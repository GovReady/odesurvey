<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

 <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/map/survey/2du/<?php echo $content['surveyId']; ?>" method="post">

    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
        Thank you for participating in the Open Data Impact Map, the first centralized, searchable database of open data use cases from around the world. 
        Your contribution makes it possible to better understand the value of open data and encourage its use globally.
        Information collected will be displayed on the <a href="http://opendataenterprise.org/map/viz">Map</a> and will be made available as open data.
      </div>
      <br />
    </div>
     
    <div class="col-md-12" role="eligibility" id="role-eligibility">
      <div class="row col-md-12">
        <h4>ELIGIBILITY</h4>
      </div>
      <div>
        <b>The Open Data Impact Map includes organizations that:</b>
          <ul>
              <li>are companies, non-profits, or developer groups; and</li>
              <li>use open government data for advocacy, to develop products and services, improve operations, inform strategy and/or conduct research.</li>
            </ul>
        We define open government data as publicly available data that is produced or commissioned by governments 
        and that can be accessed and reused by anyone, free of charge. 
      </div>
    </div>

<br />

    <div class="col-md-12" role="orgInfo-titlebar"  id="role-orgInfo-titlebar">
      <div class="section-title"><h3>1. Organizational Information</h3></div>
    </div>

    <div class="col-md-12" role="orgInfo"  id="role-orgInfo">
      <!-- Name of organization -->
      <div class="row col-md-12">
        <div class="form-group col-md-12">
          <div class="form-group col-md-10">
            <label for="org_name">Name of organization<small class="required">*</small></label>
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2">
        </div>
        </div>
      </div>

      <!-- Description of organization -->
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_description">One sentence description of organization <small class="required">(400 characters or less)*</small></label>
          <textarea type="text" class="form-control " id="org_description" name="org_description" required></textarea>
        </div>
      </div>

      <!-- Type of organization -->
      <div class="form-group col-md-12" id="org_type">
          <label for="org_type">Type of organization<small class="required">*</small></label>
        <div class="col-md-10">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="For-profit" value="For-profit" required="True"> For-profit
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Nonprofit" value="Nonprofit"> Nonprofit
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Developer group" value="Developer group"> Developer group
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_type" id="Other" value="Other"> Other
            </label>
          </div>
        </div>
      </div>

      <!-- Website URL -->
      <div class="form-group col-md-12">
        <label for="org_url">Website URL</label>
        <div class="row">      
            <div class="col-md-8">
              <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="http://">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="no_org_url" id="no_org_url" value="True"> No URL
            </div>
        </div>
      </div>

      <!-- Location -->  
      <div class="form-group col-md-12">
        <div class="form-group col-md-10 details">

          <label for="org_hq_city_all">Location <small class="required">(Please provide as specific as possible)*</small></label>
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
  
      <!-- Industry/category of organization -->
      <div class="form-group col-md-12">
        <label for="industry_id">Industry/category of the organization <small class="required">(select 1)*</small></label>
        <fieldset>
        <div class="col-md-4" id="industry_id_col-1">
          <input type="radio" name="industry_id" class="industry_id" value="agr">&nbsp; Agriculture
          <br /><input type="radio" name="industry_id" class="industry_id" value="art">&nbsp; Arts and culture
          <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="bus" required> Business &amp; legal services
          <br /><input type="radio" name="industry_id" class="industry_id" value="con">&nbsp; Consumer services
          <br /><input type="radio" name="industry_id" class="industry_id" value="dat">&nbsp; Data/information technology
          <br /><input type="radio" name="industry_id" class="industry_id" value="edu">&nbsp; Education
          <br /><input type="radio" name="industry_id" class="industry_id" value="ngy">&nbsp; Energy
          <br /><input type="radio" name="industry_id" class="industry_id" value="env">&nbsp; Environment
          <br /><input type="radio" name="industry_id" class="industry_id" value="fin">&nbsp; Finance and investment
        </div>
        <div class="col-md-4" id="industry_id_col-2">
          <input type="radio" name="industry_id" class="industry_id" value="geo">&nbsp; Geospatial/mapping
          <br /><input type="radio" name="industry_id" class="industry_id" value="gov">&nbsp; Governance
          <br /><input type="radio" name="industry_id" class="industry_id" value="hlt">&nbsp; Healthcare
          <br /><input type="radio" name="industry_id" class="industry_id" value="est">&nbsp; Housing and real estate
          <br /><input type="radio" name="industry_id" class="industry_id" value="ins">&nbsp; Insurance
          <br /><input type="radio" name="industry_id" class="industry_id" value="med">&nbsp; Media and communications
          <br /><input type="radio" name="industry_id" class="industry_id" value="man">&nbsp; Mining/Manufacturing
          <br /><input type="radio" name="industry_id" class="industry_id" value="rsh">&nbsp; Research and consulting
          <br /><input type="radio" name="industry_id" class="industry_id" value="sec">&nbsp; Security and public safety
        </div>
        <div class="col-md-4" id="industry_id_col-3">
          <input type="radio" name="industry_id" class="industry_id" value="sci">&nbsp; Scientific research
          <br /><input type="radio" name="industry_id" class="industry_id" value="tel">&nbsp; Telecommunications/internet service providers (ISPs)
          <br /><input type="radio" name="industry_id" class="industry_id" value="trm">&nbsp; Tourism
          <br /><input type="radio" name="industry_id" class="industry_id" value="trn">&nbsp; Transportation and logistics
          <br /><input type="radio" name="industry_id" class="industry_id" value="wat">&nbsp; Water and sanitation
          <br /><input type="radio" name="industry_id" class="industry_id" value="wea">&nbsp; Weather
          <br /><input type="radio" name="industry_id" class="industry_id" value="otr">&nbsp; Other
                <input type="text" class="form-control" style="display:none" name="industry_other" placeholder="Describe other">
        </div>
        </fieldset>
      </div>

      <!-- Founding year -->    
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_year_founded">Founding year<small class="required">*</small></label>
          <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required>
        </div>
      </div>

      <!-- Size -->
      <div class="form-group col-md-12">
        <label for="org_size_id">Size<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="1-10"> 1-10 employees
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="11-50"> 11-50 employees
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="51-200"> 51-200 employees
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="201-1000"> 201-1000 employees
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_size_id" value="1000+"> 1000+ employees
            </label>
          </div>
        </div>
      </div>

      <!-- What is the greatest type of impact your organization has? -->
      <div class="form-group col-md-12" id="org_greatest_impact">
          <label for="org_greatest_impact">What is the greatest type of impact your organization has?<small class="required">*</small></label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Economic" value="Economic" /> Economic
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Environmental" value="Environmental" /> Environmental
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Governance" value="Governance" /> Governance
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Social" value="Social" /> Social
            </label>
            <label class="btn btn-default">
                <input type="radio" name="org_greatest_impact" id="Other" value="Other" /> Other
            </label>
          </div>
        </div>
      </div>
    </div><!--/OrgInfo-->

