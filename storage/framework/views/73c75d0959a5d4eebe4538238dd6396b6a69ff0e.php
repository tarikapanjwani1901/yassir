<?php $__env->startSection('title'); ?>
OTRListing
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('public/assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('public/assets/vendors/daterangepicker/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<style>
  .dt1{width: 200px;display: inline-block; margin-left: 6px;}    
</style> 
<section class="content-header">
    <h1>OTR Listings</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li class="active">OTR Listings</li>
    </ol>
</section>
<!-- Main content -->
<section class="content paddingleft_right15">
   <div class="">
    <div class="row">
        <div class="portlet box warning">
            <div class="portlet-title">
                    <div class="caption">
                      OTR Listing
                    </div>

                    <div style="float: right;">
                        <form action="<?php echo e(url('/admin/excel')); ?>" method="post">
                               <?php echo e(csrf_field()); ?>

                                <?php if(isset($_GET['category'])): ?>
                                    <input type="hidden" name="category" value="<?php echo e($_GET['category']); ?>">
                                <?php endif; ?>
                                <input type="hidden" name="user_id" value="<?php echo e(Sentinel::getUser()->id); ?>">

                             
                               <button type="button" id="btnExport" class="btn btn-primary pull-right exporting" data-toggle="tooltip" title="" data-original-title="Generate Excel"><i class="fa fa-file-excel-o"></i> Generate Excel</button>
                        </form>
                    </div>

                </div>  
                

                <form class="reportform padd15" action="" method="get" name="inquiry" autocomplete="off">
                <input type="search" name="city_name" placeholder="search" style="height: 35px;border: 1px solid #cccccc;padding-left: 6px;border-radius: 5px;" value="<?php
             if(isset($_GET['city_name'])){ echo $_GET['city_name']; } ?>">
                

                <select class="form-control" name="main_category" id="main_category">
                    <option value="">Select category</option>
                    <option value="Property">Property</option>
                    <option value="Consultancy">Consultancy</option>
                    <option value="Contractor">Contractor</option>
                    <option value="Material">Material</option>
                    <option value="Skill Labour">Skill Labour</option>

                     <input id="dob" name="date" type="text" class="form-control dt1"
                                                               data-date-format="YYYY-MM-DD" value=""
                                                               placeholder="yyyy-mm-dd"/>
                  <input type="submit" value="Submit" id="submit">
                  <a href="<?php echo e(url('/')); ?>/admin/otrlisting"   class="btn btn-primary exporting"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                </form>      
                <div class="portlet-body testimoniallist">
                 <div class="table-responsive">
                    <table class="table table-bordered" id="printableArea">
                       <thead>
                          <tr>
                             <th>Id</th>
                             <th>Name</th>
                             <th>Phone</th>
                             <th>City</th>
                             <th>Intrested</th>
                             <th>Date/Time</th>
                          </tr>
                       </thead>
                       <tbody>
                           <?php $i = ($otrListing->currentpage()-1)*$otrListing->perpage() + 1 ?>
                            <?php if(count($otrListing)): ?>
                            <?php $__currentLoopData = $otrListing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="tr_<?php echo e($otr->id); ?>">
                                    <td> <?php echo e($i++); ?> </td>
                                    <td> <?php echo e(ucfirst($otr->name)); ?> </td>
                                    <td> <?php echo e($otr->phone); ?> </td>
                                    <td> <?php echo e(ucfirst($otr->city)); ?> </td>
                                    <td> <?php echo e($otr->intrested); ?> </td>
                                    <?php if($otr->created_at == ''): ?>
                                    <td></td>
                                    <?php else: ?>			                 
                                   <td>
                                     <?php echo date('M j h:ia', strtotime($otr->created_at)) ?> 
                                   </td>
                                     <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <tr>
                              <td colspan="10">No records found</td>
                            </tr>
                            <?php endif; ?>
                       </tbody>
                    </table>
                    <?php echo e($otrListing->links()); ?>

                 </div>
                </div>
           </div>
        </div>
  </div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remove Product</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure?</p>
            </div>
            <input type="hidden" name="bookId" id="bookId" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="btn_ok_1" class="btn btn-primary">Sure</button>
            </div>
        </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
<script src="<?php echo e(asset('public/assets/vendors/moment/js/moment.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/daterangepicker/js/daterangepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/vendors/clockface/js/clockface.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/js/pages/datepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/js/table2excel.js')); ?>"></script>


<script src="<?php echo e(asset('public/assets/vendors/iCheck/js/icheck.js')); ?>"></script>
 
    <script src="<?php echo e(asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>"  type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/select2/js/select2.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(asset('public/assets/js/pages/adduser.js')); ?>"></script>





<script type="text/javascript">
$("#btnExport").click(function () {
                 $("#printableArea").remove(".ac").table2excel({
                exclude: ".ac",
                    name: "Employee data",
                filename: "OTR_details"
                });
            });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>