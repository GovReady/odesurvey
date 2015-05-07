#!/usr/bin/env python
# -*- coding: utf-8 -*-

import xlrd
from collections import OrderedDict
import simplejson as json
import random
import copy

# Open the workbook and select the first worksheet

xlsx_file = "Inventory.xlsx"

wb = xlrd.open_workbook(xlsx_file)
print "The file name is", xlsx_file
print "The number of worksheets is", wb.nsheets
print wb.sheet_names()

sh = wb.sheet_by_index(0)
print sh.name, sh.nrows, sh.ncols

# List to hold dictionaries
org_list = []
org_list_not_used = []
cnt = 0
# # Iterate through each row in worksheet and fetch values into dict
# for rownum in range(1, sh.nrows):
for rownum in range(1, sh.nrows):
    cnt +=1
    org = OrderedDict()
    # Get values of all cells in the row
    row_values = sh.row_values(rownum)
    # print row_values
    
    # Assign values to object
    org['profile_id'] = str(cnt)
    org['eligibility'] = row_values[0]
    org['org_name'] = row_values[2]
    org['org_type'] = row_values[3]
    org['org_type_other'] = None

    org['org_url'] = row_values[4]
    org['org_description'] = row_values[5]
    # org_type_other
    org['org_hq_city'] = row_values[6]
    org['org_hq_country'] = row_values[8]
    if org['org_hq_country'] == "USA":
        org['org_hq_country_locode'] = 'US'

    org['industry_id'] = row_values[9]
    # randomly select industry category
    industries =["agr", "art", "bus", "con", "dat", "edu", "ngy", "env", "fin", "geo", "gov", "hlt", "est", "ins", "med", "man", "rsh", "sec", "sci", "tel", "trm", "trn", "wat", "wea", "otr"]
    org['industry_id'] = random.choice(industries)

    if isinstance(row_values[10], (int, float)):
        org['org_year_founded'] = int(row_values[10])
    else:
	    org['org_year_founded'] = None

    org['org_size_id'] = row_values[11]
    org['org_greatest_impact'] = row_values[12]
    org['org_profile_src'] = row_values[18]
    if isinstance(row_values[29], (int, float)):
        org['org_confidence'] = int(row_values[29])
    else:
        org['org_confidence'] = None
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

    locs = {"New York USA" : ["New York", "NY", "US", 40.7127837, -74.00594130000002],
"San Francisco USA" : ["San Francisco", "CA", "US", 37.7749295, -122.41941550000001],
"Ann Arbor USA" : ["Ann Arbor", "MI", "US", 42.2808256, -83.74303780000002],
"Arlington USA" : ["Arlington", "VA", "US", 38.8799697, -77.1067698],
"Atlanta USA" : ["Atlanta", "GA", "US", 33.7489954, -84.3879824],
"Austin USA" : ["Austin", "TX", "US", 30.267153, -97.74306079999997],
"Bainbridge Island USA" : ["Bainbridge Island", "WA", "US", 47.6262081, -122.52124479999998],
"Berkeley USA" : ["Berkeley", "CA", "US", 37.8715926, -122.27274699999998],
"Beverly USA" : ["Beverly", "MA", "US", 42.5584283, -70.88004899999999],
"Boston USA" : ["Boston", "MA", "US", 42.3600825, -71.05888010000001],
"Brentwood USA" : ["Brentwood", "MD", "US", 38.9437631, -76.9568974],
"Bristow USA" : ["Bristow", "VA", "US", 38.723303, -77.5367043],
"Bulgaria" : ["", "", "BG", 42.733883, 25.485829999999964],
"Cambridge USA" : ["Cambridge", "MA", "US", 42.3736158, -71.1097335],
"Campbell USA" : ["Campbell", "CA", "US", 37.2871651, -121.9499568],
"Canada" : ["", "", "CA", 56.130366, -106.34677099999999],
"Cedar City USA" : ["Cedar City", "UT", "US", 37.67747689999999, 113.06189310000002],
"Centreville USA" : ["Centreville", "VA", "US", 38.8403909, -77.42887689999998],
"Chicago USA" : ["Chicago", "IL", "US", 41.8781136, -87.62979819999998],
"Cincinnati USA" : ["Cincinnati", "OH", "US", 39.1031182, -84.51201960000003],
"Columbus USA" : ["Columbus", "OH", "US", 39.9611755, -82.99879420000002],
"Cupertino USA" : ["Cupertino", "CA", "US", 37.3229978, -122.03218229999999],
"Danvers USA" : ["Danvers", "MA", "US", 42.5750009, -70.93212199999999],
"Evansville USA" : ["Evansville", "IN", "US", 37.9715592, -87.57108979999998],
"Fairfax USA" : ["Fairfax", "VA", "US", 38.84622359999999, -77.30637330000002],
"Friendswood USA" : ["Friendswood", "TX", "US", 29.5293998, -95.20104470000001],
"Hopkinton USA" : ["Hopkinton", "", "USA", 0, 0],
"Hyderabad India" : ["Hyderabad", "Telangana", "IN", 17.385044, 78.486671],
"Indianapolis USA" : ["Indianapolis", "IN", "US", 39.768403, -86.15806800000001],
"Irvine USA" : ["Irvine", "CA", "US", 33.6839473, -117.79469419999998],
"Little Rock USA" : ["Little Rock", "AR", "US", 34.7464809, -92.28959479999997],
"Log Angeles USA" : ["Log Angeles", "CA", "US", 34.0522342, -118.2436849],
"McLean USA" : ["McLean", "VA", "US", 38.9338676, -77.17726040000002],
"Melville USA" : ["Melville", "NY", "US", 40.7934322, -73.41512139999998],
"Menlo Park USA" : ["Menlo Park", "CA", "US", 37.4529598, -122.18172520000002],
"MEXICO" : ["", "", "MX", 23.634501, -102.55278399999997],
"Miami USA" : ["Miami", "FL", "US", 25.7616798, -80.19179020000001],
"Millbrae USA" : ["Millbrae", "CA", "US", 37.5985468, -122.38719420000001],
"Milwaukee USA" : ["Milwaukee", "WI", "US", 43.0389025, -87.90647360000003],
"Moldova" : ["", "", "MD", 47.411631, 28.369885000000068],
"Mountain View USA" : ["Mountain View", "CA", "US", 37.3860517, -122.0838511],
"Menlo Park USA" : ["New Brunswick", "NJ", "US", 37.4529598, -122.18172520000002],
"New York City USA" : ["New York", "NY", "US", 40.7127837, -74.00594130000002],
"North Kansas City USA" : ["North Kansas City", "KS", "US", 39.14290810000001, -94.5729781],
"Northbrook USA" : ["Northbrook", "IL", "US", 42.1275267, -87.82895480000002],
"Oakbrook Terrace USA" : ["Oakbrook Terrace", "IL", "US", 41.8500302, -87.96450770000001],
"Omaha USA" : ["Omaha", "NB", "US", 41.2523634, -95.99798829999997],
"Palo Alto USA" : ["Palo Alto", "CA", "US", 37.4418834, -122.14301949999998],
"Philadelphia USA" : ["Philadelphia", "PA", "US", 39.9525839, -75.16522150000003],
"Raleigh USA" : ["Raleigh", "NC", "US", 35.7795897, -78.63817870000003],
"Redmond USA" : ["Redmond", "WA", "US", 47.6739881, -122.121512],
"Reston USA" : ["Reston", "VA", "US", 38.9586307, -77.35700279999998],
"Ridgefield USA" : ["Ridgefield", "NJ", "US", 40.8342669, -74.00875050000002],
"Rockville USA" : ["Rockville", "MD", "US", 39.0839973, -77.15275780000002],
"San Diego USA" : ["San Diego", "CA", "US", 32.715738, -117.16108380000003],
"San Jose USA" : ["San Jose", "CA", "US", 37.3382082, -121.88632860000001],
"San Ramon USA" : ["San Ramon", "CA", "US", 37.7799273, -121.97801529999998],
"Santa Clara USA" : ["Santa Clara", "CA", "US", 37.3541079, -121.95523559999998],
"Santa Cruz USA" : ["Santa Cruz", "CA", "US", 36.9741171, -122.03079630000002],
"Seattle USA" : ["Seattle", "WA", "US", 47.6062095, -122.3320708],
"Short Hills USA" : ["Short Hills", "NJ", "US", 40.7483499 , -74.32321939999997],
"St Louis USA" : ["St Louis", "MO", "US", 38.6270025, -90.1994042],
"State College USA" : ["State College", "PA", "US", 40.7933949, -77.8600012],
"United Kingdom" : ["", "", "UK", 55.378051, -3.43597299999999],
"Washington DC USA" : ["Washington", "DC", "US", 38.9071923, -77.03687070000001],
"Washington USA" : ["Washington", "DC", "US", 38.9071923, -77.03687070000001],
"West Loop USA" : ["West Loop", "IL", "US", 41.882457, -87.6446775],
"West Warwick USA" : ["West Warwick", "RI", "US", 41.70367110000001, -71.52150240000003],
"Westminster USA" : ["Westminster", "CO", "US", 39.8366528, -105.0372046],
"Westport USA" : ["Westport", "CT", "US", 41.1414717, -73.3579049],
"Williamsville USA" : ["Williamsville", "NY", "US", 42.963947, -78.73780909999999],
"Yonkers USA" : ["Yonkers", "NY", "US", 40.9312099, -73.89874689999999],
"India" : ["","", "India", 20.593684, 78.96288000000004],
"Australia" : ["","", "Australia", -25.274398, 133.77513599999997],
"Bulgaria" : ["","", "Bulgaria", 42.733883, 25.485829999999964],
"South Africa" : ["","", "South Africa", -30.559482, 22.937505999999985],
"Kenya " : ["","", "Kenya ", -0.023559, 37.90619300000003],
"Ghana" : ["","", "Ghana", 7.946527, -1.0231939999999895],
"Guatemala" : ["","", "Guatemala", 14.613333, -90.535278],
"Morocco" : ["","", "Morocco", 31.791702, -7.092620000000011],
"Russia" : ["","", "Russia", 61.52401, 105.31875600000001],
"MOLDOVA, REPUBLIC OF" : ["","", "MOLDOVA, REPUBLIC OF", 47.411631, 28.369885000000068],
"Philippines" : ["","", "Philippines", 12.879721, 121.77401699999996],
"Netherlands" : ["","", "Netherlands", 52.132633, 5.2912659999999505],
"Poland" : ["","", "Poland", 51.919438, 19.14513599999998],
"United States" : ["","", "US", 37.09024, -95.71289100000001],
"UNITED STATES" : ["","", "US", 37.09024, -95.71289100000001],
"Costa Rica " : ["","", "Costa Rica ", 9.748916999999999, -83.75342799999999],
"Brazil" : ["","", "Brazil", -14.235004, -51.92527999999999],
"ITALY" : ["","", "ITALY", 41.87194, 12.567379999999957],
"Nigeria" : ["","", "Nigeria", 9.081999, 8.675277000000051],
"Argentina" : ["","", "Argentina", -38.416097, -63.616671999999994],
"Georgia" : ["","", "Georgia", None, None],
"JAMAICA" : ["","", "JAMAICA", 18.109581, -77.297508],
"Colombia" : ["","", "Colombia", 4.570868, -74.29733299999998],
"Chile" : ["","", "Chile", 4.570868, -74.29733299999998],
"Tanzania" : ["","", "Tanzania", -6.369028, 34.888822000000005],
"France" : ["","", "France", 46.227638, 2.213749000000007],
"Uruguay" : ["","", "Uruguay", -32.522779, -55.76583500000004],
"ECUADOR" : ["","", "ECUADOR", -1.831239, -78.18340599999999],
"Pakistan" : ["","", "Pakistan", 30.375321, 69.34511599999996],
"Kenya" : ["","", "Kenya", -0.023559, 37.90619300000003]
    }
    try:
    	loc = "%s %s" % (org['org_hq_city'],org['org_hq_country'])
    	org['org_hq_city'] = locs[loc][0]
    	org['org_hq_st_prov'] = locs[loc][1]
        org['org_hq_country_locode'] = locs[loc][2]
        org['latitude'] = float(locs[loc][3])
    	org['longitude'] = float(locs[loc][4])
    except:
    	org['org_hq_city'] = None
    	org['org_hq_st_prov'] = None
        org['org_hq_country_locode'] = None
        org['latitude'] = None
    	org['longitude'] = None
        # print org['org_hq_city'], org['org_hq_country'], org['latitude']
    
    try:
        loc = "%s" % (org['org_hq_country'])
        # print "--%s" % (org['org_hq_country'])
        org['org_hq_city'] = None
        org['org_hq_st_prov'] = None
        org['org_hq_country_locode'] = locs[loc][2]
        org['latitude'] = float(locs[loc][3])
        org['longitude'] = float(locs[loc][4])
        # print ">>%s" % (locs[loc])
    except:
         print "(%s)" % org['org_hq_country']
         # print locs['United Kingdom']



