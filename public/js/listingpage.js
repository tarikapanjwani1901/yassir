$(document).ready(function(){
 $('.user').blur(function(){
  var error_email = '';
  var email = $('.user').val();
  var _token = $('input[name="_token"]').val();
   $.ajax({
    url:"{{url('/')}}/check_phone",
    method:"POST",
    data:{phone:email, _token:_token},
    success:function(result)
    {
     if(result == 'not_unique')
     {
      $('#error_user').html('<label class="text-danger">This Mobile number is alredy registered</label>');
      $('.user').removeClass('has-error');
      $('#submits').attr('disabled', 'disabled');
     }
     else
     {
      $('#error_user').html('');
       $('#submits').attr('disabled', false);
     }
    }
   })
 });
});

    $(".shop").on('click', function() {
      var id = $(this).attr("id");
      $(this).parent().parent().parent().find('.shop_sqyrd').css('display','block');
      $(this).parent().parent().parent().find('.3bhk').css('display','none');
      $(this).parent().parent().parent().find('.2bhk').css('display','none');
      var a = $(this).parent().parent().parent().find(".hdnvalue").val();
      $(this).parent().parent().parent().find('.shop_info').css('display','block');
      $(this).parent().parent().parent().find('.www').css('display','none');
      var price = $(this).data("shop_price");
      var area = $(this).data("shop_area");
      var washroom = $(this).data("shop_washroom");
      var car = $(this).data("shop_car_parking");
      var floor = $(this).data("shop_floor");

      if(id == a){
      $(this).parent().parent().parent().find('.shop_area').text(area);
      $(this).parent().parent().parent().find('.shop_price').text(price);
      $(this).parent().parent().parent().find('.shop_floor').text(floor);
      $(this).parent().parent().parent().find('.shop_car').text(car);
      }
      });

    jQuery(document).ready(function(){

      $('.shop_info').css('display','none');
         //BHK Click
      $(".bhk_class").on('click', function() {
        $(this).parent().parent().parent().find('.3bhk').css('display','block');
        $(this).parent().parent().parent().find('.2bhk').css('display','block');
        $(this).parent().parent().parent().find('.shop_info').css('display','none');
        $(this).parent().parent().parent().find('.www').css('display','block');

        //Get current id
        var bhkid = $(this).attr('id');
        //Split the id
        var splitid = bhkid.split('_');
        //Hide all the li
        $(".detailtab2_"+splitid[1]+" li").hide();
        //Show all the clicked li
        $(".detailtab2_"+splitid[1]+" ."+bhkid).show();
        //Show first record
        $( ".detailtab2_"+splitid[1]+" .bhk_"+splitid[1]+"_"+splitid[2]+" .sqft_click").first().trigger('click');
      });
      $(".sqft_click").on('click', function() {
        //Get Current ID
        var sqftid = $(this).attr('id');
        //Split the id
        var sqftsplitid = sqftid.split('_');

        $('.shop_info').css('display','none');
        $('.www').css('display','block');
        //Hide all the li
        $(".detail2_"+sqftsplitid[1]+" .property_detail").hide();
        //Show all the clicked li
        $(".detail2_"+sqftsplitid[1]+" #property_detail_"+sqftsplitid[1]+"_"+sqftsplitid[2]+"_"+sqftsplitid[3]).show();
      });
      $('.product-listing-right').css('height', $('.service-list').height() + 200);
      $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    });
    //Function to save listing in saved list
    function saveListing(listing_id) {
        var expDate = new Date();
        expDate.setTime(expDate.getTime() + (15 * 60 * 1000)); // add 15 minutes
        //Get the current count
        if (typeof $.cookie("total_count") !== 'undefined') {
            var updated = Number($.cookie("total_count")) + 1;     // Number()
        } else {
            var updated = '1';
        }
        if (typeof $.cookie("listing_value") !== 'undefined') {
            var listing_ids = $.cookie("listing_value")+','+listing_id;
        } else {
            var listing_ids = listing_id;
        }
        //Erase value
        $.removeCookie("total_count", { path: '/' });
        $.removeCookie("listing_value", { path: '/' });
        //Set new value
        $.cookie('total_count', updated, { path: '/', expires: expDate });
        $.cookie("listing_value",listing_ids, { path: '/', expires: expDate });
        //Update the header count value
        $(".header-like .count").html('');
        $(".header-like .count").html(updated);
    }
    jQuery(".listingbtn").on('click',function() {
        jQuery(".gridview").hide();
        jQuery(".listingview").show();
        jQuery(".gridbtn").removeClass('active');
        jQuery(".listingbtn").addClass('active');
    });
    jQuery(".gridbtn").on('click',function() {
        jQuery(".listingview").hide();
        jQuery(".gridview").show();
        jQuery(".listingbtn").removeClass('active');
        jQuery(".gridbtn").addClass('active');
    });
    jQuery("#l_category").on('change',function(){
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getType')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#s_type").empty();

                    $("#s_type").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#s_type").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })
    });

