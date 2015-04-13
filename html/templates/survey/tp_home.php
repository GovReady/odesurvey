<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

<style>
	.controlsec {
		border:0px solid #eee; 
		margin: 12px 0px 0px 0px; 
	}

  .myeditable {
    height: 200px;
    width: 150%;
  }

  .myeditableshow {
  }

  h3 {
    border-bottom: 1px dotted #ddd;
    margin: 24px 0px 16px 0px;
  }

{
    width: 85%!important;
}

body {
  font-size: 11pt;
}

</style>

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

 <form id="survey_form" class="form-horizontal" action="/survey/opendata/<?php echo $content['surveyId']; ?>" method="post">

    <div class="row col-md-12 controlsec row-fluid" role="Intro">
      <div class="row col-md-12">
          <h3>Introduction</h3>
      </div>

      <div class="row col-md-8">
          <div>
            The Open Data Impact Map includes organizations that:
              <ul>
                  <li>are companies, non-profits, or developer communities</li>
                  <li>use open government data to develop products and services, or operations, and  strategy</li>
                </ul>
            <br />
            We define <i>open government data</i> as publicly available data that is produced or commissioned by governments 
            (or government-controlled entities) that can be accessed and reused by anyone, free of charge or at marginal cost. 
          </div>
        </div>

    </div><!--/Intro-->

    <div class="row col-md-9 controlsec" role="orgInfo">
     	<div class="row col-md-12">
     			<h3>Organization information</h3>
     	</div>

     	<div class="row col-md-12">
        <div class="form-group col-md-12">
          <div class="form-group col-md-7">
            <label for="org_name">Official organization name</label>
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="e.g., IBM Corporation" required minlength="2">
        </div>
        </div>
      </div>

      <div class="form-group col-md-12">
          <label class="control-label">What type of organization is it? (select 1)</label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_type" value="For-profit" /> For-profit
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" value="Nonprofit" /> Nonprofit
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" value="Developer community" /> Developer community
            </label>
          </div>
        </div>
      </div>


      <div class="form-group col-md-12">
      <div class="form-group col-md-7">
        <label for="org_url">Website URL of the organization</label>
        <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="http://" required>
      </div>
    </div>


    <div class="form-group col-md-12">
      <div class="form-group col-md-7">
        <label for="org_year_founded">Year founded</label>
        <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="e.g., 2004" required>
      </div>
    </div>

    <div class="form-group col-md-12">
      <div class="form-group col-md-8">
        <label for="org_description">Description of organization (400 characters or less) </label>
        <textarea type="text" class="form-control " id="org_description" name="org_description" style="height:160px; min-height:160px;  max-height:160px;" required></textarea>
      </div>
    </div>
    
    <!--div class="form-group">
      <label for="org_size_id">Number of employees (select 1)</label>
      <select class="form-control" name="org_size_id">
        <option value="0">Select</option>
        <option value="1">1-10</option>
        <option value="2">11-50</option>
        <option value="3">51-200</option>
        <option value="4">201-1000</option>
        <option value="5">1000+</option>
      </select>
    </div-->

    <div class="form-group col-md-12">
      <label class="control-label">Number of employees (select 1)</label>
      <div class="col-xs-9">
        <div class="btn-group" data-toggle="buttons">
          <label class="btn btn-default">
              <input type="radio" name="org_size_id" value="1 - 10" /> 1 - 10
          </label>
          <label class="btn btn-default">
              <input type="radio" name="org_size_id" value="11 - 50" /> 11 - 50
          </label>
          <label class="btn btn-default">
              <input type="radio" name="org_size_id" value="51 - 200" /> 51 - 200
          </label>
          <label class="btn btn-default">
              <input type="radio" name="org_size_id" value="201 - 1000" /> 201 - 1000
          </label>
          <label class="btn btn-default">
              <input type="radio" name="org_size_id" value="1000+" /> 1000+
          </label>
        </div>
      </div>
    </div>


    <div class="form-group col-md-12">
      <div class="form-group col-md-7">
      <label for="industry_id">Industry/category (select 1)</label>
        <select class="basic-single-industry required" name="industry_id" id="industry_id" style="width:336px;" >
          <option value="">Select</option>
          <option value="bus">Business &amp; legal services</option>
          <option value="cul">Culture/Leisure</option>
          <option value="dat">Data/Technology</option>
          <option value="edu">Education</option>
          <option value="ngy">Energy</option>
          <option value="env">Environment &amp; weather</option>
          <option value="fin">Finance &amp; investment</option>
          <option value="agr">Food &amp; agriculture</option>
          <option value="geo">Geospatial/Mapping</option>
          <option value="gov">Governance</option>
          <option value="hlt">Healthcare</option>
          <option value="est">Housing/Real estate</option>
          <option value="hum">Human rights</option>
          <option value="ins">Insurance</option>
          <option value="lif">Lifestyle &amp; consumer</option>
          <option value="med">Media &amp; communications</option>
          <option value="man">Mining/Manufacturing</option>
          <option value="rsh">Research &amp; consulting</option>
          <option value="sci">Scientific research</option>
          <option value="tel">Telecommunication/ISPs</option>
          <option value="trm">Tourism</option>
          <option value="trd">Trade &amp; commodities</option>
          <option value="trn">Transportation</option>
        </select>
      </div>
    </div>

    <div class="form-group col-md-12">
      <div class="form-group col-md-7 details">

        <label for="org_hq_city_all">City, State/Province, Country</label>
        <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all" required>

        <!--label for="org_hq_city">City</label -->
        <input type="hidden" class="form-control" id="org_hq_city" name="org_hq_city" required data-geo="locality">

        <!--label for="org_hq_st_prov">State/Province</label -->
        <input type="hidden" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" required data-geo="administrative_area_level_1">

        <!--label for="org_hq_country">Country</label -->
        <input type="hidden" class="form-control" id="org_hq_country" name="org_hq_country" required data-geo="country_short">

        <!--label for="latitude">lat</label -->
        <input type="hidden" class="form-control" id="latitude" name="latitude" required data-geo="lat">
        <!--label for="longitude">lng</label -->
        <input type="hidden" class="form-control" id="longitude" name="longitude" required data-geo="lng">
      </div>
    </div>


    </div><!--/OrgInfo-->

    <div class="col-md-9 controlsec" role="dataUse">
      <div class="row col-md-12" role="dataTypes">
        <h3>How Do You Use Open Government Data?</h3>

        <div>Please tell us what kinds of open government data are most relevant for your organization.<br />
          In each case tell us the country that supplies the data, and whether the data is local, regional or national.<br /><br /></div>
      </div>

