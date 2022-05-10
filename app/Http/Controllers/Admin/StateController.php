<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\JoshController;
use Illuminate\Http\Request;
use Auth;
use DB;
use Image;
use App\state;

class StateController extends JoshController
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
        //Get all the state
       
	    $state = DB::table('states')
    ->select('states.id as state_id','states.name as state_name','states.status as status','countries.name as country_name')
    ->join('countries', 'states.country_id', '=', 'countries.id')
	->orderBy('states.id',"DESC")		
	->paginate(10);		
	  	$countries = $this->countryList();
		$search_keyword = $search_country = $search_status = "";
		
		
		$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	    return view('admin.locations.states.state',compact('state','countries','search_keyword','search_country','search_status','status'));
    }

    public function add() {
       
	   
	   $countryList = DB::table('countries')
            ->select('countries.name','countries.id')
           ->orderBy('countries.name',"ASC")		
	
		    ->get();
			$countries[''] = 'Please select country';
			foreach($countryList as $single){
				$countries[$single->id] = $single->name;		
			}
        
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
		
	     return view('admin.locations.states.stateadd',compact('countries','status'));
    }

    public function delete($id) {
        DB::table('states')->where('id', '=', $id)->delete();
        return 'success';
    }

    public function editState($id) {


     

       $data =  State::where('id',$id)->firstOrFail();
  
       if($data == null)
       {
        return abort(404);
       }               
      
      $state = DB::table('states')
                    ->where('id','=',$id)
                    ->get()
                    ->toArray();
	$countryList = DB::table('countries')
            ->select('countries.name','countries.id')
           ->orderBy('countries.name',"ASC")		
	
		    ->get();
			$countries[''] = 'Please select country';
			
			foreach($countryList as $single){
				$countries[$single->id] = $single->name;		
			}


		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';
	return view('admin.locations.states.stateedit',compact('countries','state','status'));
	
		
    }

     public function state_search(Request $request)
    {

      // echo "hii"; exit;
       
	   $search_keyword = $request->get('search_keyword');
       $search_country = $request->get('search_country');
	   $search_status = $request->get('search_status');
	   
     
	  
	    $state = DB::table('states')
    ->select('states.id as state_id','states.name as state_name','states.status as status','countries.name as country_name')
    ->join('countries', 'states.country_id', '=', 'countries.id');
	  $state =  $state->where('states.name','like','%'.$search_keyword.'%');
      
	  if($search_country>0){
	  	$state =  $state->where('countries.id',$search_country);
	  }
	   
	  if($search_status!=""){
	  	$state =  $state->where('states.status',$search_status);
	  }
	$state =  $state->orderBy('states.id',"DESC");		
	$state =  $state->paginate(10);		

		$countries = $this->countryList();
		
		$status[''] = 'All';
		$status['Active'] = 'Active';
		$status['Deactive'] = 'Deactive';


       return view('admin.locations.states.state',compact('search_keyword','search_country','search_status','countries','state','status'));
       // return view('admin/state',compact('state',$state));
    }

    public function editPostState(Request $request,$id) {
        
			 $checkState = State::where('name',$request->name)->where('country_id',$request->country)->where("id",'!=',$id)->first();
				
				if(isset($checkState->id) && $checkState->id >0){
					 return  redirect('admin/state/edit/'.$id)->with(['error' => 'Sorry state already exists.']);
				}
		
            $state = DB::table('states')
            ->where('id', $id)
            ->update(['name' => $_POST['name'], 'country_id' => $_POST['country'], 'status' => $_POST['status']]);
           
		   
                   return redirect('admin/state')->with(['success' => 'State has been successfully updated.']);

    }

    public function addState(Request $request,$id="") {

	 $checkState = State::where('name',$request->name)->where('country_id',$request->country)->first();
				
				if(isset($checkState->id) && $checkState->id >0){
					 return  redirect('admin/state/add')->with(['error' => 'Sorry state already exists.']);
				}
		
            
        
            $ids = DB::table('states')->insertGetId(
            ['name' => $_POST['name'], 'country_id' => $_POST['country'], 'status' => $_POST['status']]
            );

                   return redirect('admin/state')->with(['success' => 'State has been successfully add.']);

    }
}


