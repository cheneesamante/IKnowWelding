<!-- Start Client Section -->
<!--<div class="client section" style="background: radial-gradient(ellipse, #214893, #0b2757), #01266c">-->
<div class="client" style="background: radial-gradient(ellipse, #214893, #0b2757), #01266c">
    <div class="container">
        <!-- Start Heading -->
        <!--<div class="heading">
                <div class="section-title"></div>
        </div>-->
        <!-- End Heading -->
        <!-- Some Text -->
        <!--        <div class="profile-header description text-center">
                    <h1>CREATE A PROFILE</h1>
                </div>-->
        <div id="register"> 
            <!--<form id="form-reg" data-parsley-validate>-->
            <form id="form-reg" method="post" action="<?php echo site_url('admin/register/save'); ?>">
                <label for="first_name">First Name</label>
                <input  data-parsley-trigger="change" type="text" value="<?php echo set_value('first_name'); ?>" id="first_tname" name="first_name">
                <?php echo form_error('first_name'); ?>
                <label for="middle_name">Middle Name</label>
                <input  data-parsley-trigger="change" type="text" value="<?php echo set_value('middle_name'); ?>" id="middle_tname" name="middle_name">
                <?php echo form_error('middle_name'); ?>
                <label for="last_tname">Last Name</label> 
                <input  data-parsley-trigger="change" type="text" value="<?php echo set_value('last_name'); ?>" id="last_tname" name="last_name">

                <label for="birthdate">Birthdate</label>
                <input class="form-control" data-parsley-trigger="change" value="<?php echo set_value('birthdate'); ?>" type="date" name="birthdate" id="birthdate">

                <label for="gender">Gender</label>
                <div class="gender-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="male" value="1" <?php echo set_radio('male', '1', TRUE); ?> name="gender" >
                        <label for="male" class="light">Male</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="female" value="2"  <?php echo set_radio('female', '1'); ?> name="gender">
                        <label for="female" class="light">Female</label>
                    </div>
                </div>
                <br/>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" data-parsley-trigger="change" >

                <label for="email">Email</label>
                <input type="email" id="email_address" value="<?php echo set_value('email_address'); ?>" name="email_address" data-parsley-trigger="change" >
                <?php echo form_error('email_address'); ?>
                <label for="country">Country</label>
                <select id="country" name="country" data-parsley-trigger="change" >
                    <option value="">-- Select a country --</option>
                    <option value="1">Philippines</option>
                </select>

                <label for="job">Previous/Current job related to welding</label>
                <select id="user_job" name="user_job" data-parsley-trigger="change" >
                    <option value="" <?php echo set_select('user_job', '', true); ?>>-- Select a field --</option>
                    <optgroup label="Commercial Industry">
                        <option value="1" <?php echo set_select('user_job', '1'); ?>>Education</option>
                        <option value="2" <?php echo set_select('user_job', '2'); ?>>Research and Development</option>
                        <option value="3" <?php echo set_select('user_job', '3'); ?>>Design/Engineering</option>
                        <option value="4" <?php echo set_select('user_job', '4'); ?>>QA/QC</option>
                        <option value="5" <?php echo set_select('user_job', '5'); ?>>Production/Manufacturing</option>
                        <option value="6" <?php echo set_select('user_job', '6'); ?>>Sales</option>
                        <option value="7" <?php echo set_select('user_job', '7'); ?>>Maintenance</option>
                        <option value="8" <?php echo set_select('user_job', '8'); ?>>Skilled</option>
                    </optgroup>
                    <optgroup label="Military">
                        <option value="9" <?php echo set_select('user_job', '9'); ?>>Education</option>
                        <option value="10" <?php echo set_select('user_job', '10'); ?>>Design/Engineering</option>
                        <option value="11" <?php echo set_select('user_job', '11'); ?>>QA/QC</option>
                        <option value="12" <?php echo set_select('user_job', '12'); ?>>Production/Manufacturing</option>
                        <option value="13" <?php echo set_select('user_job', '13'); ?>>Sales</option>
                        <option value="14" <?php echo set_select('user_job', '14'); ?>>Maintenance</option>
                        <option value="15">Skilled</option>
                    </optgroup>
                </select>

                <label for="field">Field</label>
                <select id="field" name="field" data-parsley-trigger="change" >
                    <option value="" <?php echo set_select('field', '', true); ?>>-- Select a field --</option>
                    <option value="1" <?php echo set_select('field', '1'); ?>>Education</option>
                    <option value="2" <?php echo set_select('field', '2'); ?>>Engineering</option>
                    <option value="3" <?php echo set_select('field', '3'); ?>>Production</option>
                    <option value="4" <?php echo set_select('field', '4'); ?>>QA/QC</option>
                    <option value="5" <?php echo set_select('field', '5'); ?>>NDT</option>
                    <option value="6" <?php echo set_select('field', '6'); ?>>Sales</option>
                    <option value="7" <?php echo set_select('field', '7'); ?>> Maintenance</option>
                </select>

                <label for="skills">Skills</label>
                <div><input type="checkbox" id="chk_skill1" name="skills[]" value="1" <?php echo set_checkbox('skills', '1', true); ?> data-parsley-mincheck="1" ><label for="chk_skill1" class="light">Pressure Vessel</label></div>
                <div><input type="checkbox" id="chk_skill2" name="skills[]" value="2" <?php echo set_checkbox('skills', '2'); ?>><label for="chk_skill2" class="light">Piping</label></div>
                <div><input type="checkbox" id="chk_skill3" name="skills[]" value="3" <?php echo set_checkbox('skills', '3'); ?>><label for="chk_skill3" class="light">Tank</label></div>
                <div><input type="checkbox" id="chk_skill4" name="skills[]" value="4" <?php echo set_checkbox('skills', '4'); ?>><label for="chk_skill4" class="light">Structural</label></div>
                <div><input type="checkbox" id="chk_skill5" name="skills[]" value="5" <?php echo set_checkbox('skills', '5'); ?>><label for="chk_skill5" class="light">Aerospace</label></div>
                <div><input type="checkbox" id="chk_skill6" name="skills[]" value="6" <?php echo set_checkbox('skills', '6'); ?>><label for="chk_skill6" class="light">Marine</label></div>
                <div><input type="checkbox" id="chk_skill7" name="skills[]" value="7" <?php echo set_checkbox('skills', '7'); ?>><label for="chk_skill7" class="light">Machinery</label></div>
                <div><input type="checkbox" id="chk_skill8" name="skills[]" value="8" <?php echo set_checkbox('skills', '8'); ?>><label for="chk_skill8" class="light">Automobile</label></div>
                <div><input type="checkbox" id="chk_skill9" name="skills[]" value="9" <?php echo set_checkbox('skills', '9'); ?>><label for="chk_skill9" class="light">Robotics</label></div><br>

                <label for="abroad">Working abroad?</label>
                <div class="working-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="yes_working" value="1" <?php echo set_radio('working_abroad', '1'); ?> name="working_abroad" >
                        <label for="yes_working" class="light">Yes</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="no_working" value="2" <?php echo set_radio('working_abroad', '2'); ?> name="working_abroad">
                        <label for="no_working" class="light">No</label>
                    </div>
                </div>
                <br/>
                <label for="yrs">Number of years working</label>
                <input type="number" data-parsley-trigger="change" value="<?php echo set_value('number'); ?>" id="yrs_working_abroad" name="yrs_working_abroad" />

                <label for="location">Previous/Current work location</label>
                <input type="text" id="prev_work_loc" value="<?php echo set_value('prev_work_loc'); ?>" name="prev_work_loc" />

                <label for="license">Certified/Licensed Qualification(s)</label>
                <div><input type="checkbox" id="certified_qualification" value="<?php echo set_value('certified_qualification'); ?>" name="certified_qualification" class="with-font" /><label for="certified_qualification" class="light">Certified Welding Inspector</label></div><br>

                <label for="membership">Membership</label>
                <label for="international" class="indent">International</label>
                <div class="indent-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="international1" value="1" <?php echo set_radio('membership', '1'); ?> name="membership[]" >
                        <label for="international1" class="light">AWS</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="international2" value="2" <?php echo set_radio('membership', '2'); ?> name="membership[]">
                        <label for="international2" class="light">TWI</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="international3" value="3" <?php echo set_radio('membership', '3'); ?> name="membership[]">
                        <label for="international3" class="light">Others</label>
                    </div>
                    <div class="indent-choices">
                        <label for="" class="light">Specify:</label>
                        <input type="text" name="international_others" id="international_others"  value="<?php echo set_value('international_others'); ?>" />
                    </div>
                    <br>
                </div>
                <label for="local" class="indent">Local/National</label>
                <div class="indent-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="local" value="4"  <?php echo set_radio('membership', '4'); ?> name="membership[]">

                        <label for="local" class="light">Specify:</label>
                        <input type="text" name="local_others"  id="local_others" value="<?php echo set_value('local_others'); ?>" /></div><br>
                </div>
                <br/>
                <div class="text-center">By clicking Sign up, you agree to IknowWelding's <a>User Agreement</a> and <a>Privacy Policy</a>.</div>
                <div class="text-center">
                    <br/>
                    <button id="submit" class="btn btn-signup-form" type="submit" style="pointer-events: all; cursor: pointer;">
                        <i class="fa fa-arrow-circle-right"></i> SIGN UP
                    </button>
                </div>
                <br/>

            </form>
        </div>
    </div>
</div>
</div>
<!-- End Client Section -->