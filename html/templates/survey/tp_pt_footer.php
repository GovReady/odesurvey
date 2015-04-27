<a name="footer"></a>

 <div class="container col-sm-12 footer" style="padding-top:60px;">
   <footer style="text-align:center;">
	 <!--
     <a href="http://twitter.com/gitmachines"><img src="/img/twitter-wrap.png" alt="Twitter Logo" class="social-icon"></a>
		 <a href="http://https://github.com/GovReady/GovReady.github.io"><img src="/img/github-wrap.png" alt="Github Logo" class="social-icon"></a>
     <p>&copy; GovReady, Greg Elin 2014</p>
   -->
   <p>&copy;</p>
   </footer>
 </div>


     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
     <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

     <script src="/js/vendor/bootstrap.min.js"></script>

     <script src="/js/plugins.js"></script>
     <script src="/js/main.js"></script>

      <!-- select2 library -->
      <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
      <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>

      <script src="/dist/jquery.validate.min.js"></script>

      <!-- geocomplete -->
      
      <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
      <script src="/js/vendor/ubilabs-geocomplete-eb38f45/jquery.geocomplete.js"></script>

     <script>

       var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
       (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
       g.src='//www.google-analytics.com/ga.js';
       s.parentNode.insertBefore(g,s)}(document,'script'));

       $( document ).ready(function() {

         // Adjust active button on click
         // $("#menu-name").click( function () {
         //   $( "#menu-home" ).toggleClass( "active", true );
         //   $( "#menu-about" ).toggleClass( "active", false );
         //   $( "#menu-contact" ).toggleClass( "active", false );
         // });

         // $("#menu-home").click( function () {
         //   $( "#menu-home" ).toggleClass( "active", true );
         //   $( "#menu-about" ).toggleClass( "active", false );
         //   $( "#menu-contact" ).toggleClass( "active", false );
         // });

         // $("#menu-about").click( function () {
         //   $( "#menu-home" ).toggleClass( "active", false );
         //   $( "#menu-about" ).toggleClass( "active", true );
         //   $( "#menu-contact" ).toggleClass( "active", false );
         // });

         // $("#menu-contact").click( function () {
         //   $( "#menu-home" ).toggleClass( "active", false );
         //   $( "#menu-about" ).toggleClass( "active", false );
         //   $( "#menu-contact" ).toggleClass( "active", true );
         // });

        // $('noscript[data-large][data-small]').each(function() { 
        //   var src = screen.width >= 500 ? $(this).data('large') : $(this).data('small');
        //   $('<img src="' + src + '" alt="' + $(this).data('alt') + '" />').insertAfter($(this));
        // });

        $(".basic-single-industry").select2(
          { placeholder: "Select an industry",
          allowClear: true }
        );

        $(".js-example-basic-single").select2( 
          { placeholder: "Select",
          allowClear: true }
        );

        // $(".country-basic-multiple").select2(
        //   { placeholder: "Select country sources",
        //   allowClear: true }
        // );

        // $(".basic-multiple").select2(
        //   {placeholder: "Select levels",
        //   allowClear: true}
        // );

        // Add data use row
        $('#addDataUseBtn').on('click', function(event) {
          event.preventDefault(); // To prevent following the link (optional)
          addDataUseRow();
        });

        $("#survey_form").validate();

        $('#org_hq_city_all').geocomplete({ 
          details: ".details",
          detailsAttribute: "data-geo"
        });
          
  }); // End Document Ready function
      
      $('.data_type').on("change", function(e) {
        // alert('running');
        myId = this.id.split("-")[1];
        var sel_val = $('#'+this.id).select2().val();
        // alert('sel_val: '+sel_val);
        if (sel_val == "Other") {
          addDataUseOther(myId);
        } else {
          removeDataUseOther(myId);
        }
      });

      $('input[type=radio][name=org_type]').change(function() {
        if (this.value == 'Other') {
          if ($('#org_type_other_div').length == 0) {
            var new_html = '<div class="col-md-4" id="org_type_other_div"><input type="text" class="form-control" id="org_type_other" name="org_type_other" placeholder="Describe other" required></div>';
            // console.log($('#industry_id').parent());
            $('#org_type').append(new_html);
          }
        }
        else {
          if ( $('#org_type_other_div').length > 0 ) {
            $('#org_type_other_div').remove();
          }
        }
      });

      $('input[type=radio][name=org_greatest_impact]').change(function() {
        if (this.value == 'Other') {
          if ( $('#org_greatest_impact_other_div').length == 0 ) {
            var new_html = '<div class="col-md-4" id="org_greatest_impact_other_div"><input type="text" class="form-control" id="org_greatest_impact_other" name="org_greatest_impact_other" placeholder="Describe other" required></div>';
            // console.log($('#industry_id').parent());
            $('#org_greatest_impact').append(new_html);
          }
        }
        else {
          if ( $('#org_greatest_impact_other_div').length > 0 ) {
            $('#org_greatest_impact_other_div').remove();
          }
        }
      });

      $('#industry_id').on("change", function(e) {
        myId = this.id.split("-")[1];
        var sel_val = $('#'+this.id).select2().val();
        if (sel_val == "otr") {
          addIndustryOther();
        } else {
          removeIndustryOther();
        }
      });

      // Add data use row
      $('#add_data_src_btn-1').on('click', function(event) {
        event.preventDefault(); // To prevent following the link (optional)
        var msg = "add_data_src_btn-1 clicked";
        // alert(msg);
        myId = this.id.split("-")[1];
        addDataSrc(myId);
        // addDataUseRow();
        return false;
      });

      // Improved data use profile
      $('input[type=radio][name=data_type_count]').change(function() {
        updateDataUseProfile();
      });

      $('input[type=radio][name=data_country_count]').change(function() {
        updateDataUseProfile();
      });
      
     </script>
 </body>
</html>


