#!/usr/bin/env python
# -*- coding: utf-8 -*-
#
# Name: odeinventory.py
# Author: Greg Elin gregelin@gitmachines.com
# Copyright: 2015, Center for Open Data Enterprise and GovReady PBC. All Rights Reserved.
# Version 1.0.1
#
# About: Parses internal Inventory.xlsx spreadsheet to generate org_profile.json
#        and arcgis_flatfile.json for importining into Parse.com database
#        
# Usage: python odeinventory.py
# Output: org_profile.json and arcgis_flatfile.json
#
# Change Log:
#   Version 1.0.1 - Moved location reference data into external json files
#   Version 1.0.0 - Everything working OK.
#

import xlrd
from collections import OrderedDict
import simplejson as json
import random
import copy
import re

# Read in look up data
# Read in location look ups
with open('locs.json') as data_file:
    locs = json.load(data_file)
# Read in Worldbank Region data
with open('regions.json') as data_file:
    regions = json.load(data_file)
# spreadsheet fields
with open('spreadsheet_fields.json') as data_file:
    fields = json.load(data_file)

# Open the workbook and select the first worksheet
xlsx_file = "Inventory.xlsx"

wb = xlrd.open_workbook(xlsx_file)
print "The file name is", xlsx_file
print "The number of worksheets is", wb.nsheets
print wb.sheet_names()

sh = wb.sheet_by_index(0)
print sh.name, sh.nrows, sh.ncols

#
# Functions
#

# Test if organization qualifies to be included
def org_include(org):
    # if org['eligibility'] == 'Y' and org['org_confidence'] > 3 and org['org_hq_country'] != "Spain" and (org['latitude'] is not None) and org['latitude'] != 0 and org['longitude'] != 0 :
    if "Y" != org['eligibility'] and "YY" != org['eligibility']:
        print "skipped b/c org['eligibility'] is %s" % (org['eligibility'])
        return False
    if org['org_profile_src'].find("OD500 (unsubmitted)") > -1:
        print "skipped b/c org['org_profile_src'] is %s" % (org['org_profile_src'])
        return False
    if org['org_profile_src'].find("OD500 AU") > -1:
        print "skipped b/c org['org_profile_src'] is %s" % (org['org_profile_src'])
        return False
    if org['org_profile_src'].find("data.gob.es") > -1:
        print "skipped b/c org['org_profile_src'] is %s" % (org['org_profile_src'])
        return False
    # If we got here, record should be included
    return True

