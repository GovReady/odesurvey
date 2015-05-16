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
          <h3>SUMBISSION RECEIVED: Thank you!</h3>
      </div>

      <div class="row col-md-12">
          <div>
            Thank you for participating in the Open Data Impact Map! We will review and publish your submission shortly. 
            If you wish to view or make any changes to your entry, you may access it via the unique url:  <a href ="http://<?php echo $content['HTTP_HOST']; ?>/map/survey/<?php echo $content['surveyId'] ?>">http://<?php echo $content['HTTP_HOST']; ?>/map/survey/<?php echo $content['surveyId'] ?></a>
          </div>
          <br />
          Please help us spread the word!
          <br />
          <a href="https://twitter.com/intent/tweet?button_hashtag=&text=Checkout%20the%20open%20data%20impact%20map!%20http://opendataenterprise.org/map" class="twitter-hashtag-button" data-lang="en" data-size="large">Tweet</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
          <br /><br />
          If you have any questions, email us at map@odenterprise.org.
          <br /><br />
          Best, 
          <br /><br />
          The Center for Open Data Enterprise
      </div>

    </div><!--/Intro-->

</form>

</div>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>