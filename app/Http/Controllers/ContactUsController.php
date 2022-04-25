<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
Class ContactUsController extends Controller
{
    

     public function __construct()
    {
       
       
        $contact = DB::table('contact_detail')->get();
        $property_list = DB::table('property_listing')->get();
        $product_list = DB::table('product_listing')->get(); 
        $popular_list = DB::table('popular_categories')->get();
        $setting = DB::table('general_setting')->get();

        \View::share('property_list',$property_list);
        \View::share('product_list',$product_list);
        \View::share('popular_list',$popular_list);
        \View::share('setting',$setting);
        \View::share('contact',$contact);
    }


    public function view() {
       
    	return view('contactus');
    }

    public function sendMail(Request $request) {

        //Send mail to support
        $to = "support@yassir.in";
        $subject = "New Inquiry";
        $txt = "Hi,". "<br><br>";
        $txt .= ucfirst($request->fname)." has query. Please reach out to with below information.". "<br><br>";
        $txt .= "Email: ".$request->email. "\r\n";
        $txt .= "Phone: ".$request->phone. "<br>";
        $txt .= "Comment: ".$request->comment. "<br><br>";
        $txt .= "Thanks!";
        $headers = "From: support@yassir.in" . "\r\n";
        $to1 = $_POST['email'];
        $subject1 = "Thank you for contacting us";
        $txt1 = "We have received your enquiry and will respond to you within 24 hours.  For urgent enquiries please call us on <b>7575081000</b>.
                    ". "<br><br>";
        $txt1 .="Thanks & Regards"."<br><br>";
        $txt1 .='<table align="left" cellpadding="0" cellspacing="0" style="max-width:450px; width:100%;">
                            <tbody style="border:0;">
                                <tr>
                                <td width="150px" valign="top"><img src="http://yassir.in/public/assets/images/yassir_small.png" style="width:150px;"></td>
                                    <td style="padding:0 15px 10px 15px; color:#666; font-weight: blod; border:0"  valign="top">
                                <table cellpadding="0"  valign="top" cellspacing="0" style="max-width:450px; width:100%; border:0">
                                    <tbody style="border:0;">
                                        <tr>
                                        <td  style="color:#888; font-family: Arial, Helvetica, sans-serif; border:0; font-size: 14px; font-weight:bold; font-style: italic">
                                    YasSir
                                    </td>
                                 </tr>
                                <tr>
                                <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">7575081000  <span style="color:#f00; display: inline-block">|</span> </td>
                                </tr>
                                <tr>
                                <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">Golden arcade, SF, 07, GIDC Electronic<br>Estate, Sector 25, Gandhinagar, Gujarat  </td>
                            </tr>
                            <tr>
                            <td style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">
                              382027 <span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="mailto:info@yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">info@yassir.in </a><span style="color:#f00; display: inline-block; margin:0 3px;">|</span><a href="http://www.yassir.in" style="color:#888; border:0; font-size: 14px;  font-family: Arial, Helvetica, sans-serif; font-weight:bold;">www.yassir.in </a>  </td>
                          </tr>
                          <tr>
                            <td style="padding: 8px 0 0 0;">
                              <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/fb-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/twt-icon.png" style="width:20px;"></a>
                                  <a href="#" style="display: inline-block; margin: 3px 3px 3px 0;"><img src="http://www.yassir.in/public/assets/images/insta-icon.png" style="width:20px;"></a>

                              </td>
                          </tr>

                            </tbody>
                        </table>

                    </td>
                </tr>
                </tbody>
                </table>';
        $headers = "From: YasSir <support@yassir.in>" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        mail($to,$subject,$txt,$headers);
        mail($to1,$subject1,$txt1,$headers);
        //mail('support@yassir.in',$subject1,$txt1,$headers);
    	return back()->with('contact_msgs','Thank you for contacting us. We have received your enquiry and will respond to you within 24 hours!');
    }
}
