
<!--==================  Start Form modal =================== -->

<div class="modal" tabindex="-1" id="formmodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Registration</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
      </div>
      <div class="text-center">
         <h5 class="msg"></h5>
      </div>
      <form name="rs_form" id="rs_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="modal-body">
              <div class="row">
                 <div class="col-md-6">
                     <div class="form-group">
                      <label for="rs_fullname">Full Name <span class="text-danger">*</span> </label>
                      <input type="text" class="form-control" id="rs_fullname" name="rs_fullname" placeholder="enter full name">
                    </div>
                    <div class="errorClass rs_fullname_error"></div>
                 </div>
                <div class="col-md-6">
                     <div class="form-group">
                      <label for="rs_lastname">Last Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="rs_lastname" name="rs_lastname" placeholder="enter last name">
                    </div>
                    <div class="errorClass rs_lastname_error"></div>
                 </div>
              </div>
              <div class="row mt-2">
                 <div class="col-md-6">
                     <div class="form-group">
                      <label for="rs_email">Email <span class="text-danger">*</span></label>
                      <input type="email" class="form-control" id="rs_email" name="rs_email" placeholder="enter email eddress">
                    </div>
                    <div class="errorClass rs_email_error"></div>
                 </div>
                <div class="col-md-6">
                     <div class="form-group">
                      <label for="rs_password">Password <span class="text-danger">*</span></label>
                      <input type="password" class="form-control" id="rs_password" name="rs_password" placeholder="enter password">
                    </div>
                    <div class="errorClass rs_password_error"></div>
                 </div>
              </div>
              <div class="row mt-2">
                 <div class="col-md-6">
                     <div class="form-group">
                      <label for="rs_country">Country <span class="text-danger">*</span></label>
                      <select class="form-control" name="rs_country" id="rs_country" onchange="loadState($(this).val())">
                        <option value="">Choose One</option>
                          <?php
                            $countryArr=$userObj->getCountryName();
                            if(!empty($countryArr)):
                              foreach ($countryArr as $countryData) {
                          ?>
                          <option value="<?= $countryData['sortname']."_".$countryData['id'];?>"><?= $countryData['name'];?></option>
                        <?php } endif;?>
                      </select>
                      
                    </div>
                     <div class="errorClass rs_country_error"></div>
                 </div>
                <div class="col-md-6">
                     <div class="form-group">
                      <label for="rs_state">State <span class="text-danger">*</span></label>
                      <select class="form-control" name="rs_state" id="rs_state" onchange="loadCity($(this).val())">
                        <option value="">Choose One</option>

                      </select>
                      
                    </div>
                    <div class="errorClass rs_state_error"></div>
                 </div>
                 <div class="col-md-6 mt-2">
                     <div class="form-group">
                      <label for="rs_state">City <span class="text-danger">*</span></label>
                      <select class="form-control" name="rs_city" id="rs_city">
                        <option value="">Choose One</option>

                      </select>
                      
                    </div>
                    <div class="errorClass rs_city_error"></div>
                 </div>
                 <div class="col-md-12 mt-3">
                      <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="rs_termcondition" id="rs_termcondition" value="1">
                        <label class="form-check-label" for="rs_termcondition">I agree terms and conditions</label>
                      </div>
                     <div class="errorClass rs_termcondition_error"></div>
                  </div>
              </div>
            </div>
            <div class="modal-footer mt-2">
              <input type="hidden" name="hid" id="hid" value="">
              <button type="submit" class="btn btn-primary" name="rs_submit" id="rs_submit"><i class="fa fa-save" aria-hidden="true"></i> Save </button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
      </form>
    </div>
  </div>
</div>

<!--==================  End Form modal =================== -->