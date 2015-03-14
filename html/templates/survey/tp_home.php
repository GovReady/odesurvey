<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

  <!-- Start main content section -->

        <div class="col-md-9" role="main">

        <h2><?php echo $content['title']; ?><br /><small>helper text</small></h2>

 </div> <!--/end main -->

<!-- exploration -->
<style>
	.controlsec {
		border:1px solid #eee; 
		margin: 12px 0px 0px 0px; 
	}

  .myeditable {
    height: 200px;
    width: 140%;
  }

  .myeditableshow {
  }

</style>

 <div class="row col-md-9 controlsec" role="sec2">
 	<div class="row col-md-12">
 			<h3>Organization information</h3>
 	</div>

 	<div class="row col-md-12 ">
      <div>1) Name of organization</div>
      <a href="#" id="orgName" data-type="text" data-pk="1">  </a>

      <br /><br />
 			<div>2) What type of organziation is it? (select 1)</div>
      <a href="#" id="orgType" data-type="select" data-pk="1" data-title="Select org type"></a>
		</div>	
	</div>

  <div class="col-md-9 controlsec" role="sec3" >
  	<div class="row col-md-12">
 			<h3>Data use</h3>
      <div>3) Please indicate your organizations primary uses of open data. For each type of open data your organization uses, indicate the general data type, the level of government providing the data, and the source country of the data.<br /><br /></div>
 		</div>

 	  <div class="row col-md-12" id="dataUse">

      <div class="row col-md-12" id="dataUseHeading" style="border-bottom:1px solid #eee;">
        <div class="col-md-1">#</div>
        <div class="col-md-5">General data type</div>
        <div class="col-md-3">Gov level</div>
        <div class="col-md-3">Country source</div>
      </div>

      <div class="row col-md-12" id="dataUseGrid">
        <div class="row col-md-12 dataUseGridRow" style="border-bottom:1px solid #eee;">
          <div class="col-md-1">(1)</div>
          <div class="col-md-5"><a href="#" id="dataType1" data-type="select" data-pk="1" data-title="Select data type"></a></div>
          <div class="col-md-3"><a href="#" id="srcGovLevel1" data-type="checklist" data-pk="1" data-title="Select source government level"></a></div>
          <div class="col-md-2"><a href="#" id="srcCountry1" data-type="checklist" data-pk="1" data-title="Select source Country"></a></div>
        </div> <!-- /row -->

      </div> <!-- /dataUseGrid -->

      <div class="row col-md-10" style="margin: 12px 0px 0px 0px">
        <button class="btn btn-primary" id="addDataUseBtn" type="submit">Add row</button>
      </div>

      <div class="row col-md-11" style="margin: 12px 0px 0px 0px">
        <div>4) What purpose does open data serve for your company or organization? - select all that apply</div>

        
      </div>

    </div> <!-- /dataUse row -->

  </div> <!-- /sec2 -->

 <div class="col-md-9 controlsec" role="sec2">
  	<div class="row">
 		<div class="col-md-10">
 			<h3>Sec 3</h3>
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

