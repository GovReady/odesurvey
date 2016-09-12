<?php 
// I18N support information here
// $language = "fr_FR";
$language = $content['language'];
putenv("LANG=" . $language); 
setlocale(LC_ALL, $language);
 
// Set the text domain as "messages"
$domain = "messages";
bindtextdomain($domain, "Locale"); 
bind_textdomain_codeset($domain, 'UTF-8');
 
textdomain($domain);
?>
<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

 <!-- <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/map/survey/<?php echo $content['surveyId']; ?>/editform" method="post"> -->
  <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/map/survey/2du/<?php echo $content['surveyId']; ?>" method="post">

    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
        
        
        Thank you for participating in the Open Data Impact Map, the first centralized, searchable database of open data use cases from around the world. 
        Your contribution makes it possible to better understand the value of open data and encourage its use globally.
        <!-- Information collected will be displayed on the <a href="http://opendataenterprise.org/map/viz">Map</a> and will be made available as open data.
       -->
      </div>
      <br />
    </div>
     
    <!-- <div class="col-md-12" role="eligibility" id="role-eligibility">
      <div class="row col-md-12">
        <h4>ELIGIBILITY</h4>
      </div>
      <div>
        <b>The Open Data Impact Map includes organizations that:</b>
          <ul>
              <li>are companies, non-profits, or developer groups; and</li>
              <li>use open government data to develop products and services, improve operations, inform strategy and/or conduct research.</li>
            </ul>
        We define open government data as publicly available data that is produced or commissioned by governments 
        and that can be accessed and reused by anyone, free of charge. 
      </div>
    </div> -->

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
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2" value="<?php echo $org_profile[0]['org_name'];?>">
            <input type="hidden" class="form-control" id="objectId" name="objectId" value="<?php echo $org_profile[0]['object_id'];?>">
            <input type="hidden" class="form-control" id="oldId" name="oldId" value="<?php echo $content['old_survey_id'];?>">
        </div>
        </div>
      </div>

      <!-- Description of organization -->
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_description">One sentence description of organization <small class="required">(400 characters or less)*</small></label>
          <textarea type="text" class="form-control " id="org_description" name="org_description" required><?php echo $org_profile[0]['org_description'];?></textarea>
        </div>
      </div>

      <!-- Type of organization -->
      <div class="form-group col-md-12" id="org_type">
          <label for="org_type">Type of organization<small class="required">*</small></label>
        <div class="col-md-10">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("For-profit" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="For-profit" value="For-profit" required="True" <?php if ("For-profit" == $org_profile[0]['org_type']) {echo "checked";} ?>> For-profit
            </label>
            <label class="btn btn-default <?php if ("Nonprofit" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Nonprofit" value="Nonprofit" <?php if ("Nonprofit" == $org_profile[0]['org_type']) {echo "checked";} ?>> Nonprofit
            </label>
            <label class="btn btn-default <?php if ("Developer group" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Developer group" value="Developer group" <?php if ("Developer group" == $org_profile[0]['org_type']) {echo "checked";} ?>> Developer group
            </label>
            <label class="btn btn-default <?php if ("Other" == $org_profile[0]['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Other" value="Other" <?php if ("Other" == $org_profile[0]['org_type']) {echo "checked";} ?>> Other
            </label>
          </div>
        </div>
        <?php if ("Other" == $org_profile[0]['org_type']) { ?>
          <div class="col-md-4" id="org_type_other_div"><input type="text" class="form-control" id="org_type_other" name="org_type_other" placeholder="Provide other" required value="<?php echo $org_profile[0]['org_type_other'];?>"></div>
        <?php } ?>
      </div>

      <!-- Website URL -->
      <div class="form-group col-md-12">
        <label for="org_url">Website URL</label>
        <div class="row">      
            <div class="col-md-8">
              <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="<?php if (null !== $org_profile[0]['org_url']) { echo $org_profile[0]['org_url']; } else { echo null; } ?>">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="no_org_url" id="no_org_url" value="True" <?php if ($org_profile[0]['no_org_url']) {echo "checked";} ?>> No URL 
            </div>
        </div>
      </div>

      <!-- Location -->  
      <div class="form-group col-md-12">
        <div class="form-group col-md-10 details">

          <label for="org_hq_city_all">Location <small class="required">(Please provide as specific as possible)*</small></label>
          <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all" required value="<?php echo $org_loc[0]['org_hq_city'].", ".$org_loc[0]['org_hq_st_prov'].", ".$org_country[0]['org_hq_country'];?>">

          <!--label for="org_hq_city">City</label -->
          <input type="hidden" class="form-control" id="org_hq_city" name="org_hq_city" required data-geo="locality" value="<?php echo $org_loc[0]['org_hq_city'];?>">

          <!--label for="org_hq_st_prov">State/Province</label -->
          <input type="hidden" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" required data-geo="administrative_area_level_1" value="<?php echo $org_loc[0]['org_hq_st_prov'];?>">

          <!--label for="org_hq_country">Country</label -->
          <input type="hidden" class="form-control" id="org_hq_country" name="org_hq_country" required data-geo="country" value="<?php echo $org_country[0]['org_hq_country'];?>">

          <input type="hidden" class="form-control" id="org_hq_country_locode" name="org_hq_country_locode" data-geo="country_short" value="<?php echo $org_country[0]['org_hq_country_locode'];?>">

          <!--label for="latitude">lat</label -->
          <input type="hidden" class="form-control" id="latitude" name="latitude" required data-geo="lat" value="<?php echo $org_loc[0]['latitude'];?>">
          <!--label for="longitude">lng</label -->
          <input type="hidden" class="form-control" id="longitude" name="longitude" required data-geo="lng" value="<?php echo $org_loc[0]['longitude'];?>">
        </div>
      </div>
  
      <!-- Industry/category of organization -->
      <div class="form-group col-md-12">
        <label for="industry_id">Industry/category of the organization <small class="required">(select 1)*</small></label>
        <fieldset>
        <div class="col-md-4" id="industry_id_col-1">
          <input type="radio" name="industry_id" class="industry_id" value="Agriculture" <?php if ("Agriculture" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Agriculture
          <br /><input type="radio" name="industry_id" class="industry_id" value="Arts, culture and tourism" <?php if ("Arts, culture and tourism" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Arts, culture and tourism
          <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="Business, research and consulting" required <?php if ("Business, research and consulting" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Business, research and consulting
          <br /><input type="radio" name="industry_id" class="industry_id" value="Consumer" <?php if ("Consumer" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Consumer
          <br /><input type="radio" name="industry_id" class="industry_id" value="IT and geospatial" <?php if ("IT and geospatial" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; IT and geospatial
          <br /><input type="radio" name="industry_id" class="industry_id" value="Education" <?php if ("Education" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Education
          <br /><input type="radio" name="industry_id" class="industry_id" value="Energy and climate" <?php if ("Energy and climate" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Energy and climate
        </div>
        <div class="col-md-4" id="industry_id_col-2">
          <input type="radio" name="industry_id" class="industry_id" value=" Finance, investment and insurance">&nbsp;  Finance, investment and insurance
          <br /><input type="radio" name="industry_id" class="industry_id" value="Governance" <?php if ("Governance" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Governance
          <br /><input type="radio" name="industry_id" class="industry_id" value="Health" <?php if ("Health" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Health
          <br /><input type="radio" name="industry_id" class="industry_id" value="Housing, construction and real estate" <?php if ("Housing, construction and real estate" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Housing, construction and real estate
          <br /><input type="radio" name="industry_id" class="industry_id" value="Media and communications" <?php if ("Media and communications" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Media and communications
          <br /><input type="radio" name="industry_id" class="industry_id" value="Transportation and logistics " <?php if ("Transportation and logistics " == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Transportation and logistics 
          <br /><input type="radio" name="industry_id" class="industry_id" value="Other" <?php if ("Other" == $org_profile[0]['industry_id']) {echo "checked";} ?>>&nbsp; Other
              <?php if ("Other" == $org_profile[0]['industry_id']) { ?>
                <input type="text" class="form-control" name="industry_other" placeholder="Describe other" value="<?php echo $org_profile[0]['industry_other'];?>">
              <?php } else { ?>
                <input type="text" class="form-control" style="display:none" name="industry_other" placeholder="Describe other">
              <?php } ?>
        </fieldset>
      </div>

      <!-- Founding year -->    
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_year_founded">Founding year<small class="required">*</small></label>
          <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required value="<?php echo $org_profile[0]['org_year_founded'];?>">
        </div>
      </div>

      <!-- Size -->
      <div class="form-group col-md-12">
        <label for="org_size_id">Size<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("1-10" == $org_profile[0]['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="1-10" <?php if ("1-10" == $org_profile[0]['org_size_id']) {echo "checked";} ?>> 1-10 employees
            </label>
            <label class="btn btn-default <?php if ("11-50" == $org_profile[0]['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="11-50" <?php if ("11-50" == $org_profile[0]['org_size_id']) {echo "checked";} ?>> 11-50 employees
            </label>
            <label class="btn btn-default  <?php if ("51-200" == $org_profile[0]['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="51-200" <?php if ("51-200" == $org_profile[0]['org_size_id']) {echo "checked";} ?>> 51-200 employees
            </label>
            <label class="btn btn-default <?php if ("201-1000" == $org_profile[0]['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="201-1000" <?php if ("201-1000" == $org_profile[0]['org_size_id']) {echo "checked";} ?>> 201-1000 employees
            </label>
            <label class="btn btn-default <?php if ("1000+" == $org_profile[0]['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="1000+"<?php if ("1000+" == $org_profile[0]['org_size_id']) {echo "checked";} ?>> 1000+ employees
            </label>
          </div>
        </div>
      </div>

      <!-- What is the greatest type of impact your organization has? -->
      <div class="form-group col-md-12" id="org_greatest_impact">
          <label for="org_greatest_impact">What is the greatest type of impact your organization has?<small class="required">*</small></label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("Economic" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Economic" value="Economic" <?php if ("Economic" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Economic
            </label>
            <label class="btn btn-default <?php if ("Environmental" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Environmental" value="Environmental" <?php if ("Environmental" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Environmental
            </label>
            <label class="btn btn-default <?php if ("Governance" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Governance" value="Governance" <?php if ("Governance" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Governance
            </label>
            <label class="btn btn-default <?php if ("Social" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Social" value="Social"  <?php if ("Social" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Social
            </label>
            <label class="btn btn-default <?php if ("Other" == $org_profile[0]['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Other" value="Other"  <?php if ("Other" == $org_profile[0]['org_greatest_impact']) {echo "checked";} ?>> Other
            </label>
          </div>
        </div>
          <div class="col-md-10" id="org_greatest_impact_detail_div"><input type="text" class="form-control" id="org_greatest_impact_detail" name="org_greatest_impact_detail" placeholder="Provide other" required value="<?php echo $org_profile[0]['org_greatest_impact_detail'];?>"></div>
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
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" required  <?php if (in_array("Agriculture", $org_data_use1)) {echo "checked";} ?>>&nbsp; Agriculture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture" <?php if (in_array("Arts and culture", $org_data_use1)) {echo "checked";} ?>>&nbsp; Arts and culture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business" <?php if (in_array("Business", $org_data_use1)) {echo "checked";} ?>>&nbsp; Business
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer" <?php if (in_array("Consumer", $org_data_use1)) {echo "checked";} ?>>&nbsp; Consumer
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographics and social" <?php if (in_array("Demographics and social", $org_data_use1)) {echo "checked";} ?>>&nbsp; Demographics and social
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics " <?php if (in_array("Economics", $org_data_use1)) {echo "checked";} ?>>&nbsp; Economics
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education" <?php if (in_array("Education", $org_data_use1)) {echo "checked";} ?>>&nbsp; Education
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy" <?php if (in_array("Energy", $org_data_use1)) {echo "checked";} ?>>&nbsp; Energy
        </div>
        <div class="col-md-4" id="data_type_col-2">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment" <?php if (in_array("Environment", $org_data_use1)) {echo "checked";} ?>>&nbsp; Environment
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance" <?php if (in_array("Finance", $org_data_use1)) {echo "checked";} ?>>&nbsp; Finance
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial/mapping" <?php if (in_array("Geospatial/mapping", $org_data_use1)) {echo "checked";} ?>>&nbsp; Geospatial/mapping
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations" <?php if (in_array("Government operations", $org_data_use1)) {echo "checked";} ?>>&nbsp; Government operations
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare" <?php if (in_array("Health/healthcare", $org_data_use1)) {echo "checked";} ?>>&nbsp; Health/healthcare
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing" <?php if (in_array("Housing", $org_data_use1)) {echo "checked";} ?>>&nbsp; Housing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International/global development" <?php if (in_array("International/global development", $org_data_use1)) {echo "checked";} ?>>&nbsp; International/global development
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal" <?php if (in_array("Legal", $org_data_use1)) {echo "checked";} ?>>&nbsp; Legal
        </div>
        <div class="col-md-4" id="data_type_col-3">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Manufacturing" <?php if (in_array("Manufacturing", $org_data_use1)) {echo "checked";} ?>>&nbsp; Manufacturing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research" <?php if (in_array("Science and research", $org_data_use1)) {echo "checked";} ?>>&nbsp; Science and research
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety" <?php if (in_array("Public safety", $org_data_use1)) {echo "checked";} ?>>&nbsp; Public safety
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism" <?php if (in_array("Tourism", $org_data_use1)) {echo "checked";} ?>>&nbsp; Tourism
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation" <?php if (in_array("Tra", $org_data_use1)) {echo "checked";} ?>>&nbsp; Transportation
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather" <?php if (in_array("Weather", $org_data_use1)) {echo "checked";} ?>>&nbsp; Weather
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Other" <?php if (in_array("Other", $org_data_use1)) {echo "checked";} ?>>&nbsp; Other
                  <input type="text" class="form-control" style="" id="data_use_type_other" name="data_use_type_other" placeholder="Provide details" value="<?php if (array_key_exists("data_use_type_other", $org_profile)) {echo $org_profile['data_use_type_other'];} ?>">
        </div>
      </div>
<br />
      <!-- Sources of open data -->

      <?php
        // Deal with data_country_count error
        if (!array_key_exists('data_country_count', $org_profile)) {
          $org_data_use[0]['data_country_count'] = 0;
        }
      ?>
      <div class="form-group col-md-12">
        <label for="data_country_count">Number of countries from which open data is provided<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default" <?php if ("1" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="1" <?php if ("1" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 1 country
            </label>
            <label class="btn btn-default <?php if ("2 - 5" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="2 - 5" <?php if ("2 - 5" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 2-5 countries
            </label>
            <label class="btn btn-default <?php if ("6 - 10" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="6 - 10" <?php if ("6 - 10" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 6-10 countries
            </label>
            <label class="btn btn-default <?php if ("11 - 20" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="11 - 20" <?php if ("11 - 20" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 11-20 countries
            </label>
            <label class="btn btn-default <?php if ("21 - 50" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="21 - 50" <?php if ("21 - 50" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 21-50 countries
            </label>
            <label class="btn btn-default <?php if ("50+" == $org_data_use[0]['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="50+" <?php if ("50+" == $org_data_use[0]['data_country_count']) {echo "checked";} ?>> 50+ countries
            </label>
          </div>
        </div>
      </div>

      <div id="data_use_details">

<?php
/*
// echo "rows: ".count($org_data_use);
// echo "<pre>";print_r($org_data_use);echo "</pre>";

// build up easy dictionary for checked values
$gov_level_checked = array();
for ($r = 0; $r < count($org_data_use); $r++) {
  $key = $org_data_use[$r]['data_src_country_name'].$org_data_use[$r]['data_type'].$org_data_use[$r]['data_src_gov_level'];
  $gov_level_checked[$key] = "checked";
}
// echo "<pre>";print_r($gov_level_checked);echo "</pre>";

echo '<div class=" col-md-12" style="border:0px solid black;" id="data_details">Update the countries that provide the data used by your organization, and whether the data is national and/or local (province/state/city).</div>';
$prev_country = "";
$country_count = 0;

for ($r = 0; $r < count($org_data_use); $r++) {

  $country = $org_data_use[$r]['data_src_country_name'];
  if ($prev_country != $country) {
    // echo "<br>new country<br>";
    if ($r > 0) {
      // we are not in the first row, so close up previous row
      $bottom_html = '</div></div>';
      echo $bottom_html;
    }
    $country_count++;

    $top_html = '<div class="col-md-12 data_detail_row"><div class="row col-md-12" style="border:0px solid #ddd;" >';
    echo $top_html;
    $row_html = '<div class="col-md-5" style="border:0px solid red;">Data source - Country<br />';
    $row_html .= <<<EOL
<select name="dataUseData-{$country_count}[src_country][src_country_locode]" class="js-example-basic-single" style="width:240px;">
<option value="$country">$country</option>
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
<option value="CI">Côte d\'Ivoire</option>
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
<option value="KP">Korea, Democratic People\'s Republic of</option>
<option value="KR">Korea, Republic of</option>
<option value="KW">Kuwait</option>
<option value="KG">Kyrgyzstan</option>
<option value="LA">Lao People\'s Democratic Republic</option>
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
<option value="TW">Taiwan</option>
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
EOL;

    $row_html .= '</div>';
    echo $row_html;
    // echo print_r($org_data_use1);

    echo '<div class="col-md-7">'; // frame data use

    foreach ($org_data_use1 as $entry) {
      $key_national = $country.$entry."National";
      $key_local = $country.$entry."Local";

      $national_checked = "";
      $local_checked = "";
      $national_class = "";
      $local_class = "";

      if (array_key_exists($key_national, $gov_level_checked)) {
        $national_checked = "checked";
        $national_class = "active";
      }
      if (array_key_exists($key_local, $gov_level_checked)) {
        $local_checked = "checked";
        $local_class = "active";
      }

      // print "($entry)";
      $entry_sized = sizeStringPhp($entry, 16);
      $gov_level = <<<EOL
<span class="col-md-4" style="border:0px solid black;">
<span class="" id="" style="font-size:0.8em;"><span class="rm-type">x</span>&nbsp;&nbsp;&nbsp; $entry_sized </span><br />
  <div class="btn-group" data-toggle="buttons">
    <label class="btn btn-default {$national_class}" style="font-size:0.6em">
        <input type="checkbox" name="dataUseData-{$country_count}[src_country][type][{$entry}][src_gov_level][]" value="National" $national_checked>National
    </label>
    <label class="btn btn-default {$local_class}" style="font-size:0.6em">
        <input type="checkbox" name="dataUseData-{$country_count}[src_country][type][{$entry}][src_gov_level][]" value="Local" $local_checked>Local
    </label>
  </div>&nbsp;&nbsp;
</span>
EOL;
    echo $gov_level;

    }

    echo "</div>";// close frame data use

  } else {
    // echo "<br>same country<br>";
    
  }

  // $top_html = '<div class="col-md-12 data_detail_row"><div class="row col-md-12" style="border:0px solid #ddd;" >';
  
  $prev_country = $country;

}
// Close up final row
$bottom_html = '</div></div><br />';
echo $bottom_html;

*/
?>



      </div>

      <div class="row col-md-12">
        <label class="row col-md-10">
          How does your organization use open data?<small class="required">*</small> 
        </label>

        <div class="form-group col-md-12">
          <div class="col-md-6" id="use_open_data_col-1">
             <div>
              <input type="checkbox" class="use_open_data" name="use_advocacy" id="use_advocacy" value="True" <?php if ("1" == $data_app[0]['advocacy']) {echo "checked";} ?>> advocacy
              <textarea class="form-control" style="" id="use_advocacy_desc" name="use_advocacy_desc" placeholder="Provide details"><?php if (array_key_exists("advocacy_desc", $data_app[0])) {echo $data_app[0]['advocacy_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_prod_srvc" id="use_prod_srvc" value="True" <?php if ("1" == $data_app[0]['prod_srvc']) {echo "checked";} ?>> develop new products or services
              <textarea class="form-control" style="" id="use_prod_srvc_desc" name="use_prod_srvc_desc" placeholder="Provide details"><?php if (array_key_exists("prod_srvc_desc", $data_app[0])) {echo $data_app[0]['prod_srvc_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_org_opt" id="use_org_opt" value="True" <?php if ("1" == $data_app[0]['org_opt']) {echo "checked";} ?>> organizational optimization <i>(e.g. benchmarking, market analysis, improving efficiency, enhancing existing products and services)</i>
              <textarea class="form-control" style="" id="use_org_opt_desc" name="use_org_opt_desc" placeholder="Provide details"><?php if (array_key_exists("org_opt_desc", $data_app[0])) {echo $data_app[0]['org_opt_desc'];} ?></textarea>
            </div>
          </div>

          <div class="col-md-6" id="use_open_data_col-2">
            <div>
              <input type="checkbox" class="use_open_data" name="use_research" id="use_research" value="True" <?php if ("1" == $data_app[0]['research']) {echo "checked";} ?>> research
              <textarea class="form-control" style="" id="use_research_desc" name="use_research_desc" placeholder="Provide details"><?php if (array_key_exists("research_desc", $data_app[0])) {echo $data_app[0]['research_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_other" id="use_other" value="True" <?php if ("1" == $data_app[0]['other']) {echo "checked";} ?>> other
              <textarea class="form-control" style="" id="use_other_desc" name="use_other_desc" placeholder="Provide details"><?php if (array_key_exists("other_desc", $data_app[0])) {echo $data_app[0]['other_desc'];} ?></textarea>
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
          <textarea type="text" class="form-control" id="org_additional" name="org_additional" placeholder="E.g. How could the open data your organization uses be improved? Which datasets are most valuable to your organization? What other types of data does your organization use in addition to open government data?"><?php echo $org_profile[0]['org_additional'];?></textarea>
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
          <input type="hidden" class="form-control" id="org_profile_status" name="org_profile_status" value="edit">
          <input type="hidden" class="form-control" id="org_profile_src" name="org_profile_src" value="survey-edit">
          <input type="hidden" class="form-control" id="profile_id" name="profile_id" value="<?php echo $org_profile[0]['profile_id']?>">
        </div>
      </div>
    </div><!-- /closes role contact -->
      
      <br />

    <div class="col-md-12" style="text-align:center;">    
      <button class="btn btn-primary" style="padding:1em 2em 1em 2em; width:200px; background-color: rgb(53, 162, 227);" id="btnSubmit" type="submit" name="submit" value="submit">SUBMIT</button>
    </div>

      
    </div>

</form>

</div> 
<!-- I think I am missing a closing </div> gut things are working. -->
<!-- end container - where is the tag? -->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

