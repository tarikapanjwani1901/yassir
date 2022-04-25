 <?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

Class QuickQuoteController extends Controller
{
    public function view() {

    	//Get the category listing
    	$category = DB::table('category')->get()->toArray();

    	//Get category_type_properties
    	$category_properties = DB::table('category_type_properties')->get()->toArray();

    	return view('quickquote')->with('category',$category)->with('category_properties',$category_properties);
    }

    public function sendMail(Request $request) {

    	//Get the category listing
    	$category = DB::table('category')->get()->toArray();

    	//Get category_type_properties
    	$category_properties = DB::table('category_type_properties')->get()->toArray();

    	//Get category name
    	$subName = $this->getCateName($request->cate,$request->sub_cate);

        //Send mail
        $to = "support@yassir.in";
        $subject = "New Quotation Request";
        $txt = "Hi,". "<br><br>";
        $txt .= ucfirst($request->fullname)." has requested for quotation.". "<br><br>";
        $txt .= "Email: ".$request->email. "\r\n";
        $txt .= "Phone: ".$request->phone. "<br>";
        $txt .= "Category: ".$this->category($request->cate). "<br>";
        $txt .= "Sub Category: ".$subName. "<br>";
        $txt .= "Comment: ".$request->comment. "<br>";
        $txt .= "Thanks!";
        $headers = "From: support@yassir.in" . "<br>";

        //Send mail to user
        $to1 = $_POST['email'];
        $subject1 = "Thank you for contacting us";
        $txt1 = "We have received your enquiry and will respond to you within 24 hours. For urgent enquiries please call us on 7575081000.
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
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to,$subject,$txt,$headers);
        mail($to1,$subject1,$txt1,$headers);
        mail('support@yassir.in',$subject1,$txt1,$headers);

    	return view('quickquote')->with('success','success')->with('category',$category)->with('category_properties',$category_properties);
    }

    public function getCateName($cat,$sub) {

		switch ($cat) {
		    case '1':
		        $table = 'category_type_properties';
		        break;
		    case '2':
		        $table = 'category_type_consultancy';
		        break;
		    case '3':
		        $table = 'category_type_contractor';
		        break;
		   	case '4':
		        $table = 'category_type_material';
		        break;
            case '5':
                $table = 'category_type_skill_labour';
                break;    
		}

		$cateName = DB::table($table)->where('id', $sub)->get()->toArray();

		return $cateName[0]->name;
    }

    public function category($key) {
    	$array = array(
    		'1' => 'Properties',
    		'2' => 'Consultancy',
    		'3' => 'Contractor',
    		'4' => 'Material'
            '5' => 'Skill labour'
    	);

    	return $array[$key];
    }

}
