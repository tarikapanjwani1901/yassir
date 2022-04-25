    @extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Invoice
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/css/pages/invoice.css') }}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        *{
            font-family: Lato, sans-serif ;
        }
    #printableArea table tr td:last-child {width: 20%;}
</style>
<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 4px 8px;} 
    b, strong{font-size: 12px;}
    @media screen and (max-width:1200px){
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 4px 8px;}
    }
    .table{margin-bottom:0px;}
    td.qty{width: 8%;} 
    .btm-add1{width:60%;}
    .btm-add2{width:40%;}

    .sn{width: 7%;}
    .ds{width: 30%;}
    .hsn{width: 15%;}
    .ps1{width: 12%;}
    .qty{width: 10%;}
    .amt{}
/*    #printableArea table tr td{width: 72%;}*/
    #printableArea table tr td:last-child{width: 28%;}
    #printableArea table tr td.l1{width: 72%;}
</style> 
@stop

{{-- Page content --}}
@section('content')
<script type="text/javascript">
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;

}
</script>
<section class="content-header">
                <h1>Invoice</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                            Dashboard
                        </a>
                    </li>
                    <li ><a href="#"> Pages</a></li>
                    <li class="active"> Tax Invoice</li>
                </ol>
            </section>
            <!-- Main content -->
            <div id="printableArea">
            <section class="content paddingleft_right15" id="invoice-stmt">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-heading" style="display: none;">
                                <h3   class="panel-title"><i class="livicon" data-name="tablet" data-size="16" data-loop="true" data-c="#fff" data-hc="#fff"></i> Tax Invoice <bold></bold></h3>
                             <span class="pull-right colors_right">
                                 <ul class="list-inline colors">
                                     <li class="bg-default"></li>
                                     <li class="bg-primary"></li>
                                     <li class="bg-success"></li>
                                     <li class="bg-warning"></li>
                                     <li class="bg-danger"> </li>
                                     <li class="bg-info"></li>
                                 </ul>
                                    </span>
                            </div>
                            <div class="panel-body" style="border:1px solid #ccc;padding:0;margin:0;">
                                <div style="text-align: center; margin: 0 auto; width: 100%; border-bottom:1px solid black; font-weight:700;">TAX INVOICE</div>
                                <div class="row" style="padding: 15px;margin-top:5px;">
                                    <div class="col-md-6">
                                        <img style="float:left;display:inline-block;height: 80px;" src="{{ asset('public/assets/images/invoice_logo.png') }}" alt="logo" class="img-responsive" >
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull-right" style="font-weight:700; font-size: 12px;">
                                            <strong>YasSir</strong><br>
                                            Golden arcade, SF, 07,Sector 25,<br>
                                            Gandhinagar, Gujarat- 382027<br>
                                            call us:7575081000<br>
                                            E: info@yassir.in<br>
                                            website: www.yassir.in<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding:15px;">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table"> 
                                               
                                                <tbody>
                                                    <tr>
                                                        <td class="l1" colspan="5"><strong>Details of Receive | Billed to :</strong></td>
                                                        <td colspan="1"><strong>Invoice No.: {{ $edit_data[0]->invoice_number }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="l1" colspan="5"><strong> Name: {{ ucfirst($edit_data[0]->company_name) }}</strong></td>
                                                        <td colspan="1"><strong>Invoice Date : {{ $edit_data[0]->created_at }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="l1" colspan="5"><strong>Address: {{ $edit_data[0]->address }}</strong></td>
                                                        <td colspan="1" style="border-bottom: 1px solid #fff;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="l1" colspan="5" ><strong>Contact: {{ $edit_data[0]->mobile }}</strong></td>
                                                        <td colspan="1" style="border-bottom: 1px solid #fff;"></td>
                                                    </tr>
                                                    <tr>
                                                        @if(!$edit_data[0]->gst_number=="")
                                                        <td class="l1" colspan="5" style="border-bottom:0px;"><strong>GSTIN: {{ $edit_data[0]->gst_number }}</strong></td>
                                                        @else
                                                        <td class="l1" colspan="5" style="border-bottom:0px;"></td>
                                                        @endif
                                                        <td class="l1" colspan="1" style="border-bottom:0px;"><center>(Original Copy)</center></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="sn"><strong>SI No.</strong></td>
                                                        <td class="ds"><strong>DESCRIPTION</strong></td>
                                                        <td class="hsn text-right" ><strong>HSN /SAC</strong></td>
                                                        <td class="ps1 text-right"><strong>PRICE  <i class="fa fa-rupee" aria-hidden="true"></i></strong></td>
                                                        <td class="qty text-right" ><strong>QNTY.</strong></td>
                                                        <td class="amt text-right"><strong>AMOUNT <i class="fa fa-rupee" aria-hidden="true"></strong></td>
                                                    </tr>

                                                    @php $count = 1; @endphp
                                                 @foreach($edit_data as  $value)

                                                <tr>
                                                    <td>{{$count++}}</td>
                                                    <td>{{ $value->package }}</td>
                                                    <td class="text-right">{{ $value->hsn }}</td>
                                                    <td class="text-right">{{ $value->price }}</td>
                                                    <td class="text-right">{{ $value->qnty }}</td>
                                                     <td class="text-right">{{ $value->price }}</td>
                                                </tr>
                                                    @endforeach
                                                <tr>

                                                    <td  colspan="5" class="text-right l1"><strong>SUB TOTAL</strong></td>
                                                    <td colspan="2" class="text-right">{{$price_total}}</td>
                                                </tr>
                                                <tr>

                                                    <td  colspan="5" class="text-right l1"><strong>CGST @ 9%</strong></td>
                                                    <td  colspan="2" class="text-right">{{$cgst_total}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-right l1" ><strong>SGST @ 9%</strong></td>
                                                    <td colspan="2" class="text-right">{{$sgst_total}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-right l1" ><strong>IGST @ 18%</strong></td>
                                                    <td colspan="2" class="text-right" style="border-top:0px;">0.00</td>
                                                </tr>
                                                <tr > 
                                                    <td  colspan="5" class="text-right l1" style="border-bottom:0px;"><strong>TOTAL</strong></td>
                                                    <td  colspan="2" class="text-right" style="border-bottom:0px;"><strong>{{ $sum_invoice }}</strong></td>
                                                </tr>
                                                </table>
                                                <table class="table">
                                                <tr>
                                                    <td colspan="6">
                                                        <strong>NOTE:</strong>
                                                        <br>
                                                        # Tenure of services and payment terms for this invoice would be governed as per the agreement betweenthe  Customer and YasSir.<br>
                                                        # Thisinvoice is valid,Subject to relization of duepayments, as mentioned in details above.
                                                    </td> 
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="btm-add1"><strong>Account Details:</strong><br>
                                                        <strong>Name: YAS SIR</strong><br>
                                                        <strong>Account No: 920020058867171</strong><br>
                                                        <strong>Bank: AXIS BANK</strong><br>
                                                        <strong>IFSC: UTIB0004377</strong><br>
                                                        <strong>Branch: SARGASAN , GANDHINAGAR</strong><br>
                                                        <strong>GSTN No: 24DMBPK9418L2ZQ</strong><br>
                                                    </td>
                                                    <td colspan="2" class="btm-add2">
                                                        <strong>Authorized Signatory</strong><br>
                                                        <img src="{{ asset('public/assets/images/Capture1.PNG') }}" alt="logo" class="img-responsive"><br>
                                                        <strong>Name: Keyur Kadiya</strong><br>
                                                        <strong>Designation: Managing Director</strong>
                                                    </td>
                                                    
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table class="table">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div style="background-color: #eee;padding:15px;" id="footer-bg"> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Account Details:</strong><br>
                                            <strong>Name: YAS SIR</strong><br>
                                            <strong>Account No: 09331212000017</strong><br>
                                            <strong>Bank: ORIENTAL BANK OF COMMERCE</strong><br>
                                            <strong>IFSC: ORBC0100933</strong><br>
                                            <strong>Branch: SECTOR-11 , GANDHINAGAR</strong><br>
                                            <strong>GSTN No: 24DMBPK9418L2ZQ</strong><br>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="pull-right">
                                                <strong>Authorized Signatory</strong><br>
                                                <img src="{{ asset('public/assets/images/Capture1.PNG') }}" alt="logo" class="img-responsive"><br>
                                                <strong>Name: Keyur Kadiya</strong><br>
                                                <strong>Designation: Managing Director</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <hr> 
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </div>
            <div style="margin:10px 20px;text-align:center;" class="btn-section">
                                        <button type="button"  class="btn btn-responsive btn_marTop button-alignment btn-info"
                                                data-toggle="button">
                                            <a style="color:#fff;" onclick="printDiv('printableArea')">
                                                <i class="livicon" data-name="printer" data-size="16" data-loop="true"
                                                   data-c="#fff" data-hc="white" style="position:relative;top:3px;"></i>
                                                Print
                                            </a>
                                        </button>
                                    </div>
                <!-- content --> 
    @stop

{{-- page level scripts --}}
@section('footer_scripts')

    <script  src="{{ asset('assets/js/pages/invoice.js') }}"  type="text/javascript"></script>

@stop