function getPredefineSelection() {
      var keyword = jQuery("#s_key").val();
      $.ajax({
          type:"GET",
          dataType: "json",
          url:"{{url('/getSelectionInfo')}}?keyword="+keyword,
          success:function(data){
              if (data === false || data === 'no_action') {
                  $("#l_category").val('').change();
                  $("#s_type").val('').change();
              } else {
                  //Grab the category value
                  var cate = $("l_category").val();
                  var s_type = $("s_type").val();
                  if (cate !== data.category_id) {
                      $("#l_category").val(data.category_id).change();
                  }
                  if (s_type !== data.sub_cate_id) {
                      setTimeout(function(){ $("#s_type").val(data.sub_cate_id).change(); }, 2000);
                  }
              }
          }
      })
  }
    
 $('.rera_text').click(function(){
        $(this).CopyToClipboard();
    });

     
    jQuery("#l_category").on('change',function(){
       $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{url('/getType')}}?category="+this.value,
            success:function(data){
                if ( data ) {
                    //Empty Drop Down
                    $("#s_type").empty();

                    $("#s_type").append('<option value="">Sub Category</option>');
                    $.each( data, function( key, value ) {
                        $("#s_type").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
        })      
    });
    var ltName = getCookie('Info');
    if (ltName == '') {

$(window).on('load',function(){
        $('#myOTR').modal('show');
         $('.firstBlur').addClass('modalBlur');
    });


        $(".modal fade").css("display", "block");
        $(".modal fade").css("opacity", "10");
        $(".modal fade").css("pointer-events", "auto");

    }
    else {
        $("#myOTR").modal('hide');
        $(".modal fade").css("opacity", "0");
        $(".modal fade").css("pointer-events", "none");
    }


    $.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a valid mobile number');


    $("#super_submit").validate({
    rules: {
      txtname:{
       required: true,
      },
      txtnumber: {
        required: true,
        regex: '^([+][9][1]|[9][1]|[0]){0,1}([6-9]{1})([0-9]{9})$'
      },
      txtcity: {
        required: true,
      },
      cat:{
        required: true,
      },
    },
    messages: {
      txtname: {
        required: "Username is required",
      },
      txtnumber: {
        required: "Mobile number is required",
      },
       txtcity: {
        required: "City name is required",
      },
      cat: {
        required: "Category Must Required",
      },
    },
    errorElement : 'div',
      errorLabelContainer: '.error',
      submitHandler: function() {
        $.ajax({
          url:"{{url('/')}}/otradd_form",
          type: 'post',
          data: $('#super_submit').serialize(),
          success: function(result){
             if(result == 'success')
              {
              setCookie('Info', result, 365);
              $("#myOTR").modal('hide');
              $('#ignismyModal').modal('show');
            }
             // $('.modal-backdrop').css("display", "none");
          },error: function(err){

          }
        });  
      }    
    });
$("#close_modal").click(function(){
   $('#myOTR').modal('toggle');
    $('.firstBlur').removeClass('modalBlur');
});    
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
    $(function () {
        $('.select2').select2()
    });
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
    

  $(".number").keypress(function (e) {
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
             return false;
  }
 });
 $('.c_this').on('click',function() {
    
 $('.firstBlur').removeClass('modalBlur');
});
  