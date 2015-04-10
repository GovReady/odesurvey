<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

  <!-- Start main content section -->

        <div class="col-md-9" role="main">
<!--
        <h2><?php echo $content['title']; ?><br /><small>helper text</small></h2>
-->
 </div> <!--/end main -->

<!-- exploration -->
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

 /* Important to get editable to be full width (see: https://github.com/vitalets/x-editable/issues/361#issuecomment-74871125) */
  .editable-container.editable-inline,
  .editable-container.editable-inline .control-group.form-group,
  .editable-container.editable-inline .control-group.form-group .editable-input,
  .editable-container.editable-inline .control-group.form-group .editable-input textarea,
  .editable-container.editable-inline .control-group.form-group .editable-input select,
  .editable-container.editable-inline .control-group.form-group .editable-input input:not([type=radio]):not([type=checkbox]):not([type=submit])
{
    width: 85%!important;
}

body {
  font-size: 11pt;
}

</style>

<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

 <form class="form-horizontal" action="/survey/opendata/<?php echo $content['surveyId']; ?>" method="post">

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
            <input type="text" class="form-control" id="org_name" name="org_name" placeholder="e.g., IBM Corporation">
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
        <input type="text" class="form-control" id="org_url" name="org_url" placeholder="http://" value="http://">
      </div>
    </div>


    <div class="form-group col-md-12">
      <div class="form-group col-md-7">
        <label for="org_year_founded">Year founded</label>
        <input type="text" class="form-control" id="org_year_founded" name="org_year_founded" placeholder="e.g., 2004">
      </div>
    </div>

    <div class="form-group col-md-12">
      <div class="form-group col-md-8">
        <label for="org_description">Description of organization (400 characters or less) </label>
        <textarea type="text" class="form-control " id="org_description" name="org_description" style="height:160px; min-height:160px;  max-height:160px;"></textarea>
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
        <select class="form-control" name="industry_id">
          <option value="0">Select</option>
          <option value="bus">business &amp; legal services</option>
          <option value="cul">culture/leisure</option>
          <option value="dat">data/technology</option>
          <option value="edu">education</option>
          <option value="ngy">energy</option>
          <option value="env">environment &amp; weather</option>
          <option value="fin">finance &amp; investment</option>
          <option value="agr">food &amp; agriculture</option>
          <option value="geo">geospatial/mapping</option>
          <option value="gov">governance</option>
          <option value="hlt">healthcare</option>
          <option value="est">housing/real estate</option>
          <option value="hum">human rights</option>
          <option value="ins">insurance</option>
          <option value="lif">lifestyle &amp; consumer</option>
          <option value="med">media &amp; communications</option>
          <option value="man">mining/manufacturing</option>
          <option value="rsh">research &amp; consulting</option>
          <option value="sci">scientific research</option>
          <option value="tel">telecommunication/ISPs</option>
          <option value="trm">tourism</option>
          <option value="trd">trade &amp; commodities</option>
          <option value="trn">transportation</option>
        </select>
      </div>
    </div>

    <div class="form-group col-md-12">
      <div class="form-group col-md-7">
        <label for="org_hq_city">City</label>
        <input type="text" class="form-control" id="org_hq_city" name="org_hq_city" placeholder="">

        <label for="org_hq_st_prov">State/Province</label>
        <input type="text" class="form-control" id="org_hq_st_prov" name="org_hq_st_prov" placeholder="">

        <label for="org_hq_country">Country</label>
        <input type="text" class="form-control" id="org_hq_country" name="org_hq_country" placeholder="">
      </div>
    </div>


    </div><!--/OrgInfo-->

    <div class="col-md-9 controlsec" role="dataUse">
      <div class="row col-md-12" role="dataTypes">
        <h3>How Do You Use Open Government Data?</h3>

        <div>Please tell us what kinds of open government data are most relevant for your organization.<br />
          In each case tell us the country that supplies the data, and whether the data is local, regional or national.<br /><br /></div>
      </div>

    <div class="row col-md-12" id="dataUse">
      <div class="row col-md-12" id="dataUseHeading" style="border-bottom:1px solid #eee;">
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-3">Relevant kind of data<br /><small>select one</small></div>
        <div class="col-md-4">From country supplying data<br /><small>select all that apply</small></div>
        <div class="col-md-3">From government level<br /><small>select all that apply</small></div>
      </div>

      <div class="row col-md-12" id="dataUseGrid">
        <div class="row col-md-12 dataUseGridRow" style="border-bottom:1px solid #eee;">
          <div class="col-md-1">(1)</div>
          <div class="col-md-3"><a href="#" id="dataType1" data-type="select" data-pk="1" data-title="Select data type"></a></div>
          <div class="col-md-4"><a href="#" id="srcCountry1" data-type="checklist" data-pk="1" data-title="Select source Country"></a></div>
          <div class="col-md-3"><a href="#" id="srcGovLevel1" data-type="checklist" data-pk="1" data-title="Select source government level"></a></div>
      
        </div> <!-- /row -->
      </div> <!-- /dataUseGrid -->

      <div class="row col-md-10" style="margin: 12px 0px 0px 0px">
        <button class="btn btn-default btn-xs" id="addDataUseBtn" type="">Add row</button>
      </div>

    </div> <!-- /dataUse row -->
    <br />
    <div class="row col-md-12" role="dataPurposes">
      <label>
        What purpose does open data serve for your company or organization? - select all that apply
      </label>

      <div class="form-group col-md-12">
        <div class="form-group col-md-7">
          <div class="checkbox">
            <label> Develop product services
              <input type="checkbox" name="use_prod_srvc" id="use_prod_srvc" value="True"> 
              <input type="text" class="form-control" id="use_prod_srvc_desc" name="use_prod_srvc_desc">
                
            </label>
          </div>

          <div class="checkbox">
            <label>
              <input type="checkbox" name="use_org_opt" id="use_prod" value="True">
              Organization optimization
            </label>
          </div>
          <div>
            <input type="text" class="form-control" id="use_org_opt_desc" name="use_org_opt_desc">
          </div>

          <div class="checkbox">
            <label>
              <input type="checkbox" name="use_research" id="use_research" value="True">
              Use Research
            </label>
          </div>
          <div>
            <input type="text" class="form-control" id="use_research_desc" name="use_research_desc">
          </div>

          <div class="checkbox">
            <label>
              <input type="checkbox" name="use_other" id="use_other" value="True">
              Other
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
          <textarea type="text" class="form-control" id="org_greatest_impact" name="org_greatest_impact" style="height:160px; min-height:160px;  max-height:160px;"></textarea>
      </div>
    </div>

    <div class="" role="Contact">
      <div class="row col-md-12">
          <h3>Contact</h3>
      </div>

      <div class="">
        <div class="row col-md-7">
          <label for="survey_contact_name">Your full name</label>
          <input type="text" class="form-control" id="survey_contact_name" name="survey_contact_name" placeholder="">

          <label for="survey_contact_title">Your title at organization</label>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title" placeholder="">

          <label for="survey_contact_email">Your email</label>
          <input type="text" class="form-control" id="survey_contact_email" name="survey_contact_email" placeholder="">

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

</div><!--/???? this should close datause tag - something must be wrong with data grid-->


</form>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

