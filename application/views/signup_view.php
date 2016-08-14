<!-- Start Client Section -->
<div class="client section" style="background: radial-gradient(ellipse, #214893, #0b2757), #01266c">
    <div class="container">
        <!-- Start Heading -->
        <!--<div class="heading">
                <div class="section-title"></div>
        </div>-->
        <!-- End Heading -->
        <!-- Some Text -->
        <div class="profile-header description text-center">
            <h1>CREATE A PROFILE</h1>
        </div>
        <div id="register">
            <form id="form-reg" data-parsley-validate>
                <label for="first_name">First Name</label>
                <input required="required" data-parsley-trigger="change" type="text" id="first_tname" name="first_name">

                <label for="middle_name">Middle Name</label>
                <input required="required" data-parsley-trigger="change" type="text" id="middle_tname" name="middle_name">

                <label for="last_tname">Last Name</label>
                <input required="required" data-parsley-trigger="change" type="text" id="last_tname" name="last_name">

                <label for="birthdate">Birthdate</label>
                <input class="form-control" data-parsley-trigger="change" type="date" name="birthdate" id="birthdate">

                <label for="gender">Gender</label>
                <div class="gender-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="male" value="1" name="gender" required="required">
                        <label for="male" class="light">Male</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="female" value="2" name="gender">
                        <label for="female" class="light">Female</label>
                    </div>
                </div>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" data-parsley-trigger="change" required="required">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" data-parsley-trigger="change" required="required">

                <label for="country">Country</label>
                <select id="country" name="country" data-parsley-trigger="change" required="required">
                    <option value="">-- Select a country --</option>
                    <option value="1">Philippines</option>
                </select>

                <label for="job">Previous/Current job related to welding</label>
                <select id="job" name="user_job" data-parsley-trigger="change" required="required">
                    <optgroup label="Commercial Industry">
                        <option value="1">Education</option>
                        <option value="2">Research and Development</option>
                        <option value="3">Design/Engineering</option>
                        <option value="4">QA/QC</option>
                        <option value="5">Production/Manufacturing</option>
                        <option value="6">Sales</option>
                        <option value="7">Maintenance</option>
                        <option value="8">Skilled</option>
                    </optgroup>
                    <optgroup label="Military">
                        <option value="1">Education</option>
                        <option value="2">Design/Engineering</option>
                        <option value="3">QA/QC</option>
                        <option value="4">Production/Manufacturing</option>
                        <option value="5">Sales</option>
                        <option value="6">Maintenance</option>
                        <option value="7">Skilled</option>
                    </optgroup>
                </select>

                <label for="field">Field</label>
                <select id="field" name="field" data-parsley-trigger="change" required="required">
                    <option value="">-- Select a field --</option>
                    <option value="1">Education</option>
                    <option value="2">Engineering</option>
                    <option value="3">Production</option>
                    <option value="4">QA/QC</option>
                    <option value="5">NDT</option>
                    <option value="6">Sales</option>
                    <option value="7"> Maintenance</option>
                </select>

                <label for="skills">Skills</label>
                <div><input type="checkbox" id="chk_skill1" name="chk_skill[]" value="1" data-parsley-mincheck="1" required="required"><label for="chk_skill1" class="light">Pressure Vessel</label></div>
                <div><input type="checkbox" id="chk_skill2" name="chk_skill[]" value="2"><label for="chk_skill2" class="light">Piping</label></div>
                <div><input type="checkbox" id="chk_skill3" name="chk_skill[]" value="3"><label for="chk_skill3" class="light">Tank</label></div>
                <div><input type="checkbox" id="chk_skill4" name="chk_skill[]" value="4" ><label for="chk_skill4" class="light">Structural</label></div>
                <div><input type="checkbox" id="chk_skill5" name="chk_skill[]" value="5" ><label for="chk_skill5" class="light">Aerospace</label></div>
                <div><input type="checkbox" id="chk_skill6" name="chk_skill[]" value="6"><label for="chk_skill6" class="light">Marine</label></div>
                <div><input type="checkbox" id="chk_skill7" name="chk_skill[]" value="7"><label for="chk_skill7" class="light">Machinery</label></div>
                <div><input type="checkbox" id="chk_skill8" name="chk_skill[]" value="8"><label for="chk_skill8" class="light">Automobile</label></div>
                <div><input type="checkbox" id="chk_skill9" name="chk_skill[]" value="9"><label for="chk_skill9" class="light">Robotics</label></div><br>

                <label for="abroad">Working abroad?</label>
                <div class="working-abroad-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="working_abroad1" value="1" name="working_abroad">
                        <label for="yes" class="light">Yes</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="working_abroad2" value="2" name="working_abroad">
                        <label for="no" class="light">No</label>
                    </div>
                </div>
                <label for="yrs">Number of years working</label>
                <input type="number" data-parsley-trigger="change" required="required" id="yrs" name="yrs">

                <label for="location">Previous/Current work location</label>
                <input type="text" id="location" name="location">

                <label for="license">Certified/Licensed Qualification(s)</label>
                <div><input type="checkbox" id="rad_certified" value="1" name="rad_certified" class="with-font"><label for="rad_certified" class="light">Certified Welding Inspector</label></div><br>

                <label for="membership">Membership</label>
                <label for="international" class="indent">International</label>
                <div class="indent-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="international1" value="1" name="membership[]" required="required">
                        <label for="international1" class="light">AWS</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="international2" value="2" name="membership[]">
                        <label for="international2" class="light">TWI</label>
                    </div>
                    <div>
                        <input type="radio" class="with-font indent" id="international3" value="3" name="membership[]">
                        <label for="international3" class="light">Others</label>
                    </div>
                    <div class="indent-choices">
                        <label for="" class="light">Specify:</label>
                        <input type="text" name="" id="international-others"/>
                    </div>
                    <br>
                </div>
                <label for="local" class="indent">Local/National</label>
                <div class="indent-choices">
                    <div>
                        <input type="radio" class="with-font indent" id="local" value="" name="membership[]">

                        <label for="local" class="light">Specify:</label>
                        <input type="text" name=""  id="local-others"/></div><br>
                </div>

                <button id="submit" class="btn btn-signup-form" type="submit" style="pointer-events: all; cursor: pointer;">
                    <i class="fa fa-check"></i>
                    SIGN UP
                </button>

            </form>
        </div>
    </div>
</div>
</div>
<!-- End Client Section -->

<!-- For other status alert -->
<div id="alert-status" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                    <h4 id="alert-modal-title" class="modal-title">Change User Status</h4>
                </div>
                <div class="modal-body">
                    <div id="user-info-alert-msg"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-default" onclick="javascript:refresh_page()">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>
