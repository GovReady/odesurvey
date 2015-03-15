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

 <div class="row col-md-12 controlsec row-fluid" role="Intro">
  <div class="row col-md-12">
      <h3>Introduction</h3>
  </div>

  <div class="row col-md-12 ">
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
  </div>


 <div class="row col-md-9 controlsec" role="orgInfo">
 	<div class="row col-md-12">
 			<h3>Organization information</h3>
 	</div>

 	<div class="row col-md-12 ">
      <div>1) Official organization name</div>
      <a href="#" id="orgNameOfficial" data-type="text" data-pk="1"></a>

      <br /><br />
       <div>2) Common organization name</div>
      <a href="#" id="orgNameCommon" data-type="text" data-pk="1"> </a>

      <br /><br />
			<div>2) What type of organization is it? (select 1)</div>
      <a href="#" id="orgType" data-type="select" data-pk="1" data-title="Select org type"></a>
		</div>	
	</div>



  <div class="col-md-9 controlsec" role="dataUse">
  	<div class="row col-md-12" role="dataTypes">
 			<h3>Open data use</h3>
      <div>4) Please tell us what kinds of open government data are most relevant for your organization.<br />
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
      <div>5) What purpose does open data serve for your company or organization? - select all that apply<br /><br /></div>
    </div>
    <div class="row col-md-12" id="dataPurpose">
      <div class="row col-md-12" id="dataPurposeGridHeading" style="border-bottom:0px solid #eee;">
        <div class="col-md-12">Build new products/services with open government data</div>
        <div class="col-md-12"><a href="#" id="x1" data-type="checklist" data-pk="1" data-title="Select"></a></div>
      <br />
      </div>
      <div class="row col-md-12" id="dataPurposeGrid">
        <div class="row col-md-12 dataPurposeGridRow" style="border-bottom:0px solid #eee;">
          <div class="col-md-12">Organizaton optimization</div>
          <div class="col-md-12"><a href="#" id="x2" data-type="checklist" data-pk="1" data-title="Select"></a></div>
        </div> <!-- /row -->
      </div> <!-- /dataPurposeGrid -->
    </div> <!-- /dataPurpose row -->

    <br />

    <div class="row col-md-12" role="orgImpactQ">
      <div>6) What is the most important way in which your company or organization has a positive impact, and how does open government data help you achieve it?</div>
      <a href="#" id="orgImpactResponse" data-type="textarea" data-pk="1" data-title="Select" style=""></a>
    </div>
    <div class="row col-md-12" id="orgImpact">
        
    </div> <!-- /dataPurpose row -->


  </div> <!-- /dataUse Section -->



 <div class="col-md-9 controlsec" role="contact">
  <div class="row col-md-12">
      <h3>Contact</h3>
  </div>

    <div class="row col-md-12" role="dataPurposes">
      <div>7) Contact information<br /><br /></div>
    </div>
    <div class="row col-md-12" id="dataPurpose">
      <div class="row col-md-12" id="dataPurposeGridHeading" style="border-bottom:0px solid #eee;">
        <div class="col-md-12">Name</div>
        <div class="col-md-12"><a href="#" id="contactName" data-type="text" data-pk="1"> </a></div>
      <br />
      </div>
      <div class="row col-md-12" id="dataPurposeGrid">
        <div class="row col-md-12 dataPurposeGridRow" style="border-bottom:0px solid #eee;">
          <div class="col-md-12">Email</div>
          <div class="col-md-12"><a href="#" id="contactEmail" data-type="text" data-pk="1"> </a></div>
        </div> <!-- /row -->
      </div> <!-- /dataPurposeGrid -->
    </div> <!-- /dataPurpose row -->

    <br /><br />
  <button class="btn btn-primary col-md-3" id="btnSubmit" type="submit">SEND</button>


 </div>

<!-- /exploration -->






  </div>
  <!--/end container-->

<script>

    // $('#confirm-delete').on('show.bs.modal', function(e) {
    //     $(this).find('.btn-ok').attr('href', $(e.relatedTarget).attr('href'));
    // });

</script>


<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

