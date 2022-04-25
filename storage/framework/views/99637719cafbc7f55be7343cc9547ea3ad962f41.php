 <div class="col-sm-5 col-md-4">
    <aside>
        
        <?php
       //echo "<pre>"; print_r($result); exit;
            $address = $result[0]->address;
        ?>

        <?php
            $check = '';
           if (Sentinel::check() && (Sentinel::inRole('admin') || Sentinel::inRole('vendor')  || Sentinel::inRole('sales-team'))) {
                $check = '1';
            } else {
                if (isset($_COOKIE['otp_lists'])) {
                    $explode = explode(',', $_COOKIE['otp_lists']);

                    if (!in_array($d->v_id, $explode)) {
                        $check = '0';
                    } else {
                        $check = '1';
                    }
                } else if (Sentinel::check() && Sentinel::inRole('vendor') && Sentinel::getUser()->id == $d->v_id ) {
                    $check = '1';
                } else {
                    $check = '0';
                }
            }
        ?>    
<?php if ($check == '1') { ?>             
<div class="sidettl">
            <h4>Location</h4>
        </div>
            <div class="map-address  map_location">
                <div class="showinfo">
                <div class="sidemap">
                    <iframe width="100%" height="380" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=<?php echo e($result[0]->l_location); ?>&amp;key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY"></iframe>
                </div>
                <div class="sidebox">
                    <table>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-map-marker"></i></td>
                                <td><?php echo e($result[0]->l_location); ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user"></i> </td>
                                 <td><?php echo $result[0]->vfname.' '.$result[0]->vlname ?></td>
                            </tr>
                            <?php if($result[0]->Phone != ''): ?>
                                <tr>
                                    <td><i class="fa fa-phone"></i> </td>
                                    <td><a href="tel:<?php echo e($result[0]->Phone); ?>"><?php echo e($result[0]->Phone); ?></a></td>
                                </tr>
                            <?php endif; ?>
                          <tr>
                            <?php $a = strtolower($result[0]->email);
                            $final = ucfirst($a); ?>
                            <td><i class="fa fa-envelope"></i> </td>
                            <td><?php echo e($final); ?></td>
                        </tr>

                            <?php if($result[0]->youtube != '' || $result[0]->facebook != ''): ?>
                            <tr>
                                <td colspan="2" class="socialicon">
                                    <?php if(isset($result[0]->facebook) && $result[0]->facebook != ''): ?>
                                        <a href="https://<?php echo e($result[0]->facebook); ?>" target="_blank"><i class="fa fa-facebook-square"></i> </a>
                                    <?php endif; ?>

                                    <?php if(isset($result[0]->youtube) && $result[0]->youtube != ''): ?>
                                        <a href="<?php echo e($result[0]->youtube); ?>" target="_blank"><i class="fa fa-youtube-square"></i> </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div></div>
            </div>
       
<?php } else { ?>
    


    
    <div class="sidettl">
        <h4>Location</h4>
    </div>
    <div class="map-address  map_location">
            <div class="showinfo">
            <div class="sidemap">
                <iframe width="100%" height="380" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q=<?php echo e($result[0]->l_location); ?>&amp;key=AIzaSyD6iL3nqzV46MTCX9wHdhHCP-CCQSmQDzY"></iframe>

 
          

            </div>
            <div class="sidebox">
                <table>
                    <tbody>
                        <tr>
                            <td><i class="fa fa-map-marker"></i></td>
                            <td><?php echo e($result[0]->l_location); ?></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-user"></i> </td>
                           <td><?php echo $result[0]->vfname.' '.$result[0]->vlname ?></td>
                        </tr>
                         <?php if($result[0]->Phone != ''): ?>
                            
                            <tr id="demo_view">
                                <td><i class="fa fa-phone"></i> </td>
                                <td><a href="tel:+91-XXXXXXXXXX">+91-XXXXXXXXXX</a></td>
                            </tr>
                        
                        <?php endif; ?>
                        <?php if($result[0]->Phone != ''): ?>
                            
                            <tr id="location_view" style="display:none;">
                                <td><i class="fa fa-phone"></i> </td>
                                <td><a href="tel:<?php echo e($result[0]->Phone); ?>"><?php echo e($result[0]->Phone); ?></a></td>
                            </tr>
                        
                        <?php endif; ?>      
                        <tr>
                            <?php $a = strtolower($result[0]->email);
                            $final = ucfirst($a); ?>
                            <td><i class="fa fa-envelope"></i> </td>
                            <td><?php echo e($final); ?></td>
                        </tr>
                        <?php if($result[0]->youtube != '' || $result[0]->facebook != ''): ?>
                        <tr>
                            <td colspan="2" class="socialicon">
                                <?php if(isset($result[0]->facebook) && $result[0]->facebook != ''): ?>
                                    <a href="https://<?php echo e($result[0]->facebook); ?>" target="_blank"><i class="fa fa-facebook-square"></i> </a>
                                <?php endif; ?>

                                <?php if(isset($result[0]->youtube) && $result[0]->youtube != ''): ?>
                                    <a href="<?php echo e($result[0]->youtube); ?>" target="_blank"><i class="fa fa-youtube-square"></i> </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
                 <div align="center">
       <a href="javascript:void();" class="commonbtn onclick" id="iam_interest"> <i class="fa fa-phone fa-lg" aria-hidden="true"> Contact Now</i></a><br><br>
    </div>
            </div>
            </div>
      </div>

<?php } ?>



          <div class="popup-overlay" style="display: none;">
            <!--Creates the popup content-->
             <div class="popup-content">
                 <button class="close">x</button>
                <form id="otp_form" method="post" class="formdesign1">
                    <div class="formheader">
                        <label class="otpmailsent" style="display: none;">Mail Sent! Please check your mail box.</label>
                        <div class="fromgroup email_overright"> <input type="email" name="otpemail" id="otpemail" value="" placeholder="Enter Email To Get OTP">
                   </div><div class="fromgroup"> <input type="hidden" name="listing_id" value="<?php echo e($result[0]->vl_id); ?>" id="listing_id">
                  </div> <div class="fromgroup"> <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        </div></div>
                    <div class="formfooter">
                    <input type="submit" name="submit" id="otp_sub"></div>

                </form>
            </div>
            </div>

             <div class="alert alert-success alert-dismissible" style="display:none">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong id="success"></strong>
                </div>

           
                


            <h4 id="owner">Owner Detail</h4>
            <div class="hostbox" >
                <div class="map-address sidebox">
                    <div class="hostbanner">
                        <div class="hostperson">
                            <?php if(!$result[0]->logo == ""): ?>
                            <img src="../public/images/logo/<?php echo e($result[0]->vl_id); ?>/<?php echo e($result[0]->logo); ?>" alt="logo">
                            <?php else: ?>
                             <img src="<?php echo e(url('/')); ?>/public/images/noimage.png" width="100px;" alt="noimage"> 
                             <?php endif; ?>
                        </div>
                    </div>
                    <table>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-user"></i> </td>
                                <td><?php echo $result[0]->vfname.' '.$result[0]->vlname ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-building-o"></i> </td>
                                <td><?php echo $result[0]->c_name ?></td>
                            </tr>
                            <tr>
                                <?php $a = strtolower($result[0]->u_email);
                                $final = ucfirst($a); ?>
                                <td><i class="fa fa-envelope"></i> </td>
                                <td><?php echo e($final); ?></td>
                            </tr>
                            <?php if($result[0]->web_site): ?>
                                <tr>
                                    <td><i class="fa fa-globe"></i> </td>
                                    <?php if(strpos($result[0]->web_site, "http://")): ?>
                                        <td><a href="<?php echo e($result[0]->web_site); ?>" target="_blank"><?php echo e($result[0]->web_site); ?></a></td>
                                    <?php else: ?>
                                        <td><a href="http://<?php echo e($result[0]->web_site); ?>" target="_blank"><?php echo e($result[0]->web_site); ?></a></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- <div class="more_information active_hide">  </div>-->
                        <?php if($result[0]->achievements != ''): ?>
                        <div class="achievements">
                            <h3>Achievements</h3>
                            <?php $explode = explode('<br />', nl2br($result[0]->achievements)); ?>
                            <?php
                                foreach ($explode as $key => $value) {
                                    if (trim($value) != ''){
                                        echo trim($value).'<br>';
                                    }
                                }
                            ?>
                        </div>
                        <?php endif; ?>

                        <?php if($result[0]->past_projects != ''): ?>
                        <div class="past_project">
                            <h3>Past Projects</h3>
                            <?php $explode = explode('<br />', nl2br($result[0]->past_projects)); ?>
                            <?php
                                foreach ($explode as $key => $value) {
                                    if (trim($value) != ''){
                                        echo trim($value).'<br>';
                                    }
                                }
                            ?>
                        </div>
                        <?php endif; ?>

                        <?php if($result[0]->current_project != ''): ?>
                        <div class="current_project">
                            <h3>Current Project</h3>
                            <?php $explode = explode('<br />', nl2br($result[0]->current_project)); ?>
                            <?php
                                foreach ($explode as $key => $value) {
                                    if (trim($value) != ''){
                                        echo trim($value).'<br>';
                                    }
                                }
                            ?>
                        </div>
                        <?php endif; ?>
                    <!-- <div class="viewprofile btn1">
                        <a>Read More</a>
                    </div> -->
                </div>
            </div>

            <?php $week = array(
                '1' => 'Monday',
                '2' => 'Tuesday',
                '3' => 'Wednesday',
                '4' => 'Thursday',
                '5' => 'Friday',
                '6' => 'Saturday',
                '7' => 'Sunday');

                $hrs = explode(',',$result[0]->working_hr);
            ?>
            <div class="hostbox" id="owner">
                <h4>Working hours</h4>
                <div class="hours sidebox">
                    <span><i class="fa fa-clock-o"></i> Now Open</span>
                    <table>
                        <tbody>

                            <?php
                                for ($i=1; $i < 8; $i++) { ?>
                                    <?php
                                        $time = 'Close';
                                        if (in_array($i, $hrs)) {
                                            $time = $result[0]->working_time;
                                        }
                                    ?>

                                    <tr>
                                        <td><?php echo $week[$i] ?></td>
                                        <td><?php echo $time ?></td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </aside>
</div>
<div id="mySidenav" class="sidenav">
   <?php if($result[0]->l_category == '1'): ?>  
  <span id="about"><b>Book A Visit</b></span>
  <?php else: ?>
  <span id="about"><b>Inquire Now</b></span>
  <?php endif; ?>
  <div class="fm">
    <div class="book-form sidebox bvisit">
        <form class="formdesign1" method="post" id="bookvisit_info">
                         <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="formheader">
                            <div class="fromgroup">
                                <i class="fa fa-user"></i>
                                <input placeholder="Name" type="text" name="f_name" value="" id="f_name" >
                            </div>
                            <div class="fromgroup">
                                <i class="fa fa-envelope-o"></i>
                                <input placeholder="Email" type="text" name="iemail" value="" id="iemail">
                            </div>
                            <div class="fromgroup">
                                <i class="fa fa-phone"></i>
                                <input placeholder="Phone number" type="number" name="inumber" value="" id="inumber" >
                            </div>
                            <?php if($result[0]->l_category == '1'): ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="fromgroup"><i class="fa fa-calendar-o"></i>
                                        <input placeholder="Date" type="date" id="idate" name="idate" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fromgroup"><i class="fa fa-calendar-o"></i>
                                        <input placeholder="Time" type="text" id="itime" name="itime" value="">
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="fromgroup">
                                <textarea placeholder="Additional Information" name="icomment" id="icomment"> </textarea>
                            </div>
                        </div>

                        <input type="hidden" name="uemail" id="uemail" value="<?php echo e($result[0]->email); ?>">
                        <input type="hidden" name="u_id" id="u_id" value="<?php echo e($result[0]->u_id); ?>">
                        <input type="hidden" name="hvl_id" id="hvl_id" value="<?php echo e($result[0]->vl_id); ?>">
                       
                        <div class="formfooter">
                            <input type="submit" name="submit" id="isubmit">
                        </div>
                    </form>
    </div>
  </div>
</div>

<script src="<?php echo e(asset('public/assets/js/jquery.validate.min.js')); ?>"></script>
<script>

jQuery(document).ready(function () {

    jQuery("#add_review").on('click',function() {
        jQuery("#addreview").css('display','block');
        jQuery('html, body').animate({
            scrollTop: jQuery("#addreview").offset().top
        }, 2000);
    });

    jQuery("#viewlocation").on('click',function() {
        jQuery(".popup-overlay").css('display','block');
        jQuery('html, body').animate({
            scrollTop: jQuery(".popup-overlay").offset().top
        }, 2000);
    });

    jQuery('#otp_form').validate({
        rules: {
            otpemail: {
                required: true,
                email: true
            }
        },
        highlight: function (element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        success: function (element) {
            element.text('OK!').addClass('valid')
                .closest('.control-group').removeClass('error').addClass('success');
        }
    });

    jQuery("#close").on('click',function() {
        jQuery("#addreview").css('display','none');
    });
    
var cnt=0;
jQuery('#about').on('click',function() {

        $('#bookvisit_info')[0].reset();
     
        if(jQuery('.fm').hasClass('open')){
            jQuery('.fm').removeClass('open');
        }else{
            jQuery('.fm').addClass('open');
            cnt=1;
        }
    });

 // jQuery("body").on('click',function() {
 //    if(cnt==0){
 //        if(jQuery('.fm').hasClass('open')){
 //            jQuery('.fm').removeClass('open');
 //        }
 //    }
 //        cnt=0;        
 //    });
 // jQuery('#isubmit').on('click',function() {

 //        if(cnt==0){
 //            jQuery('.fm').addClass('open');
 //        }
        
 //    });
    jQuery(".viewprofile").on('click',function() {
        if (jQuery(".more_information").hasClass("active_show")) {
            jQuery(".more_information").removeClass('active_show').addClass('active_hide');
            jQuery(".viewprofile a").html('');
            jQuery(".viewprofile a").html('Read More');
        } else {
            jQuery(".more_information").removeClass('active_hide').addClass('active_show');
            jQuery(".viewprofile a").html('');
            jQuery(".viewprofile a").html('Less Info');
        }
    });

    jQuery(".close").on('click',function() {
        jQuery(".popup-overlay").css('display','none');
    });

    jQuery("#otp_form").submit(function(e) {
        e.preventDefault();

        var otpval = jQuery("#otpvalue").val();
        var lemail = jQuery("#otpemail").val();
        var lid = jQuery("#listing_id").val();

        if (otpval == '') {
            jQuery(".otpmailsent").removeClass("valid");
            jQuery(".otpmailsent").css('display','block');
            jQuery(".otpmailsent").html('');
            jQuery(".otpmailsent").html('Field is required.').addClass('error');
        }

        if (typeof(otpval) != "undefined" && otpval !== '') {
            jQuery.ajax({
                type: "GET",
                url: '/otpverified/{otpval}/{lid}',
                data: {'otpval' : otpval,'lid' : lid},
            }).done(function( msg ) {
                if (msg == 'success') {
                    jQuery(".otpmailsent").css('display','none');
                    jQuery(".showinfo").removeClass("nodisplay");
                    jQuery(".popup-overlay").css('display','none');
                    jQuery("#viewlocation").css('display','none');
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".showinfo").offset().top
                    }, 2000);
                } else {
                    jQuery(".otpmailsent").removeClass("valid");
                    jQuery(".otpmailsent").css('display','block');
                    jQuery(".otpmailsent").html('');
                    jQuery(".otpmailsent").html(msg);
                }
            });
        }

        if (typeof(lemail) != "undefined" && lemail !== null) {

            jQuery.ajax({
                type: "GET",
                url: '/otp/{lemail}/{lid}',
                data: {'lemail' : lemail,'lid' : lid},
            }).done(function( msg ) {
                if (msg == 'success') {
                    jQuery(".otpmailsent").css('display','block').addClass('error valid');
                    jQuery(".formheader .email_overright").html('');
                    jQuery(".formheader .email_overright").html('<input type="text" name="otpvalue" id="otpvalue" value="" placeholder="Enter OTP">');
                }
            });
        }


    });

    var stickyTop = jQuery('.tab-menu').offset().top;
    //var stickyTop = jQuery(window).scrollTop();

    jQuery(window).on( 'scroll', function(){
        //console.log(jQuery(window).scrollTop());
        if (jQuery(window).scrollTop() >= 500) {
            jQuery('.tab-menu').addClass('sticky-tab');
        } else {
            jQuery('.tab-menu').removeClass('sticky-tab');
        }
    });

});
</script>
<script src="<?php echo e(url('/')); ?>/public/js/jquery.copy-to-clipboard.js"></script>
<script>
 $('.rera_text').click(function(){
        $(this).CopyToClipboard();
    });
  
</script>
<script>
$(document).ready(function () {
    $('#bookvisit_info').validate({
        rules: {
            f_name: {
                required: true
            },
            inumber: {
                required: true,
            },
            itime: {
                required: true,
            },
            idate: {
                required: true,
            },
            icomment: {
                required: true,
            },
        },
        messages:{
            f_name:{
                required:"Enter your name",
            },
            inumber:{
                required:"Enter your mobile number",
            },
            itime:{
                required:"Time is required",
            },
            idate:{
                required:"Date is required",
            },
            icomment:{
                required:"Enter your message",
            },        
        },
    });
});
$('#iam_interest').on('click',function() {
$('#properties_otp').modal('show');
 $('.firstBlur').addClass('modalBlur');
});


$('.close_this').on('click',function() {
$('#properties_otp').modal('hide');
 $('.firstBlur').removeClass('modalBlur');
});
</script>