# List to hold dictionaries
org_list = []
org_list_not_used = []
org_errors = []
cnt = 0
# # Iterate through each row in worksheet and fetch values into dict
# for rownum in range(1, 50):
for rownum in range(0, sh.nrows):
    # print "hidden? %n" % sh.row_values(rownum).col_hidden
    cnt +=1
    org = OrderedDict()
    # Get values of all cells in the row
    row_values = sh.row_values(rownum)
    # print row_values

    # Assign values to object
    org['profile_id'] = str(cnt)
    org['eligibility'] = row_values[0]
    org['org_name'] = row_values[2]
    
    print "\nrow %d: %s\n===================================================" % (rownum, org['org_name'])
    
    org['org_type'] = row_values[3]
    org['org_type_other'] = None

    org['org_url'] = row_values[4]
    org['no_org_url'] = False
    org['org_description'] = row_values[5]
    # org_type_other
    org['org_hq_city'] = row_values[6]
    org['org_hq_st_prov'] = row_values[7]
    org['org_hq_country'] = row_values[8]
    # if org['org_hq_country'] == "USA":
    #     org['org_hq_country_locode'] = 'US'

    # print "loc: %s, %s, %s" % (org['org_hq_city'],org['org_hq_st_prov'], org['org_hq_country'])

    org['industry_id'] = row_values[9]
    
    try:
        org['org_year_founded'] = int(row_values[10])
    except:
        org['org_year_founded'] = None

    org['org_size_id'] = row_values[11]
    org['org_greatest_impact'] = row_values[12]
    # print "impact", org['org_greatest_impact']
    org['org_greatest_impact_detail'] = None
    # print len(org['org_greatest_impact'])
    if "(" in org['org_greatest_impact']:
        org['org_greatest_impact'], org['org_greatest_impact_detail'] = org['org_greatest_impact'].split("(")
        org['org_greatest_impact_detail'] = org['org_greatest_impact_detail'].strip(")")

    org['data_use_unparsed'] = row_values[13]
    org['usage_unparsed'] = row_values[14]
    org['org_profile_src'] = row_values[15]
    if "survey" == org['org_profile_src'] or "submitted" == ['org_profile_src'] or "submitted survey" == ['org_profile_src']:
        org['org_profile_category'] = 'submitted survey'
    else:
        org['org_profile_category'] = 'researched'

    try:
        org['org_confidence'] = int(row_values[26])
    except:
        org['org_confidence'] = None

    # print org['org_confidence']
    org['org_profile_year'] = 2015
    # org['latitude'] = None
    # org['longitude'] = None
    org['org_profile_status'] = 'test'
    org['date_created'] = '2015-05-06'
    org['date_modified'] = '2015-05-06'
    org['org_additional'] = ''

    # Fix variables
    org_types = { "Private" : "For-profit",
        "Private" : "For-profit",
        "For profit" : "For-profit",
        "For Profit" : "For-profit"
    }
    try:
    	org['org_type'] = org_types[org['org_type']]
    except:
    	org['org_type_other'] = org['org_type']
    	org['org_type'] = "Other"


    sizes = {"NA" : None,
"1-10" : "1-10",
"11-50" : "11-50",
"51-200" : "51-200",
"201-500" : "201-1000",
"501-1,000" : "1000+",
"1000+" : "1000+",
"1,001-5,000" : "1000+",
"5,001-10,000" : "1000+",
"10,001+" : "1000+"
}
    try:
        org['org_size_id'] = sizes[org['org_size_id']]
    except:
        org['org_size_id'] = None

    try:
    	loc = "%s %s %s" % (org['org_hq_city'],org['org_hq_st_prov'], org['org_hq_country'])
    	org['org_hq_city'] = locs[loc][0]
    	org['org_hq_st_prov'] = locs[loc][1]
        org['org_hq_country_locode'] = locs[loc][2]
        org['latitude'] = float(locs[loc][3])
    	org['longitude'] = float(locs[loc][4])
        #print "%s, %s" % (org['latitude'], org['longitude'])
        print "loc match success"
    except:
    	org['org_hq_city'] = None
    	org['org_hq_st_prov'] = None
        org['org_hq_country_locode'] = None
        org['latitude'] = None
    	org['longitude'] = None
        print "loc match failed"
        # print org['org_hq_city'], org['org_hq_country'], org['latitude']


    try:
        # org['org_hq_country_locode'] 
        #print "%s %s" % (org['org_hq_country_locode'], regions[org['org_hq_country_locode']]['REGION'])
        org['org_hq_country_region'] = regions[org['org_hq_country_locode']]['REGION']
        org['org_hq_country_income'] = regions[org['org_hq_country_locode']]['INCOME']
        org['org_hq_country_income_code'] = regions[org['org_hq_country_locode']]['INCOME CODE']
    except:
        print "missing region code"
        org['org_hq_country_region'] = None
        org['org_hq_country_income'] = None
        org['org_hq_country_income_code'] = None

    # fix country code
    if (3 == len(org['org_hq_country']) and 'EUR' != org['org_hq_country']):
        org['org_hq_country'] = regions[org['org_hq_country']]['COUNTRY']
    
    if  org['org_hq_country_locode'] is not None and 3 == len(org['org_hq_country_locode']) and 'EUR' != org['org_hq_country_locode']:
        org['org_hq_country_locode'] = regions[org['org_hq_country_locode']]['ISO3166-1-UNLOC']
        
    # parse usage_unparsed
    usage_key = {
    "new" : "use_prod_srvc",
    "optimization" : "use_org_opt",
    "Optimization" : "use_org_opt",
    "research" : "use_research",
    "advocacy" : "use_advocacy",
    "other" : "use_other",
    "Type of use" : "use_other"
    }
    for key in usage_key.keys():
        org[usage_key[key]] = False
        org[usage_key[key]+"_desc"] = None      
    usages = org['usage_unparsed'].split("|")
    for usage in usages:
        #print "use: %s" % usage.strip()
        usage_split = usage.split(":")
        if len(usage_split) < 1:
            continue
        if len(usage_split) < 2:
            usage_split.append("")
        usage_split[0] = usage_split[0].strip()
        usage_split[1] = usage_split[1].strip()
        #print "***%s, %s" % (usage_split[0], usage_split[1])

        try:
            # print "(%s)->%s" % (usage_split[0], usage_key[usage_split[0]])
            org[usage_key[usage_split[0]]] = True
            org[usage_key[usage_split[0]]+"_desc"] = usage_split[1]
        except:
            print "ERROR on usage_key[usage_split[0]: "
        # print "usage_split[1] %s" % usage_split[1]
        # print usage_key[usage_split[0]]+"_desc"
    # variable dump
    # print org
    # delete unparsed key
    org.pop('usage_unparsed', None)

