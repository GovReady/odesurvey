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

</style>

 <div class="row col-md-9 controlsec" role="orgInfo">
 	<div class="row col-md-12">
 			<h3>Organization information</h3>
 	</div>

 	<div class="row col-md-12 ">
      <div><strong>1) Official organization name</strong></div>
      <a href="#" id="orgNameOfficial" data-type="text" data-pk="1"></a>

      <br /><br />
       <div><strong>2) Common organization name</strong></div>
      <a href="#" id="orgNameCommon" data-type="text" data-pk="1"> </a>

      <br /><br />
			<div><strong>2) What type of organization is it? (select 1)</strong></div>
      <a href="#" id="orgType" data-type="select" data-pk="1" data-title="Select org type"></a>
		</div>	
	</div>



  <div class="col-md-9 controlsec" role="dataUse">
  	<div class="row col-md-12" role="dataTypes">
 			<h3>Open data use</h3>
      <div><strong>4) Please tell us what kinds of open government data are most relevant for your organization.<br />
        In each case tell us the country that supplies the data, and whether the data is local, regional or national.</strong><br /><br /></div>
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
        <button class="btn btn-default btn-xs" id="addDataUseBtn" type="submit">Add row</button>
      </div>

    </div> <!-- /dataUse row -->
    <br />
    
    <div class="row col-md-12" role="dataPurposes">
      <div><strong>5) What purpose does open data serve for your company or organization? - select all that apply</strong><br /><br /></div>
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
      <div><strong>6) What is the most important way in which your company or organization has a positive impact, and how does open government data help you achieve it?</strong><br /><br /></div>
    </div>
    <div class="row col-md-12" id="orgImpact">
      <div class="row col-md-12" id="orgImpactGrid">
        <div class="row col-md-12 orgImpactGridRow" style="">
          <div class="col-md-12" style=""><a href="#" id="orgImpactResponse" data-type="textarea" data-pk="1" data-title="Select" style=""></a></div>
        </div> <!-- /row -->
      </div> <!-- /dataPurposeGrid -->
    </div> <!-- /dataPurpose row -->


  </div> <!-- /dataUse Section -->



 <div class="col-md-9 controlsec" role="contact">
  	<div class="row">
 		<div class="col-md-10">
 			<h3>Contact</h3>
 		</div>

 	</div>

 	<div class="row">
 		<div class="col-md-12">
 			<div id="#">Blah, blah 3</div>
 			</p>
		</div>	
	</div>


 </div>

<!-- /exploration -->


</div> <!--/end row -->



  </div>
  <!--/end container-->

<!-- confirm destroy bootstrap modal -->
<div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Section</h3>
            </div>
            <div class="modal-body" style="height:360px;">
                <textarea rows=16 cols=120>The Defense Security Cooperation Agency’s (DSCA) GlobalNET is a key tool to promote communication between Regional International Outreach (RIO) education centers and institutions, Partnership for Peace (PfP) partners and the communities they engage. RIO-PIMS must provide a secure, extensible, and scalable IT platform for outreach and communication. The system must also encourage engagement via superior usability practices to fulfill its outreach and collaboration missions.
 			</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="/controls/audits/destroy" class="btn btn-primary btn-ok">Update</a>
            </div>
        </div>
    </div>
</div>
<script>

    // $('#confirm-delete').on('show.bs.modal', function(e) {
    //     $(this).find('.btn-ok').attr('href', $(e.relatedTarget).attr('href'));
    // });

</script>


<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>

