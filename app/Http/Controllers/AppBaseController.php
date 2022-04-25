<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use App\Http\Controllers\Controller as LaravelController;
use Response;
use Illuminate\Http\Request;
use App\vendor_listing;
use App\User;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends LaravelController
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function get_vender(Request $request)
    {
    	$vendor = vendor_listing::latest()->get();
    	return response()->json(array('status'=>'success','vendor_data'=>$vendor),200);
    } 

    public function get_user(Request $request)
    {
    	$vendor = User::latest()->get();
    	return response()->json(array('status'=>'success','user_data'=>$vendor),200);
    } 

	public function get_user_by_id(Request $request,$id)
    {
    	$user = User::find($id);
    	return response()->json(array('status'=>'success','user_data'=>$user),200);
    } 

}