<div>


</div>

    <div class="row col-md-12" id="dataUse">


      <div class="row col-md-12 data-use-row" id="dataUseHeading" style="border-bottom:1px solid #eee;">
        <div class="col-md-4">Relevant kind of data<br /><small>select one</small></div>
        <div class="col-md-5" id="data_type_col-1">

          <select name="data_type-1" id="data_type-1" class="js-example-basic-single data_type">
            <option value="">Select</option>
            <option value="Agriculture">Agriculture</option>
            <option value="Arts and culture">Arts and culture</option>
            <option value="Business">Business</option>
            <option value="Consumer">Consumer</option>
            <option value="Demographics and social">Demographics and social</option>
            <option value="Economics ">Economics</option>
            <option value="Education">Education</option>
            <option value="Energy">Energy</option>
            <option value="Environment">Environment</option>
            <option value="Finance">Finance</option>
            <option value="Geospatial/mapping">Geospatial/mapping</option>
            <option value="Government operations">Government operations</option>
            <option value="Health/healthcare">Health/healthcare</option>
            <option value="Housing">Housing</option>
            <option value="International/global development">International/global development</option>
            <option value="Legal">Legal</option>
            <option value="Manufacturing">Manufacturing</option>
            <option value="Science and research">Science and research</option>
            <option value="Public safety">Public safety</option>
            <option value="Tourism">Tourism</option>
            <option value="Transportation">Transportation</option>
            <option value="Weather">Weather</option>
            <option value="Other">Other</option>
          </select>

        </div>
      </div>

      <div class="row col-md-12" id="dataUseHeading" style="border-bottom:1px solid #eee;">
        <div class="col-md-4">From country supplying data<br /><small>select all that apply</small></div>
        <div class="col-md-5">

