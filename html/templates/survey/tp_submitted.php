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

 <form class="form-horizontal"><!-- using form tag for moment to preserve left side alignment -->

    <div class="row col-md-12 controlsec row-fluid" role="Intro">
      <div class="row col-md-12">
          <h3>Thank You!</h3>
      </div>

      <div class="row col-md-8">
          <div>
            Thank you for completing the 2015 Open Data Survey for <?php echo $org_profile['org_name']; ?>.
          </div>
          <div>
            You can view your survey anytime at: <a href ="http://<?php echo $content['HTTP_HOST']; ?>/survey/opendata/<?php echo $content['surveyId'] ?>/submitted">http://<?php echo $content['HTTP_HOST']; ?>/survey/opendata/<?php echo $content['surveyId'] ?>/submitted</a>
          </div>
        </div>

    </div><!--/Intro-->

    <div class="row col-md-9 controlsec" role="orgInfo">
     	<div class="row col-md-12">
     			<h3>Organization information</h3>
     	</div>

        <div class="form-group col-md-12">
          <div class="form-group col-md-7">
            <label for="org_name">Official organization name</label>
            <?php echo $org_profile['org_name']; ?>
        </div>
        </div>

    </div><!--/OrgInfo-->

</form>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>