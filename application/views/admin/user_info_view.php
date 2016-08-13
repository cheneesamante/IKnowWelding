<script>

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
                    <form role="form">
                      <div class="box-body">
                        <div class="form-group">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input type="text" class="form-control" id="surname" placeholder="Enter Surname">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select id="country" name="country" class="form-control select2" style="width: 100%;">
                                <option selected="selected">Philippines</option>
                                <option value="">-- Select a country --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Previous/Current job related to welding</label>
                            <select id="job" name="user_job" class="form-control select2" style="width: 100%;">
                                <optgroup label="Commercial Industry">
                                    <option value="">Education</option>
                                    <option value="">Research and Development</option>
                                    <option value="">Design/Engineering</option>
                                    <option value="">QA/QC</option>
                                    <option value="">Production/Manufacturing</option>
                                    <option value="">Sales</option>
                                    <option value="">Maintenance</option>
                                    <option value="">Skilled</option>
                                </optgroup>
                                <optgroup label="Military">
                                    <option value="">Education</option>
                                    <option value="">Design/Engineering</option>
                                    <option value="">QA/QC</option>
                                    <option value="">Production/Manufacturing</option>
                                    <option value="">Sales</option>
                                    <option value="">Maintenance</option>
                                    <option value="">Skilled</option>
                                </optgroup>
                            </select>
                          
                        </div>
			<div class="form-group">
                            <label>Field</label>
                            <select id="field" name="field" class="form-control select2" style="width: 100%;">
                                <option value="">-- Select a field --</option>
                                <option value="">Education</option>
                                <option value="">Engineering</option>
                                <option value="">Production</option>
                                <option value="">QA/QC</option>
                                <option value="">NDT</option>
                                <option value="">Sales</option>
                                <option value=""> Maintenance</option>
                            </select>
                        </div>	
			<div class="form-group">
                            <label>Skills</label>
                            <div class="indent">
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="chk_skill1" name="chk_skill[]">
                                      Pressure Vessel
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="chk_skill2" name="chk_skill[]">
                                      Piping
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="chk_skill3" name="chk_skill[]">
                                      Tank
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="chk_skill4" name="chk_skill[]">
                                      Structural
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="chk_skill5" name="chk_skill[]">
                                      Aerospace
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="chk_skill6" name="chk_skill[]">
                                      Marine
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                       <input type="checkbox" id="chk_skill7" name="chk_skill[]">
                                       Machinery
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="chk_skill8" name="chk_skill[]">
                                        Automobile
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                         <input type="checkbox" id="chk_skill9" name="chk_skill[]">
                                         Robotics
                                    </label>
                                </div>
                            </div>
                        </div>	
                          
                        <div class="form-group">
                            <label for="name">Number of years working</label>
                            <input type="text" class="form-control" id="yrs" placeholder="Enter Number of years working">
                        </div>
                        
                        <div class="form-group">
                            <label>Working abroad?</label>
                            <div class="indent">
                                <div class="radio">
                                  <label>
                                    <input type="radio" id="rad_abroad_yes" name="rad_abroad" class="minimal" checked>
                                    Yes
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <input type="radio" id="rad_abroad_no" name="rad_abroad" class="minimal">
                                    No
                                  </label>
                                </div>
                            </div>
                        </div>

			<div class="form-group">
                            <label for="name">Previous/Current work location</label>
                            <input type="text" class="form-control" id="location" placeholder="Enter previous/current work location">
                        </div>	
                        
                        <div class="form-group">
                            <label>Certified/Licensed Qualification(s)?</label>
                            <div class="indent">
                                <div class="radio">
                                  <label>
                                    <input type="radio" id="rad_certified" name="rad_certified">
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
                                        <input type="radio" id="international1" name="membership" class="minimal" checked>
                                        AWS
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" id="international2" name="membership" class="minimal">
                                        TWI
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" id="international3" name="membership" class="minimal">
                                        Others
                                      </label>
                                      <div class="indent">
                                        <label>Specify: </label>
                                        <input class="specify" type="text" name="" required="true" id="international-others" />
                                      </div><br>
                                    </div>
                                </div>
                                <br>
                                Local/National
                                <div class="indent">
                                    <input type="radio" id="local" name="membership" class="minimal" checked>
                                    Specify: 
                                    <input class="specify" type="text" name="" required="true" id="local"/>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>
                </section>	
                </div><!-- /.col (right) -->
   
