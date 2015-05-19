/*
 * Custom javascript for Center for Open Data Enterprise
 * Project Open Data Survey
 * Author: Greg Elin, GovReady PBC
 * Copyright Greg Elin & Center for Open Data Enterprise, 2015. All Rights Reserved.
 *
 */

// force reload of javascript file
// use: reload_js('source_file.js');
function reload_js(src) {
    $('script[src="' + src + '"]').remove();
    $('<script>').attr('src', src).appendTo('head');
}


// testing method
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
  $('input[type=radio][value="For-profit"]').click();
  $('input[type=radio][value="Economic"]').click();

  $('input#org_greatest_impact_other').val("Economic details here");
  
  $('input[type=radio][value=dat]').prop("checked", true);
  $('input[type=radio][value="1 - 10"]').click(); 

  $('input[type=checkbox][name="use_prod_srvc"]').click(); 
  $('input#use_prod_srvc_desc').val("we develop products and services");
  $('input#org_hq_city_all').val("Chicago, Illinois, United States");
  $('input#org_hq_city').val("Chicago");
  $('input#org_hq_st_prov').val("Illinois");
  $('input#org_hq_country').val("US");
  $('input#latitude').val("41.8781136");
  $('input#longitude').val("-87.62979819999998");
  $('input[type=checkbox][value=Business]').prop("checked", true);
  $('input[type=radio][value="2 - 5"]').click();

  // Let's fill in the data use form
  $('input[type=checkbox][value=Agriculture]').prop("checked", true);
  $('input[type=checkbox][value="Arts and culture"]').prop("checked", true);
  $('input[type=checkbox][name="dataUseData-1[\'src_country\'][1][Business][\'src_gov_level\'][]"]').click(); 
  $('input[type=checkbox][name="dataUseData-2[\'src_country\'][1][Business][\'src_gov_level\'][]"]').click(); 
  $('input[type=checkbox][name="dataUseData-3[\'src_country\'][1][Business][\'src_gov_level\'][]"]').click(); 
  $('input[type=select][name="dataUseData-1[\'src_country\'][1][\'src_country_locode\']"]').val("US");

  return true;
}

// String sizestring method
function sizestring(string, strlen){
  // if string too short, pad string
  if (string.length < strlen) {
    pad_len = strlen - string.length;
    return string + Array(pad_len).join('&nbsp;');
  }

  // if string too long, shorten
  if (string.length > strlen)
    return string.substring(0,strlen)+'...';
  else
    return string;
};

// Use of Open Data Interactivity
function updateDataUseProfile(e) {
  toggleDataTypeGuidance();

  var data_country_count = $('input[type=radio][name=data_country_count]:checked').val();
  if (typeof data_country_count !== 'undefined') {

    switch (data_country_count) {
      case "1":
        country_count = 1;
        country_text = "country";
        break;
      case "2 - 5":
        country_count = 3;
        country_text = "top 3 countries";
        break;
      case "6 - 10":
        country_count = 3;
        country_text = "top 3 countries";
        break;
      default:
      country_count = 3;
        country_text = "top 3 countries";
    } 

    // empty holding div
    $('#data_use_details').empty();

    var content_question =  '<div class=" col-md-12" style="border:0px solid black;" id="data_details">Indicate the '+country_text+' that provide the data used by your organization, and whether the data is national and/or local (province/state/city).</div>';
    $('#data_use_details').append(content_question);

    for (var c = 1; c <= country_count; c++) {
      var content = getCountries(c);
      var content_data_types = getTypes(c,'data_use_type');

    // alert(data_use_html.length);

    if (c == 1) {
      //  data-intro="Select a country whose data you use." data-position="top"
      var new_html = '<div class="col-md-12 data_detail_row" data-intro="Click National or Local to show government level of data used." data-position="top"><div class="row col-md-12" style="border:0px solid #ddd;" >'+
      content+
      '<div class="col-md-7">'+content_data_types+'</div>' +
      '</div></div>';
    } else {
      var new_html = '<div class="col-md-12 data_detail_row"><div class="row col-md-12" style="border:0px solid #ddd;" >'+
      content+
      '<div class="col-md-7">'+content_data_types+'</div>' +
      '</div></div>';
    }

      $('#data_use_details').append(new_html);
    }    
  }
  // Set selection to select2 type
  $(".js-example-basic-single").select2( 
    { placeholder: "Select",
    allowClear: true }
  );

  if (country_count > 0 ) {
    reload_js('/map/survey/js/chardinjs.min.js');
    $('body').chardinJs('start');

    // add event listener to capture any click to stop the guidance overlay
    document.addEventListener('mousedown', listener_guidance_click, false);

  }
}

