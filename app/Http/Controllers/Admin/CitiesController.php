<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\Cities;


class CitiesController extends JoshController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function countryList(){
		   $countryList = DB::table('countries')
            ->select('countries.name','countries.id')
           ->orderBy('countries.name',"ASC")		
	
		    ->get();
			$countries[''] = 'Please select country';
			foreach($countryList as $single){
				$countries[$single->id] = $single->name;		
			}
    	
		return $countries;
	}
	public function index()
    {
        //Get all the cities
       
	    $cities = DB::table('cities')
    ->select('states.id as state_id','states.name as state_name','cities.status as status','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('states', 'cities.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'states.country_id')
	
   ->orderBy('cities.id',"DESC")		
	->paginate(10);		
	$search_keyword = $search_country = $search_status = $search_state= "";
	 
	 
	 
	  	 	$countries = $this->countryList();
		
			$states[''] = 'Please select state';
			
		$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	    
			
	    return view('admin.locations.cities.cities',compact('cities','search_keyword','search_country','search_state','countries','states','status','search_status'));
    }

    public function add() {
       
			$countries = $this->countryList();
  
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
		
	     return view('admin.locations.cities.citiesadd',compact('countries','status'));
    }

    public function delete($id) {
        DB::table('cities')->where('id', '=', $id)->delete();
        return 'success';
    }

    public function editCities($id) {


     

       $data =  Cities::where('id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }               
      
        $cities = DB::table('cities')
    ->select('states.id as state_id','countries.id as country_id','states.name as state_name','cities.status as status','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('states', 'cities.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'states.country_id')
	->where('cities.id','=',$id)
	                ->get()
                    ->toArray();
		$stateList = DB::table('states')
            ->select('states.name','states.id')
			->where('states.country_id','=',$cities[0]->country_id)
	
           ->orderBy('states.name',"ASC")		
	
		    ->get();
			$states[''] = 'Please select state';
			
			foreach($stateList as $single){
				$states[$single->id] = $single->name;		
			}
				$countries = $this->countryList();
  
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	
  
        return view('admin.locations.cities.citiesedit',compact('states','cities','countries','status'));
    }
	
	
	
	public function getStateByCountry(Request $request){
			$stateList = DB::table('states')
            ->select('states.name','states.id')
           ->where("states.country_id",$request->country)
		   ->orderBy('states.name',"ASC")		
	
		    ->get();
			
			$states = array();
			
			foreach($stateList as $single){
				$states[$single->id] = $single->name;		
		}	
		return $states;
	}
	
	
	public function getCityByState(Request $request){
			
			$citiesList = DB::table('cities')
            ->select('cities.name','cities.id')
           ->where("cities.state_id",$request->state)
		   ->orderBy('cities.name',"ASC")		
	
		    ->get();
	
			
			$cities = array();
			
			foreach($citiesList as $single){
				$cities[$single->id] = $single->name;		
		}	
		return $cities;
	}
	
	public function getSubCityByCity(Request $request){
			
			$citiesList = DB::table('sub_cities')
            ->select('sub_cities.name','sub_cities.id')
           ->where("sub_cities.city_id",$request->city)
		   ->orderBy('sub_cities.name',"ASC")		
	
		    ->get();
	
			
			$cities = array();
			
			foreach($citiesList as $single){
				$cities[$single->id] = $single->name;		
		}	
		return $cities;
	}
	
	
	
	

     public function search_cities(Request $request)
    {

      // echo "hii"; exit;
       $search_keyword = $request->get('search_keyword');
       $search_country = $request->get('search_country');
       $search_state = $request->get('search_state');
	   $search_status = $request->get('search_status');
	   
	   
	  
	    $cities = DB::table('cities')
    ->select('states.id as state_id','states.name as state_name','cities.status as status','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('states', 'cities.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'states.country_id');
	
	if($search_keyword!=""){
		$cities = $cities->where('cities.name','like','%'.$search_keyword.'%');
	}
	if($search_country>0){
		$cities = $cities->where('countries.id',$search_country);
	}
	if($search_state>0){
		$cities =$cities->where('cities.state_id',$search_state);
	}
	if($search_status!=""){
		$cities =$cities->where('cities.status',$search_status);
	}
	$cities =$cities->orderBy('cities.id',"DESC");		
	$cities =$cities->paginate(10);		
	
	$countries = $this->countryList();
	$stateList = array();
	$states[''] = 'Please select state';
			
	if($search_country>0){
		
		$stateList = DB::table('states')
            ->select('states.name','states.id')
           ->where("states.country_id",$search_country)
		   ->orderBy('states.name',"ASC")		
	
		    ->get();
	
			
			
			foreach($stateList as $single){
				$states[$single->id] = $single->name;		
		}	
	}
		$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';


       return view('admin.locations.cities..cities',compact('cities','search_keyword','search_country','search_state','search_status','countries','states','status'));
    }

    public function editPostCities(Request $request,$id) {
        
			 $checkState = Cities::where('name',$request->name)->where('state_id',$request->state)->where('country_id',$request->country)->where("id",'!=',$id)->first();
				
				if(isset($checkState->id) && $checkState->id >0){
					 return  redirect('admin/cities/edit/'.$id)->with(['error' => 'Sorry city already exists.']);
				}
		
            $state = DB::table('cities')
            ->where('id', $id)
            ->update(['name' => $_POST['name'], 'state_id' => $_POST['state'], 'country_id' => $_POST['country'], 'status' => $_POST['status']]);
           
		   
                   return redirect('admin/cities')->with(['success' => 'City has been successfully updated.']);

    }

    public function addCities(Request $request,$id="") {
		

	 $checkState = Cities::where('name',$request->name)->where('state_id',$request->state)->where('country_id',$request->country)->first();
				
				if(isset($checkState->id) && $checkState->id >0){
					 return  redirect('admin/cities/add')->with(['error' => 'Sorry city already exists.']);
				}
		
            
        
            $ids = DB::table('cities')->insertGetId(
            ['name' => $_POST['name'], 'state_id' => $_POST['state'], 'country_id' => $_POST['country'], 'status' => $_POST['status']]
            );

                   return redirect('admin/cities')->with(['success' => 'City has been successfully add.']);

    }
}