#   Append org if eligible
    if org['eligibility'] == 'Y' and org['org_confidence'] > 3 and org['org_hq_country'] != "Spain":
        org_list.append(org)
        # print org['org_hq_city'], org['org_hq_country']
    else:
    	org_list_not_used.append(org)

#     #print org_list
print "used:", len(org_list)
print "not used:", len(org_list_not_used)

# Serialize the list of dicts to JSON
results = { "results": org_list }
# j = json.dumps(org_list)
j = json.dumps(results, sort_keys=False, indent=4, separators=(',', ': '))
# print j
# Write to file
with open('org_profile.json', 'w') as f:
    f.write(j)

# Now generate ArcGIS Flat file
data_type = ["Agriculture", "Arts and culture", "Business", "Consumer", "Demographics and social", "Economics", "Education", "Other"]
country = {"AF" : "Afghanistan", "AX" : "Åland Islands", "AL" : "Albania", "DZ" : "Algeria", "AS" : "American Samoa", "AD" : "Andorra", "AO" : "Angola", "AI" : "Anguilla", "AQ" : "Antarctica", "AG" : "Antigua and Barbuda", "AR" : "Argentina", "AM" : "Armenia", "AW" : "Aruba", "AU" : "Australia", "AT" : "Austria", "AZ" : "Azerbaijan", "BS" : "Bahamas", "BH" : "Bahrain", "BD" : "Bangladesh", "BB" : "Barbados", "BY" : "Belarus", "BE" : "Belgium", "BZ" : "Belize", "BJ" : "Benin", "BM" : "Bermuda", "BT" : "Bhutan", "BO" : "Bolivia", "BQ" : "Bonaire, Sint Eustatius and Saba", "BA" : "Bosnia and Herzegovina", "BW" : "Botswana", "BR" : "Brazil", "IO" : "British Indian Ocean Territory", "BN" : "Brunei Darussalam", "BG" : "Bulgaria", "BF" : "Burkina Faso", "BI" : "Burundi", "KH" : "Cambodia", "CM" : "Cameroon", "CA" : "Canada", "CV" : "Cape Verde", "KY" : "Cayman Islands", "CF" : "Central African Republic", "TD" : "Chad", "CL" : "Chile", "CN" : "China", "CX" : "Christmas Island", "CC" : "Cocos (Keeling) Islands", "CO" : "Colombia", "KM" : "Comoros", "CG" : "Congo", "CD" : "Congo, The Democratic Republic of the", "CK" : "Cook Islands", "CR" : "Costa Rica", "CI" : "Côte d\'Ivoire", "HR" : "Croatia", "CU" : "Cuba", "CW" : "Curaçao", "CY" : "Cyprus", "CZ" : "Czech Republic", "DK" : "Denmark", "DJ" : "Djibouti", "DM" : "Dominica", "DO" : "Dominican Republic", "EC" : "Ecuador", "EG" : "Egypt", "SV" : "El Salvador", "GQ" : "Equatorial Guinea", "ER" : "Eritrea", "EE" : "Estonia", "ET" : "Ethiopia", "FK" : "Falkland Islands (Malvinas)", "FO" : "Faroe Islands", "FJ" : "Fiji", "FI" : "Finland", "FR" : "France", "GF" : "French Guiana", "PF" : "French Polynesia", "TF" : "French Southern Territories", "GA" : "Gabon", "GM" : "Gambia", "GE" : "Georgia", "DE" : "Germany", "GH" : "Ghana", "GI" : "Gibraltar", "GR" : "Greece", "GL" : "Greenland", "GD" : "Grenada", "GP" : "Guadeloupe", "GU" : "Guam", "GT" : "Guatemala", "GG" : "Guernsey", "GN" : "Guinea", "GW" : "Guinea-Bissau", "GY" : "Guyana", "HT" : "Haiti", "HM" : "Heard Island and McDonald Islands", "VA" : "Holy See (Vatican City State)", "HN" : "Honduras", "HK" : "Hong Kong", "HU" : "Hungary", "IS" : "Iceland", "IN" : "India", "ID" : "Indonesia", "XZ" : "Installations in International Waters", "IR" : "Iran, Islamic Republic of", "IQ" : "Iraq", "IE" : "Ireland", "IM" : "Isle of Man", "IL" : "Israel", "IT" : "Italy", "JM" : "Jamaica", "JP" : "Japan", "JE" : "Jersey", "JO" : "Jordan", "KZ" : "Kazakhstan", "KE" : "Kenya", "KI" : "Kiribati", "KP" : "Korea, Democratic People\'s Republic of", "KR" : "Korea, Republic of", "KW" : "Kuwait", "KG" : "Kyrgyzstan", "LA" : "Lao People\'s Democratic Republic", "LV" : "Latvia", "LB" : "Lebanon", "LS" : "Lesotho", "LR" : "Liberia", "LY" : "Libya", "LI" : "Liechtenstein", "LT" : "Lithuania", "LU" : "Luxembourg", "MO" : "Macao", "MK" : "Macedonia, The former Yugoslav Republic of", "MG" : "Madagascar", "MW" : "Malawi", "MY" : "Malaysia", "MV" : "Maldives", "ML" : "Mali", "MT" : "Malta", "MH" : "Marshall Islands", "MQ" : "Martinique", "MR" : "Mauritania", "MU" : "Mauritius", "YT" : "Mayotte", "MX" : "Mexico", "FM" : "Micronesia, Federated States of", "MD" : "Moldova, Republic of", "MC" : "Monaco", "MN" : "Mongolia", "ME" : "Montenegro", "MS" : "Montserrat", "MA" : "Morocco", "MZ" : "Mozambique", "MM" : "Myanmar", "NA" : "Namibia", "NR" : "Nauru", "NP" : "Nepal", "NL" : "Netherlands", "NC" : "New Caledonia", "NZ" : "New Zealand", "NI" : "Nicaragua", "NE" : "Niger", "NG" : "Nigeria", "NU" : "Niue", "NF" : "Norfolk Island", "MP" : "Northern Mariana Islands", "NO" : "Norway", "OM" : "Oman", "PK" : "Pakistan", "PW" : "Palau", "PS" : "Palestine, State of", "PA" : "Panama", "PG" : "Papua New Guinea", "PY" : "Paraguay", "PE" : "Peru", "PH" : "Philippines", "PN" : "Pitcairn", "PL" : "Poland", "PT" : "Portugal", "PR" : "Puerto Rico", "QA" : "Qatar", "RE" : "Reunion", "RO" : "Romania", "RU" : "Russian Federation", "RW" : "Rwanda", "BL" : "Saint Barthélemy", "SH" : "Saint Helena, Ascension and Tristan Da Cunha", "KN" : "Saint Kitts and Nevis", "LC" : "Saint Lucia", "MF" : "Saint Martin (French Part)", "PM" : "Saint Pierre and Miquelon", "VC" : "Saint Vincent and the Grenadines", "WS" : "Samoa", "SM" : "San Marino", "ST" : "Sao Tome and Principe", "SA" : "Saudi Arabia", "SN" : "Senegal", "RS" : "Serbia", "SC" : "Seychelles", "SL" : "Sierra Leone", "SG" : "Singapore", "SX" : "Sint Maarten (Dutch Part)", "SK" : "Slovakia", "SI" : "Slovenia", "SB" : "Solomon Islands", "SO" : "Somalia", "ZA" : "South Africa", "GS" : "South Georgia and the South Sandwich Islands", "SS" : "South Sudan", "ES" : "Spain", "LK" : "Sri Lanka", "SD" : "Sudan", "SR" : "Suriname", "SJ" : "Svalbard and Jan Mayen", "SZ" : "Swaziland", "SE" : "Sweden", "CH" : "Switzerland", "SY" : "Syrian Arab Republic", "TW" : "Taiwan, Province of China", "TJ" : "Tajikistan", "TZ" : "Tanzania, United Republic of", "TH" : "Thailand", "TL" : "Timor-Leste", "TG" : "Togo", "TK" : "Tokelau", "TO" : "Tonga", "TT" : "Trinidad and Tobago", "TN" : "Tunisia", "TR" : "Turkey", "TM" : "Turkmenistan", "TC" : "Turks and Caicos Islands", "TV" : "Tuvalu", "UG" : "Uganda", "UA" : "Ukraine", "AE" : "United Arab Emirates", "GB" : "United Kingdom", "US" : "United States", "UM" : "United States Minor Outlying Islands", "UY" : "Uruguay", "UZ" : "Uzbekistan", "VU" : "Vanuatu", "VE" : "Venezuela", "VN" : "Viet Nam", "VG" : "Virgin Islands, British", "VI" : "Virgin Islands, U.S.", "WF" : "Wallis and Futuna", "EH" : "Western Sahara", "YE" : "Yemen", "ZM" : "Zambia", "ZW" : "Zimbabwe"}
# create new array
data_use_flat = []

