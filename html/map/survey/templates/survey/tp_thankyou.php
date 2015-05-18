<?php include __DIR__.'/'.'tp_pt_header.php'; ?>

  <!-- Start main content section -->

        <div class="col-md-9" role="main">
<!--
        <h2><?php echo $content['title']; ?><br /><small>helper text</small></h2>
-->
 </div> <!--/end main -->



<!-- Main Content Section -->
<div class="container lg-font col-md-12" style="border:0px solid black;">

    <div class="col-md-12" role="orgInfo-titlebar"  id="role-orgInfo-titlebar" style="margin-top: 40px;">
      <div class="section-title"><h3>SUBMISION RECEIVED</h3></div>
    </div>
 
    <div class="col-md-12" role="orgInfo"  id="role-orgInfo" style="font-size:14pt;height:400px; margin-top">
    
    <div class="row col-md-12">
        <div>
          Thank you for participating in the Open Data Impact Map. <b>All submissions will be reviewed before public display.</b>  
        </div>
        <br />
        <b>Take me to the Map</b>: <a href ="http://<?php echo $content['HTTP_HOST']; ?>/map/viz">http://<?php echo $content['HTTP_HOST']; ?>/map/viz</a>
        <br /><br />
        <b>View my submission</b>:  <a href ="http://<?php echo $content['HTTP_HOST']; ?>/map/survey/<?php echo $content['surveyId'] ?>">http://<?php echo $content['HTTP_HOST']; ?>/map/survey/<?php echo $content['surveyId'] ?></a>
        <br />Use this unique URL to make changes.

        <br /><br />
        Please help us spread the word!<br />
        <a href="https://twitter.com/intent/tweet?button_hashtag=&text=Checkout%20the%20open%20data%20impact%20map!%20http://opendataenterprise.org/map" class="twitter-hashtag-button" data-lang="en" data-size="large">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        <br />
        If you have any questions, email us at map@odenterprise.org.
        <br /><br />
        Best, 
        <br /><br />
        The Center for Open Data Enterprise
    </div>

  </div><!--/Intro-->

</div>

<!-- I think I am missing a closing </div> gut things are working.
<!--/end container - where is the tag?-->

<?php include __DIR__.'/'.'tp_pt_footer.php'; ?>