<select name="data_src_country_locode-1[]" class="country-basic-multiple" multiple="multiple">
<option value="AF">Afghanistan</option>
<option value="AX">Åland Islands</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option>
<option value="AO">Angola</option>
<option value="AI">Anguilla</option>
<option value="AQ">Antarctica</option>
<option value="AG">Antigua and Barbuda</option>
<option value="AR">Argentina</option>
<option value="AM">Armenia</option>
<option value="AW">Aruba</option>
<option value="AU">Australia</option>
<option value="AT">Austria</option>
<option value="AZ">Azerbaijan</option>
<option value="BS">Bahamas</option>
<option value="BH">Bahrain</option>
<option value="BD">Bangladesh</option>
<option value="BB">Barbados</option>
<option value="BY">Belarus</option>
<option value="BE">Belgium</option>
<option value="BZ">Belize</option>
<option value="BJ">Benin</option>
<option value="BM">Bermuda</option>
<option value="BT">Bhutan</option>
<option value="BO">Bolivia</option>
<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
<option value="BA">Bosnia and Herzegovina</option>
<option value="BW">Botswana</option>
<option value="BR">Brazil</option>
<option value="IO">British Indian Ocean Territory</option>
<option value="BN">Brunei Darussalam</option>
<option value="BG">Bulgaria</option>
<option value="BF">Burkina Faso</option>
<option value="BI">Burundi</option>
<option value="KH">Cambodia</option>
<option value="CM">Cameroon</option>
<option value="CA">Canada</option>
<option value="CV">Cape Verde</option>
<option value="KY">Cayman Islands</option>
<option value="CF">Central African Republic</option>
<option value="TD">Chad</option>
<option value="CL">Chile</option>
<option value="CN">China</option>
<option value="CX">Christmas Island</option>
<option value="CC">Cocos (Keeling) Islands</option>
<option value="CO">Colombia</option>
<option value="KM">Comoros</option>
<option value="CG">Congo</option>
<option value="CD">Congo, The Democratic Republic of the</option>
<option value="CK">Cook Islands</option>
<option value="CR">Costa Rica</option>
<option value="CI">Côte d'Ivoire</option>
<option value="HR">Croatia</option>
<option value="CU">Cuba</option>
<option value="CW">Curaçao</option>
<option value="CY">Cyprus</option>
<option value="CZ">Czech Republic</option>
<option value="DK">Denmark</option>
<option value="DJ">Djibouti</option>
<option value="DM">Dominica</option>
<option value="DO">Dominican Republic</option>
<option value="EC">Ecuador</option>
<option value="EG">Egypt</option>
<option value="SV">El Salvador</option>
<option value="GQ">Equatorial Guinea</option>
<option value="ER">Eritrea</option>
<option value="EE">Estonia</option>
<option value="ET">Ethiopia</option>
<option value="FK">Falkland Islands (Malvinas)</option>
<option value="FO">Faroe Islands</option>
<option value="FJ">Fiji</option>
<option value="FI">Finland</option>
<option value="FR">France</option>
<option value="GF">French Guiana</option>
<option value="PF">French Polynesia</option>
<option value="TF">French Southern Territories</option>
<option value="GA">Gabon</option>
<option value="GM">Gambia</option>
<option value="GE">Georgia</option>
<option value="DE">Germany</option>
<option value="GH">Ghana</option>
<option value="GI">Gibraltar</option>
<option value="GR">Greece</option>
<option value="GL">Greenland</option>
<option value="GD">Grenada</option>
<option value="GP">Guadeloupe</option>
<option value="GU">Guam</option>
<option value="GT">Guatemala</option>
<option value="GG">Guernsey</option>
<option value="GN">Guinea</option>
<option value="GW">Guinea-Bissau</option>
<option value="GY">Guyana</option>
<option value="HT">Haiti</option>
<option value="HM">Heard Island and McDonald Islands</option>
<option value="VA">Holy See (Vatican City State)</option>
<option value="HN">Honduras</option>
<option value="HK">Hong Kong</option>
<option value="HU">Hungary</option>
<option value="IS">Iceland</option>
<option value="IN">India</option>
<option value="ID">Indonesia</option>
<option value="XZ">Installations in International Waters</option>
<option value="IR">Iran, Islamic Republic of</option>
<option value="IQ">Iraq</option>
<option value="IE">Ireland</option>
<option value="IM">Isle of Man</option>
<option value="IL">Israel</option>
<option value="IT">Italy</option>
<option value="JM">Jamaica</option>
<option value="JP">Japan</option>
<option value="JE">Jersey</option>
<option value="JO">Jordan</option>
<option value="KZ">Kazakhstan</option>
<option value="KE">Kenya</option>
<option value="KI">Kiribati</option>
<option value="KP">Korea, Democratic People's Republic of</option>
<option value="KR">Korea, Republic of</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Lao People's Democratic Republic</option>
<option value="LV">Latvia</option>
<option value="LB">Lebanon</option>
<option value="LS">Lesotho</option>
<option value="LR">Liberia</option>
<option value="LY">Libya</option>
<option value="LI">Liechtenstein</option>
<option value="LT">Lithuania</option>
<option value="LU">Luxembourg</option>
<option value="MO">Macao</option>
<option value="MK">Macedonia, The former Yugoslav Republic of</option>
<option value="MG">Madagascar</option>
<option value="MW">Malawi</option>
<option value="MY">Malaysia</option>
<option value="MV">Maldives</option>
<option value="ML">Mali</option>
<option value="MT">Malta</option>
<option value="MH">Marshall Islands</option>
<option value="MQ">Martinique</option>
<option value="MR">Mauritania</option>
<option value="MU">Mauritius</option>
<option value="YT">Mayotte</option>
<option value="MX">Mexico</option>
<option value="FM">Micronesia, Federated States of</option>
<option value="MD">Moldova, Republic of</option>
<option value="MC">Monaco</option>
<option value="MN">Mongolia</option>
<option value="ME">Montenegro</option>
<option value="MS">Montserrat</option>
<option value="MA">Morocco</option>
<option value="MZ">Mozambique</option>
<option value="MM">Myanmar</option>
<option value="NA">Namibia</option>
<option value="NR">Nauru</option>
<option value="NP">Nepal</option>
<option value="NL">Netherlands</option>
<option value="NC">New Caledonia</option>
<option value="NZ">New Zealand</option>
<option value="NI">Nicaragua</option>
<option value="NE">Niger</option>
<option value="NG">Nigeria</option>
<option value="NU">Niue</option>
<option value="NF">Norfolk Island</option>
<option value="MP">Northern Mariana Islands</option>
<option value="NO">Norway</option>
<option value="OM">Oman</option>
<option value="PK">Pakistan</option>
<option value="PW">Palau</option>
<option value="PS">Palestine, State of</option>
<option value="PA">Panama</option>
<option value="PG">Papua New Guinea</option>
<option value="PY">Paraguay</option>
<option value="PE">Peru</option>
<option value="PH">Philippines</option>
<option value="PN">Pitcairn</option>
<option value="PL">Poland</option>
<option value="PT">Portugal</option>
<option value="PR">Puerto Rico</option>
<option value="QA">Qatar</option>
<option value="RE">Reunion</option>
<option value="RO">Romania</option>
<option value="RU">Russian Federation</option>
<option value="RW">Rwanda</option>
<option value="BL">Saint Barthélemy</option>
<option value="SH">Saint Helena, Ascension and Tristan Da Cunha</option>
<option value="KN">Saint Kitts and Nevis</option>
<option value="LC">Saint Lucia</option>
<option value="MF">Saint Martin (French Part)</option>
<option value="PM">Saint Pierre and Miquelon</option>
<option value="VC">Saint Vincent and the Grenadines</option>
<option value="WS">Samoa</option>
<option value="SM">San Marino</option>
<option value="ST">Sao Tome and Principe</option>
<option value="SA">Saudi Arabia</option>
<option value="SN">Senegal</option>
<option value="RS">Serbia</option>
<option value="SC">Seychelles</option>
<option value="SL">Sierra Leone</option>
<option value="SG">Singapore</option>
<option value="SX">Sint Maarten (Dutch Part)</option>
<option value="SK">Slovakia</option>
<option value="SI">Slovenia</option>
<option value="SB">Solomon Islands</option>
<option value="SO">Somalia</option>
<option value="ZA">South Africa</option>
<option value="GS">South Georgia and the South Sandwich Islands</option>
<option value="SS">South Sudan</option>
<option value="ES">Spain</option>
<option value="LK">Sri Lanka</option>
<option value="SD">Sudan</option>
<option value="SR">Suriname</option>
<option value="SJ">Svalbard and Jan Mayen</option>
<option value="SZ">Swaziland</option>
<option value="SE">Sweden</option>
<option value="CH">Switzerland</option>
<option value="SY">Syrian Arab Republic</option>
<option value="TW">Taiwan, Province of China</option>
<option value="TJ">Tajikistan</option>
<option value="TZ">Tanzania, United Republic of</option>
<option value="TH">Thailand</option>
<option value="TL">Timor-Leste</option>
<option value="TG">Togo</option>
<option value="TK">Tokelau</option>
<option value="TO">Tonga</option>
<option value="TT">Trinidad and Tobago</option>
<option value="TN">Tunisia</option>
<option value="TR">Turkey</option>
<option value="TM">Turkmenistan</option>
<option value="TC">Turks and Caicos Islands</option>
<option value="TV">Tuvalu</option>
<option value="UG">Uganda</option>
<option value="UA">Ukraine</option>
<option value="AE">United Arab Emirates</option>
<option value="GB">United Kingdom</option>
<option value="US">United States</option>
<option value="UM">United States Minor Outlying Islands</option>
<option value="UY">Uruguay</option>
<option value="UZ">Uzbekistan</option>
<option value="VU">Vanuatu</option>
<option value="VE">Venezuela</option>
<option value="VN">Viet Nam</option>
<option value="VG">Virgin Islands, British</option>
<option value="VI">Virgin Islands, U.S.</option>
<option value="WF">Wallis and Futuna</option>
<option value="EH">Western Sahara</option>
<option value="YE">Yemen</option>
<option value="ZM">Zambia</option>
<option value="ZW">Zimbabwe</option>
</select>

        </div>
      </div>

      <div class="row col-md-12" id="dataUseHeading" style="border-bottom:1px solid #eee;">
        <div class="col-md-4">From government level<br /><small>select all that apply</small></div>
        <div class="col-md-5">

