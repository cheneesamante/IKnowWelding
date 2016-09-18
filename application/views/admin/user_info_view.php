<script>
    $(document).ready(function(){
        $('input, select').attr('disabled', 'disabled');
    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Registered Users
        </h1>
        <ol class="breadcrumb">
          <!--<li><a href="#"><i class="fa fa-dashboard"></i> Registered Users</a></li>
          <li><a href="#">Tables</a></li>
          <li class="active">Data tables</li>-->
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Information</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="user_form" role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label for="first_tname">First Name</label>
                        <input type="text" class="form-control" id="first_tname" name="first_name" placeholder="Enter First Name" value="<?php echo isset($user['first_name']) ? $user['first_name'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo isset($user['middle_name']) ? $user['middle_name'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo isset($user['last_name']) ? $user['last_name'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                            </div>
                            <input class="form-control" type="text" id="birthdate" name="birthdate" data-mask="" data-inputmask="'alias': 'dd/mm/yyyy'" value="<?php echo isset($user['birthdate']) ? $user['birthdate'] : '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <div class="indent">
	                        <div class="radio">
	                        	<label>
			                        <input type="radio" class="with-font indent minimal" id="male" value="1" name="gender" <?php echo isset($user['gender']) && $user['gender'] == 1 ? 'checked' : '' ?>>
			                         Male
		                        </label>
		                    </div>
		                    <div class="radio">
		                    	<label>
			                        <input type="radio" class="with-font indent minimal" id="female" value="2" name="gender" <?php echo isset($user['gender']) && $user['gender'] == 2 ? 'checked' : '' ?>>
			                        Female
		                        </label>
		                    </div>
		                </div>
	                </div>
	                <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Email" value="<?php echo isset($user['username']) ? $user['username'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo isset($user['email_address']) ? $user['email_address'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Country</label>
                        <select id="country" name="country" class="form-control select2" style="width: 100%;">
                            <option value="">-- Select a country --</option>
                    		<option value="1" <?php echo isset($user['country']) && $user['country'] == 1 ? 'selected' : '' ?>>Philippines</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Previous/Current job related to welding</label>
                        <select id="job" name="user_job" class="form-control select2" style="width: 100%;">
                            <optgroup label="Commercial Industry">
		                        <option value="1" <?php echo isset($user['user_job']) && $user['user_job'] == 1 ? 'selected' : '' ?>>Education</option>
		                        <option value="2" <?php echo isset($user['user_job']) && $user['user_job'] == 2 ? 'selected' : '' ?>>Research and Development</option>
		                        <option value="3" <?php echo isset($user['user_job']) && $user['user_job'] == 3 ? 'selected' : '' ?>>Design/Engineering</option>
		                        <option value="4" <?php echo isset($user['user_job']) && $user['user_job'] == 4 ? 'selected' : '' ?>>QA/QC</option>
		                        <option value="5" <?php echo isset($user['user_job']) && $user['user_job'] == 5 ? 'selected' : '' ?>>Production/Manufacturing</option>
		                        <option value="6" <?php echo isset($user['user_job']) && $user['user_job'] == 6 ? 'selected' : '' ?>>Sales</option>
		                        <option value="7" <?php echo isset($user['user_job']) && $user['user_job'] == 7 ? 'selected' : '' ?>>Maintenance</option>
		                        <option value="8" <?php echo isset($user['user_job']) && $user['user_job'] == 8 ? 'selected' : '' ?>>Skilled</option>
                            </optgroup>
                            <optgroup label="Military">
		                        <option value="9" <?php echo isset($user['user_job']) && $user['user_job'] == 9 ? 'selected' : '' ?>>Education</option>
		                        <option value="10" <?php echo isset($user['user_job']) && $user['user_job'] == 10 ? 'selected' : '' ?>>Design/Engineering</option>
		                        <option value="11" <?php echo isset($user['user_job']) && $user['user_job'] == 11 ? 'selected' : '' ?>>QA/QC</option>
		                        <option value="12" <?php echo isset($user['user_job']) && $user['user_job'] == 12 ? 'selected' : '' ?>>Production/Manufacturing</option>
		                        <option value="13" <?php echo isset($user['user_job']) && $user['user_job'] == 13 ? 'selected' : '' ?>>Sales</option>
		                        <option value="14" <?php echo isset($user['user_job']) && $user['user_job'] == 14 ? 'selected' : '' ?>>Maintenance</option>
		                        <option value="15" <?php echo isset($user['user_job']) && $user['user_job'] == 15 ? 'selected' : '' ?>>Skilled</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Field</label>
                        <select id="field" name="field" class="form-control select2" style="width: 100%;">
                            <option value="">-- Select a field --</option>
		                    <option value="1" <?php echo isset($user['field']) && $user['field'] == 1 ? 'selected' : '' ?>>Education</option>
		                    <option value="2" <?php echo isset($user['field']) && $user['field'] == 2 ? 'selected' : '' ?>>Engineering</option>
		                    <option value="3" <?php echo isset($user['field']) && $user['field'] == 3 ? 'selected' : '' ?>>Production</option>
		                    <option value="4" <?php echo isset($user['field']) && $user['field'] == 4 ? 'selected' : '' ?>>QA/QC</option>
		                    <option value="5" <?php echo isset($user['field']) && $user['field'] == 5 ? 'selected' : '' ?>>NDT</option>
		                    <option value="6" <?php echo isset($user['field']) && $user['field'] == 6 ? 'selected' : '' ?>>Sales</option>
		                    <option value="7" <?php echo isset($user['field']) && $user['field'] == 7 ? 'selected' : '' ?>> Maintenance</option>
                        </select>
                    </div>	
                    <div class="form-group">
                        <label>Skills</label>
                        <div class="indent">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill1" name="chk_skill[]"  value="1" <?php echo isset($user['skills']) && $user['skills'] == 1 ? 'checked' : '' ?>>
                                    Pressure Vessel
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill2" name="chk_skill[]"  value="2" <?php echo isset($user['skills']) && $user['skills'] == 2 ? 'checked' : '' ?>>
                                    Piping
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill3" name="chk_skill[]"  value="3" <?php echo isset($user['skills']) && $user['skills'] == 3 ? 'checked' : '' ?>>
                                    Tank
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill4" name="chk_skill[]"  value="4" <?php echo isset($user['skills']) && $user['skills'] == 4 ? 'checked' : '' ?>>
                                    Structural
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill5" name="chk_skill[]"  value="5" <?php echo isset($user['skills']) && $user['skills'] == 5 ? 'checked' : '' ?>>
                                    Aerospace
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill6" name="chk_skill[]"  value="6" <?php echo isset($user['skills']) && $user['skills'] == 6 ? 'checked' : '' ?>>
                                    Marine
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill7" name="chk_skill[]"  value="7" <?php echo isset($user['skills']) && $user['skills'] == 7 ? 'checked' : '' ?>>
                                    Machinery
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill8" name="chk_skill[]"  value="8" <?php echo isset($user['skills']) && $user['skills'] == 8 ? 'checked' : '' ?>>
                                    Automobile
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="chk_skill9" name="chk_skill[]"  value="9" <?php echo isset($user['skills']) && $user['skills'] == 9 ? 'checked' : '' ?>>
                                    Robotics
                                </label>
                            </div>
                        </div>
                    </div>	

                    <div class="form-group">
                        <label>Working abroad?</label>
                        <div class="indent">
                            <div class="radio">
                                <label>
                                    <input type="radio" id="working_abroad1" name="working_abroad" class="minimal" <?php echo isset($user['working_abroad']) && $user['working_abroad'] == 1 ? 'checked' : '' ?>>
                                    Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" id="working_abroad2" name="working_abroad" class="minimal" <?php echo isset($user['working_abroad']) && $user['working_abroad'] == 2 ? 'checked' : '' ?>>
                                    No
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="yrs">Number of years working</label>
                        <input type="number" class="form-control" id="yrs" name="yrs" placeholder="Enter Number of years working" value="<?php echo isset($user['yrs_working_abroad']) ? $user['yrs_working_abroad'] : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="name">Previous/Current work location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter previous/current work location" value="<?php echo isset($user['prev_work_loc']) ? $user['prev_work_loc'] : '' ?>">
                    </div>	

                    <div class="form-group">
                        <label>Certified/Licensed Qualification(s)?</label>
                        <div class="indent">
                            <div class="radio">
                                <label>
                                    <input type="radio" id="rad_certified" value="1" name="rad_certified" <?php echo isset($user['certified_qualification']) && $user['certified_qualification'] == 1 ? 'checked' : '' ?>>
                                    Certified Welding Inspector
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Membership</label>
                        <div class="indent">
                            International
                            <div class="indent">
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="international1" name="membership" value="1" name="membership[]" class="minimal" <?php echo isset($user['membership']) && $user['membership'] == 1 ? 'checked' : '' ?>>
                                        AWS
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="international2" name="membership" value="2" name="membership[]" class="minimal" <?php echo isset($user['membership']) && $user['membership'] == 2 ? 'checked' : '' ?>>
                                        TWI
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" id="international3" name="membership" value="3" name="membership[]" class="minimal" <?php echo isset($user['membership']) && $user['membership'] == 3 ? 'checked' : '' ?>>
                                        Others
                                    </label>
                                    <div class="indent">
                                        <label>Specify: </label>
                                        <input class="specify" type="text" name="international-others" id="international-others" />
                                    </div><br>
                                </div>
                            </div>
                            <br>
                            Local/National
                            <div class="indent">
                                <input type="radio" id="local" class="minimal" value="4" name="membership[]" <?php echo isset($user['membership']) && $user['membership'] == 4 ? 'checked' : '' ?>>
                                Specify: 
                                <input class="specify" type="text" name="local" id="local"/>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <!--<div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>-->
            </form>
        </div>
    </section>	
</div><!-- /.col (right) -->

