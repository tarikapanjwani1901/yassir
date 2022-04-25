@include('backend.header')

<div class="col-md-12">
   <div class="panel panel-primary">
      <div class="panel-heading">
         <h3 class="panel-title">
            <i class="material-icons ">person_add</i>
            Add New User
         </h3>
         <span class="pull-right clickable">
         <i class="material-icons">keyboard_arrow_up</i>
         </span>
      </div>
      <div class="panel-body">
         <!--main content-->
         <form name="commentForm" id="commentForm" action="http://material.joshadmin.com/admin/users" method="POST" enctype="multipart/form-data" class="form-horizontal bv-form" novalidate="novalidate">
            <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;" disabled="disabled"></button>
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="u6TChuIUyT9NTaFy8R2JoWrm3c4g6DTWgaUN8u3z">
            <div id="rootwizard">
               <ul class="nav nav-pills">
                  <li class="bv-tab-success active"><a href="#tab1" data-toggle="tab" aria-expanded="true">User Profile</a></li>
                  <li class="bv-tab-success"><a href="#tab2" data-toggle="tab" aria-expanded="false">Bio</a></li>
                  <li class=""><a href="#tab3" data-toggle="tab" aria-expanded="false">Address</a></li>
                  <li class=""><a href="#tab4" data-toggle="tab" aria-expanded="false">User Group</a></li>
               </ul>
               <div class="tab-content">
                  <div class="tab-pane active" id="tab1">
                     <h2 class="hidden">&nbsp;</h2>
                     <div class="form-group has-success">
                        <label for="first_name" class="col-sm-2 control-label">First Name *</label>
                        <div class="col-sm-10">
                           <input id="first_name" name="first_name" type="text" placeholder="First Name" class="form-control required" value="" data-bv-field="first_name">
                           <small class="help-block" data-bv-validator="notEmpty" data-bv-for="first_name" data-bv-result="VALID" style="display: none;">First name is required</small>
                        </div>
                     </div>
                     <div class="form-group has-success">
                        <label for="last_name" class="col-sm-2 control-label">Last Name *</label>
                        <div class="col-sm-10">
                           <input id="last_name" name="last_name" type="text" placeholder="Last Name" class="form-control required" value="" data-bv-field="last_name">
                           <small class="help-block" data-bv-validator="notEmpty" data-bv-for="last_name" data-bv-result="VALID" style="display: none;">Last name is required</small>
                        </div>
                     </div>
                     <div class="form-group  has-success">
                        <label for="email" class="col-sm-2 control-label">Email *</label>
                        <div class="col-sm-10">
                           <input id="email" name="email" placeholder="E-mail" type="text" class="form-control required email" value="" data-bv-field="email">
                           <small class="help-block" data-bv-validator="notEmpty" data-bv-for="email" data-bv-result="VALID" style="display: none;">The email address is required</small><small class="help-block" data-bv-validator="emailAddress" data-bv-for="email" data-bv-result="VALID" style="display: none;">The input is not a valid email address</small>
                        </div>
                     </div>
                     <div class="form-group has-success">
                        <label for="password" class="col-sm-2 control-label">Password *</label>
                        <div class="col-sm-10">
                           <input id="password" name="password" type="password" placeholder="Password" class="form-control required" value="" data-bv-field="password">
                           <small class="help-block" data-bv-validator="notEmpty" data-bv-for="password" data-bv-result="VALID" style="display: none;">Password is required</small><small class="help-block" data-bv-validator="different" data-bv-for="password" data-bv-result="VALID" style="display: none;">Password should not match first name or last name</small>
                        </div>
                     </div>
                     <div class="form-group  has-success">
                        <label for="password_confirm" class="col-sm-2 control-label">Confirm
                        Password *</label>
                        <div class="col-sm-10">
                           <input id="password_confirm" name="password_confirm" type="password" placeholder="Confirm Password " class="form-control required" data-bv-field="password_confirm">
                           <small class="help-block" data-bv-validator="notEmpty" data-bv-for="password_confirm" data-bv-result="VALID" style="display: none;">Confirm Password is required</small><small class="help-block" data-bv-validator="identical" data-bv-for="password_confirm" data-bv-result="VALID" style="display: none;">Please enter the same value</small><small class="help-block" data-bv-validator="different" data-bv-for="password_confirm" data-bv-result="VALID" style="display: none;">Confirm Password should match with password</small>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab2" disabled="disabled">
                     <h2 class="hidden">&nbsp;</h2>
                     <div class="form-group required is-empty">
                        <label for="dob" class="col-sm-2 control-label">Date of Birth</label>
                        <div class="col-sm-10">
                           <input id="dob" name="dob" type="text" class="form-control" data-date-format="YYYY-MM-DD" placeholder="yyyy-mm-dd">
                        </div>
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group is-empty is-fileinput">
                        <label for="pic" class="col-sm-2 control-label">Profile picture</label>
                        <div class="col-sm-10">
                           <div class="fileinput fileinput-new" data-provides="fileinput">
                              <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                 <img src="http://placehold.it/200x200" alt="profile pic">
                              </div>
                              <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                              <div>
                                 <span class="btn btn-default btn-file">
                                 <span class="fileinput-new">Select image</span>
                                 <span class="fileinput-exists">Change</span>
                                 <input id="pic" name="pic_file" type="file" class="form-control">
                                 </span>
                                 <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="form-group has-success">
                        <label for="bio" class="col-sm-2 control-label">Bio
                        <small>(brief intro) *</small>
                        </label>
                        <div class="col-sm-10">
                           <textarea name="bio" id="bio" class="form-control" rows="4" data-bv-field="bio"></textarea>
                           <small class="help-block" data-bv-validator="notEmpty" data-bv-for="bio" data-bv-result="VALID" style="display: none;">The Bio data field is required</small>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab3" disabled="disabled">
                     <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">
                           <select class="form-control" title="Select Gender..." name="gender">
                              <option disabled="" selected="">Select</option>
                              <option value="male">
                                 MALE
                              </option>
                              <option value="female">
                                 FEMALE
                              </option>
                              <option value="other">
                                 OTHER
                              </option>
                           </select>
                        </div>
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-10">
                           <input id="state" name="state" type="text" class="form-control" value="">
                        </div>
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group">
                        <label for="city" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-10">
                           <input id="city" name="city" type="text" class="form-control" value="">
                        </div>
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                           <input id="address" name="address" type="text" class="form-control" value="">
                        </div>
                        <span class="help-block"></span>
                     </div>
                     <div class="form-group">
                        <label for="postal" class="col-sm-2 control-label">Postal/zip</label>
                        <div class="col-sm-10">
                           <input id="postal" name="postal" type="text" class="form-control" value="">
                        </div>
                        <span class="help-block"></span>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab4" disabled="disabled">
                     <p class="text-danger"><strong>Be careful with group selection, if you give
                        admin access.. they can access admin section</strong>
                     </p>
                     <div class="form-group required is-empty">
                        <label for="group" class="control-label">Group *</label>
                        <select class="form-control required" title="Select group..." name="group" id="group" data-bv-field="group">

                        </select>
                        <span class="help-block"></span>
                        <small class="help-block" data-bv-validator="notEmpty" data-bv-for="group" data-bv-result="NOT_VALIDATED" style="display: none;">You must select a group</small>
                     </div>
                     <div class="form-group checkbox">
                        <label>
                        <input type="checkbox" id="activate" name="activate" class="pos-rel p-l-30" value="1"><span class="checkbox-material"><span class="check"></span></span>
                        To activate user account automatically, click the check box
                        </label>
                        <br>
                     </div>
                  </div>
                  <ul class="pager wizard">
                     <li class="previous disabled"><a href="#">Previous</a></li>
                     <li class="next" style=""><a href="#">Next</a></li>
                     <li class="next finish hidden" style="display: none;"><a href="javascript:;">Finish</a>
                     </li>
                  </ul>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

@include('backend.footer')