<select name="data_src_gov_level-1[]" class="basic-multiple"  multiple="multiple" style="width:336px;">
  <option value="Federal">Federal</option>
  <option value="Regional">Regional</option>
  <option value="Local">Local</option>
</select>

        </div>
      </div>

      <br /><!-- new row -->

    </div> <!-- /dataUse row -->


      <div class="row col-md-12" style="margin: 12px 0px 0px 0px">
        <button class="btn btn-default btn-md" id="addDataUseBtn" type="">Add data use</button>
      </div>
    <br />
    <br />
    <div class="row col-md-12" role="dataPurposes">
      <label>
        What purpose does open data serve for your company or organization? - select all that apply
      </label>

      <div class="form-group col-md-12">
        <div class="form-group col-md-7">
          <div class="checkbox">
            <label> develop new products or services : 
              <input type="checkbox" name="use_prod_srvc" id="use_prod_srvc" value="True"> 
              <input type="text" class="form-control" id="use_prod_srvc_desc" name="use_prod_srvc_desc">
                
            </label>
          </div>

          <div class="checkbox">
            <label>
              <input type="checkbox" name="use_org_opt" id="use_prod" value="True">
              organizational optimization :
            </label>
          </div>
          <div>
            <input type="text" class="form-control" id="use_org_opt_desc" name="use_org_opt_desc">
          </div>

          <div class="checkbox">
            <label>
              <input type="checkbox" name="use_research" id="use_research" value="True">
              research :
            </label>
          </div>
          <div>
            <input type="text" class="form-control" id="use_research_desc" name="use_research_desc">
          </div>

          <div class="checkbox">
            <label>
              <input type="checkbox" name="use_other" id="use_other" value="True">
              other: 
            </label>
          </div>
          <div>
            <input type="text" class="form-control" id="use_other_desc" name="use_other_desc">
          </div>
    
          </div>
        </div>


    <div class="form-group col-md-12">
      <div class="form-group col-md-8">
        <label for="org_description">What is the most important way in which your company or organization has a positive impact, and how does open government data help you achieve it? (400 characters or less) </label>
          <textarea type="text" class="form-control" id="org_greatest_impact" name="org_greatest_impact" style="height:160px; min-height:160px;  max-height:160px;" required></textarea>
      </div>
    </div>

    <div class="" role="Contact">
      <div class="row col-md-12">
          <h3>Contact</h3>
      </div>

      <div class="">
        <div class="row col-md-7">
          <label for="survey_contact_name">Your full name</label>
          <input type="text" class="form-control" id="survey_contact_name" name="survey_contact_name" required>

          <label for="survey_contact_title">Your title at organization</label>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title" required>

          <label for="survey_contact_email">Your email</label>
          <input type="email" class="form-control" id="survey_contact_email" name="survey_contact_email" required>

          <input type="hidden" class="form-control" id="org_profile_year" name="org_profile_year" value="2015">
          <input type="hidden" class="form-control" id="org_profile_status" name="org_profile_status" value="submitted">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_src" value="survey">
        </div>
        
        <div>
          <div class="row col-md-7"><br />
            <button class="btn btn-primary col-md-3" id="btnSubmit" type="submit">SEND</button>
          </div>
        </div>

      </div>
      
    </div>

</div><!--/???? closes data purpose this should close datause tag - something must be wrong with data grid-->
</div><!-- /closes data use -->
</div><!-- /closes comtainer  -->

</form>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