cnt = 0
for org in org_list:
    cnt += 1
    print cnt
    # add row for org org_profile
    org['data_type'] = None
    org['data_src_country_locode'] = None
    org['data_src_gov_level'] = None
    org['row_type'] = "org_profile"
    data_use_flat.append(copy.copy(org))
    print "xx len data_use_flat: %d" % len(data_use_flat)

    for use in range(0,2):
        rand_type = random.choice(data_type)
        # print rand_type
        for src in range (0,2):
            rand_source = random.choice(country.keys())
            # print rand_source
            if cnt % 2 == 0 :
                print "%s %s %s" % (rand_type, rand_source, "National")
                org['data_type'] = rand_type
                org['data_src_country_locode'] = rand_source
                org['data_src_gov_level'] = "National"
                org['row_type'] = "data_use"
                data_use_flat.append(copy.copy(org))
                print "len data_use_flat: %d" % len(data_use_flat)

                # repeat for State/Local
                org['data_src_gov_level'] = "State/Local"
                data_use_flat.append(copy.copy(org))
                print "len data_use_flat: %d" % len(data_use_flat)
                
            else:
                print "%s %s %s" % (rand_type, rand_source, "State/Local")
                org['data_type'] = rand_type
                org['data_src_country_locode'] = rand_source
                org['data_src_gov_level'] = "State/Local"
                org['row_type'] = "data_use"
                data_use_flat.append(copy.copy(org))
                print "len data_use_flat: %d" % len(data_use_flat)

results = { "results": data_use_flat }
# j = json.dumps(org_list)
j = json.dumps(results, sort_keys=False, indent=4, separators=(',', ': '))
# print j
# Write to file
with open('arcgis_flatfile.json', 'w') as f:
    f.write(j)



