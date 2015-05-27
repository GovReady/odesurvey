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

 <form id="survey_form" class="form-horizontal" style="border:0px dotted black;" action="/map/edit/<?php echo $content['surveyId']; ?>/editform" method="post">

    <div class="col-md-12" role="Intro" id="role-intro">
      <div style="text-align:center;font-size:1.1em;margin-top:20px;">
        EDIT FORM (under development)
        <!-- 
        Thank you for participating in the Open Data Impact Map, the first centralized, searchable database of open data use cases from around the world. 
        Your contribution makes it possible to better understand the value of open data and encourage its use globally.
        Information collected will be displayed on the <a href="http://opendataenterprise.org/map/viz">Map</a> and will be made available as open data.
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
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2" value="<?php echo $org_profile['org_name'];?>">
        </div>
        </div>
      </div>

      <!-- Description of organization -->
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_description">One sentence description of organization <small class="required">(400 characters or less)*</small></label>
          <textarea type="text" class="form-control " id="org_description" name="org_description" required><?php echo $org_profile['org_description'];?></textarea>
        </div>
      </div>

      <!-- Type of organization -->
      <div class="form-group col-md-12" id="org_type">
          <label for="org_type">Type of organization<small class="required">*</small></label>
        <div class="col-md-10">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("For-profit" == $org_profile['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="For-profit" value="For-profit" required="True" <?php if ("For-profit" == $org_profile['org_type']) {echo "checked";} ?>> For-profit
            </label>
            <label class="btn btn-default <?php if ("Nonprofit" == $org_profile['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Nonprofit" value="Nonprofit" <?php if ("Nonprofit" == $org_profile['org_type']) {echo "checked";} ?>> Nonprofit
            </label>
            <label class="btn btn-default <?php if ("Developer group" == $org_profile['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Developer group" value="Developer group" <?php if ("Developer group" == $org_profile['org_type']) {echo "checked";} ?>> Developer group
            </label>
            <label class="btn btn-default <?php if ("Other" == $org_profile['org_type']) {echo "active";} ?>">
                <input type="radio" name="org_type" id="Other" value="Other" <?php if ("Other" == $org_profile['org_type']) {echo "checked";} ?>> Other
            </label>
          </div>
        </div>
        <?php if ("Other" == $org_profile['org_type']) { ?>
          <div class="col-md-4" id="org_type_other_div"><input type="text" class="form-control" id="org_type_other" name="org_type_other" placeholder="Provide other" required value="<?php echo $org_profile['org_type_other'];?>"></div>
        <?php } ?>
      </div>

      <!-- Website URL -->
      <div class="form-group col-md-12">
        <label for="org_url">Website URL</label>
        <div class="row">      
            <div class="col-md-8">
              <input type="url" class="form-control" id="org_url" name="org_url" placeholder="http://" value="<?php if (null !== $org_profile['org_url']) { echo $org_profile['org_url']; } else { echo null; } ?>">
            </div>
            <div class="col-md-4">
              <input type="checkbox" name="no_org_url" id="no_org_url" value="True" <?php if ($org_profile['no_org_url']) {echo "checked";} ?>> No URL 
            </div>
        </div>
      </div>

      <!-- Location -->  
      <div class="form-group col-md-12">
        <div class="form-group col-md-10 details">

          <label for="org_hq_city_all">Location <small class="required">(Please provide as specific as possible)*</small></label>
          <input type="text" class="form-control" id="org_hq_city_all" name="org_hq_city_all" required value="<?php echo $org_profile['org_hq_city'].", ".$org_profile['org_hq_st_prov'].", ".$org_profile['org_hq_country'];?>">

          <!--label for="org_hq_city">City</label -->
          <input type="hidden" class="form-control" id="org_hq_city" name="org_hq_city" required data-geo="locality" value="<?php echo $org_profile['org_hq_city'];?>">

          <!--label for="org_hq_st_prov">State/Province</label -->
          <input type="hidden" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" required data-geo="administrative_area_level_1" value="<?php echo $org_profile['org_hq_st_prov'];?>">

          <!--label for="org_hq_country">Country</label -->
          <input type="hidden" class="form-control" id="org_hq_country" name="org_hq_country" required data-geo="country_short" value="<?php echo $org_profile['org_hq_country'];?>">

          <!--label for="latitude">lat</label -->
          <input type="hidden" class="form-control" id="latitude" name="latitude" required data-geo="lat" value="<?php echo $org_profile['latitude'];?>">
          <!--label for="longitude">lng</label -->
          <input type="hidden" class="form-control" id="longitude" name="longitude" required data-geo="lng" value="<?php echo $org_profile['longitude'];?>">
        </div>
      </div>
  
      <!-- Industry/category of organization -->
      <div class="form-group col-md-12">
        <label for="industry_id">Industry/category of the organization <small class="required">(select 1)*</small></label>
        <fieldset>
        <div class="col-md-4" id="industry_id_col-1">
          <input type="radio" name="industry_id" class="industry_id" value="Agriculture" <?php if ("Agriculture" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Agriculture
          <br /><input type="radio" name="industry_id" class="industry_id" value="Arts and culture" <?php if ("Arts and culture" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Arts and culture
          <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="Business and legal services" required <?php if ("Business and legal services" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Business and legal services
          <br /><input type="radio" name="industry_id" class="industry_id" value="Consumer services" <?php if ("Consumer services" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Consumer services
          <br /><input type="radio" name="industry_id" class="industry_id" value="Data/information technology" <?php if ("Data/information technology" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Data/information technology
          <br /><input type="radio" name="industry_id" class="industry_id" value="Education" <?php if ("Education" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Education
          <br /><input type="radio" name="industry_id" class="industry_id" value="Energy" <?php if ("Energy" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Energy
          <br /><input type="radio" name="industry_id" class="industry_id" value="Environment" <?php if ("Environment" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Environment
          <br /><input type="radio" name="industry_id" class="industry_id" value="Finance and investment" <?php if ("Finance and investment" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Finance and investment
        </div>
        <div class="col-md-4" id="industry_id_col-2">
          <input type="radio" name="industry_id" class="industry_id" value="geo">&nbsp; Geospatial/mapping
          <br /><input type="radio" name="industry_id" class="industry_id" value="Governance" <?php if ("Governance" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Governance
          <br /><input type="radio" name="industry_id" class="industry_id" value="Healthcare" <?php if ("Healthcare" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Healthcare
          <br /><input type="radio" name="industry_id" class="industry_id" value="Housing and real estate" <?php if ("Housing and real estate" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Housing and real estate
          <br /><input type="radio" name="industry_id" class="industry_id" value="Insurance" <?php if ("Insurance" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Insurance
          <br /><input type="radio" name="industry_id" class="industry_id" value="Media and communications" <?php if ("Media and communications" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Media and communications
          <br /><input type="radio" name="industry_id" class="industry_id" value="Mining/Manufacturing" <?php if ("Mining/Manufacturing" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Mining/Manufacturing
          <br /><input type="radio" name="industry_id" class="industry_id" value="Research and consulting" <?php if ("Research and consulting" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Research and consulting
          <br /><input type="radio" name="industry_id" class="industry_id" value="Security and public safety" <?php if ("Security and public safety" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Security and public safety
        </div>
        <div class="col-md-4" id="industry_id_col-3">
          <input type="radio" name="industry_id" class="industry_id" value="sci">&nbsp; Scientific research
          <br /><input type="radio" name="industry_id" class="industry_id" value="Telecommunications/internet service providers (ISPs)" <?php if ("Telecommunications/internet service providers (ISPs)" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Telecommunications/internet service providers (ISPs)
          <br /><input type="radio" name="industry_id" class="industry_id" value="Tourism" <?php if ("Tourism" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Tourism
          <br /><input type="radio" name="industry_id" class="industry_id" value="Transportation and logistics" <?php if ("Transportation and logistics" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Transportation and logistics
          <br /><input type="radio" name="industry_id" class="industry_id" value="Water and sanitation" <?php if ("Water and sanitation" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Water and sanitation
          <br /><input type="radio" name="industry_id" class="industry_id" value="Weather" <?php if ("Weather" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Weather
          <br /><input type="radio" name="industry_id" class="industry_id" value="Other" <?php if ("Other" == $org_profile['industry_id']) {echo "checked";} ?>>&nbsp; Other
              <?php if ("Other" == $org_profile['industry_id']) { ?>
                <input type="text" class="form-control" name="industry_other" placeholder="Describe other" value="<?php echo $org_profile['industry_other'];?>">
              <?php } else { ?>
                <input type="text" class="form-control" style="display:none" name="industry_other" placeholder="Describe other">
              <?php } ?>
        </div>
        </fieldset>
      </div>

      <!-- Founding year -->    
      <div class="form-group col-md-12">
        <div class="form-group col-md-10">
          <label for="org_year_founded">Founding year<small class="required">*</small></label>
          <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required value="<?php echo $org_profile['org_year_founded'];?>">
        </div>
      </div>

      <!-- Size -->
      <div class="form-group col-md-12">
        <label for="org_size_id">Size<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("1-10" == $org_profile['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="1-10" <?php if ("1-10" == $org_profile['org_size_id']) {echo "checked";} ?>> 1-10 employees
            </label>
            <label class="btn btn-default <?php if ("11-50" == $org_profile['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="11-50" <?php if ("11-50" == $org_profile['org_size_id']) {echo "checked";} ?>> 11-50 employees
            </label>
            <label class="btn btn-default  <?php if ("51-200" == $org_profile['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="51-200" <?php if ("51-200" == $org_profile['org_size_id']) {echo "checked";} ?>> 51-200 employees
            </label>
            <label class="btn btn-default <?php if ("201-1000" == $org_profile['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="201-1000" <?php if ("201-1000" == $org_profile['org_size_id']) {echo "checked";} ?>> 201-1000 employees
            </label>
            <label class="btn btn-default <?php if ("1000+" == $org_profile['org_size_id']) {echo "active";} ?>">
                <input type="radio" name="org_size_id" value="1000+"<?php if ("1000+" == $org_profile['org_size_id']) {echo "checked";} ?>> 1000+ employees
            </label>
          </div>
        </div>
      </div>

      <!-- What is the greatest type of impact your organization has? -->
      <div class="form-group col-md-12" id="org_greatest_impact">
          <label for="org_greatest_impact">What is the greatest type of impact your organization has?<small class="required">*</small></label>
        <div class="col-xs-9">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default <?php if ("Economic" == $org_profile['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Economic" value="Economic" <?php if ("Economic" == $org_profile['org_greatest_impact']) {echo "checked";} ?>> Economic
            </label>
            <label class="btn btn-default <?php if ("Environmental" == $org_profile['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Environmental" value="Environmental" <?php if ("Environmental" == $org_profile['org_greatest_impact']) {echo "checked";} ?>> Environmental
            </label>
            <label class="btn btn-default <?php if ("Governance" == $org_profile['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Governance" value="Governance" <?php if ("Governance" == $org_profile['org_greatest_impact']) {echo "checked";} ?>> Governance
            </label>
            <label class="btn btn-default <?php if ("Social" == $org_profile['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Social" value="Social"  <?php if ("Social" == $org_profile['org_greatest_impact']) {echo "checked";} ?>> Social
            </label>
            <label class="btn btn-default <?php if ("Other" == $org_profile['org_greatest_impact']) {echo "active";} ?>">
                <input type="radio" name="org_greatest_impact" id="Other" value="Other"  <?php if ("Other" == $org_profile['org_greatest_impact']) {echo "checked";} ?>> Other
            </label>
          </div>
        </div>
          <div class="col-md-10" id="org_greatest_impact_detail_div"><input type="text" class="form-control" id="org_greatest_impact_detail" name="org_greatest_impact_detail" placeholder="Provide other" required value="<?php echo $org_profile['org_greatest_impact_detail'];?>"></div>
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
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" required  <?php if (in_array("Agriculture", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Agriculture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture" <?php if (in_array("Arts and culture", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Arts and culture
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business" <?php if (in_array("Business", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Business
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer" <?php if (in_array("Consumer", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Consumer
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographics and social" <?php if (in_array("Demographics and social", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Demographics and social
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics " <?php if (in_array("Economics", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Economics
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education" <?php if (in_array("Education", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Education
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy" <?php if (in_array("Energy", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Energy
        </div>
        <div class="col-md-4" id="data_type_col-2">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment" <?php if (in_array("Environment", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Environment
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance" <?php if (in_array("Finance", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Finance
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial/mapping" <?php if (in_array("Geospatial/mapping", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Geospatial/mapping
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations" <?php if (in_array("Government operations", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Government operations
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare" <?php if (in_array("Health/healthcare", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Health/healthcare
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing" <?php if (in_array("Housing", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Housing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International/global development" <?php if (in_array("International/global development", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; International/global development
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal" <?php if (in_array("Legal", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Legal
        </div>
        <div class="col-md-4" id="data_type_col-3">
            <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Manufacturing" <?php if (in_array("Manufacturing", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Manufacturing
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research" <?php if (in_array("Science and research", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Science and research
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety" <?php if (in_array("Public safety", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Public safety
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism" <?php if (in_array("Tourism", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Tourism
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation" <?php if (in_array("Tra", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Transportation
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather" <?php if (in_array("Weather", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Weather
            <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Other" <?php if (in_array("Other", $org_profile['data_use_type'])) {echo "checked";} ?>>&nbsp; Other
                  <input type="text" class="form-control" style="" id="data_use_type_other" name="data_use_type_other" placeholder="Provide details" value="<?php if (array_key_exists("data_use_type_other", $org_profile)) {echo $org_profile['data_use_type_other'];} ?>">
        </div>
      </div>
<br />
      <!-- Sources of open data -->
      <div class="form-group col-md-12">
        <label for="data_country_count">Number of countries from which open data is provided<small class="required">*</small></label>
        <div class="col-md-12">
          <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default" <?php if ("1" == $org_profile['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="1" <?php if ("1" == $org_profile['data_country_count']) {echo "checked";} ?>> 1 country
            </label>
            <label class="btn btn-default <?php if ("2 - 5" == $org_profile['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="2 - 5" <?php if ("2 - 5" == $org_profile['data_country_count']) {echo "checked";} ?>> 2-5 countries
            </label>
            <label class="btn btn-default <?php if ("6 - 10" == $org_profile['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="6 - 10" <?php if ("6 - 10" == $org_profile['data_country_count']) {echo "checked";} ?>> 6-10 countries
            </label>
            <label class="btn btn-default <?php if ("11 - 20" == $org_profile['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="11 - 20" <?php if ("11 - 20" == $org_profile['data_country_count']) {echo "checked";} ?>> 11-20 countries
            </label>
            <label class="btn btn-default <?php if ("21 - 50" == $org_profile['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="21 - 50" <?php if ("21 - 50" == $org_profile['data_country_count']) {echo "checked";} ?>> 21-50 countries
            </label>
            <label class="btn btn-default <?php if ("50+" == $org_profile['data_country_count']) {echo "active";} ?>">
                <input type="radio" name="data_country_count" value="50+" <?php if ("50+" == $org_profile['data_country_count']) {echo "checked";} ?>> 50+ countries
            </label>
          </div>
        </div>
      </div>

      <div id="data_use_details">

<?php
echo "rows: ".count($org_data_use);
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
    $row_html = '<div class="col-md-5" style="border:0px solid red;">';
    $row_html .= <<<EOL
<select name="dataUseData-{$country_count}[src_country][src_country_locode]" class="js-example-basic-single" style="width:240px;">
<option value="$country">$country</option>
<option value="AF">Afghanistan</option>
<option value="AX">Åland Islands</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
</select>
EOL;

    $row_html .= '</div>';
    echo $row_html;
    // echo print_r($org_profile['data_use_type']);

    echo '<div class="col-md-7">'; // frame data use

    foreach ($org_profile['data_use_type'] as $entry) {
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


?>



      </div>

      <div class="row col-md-12">
        <label class="row col-md-10">
          How does your organization use open data?<small class="required">*</small> 
        </label>

        <div class="form-group col-md-12">
          <div class="col-md-6" id="use_open_data_col-1">
             <div>
              <input type="checkbox" class="use_open_data" name="use_advocacy" id="use_advocacy" value="True" <?php if ("1" == $org_profile['use_advocacy']) {echo "checked";} ?>> advocacy
              <textarea class="form-control" style="" id="use_advocacy_desc" name="use_advocacy_desc" placeholder="Provide details"><?php if (array_key_exists("use_advocacy_desc", $org_profile)) {echo $org_profile['use_advocacy_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_prod_srvc" id="use_prod_srvc" value="True" <?php if ("1" == $org_profile['use_prod_srvc']) {echo "checked";} ?>> develop new products or services
              <textarea class="form-control" style="" id="use_prod_srvc_desc" name="use_prod_srvc_desc" placeholder="Provide details"><?php if (array_key_exists("use_prod_srvc_desc", $org_profile)) {echo $org_profile['use_prod_srvc_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_org_opt" id="use_org_opt" value="True" <?php if ("1" == $org_profile['use_org_opt']) {echo "checked";} ?>> organizational optimization <i>(e.g. benchmarking, market analysis, improving efficiency, enhancing existing products and services)</i>
              <textarea class="form-control" style="" id="use_org_opt_desc" name="use_org_opt_desc" placeholder="Provide details"><?php if (array_key_exists("use_org_opt_desc", $org_profile)) {echo $org_profile['use_org_opt_desc'];} ?></textarea>
            </div>
          </div>

          <div class="col-md-6" id="use_open_data_col-2">
            <div>
              <input type="checkbox" class="use_open_data" name="use_research" id="use_research" value="True" <?php if ("1" == $org_profile['use_research']) {echo "checked";} ?>> research
              <textarea class="form-control" style="" id="use_research_desc" name="use_research_desc" placeholder="Provide details"><?php if (array_key_exists("use_research_desc", $org_profile)) {echo $org_profile['use_research_desc'];} ?></textarea>
            </div>
            <div>
              <input type="checkbox" class="use_open_data" name="use_other" id="use_other" value="True" <?php if ("1" == $org_profile['use_other']) {echo "checked";} ?>> other
              <textarea class="form-control" style="" id="use_other_desc" name="use_other_desc" placeholder="Provide details"><?php if (array_key_exists("use_other_desc", $org_profile)) {echo $org_profile['use_other_desc'];} ?></textarea>
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
          <textarea type="text" class="form-control" id="org_additional" name="org_additional" placeholder="E.g. How could the open data your organization uses be improved? Which datasets are most valuable to your organization? What other types of data does your organization use in addition to open government data?"><?php echo $org_profile['org_additional'];?></textarea>
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

