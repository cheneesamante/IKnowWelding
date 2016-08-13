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
			<form>
				<label for="name">First Name</label>
				<input type="text" id="name" name="user_name">
          
				<label for="surname">Surname</label>
				<input type="text" id="surname" name="surname">
				
				<label for="email">Email</label>
				<input type="email" id="email" name="email">
          
				<label for="country">Country</label>
				<select id="country" name="country">
					<option value="">-- Select a country --</option>
					<option value="">Philippines</option>
				</select>
			
				<label for="job">Previous/Current job related to welding</label>
				<select id="job" name="user_job">
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
				
				<label for="field">Field</label>
				<select id="field" name="field">
					<option value="">-- Select a field --</option>
					<option value="">Education</option>
					<option value="">Engineering</option>
					<option value="">Production</option>
					<option value="">QA/QC</option>
					<option value="">NDT</option>
					<option value="">Sales</option>
					<option value=""> Maintenance</option>
				</select>

				<label for="skills">Skills</label>
				<div><input type="checkbox" id="chk_skill1" name="chk_skill[]"><label for="chk_skill1" class="light">Pressure Vessel</label></div>
				<div><input type="checkbox" id="chk_skill2" name="chk_skill[]"><label for="chk_skill2" class="light">Piping</label></div>
				<div><input type="checkbox" id="chk_skill3" name="chk_skill[]"><label for="chk_skill3" class="light">Tank</label></div>
				<div><input type="checkbox" id="chk_skill4" name="chk_skill[]"><label for="chk_skill4" class="light">Structural</label></div>
				<div><input type="checkbox" id="chk_skill5" name="chk_skill[]"><label for="chk_skill5" class="light">Aerospace</label></div>
				<div><input type="checkbox" id="chk_skill6" name="chk_skill[]"><label for="chk_skill6" class="light">Marine</label></div>
				<div><input type="checkbox" id="chk_skill7" name="chk_skill[]"><label for="chk_skill7" class="light">Machinery</label></div>
				<div><input type="checkbox" id="chk_skill8" name="chk_skill[]"><label for="chk_skill8" class="light">Automobile</label></div>
				<div><input type="checkbox" id="chk_skill9" name="chk_skill[]"><label for="chk_skill9" class="light">Robotics</label></div><br>
          
				<label for="yrs">Number of years working</label>
				<input type="text" id="yrs" name="yrs">
				
  
				<label for="abroad">Working abroad?</label>
				<div><input type="radio" id="rad_abroad_yes" class="with-font" value="" name="rad_abroad"><label for="rad_abroad_yes" class="light">Yes</label></div>
				<div><input type="radio" id="rad_abroad_no"  class="with-font" value="" name="rad_abroad"><label for="rad_abroad_no" class="light">No</label></div><br>
				
				<label for="location">Previous/Current work location</label>
				<input type="text" id="location" name="location">
								
				<label for="license">Certified/Licensed Qualification(s)</label>
				<div><input type="checkbox" id="rad_certified" value="" name="rad_certified" class="with-font"><label for="rad_certified" class="light">Certified Welding Inspector</label></div><br>

				<label for="membership">Membership</label>
				<label for="international" class="indent">International</label>
				<div class="indent-choices">
					<div><input type="radio" class="with-font indent" id="international1" value="" name="membership"><label for="international1" class="light">AWS</label></div>
					<div><input type="radio" class="with-font indent" id="international2" value="" name="membership"><label for="international2" class="light">TWI</label></div>
					<div><input type="radio" class="with-font indent" id="international3" value="" name="membership"><label for="international3" class="light">Others</label></div>
                    <div class="indent-choices">
                        <label for="" class="light">Specify:</label>
                        <input type="text" name="" required="true" id="international-others" />
                    </div><br>
				</div>
				<label for="local" class="indent">Local/National</label>
				<div class="indent-choices">
					<div><input type="radio" class="with-font indent" id="local" value="" name="membership"><label for="local" class="light">Specify:</label>
                    <input type="text" name="" required="true" id="local"/></div><br>
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