<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

  <!-- Start main content section -->

        <div class="col-md-9" role="main">
<!--
        <h2><?php echo $content['title']; ?><br /><small>helper text</small></h2>
-->
 </div> <!--/end main -->



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

    


</form>

</div>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>