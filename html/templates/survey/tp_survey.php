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
          <h3>Eligibility <small>tp_survey.php</small></h3>
      </div>

      <div class="row col-md-8">
          <div>
            The Open Data Impact Map includes organizations that:<br /><br />
              <ul>
                  <li>are companies, non-profits, or developer groups; and</li>
                  <li>use <i>open government data</i> to develop products and services, improve operations, inform strategy and/or conduct research.</li>
                </ul>
            <br />
            We define <i>open government data</i> as publicly available data that is produced or commissioned by governments 
            and that can be accessed and reused by anyone, free of charge. 
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
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="" required minlength="2">
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
        <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="" required>
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
        <h3>Use of open government data</h3>

        <div>Please tell us what types of open government data are most relevant for your organization.<br />
          In each case tell us the country that supplies the data, and whether the data is local, regional or national.<br /><br /></div>
      </div>

<div>


</div>

    <div class="row col-md-12" id="dataUse"><small>datause (alt)</small>

      <div class="row col-md-12 data-use-row" id="dataUseHeading" style="border-bottom:1px solid #eee;">
        <div class="col-md-4">Relevant type of data<br /><small>select one</small></div>
        <div class="col-md-4">From country supplying data<br /><small>select all that apply</small></div>
        <div class="col-md-4">From government level<br /><small>select all that apply</small></div>
      </div>

      <div class="row col-md-12 data-use-row" id="dataUseData-1" style="">
        <div class="col-md-4" id="data_type_col-1">

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

        <div class="col-md-4">
<select name="data_src_country_locode-1[]" class="js-example-basic-single" style="width:240px;">
<option value="">Select</option>
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

</select>

        </div>

  <div class="col-md-4">
      <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-default" style="font-size:0.6em">
            <input type="checkbox" name="data_src_gov_level-1[]" value="National" />National
        </label>
        <label class="btn btn-default" style="font-size:0.6em">
            <input type="checkbox" name="data_src_gov_level-1[]" value="State/Province" />State/Province
        </label>
        <label class="btn btn-default" style="font-size:0.6em">
            <input type="checkbox" name="data_src_gov_level-1[]" value="Local" />Local
        </label>
      </div>
  </div>


  </div> <!-- /dataUseData-1 -->

    <div class="row col-md-12 add_data_src_btn_row" id="add_data_src_btn_row-1">
    <div class="col-md-4">&nbsp;</div>
    <div class="col-md-4">
      <button class="btn btn-default btn-xs" id="add_data_src_btn-1" type="" style="font-size:0.75em;">Add data source</button>
    </div>
    <div class="col-md-4">&nbsp;</div>
  </div>

      <br /><!-- new row -->

    </div> <!-- /dataUse row -->


      <div class="row col-md-12" style="margin: 12px 0px 0px 0px">
        <button class="btn btn-default btn-md" id="addDataUseBtn" type="">Add more data types</button>
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
            <label>
              <input type="checkbox" name="use_prod_srvc" id="use_prod_srvc" value="True">
              develop new products or services : 
            </label>
          </div>
          <div>
            <input type="text" class="form-control" id="use_prod_srvc_desc" name="use_prod_srvc_desc">
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
          Contact information will not be publicly displayed.
          <br /><br />
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