// set onscreen guidance only for checked data types
function toggleDataTypeGuidance () {
    // add online guidance
     // clear on screen guidance
    $('input[type=checkbox][class=data_use_type]').map(function(){  $(this).removeAttr('data-intro'); });
    $('input[type=checkbox][class=data_use_type]').map(function(){  $(this).removeAttr('data-position'); });
    $('input[type=checkbox][class=data_use_type]').map(function(){  $(this).next("span").css('font-weight', 'normal'); });
    
    // add online guidance for checked items
    $('input[type=checkbox][class=data_use_type]:checked').map(function(){  $(this).next("span").css('font-weight', 'bold'); });
    $('input[type=checkbox][class=data_use_type]:checked').map(function(){  $(this).attr('data-intro', sizestring($(this).val(), 12) ); });
    $('input[type=checkbox][class=data_use_type]:checked').map(function(){  $(this).attr('data-position', 'right'); });
}

// Listener to capture all clicks to stop overlay guidance
var listener_guidance_click = function (e) {
  $('body').chardinJs('stop');
}

// manage data use
function getTypes(idSuffixNum, selectName) {
  // get array of selected items
  var data_use_type = $('input[type=checkbox][class='+selectName+']:checked').map(function(){ return $(this).val(); }).get();
  console.log(data_use_type);

  var data_use_html = "";
  data_use_type.forEach(function (entry) {
    // Use Other value if set
    if (entry == "Other" && $('input[name="data_use_type_other"]').val() != '') {
      entry = $('input[name="data_use_type_other"]').val();
    }
    console.log(entry);

    // if (data_use_html.length == 0) {
    //   var xx = 'data-intro="info here" data-position="above"';
    // } else {
    //   var xx = '';
    // }

    var gov_level = ' \
    <span class="col-md-4" style="border:0px solid black;"> \
    <span class="" id="" style="font-size:0.8em;">'+sizestring(entry, 18)+'</span> \
      <div class="btn-group" data-toggle="buttons"> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+idSuffixNum.toString()+'[src_country][type]['+entry+'][src_gov_level][]" value="National">National \
        </label> \
        <label class="btn btn-default" style="font-size:0.6em"> \
            <input type="checkbox" name="dataUseData-'+idSuffixNum.toString()+'[src_country][type]['+entry+'][src_gov_level][]" value="Local">Local \
        </label> \
      </div> \
      </span>';
    data_use_html = data_use_html + gov_level;
  })

  return '<div class="col-md-12" style="">'+data_use_html+'</div>';
}

function getCountries(idSuffixNum) {
  var guid_attr = '';
  if (idSuffixNum == 1) {
    var guid_attr = 'data-intro="Select country providing data used by your organization" data-position="top"';
  }

  var select_countries = ' \
        <div class="data-src-row col-md-3" id="data-src-row-'+idSuffixNum.toString()+' style="" '+guid_attr+'> Data source - Country\
<select name="dataUseData-'+idSuffixNum.toString()+'[src_country][src_country_locode]" class="js-example-basic-single" style="width:240px;"> \
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
        </div> ';
  return select_countries;
}

