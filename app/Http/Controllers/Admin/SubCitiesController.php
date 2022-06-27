<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\Models\SubCity;

class SubCitiesController extends JoshController
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
       
	    $sub_cities = DB::table('sub_cities')
    ->select('sub_cities.id as sub_city_id','sub_cities.name as sub_city_name','sub_cities.status as status','states.id as state_id','states.name as state_name','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('cities', 'cities.id', '=', 'sub_cities.city_id')
	->join('states', 'cities.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'states.country_id')
	
   ->orderBy('sub_cities.id',"DESC")		
	->paginate(10);		
	$search_keyword = $search_country = $search_state=$search_city = $search_status="";
	 
	 
	  	 	$countries = $this->countryList();
		
			$states[''] = 'Please select state';
			$cities[''] = 'Please select city';
			
		$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	    
			
	    return view('admin.locations.sub_cities.sub_cities',compact('sub_cities','cities','search_keyword','search_country','search_state','search_city','search_status','countries','states','status'));
    }

    public function add() {
       
			$countries = $this->countryList();
  
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
		
	     return view('admin.locations.sub_cities.sub_citiesadd',compact('countries','status'));
    }

    public function delete($id) {
        DB::table('sub_cities')->where('id', '=', $id)->delete();
        return 'success';
    }

    public function editSubCities($id) 
	{
       $data =  SubCity ::where('id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }               
      
        $sub_cities = DB::table('sub_cities')
    ->select('sub_cities.name as sub_city_name','sub_cities.id as city_id','sub_cities.status as status','states.id as state_id','countries.id as country_id','states.name as state_name','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('cities', 'cities.id', '=', 'sub_cities.city_id')
	->join('states', 'cities.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'states.country_id')
	->where('sub_cities.id','=',$id)
	                ->get()
                    ->toArray();
					
					
		$stateList = DB::table('states')
            ->select('states.name','states.id')
			->where('states.country_id','=',$sub_cities[0]->country_id)
	
           ->orderBy('states.name',"ASC")		
	
		    ->get();
			$states[''] = 'Please select state';
			
			foreach($stateList as $single){
				$states[$single->id] = $single->name;		
			}
			
					
		$citiesList = DB::table('cities')
            ->select('cities.name','cities.id')
			->where('cities.state_id','=',$sub_cities[0]->state_id)
	
           ->orderBy('cities.name',"ASC")		
	
		    ->get();
			$cities[''] = 'Please select city';
			
			foreach($citiesList as $single){
				$cities[$single->id] = $single->name;		
			}
			
				$countries = $this->countryList();
  
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	
  
        return view('admin.locations.sub_cities.sub_citiesedit',compact('cities','states','sub_cities','countries','status'));
    }
	
	

     public function search_sub_cities(Request $request)
    {

      // echo "hii"; exit;
       $search_keyword = $request->get('search_keyword');
       $search_country = $request->get('search_country');
       $search_state = $request->get('search_state');
       $search_city = $request->get('search_city');
	   $search_status= $request->get('search_status');
	   
	  
	
	    $sub_cities = DB::table('sub_cities')
    ->select('sub_cities.id as sub_city_id','sub_cities.name as sub_city_name','sub_cities.status as status','states.id as state_id','states.name as state_name','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('cities', 'cities.id', '=', 'sub_cities.city_id')
	->join('states', 'cities.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'states.country_id');
	
	if($search_keyword!=""){
		$sub_cities = $sub_cities->where('cities.name','like','%'.$search_keyword.'%');
	}
	if($search_country>0){
		$sub_cities = $sub_cities->where('countries.id',$search_country);
	}
	if($search_state>0){
		$sub_cities =$sub_cities->where('cities.state_id',$search_state);
	}
	if($search_city>0){
		$sub_cities =$sub_cities->where('sub_cities.city_id',$search_city);
	}
	if($search_status!=""){
		$sub_cities =$sub_cities->where('sub_cities.status',$search_status);
	}
	$sub_cities =$sub_cities->orderBy('cities.id',"DESC");		
	$sub_cities =$sub_cities->paginate(10);		
	
	$countries = $this->countryList();
	$stateList = array();
	$states[''] = 'Please select state';
	$cities[''] = 'Please select city';;
			
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
	
	if($search_country>0 && $search_state>0){
		
		$citiesList = DB::table('cities')
            ->select('cities.name','cities.id')
           ->where("cities.state_id",$search_state)
		   ->orderBy('cities.name',"ASC")		
	
		    ->get();
	
			
			
			foreach($citiesList as $single){
				$cities[$single->id] = $single->name;		
		}	
	}
	$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';

	

       return view('admin.locations.sub_cities.sub_cities',compact('sub_cities','search_keyword','search_country','search_state','search_city','search_status','status','countries','states','cities'));
    }

    public function editPostSubCities(Request $request,$id) {
        
			 $checkState = SubCity::where('name',$request->name)->where('state_id',$request->state)->where('city_id',$request->city)->where('country_id',$request->country)->where("id",'!=',$id)->first();
				
				if(isset($checkState->id) && $checkState->id >0){
					 return  redirect('admin/sub_cities/edit/'.$id)->with(['error' => 'Sorry sub city already exists.']);
				}
		
            $state = DB::table('sub_cities')
            ->where('id', $id)
            ->update(['name' => $_POST['name'], 'city_id' => $_POST['city'], 'state_id' => $_POST['state'], 'country_id' => $_POST['country'], 'status' => $_POST['status']]);
           
		   
                   return redirect('admin/sub_cities')->with(['success' => 'Sub city has been successfully updated.']);

    }

    public function addSubCities(Request $request,$id="") {
		

	 $checkState = SubCity::where('name',$request->name)->where('state_id',$request->state)->where('country_id',$request->country)->where('city_id',$request->city)->first();
				
				if(isset($checkState->id) && $checkState->id >0){
					 return  redirect('admin/sub_cities/add')->with(['error' => 'Sorry sub city already exists.']);
				}
		
            
        
            $ids = DB::table('sub_cities')->insertGetId(
            ['name' => $_POST['name'], 'state_id' => $_POST['state'], 'country_id' => $_POST['country'], 'city_id' => $_POST['city'], 'status' => $_POST['status']]
            );

                   return redirect('admin/sub_cities')->with(['success' => 'Sub city has been successfully add.']);

    }
}