#   Append org if eligible
    if org_include(org):
        org_list.append(org)
    else:
        org_list_not_used.append(org)

#     #print org_list
print "========================================"
print "rows used:", len(org_list)
print "rows not used:", len(org_list_not_used)

# Serialize the list of dicts to JSON
results = { "results": org_list }
# j = json.dumps(org_list)
j = json.dumps(results, sort_keys=False, indent=4, separators=(',', ': '))
# print j
# Write to file
with open('org_profile.json', 'w') as f:
    f.write(j)

# Now generate ArcGIS Flat file
# data_type = ["Agriculture", "Arts and culture", "Business", "Consumer", "Demographics and social", "Economics", "Education", "Other"]
# country = {"AF" : "Afghanistan", "AX" : "Åland Islands", "AL" : "Albania", "DZ" : "Algeria", "AS" : "American Samoa", "AD" : "Andorra", "AO" : "Angola", "AI" : "Anguilla", "AQ" : "Antarctica", "AG" : "Antigua and Barbuda", "AR" : "Argentina", "AM" : "Armenia", "AW" : "Aruba", "AU" : "Australia", "AT" : "Austria", "AZ" : "Azerbaijan", "BS" : "Bahamas", "BH" : "Bahrain", "BD" : "Bangladesh", "BB" : "Barbados", "BY" : "Belarus", "BE" : "Belgium", "BZ" : "Belize", "BJ" : "Benin", "BM" : "Bermuda", "BT" : "Bhutan", "BO" : "Bolivia", "BQ" : "Bonaire, Sint Eustatius and Saba", "BA" : "Bosnia and Herzegovina", "BW" : "Botswana", "BR" : "Brazil", "IO" : "British Indian Ocean Territory", "BN" : "Brunei Darussalam", "BG" : "Bulgaria", "BF" : "Burkina Faso", "BI" : "Burundi", "KH" : "Cambodia", "CM" : "Cameroon", "CA" : "Canada", "CV" : "Cape Verde", "KY" : "Cayman Islands", "CF" : "Central African Republic", "TD" : "Chad", "CL" : "Chile", "CN" : "China", "CX" : "Christmas Island", "CC" : "Cocos (Keeling) Islands", "CO" : "Colombia", "KM" : "Comoros", "CG" : "Congo", "CD" : "Congo, The Democratic Republic of the", "CK" : "Cook Islands", "CR" : "Costa Rica", "CI" : "Côte d\'Ivoire", "HR" : "Croatia", "CU" : "Cuba", "CW" : "Curaçao", "CY" : "Cyprus", "CZ" : "Czech Republic", "DK" : "Denmark", "DJ" : "Djibouti", "DM" : "Dominica", "DO" : "Dominican Republic", "EC" : "Ecuador", "EG" : "Egypt", "SV" : "El Salvador", "GQ" : "Equatorial Guinea", "ER" : "Eritrea", "EE" : "Estonia", "ET" : "Ethiopia", "FK" : "Falkland Islands (Malvinas)", "FO" : "Faroe Islands", "FJ" : "Fiji", "FI" : "Finland", "FR" : "France", "GF" : "French Guiana", "PF" : "French Polynesia", "TF" : "French Southern Territories", "GA" : "Gabon", "GM" : "Gambia", "GE" : "Georgia", "DE" : "Germany", "GH" : "Ghana", "GI" : "Gibraltar", "GR" : "Greece", "GL" : "Greenland", "GD" : "Grenada", "GP" : "Guadeloupe", "GU" : "Guam", "GT" : "Guatemala", "GG" : "Guernsey", "GN" : "Guinea", "GW" : "Guinea-Bissau", "GY" : "Guyana", "HT" : "Haiti", "HM" : "Heard Island and McDonald Islands", "VA" : "Holy See (Vatican City State)", "HN" : "Honduras", "HK" : "Hong Kong", "HU" : "Hungary", "IS" : "Iceland", "IN" : "India", "ID" : "Indonesia", "XZ" : "Installations in International Waters", "IR" : "Iran, Islamic Republic of", "IQ" : "Iraq", "IE" : "Ireland", "IM" : "Isle of Man", "IL" : "Israel", "IT" : "Italy", "JM" : "Jamaica", "JP" : "Japan", "JE" : "Jersey", "JO" : "Jordan", "KZ" : "Kazakhstan", "KE" : "Kenya", "KI" : "Kiribati", "KP" : "Korea, Democratic People\'s Republic of", "KR" : "Korea, Republic of", "KW" : "Kuwait", "KG" : "Kyrgyzstan", "LA" : "Lao People\'s Democratic Republic", "LV" : "Latvia", "LB" : "Lebanon", "LS" : "Lesotho", "LR" : "Liberia", "LY" : "Libya", "LI" : "Liechtenstein", "LT" : "Lithuania", "LU" : "Luxembourg", "MO" : "Macao", "MK" : "Macedonia, The former Yugoslav Republic of", "MG" : "Madagascar", "MW" : "Malawi", "MY" : "Malaysia", "MV" : "Maldives", "ML" : "Mali", "MT" : "Malta", "MH" : "Marshall Islands", "MQ" : "Martinique", "MR" : "Mauritania", "MU" : "Mauritius", "YT" : "Mayotte", "MX" : "Mexico", "FM" : "Micronesia, Federated States of", "MD" : "Moldova, Republic of", "MC" : "Monaco", "MN" : "Mongolia", "ME" : "Montenegro", "MS" : "Montserrat", "MA" : "Morocco", "MZ" : "Mozambique", "MM" : "Myanmar", "NA" : "Namibia", "NR" : "Nauru", "NP" : "Nepal", "NL" : "Netherlands", "NC" : "New Caledonia", "NZ" : "New Zealand", "NI" : "Nicaragua", "NE" : "Niger", "NG" : "Nigeria", "NU" : "Niue", "NF" : "Norfolk Island", "MP" : "Northern Mariana Islands", "NO" : "Norway", "OM" : "Oman", "PK" : "Pakistan", "PW" : "Palau", "PS" : "Palestine, State of", "PA" : "Panama", "PG" : "Papua New Guinea", "PY" : "Paraguay", "PE" : "Peru", "PH" : "Philippines", "PN" : "Pitcairn", "PL" : "Poland", "PT" : "Portugal", "PR" : "Puerto Rico", "QA" : "Qatar", "RE" : "Reunion", "RO" : "Romania", "RU" : "Russian Federation", "RW" : "Rwanda", "BL" : "Saint Barthélemy", "SH" : "Saint Helena, Ascension and Tristan Da Cunha", "KN" : "Saint Kitts and Nevis", "LC" : "Saint Lucia", "MF" : "Saint Martin (French Part)", "PM" : "Saint Pierre and Miquelon", "VC" : "Saint Vincent and the Grenadines", "WS" : "Samoa", "SM" : "San Marino", "ST" : "Sao Tome and Principe", "SA" : "Saudi Arabia", "SN" : "Senegal", "RS" : "Serbia", "SC" : "Seychelles", "SL" : "Sierra Leone", "SG" : "Singapore", "SX" : "Sint Maarten (Dutch Part)", "SK" : "Slovakia", "SI" : "Slovenia", "SB" : "Solomon Islands", "SO" : "Somalia", "ZA" : "South Africa", "GS" : "South Georgia and the South Sandwich Islands", "SS" : "South Sudan", "ES" : "Spain", "LK" : "Sri Lanka", "SD" : "Sudan", "SR" : "Suriname", "SJ" : "Svalbard and Jan Mayen", "SZ" : "Swaziland", "SE" : "Sweden", "CH" : "Switzerland", "SY" : "Syrian Arab Republic", "TW" : "Taiwan, Province of China", "TJ" : "Tajikistan", "TZ" : "Tanzania, United Republic of", "TH" : "Thailand", "TL" : "Timor-Leste", "TG" : "Togo", "TK" : "Tokelau", "TO" : "Tonga", "TT" : "Trinidad and Tobago", "TN" : "Tunisia", "TR" : "Turkey", "TM" : "Turkmenistan", "TC" : "Turks and Caicos Islands", "TV" : "Tuvalu", "UG" : "Uganda", "UA" : "Ukraine", "AE" : "United Arab Emirates", "GB" : "United Kingdom", "US" : "United States", "UM" : "United States Minor Outlying Islands", "UY" : "Uruguay", "UZ" : "Uzbekistan", "VU" : "Vanuatu", "VE" : "Venezuela", "VN" : "Viet Nam", "VG" : "Virgin Islands, British", "VI" : "Virgin Islands, U.S.", "WF" : "Wallis and Futuna", "EH" : "Western Sahara", "YE" : "Yemen", "ZM" : "Zambia", "ZW" : "Zimbabwe"}
# create new array
data_use_flat = []

