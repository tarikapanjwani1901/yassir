<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\Areas;



class AreasController extends JoshController
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
       
	    $areas = DB::table('areas')
    ->select('sub_cities.id as sub_city_id','sub_cities.name as sub_city_name','areas.id as area_id','areas.name as area_name','areas.pincode as area_pincode','areas.status as status','states.id as state_id','states.name as state_name','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('sub_cities', 'sub_cities.id', '=', 'areas.sub_city_id')
	->join('cities', 'cities.id', '=', 'areas.city_id')
	->join('states', 'areas.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'areas.country_id')
	
   ->orderBy('areas.id',"DESC")		
	->paginate(10);		
	$search_keyword=$search_pincode = $search_country = $search_state=$search_city =$search_sub_city =$search_pincode  = $search_status="";
	 
	 
	  	 	$countries = $this->countryList();
		
			$states[''] = 'Please select state';
			$cities[''] = 'Please select city';
			$sub_cities[''] = 'Please select sub city';
			
		$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	    
			
	    return view('admin.locations.areas.areas',compact('areas','cities','sub_cities','search_keyword','search_pincode','search_sub_city','search_country','search_state','search_city','search_status','countries','states','status'));
    }

    public function add() {
       
			$countries = $this->countryList();
  
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
		
	     return view('admin.locations.areas.areasadd',compact('countries','status'));
    }

    public function delete($id) {
        DB::table('areas')->where('id', '=', $id)->delete();
        return 'success';
    }

    public function editAreas($id) {


     
	 

       $data =  Areas::where('id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }               
      
        $areas = DB::table('areas')
    ->select('sub_cities.id as sub_city_id','sub_cities.name as sub_city_name','areas.id as area_id','areas.name as area_name','areas.pincode as area_pincode',
	'areas.status as status','states.id as state_id','states.name as state_name','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('sub_cities', 'sub_cities.id', '=', 'areas.sub_city_id')
	->join('cities', 'cities.id', '=', 'areas.city_id')
	->join('states', 'areas.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'areas.country_id')
	->where('areas.id','=',$id)
	                ->get()
                    ->toArray();
	
	
					
		$stateList = DB::table('states')
            ->select('states.name','states.id')
			->where('states.country_id','=',$areas[0]->country_id)
	
           ->orderBy('states.name',"ASC")		
	
		    ->get();
			$states[''] = 'Please select state';
			
			foreach($stateList as $single){
				$states[$single->id] = $single->name;		
			}
			
					
		$citiesList = DB::table('cities')
            ->select('cities.name','cities.id')
			->where('cities.state_id','=',$areas[0]->state_id)
	
           ->orderBy('cities.name',"ASC")		
	
		    ->get();
			$cities[''] = 'Please select city';
			
			foreach($citiesList as $single){
				$cities[$single->id] = $single->name;		
			}
			
			$subcitiesList = DB::table('sub_cities')
            ->select('sub_cities.name','sub_cities.id')
			->where('sub_cities.city_id','=',$areas[0]->city_id)
	
           ->orderBy('sub_cities.name',"ASC")		
	
		    ->get();
			$sub_cities[''] = 'Please select sub city';
			
			foreach($subcitiesList as $single){
				$sub_cities[$single->id] = $single->name;		
			}
			
				$countries = $this->countryList();
  
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
 
        return view('admin.locations.areas.areasedit',compact('cities','states','sub_cities','areas','countries','status'));
    }
	
	

     public function search_areas(Request $request)
    {

      // echo "hii"; exit;
       $search_keyword = $request->get('search_keyword');
	   $search_pincode = $request->get('search_pincode');
       $search_country = $request->get('search_country');
       $search_state = $request->get('search_state');
       $search_city = $request->get('search_city');
	   $search_sub_city = $request->get('search_sub_city');
	   $search_status= $request->get('search_status');
	   
	  
	
	       $areas = DB::table('areas')
    ->select('sub_cities.id as sub_city_id','sub_cities.name as sub_city_name','areas.id as area_id','areas.name as area_name','areas.pincode as area_pincode','areas.status as status','states.id as state_id','states.name as state_name','cities.name as city_name','cities.id as city_id','countries.name as country_name','countries.id as country_id')
    ->join('sub_cities', 'sub_cities.id', '=', 'areas.sub_city_id')
	->join('cities', 'cities.id', '=', 'areas.city_id')
	->join('states', 'areas.state_id', '=', 'states.id')
	->join('countries', 'countries.id', '=', 'areas.country_id');

	
	if($search_keyword!=""){
		$areas = $areas->where('areas.name','like','%'.$search_keyword.'%');
	}
		if($search_pincode!=""){
		$areas = $areas->where('areas.pincode','like','%'.$search_pincode.'%');
	}
	if($search_country>0){
		$areas = $areas->where('countries.id',$search_country);
	}
	if($search_state>0){
		$areas =$areas->where('cities.state_id',$search_state);
	}
	if($search_city>0){
		$areas =$areas->where('sub_cities.city_id',$search_city);
	}
	if($search_sub_city>0){
		$areas =$areas->where('areas.sub_city_id',$search_sub_city);
	}
	if($search_status!=""){
		$areas =$areas->where('areas.status',$search_status);
	}
	$areas =$areas->orderBy('areas.id',"DESC");		
	$areas =$areas->paginate(10);		
	
	$countries = $this->countryList();
	$stateList = array();
	$states[''] = 'Please select state';
	$cities[''] = 'Please select city';;
	$sub_cities[''] = 'Please select sub city';
			
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
	
	if($search_country>0 && $search_state>0 && $search_city>0){
		
		$subcitiesList = DB::table('sub_cities')
            ->select('sub_cities.name','sub_cities.id')
           ->where("sub_cities.city_id",$search_city)
		   ->orderBy('sub_cities.name',"ASC")		
	
		    ->get();
	
			
			
			foreach($subcitiesList as $single){
				$sub_cities[$single->id] = $single->name;		
		}	
	}
	$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';

	

       return view('admin.locations.areas.areas',compact('areas','sub_cities','search_keyword','search_pincode','search_sub_city','search_country','search_state','search_city','search_status','status','countries','states','cities'));
    }

    public function editPostAreas(Request $request,$id) {
        
			 $checkAreas = Areas::where('pincode',$request->pincode)->where('state_id',$request->state)->where('sub_city_id',$request->sub_city)->where('city_id',$request->city)->where('country_id',$request->country)->where("id",'!=',$id)->first();
				
				if(isset($checkAreas->id) && $checkAreas->id >0){
					 return  redirect('admin/areas/edit/'.$id)->with(['error' => 'Sorry Areas already exists.']);
				}
		
            $state = DB::table('areas')
            ->where('id', $id)
            ->update(['name' => $_POST['name'],'pincode' => $_POST['pincode'], 'city_id' => $_POST['city'], 'state_id' => $_POST['state'], 'country_id' => $_POST['country'], 'sub_city_id' => $_POST['sub_city'], 'status' => $_POST['status']]);
           
		   
                   return redirect('admin/areas')->with(['success' => 'Areas has been successfully updated.']);

    }

    public function addAreas(Request $request,$id="") {
		

	 $checkAreas = Areas::where('state_id',$request->state)->where('country_id',$request->country)->where('city_id',$request->city)->where('pincode',$request->pincode)->where('sub_city_id',$request->sub_city)->first();
				
				if(isset($checkAreas->id) && $checkAreas->id >0){
					 return  redirect('admin/areas/add')->with(['error' => 'Sorry Area already exists.']);
				}
		
            
        
            $ids = DB::table('areas')->insertGetId(
            ['name' => $_POST['name'],'pincode' => $_POST['pincode'], 'state_id' => $_POST['state'], 'country_id' => $_POST['country'], 'city_id' => $_POST['city'], 'sub_city_id' => $_POST['sub_city'], 'status' => $_POST['status']]
            );

                   return redirect('admin/areas')->with(['success' => 'Area has been successfully add.']);

    }
}


