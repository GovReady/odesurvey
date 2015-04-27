/* Declare the function 'addDataSrc'
   Add a data source row
*/
function addDataSrc(myId){
  console.log('addDataSrc called with myid: '+myId);
  // alert('addDataUseOther called with myid: '+myId);
  // var data_use_other = '<input type="text" class="form-control" id="data_type_other-'+myId+'" name="data_type_other-'+myId+'" placeholder="Describe other" required>';
  // alert(+myId);

  var rows = $('#dataUseData-'+myId+' .data-src-row').length;
  console.log('rows: '+rows);
  var idSuffixNum = rows + 1;
  console.log('idSuffixNum: '+idSuffixNum);

  var data_src_html = '<div class="col-md-4">&nbsp;</div> \
    <div class="col-md-4"> \
<select name="dataUseData-'+myId+'[\'src_country\']['+ idSuffixNum.toString()+'][\'src_country_locode\']" class="js-example-basic-single" style="width:240px;"> \
<option value="">Select</option> \
<option value="AF">Afghanistan</option> \
<option value="AX">Åland Islands</option> \
<option value="AL">Albania</option> \
<option value="DZ">Algeria</option> \
<option value="AS">American Samoa</option> \
<option value="AD">Andorra</option> \
<option value="AO">Angola</option> \
<option value="AI">Anguilla</option> \
<option value="AQ">Antarctica</option> \
<option value="AG">Antigua and Barbuda</option> \
<option value="AR">Argentina</option> \
<option value="AM">Armenia</option> \
<option value="AW">Aruba</option> \
<option value="AU">Australia</option> \
<option value="AT">Austria</option> \
<option value="AZ">Azerbaijan</option> \
<option value="BS">Bahamas</option> \
<option value="BH">Bahrain</option> \
<option value="BD">Bangladesh</option> \
<option value="BB">Barbados</option> \
<option value="BY">Belarus</option> \
<option value="BE">Belgium</option> \
<option value="BZ">Belize</option> \
<option value="BJ">Benin</option> \
<option value="BM">Bermuda</option> \
<option value="BT">Bhutan</option> \
<option value="BO">Bolivia</option> \
<option value="BQ">Bonaire, Sint Eustatius and Saba</option> \
<option value="BA">Bosnia and Herzegovina</option> \
<option value="BW">Botswana</option> \
<option value="BR">Brazil</option> \
<option value="IO">British Indian Ocean Territory</option> \
<option value="BN">Brunei Darussalam</option> \
<option value="BG">Bulgaria</option> \
<option value="BF">Burkina Faso</option> \
<option value="BI">Burundi</option> \
<option value="KH">Cambodia</option> \
<option value="CM">Cameroon</option> \
<option value="CA">Canada</option> \
<option value="CV">Cape Verde</option> \
<option value="KY">Cayman Islands</option> \
<option value="CF">Central African Republic</option> \
<option value="TD">Chad</option> \
<option value="CL">Chile</option> \
<option value="CN">China</option> \
<option value="CX">Christmas Island</option> \
<option value="CC">Cocos (Keeling) Islands</option> \
<option value="CO">Colombia</option> \
<option value="KM">Comoros</option> \
<option value="CG">Congo</option> \
<option value="CD">Congo, The Democratic Republic of the</option> \
<option value="CK">Cook Islands</option> \
<option value="CR">Costa Rica</option> \
<option value="CI">Côte d\'Ivoire</option> \
<option value="HR">Croatia</option> \
<option value="CU">Cuba</option> \
<option value="CW">Curaçao</option> \
<option value="CY">Cyprus</option> \
<option value="CZ">Czech Republic</option> \
<option value="DK">Denmark</option> \
<option value="DJ">Djibouti</option> \
<option value="DM">Dominica</option> \
<option value="DO">Dominican Republic</option> \
<option value="EC">Ecuador</option> \
<option value="EG">Egypt</option> \
<option value="SV">El Salvador</option> \
<option value="GQ">Equatorial Guinea</option> \
<option value="ER">Eritrea</option> \
<option value="EE">Estonia</option> \
<option value="ET">Ethiopia</option> \
<option value="FK">Falkland Islands (Malvinas)</option> \
<option value="FO">Faroe Islands</option> \
<option value="FJ">Fiji</option> \
<option value="FI">Finland</option> \
<option value="FR">France</option> \
<option value="GF">French Guiana</option> \
<option value="PF">French Polynesia</option> \
<option value="TF">French Southern Territories</option> \
<option value="GA">Gabon</option> \
<option value="GM">Gambia</option> \
<option value="GE">Georgia</option> \
<option value="DE">Germany</option> \
<option value="GH">Ghana</option> \
<option value="GI">Gibraltar</option> \
<option value="GR">Greece</option> \
<option value="GL">Greenland</option> \
<option value="GD">Grenada</option> \
<option value="GP">Guadeloupe</option> \
<option value="GU">Guam</option> \
<option value="GT">Guatemala</option> \
<option value="GG">Guernsey</option> \
<option value="GN">Guinea</option> \
<option value="GW">Guinea-Bissau</option> \
<option value="GY">Guyana</option> \
<option value="HT">Haiti</option> \
<option value="HM">Heard Island and McDonald Islands</option> \
<option value="VA">Holy See (Vatican City State)</option> \
<option value="HN">Honduras</option> \
<option value="HK">Hong Kong</option> \
<option value="HU">Hungary</option> \
<option value="IS">Iceland</option> \
<option value="IN">India</option> \
<option value="ID">Indonesia</option> \
<option value="XZ">Installations in International Waters</option> \
<option value="IR">Iran, Islamic Republic of</option> \
<option value="IQ">Iraq</option> \
<option value="IE">Ireland</option> \
<option value="IM">Isle of Man</option> \
<option value="IL">Israel</option> \
<option value="IT">Italy</option> \
<option value="JM">Jamaica</option> \
<option value="JP">Japan</option> \
<option value="JE">Jersey</option> \
<option value="JO">Jordan</option> \
<option value="KZ">Kazakhstan</option> \
<option value="KE">Kenya</option> \
<option value="KI">Kiribati</option> \
<option value="KP">Korea, Democratic People\'s Republic of</option> \
<option value="KR">Korea, Republic of</option> \
<option value="KW">Kuwait</option> \
<option value="KG">Kyrgyzstan</option> \
<option value="LA">Lao People\'s Democratic Republic</option> \
<option value="LV">Latvia</option> \
<option value="LB">Lebanon</option> \
<option value="LS">Lesotho</option> \
<option value="LR">Liberia</option> \
<option value="LY">Libya</option> \
<option value="LI">Liechtenstein</option> \
<option value="LT">Lithuania</option> \
<option value="LU">Luxembourg</option> \
<option value="MO">Macao</option> \
<option value="MK">Macedonia, The former Yugoslav Republic of</option> \
<option value="MG">Madagascar</option> \
<option value="MW">Malawi</option> \
<option value="MY">Malaysia</option> \
<option value="MV">Maldives</option> \
<option value="ML">Mali</option> \
<option value="MT">Malta</option> \
<option value="MH">Marshall Islands</option> \
<option value="MQ">Martinique</option> \
<option value="MR">Mauritania</option> \
<option value="MU">Mauritius</option> \
<option value="YT">Mayotte</option> \
<option value="MX">Mexico</option> \
<option value="FM">Micronesia, Federated States of</option> \
<option value="MD">Moldova, Republic of</option> \
<option value="MC">Monaco</option> \
<option value="MN">Mongolia</option> \
<option value="ME">Montenegro</option> \
<option value="MS">Montserrat</option> \
<option value="MA">Morocco</option> \
<option value="MZ">Mozambique</option> \
<option value="MM">Myanmar</option> \
<option value="NA">Namibia</option> \
<option value="NR">Nauru</option> \
<option value="NP">Nepal</option> \
<option value="NL">Netherlands</option> \
<option value="NC">New Caledonia</option> \
<option value="NZ">New Zealand</option> \
<option value="NI">Nicaragua</option> \
<option value="NE">Niger</option> \
<option value="NG">Nigeria</option> \
<option value="NU">Niue</option> \
<option value="NF">Norfolk Island</option> \
<option value="MP">Northern Mariana Islands</option> \
<option value="NO">Norway</option> \
<option value="OM">Oman</option> \
<option value="PK">Pakistan</option> \
<option value="PW">Palau</option> \
<option value="PS">Palestine, State of</option> \
<option value="PA">Panama</option> \
<option value="PG">Papua New Guinea</option> \
<option value="PY">Paraguay</option> \
<option value="PE">Peru</option> \
<option value="PH">Philippines</option> \
<option value="PN">Pitcairn</option> \
<option value="PL">Poland</option> \
<option value="PT">Portugal</option> \
<option value="PR">Puerto Rico</option> \
<option value="QA">Qatar</option> \
<option value="RE">Reunion</option> \
<option value="RO">Romania</option> \
<option value="RU">Russian Federation</option> \
<option value="RW">Rwanda</option> \
<option value="BL">Saint Barthélemy</option> \
<option value="SH">Saint Helena, Ascension and Tristan Da Cunha</option> \
<option value="KN">Saint Kitts and Nevis</option> \
<option value="LC">Saint Lucia</option> \
<option value="MF">Saint Martin (French Part)</option> \
<option value="PM">Saint Pierre and Miquelon</option> \
<option value="VC">Saint Vincent and the Grenadines</option> \
<option value="WS">Samoa</option> \
<option value="SM">San Marino</option> \
<option value="ST">Sao Tome and Principe</option> \
<option value="SA">Saudi Arabia</option> \
<option value="SN">Senegal</option> \
<option value="RS">Serbia</option> \
<option value="SC">Seychelles</option> \
<option value="SL">Sierra Leone</option> \
<option value="SG">Singapore</option> \
<option value="SX">Sint Maarten (Dutch Part)</option> \
<option value="SK">Slovakia</option> \
<option value="SI">Slovenia</option> \
<option value="SB">Solomon Islands</option> \
<option value="SO">Somalia</option> \
<option value="ZA">South Africa</option> \
<option value="GS">South Georgia and the South Sandwich Islands</option> \
<option value="SS">South Sudan</option> \
<option value="ES">Spain</option> \
<option value="LK">Sri Lanka</option> \
<option value="SD">Sudan</option> \
<option value="SR">Suriname</option> \
<option value="SJ">Svalbard and Jan Mayen</option> \
<option value="SZ">Swaziland</option> \
<option value="SE">Sweden</option> \
<option value="CH">Switzerland</option> \
<option value="SY">Syrian Arab Republic</option> \
<option value="TW">Taiwan, Province of China</option> \
<option value="TJ">Tajikistan</option> \
<option value="TZ">Tanzania, United Republic of</option> \
<option value="TH">Thailand</option> \
<option value="TL">Timor-Leste</option> \
<option value="TG">Togo</option> \
<option value="TK">Tokelau</option> \
<option value="TO">Tonga</option> \
<option value="TT">Trinidad and Tobago</option> \
<option value="TN">Tunisia</option> \
<option value="TR">Turkey</option> \
<option value="TM">Turkmenistan</option> \
<option value="TC">Turks and Caicos Islands</option> \
<option value="TV">Tuvalu</option> \
<option value="UG">Uganda</option> \
<option value="UA">Ukraine</option> \
<option value="AE">United Arab Emirates</option> \
<option value="GB">United Kingdom</option> \
<option value="US">United States</option> \
<option value="UM">United States Minor Outlying Islands</option> \
<option value="UY">Uruguay</option> \
<option value="UZ">Uzbekistan</option> \
<option value="VU">Vanuatu</option> \
<option value="VE">Venezuela</option> \
<option value="VN">Viet Nam</option> \
<option value="VG">Virgin Islands, British</option> \
<option value="VI">Virgin Islands, U.S.</option> \
<option value="WF">Wallis and Futuna</option> \
<option value="EH">Western Sahara</option> \
<option value="YE">Yemen</option> \
<option value="ZM">Zambia</option> \
<option value="ZW">Zimbabwe</option> \
</select> \
    </div> \
  <div class="col-md-4"> \
      <div class="btn-group" data-toggle="buttons"> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+myId+'[\'src_country\']['+ idSuffixNum.toString()+'][\'src_gov_level\'][]" value="National" />National \
        </label> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+myId+'[\'src_country\']['+ idSuffixNum.toString()+'][\'src_gov_level\'][]" value="State/Province" />State/Province \
        </label> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+myId+'[\'src_country\']['+ idSuffixNum.toString()+'][\'src_gov_level\'][]" value="Local" />Local \
        </label> \
      </div> \
      <span class="dataUseData__clear">×</span> \
  </div> '

  var $div = $("<div>", {class: "row col-md-12 data-src-row", html: data_src_html});

  $('#dataUseData-'+myId.toString()).append($div);

  console.log('#add_data_src_btn_row-'+idSuffixNum);
  $(".js-example-basic-single").select2( 
    { placeholder: "Select",
    allowClear: true }
  );

  $('.dataUseData__clear').on('click', function(e) {
    var msg = "clear dataUse row";
    console.log;
    $(this).parent().parent().remove();
    return false;
  });

  return false;
}


/* Declare the function 'addDataUseOther'
   Add a row to data use question
*/
function addDataUseOther(myId){
  console.log('addDataUseOther called with myid: '+myId);
  // alert('addDataUseOther called with myid: '+myId);
  var data_use_other = '<input type="text" class="form-control" id="data_type_other-'+myId+'" name="data_type_other-'+myId+'" placeholder="Describe other" style="width:180px;" required>';
  $('#data_type_col-'+myId).append(data_use_other);
}

/* Declare the function 'removeDataUseOther'
   Add a row to data use question
*/
function removeDataUseOther(myId){
  console.log('removeDataUseOther called ');
  // alert('removeDataUseOther called with myid: '+myId);
  if ( $('#data_type_other-'+myId).length > 0 ) {
    $('#data_type_other-'+myId).remove();
  }
}

/* Declare the function 'addDataUseOther'
   Add a row to data use question
*/
function addIndustryOther(){
  console.log('addIndustryOther called');
  // alert('addDataUseOther called');
  var new_html = '<input type="text" class="form-control" id="industry_other" name="industry_other" placeholder="Describe other" required>';
  console.log($('#industry_id').parent());
  $('#industry_id').parent().append(new_html);
}

/* Declare the function 'removeDataUseOther'
   Add a row to data use question
*/
function removeIndustryOther(){
  console.log('removeIndustryOther called ');
  // alert('removeDataUseOther called');
  if ( $('#industry_other').length > 0 ) {
    $('#industry_other').remove();
  }
}

/* Declare the function 'addDataUseRow'
   Add a row to data use question
*/
function addDataUseRow(){
  console.log('addDataUse called');

  var rows = $('.data-use-row').length;
  console.log('rows: '+rows);
  var idSuffixNum = rows + 1;
  // alert( idSuffixNum);

  // var x = '<div class="row col-md-12 dataUseGridRow" style="border-bottom:1px solid #eee;">' +
  //  '<div class="col-md-1">('+idSuffixNum.toString()+')</div>'+
  //  '<div class="col-md-3"><a href="#" id="dataType'+idSuffixNum.toString()+'"></a></div>'+
  //  '<div class="col-md-4"><a href="#" id="srcCountry'+idSuffixNum.toString()+'"></a></div>' +
  //  '<div class="col-md-3"><a href="#" id="srcGovLevel'+idSuffixNum.toString()+'"></a></div>' +
  //  '</div><!-- /row -->';

  var data_row = ' \
        <div class="row col-md-12 data-use-row" id="dataUseData-'+idSuffixNum.toString()+'" style="border-bottom:1px solid #eee;"> \
        <div class="col-md-4" id="data_type_col-'+idSuffixNum.toString()+'"> \
          <select name="data_type-'+idSuffixNum.toString()+'" id="data_type-'+idSuffixNum.toString()+'" class="js-example-basic-single data_type"> \
            <option value="">Select</option> \
            <option value="Agriculture">Agriculture</option> \
            <option value="Arts and culture">Arts and culture</option> \
            <option value="Business">Business</option> \
            <option value="Consumer">Consumer</option> \
            <option value="Demographics and social">Demographics and social</option> \
            <option value="Economics ">Economics</option> \
            <option value="Education">Education</option> \
            <option value="Energy">Energy</option> \
            <option value="Environment">Environment</option> \
            <option value="Finance">Finance</option> \
            <option value="Geospatial/mapping">Geospatial/mapping</option> \
            <option value="Government operations">Government operations</option> \
            <option value="Health/healthcare">Health/healthcare</option> \
            <option value="Housing">Housing</option> \
            <option value="International/global development">International/global development</option> \
            <option value="Legal">Legal</option> \
            <option value="Manufacturing">Manufacturing</option> \
            <option value="Science and research">Science and research</option> \
            <option value="Public safety">Public safety</option> \
            <option value="Tourism">Tourism</option> \
            <option value="Transportation">Transportation</option> \
            <option value="Weather">Weather</option> \
            <option value="Other">Other</option> \
          </select> \
        </div> \
 \
        <div class="data-src-row" id="data-src-row-'+idSuffixNum.toString()+'"> \
        <div class="col-md-4">\
<select name="dataUseData-'+idSuffixNum.toString()+'[\'src_country\'][1][\'src_country_locode\']" class="js-example-basic-single" style="width:240px;"> \
<option value="">Select</option> \
<option value="AF">Afghanistan</option> \
<option value="AX">Åland Islands</option> \
<option value="AL">Albania</option> \
<option value="DZ">Algeria</option> \
<option value="AS">American Samoa</option> \
<option value="AD">Andorra</option> \
<option value="AO">Angola</option> \
<option value="AI">Anguilla</option> \
<option value="AQ">Antarctica</option> \
<option value="AG">Antigua and Barbuda</option> \
<option value="AR">Argentina</option> \
<option value="AM">Armenia</option> \
<option value="AW">Aruba</option> \
<option value="AU">Australia</option> \
<option value="AT">Austria</option> \
<option value="AZ">Azerbaijan</option> \
<option value="BS">Bahamas</option> \
<option value="BH">Bahrain</option> \
<option value="BD">Bangladesh</option> \
<option value="BB">Barbados</option> \
<option value="BY">Belarus</option> \
<option value="BE">Belgium</option> \
<option value="BZ">Belize</option> \
<option value="BJ">Benin</option> \
<option value="BM">Bermuda</option> \
<option value="BT">Bhutan</option> \
<option value="BO">Bolivia</option> \
<option value="BQ">Bonaire, Sint Eustatius and Saba</option> \
<option value="BA">Bosnia and Herzegovina</option> \
<option value="BW">Botswana</option> \
<option value="BR">Brazil</option> \
<option value="IO">British Indian Ocean Territory</option> \
<option value="BN">Brunei Darussalam</option> \
<option value="BG">Bulgaria</option> \
<option value="BF">Burkina Faso</option> \
<option value="BI">Burundi</option> \
<option value="KH">Cambodia</option> \
<option value="CM">Cameroon</option> \
<option value="CA">Canada</option> \
<option value="CV">Cape Verde</option> \
<option value="KY">Cayman Islands</option> \
<option value="CF">Central African Republic</option> \
<option value="TD">Chad</option> \
<option value="CL">Chile</option> \
<option value="CN">China</option> \
<option value="CX">Christmas Island</option> \
<option value="CC">Cocos (Keeling) Islands</option> \
<option value="CO">Colombia</option> \
<option value="KM">Comoros</option> \
<option value="CG">Congo</option> \
<option value="CD">Congo, The Democratic Republic of the</option> \
<option value="CK">Cook Islands</option> \
<option value="CR">Costa Rica</option> \
<option value="CI">Côte d\'Ivoire</option> \
<option value="HR">Croatia</option> \
<option value="CU">Cuba</option> \
<option value="CW">Curaçao</option> \
<option value="CY">Cyprus</option> \
<option value="CZ">Czech Republic</option> \
<option value="DK">Denmark</option> \
<option value="DJ">Djibouti</option> \
<option value="DM">Dominica</option> \
<option value="DO">Dominican Republic</option> \
<option value="EC">Ecuador</option> \
<option value="EG">Egypt</option> \
<option value="SV">El Salvador</option> \
<option value="GQ">Equatorial Guinea</option> \
<option value="ER">Eritrea</option> \
<option value="EE">Estonia</option> \
<option value="ET">Ethiopia</option> \
<option value="FK">Falkland Islands (Malvinas)</option> \
<option value="FO">Faroe Islands</option> \
<option value="FJ">Fiji</option> \
<option value="FI">Finland</option> \
<option value="FR">France</option> \
<option value="GF">French Guiana</option> \
<option value="PF">French Polynesia</option> \
<option value="TF">French Southern Territories</option> \
<option value="GA">Gabon</option> \
<option value="GM">Gambia</option> \
<option value="GE">Georgia</option> \
<option value="DE">Germany</option> \
<option value="GH">Ghana</option> \
<option value="GI">Gibraltar</option> \
<option value="GR">Greece</option> \
<option value="GL">Greenland</option> \
<option value="GD">Grenada</option> \
<option value="GP">Guadeloupe</option> \
<option value="GU">Guam</option> \
<option value="GT">Guatemala</option> \
<option value="GG">Guernsey</option> \
<option value="GN">Guinea</option> \
<option value="GW">Guinea-Bissau</option> \
<option value="GY">Guyana</option> \
<option value="HT">Haiti</option> \
<option value="HM">Heard Island and McDonald Islands</option> \
<option value="VA">Holy See (Vatican City State)</option> \
<option value="HN">Honduras</option> \
<option value="HK">Hong Kong</option> \
<option value="HU">Hungary</option> \
<option value="IS">Iceland</option> \
<option value="IN">India</option> \
<option value="ID">Indonesia</option> \
<option value="XZ">Installations in International Waters</option> \
<option value="IR">Iran, Islamic Republic of</option> \
<option value="IQ">Iraq</option> \
<option value="IE">Ireland</option> \
<option value="IM">Isle of Man</option> \
<option value="IL">Israel</option> \
<option value="IT">Italy</option> \
<option value="JM">Jamaica</option> \
<option value="JP">Japan</option> \
<option value="JE">Jersey</option> \
<option value="JO">Jordan</option> \
<option value="KZ">Kazakhstan</option> \
<option value="KE">Kenya</option> \
<option value="KI">Kiribati</option> \
<option value="KP">Korea, Democratic People\'s Republic of</option> \
<option value="KR">Korea, Republic of</option> \
<option value="KW">Kuwait</option> \
<option value="KG">Kyrgyzstan</option> \
<option value="LA">Lao People\'s Democratic Republic</option> \
<option value="LV">Latvia</option> \
<option value="LB">Lebanon</option> \
<option value="LS">Lesotho</option> \
<option value="LR">Liberia</option> \
<option value="LY">Libya</option> \
<option value="LI">Liechtenstein</option> \
<option value="LT">Lithuania</option> \
<option value="LU">Luxembourg</option> \
<option value="MO">Macao</option> \
<option value="MK">Macedonia, The former Yugoslav Republic of</option> \
<option value="MG">Madagascar</option> \
<option value="MW">Malawi</option> \
<option value="MY">Malaysia</option> \
<option value="MV">Maldives</option> \
<option value="ML">Mali</option> \
<option value="MT">Malta</option> \
<option value="MH">Marshall Islands</option> \
<option value="MQ">Martinique</option> \
<option value="MR">Mauritania</option> \
<option value="MU">Mauritius</option> \
<option value="YT">Mayotte</option> \
<option value="MX">Mexico</option> \
<option value="FM">Micronesia, Federated States of</option> \
<option value="MD">Moldova, Republic of</option> \
<option value="MC">Monaco</option> \
<option value="MN">Mongolia</option> \
<option value="ME">Montenegro</option> \
<option value="MS">Montserrat</option> \
<option value="MA">Morocco</option> \
<option value="MZ">Mozambique</option> \
<option value="MM">Myanmar</option> \
<option value="NA">Namibia</option> \
<option value="NR">Nauru</option> \
<option value="NP">Nepal</option> \
<option value="NL">Netherlands</option> \
<option value="NC">New Caledonia</option> \
<option value="NZ">New Zealand</option> \
<option value="NI">Nicaragua</option> \
<option value="NE">Niger</option> \
<option value="NG">Nigeria</option> \
<option value="NU">Niue</option> \
<option value="NF">Norfolk Island</option> \
<option value="MP">Northern Mariana Islands</option> \
<option value="NO">Norway</option> \
<option value="OM">Oman</option> \
<option value="PK">Pakistan</option> \
<option value="PW">Palau</option> \
<option value="PS">Palestine, State of</option> \
<option value="PA">Panama</option> \
<option value="PG">Papua New Guinea</option> \
<option value="PY">Paraguay</option> \
<option value="PE">Peru</option> \
<option value="PH">Philippines</option> \
<option value="PN">Pitcairn</option> \
<option value="PL">Poland</option> \
<option value="PT">Portugal</option> \
<option value="PR">Puerto Rico</option> \
<option value="QA">Qatar</option> \
<option value="RE">Reunion</option> \
<option value="RO">Romania</option> \
<option value="RU">Russian Federation</option> \
<option value="RW">Rwanda</option> \
<option value="BL">Saint Barthélemy</option> \
<option value="SH">Saint Helena, Ascension and Tristan Da Cunha</option> \
<option value="KN">Saint Kitts and Nevis</option> \
<option value="LC">Saint Lucia</option> \
<option value="MF">Saint Martin (French Part)</option> \
<option value="PM">Saint Pierre and Miquelon</option> \
<option value="VC">Saint Vincent and the Grenadines</option> \
<option value="WS">Samoa</option> \
<option value="SM">San Marino</option> \
<option value="ST">Sao Tome and Principe</option> \
<option value="SA">Saudi Arabia</option> \
<option value="SN">Senegal</option> \
<option value="RS">Serbia</option> \
<option value="SC">Seychelles</option> \
<option value="SL">Sierra Leone</option> \
<option value="SG">Singapore</option> \
<option value="SX">Sint Maarten (Dutch Part)</option> \
<option value="SK">Slovakia</option> \
<option value="SI">Slovenia</option> \
<option value="SB">Solomon Islands</option> \
<option value="SO">Somalia</option> \
<option value="ZA">South Africa</option> \
<option value="GS">South Georgia and the South Sandwich Islands</option> \
<option value="SS">South Sudan</option> \
<option value="ES">Spain</option> \
<option value="LK">Sri Lanka</option> \
<option value="SD">Sudan</option> \
<option value="SR">Suriname</option> \
<option value="SJ">Svalbard and Jan Mayen</option> \
<option value="SZ">Swaziland</option> \
<option value="SE">Sweden</option> \
<option value="CH">Switzerland</option> \
<option value="SY">Syrian Arab Republic</option> \
<option value="TW">Taiwan, Province of China</option> \
<option value="TJ">Tajikistan</option> \
<option value="TZ">Tanzania, United Republic of</option> \
<option value="TH">Thailand</option> \
<option value="TL">Timor-Leste</option> \
<option value="TG">Togo</option> \
<option value="TK">Tokelau</option> \
<option value="TO">Tonga</option> \
<option value="TT">Trinidad and Tobago</option> \
<option value="TN">Tunisia</option> \
<option value="TR">Turkey</option> \
<option value="TM">Turkmenistan</option> \
<option value="TC">Turks and Caicos Islands</option> \
<option value="TV">Tuvalu</option> \
<option value="UG">Uganda</option> \
<option value="UA">Ukraine</option> \
<option value="AE">United Arab Emirates</option> \
<option value="GB">United Kingdom</option> \
<option value="US">United States</option> \
<option value="UM">United States Minor Outlying Islands</option> \
<option value="UY">Uruguay</option> \
<option value="UZ">Uzbekistan</option> \
<option value="VU">Vanuatu</option> \
<option value="VE">Venezuela</option> \
<option value="VN">Viet Nam</option> \
<option value="VG">Virgin Islands, British</option> \
<option value="VI">Virgin Islands, U.S.</option> \
<option value="WF">Wallis and Futuna</option> \
<option value="EH">Western Sahara</option> \
<option value="YE">Yemen</option> \
<option value="ZM">Zambia</option> \
<option value="ZW">Zimbabwe</option> \
</select> \
        </div> \
 \
  <div class="col-md-4"> \
      <div class="btn-group" data-toggle="buttons"> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+idSuffixNum.toString()+'[\'src_country\'][1][\'src_gov_level\'][]" value="National" />National \
        </label> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+idSuffixNum.toString()+'[\'src_country\'][1][\'src_gov_level\'][]" value="State/Province" />State/Province \
        </label> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+idSuffixNum.toString()+'[\'src_country\'][1][\'src_gov_level\'][]" value="Local" />Local \
        </label> \
      </div> \
  </div> \
         </div> <!-- /data-src-row --> \
        <br /> \
  \
      </div> <!-- /dataUseData-1 --> \
      \
    <div class="row add_data_src_btn_row" id="add_data_src_btn_row-'+idSuffixNum.toString()+'"> \
      <div class="col-md-4"> \
        &nbsp; \
      </div> \
      <div class="col-md-4"> \
        <button class="btn btn-default btn-xs" id="add_data_src_btn-'+idSuffixNum.toString()+'" type="" style="font-size:0.75em;">Add data source</button> \
      </div> \
      <div class="col-md-4"> \
        &nbsp; \
      </div> \
    </div> \
 \
      <br /> <!-- new row id: '+idSuffixNum.toString()+' -->';

    $('#dataUse').append(data_row);

    // Clear change actions on .data_type
    $('.data_type').off("change");
    // Set change action on .data_type
    $('.data_type').on("change", function(e) {
      // Split id to get iteration of data_use
      myId = this.id.split("-")[1];
      // alert("myId: "+myId);
      var sel_val = $('#'+this.id).select2().val();
      // alert('sel_val: '+sel_val);
      if (sel_val == "Other") {
        addDataUseOther(myId);
      } else {
        removeDataUseOther(myId);
      }
    });

    $(".basic-single-industry").select2( 
      { placeholder: "Select an industry",
      allowClear: true }
    );

    $(".js-example-basic-single").select2( 
      { placeholder: "Select",
      allowClear: true }
    );

    $(".country-basic-multiple").select2(
      { placeholder: "Select country sources",
      allowClear: true }
    );
    $(".basic-multiple").select2(
      {placeholder: "Select levels",
      allowClear: true}
    );

    // Add data use row
    $('#add_data_src_btn-'+idSuffixNum.toString()).on('click', function(event) {
      event.preventDefault(); // To prevent following the link (optional)
      var msg = "add_data_src_btn-x clicked";
      // alert(msg);
      myId = this.id.split("-")[1];
      // alert(myId);
      addDataSrc(myId);
      // addDataUseRow();
      return false;
    });
 
}

// Improved data use profile
// $('input[type=radio][name=data_type_count]').change(function() {
//   updateDataUseProfile();
// });

// $('input[type=radio][name=data_country_count]').change(function() {
//   updateDataUseProfile();
// });

function updateDataUseProfile() {
  // alert('updateDataUseProfile');
  //$('input:checkbox[name=SOMENAME]')
  var data_type_count = $('input[type=radio][name=data_type_count]:checked').val();
  var data_country_count = $('input[type=radio][name=data_country_count]:checked').val();
  if (typeof data_type_count !== 'undefined' && typeof data_country_count !== 'undefined') {
    alert('types: '+data_type_count+'\ncountries: '+data_country_count);
    // role-dataUse
    var content = "<h4>Connidtional questions based on type and country count appears here</h4>";
    $('#data_use_details').append(content);
  }  

}



// testing methods
function fillForm() {
  // fill survey form
  $('input#org_name').val("Test Company");
  // $("input[id=Nonprofit]").prop('checked', true);
  $('input#org_url').val("http://www.testcompany.com"); 
  $('input#org_year_founded').val("2009");
  $('textarea#org_description').val("This is a test description");
  $('textarea#org_additional').val("This organization has a big impact...");
  $('input#survey_contact_first').val("Greg");
  $('input#survey_contact_last').val("Elin");
  $('input#survey_contact_title').val("Director of Surveys");
  $('input#survey_contact_email').val("greg@odesurvey.org");
  $('input#survey_contact_phone').val("505-555-1212");
}
