@include('backend.header')

<div class="col-lg-12">
   <ul class="nav  nav-tabs ">
      <li class="active">
         <a href="#tab1" data-toggle="tab">
         <i class="material-icons tab_icons">supervisor_account</i>
         User Profile</a>
      </li>
      <li>
         <a href="#tab2" data-toggle="tab">
         <i class="material-icons tab_icons">vpn_key</i>
         Change Password</a>
      </li>
   </ul>
   <div class="tab-content mar-top">
      <div id="tab1" class="tab-pane fade active in">
         <div class="row">
            <div class="col-lg-12">
               <div class="panel">
                  <div class="panel-heading">
                     <h3 class="panel-title">
                        User Profile
                     </h3>
                  </div>
                  <div class="panel-body">
                     <div class="col-md-4">
                        <div class="img-file">
                           <img src="http://material.joshadmin.com/assets/images/authors/no_avatar.jpg" alt="..." class="img-responsive">
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="panel-body">
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped" id="users">
                                 <tbody>
                                    <tr>
                                       <td>First Name</td>
                                       <td>
                                          John
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Last Name</td>
                                       <td>
                                          hhfgdf
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>E-mail</td>
                                       <td>
                                          admin1@admin.com
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>
                                          Gender / Sex
                                       </td>
                                       <td>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Birth Date</td>
                                       <td>
                                          2018-10-21
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Country</td>
                                       <td>
                                          Italy
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>State</td>
                                       <td>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>City</td>
                                       <td>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Address</td>
                                       <td>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Postal / Zip code</td>
                                       <td>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Status</td>
                                       <td>
                                          Activated
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Created At</td>
                                       <td>
                                          2 months ago
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="tab2" class="tab-pane fade">
         <div class="row">
            <div class="col-md-12 pd-top">
               <form class="form-horizontal password_change">
                  <div class="form-body">
                     <div class="form-group is-empty">
                        <label for="inputpassword" class="col-md-3 control-label">
                        Password
                        <span class="require">*</span>
                        </label>
                        <div class="col-md-9">
                           <div class="input-group">
                              <span class="input-group-addon">
                              <i class="material-icons">vpn_key</i>
                              </span>
                              <input type="password" id="password" placeholder="Password" class="form-control">
                           </div>
                        </div>
                     </div>
                     <div class="form-group is-empty">
                        <label for="inputnumber" class="col-md-3 control-label">
                        Confirm Password
                        <span class="require">*</span>
                        </label>
                        <div class="col-md-9">
                           <div class="input-group">
                              <span class="input-group-addon">
                              <i class="material-icons">vpn_key</i>
                              </span>
                              <input type="password" id="password-confirm" placeholder="Confirm Password" class="form-control">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-actions">
                     <div class="col-md-offset-3 col-md-9 btn_subm">
                        <button type="submit" class="btn btn-primary " id="change-password">Submit
                        </button>
                        &nbsp;
                        <input type="reset" class="btn btn-default reset_btn" value="Reset">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

@include('backend.footer')