print "\n\n************************************\n org processing complete \n Starting on processing data use \n************************************\n"

cnt = 0
# Get data use for each record
for org in org_list:
    cnt += 1
    # print cnt
    # add row for org org_profile
    data_srcs = org['data_use_unparsed'].split("|")
    # Delete unparsed element
    org.pop('data_use_unparsed', None)
    
    org['data_type'] = None
    org['data_src_country_locode'] = None
    org['data_src_gov_level'] = None
    org['row_type'] = "org_profile"
    data_use_flat.append(copy.copy(org))
    
    # Split data use using data_srcs
    print "%s, %s" % (org['profile_id'], org['org_name'])    
    for data_src in data_srcs:
        print data_src.strip("")
        org['row_type'] = "data_use"
        if 0 == len(data_src) or None == data_src or "null" == data_src:
            org['data_type'] = None
            org['data_src_country_locode'] = None
            org['data_src_country_name'] = None
            org['data_src_gov_level'] = None
            continue
        try:
            org['data_type'], org['data_src_country_locode'], org['data_src_gov_level'] = data_src.split(";")
            org['data_type'] = org['data_type'].strip()
            org['data_src_gov_level'] = org['data_src_gov_level'].strip()
            org['data_src_country_name'] = None
            org['data_src_country_locode'] = org['data_src_country_locode'].strip()
        except:
            org_errors.append( "%s: error splitting data_src %s" % (org['org_name'], data_src ) )
        
        if  org['data_src_country_locode'] is not None and 3 == len(org['data_src_country_locode']) and 'EUR' != org['data_src_country_locode']:
            # print "????%s?%s--regions:%s" % (org['data_src_country_locode'], org['data_src_country_locode'],regions[org['data_src_country_locode']]['COUNTRY-NAME'])
            # IMPORTANT get data_src_country_name before changing data_src_country_locode
            org['data_src_country_name'] = regions[org['data_src_country_locode']]['COUNTRY-NAME']
            org['data_src_country_locode'] = regions[org['data_src_country_locode']]['ISO3166-1-UNLOC']
            print org['data_src_country_name']
            
        # Append copy of object to data_use_flatfile
        data_use_flat.append(copy.copy(org))

results = { "results": data_use_flat }
# j = json.dumps(org_list)
j = json.dumps(results, sort_keys=False, indent=4, separators=(',', ': '))
# print j
# Write to file
with open('arcgis_flatfile.json', 'w') as f:
    f.write(j)


#     #print org_list
print "============"
print "rows used:", len(org_list)
print "rows not used:", len(org_list_not_used)
print "orgs with errors", len(org_errors), org_errors