<br />

    <div class="col-md-12" role="dataUse-titlebar"  id="role-dataUse-titlebar">
      <div class="section-title"><h3>2. Use of Open Data</h3></div>
    </div>

    <div class="col-md-12" role="dataUse" id="role-dataUse">
      
      <div class="row col-md-12 data-use-row" id="dataUseDataType">
        <label for="data_use_type[]">Types of <u>most relevant</u> open data your organization uses <small class="required">(select all that apply)*</small></label>
        <div class="col-md-4" id="data_type_col-1">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" required>&nbsp; Agriculture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture">&nbsp; Arts and culture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business">&nbsp; Business
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer">&nbsp; Consumer
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographics and social">&nbsp; Demographics and social
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics ">&nbsp; Economics
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education">&nbsp; Education
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy">&nbsp; Energy
        </div>
        <div class="col-md-4" id="data_type_col-2">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment">&nbsp; Environment
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance">&nbsp; Finance
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial/mapping">&nbsp; Geospatial/mapping
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations">&nbsp; Government operations
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare">&nbsp; Health/healthcare
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing">&nbsp; Housing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International/global development">&nbsp; International/global development
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal">&nbsp; Legal
        </div>
        <div class="col-md-4" id="data_type_col-3">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Manufacturing">&nbsp; Manufacturing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research">&nbsp; Science and research
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety">&nbsp; Public safety
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism">&nbsp; Tourism
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation">&nbsp; Transportation
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather">&nbsp; Weather
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Other">&nbsp; Other
                  <input type="text" class="form-control" style="display:none" id="data_use_type_other" name="data_use_type_other" placeholder="Provide details">
        </div>
      </div>
