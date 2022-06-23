
<p style="display: none;">{{$test = Sentinel::getUser()->id}}</p>
<?php 
$vendor_listing = \DB::table('vendor_listing')->where('u_id',$test)->get();
?>
<ul id="menu" class="page-sidebar-menu">

	@if(Sentinel::inRole('admin'))
    <li {!! (Request::is('admin') ? 'class="active"' : '') !!}>
        <a href="{{ route('admin.dashboard') }}">
            <i class="livicon" data-name="dashboard" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Dashboard</span>
        </a>
    </li>
    @endif

<!--     <li {!! (Request::is('admin/log_viewers') || Request::is('admin/log_viewers/logs')  ? 'class="active"' : '') !!}>

        <a href="{{  URL::to('admin/log_viewers') }}">
            <i class="livicon" data-name="help" data-size="18" data-c="#1DA1F2" data-hc="#1DA1F2"
               data-loop="true"></i>
            Log Viewer
        </a>
    </li> -->
<!--     <li {!! (Request::is('admin/activity_log') ? 'class="active"' : '') !!}>
        <a href="{{  URL::to('admin/activity_log') }}">
            <i class="livicon" data-name="eye-open" data-size="18" data-c="#F89A14" data-hc="#F89A14"
               data-loop="true"></i>
            Activity Log
        </a>
    </li> -->
    @if(Sentinel::inRole('admin'))
    <li {!! (Request::is('admin/users') || Request::is('admin/users/create')  ||  Request::is('admin/groups') ||  Request::is('admin/groups/create') || Request::is('admin/manage_invoice')     || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="user" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Users</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Users
                </a>
            </li>
            <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New User
                </a>
            </li>
            <li {!! (Request::is('admin/deleted_users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/deleted_users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Deleted Users
                </a>
            </li>
            <li {!! (Request::is('admin/groups') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/groups') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Group List
                </a>
            </li>
            <li {!! (Request::is('admin/groups/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/groups/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New Group
                </a>
            </li>
             <li {!! (Request::is('admin/manage_invoice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_invoice') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Generate Invoice
                </a>
            </li>
        </ul>
    </li>


    <!-- export -->
    <!--
     <li {!! (Request::is('admin/all_vendor') || Request::is('admin/all_sales') || Request::is('admin/all_customer') || Request::is('admin/all_vendor/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Export report</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/all_vendor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/all_vendor') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Vendor
                </a>
            </li>
            <li {!! (Request::is('admin/all_sales') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/all_sales') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Sales
                </a>
            </li>
            <li {!! (Request::is('admin/all_customer') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/all_customer') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Customer
                </a>
            </li>
        </ul>
    </li>-->







    <!-- Menus generated by CRUD generator -->

    <li {!! (Request::is('admin/state') || Request::is('admin/cities') || Request::is('admin/cities_search') || Request::is('admin/cities/add') || Request::is('admin/cities/*') 
    
   || Request::is('admin/sub_cities') || Request::is('admin/sub_cities_search') || Request::is('admin/sub_cities/add') || Request::is('admin/sub_cities/*')  
   || Request::is('admin/areas') || Request::is('admin/areas_search') || Request::is('admin/areas/add') || Request::is('admin/areas/*')  
     || Request::is('admin/state_search')  || Request::is('admin/state/add') || Request::is('admin/state/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Locations</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/state') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/state') }}">
                    <i class="fa fa-angle-double-right"></i>
                   All State
                </a>
            </li>
            <li {!! (Request::is('admin/state/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/state/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add State
                </a>
            </li>
            
            <li {!! (Request::is('admin/cities') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/cities') }}">
                    <i class="fa fa-angle-double-right"></i>
                   All Cities
                </a>
            </li>
            <li {!! (Request::is('admin/cities/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/cities/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add City
                </a>
            </li>
            
            
            <li {!! (Request::is('admin/sub_cities') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/sub_cities') }}">
                    <i class="fa fa-angle-double-right"></i>
                   All Sub Cities
                </a>
            </li>
            <li {!! (Request::is('admin/sub_cities/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/sub_cities/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Sub City
                </a>
            </li>
            
            
              <li {!! (Request::is('admin/areas') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/areas') }}">
                    <i class="fa fa-angle-double-right"></i>
                   All Areas
                </a>
            </li>
            <li {!! (Request::is('admin/areas/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/areas/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Area
                </a>
            </li>
        </ul>
    </li>
  
    <li {!! (Request::is('admin/testimonials') || Request::is('admin/testimonials/add') || Request::is('admin/testimonials/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Testimonials</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/testimonials') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/testimonials') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Testimonials
                </a>
            </li>
            <li {!! (Request::is('admin/testimonials/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/testimonials/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Testimonial
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/categories') || Request::is('admin/categories/add') || Request::is('admin/categories/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">System Category</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/categories') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/categories') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Category
                </a>
            </li>
            <li {!! (Request::is('admin/categories/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/categories/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Category
                </a>
            </li>
        </ul>
    </li>
    <li {!! (Request::is('admin/skill_labors') || Request::is('admin/skill_labors/add') || Request::is('admin/deleted_skilllabor')   || Request::is('admin/skill_labors/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage skill labor</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/skill_labors') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/skill_labors') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Skill labor
                </a>
            </li>
            <li {!! (Request::is('admin/deleted_skilllabor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/deleted_skilllabor') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Deleted Skill labor
                </a>
            </li>
            <li {!! (Request::is('admin/skill_labors/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/skill_labors/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Skill labor
                </a>
            </li>
        </ul>
    </li>
    
     <li {!! (Request::is('admin/manage_cms') || Request::is('admin/manage_cms/add') || Request::is('admin/manage_cms/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage CMS</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/manage_cms') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_cms') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All CMS Pages
                </a>
            </li>
            <!-- <li {!! (Request::is('admin/manage_cms/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_cms/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add CMS Page
                </a>
            </li> -->
        </ul>
    </li>

    <li {!! (Request::is('admin/review') ? 'class="active"' : '') !!}>
        <a href="{{ URL('admin/review') }}">
            <i class="livicon" data-name="review" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Review</span>
        </a>
    </li>
     <li {!! (Request::is('admin/visitor_records') ? 'class="active"' : '') !!}>
        <a href="{{ URL('admin/visitor_records') }}">
            <i class="livicon" data-name="review" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Visitors search records</span>
        </a>
    </li>
    @endif

    @if(Sentinel::inRole('admin'))
    <li {!! (Request::is('admin/vendorlisting') || Request::is('admin/vendorlisting/add') || Request::is('admin/vendorlisting/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Vendor Listing</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/vendorlisting') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/vendorlisting') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Listings
                </a>
            </li>
            <li {!! (Request::is('admin/vendorlisting/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/vendorlisting/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Listing
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if (Sentinel::inRole('vendor'))
        <li {!! (Request::is('admin/vendorlisting') ? 'class="active"' : '') !!}>
            <a href="{{ URL::to('admin/vendorlisting') }}">
                <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
                   data-loop="true"></i>
                <span class="title">Company Info</span>
            </a>
        </li>
    @endif

    @if(Sentinel::inRole('admin'))
    <li {!! (Request::is('admin/product') || Request::is('admin/product/add') || Request::is('admin/brochure') || Request::is('admin/product/*')? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Material Products</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/product') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/product') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Products
                </a>
            </li>
            <li {!! (Request::is('admin/product/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/product/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Product
                </a>
            </li>
            <li {!! (Request::is('admin/product/category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/product/category') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Product Category
                </a>
            </li>
             @if(Sentinel::inRole('admin'))   
            <li {!! (Request::is('admin/brochure') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/brochure') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Brochure
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

    @if(Sentinel::inRole('admin') || Sentinel::inRole('vendor'))
    <li {!! (Request::is('admin/inquirylisting') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/inquirylisting') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Inquiry Listing</span>
        </a>
    </li>
    @endif
    
    
     @if(Sentinel::inRole('vendor'))
     
     
    <li {!! (Request::is('admin/vendor_properties') || Request::is('admin/vendor_properties/add') || Request::is('admin/vendor_properties/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Property Listing</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/vendor_properties') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/vendor_properties') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Property Listing
                </a>
            </li>
            <li {!! (Request::is('admin/vendor_properties/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/vendor_properties/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Property Listing
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if(Sentinel::inRole('admin') || Sentinel::inRole('sales-team') || Sentinel::inRole('vendor') )
    <li {!! (Request::is('admin/otplisting') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/otplisting') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">OTP Listing</span>
        </a>
    </li>
    @endif
    
    

     @if(Sentinel::inRole('vendor'))
    <li {!! (Request::is('admin/invoice_detail') ? 'class="active" id="active"' : '') !!}>
        <a href="{{ URL::to('admin/invoice_detail') }}">
            <i class="livicon" data-name="file" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            Invoice information
        </a>
    </li>
    @endif

     @if(Sentinel::inRole('vendor'))   
        <li {!! (Request::is('admin/brochure') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/brochure') }}">
                 <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
                Brochure
            </a>
        </li>
        @foreach($vendor_listing as $dd)
        @if($dd->l_category == 4)
        <li {!! (Request::is('admin/product') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/product') }}">
                    <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
                    All Products
                </a>
            </li>
        <li {!! (Request::is('admin/product/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/product/add') }}">
                    <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
                    Add Product
                </a>
        </li>
        @endif
        @endforeach
    @endif    
    

    @if(Sentinel::inRole('admin'))
        <li {!! (Request::is('admin/otrlisting') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/otrlisting') }}">
        <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
        data-loop="true"></i>
        <span class="title">OTR Listing</span>
        </a>
        </li>
    @endif

     @if(Sentinel::inRole('admin'))
     <li {!! (Request::is('admin/slider_image') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/slider_image') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Slider Image</span>
        </a>
    </li>
     @endif
     @if(Sentinel::inRole('admin'))
     <li {!! (Request::is('admin/system_keyword') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/system_keyword') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">System Keyword</span>
        </a>
    </li>
     @endif     
     <!--@if(Sentinel::inRole('admin'))
     <li {!! (Request::is('admin/numbers') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/numbers') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Numbers</span>
        </a>
    </li>
     @endif-->
     
    @if(Sentinel::inRole('admin'))
     <li {!! (Request::is('admin/managescitys') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/managescitys') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage cities</span>
        </a>
    </li>
     @endif

     @if(Sentinel::inRole('admin'))
     <li {!! (Request::is('admin/managesareas') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/managesareas') }}">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage areas</span>
        </a>
    </li>
    @endif

    @if(Sentinel::inRole('admin'))
    
    <li {!! (Request::is('admin/manage_property_list') || Request::is('admin/manage_property_list/add') || Request::is('admin/manage_property_list/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage Property Listing</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/manage_property_list') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_property_list') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Property Listing
                </a>
            </li>
            <li {!! (Request::is('admin/manage_property_list/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_property_list/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Property Listing
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/manage_product_list') || Request::is('admin/manage_product_list/add') || Request::is('admin/manage_product_list/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage Product Listing</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/manage_product_list') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_product_list') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Product Listing
                </a>
            </li>
            <li {!! (Request::is('admin/manage_product_list/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_product_list/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Product Listing
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/manage_popular_categories') || Request::is('admin/manage_popular_categories/add') || Request::is('admin/manage_popular_categories/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Manage Popular Categories Listing</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/manage_popular_categories') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_popular_categories') }}">
                    <i class="fa fa-angle-double-right"></i>
                    All Popular Categories Listing
                </a>
            </li>
            <li {!! (Request::is('admin/manage_popular_categories/add') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/manage_popular_categories/add') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add Popular Categories Listing
                </a>
            </li>
        </ul>
    </li>
    @endif
     

     @if(Sentinel::inRole('admin'))
    <li {!! (Request::is('admin/general_setting') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">General Setting</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li>
                <a href="{{ URL::to('admin/general_setting') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Manage General Setting
                </a>
            </li>
            <li>
                <a href="{{ URL::to('admin/contact_detail') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Manage Contact Detail
                </a>
            </li>
        </ul>
    </li>
    @endif



    @if(Sentinel::inRole('admin'))
    <li {!! ((Request::is('admin/blogcategory') || Request::is('admin/blogcategory/create') || Request::is('admin/blog') ||  Request::is('admin/blog/create')) || Request::is('admin/blog/*') || Request::is('admin/blogcategory/*') ? 'class="active"' : '') !!}>
        <a href="javascript:void(0);">
            <i class="livicon" data-name="comment" data-c="#F89A14" data-hc="#F89A14" data-size="18"
               data-loop="true"></i>
            <span class="title">Blog</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/blogcategory') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/blogcategory') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Blog Category List
                </a>
            </li>
            <li {!! (Request::is('admin/blog') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/blog') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Blog List
                </a>
            </li>
            <li {!! (Request::is('admin/blog/create') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/blog/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New Blog
                </a>
            </li>
        </ul>
    </li>
    @endif

    @include('admin/layouts/menu')
</ul>