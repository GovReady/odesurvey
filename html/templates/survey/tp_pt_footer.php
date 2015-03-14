<a name="footer"></a>

 <div class="container col-sm-12 footer" style="padding-top:60px;">
   <footer style="text-align:center;">
	 <!--
     <a href="http://twitter.com/gitmachines"><img src="/img/twitter-wrap.png" alt="Twitter Logo" class="social-icon"></a>
		 <a href="http://https://github.com/GovReady/GovReady.github.io"><img src="/img/github-wrap.png" alt="Github Logo" class="social-icon"></a>
     <p>&copy; GovReady, Greg Elin 2014</p>
   -->
   <p>&copy; GovReady PBC 2015</p>
   </footer>
 </div>


     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
     <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

     <script src="/js/vendor/bootstrap.min.js"></script>

     <script src="/js/plugins.js"></script>
     <script src="/js/main.js"></script>

     <script src="/js/vendor/bootstrap-editable.min.js"></script>

     <link href="/js/vendor/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css"></link>  
      <script src="/js/vendor/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js"></script>  
      <script src="/js/vendor/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.min.js"></script>
      <script src="/js/vendor/inputs-ext/typeaheadjs/typeaheadjs.js"></script>
      <script src="/js/vendor/inputs-ext/wysihtml5/wysihtml5.js"></script>

     <script>



         var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
         (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
         g.src='//www.google-analytics.com/ga.js';
         s.parentNode.insertBefore(g,s)}(document,'script'));


         $( document ).ready(function() {

           // Adjust active button on click
           $("#menu-name").click( function () {
             $( "#menu-home" ).toggleClass( "active", true );
             $( "#menu-about" ).toggleClass( "active", false );
             $( "#menu-contact" ).toggleClass( "active", false );
           });

           $("#menu-home").click( function () {
             $( "#menu-home" ).toggleClass( "active", true );
             $( "#menu-about" ).toggleClass( "active", false );
             $( "#menu-contact" ).toggleClass( "active", false );
           });

           $("#menu-about").click( function () {
             $( "#menu-home" ).toggleClass( "active", false );
             $( "#menu-about" ).toggleClass( "active", true );
             $( "#menu-contact" ).toggleClass( "active", false );
           });

           $("#menu-contact").click( function () {
             $( "#menu-home" ).toggleClass( "active", false );
             $( "#menu-about" ).toggleClass( "active", false );
             $( "#menu-contact" ).toggleClass( "active", true );
           });

          $('noscript[data-large][data-small]').each(function() { 
            var src = screen.width >= 500 ? $(this).data('large') : $(this).data('small');
            $('<img src="' + src + '" alt="' + $(this).data('alt') + '" />').insertAfter($(this));
          });

          //turn to inline mode
          $.fn.editable.defaults.mode = 'inline';

          // Editable areas


          $("#comments").editable();
          
          // org information
          $("#orgName").editable();

          $('#orgType').editable({
              source: [
                    {value: 1, text: 'for-profit'},
                    {value: 2, text: 'nonprofit'},
                    {value: 3, text: 'developer community'}
                 ]
          });

          // Data use
          $('#dataType1').editable({
              source: [
                    {value: 1, text: 'Agriculture'},
                    {value: 2, text: 'Arts and Culture'},
                    {value: 3, text: 'Business'},
                    {value: 4, text: 'Consumer'},
                    {value: 5, text: 'Demographics and Social'},
                    {value: 6, text: 'Economics '},
                    {value: 7, text: 'Education'},
                    {value: 8, text: 'Energy'},
                    {value: 9, text: 'Environment'},
                    {value: 10, text: 'Finance'},
                    {value: 11, text: 'Geospatial/Mapping'},
                    {value: 12, text: 'Government Operations'},
                    {value: 13, text: 'Health/Healthcare'},
                    {value: 14, text: 'Housing'},
                    {value: 15, text: 'International/Global Development'},
                    {value: 16, text: 'Legal'},
                    {value: 17, text: 'Manufacturing'},
                    {value: 18, text: 'Science and Research'},
                    {value: 19, text: 'Public Safety'},
                    {value: 20, text: 'Tourism'},
                    {value: 21, text: 'Transportation'},
                    {value: 22, text: 'Weather'}
                 ]
          });


          $('#srcCountry1').editable({
              source: [
                    {value: 1, text: 'Mexico'},
                    {value: 2, text: 'Russia'},
                    {value: 3, text: 'United States'},
                    {value: 4, text: 'Other countries below this'}
                 ]
          });


          $('#srcGovLevel1').editable({
              source: [
                    {value: 1, text: 'local'},
                    {value: 2, text: 'regional'},
                    {value: 3, text: 'national'}
                 ]
          });
          
          addDataUseRow();
          addDataUseRow();

          $('#addDataUseBtn').on('click', function(event) {
            event.preventDefault(); // To prevent following the link (optional)
            addDataUseRow();
          });
          


         }); // End Document Ready function

        /* Declare the function 'addDataUseRow' 
           Add a row to data use question
        */
        function addDataUseRow(){
          console.log('addDataUseRow called');

          var rows = $('.dataUseGridRow').length;
          console.log('rows: '+rows);
          var idSuffixNum = rows + 1;

          var x = '<div class="row col-md-12 dataUseGridRow" style="border-bottom:1px solid #eee;">' +
           '<div class="col-md-1">('+idSuffixNum.toString()+')</div>'+
           '<div class="col-md-5"><a href="#" id="dataType'+idSuffixNum.toString()+'"></a></div>'+
           '<div class="col-md-3"><a href="#" id="srcGovLevel'+idSuffixNum.toString()+'"></a></div>' +
           '<div class="col-md-2"><a href="#" id="srcCountry'+idSuffixNum.toString()+'"></a></div>' +
           '</div><!-- /row -->';

           $('#dataUseGrid').append(x);

           $('#dataType'+idSuffixNum.toString()).editable({
              type: 'select',
              pk: idSuffixNum,
              title: 'Select data type',
              showbuttons: false,
              source: [
                    {value: 1, text: 'Agriculture'},
                    {value: 2, text: 'Arts and Culture'},
                    {value: 3, text: 'Business'},
                    {value: 4, text: 'Consumer'},
                    {value: 5, text: 'Demographics and Social'},
                    {value: 6, text: 'Economics '},
                    {value: 7, text: 'Education'},
                    {value: 8, text: 'Energy'},
                    {value: 9, text: 'Environment'},
                    {value: 10, text: 'Finance'},
                    {value: 11, text: 'Geospatial/Mapping'},
                    {value: 12, text: 'Government Operations'},
                    {value: 13, text: 'Health/Healthcare'},
                    {value: 14, text: 'Housing'},
                    {value: 15, text: 'International/Global Development'},
                    {value: 16, text: 'Legal'},
                    {value: 17, text: 'Manufacturing'},
                    {value: 18, text: 'Science and Research'},
                    {value: 19, text: 'Public Safety'},
                    {value: 20, text: 'Tourism'},
                    {value: 21, text: 'Transportation'},
                    {value: 22, text: 'Weather'}
                 ]
              });

            $('#srcGovLevel'+idSuffixNum.toString()).editable({
              type: 'checklist',
              pk: idSuffixNum,
              title: 'Select source government',
              showbuttons: true,
              source: [
                    {value: 1, text: 'local'},
                    {value: 2, text: 'regional'},
                    {value: 3, text: 'national'}
                 ]
              });

            $('#srcCountry'+idSuffixNum.toString()).editable({
              type: 'checklist',
              pk: idSuffixNum,
              title: 'Select source government',
              showbuttons: true,
              source: [
                    {value: 1, text: 'Mexico'},
                    {value: 2, text: 'Russia'},
                    {value: 3, text: 'United States'},
                    {value: 4, text: 'Other countries below this'}
                 ]
              });

            // Data purpose

            $('#x1').editable({
              source: [
                    {value: 'ma', text: 'mobile applications'},
                    {value: 'wa', text: 'web-based applications'},
                    {value: 'pl', text: 'product line'},
                    {value: 'sl', text: 'service line'}
                 ]
            });


            $('#x2').editable({
              source: [
                    {value: 'ieps', text: 'Improve existing products and services'},
                    {value: 'ieo', text: 'Increase efficiency of operations'},
                    {value: 'ikmt', text: 'Increase knowledge of markets and trends'}
                 ]
            });    

            // Org impact

            $('#orgImpactResponse').editable({
              rows: 6,
              placeholder: 'placeholder text',
              cols: 80
            });    

        }
        /*
      <div class="row" style="border-bottom:1px solid #eee;">

        <div class="col-md-1">a.</div>
        <div class="col-md-5"><a href="#" id="dataType1" data-type="select" data-pk="1" data-title="Select data type"></a></div>
        <div class="col-md-3"><a href="#" id="srcGovLevel1" data-type="checklist" data-pk="1" data-title="Select source government level"></a></div>
        <div class="col-md-2"><a href="#" id="srcCountry1" data-type="checklist" data-pk="1" data-title="Select source Country"></a></div>

      </div> <!-- /row -->
        */

     </script>
 </body>
</html>