<br />
      <!-- Sources of open data -->
      <div class="form-group col-md-12">
        <label for="data_country_count">Number of countries from which open data is provided<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="1" /> 1 country
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="2 - 5" /> 2-5 countries
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="6 - 10" /> 6-10 countries
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="11 - 20" /> 11-20 countries
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="21 - 50" /> 21-50 countries
            </label>
            <label class="btn btn-default">
                <input type="radio" name="data_country_count" value="50+" /> 50+ countries
            </label>
          </div>
        </div>
      </div>

      <div id="data_use_details"></div>

      <div class="row col-md-12">
        <label class="row col-md-10">
          How does your organization use open data?<small class="required">*</small> 
        </label>

        <div class="form-group col-md-12">
          <div class="col-md-6" id="use_open_data_col-1">
             <div>
              <input type="checkbox" class="use_open_data" name="use_advocacy" id="use_advocacy" value="True"> advocacy
              <input type="text" class="form-control" style="display:none" id="use_advocacy_desc" name="use_advocacy_desc" placeholder="Provide details">
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_prod_srvc" id="use_prod_srvc" value="True"> develop new products or services
              <input type="text" class="form-control" style="display:none" id="use_prod_srvc_desc" name="use_prod_srvc_desc" placeholder="Provide details">
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_org_opt" id="use_org_opt" value="True"> organizational optimization <i>(e.g. benchmarking, market analysis, improving efficiency, enhancing existing products and services)</i>
              <input type="text" class="form-control" style="display:none" id="use_org_opt_desc" name="use_org_opt_desc" placeholder="Provide details">
            </div>
          </div>

          <div class="col-md-6" id="use_open_data_col-2">
            <div>
              <input type="checkbox" class="use_open_data" name="use_research" id="use_research" value="True"> research
              <input type="text" class="form-control" style="display:none" id="use_research_desc" name="use_research_desc" placeholder="Provide details">
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_other" id="use_other" value="True"> other
              <input type="text" class="form-control" style="display:none" id="use_other_desc" name="use_other_desc" placeholder="Provide details">
            </div>
          </div>
        </div>
      </div>

      <!-- Additional description --> 
      <div class="row col-md-12">
        <label class="row col-md-10">
          Additional information <small class="optional">(optional, 400 characters or less)</small>
        </label>

        <div class="row col-md-10">
          <textarea type="text" class="form-control" id="org_additional" name="org_additional" placeholder="E.g. How could the open data your organization uses be improved? Which datasets are most valuable to your organization? What other types of data does your organization use in addition to open government data?"></textarea>
        </div>
      </div>
      <br />
    </div>

    <br />
 
    <div class="col-md-12" role="contact-titlebar"  id="role-contact-titlebar">
      <div class="section-title"><h3>3. Contact Information <small>(This information will not be made public)</small></h3></div>
    </div>

    <div class="col-md-12" role="contact" id="role-contact">

      <div class="form-group col-md-12">
        <div class="col-md-5">
          <div for="survey_contact_first">First name<small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_first" name="survey_contact_first" required>
        </div>

        <div class="col-md-5">
          <div for="survey_contact_last">Last name<small class="required">*</small></div>
          <input type="text" class="form-control" id="survey_contact_last" name="survey_contact_last" required>
        </div>

        <div class="col-md-10">
          <div for="survey_contact_title">Title <i>(optional)</i></div>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title">

          <div for="survey_contact_email">Email<small class="required">*</small></div>
          <input type="email" class="form-control" id="survey_contact_email" name="survey_contact_email" required>

          <div for="survey_contact_email">Phone <i>(optional)</i></div>
          <input type="text" class="form-control" id="survey_contact_phone" name="survey_contact_phone">

          <input type="hidden" class="form-control" id="org_profile_year" name="org_profile_year" value="2015">
          <input type="hidden" class="form-control" id="org_profile_status" name="org_profile_status" value="submitted">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_src" value="survey">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_category" value="submitted survey">
        </div>
      </div>
    </div><!-- /closes role contact -->
      
      <br />

    <div class="col-md-12" role="submit-note" id="role-submit-note">
      <div style="text-align:center;font-size:14px;margin-top:20px;">
        <i>Please note that all submissions will be reviewed by the Center for Open Data Enterprise 
        research team before public display on the Open Data Impact Map.</i>
      </div>
      <br />
    </div>

    <div class="col-md-12" style="text-align:center;">    
      <button class="btn btn-primary" style="padding:1em 2em 1em 2em; width:200px; background-color: rgb(53, 162, 227);" id="btnSubmit" type="submit" name="submit" value="submit">SUBMIT</button>
    </div>

      
    </div>

</form>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

