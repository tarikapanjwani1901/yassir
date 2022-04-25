<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body id="result" >
<link href="{{url('/')}}/public/assets/css/bootstrap1.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
.btn:focus, .btn:active, button:focus, button:active {outline: none !important;box-shadow: none !important;}
#image-gallery .modal-footer{display: block;}
.pdf-cover{position:relative;margin-top: 20%;}
.hd-broucher {padding: 0 10px; line-height: 46px; border-left: 5px solid #8c1730;border-right: 5px solid #8c1730; line-height: 34px; margin-bottom: 20px;}
.pdf-logo-image{height: 50px;display: inline-block;position: absolute;right: 0;bottom: 25px;}
.pdf-text-title{    border-bottom: 3px solid #8c1730;
    padding-bottom: 18px;
    display: block;
    width: 100%;
    font-size: 75px;
    margin-bottom: 30px;}
.main-text-cover{    position: relative;
    color: #fff;
    background: #8c1730;
    text-align: justify;
    border-radius: 3px;
    padding: 25px 15px;
    width: 100%;
    font-size: 40px;
    margin-bottom:0%;
    line-height: 75px;margin-top: 10%;}
.thmb-img{width:185px;}
.cnt-1{background:#8c1730;border-radius: 3px;padding:10px 15px; width: 100%;}
.cnt-1-title{color: #fff;font-size: 46px;width: 100%;border-bottom: 3px solid #fff;padding-bottom: 3px;}
.cnt-1-text{color: #fff;font-size: 20px;font-weight: normal;}
.cnt-1-text span{font-weight: 500;font-size: 30px;}
.cnt-2{}
figure{text-align:center;}
.main-text-cover:after{    content: "";
    position: absolute;
    bottom: -9%;
    width: 0;
    height: 0;
    border: 0 solid transparent;
    border-left-width: 70px;
    border-right-width: 70px;
    border-top: 70px solid #8c1730;
    left: 50%;
    transform: translateX(-50%);}
    .cnt-2{display:block;margin-bottom:10px;}
    .cnt-3{display:block;margin-bottom:10px;}
    .cnt-4{    display: block;
    margin-bottom: 10px;
    color: #fff;
    font-size: 26px;
    font-weight: bold;}
    .cnt-1 h4{color: #fff;font-size: 26px;}
    .cnt-4 h4{color: #fff;font-size: 22px;}
    .bg-img{width:100%;} 
    .bg-img-1{opacity:0.6;width: 100%;padding: 0px 20px;}
    .one-pg-cover{padding:20px;border:20px solid #8c1730;}
    .mar-12{margin-bottom: 40%;}
    .pd1{margin:15% 0% 45% ;width: 100%;float: left;}
    .pd2{margin:120% 0% 20%;}   
    .pd3{margin:144% 0%;}   
    /*hr{width: 100%;float: left;border: 2px solid #8c1730;}  */
    /*hr:after{content:"";clear:both;}*/
    .ct-cvr{width: 100%;}
    .ct-cvr:before{clear:both;} 
    @media screen and (max-width:1379px){
    .pd1{margin:10% 0% 40%;width: 100%;float: left;}
    .pd2{margin:80% 0% 20%;}    
    .pd3{margin:144% 0%;}   
    }
</style>

<button type="button" id="btnExport" class="btn btn-primary exporting" data-toggle="tooltip" title="" data-original-title="Generate PDF"><i class="fa fa-download"></i> Generate PDF</button>
 
<div class="container" >
  <div class="one-pg-cover">
    <div class="pdf-cover">
      <img class="pdf-logo-image" src="{{url('/')}}/public/assets/images/logo-black.png">
      <h2  class="pdf-text-title">{{$data[0]->l_title}} </h2>
       @php 
          $count_item = count($data);
          $odd_num=$count_item %8;
       @endphp

    </div>
    <div class="main-text-cover">
      <p>{{$data[0]->l_title}} delivers a diverse span of various construction materials. These materials are highly reliable, more sustainable, specialized and cost effective. In order to build a strong and everlasting niche of your building, all the construction materials right from the basic- sand, bricks and blocks, fibre, cement, plasters to the complex metal fittings, bathroom fittings, glass fittings, iron rods etc. that needs to be used, Yas Sir strives to provide genuine, trustworthy and durable materials to you.</p>
    </div>
    <img class="bg-img" src="{{url('/')}}/public/images/bg4.png">
    </div>

  <div class="mar-12"></div>
           
    <div class="row ">
      <!-- <div style="color:#fff;background:#8c1730;text-align: center;border-radius: 3px;padding:25px 15px; width: 100%;font-size: 25px;margin-bottom: 8px;">
        <p>Product Category</p>
      </div>      
            @foreach($data_info as $s)
                <p style="background: #8c1730;width:32.5%; border-radius: 50px; padding: 0 8px; font-size: 14px;margin: 5px 5px 10px 0; text-align: center; color: #fff; line-height: 50px;"> {{$s->cate_name}}</p>
            @endforeach
      
     <hr style="background:#8c1730;border-radius: 3px;padding:52px; width: 100%;font-size: 25px;margin-top: 5px;"> -->
        <div class="row">

          @php $i = 0; @endphp

              <h2  class="pdf-text-title"> Product </h2>
             
           @php $cnt=1; @endphp
          @foreach($data as $datas)
           @if ($cnt%8!=0)
            
            <div class="col-lg-3 col-md-4 col-xs-6" style="margin-top: 15px;margin-bottom: 15px;">
                  <figure>
                    @if($datas->product_img=="")
                    <img  class="img-thumbnail thmb-img" src="{{url('/')}}/public/images/noimage.png" style="width: 100%;height: 350px;"><br><br>
                    @else
                      <img class="img-thumbnail thmb-img"
                           src="{{url('/')}}/public/images/product/{{$datas->id}}/{{$datas->product_img}}" style="width: 100% ;height: 350px;">
                     @endif
                  </figure>

                  <p class="text-center">{{$datas->product_name}}<br>
                  <i class="fa fa-inr" aria-hidden="true"></i>
                  @if($datas->product_price==0)
                    N/A
                  @else
                    {{$datas->product_price}}</p>
                  @endif             
            </div>
             @php  $cnt=$cnt+1;  @endphp
             @else
              @php  $cnt=1;  @endphp
               
                  <div class="col-lg-3 col-md-4 col-xs-6" style="margin-top: 15px;margin-bottom: 15px;">
                  <figure>
                    @if($datas->product_img=="")
                    <img  class="img-thumbnail thmb-img" src="{{url('/')}}/public/images/noimage.png" style="width: 100%;height: 350px;"><br><br>
                    @else
                      <img class="img-thumbnail thmb-img"
                           src="{{url('/')}}/public/images/product/{{$datas->id}}/{{$datas->product_img}}" style="width: 100%;height: 350px;">
                     @endif
                  </figure>

                  <p class="text-center">{{$datas->product_name}}<br>
                  <i class="fa fa-inr" aria-hidden="true"></i>
                  @if($datas->product_price==0)
                    N/A
                  @else
                    {{$datas->product_price}}</p>
                  @endif             
            </div>
            <hr>
            <img class="bg-img-1" src="{{url('/')}}/public/images/bg4.png">
            <div class="pd1"></div>
            @endif
          @endforeach

      
            </div>
        </div>

        @if($odd_num<=4 && $odd_num!=0)
       <div class="pd3"></div>
       @else
          <div class="pd2"></div>
        @endif

<div class="ct-cvr">
    <div class="container">
        <div class="cnt-1">
          <h1 class="cnt-1-title" style="">Contact Us</h1>
          <h4 class="cnt-1-text">
             <span class="cnt-2">{{$data[0]->l_title}}</span>
             <span class="cnt-3">Address :</span><h4>{{$data[0]->l_location}}</h4>
             <span class="cnt-4">Contact No :</span><h4>{{$data[0]->phone}}</h4>
            </h4>
        </div>
        </div>
</div>
     <!--    <img style="opacity:0.6;width: 100%;padding: 0px 20px;" src="{{url('/')}}/public/images/bg4.png"> -->
</div>
</body>
</html>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.1.135/jspdf.min.js"></script>
<script src='https://cdn.rawgit.com/simonbengtsson/jsPDF/requirejs-fix-dist/dist/jspdf.debug.js'></script>
<script src='https://unpkg.com/jspdf-autotable@2.3.2'></script>
<script src='https://cdn.rawgit.com/simonbengtsson/jsPDF/requirejs-fix-dist/dist/jspdf.debug.js'> </script> 
<script src='https://unpkg.com/jspdf-autotable@2.3.2'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
<script>
$("#btnExport").click(function () {
  $('#btnExport').css('display','none');
    var table = $('#result').get(0);
    // console.log(table);
    
    html2canvas(table, {
      onrendered: function(canvas){
        $('body').append(canvas);
        var contentWidth = canvas.width;
        var contentHeight = canvas.height;
        var position = 20,
            x = 20,
            y = 0;        
        var pageHeight = (contentWidth / 595.28 * 841.89);
        var restHeight = contentHeight;
        var imgWidth = 595.28 - position * 2;  
        var imgHeight = imgWidth / contentWidth * contentHeight - position * 2; 
        var pageData = canvas.toDataURL('image/jpeg', 1.0);
        var pdf = new jsPDF('', 'pt', 'a4');
                  
                  if (restHeight < pageHeight) { 
                      pdf.addImage(pageData, 'JPEG', x, position, imgWidth, imgHeight);
                  } else { 
                      while(restHeight > 0) {
                        pdf.addImage(pageData, 'JPEG', x, position + y, imgWidth, imgHeight);
                          restHeight -= pageHeight;
                          y -= 841.89;
                         
                          if(restHeight > 0) {
                              pdf.addPage();
                          }
                      } 
                  }
                  pdf.save('{{$data[0]->l_title}} Brochure.pdf');
      }
    });
  });

</script>