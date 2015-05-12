#!/usr/bin/env python
# -*- coding: utf-8 -*-
#
# Name: odeinventory.py
# Author: Greg Elin gregelin@gitmachines.com
# Copyright: 2015, Center for Open Data Enterprise and GovReady PBC. All Rights Reserved.
# Version 1.0
#
# About: Parses internal Inventory.xlsx spreadsheet to generate org_profile.json
#        and arcgis_flatfile.json for importining into Parse.com database
#        
# Usage: python odeinventory.py
# Output: org_profile.json and arcgis_flatfile.json
#
#

import xlrd
from collections import OrderedDict
import simplejson as json
import random
import copy
import re

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
for rownum in range(0, sh.nrows):
    print "%d ------" % (rownum)
    cnt +=1
    org = OrderedDict()
    # Get values of all cells in the row
    row_values = sh.row_values(rownum)
    # print row_values
    
    # Assign values to object
    org['profile_id'] = str(cnt)
    org['eligibility'] = row_values[0]
    org['org_name'] = row_values[2]
    print "org['org_name'] : %s" % org['org_name']
    org['org_type'] = row_values[3]
    org['org_type_other'] = None

    org['org_url'] = row_values[4]
    org['org_description'] = row_values[5]
    # org_type_other
    org['org_hq_city'] = row_values[6]
    org['org_hq_st_prov'] = row_values[7]
    org['org_hq_country'] = row_values[8]
    # if org['org_hq_country'] == "USA":
    #     org['org_hq_country_locode'] = 'US'

    print "loc: %s, %s, %s" % (org['org_hq_city'],org['org_hq_st_prov'], org['org_hq_country'])

    org['industry_id'] = row_values[9]
    # randomly select industry category
    industries =["agr", "art", "bus", "con", "dat", "edu", "ngy", "env", "fin", "geo", "gov", "hlt", "est", "ins", "med", "man", "rsh", "sec", "sci", "tel", "trm", "trn", "wat", "wea", "otr"]
    org['industry_id'] = random.choice(industries)

    try:
        org['org_year_founded'] = int(row_values[10])
    except:
        org['org_year_founded'] = None

    # if isinstance(row_values[10], (int, float)):
    #     org['org_year_founded'] = int(row_values[10])
    # else:
	   #  org['org_year_founded'] = None

    org['org_size_id'] = row_values[11]
    org['org_greatest_impact'] = row_values[12]
    print "impact", org['org_greatest_impact']
    org['org_greatest_impact_detail'] = None
    print len(org['org_greatest_impact'])
    if "(" in org['org_greatest_impact']:
        org['org_greatest_impact'], org['org_greatest_impact_detail'] = org['org_greatest_impact'].split("(")
        org['org_greatest_impact_detail'] = org['org_greatest_impact_detail'].strip(")")

    org['data_use_unparsed'] = row_values[13]
    org['usage_unparsed'] = row_values[14]
    org['org_profile_src'] = row_values[15]

    try:
        org['org_confidence'] = int(row_values[26])
    except:
        org['org_confidence'] = None

    print org['org_confidence']
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

    locs = {"  ARG" : ["", "", "ARG", -38.416097, -63.616672],
"  AUS" : ["", "", "AUS", -25.274398, 133.775136],
"  BEL" : ["", "", "BEL", 50.503887, 4.469936],
"  BGD" : ["", "", "BGD", 23.684994, 90.356331],
"  BGR" : ["", "", "BGR", 42.733883, 25.48583],
"  BHR" : ["", "", "BHR", 26.0667, 50.5577],
"  BOL" : ["", "", "BOL", -16.290154, -63.588653],
"  BRA" : ["", "", "BRA", -14.235004, -51.92528],
"  CAN" : ["", "", "CAN", 56.130366, -106.346771],
"  CHL" : ["", "", "CHL", -35.675147, -71.542969],
"  CHN" : ["", "", "CHN", 35.86166, 104.195397],
"  COL" : ["", "", "COL", 4.570868, -74.297333],
"  CRI" : ["", "", "CRI", 9.748917, -83.753428],
"  DEU" : ["", "", "DEU", 51.165691, 10.451526],
"  DNK" : ["", "", "DNK", 56.26392, 9.501785],
"  ECU" : ["", "", "ECU", -1.831239, -78.183406],
"  ESP" : ["", "", "ESP", 40.463667, -3.74922],
"  FIN" : ["", "", "FIN", 61.92411, 25.748151],
"  FRA" : ["", "", "FRA", 46.227638, 2.213749],
"  GBR" : ["", "", "GBR", 55.378051, -3.435973],
"  GEO" : ["", "", "GEO", 0, 0],
"  DEU" : ["", "", "DEU", 0, 0],
"  GTM" : ["", "", "GTM", 15.783471, -90.230759],
"  HUN" : ["", "", "HUN", 47.162494, 19.503304],
"  IDN" : ["", "", "IDN", -0.789275, 113.921327],
"  IND" : ["", "", "IND", 20.593684, 78.96288],
"  IRL" : ["", "", "IRL", 53.41291, -8.24389],
"  ISL" : ["", "", "ISL", 64.963051, -19.020835],
"  ISR" : ["", "", "ISR", 31.046051, 34.851612],
"  ITA" : ["", "", "ITA", 41.87194, 12.56738],
"  JAM" : ["", "", "JAM", 18.109581, -77.297508],
"  KEN" : ["", "", "KEN", -0.023559, 37.906193],
"  KGZ" : ["", "", "KGZ", 41.20438, 74.766098],
"  MAR" : ["", "", "MAR", 31.791702, -7.09262],
"  MDA" : ["", "", "MDA", 47.411631, 28.369885],
"  MDG" : ["", "", "MDG", -18.766947, 46.869107],
"  MEX" : ["", "", "MEX", 19.496873, -99.723267],
"  MKD" : ["", "", "MKD", 41.608635, 21.745275],
"  MYS" : ["", "", "MYS", 4.210484, 101.975766],
"  NGA" : ["", "", "NGA", 9.081999, 8.675277],
"  NIC" : ["", "", "NIC", 12.865416, -85.207229],
"  NLD" : ["", "", "NLD", 52.132633, 5.291266],
"  NOR" : ["", "", "NOR", 60.472024, 8.468946],
"  NPL" : ["", "", "NPL", 28.394857, 84.124008],
"  NZL" : ["", "", "NZL", -43.56597, 172.686219],
"  PAK" : ["", "", "PAK", 30.375321, 69.345116],
"  PER" : ["", "", "PER", -9.189967, -75.015152],
"  PHL" : ["", "", "PHL", 12.879721, 121.774017],
"  POL" : ["", "", "POL", 51.919438, 19.145136],
"  PRI" : ["", "", "PRI", 18.220833, -66.590149],
"  PRY" : ["", "", "PRY", -23.442503, -58.443832],
"  RUS" : ["", "", "RUS", 61.52401, 105.318756],
"  RWA" : ["", "", "RWA", -1.940278, 29.873888],
"  SLV" : ["", "", "SLV", 13.794185, -88.89653],
"  SVK" : ["", "", "SVK", 48.669026, 19.699024],
"  SWE" : ["", "", "SWE", 60.128161, 18.643501],
"  SYR" : ["", "", "SYR", 34.802075, 38.996815],
"  TZA" : ["", "", "TZA", -6.369028, 34.888822],
"  URY" : ["", "", "URY", -32.522779, -55.765835],
"  USA" : ["", "", "USA", 37.09024, -95.712891],
"  ZAF" : ["", "", "ZAF", -30.559482, 22.937506],
" CA USA" : ["", "CA","USA", 36.778261, -119.417932],
" FL USA" : ["", "FL","USA", 27.664827, -81.515754],
" ME USA" : ["", "ME","USA", 45.253783, -69.445469],
" NJ USA" : ["", "NJ","USA", 40.058324, -74.405661],
" NY USA" : ["", "NY","USA", 40.712784, -74.005941],
"Aarhus  DNK" : ["", "", "DNK", 56.162939, 10.203921],
"Abuja  NGA" : ["", "", "NGA", 9.066667, 7.483333],
"Accra  GHA" : ["", "", "GHA", 5.55, -0.2],
"Addison TX USA" : ["Addison", "TX", "USA", 32.96179, -96.829169],
"Agadir  MAR" : ["", "", "MAR", 35.623335, -5.273156],
"Ahmedabad  IND" : ["", "", "IND", 23.022505, 72.571362],
"Ahmedabad Gujarat IND" : ["Ahmedabad", "Gujarat", "IND", 23.022505, 72.571362],
"Amersfoort  NLD" : ["", "", "NLD", 52.156111, 5.387827],
"Ames IA USA" : ["Ames", "IA", "USA", 42.034722, -93.62],
"Amherst MA USA" : ["Amherst", "MA", "USA", 42.34038, -72.496819],
"Amsterdam  NLD" : ["", "", "NLD", 52.370216, 4.895168],
"Ann Arbor MI USA" : ["Ann Arbor", "MI", "USA", 42.280826, -83.743038],
"Arlington VA USA" : ["Arlington", "VA", "USA", 38.87997, -77.10677],
"Armonk NY USA" : ["Armonk", "NY", "USA", 41.126485, -73.714019],
"Asheville NC USA" : ["Asheville", "NC", "USA", 35.595058, -82.551487],
"Asunción  PRY" : ["", "", "PRY", -25.282197, -57.6351],
"Atlanta GA USA" : ["Atlanta", "GA", "USA", 33.748995, -84.387982],
"Auburn Hills MI USA" : ["Auburn Hills", "MI", "USA", 42.687532, -83.234103],
"Aurora OH USA" : ["Aurora", "OH", "USA", 41.317555, -81.345386],
"Austin TX USA" : ["Austin", "TX", "USA", 30.267153, -97.743061],
"Bahia Blanca   ARG" : ["", "", "ARG", -32.92527, -60.688705],
"Bainbridge Island WA USA" : ["Bainbridge Island", "WA", "USA", 47.626208, -122.521245],
"Bala Cynwyd PA USA" : ["Bala Cynwyd", "PA", "USA", 40.013142, -75.230404],
"Baltimore MD USA" : ["Baltimore", "MD", "USA", 39.290385, -76.612189],
"Bandung  IDN" : ["", "", "IDN", -6.917464, 107.619123],
"Bandung West Java IDN" : ["Bandung", "West Java", "IDN", -6.917464, 107.619123],
"Bangalore  IND" : ["", "", "IND", 12.974112, 77.60136],
"Bellevue TX USA" : ["Bellevue", "TX", "USA", 33.636493, -98.013928],
"Bellevue WA USA" : ["Bellevue", "WA", "USA", 47.610377, -122.200679],
"Bengaluru  IND" : ["", "", "IND", 12.971599, 77.594563],
"Berkeley CA USA" : ["Berkeley", "CA", "USA", 37.871593, -122.272747],
"Berkely CA USA" : ["Berkely", "CA", "USA", 37.871593, -122.272747],
"Berlin  DEU" : ["", "", "DEU", 52.520007, 13.404954],
"Bethesda MD USA" : ["Bethesda", "MD", "USA", 38.984652, -77.094709],
"Beverly MA USA" : ["Beverly", "MA", "USA", 42.558428, -70.880049],
"Bhopal  IND" : ["", "", "IND", 23.259933, 77.412615],
"Bhubaneswar  IND" : ["", "", "IND", 20.296059, 85.82454],
"Birmingham  GBR" : ["", "", "GBR", 33.520661, -86.80249],
"Bloomington IL USA" : ["Bloomington", "IL", "USA", 40.484203, -88.993687],
"Bogota  COL" : ["", "", "COL", 4.598056, -74.075833],
"Bonsall CA USA" : ["Bonsall", "CA", "USA", 33.288923, -117.22559],
"Boston  USA" : ["", "", "USA", 42.360083, -71.05888],
"Boston MA USA" : ["Boston", "MA", "USA", 42.360083, -71.05888],
"Boulder CO USA" : ["Boulder", "CO", "USA", 40.014986, -105.270546],
"Bowie MD USA" : ["Bowie", "MD", "USA", 39.006777, -76.779136],
"Bozeman MT USA" : ["Bozeman", "MT", "USA", 45.676998, -111.042934],
"Branchburg NJ USA" : ["Branchburg", "NJ", "USA", 40.586811, -74.698589],
"Brasilia  BRA" : ["", "", "BRA", -15.794229, -47.882166],
"Brasília  BRA" : ["", "", "BRA", -15.794229, -47.882166],
"Breda  NLD" : ["", "", "NLD", 51.58307, 4.77695],
"Brentwood TN USA" : ["Brentwood", "TN", "USA", 36.033116, -86.782777],
"Bristol  GBR" : ["", "", "GBR", 51.454513, -2.58791],
"Bristow VA USA" : ["Bristow", "VA", "USA", 38.723303, -77.536704],
"Broadview IL USA" : ["Broadview", "IL", "USA", 41.86392, -87.853393],
"Brooklyn NY USA" : ["Brooklyn", "NY", "USA", 40.678178, -73.944158],
"Brussels  BEL" : ["", "", "BEL", 50.85034, 4.35171],
"Buenos Aires  ARG" : ["", "", "ARG", -34.615882, -58.371733],
"Buenos Aires   ARG" : ["", "", "ARG", -34.615882, -58.371733],
"Cambridge  GBR" : ["", "", "GBR", 42.373616, -71.109733],
"Cambridge MA USA" : ["Cambridge", "MA", "USA", 42.373616, -71.109733],
"Campbell CA USA" : ["Campbell", "CA", "USA", 37.287165, -121.949957],
"Cape Town  ZAF" : ["", "", "ZAF", -33.924868, 18.424055],
"Cary NC USA" : ["Cary", "NC", "USA", 35.79154, -78.781117],
"Casablanca  MAR" : ["", "", "MAR", -33.052992, -71.603223],
"Cascais  PRT" : ["", "", "PRT", 38.721943, -9.353611],
"Cedar City UT USA" : ["Cedar City", "UT", "USA", 37.677477, -113.061893],
"Centreville VA USA" : ["Centreville", "VA", "USA", 38.840391, -77.428877],
"Champaign IL USA" : ["Champaign", "IL", "USA", 40.11642, -88.243383],
"Chapel Hill NC USA" : ["Chapel Hill", "NC", "USA", 35.9132, -79.055845],
"Chennai  IND" : ["", "", "IND", 13.046824, 80.155397],
"Chennai Tamil Nadu IND" : ["Chennai", "Tamil Nadu", "IND", 13.009947, 80.218228],
"Cheyenne, Wyoming, USA  RUS" : ["", "", "RUS", 41.139981, -104.820246],
"Chicago IL USA" : ["Chicago", "IL", "USA", 41.878114, -87.629798],
"Chicago VA USA" : ["Chicago", "VA", "USA", 41.869124, -87.679248],
"Chino Hills CA USA" : ["Chino Hills", "CA", "USA", 33.989819, -117.732585],
"Chisinau  MDA" : ["", "", "MDA", 47, 28.916667],
"Cincinnati OH USA" : ["Cincinnati", "OH", "USA", 39.103118, -84.51202],
"Clarksville VA USA" : ["Clarksville", "VA", "USA", 36.62403, -78.556945],
"Cleveland OH USA" : ["Cleveland", "OH", "USA", 41.49932, -81.694361],
"Coimbra  PRT" : ["", "", "PRT", -8.747983, -63.864679],
"College Park MD USA" : ["College Park", "MD", "USA", 38.989697, -76.93776],
"College Station TX USA" : ["College Station", "TX", "USA", 30.627977, -96.334407],
"Columbia MD USA" : ["Columbia", "MD", "USA", 39.203714, -76.861046],
"Columbus OH USA" : ["Columbus", "OH", "USA", 39.961176, -82.998794],
"Concord MA USA" : ["Concord", "MA", "USA", 42.460372, -71.348948],
"Copenhagen  DNK" : ["", "", "DNK", 55.676097, 12.568337],
"Corte Madera CA USA" : ["Corte Madera", "CA", "USA", 37.925481, -122.527475],
"Corvallis OR USA" : ["Corvallis", "OR", "USA", 44.564566, -123.262043],
"Costa Mesa CA USA" : ["Costa Mesa", "CA", "USA", 33.641132, -117.918669],
"Cupertino CA USA" : ["Cupertino", "CA", "USA", 37.322998, -122.032182],
"Danbury CT USA" : ["Danbury", "CT", "USA", 41.394817, -73.454011],
"Danvers MA USA" : ["Danvers", "MA", "USA", 42.575001, -70.932122],
"Dar es Salaam  TZA" : ["", "", "TZA", -6.8, 39.283333],
"Dayton OH USA" : ["Dayton", "OH", "USA", 39.758948, -84.191607],
"Deerfield Beach FL USA" : ["Deerfield Beach", "FL", "USA", 26.318412, -80.099766],
"Delhi  IND" : ["", "", "IND", 39.09506, -84.605222],
"Den Hague  NLD" : ["", "", "NLD", 0, 0],
"Denver CO USA" : ["Denver", "CO", "USA", 39.739236, -104.990251],
"Detroit MI USA" : ["Detroit", "MI", "USA", 42.331427, -83.045754],
"Dodoma  TZA" : ["", "", "TZA", -6.173056, 35.741944],
"Dormaa  GHA" : ["", "", "GHA", 7.283333, -2.883333],
"Draper UT USA" : ["Draper", "UT", "USA", 40.524671, -111.863823],
"Durham NC USA" : ["Durham", "NC", "USA", 35.994033, -78.898619],
"East Falmouth MA USA" : ["East Falmouth", "MA", "USA", 41.578443, -70.55864],
"Eden Prairie MN USA" : ["Eden Prairie", "MN", "USA", 44.854686, -93.470786],
"Ekaterinburg  RUS" : ["", "", "RUS", 56.834451, 60.628792],
"El Dorado Hills CA USA" : ["El Dorado Hills", "CA", "USA", 38.685737, -121.082167],
"El Segundo CA USA" : ["El Segundo", "CA", "USA", 33.91918, -118.416465],
"Emeryville CA USA" : ["Emeryville", "CA", "USA", 37.831316, -122.285247],
"Encinitas CA USA" : ["Encinitas", "CA", "USA", 33.036987, -117.291982],
"Englewood CO USA" : ["Englewood", "CO", "USA", 39.647765, -104.98776],
"Evansville IN USA" : ["Evansville", "IN", "USA", 37.971559, -87.57109],
"Fairfax VA USA" : ["Fairfax", "VA", "USA", 38.846224, -77.306373],
"Falls Church VA USA" : ["Falls Church", "VA", "USA", 38.882334, -77.171091],
"Fishers IN USA" : ["Fishers", "IN", "USA", 39.956755, -86.01335],
"Fort Wayne IN USA" : ["Fort Wayne", "IN", "USA", 41.079273, -85.139351],
"Friendswood TX USA" : ["Friendswood", "TX", "USA", 29.5294, -95.201045],
"Germantown MD USA" : ["Germantown", "MD", "USA", 39.173162, -77.27165],
"Goa  IND" : ["", "", "IND", 15.299327, 74.123996],
"Gothenburg  SWE" : ["", "", "SWE", 57.719856, 11.850395],
"Greensboro NC USA" : ["Greensboro", "NC", "USA", 36.072635, -79.791975],
"Guadalajara  MEX" : ["", "", "MEX", 19.587069, -99.175275],
"Hamburg  DEU" : ["", "", "DEU", 53.551085, 9.993682],
"Haymarket VA USA" : ["Haymarket", "VA", "USA", 38.812059, -77.636381],
"Helsinki  FIN" : ["", "", "FIN", 60.163128, 24.947748],
"Henderson NV USA" : ["Henderson", "NV", "USA", 36.039525, -114.981721],
"Herndon VA USA" : ["Herndon", "VA", "USA", 38.969555, -77.386098],
"Hingham MA USA" : ["Hingham", "MA", "USA", 42.241817, -70.889759],
"Ho Chi Minh City  VNM" : ["", "", "VNM", 10.823099, 106.629664],
"Hollywood MD USA" : ["Hollywood", "MD", "USA", 38.358355, -76.571941],
"Hopkinton MA USA" : ["Hopkinton", "MA", "USA", 42.228695, -71.522565],
"Houston PA USA" : ["Houston", "PA", "USA", 40.246459, -80.211447],
"Houston TX USA" : ["Houston", "TX", "USA", 29.760427, -95.369803],
"Hubli-Dharwad  IND" : ["", "", "IND", 15.440632, 75.004706],
"Huixquilucan  MEX" : ["", "", "MEX", 19.408642, -99.273015],
"Hyderabad  IND" : ["", "", "IND", 17.45761, 78.451446],
"Hyderbad  IND" : ["", "", "IND", 17.455074, 78.439263],
"Indianapolis IN USA" : ["Indianapolis", "IN", "USA", 39.768403, -86.158068],
"Indore  IND" : ["", "", "IND", 22.719569, 75.857726],
"Ipswich  GBR" : ["", "", "GBR", 52.056736, 1.14822],
"Irvine CA USA" : ["Irvine", "CA", "USA", 33.683947, -117.794694],
"Irving TX USA" : ["Irving", "TX", "USA", 32.814018, -96.948894],
"Islamabad  PAK" : ["", "", "PAK", 33.68669, 73.017176],
"Ithaca NY USA" : ["Ithaca", "NY", "USA", 42.443961, -76.501881],
"Jacksonville FL USA" : ["Jacksonville", "FL", "USA", 30.332184, -81.655651],
"Jakarta  IDN" : ["", "", "IDN", -6.208763, 106.845599],
"Jawa Barat  IDN" : ["", "", "IDN", -7.090911, 107.668887],
"Jericho NY USA" : ["Jericho", "NY", "USA", 40.792044, -73.539848],
"Jersey City NJ USA" : ["Jersey City", "NJ", "USA", 40.728157, -74.077642],
"Kaduna  NGA" : ["", "", "NGA", 10.516667, 7.433333],
"Kanpur  IND" : ["", "", "IND", 26.449923, 80.331874],
"Kathmandu  NPL" : ["", "", "NPL", 27.7, 85.333333],
"Kennesaw GA USA" : ["Kennesaw", "GA", "USA", 34.023434, -84.61549],
"Kerala  IND" : ["", "", "IND", 10.850516, 76.271083],
"Kingston  JAM" : ["", "", "JAM", 39.940473, -74.957677],
"Kingston Kingston JAM" : ["Kingston", "Kingston", "JAM", 17.935112, -76.840525],
"Kirkland WA USA" : ["Kirkland", "WA", "USA", 47.681488, -122.208735],
"Kochi  IND" : ["", "", "IND", 9.931233, 76.267304],
"Kolkata  IND" : ["", "", "IND", 22.496355, 88.386288],
"Kumasi  GHA" : ["", "", "GHA", 6.6666, -1.616271],
"Lagos  NGA" : ["", "", "NGA", 6.524379, 3.379206],
"Lamia  GRC" : ["", "", "GRC", 0, 0],
"Leesburg Pike Vienna VA USA" : ["Leesburg Pike Vienna", "VA", "USA", 38.930681, -77.242986],
"Leidschendam  NLD" : ["", "", "NLD", 52.079818, 4.399612],
"Lexington MA USA" : ["Lexington", "MA", "USA", 42.443037, -71.228964],
"Limbe  MWI" : ["", "", "MWI", 0, 0],
"Little Rock AR USA" : ["Little Rock", "AR", "USA", 34.746481, -92.289595],
"Ljubjana  SVN" : ["", "", "SVN", 0, 0],
"London  GBR" : ["", "", "GBR", 51.507351, -0.127758],
"London      UK " : ["London    ", "UK", "", 51.507351, -0.127758],
"Longmont CO USA" : ["Longmont", "CO", "USA", 40.167207, -105.101927],
"Los Angeles CA USA" : ["Los Angeles", "CA", "USA", 34.052234, -118.243685],
"Louisville KY USA" : ["Louisville", "KY", "USA", 38.252665, -85.758456],
"Luleå  SWE" : ["", "", "SWE", 65.584819, 22.156703],
"Lyndhurst NJ USA" : ["Lyndhurst", "NJ", "USA", 40.812017, -74.124306],
"Madhya Pradesh  IND" : ["", "", "IND", 22.973423, 78.656894],
"Madina  GHA" : ["", "", "GHA", 5.683333, -0.166667],
"Madison WI USA" : ["Madison", "WI", "USA", 43.073052, -89.40123],
"Makati City  PHL" : ["", "", "PHL", 14.558221, 121.016164],
"Manassas VA USA" : ["Manassas", "VA", "USA", 38.750949, -77.475267],
"Manchester  GBR" : ["", "", "GBR", 53.480759, -2.242631],
"Manchester NH USA" : ["Manchester", "NH", "USA", 42.99564, -71.454789],
"Manila  PHL" : ["", "", "PHL", 14.67888, 121.064941],
"Maryland Heights MO USA" : ["Maryland Heights", "MO", "USA", 38.713107, -90.42984],
"Mayfield Village OH USA" : ["Mayfield Village", "OH", "USA", 41.551995, -81.439283],
"McKinney TX USA" : ["McKinney", "TX", "USA", 33.197247, -96.639782],
"McLean VA USA" : ["McLean", "VA", "USA", 38.933868, -77.17726],
"Melbourne FL USA" : ["Melbourne", "FL", "USA", 28.083627, -80.608109],
"Melville NY USA" : ["Melville", "NY", "USA", 40.793432, -73.415121],
"Menlo Park CA USA" : ["Menlo Park", "CA", "USA", 37.45296, -122.181725],
"Mexico City  MEX" : ["", "", "MEX", 19.432608, -99.133208],
"Mexico City DF MEX" : ["Mexico City", "DF", "MEX", 19.432608, -99.133208],
"Miami FL USA" : ["Miami", "FL", "USA", 25.76168, -80.19179],
"Midlothian VA USA" : ["Midlothian", "VA", "USA", 37.505981, -77.649158],
"Milford CT USA" : ["Milford", "CT", "USA", 41.230698, -73.064036],
"Millbrae CA USA" : ["Millbrae", "CA", "USA", 37.598547, -122.387194],
"Milwaukee WI USA" : ["Milwaukee", "WI", "USA", 43.038903, -87.906474],
"Minneapolis MN USA" : ["Minneapolis", "MN", "USA", 44.977753, -93.265011],
"Minnetonka MN USA" : ["Minnetonka", "MN", "USA", 44.921184, -93.468749],
"Mohali  IND" : ["", "", "IND", 30.713942, 76.69613],
"Montevideo  URY" : ["", "", "URY", -34.901113, -56.164531],
"Moscow  RUS" : ["", "", "RUS", 55.611013, 37.7324],
"Mountain View CA USA" : ["Mountain View", "CA", "USA", 37.386052, -122.083851],
"Mumbai  IND" : ["", "", "IND", 19.127503, 72.831046],
"München  GER" : ["", "", "GER", 48.138273, 11.571052],
"Nairobi  KEN" : ["", "", "KEN", -1.292066, 36.821946],
"Nairobi  USA" : ["", "", "USA", 37.421448, -122.083423],
"Narberth PA USA" : ["Narberth", "PA", "USA", 40.008446, -75.26046],
"Nashua NH USA" : ["Nashua", "NH", "USA", 42.765366, -71.467566],
"Neenah WI USA" : ["Neenah", "WI", "USA", 44.185819, -88.462609],
"Nevada City CA USA" : ["Nevada City", "CA", "USA", 39.261561, -121.016059],
"New Brunswick NJ USA" : ["New Brunswick", "NJ", "USA", 40.486216, -74.451819],
"New Delhi  IND" : ["", "", "IND", 39.122391, -84.699481],
"New Haven CT USA" : ["New Haven", "CT", "USA", 41.308274, -72.927883],
"New York  USA" : ["", "", "USA", 40.712784, -74.005941],
"New York NY USA" : ["New York", "NY", "USA", 40.712784, -74.005941],
"New York  NY USA" : ["New York ", "NY", "USA", 40.712784, -74.005941],
"Newton MA USA" : ["Newton", "MA", "USA", 42.337041, -71.209221],
"Newtown Square PA USA" : ["Newtown Square", "PA", "USA", 39.98689, -75.400706],
"Noida  IND" : ["", "", "IND", 28.535516, 77.391026],
"Nokesville VA USA" : ["Nokesville", "VA", "USA", 38.698729, -77.579712],
"Norman OK USA" : ["Norman", "OK", "USA", 35.222567, -97.439478],
"North Kansas City MO USA" : ["North Kansas City", "MO", "USA", 39.142908, -94.572978],
"Northbrook IL USA" : ["Northbrook", "IL", "USA", 42.127527, -87.828955],
"Norwalk CT USA" : ["Norwalk", "CT", "USA", 41.117744, -73.408158],
"Oakbrook Terrace IL USA" : ["Oakbrook Terrace", "IL", "USA", 41.85003, -87.964508],
"Oakland CA USA" : ["Oakland", "CA", "USA", 37.804364, -122.271114],
"Oakton VA USA" : ["Oakton", "VA", "USA", 38.880945, -77.300817],
"Olathe KA USA" : ["Olathe", "KA", "USA", 38.881396, -94.819128],
"Omaha NE USA" : ["Omaha", "NE", "USA", 41.252363, -95.997988],
"Orange County CA USA" : ["Orange County", "CA", "USA", 33.717471, -117.831143],
"Oregon House CA USA" : ["Oregon House", "CA", "USA", 39.344343, -121.265161],
"Palo Alto CA USA" : ["Palo Alto", "CA", "USA", 37.441883, -122.143019],
"Palo Alto  CA USA" : ["Palo Alto ", "CA", "USA", 37.441883, -122.143019],
"Paramus NJ USA" : ["Paramus", "NJ", "USA", 40.944543, -74.075419],
"Parsippany NJ USA" : ["Parsippany", "NJ", "USA", 40.865287, -74.417388],
"Pasadena CA USA" : ["Pasadena", "CA", "USA", 34.147785, -118.144516],
"Philadelphia PA USA" : ["Philadelphia", "PA", "USA", 39.952584, -75.165222],
"Phoenix AZ USA" : ["Phoenix", "AZ", "USA", 33.448377, -112.074037],
"Pittsburgh PA USA" : ["Pittsburgh", "PA", "USA", 40.440625, -79.995886],
"Plano TX USA" : ["Plano", "TX", "USA", 33.019843, -96.698886],
"Portland ME USA" : ["Portland", "ME", "USA", 43.661471, -70.255326],
"Portland OR USA" : ["Portland", "OR", "USA", 45.523062, -122.676482],
"Portsmouth OH USA" : ["Portsmouth", "OH", "USA", 38.731743, -82.997674],
"Prague  CZE" : ["", "", "CZE", 50.096058, 14.285128],
"Pretoria  ZAF" : ["", "", "ZAF", -25.746111, 28.188056],
"Pune  IND" : ["", "", "IND", 18.52043, 73.856744],
"Quesada  CRI" : ["", "", "CRI", 37.844606, -3.066385],
"Quezon City  PHL" : ["", "", "PHL", 14.608331, 121.020698],
"Rabat  MAR" : ["", "", "MAR", 33.898113, 35.525065],
"Raleigh NC USA" : ["Raleigh", "NC", "USA", 35.77959, -78.638179],
"Redlands CA USA" : ["Redlands", "CA", "USA", 34.055569, -117.182538],
"Redmond WA USA" : ["Redmond", "WA", "USA", 47.673988, -122.121512],
"Redwood City CA USA" : ["Redwood City", "CA", "USA", 37.485215, -122.236355],
"Redwood Shores CA USA" : ["Redwood Shores", "CA", "USA", 37.536413, -122.245536],
"Reston CA USA" : ["Reston", "CA", "USA", 37.342175, -122.037684],
"Reston VA USA" : ["Reston", "VA", "USA", 38.958631, -77.357003],
"Reykjavik  ISL" : ["", "", "ISL", 64.146186, -21.942437],
"Ridgefield CT USA" : ["Ridgefield", "CT", "USA", 41.284063, -73.497541],
"Rockville MD USA" : ["Rockville", "MD", "USA", 39.083997, -77.152758],
"Roma  ITA" : ["", "", "ITA", -25.292057, -57.644436],
"Rotterdam  NLD" : ["", "", "NLD", 51.92442, 4.477733],
"Sacramento CA USA" : ["Sacramento", "CA", "USA", 38.581572, -121.4944],
"Saint Petersburg  RUS" : ["", "", "RUS", 59.802913, 30.267839],
"Saint-Petersburg  RUS" : ["", "", "RUS", 60.128046, 27.574952],
"Sammamish WA USA" : ["Sammamish", "WA", "USA", 47.616268, -122.035574],
"San Antonio DC USA" : ["San Antonio", "DC", "USA", 29.520448, -98.641189],
"San Diego CA USA" : ["San Diego", "CA", "USA", 32.715738, -117.161084],
"San Francisco CA USA" : ["San Francisco", "CA", "USA", 37.77493, -122.419416],
"San Francisco TX USA" : ["San Francisco", "TX", "USA", 29.966854, -102.933774],
"San Francisco WA USA" : ["San Francisco", "WA", "USA", 47.142152, -122.503956],
"San Francisco  CA USA" : ["San Francisco ", "CA", "USA", 37.77493, -122.419416],
"San Jose  CRI" : ["", "", "CRI", 20.921757, -100.744605],
"San Jose CA USA" : ["San Jose", "CA", "USA", 37.338208, -121.886329],
"San Leandro CA USA" : ["San Leandro", "CA", "USA", 37.72493, -122.156077],
"San Mateo CA USA" : ["San Mateo", "CA", "USA", 37.562992, -122.325525],
"San Ramon CA USA" : ["San Ramon", "CA", "USA", 37.779927, -121.978015],
"Sandton  ZAF" : ["", "", "ZAF", 0, 0],
"Santa Barbara CA USA" : ["Santa Barbara", "CA", "USA", 34.420831, -119.69819],
"Santa Clara CA USA" : ["Santa Clara", "CA", "USA", 37.354108, -121.955236],
"Santa Cruz CA USA" : ["Santa Cruz", "CA", "USA", 36.974117, -122.030796],
"Santa Monica CA USA" : ["Santa Monica", "CA", "USA", 34.019454, -118.491191],
"Santiago  CHL" : ["", "", "CHL", -33.452464, -70.651787],
"Santiago   CHL" : ["", "", "CHL", -33.452464, -70.651787],
"Sao Paolo  BRA" : ["", "", "BRA", -23.55052, -46.633309],
"Schaumburg IL USA" : ["Schaumburg", "IL", "USA", 42.033361, -88.083406],
"Scotsdale AZ USA" : ["Scotsdale", "AZ", "USA", 33.49417, -111.926052],
"Seattle NY USA" : ["Seattle", "NY", "USA", 47.665462, -122.382411],
"Seattle WA USA" : ["Seattle", "WA", "USA", 47.60621, -122.332071],
"Sebastopol CA USA" : ["Sebastopol", "CA", "USA", 38.402136, -122.823881],
"Selangor  MYS" : ["", "", "MYS", 0, 0],
"Seoul  KOR" : ["", "", "KOR", 37.531893, 126.919116],
"Short Hills NJ USA" : ["Short Hills", "NJ", "USA", 40.74835, -74.323219],
"Silver Spring MD USA" : ["Silver Spring", "MD", "USA", 38.990666, -77.026088],
"Skokie IL USA" : ["Skokie", "IL", "USA", 42.032403, -87.741625],
"Somerset NJ USA" : ["Somerset", "NJ", "USA", 40.52921, -74.640043],
"Somerville NJ USA" : ["Somerville", "NJ", "USA", 40.57427, -74.60988],
"South Melbourne  AUS" : ["", "", "AUS", -37.832379, 144.960433],
"Southlake TX USA" : ["Southlake", "TX", "USA", 32.941236, -97.134178],
"Southport  AUS" : ["", "", "AUS", -27.967307, 153.414515],
"St. Louis MO USA" : ["St. Louis", "MO", "USA", 38.627003, -90.199404],
"St. Paul MN USA" : ["St. Paul", "MN", "USA", 44.953703, -93.089958],
"Stamford CT USA" : ["Stamford", "CT", "USA", 41.05343, -73.538734],
"State College PA USA" : ["State College", "PA", "USA", 40.793395, -77.860001],
"Sterling VA USA" : ["Sterling", "VA", "USA", 39.006699, -77.42913],
"Stockholm  SWE" : ["", "", "SWE", 47.057147, -68.134182],
"Sugar Land TX USA" : ["Sugar Land", "TX", "USA", 29.619679, -95.634946],
"Summit NJ USA" : ["Summit", "NJ", "USA", 40.714638, -74.364612],
"Sunnyvale CA USA" : ["Sunnyvale", "CA", "USA", 37.36883, -122.03635],
"Sutton  GBR" : ["", "", "GBR", 51.361428, -0.193961],
"Sutton MA USA" : ["Sutton", "MA", "USA", 42.150035, -71.763288],
"Tallahassee FL USA" : ["Tallahassee", "FL", "USA", 30.438256, -84.280733],
"Tampa FL USA" : ["Tampa", "FL", "USA", 27.950575, -82.457178],
"Tangerang  IDN" : ["", "", "IDN", 0, 0],
"Tavagnacco  ITA" : ["", "", "ITA", 46.127465, 13.210952],
"Tel Aviv  ISR" : ["", "", "ISR", 32.0853, 34.781768],
"Tempe AZ USA" : ["Tempe", "AZ", "USA", 33.42551, -111.940005],
"Thane  IND" : ["", "", "IND", 19.218331, 72.97809],
"Tokyo  JPN" : ["", "", "JPN", 35.688535, 139.894784],
"Toronto ON CAN" : ["Toronto", "ON", "CAN", 43.633968, -79.412442],
"Valley Forge CA USA" : ["Valley Forge", "CA", "USA", 33.661201, -117.906192],
"Vancouver British Columbia CAN" : ["Vancouver", "British Columbia", "CAN", 49.286186, -123.125432],
"Venice CA USA" : ["Venice", "CA", "USA", 33.985047, -118.469483],
"Ventura CA USA" : ["Ventura", "CA", "USA", 34.274646, -119.229032],
"Vienna VA USA" : ["Vienna", "VA", "USA", 38.901223, -77.26526],
"Villa El Salvador Lima PER" : ["Villa El Salvador", "Lima", "PER", -12.216222, -76.941544],
"Villanova PA USA" : ["Villanova", "PA", "USA", 40.037583, -75.349181],
"Voronezh, Russia  RUS" : ["", "", "RUS", 51.63323, 39.18677],
"Waltham MA USA" : ["Waltham", "MA", "USA", 42.376485, -71.235611],
"Warren MI USA" : ["Warren", "MI", "USA", 42.514457, -83.014653],
"Warren NJ USA" : ["Warren", "NJ", "USA", 40.634249, -74.50048],
"Warsaw  POL" : ["", "", "POL", 52.207564, 20.944607],
"Washington DC USA" : ["Washington", "DC", "USA", 38.907192, -77.036871],
"Washington  DC USA" : ["Washington ", "DC", "USA", 38.907192, -77.036871],
"Watertown MA USA" : ["Watertown", "MA", "USA", 42.37093, -71.182832],
"Wayne NJ USA" : ["Wayne", "NJ", "USA", 40.925372, -74.276544],
"West Loop IL USA" : ["West Loop", "IL", "USA", 41.882457, -87.644677],
"West Warwick RI USA" : ["West Warwick", "RI", "USA", 41.703671, -71.521502],
"Westminster CO USA" : ["Westminster", "CO", "USA", 39.836653, -105.037205],
"Westport CT USA" : ["Westport", "CT", "USA", 41.141472, -73.357905],
"White Plains NY USA" : ["White Plains", "NY", "USA", 41.033986, -73.76291],
"White River Junction VT USA" : ["White River Junction", "VT", "USA", 43.64896, -72.319258],
"Williamsville NY USA" : ["Williamsville", "NY", "USA", 42.963947, -78.737809],
"Wyckoff NJ USA" : ["Wyckoff", "NJ", "USA", 41.009532, -74.172911],
"Yonkers NY USA" : ["Yonkers", "NY", "USA", 40.93121, -73.898747],
"Yorkville IL USA" : ["Yorkville", "IL", "USA", 41.641141, -88.447295],
"Zeist  NLD" : ["", "", "NLD", 52.090602, 5.233253]
    }
    try:
    	loc = "%s %s %s" % (org['org_hq_city'],org['org_hq_st_prov'], org['org_hq_country'])
    	org['org_hq_city'] = locs[loc][0]
    	org['org_hq_st_prov'] = locs[loc][1]
        org['org_hq_country_locode'] = locs[loc][2]
        org['latitude'] = float(locs[loc][3])
    	org['longitude'] = float(locs[loc][4])
        print "%s, %s" % (org['latitude'], org['longitude'])
        print "loc match success"
    except:
    	org['org_hq_city'] = None
    	org['org_hq_st_prov'] = None
        org['org_hq_country_locode'] = None
        org['latitude'] = None
    	org['longitude'] = None
        print "loc match failed"
        # print org['org_hq_city'], org['org_hq_country'], org['latitude']
    
    # try:
    #     loc = "Y(%s)" % (org['org_hq_country'])
    #     org['org_hq_country_locode'] = locs[loc][2]
    # except:
    #     print "N(%s)" % org['org_hq_country']

    # try:
    #     loc = "%s" % (org['org_hq_country'])
    #     # print "--%s" % (org['org_hq_country'])
    #     org['org_hq_city'] = None
    #     org['org_hq_st_prov'] = None
    #     org['org_hq_country_locode'] = locs[loc][2]
    #     org['latitude'] = float(locs[loc][3])
    #     org['longitude'] = float(locs[loc][4])
    #     # print ">>%s" % (locs[loc])
    # except:
    #      print "(%s)" % org['org_hq_country']
    #      # print locs['United Kingdom']


    regions = {
"AFG": {"ISO3166-1-UNLOC": "AF", "COUNTRY-NAME": "Afghanistan", "COUNTRY": "Afghanistan", "COUNTRY CODE": "AFG", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Low income", "INCOME CODE": "LIC"},
"AX": {"ISO3166-1-UNLOC": "AX", "COUNTRY-NAME": "Åland Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"ALB": {"ISO3166-1-UNLOC": "AL", "COUNTRY-NAME": "Albania", "COUNTRY": "Albania", "COUNTRY CODE": "ALB", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"DZA": {"ISO3166-1-UNLOC": "DZ", "COUNTRY-NAME": "Algeria", "COUNTRY": "Algeria", "COUNTRY CODE": "DZA", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ASM": {"ISO3166-1-UNLOC": "AS", "COUNTRY-NAME": "American Samoa", "COUNTRY": "American Samoa", "COUNTRY CODE": "ASM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ADO": {"ISO3166-1-UNLOC": "AD", "COUNTRY-NAME": "Andorra", "COUNTRY": "Andorra", "COUNTRY CODE": "ADO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"AGO": {"ISO3166-1-UNLOC": "AO", "COUNTRY-NAME": "Angola", "COUNTRY": "Angola", "COUNTRY CODE": "AGO", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"AI": {"ISO3166-1-UNLOC": "AI", "COUNTRY-NAME": "Anguilla", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"AQ": {"ISO3166-1-UNLOC": "AQ", "COUNTRY-NAME": "Antarctica", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"ATG": {"ISO3166-1-UNLOC": "AG", "COUNTRY-NAME": "Antigua and Barbuda", "COUNTRY": "Antigua and Barbuda", "COUNTRY CODE": "ATG", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"ARG": {"ISO3166-1-UNLOC": "AR", "COUNTRY-NAME": "Argentina", "COUNTRY": "Argentina", "COUNTRY CODE": "ARG", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ARM": {"ISO3166-1-UNLOC": "AM", "COUNTRY-NAME": "Armenia", "COUNTRY": "Armenia", "COUNTRY CODE": "ARM", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ABW": {"ISO3166-1-UNLOC": "AW", "COUNTRY-NAME": "Aruba", "COUNTRY": "Aruba", "COUNTRY CODE": "ABW", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"AUS": {"ISO3166-1-UNLOC": "AU", "COUNTRY-NAME": "Australia", "COUNTRY": "Australia", "COUNTRY CODE": "AUS", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"AUT": {"ISO3166-1-UNLOC": "AT", "COUNTRY-NAME": "Austria", "COUNTRY": "Austria", "COUNTRY CODE": "AUT", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"AZE": {"ISO3166-1-UNLOC": "AZ", "COUNTRY-NAME": "Azerbaijan", "COUNTRY": "Azerbaijan", "COUNTRY CODE": "AZE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BHS": {"ISO3166-1-UNLOC": "BS", "COUNTRY-NAME": "Bahamas", "COUNTRY": "Bahamas, The", "COUNTRY CODE": "BHS", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"BHR": {"ISO3166-1-UNLOC": "BH", "COUNTRY-NAME": "Bahrain", "COUNTRY": "Bahrain", "COUNTRY CODE": "BHR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"BGD": {"ISO3166-1-UNLOC": "BD", "COUNTRY-NAME": "Bangladesh", "COUNTRY": "Bangladesh", "COUNTRY CODE": "BGD", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BRB": {"ISO3166-1-UNLOC": "BB", "COUNTRY-NAME": "Barbados", "COUNTRY": "Barbados", "COUNTRY CODE": "BRB", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"BLR": {"ISO3166-1-UNLOC": "BY", "COUNTRY-NAME": "Belarus", "COUNTRY": "Belarus", "COUNTRY CODE": "BLR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BEL": {"ISO3166-1-UNLOC": "BE", "COUNTRY-NAME": "Belgium", "COUNTRY": "Belgium", "COUNTRY CODE": "BEL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"BLZ": {"ISO3166-1-UNLOC": "BZ", "COUNTRY-NAME": "Belize", "COUNTRY": "Belize", "COUNTRY CODE": "BLZ", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BEN": {"ISO3166-1-UNLOC": "BJ", "COUNTRY-NAME": "Benin", "COUNTRY": "Benin", "COUNTRY CODE": "BEN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BMU": {"ISO3166-1-UNLOC": "BM", "COUNTRY-NAME": "Bermuda", "COUNTRY": "Bermuda", "COUNTRY CODE": "BMU", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"BTN": {"ISO3166-1-UNLOC": "BT", "COUNTRY-NAME": "Bhutan", "COUNTRY": "Bhutan", "COUNTRY CODE": "BTN", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"BOL": {"ISO3166-1-UNLOC": "BO", "COUNTRY-NAME": "Bolivia", "COUNTRY": "Bolivia", "COUNTRY CODE": "BOL", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"BQ": {"ISO3166-1-UNLOC": "BQ", "COUNTRY-NAME": "Bonaire, Sint Eustatius and Saba", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"BIH": {"ISO3166-1-UNLOC": "BA", "COUNTRY-NAME": "Bosnia and Herzegovina", "COUNTRY": "Bosnia and Herzegovina", "COUNTRY CODE": "BIH", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BWA": {"ISO3166-1-UNLOC": "BW", "COUNTRY-NAME": "Botswana", "COUNTRY": "Botswana", "COUNTRY CODE": "BWA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BRA": {"ISO3166-1-UNLOC": "BR", "COUNTRY-NAME": "Brazil", "COUNTRY": "Brazil", "COUNTRY CODE": "BRA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"IO": {"ISO3166-1-UNLOC": "IO", "COUNTRY-NAME": "British Indian Ocean Territory", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"BRN": {"ISO3166-1-UNLOC": "BN", "COUNTRY-NAME": "Brunei Darussalam", "COUNTRY": "Brunei Darussalam", "COUNTRY CODE": "BRN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"BGR": {"ISO3166-1-UNLOC": "BG", "COUNTRY-NAME": "Bulgaria", "COUNTRY": "Bulgaria", "COUNTRY CODE": "BGR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BFA": {"ISO3166-1-UNLOC": "BF", "COUNTRY-NAME": "Burkina Faso", "COUNTRY": "Burkina Faso", "COUNTRY CODE": "BFA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BDI": {"ISO3166-1-UNLOC": "BI", "COUNTRY-NAME": "Burundi", "COUNTRY": "Burundi", "COUNTRY CODE": "BDI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"KHM": {"ISO3166-1-UNLOC": "KH", "COUNTRY-NAME": "Cambodia", "COUNTRY": "Cambodia", "COUNTRY CODE": "KHM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CMR": {"ISO3166-1-UNLOC": "CM", "COUNTRY-NAME": "Cameroon", "COUNTRY": "Cameroon", "COUNTRY CODE": "CMR", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"CAN": {"ISO3166-1-UNLOC": "CA", "COUNTRY-NAME": "Canada", "COUNTRY": "Canada", "COUNTRY CODE": "CAN", "REGION": "North America", "REGION CODE": "NAM", "INCOME": "High income", "INCOME CODE": "HIC"},
"CPV": {"ISO3166-1-UNLOC": "CV", "COUNTRY-NAME": "Cape Verde", "COUNTRY": "Cabo Verde", "COUNTRY CODE": "CPV", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"CYM": {"ISO3166-1-UNLOC": "KY", "COUNTRY-NAME": "Cayman Islands", "COUNTRY": "Cayman Islands", "COUNTRY CODE": "CYM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"CAF": {"ISO3166-1-UNLOC": "CF", "COUNTRY-NAME": "Central African Republic", "COUNTRY": "Central African Republic", "COUNTRY CODE": "CAF", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"TCD": {"ISO3166-1-UNLOC": "TD", "COUNTRY-NAME": "Chad", "COUNTRY": "Chad", "COUNTRY CODE": "TCD", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CHL": {"ISO3166-1-UNLOC": "CL", "COUNTRY-NAME": "Chile", "COUNTRY": "Chile", "COUNTRY CODE": "CHL", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"CHN": {"ISO3166-1-UNLOC": "CN", "COUNTRY-NAME": "China", "COUNTRY": "China", "COUNTRY CODE": "CHN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"CX": {"ISO3166-1-UNLOC": "CX", "COUNTRY-NAME": "Christmas Island", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"CHI": {"ISO3166-1-UNLOC": "U1", "COUNTRY-NAME": "null", "COUNTRY": "Channel Islands", "COUNTRY CODE": "CHI", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CC": {"ISO3166-1-UNLOC": "CC", "COUNTRY-NAME": "Cocos (Keeling) Islands", "COUNTRY": "", "COUNTRY CODE": "", "REGION": "", "REGION CODE": "", "INCOME": "", "INCOME CODE": ""},
"COL": {"ISO3166-1-UNLOC": "CO", "COUNTRY-NAME": "Colombia", "COUNTRY": "Colombia", "COUNTRY CODE": "COL", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"COM": {"ISO3166-1-UNLOC": "KM", "COUNTRY-NAME": "Comoros", "COUNTRY": "Comoros", "COUNTRY CODE": "COM", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"COG": {"ISO3166-1-UNLOC": "CG", "COUNTRY-NAME": "Congo", "COUNTRY": "Congo, Rep.", "COUNTRY CODE": "COG", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ZAR": {"ISO3166-1-UNLOC": "CD", "COUNTRY-NAME": "Congo, The Democratic Republic of the", "COUNTRY": "Congo, Dem. Rep.", "COUNTRY CODE": "ZAR", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CK": {"ISO3166-1-UNLOC": "CK", "COUNTRY-NAME": "Cook Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"CRI": {"ISO3166-1-UNLOC": "CR", "COUNTRY-NAME": "Costa Rica", "COUNTRY": "Costa Rica", "COUNTRY CODE": "CRI", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"CIV": {"ISO3166-1-UNLOC": "CI", "COUNTRY-NAME": "Côte d'Ivoire", "COUNTRY": "Côte d'Ivoire", "COUNTRY CODE": "CIV", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"HRV": {"ISO3166-1-UNLOC": "HR", "COUNTRY-NAME": "Croatia", "COUNTRY": "Croatia", "COUNTRY CODE": "HRV", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CUB": {"ISO3166-1-UNLOC": "CU", "COUNTRY-NAME": "Cuba", "COUNTRY": "Cuba", "COUNTRY CODE": "CUB", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"CUW": {"ISO3166-1-UNLOC": "CW", "COUNTRY-NAME": "Curaçao", "COUNTRY": "Curaçao", "COUNTRY CODE": "CUW", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"CYP": {"ISO3166-1-UNLOC": "CY", "COUNTRY-NAME": "Cyprus", "COUNTRY": "Cyprus", "COUNTRY CODE": "CYP", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CZE": {"ISO3166-1-UNLOC": "CZ", "COUNTRY-NAME": "Czech Republic", "COUNTRY": "Czech Republic", "COUNTRY CODE": "CZE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"DNK": {"ISO3166-1-UNLOC": "DK", "COUNTRY-NAME": "Denmark", "COUNTRY": "Denmark", "COUNTRY CODE": "DNK", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"DJI": {"ISO3166-1-UNLOC": "DJ", "COUNTRY-NAME": "Djibouti", "COUNTRY": "Djibouti", "COUNTRY CODE": "DJI", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"DMA": {"ISO3166-1-UNLOC": "DM", "COUNTRY-NAME": "Dominica", "COUNTRY": "Dominica", "COUNTRY CODE": "DMA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"DOM": {"ISO3166-1-UNLOC": "DO", "COUNTRY-NAME": "Dominican Republic", "COUNTRY": "Dominican Republic", "COUNTRY CODE": "DOM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ECU": {"ISO3166-1-UNLOC": "EC", "COUNTRY-NAME": "Ecuador", "COUNTRY": "Ecuador", "COUNTRY CODE": "ECU", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"EGY": {"ISO3166-1-UNLOC": "EG", "COUNTRY-NAME": "Egypt", "COUNTRY": "Egypt, Arab Rep.", "COUNTRY CODE": "EGY", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SLV": {"ISO3166-1-UNLOC": "SV", "COUNTRY-NAME": "El Salvador", "COUNTRY": "El Salvador", "COUNTRY CODE": "SLV", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"GNQ": {"ISO3166-1-UNLOC": "GQ", "COUNTRY-NAME": "Equatorial Guinea", "COUNTRY": "Equatorial Guinea", "COUNTRY CODE": "GNQ", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ERI": {"ISO3166-1-UNLOC": "ER", "COUNTRY-NAME": "Eritrea", "COUNTRY": "Eritrea", "COUNTRY CODE": "ERI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"EST": {"ISO3166-1-UNLOC": "EE", "COUNTRY-NAME": "Estonia", "COUNTRY": "Estonia", "COUNTRY CODE": "EST", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ETH": {"ISO3166-1-UNLOC": "ET", "COUNTRY-NAME": "Ethiopia", "COUNTRY": "Ethiopia", "COUNTRY CODE": "ETH", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"FK": {"ISO3166-1-UNLOC": "FK", "COUNTRY-NAME": "Falkland Islands (Malvinas)", "COUNTRY": "", "COUNTRY CODE": "", "REGION": "", "REGION CODE": "", "INCOME": "", "INCOME CODE": ""},
"FRO": {"ISO3166-1-UNLOC": "FO", "COUNTRY-NAME": "Faroe Islands", "COUNTRY": "Faeroe Islands", "COUNTRY CODE": "FRO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"FJI": {"ISO3166-1-UNLOC": "FJ", "COUNTRY-NAME": "Fiji", "COUNTRY": "Fiji", "COUNTRY CODE": "FJI", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"FIN": {"ISO3166-1-UNLOC": "FI", "COUNTRY-NAME": "Finland", "COUNTRY": "Finland", "COUNTRY CODE": "FIN", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"FRA": {"ISO3166-1-UNLOC": "FR", "COUNTRY-NAME": "France", "COUNTRY": "France", "COUNTRY CODE": "FRA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GF": {"ISO3166-1-UNLOC": "GF", "COUNTRY-NAME": "French Guiana", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PYF": {"ISO3166-1-UNLOC": "PF", "COUNTRY-NAME": "French Polynesia", "COUNTRY": "French Polynesia", "COUNTRY CODE": "PYF", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"TF": {"ISO3166-1-UNLOC": "TF", "COUNTRY-NAME": "French Southern Territories", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GAB": {"ISO3166-1-UNLOC": "GA", "COUNTRY-NAME": "Gabon", "COUNTRY": "Gabon", "COUNTRY CODE": "GAB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"GMB": {"ISO3166-1-UNLOC": "GM", "COUNTRY-NAME": "Gambia", "COUNTRY": "Gambia, The", "COUNTRY CODE": "GMB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"GEO": {"ISO3166-1-UNLOC": "GE", "COUNTRY-NAME": "Georgia", "COUNTRY": "Georgia", "COUNTRY CODE": "GEO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"DEU": {"ISO3166-1-UNLOC": "DE", "COUNTRY-NAME": "Germany", "COUNTRY": "Germany", "COUNTRY CODE": "DEU", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GHA": {"ISO3166-1-UNLOC": "GH", "COUNTRY-NAME": "Ghana", "COUNTRY": "Ghana", "COUNTRY CODE": "GHA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"GI": {"ISO3166-1-UNLOC": "GI", "COUNTRY-NAME": "Gibraltar", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GRC": {"ISO3166-1-UNLOC": "GR", "COUNTRY-NAME": "Greece", "COUNTRY": "Greece", "COUNTRY CODE": "GRC", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GRL": {"ISO3166-1-UNLOC": "GL", "COUNTRY-NAME": "Greenland", "COUNTRY": "Greenland", "COUNTRY CODE": "GRL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GRD": {"ISO3166-1-UNLOC": "GD", "COUNTRY-NAME": "Grenada", "COUNTRY": "Grenada", "COUNTRY CODE": "GRD", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"GP": {"ISO3166-1-UNLOC": "GP", "COUNTRY-NAME": "Guadeloupe", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GUM": {"ISO3166-1-UNLOC": "GU", "COUNTRY-NAME": "Guam", "COUNTRY": "Guam", "COUNTRY CODE": "GUM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"GTM": {"ISO3166-1-UNLOC": "GT", "COUNTRY-NAME": "Guatemala", "COUNTRY": "Guatemala", "COUNTRY CODE": "GTM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"GG": {"ISO3166-1-UNLOC": "GG", "COUNTRY-NAME": "Guernsey", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GIN": {"ISO3166-1-UNLOC": "GN", "COUNTRY-NAME": "Guinea", "COUNTRY": "Guinea", "COUNTRY CODE": "GIN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"GNB": {"ISO3166-1-UNLOC": "GW", "COUNTRY-NAME": "Guinea-Bissau", "COUNTRY": "Guinea-Bissau", "COUNTRY CODE": "GNB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"GUY": {"ISO3166-1-UNLOC": "GY", "COUNTRY-NAME": "Guyana", "COUNTRY": "Guyana", "COUNTRY CODE": "GUY", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"HTI": {"ISO3166-1-UNLOC": "HT", "COUNTRY-NAME": "Haiti", "COUNTRY": "Haiti", "COUNTRY CODE": "HTI", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Low income", "INCOME CODE": "LIC"},
"HM": {"ISO3166-1-UNLOC": "HM", "COUNTRY-NAME": "Heard Island and McDonald Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"VA": {"ISO3166-1-UNLOC": "VA", "COUNTRY-NAME": "Holy See (Vatican City State)", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"HND": {"ISO3166-1-UNLOC": "HN", "COUNTRY-NAME": "Honduras", "COUNTRY": "Honduras", "COUNTRY CODE": "HND", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"HKG": {"ISO3166-1-UNLOC": "HK", "COUNTRY-NAME": "Hong Kong", "COUNTRY": "Hong Kong SAR, China", "COUNTRY CODE": "HKG", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"HUN": {"ISO3166-1-UNLOC": "HU", "COUNTRY-NAME": "Hungary", "COUNTRY": "Hungary", "COUNTRY CODE": "HUN", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ISL": {"ISO3166-1-UNLOC": "IS", "COUNTRY-NAME": "Iceland", "COUNTRY": "Iceland", "COUNTRY CODE": "ISL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IND": {"ISO3166-1-UNLOC": "IN", "COUNTRY-NAME": "India", "COUNTRY": "India", "COUNTRY CODE": "IND", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"IDN": {"ISO3166-1-UNLOC": "ID", "COUNTRY-NAME": "Indonesia", "COUNTRY": "Indonesia", "COUNTRY CODE": "IDN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"XZ": {"ISO3166-1-UNLOC": "XZ", "COUNTRY-NAME": "Installations in International Waters", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"IRN": {"ISO3166-1-UNLOC": "IR", "COUNTRY-NAME": "Iran, Islamic Republic of", "COUNTRY": "Iran, Islamic Rep.", "COUNTRY CODE": "IRN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"IRQ": {"ISO3166-1-UNLOC": "IQ", "COUNTRY-NAME": "Iraq", "COUNTRY": "Iraq", "COUNTRY CODE": "IRQ", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"IRL": {"ISO3166-1-UNLOC": "IE", "COUNTRY-NAME": "Ireland", "COUNTRY": "Ireland", "COUNTRY CODE": "IRL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IMY": {"ISO3166-1-UNLOC": "IM", "COUNTRY-NAME": "Isle of Man", "COUNTRY": "Isle of Man", "COUNTRY CODE": "IMY", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ISR": {"ISO3166-1-UNLOC": "IL", "COUNTRY-NAME": "Israel", "COUNTRY": "Israel", "COUNTRY CODE": "ISR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ITA": {"ISO3166-1-UNLOC": "IT", "COUNTRY-NAME": "Italy", "COUNTRY": "Italy", "COUNTRY CODE": "ITA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"JAM": {"ISO3166-1-UNLOC": "JM", "COUNTRY-NAME": "Jamaica", "COUNTRY": "Jamaica", "COUNTRY CODE": "JAM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"JPN": {"ISO3166-1-UNLOC": "JP", "COUNTRY-NAME": "Japan", "COUNTRY": "Japan", "COUNTRY CODE": "JPN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"JE": {"ISO3166-1-UNLOC": "JE", "COUNTRY-NAME": "Jersey", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"JOR": {"ISO3166-1-UNLOC": "JO", "COUNTRY-NAME": "Jordan", "COUNTRY": "Jordan", "COUNTRY CODE": "JOR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"KAZ": {"ISO3166-1-UNLOC": "KZ", "COUNTRY-NAME": "Kazakhstan", "COUNTRY": "Kazakhstan", "COUNTRY CODE": "KAZ", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"KEN": {"ISO3166-1-UNLOC": "KE", "COUNTRY-NAME": "Kenya", "COUNTRY": "Kenya", "COUNTRY CODE": "KEN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"KIR": {"ISO3166-1-UNLOC": "KI", "COUNTRY-NAME": "Kiribati", "COUNTRY": "Kiribati", "COUNTRY CODE": "KIR", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PRK": {"ISO3166-1-UNLOC": "KP", "COUNTRY-NAME": "Korea, Democratic People's Republic of", "COUNTRY": "Korea, Dem. Rep.", "COUNTRY CODE": "PRK", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Low income", "INCOME CODE": "LIC"},
"KOR": {"ISO3166-1-UNLOC": "KR", "COUNTRY-NAME": "Korea, Republic of", "COUNTRY": "Korea, Rep.", "COUNTRY CODE": "KOR", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"KSV": {"ISO3166-1-UNLOC": "U2", "COUNTRY-NAME": "null", "COUNTRY": "Kosovo", "COUNTRY CODE": "KSV", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"KWT": {"ISO3166-1-UNLOC": "KW", "COUNTRY-NAME": "Kuwait", "COUNTRY": "Kuwait", "COUNTRY CODE": "KWT", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"KGZ": {"ISO3166-1-UNLOC": "KG", "COUNTRY-NAME": "Kyrgyzstan", "COUNTRY": "Kyrgyz Republic", "COUNTRY CODE": "KGZ", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"LAO": {"ISO3166-1-UNLOC": "LA", "COUNTRY-NAME": "Lao People's Democratic Republic", "COUNTRY": "Lao PDR", "COUNTRY CODE": "LAO", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"LVA": {"ISO3166-1-UNLOC": "LV", "COUNTRY-NAME": "Latvia", "COUNTRY": "Latvia", "COUNTRY CODE": "LVA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LBN": {"ISO3166-1-UNLOC": "LB", "COUNTRY-NAME": "Lebanon", "COUNTRY": "Lebanon", "COUNTRY CODE": "LBN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"LSO": {"ISO3166-1-UNLOC": "LS", "COUNTRY-NAME": "Lesotho", "COUNTRY": "Lesotho", "COUNTRY CODE": "LSO", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"LBR": {"ISO3166-1-UNLOC": "LR", "COUNTRY-NAME": "Liberia", "COUNTRY": "Liberia", "COUNTRY CODE": "LBR", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"LBY": {"ISO3166-1-UNLOC": "LY", "COUNTRY-NAME": "Libya", "COUNTRY": "Libya", "COUNTRY CODE": "LBY", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"LIE": {"ISO3166-1-UNLOC": "LI", "COUNTRY-NAME": "Liechtenstein", "COUNTRY": "Liechtenstein", "COUNTRY CODE": "LIE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LTU": {"ISO3166-1-UNLOC": "LT", "COUNTRY-NAME": "Lithuania", "COUNTRY": "Lithuania", "COUNTRY CODE": "LTU", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LUX": {"ISO3166-1-UNLOC": "LU", "COUNTRY-NAME": "Luxembourg", "COUNTRY": "Luxembourg", "COUNTRY CODE": "LUX", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"MAC": {"ISO3166-1-UNLOC": "MO", "COUNTRY-NAME": "Macao", "COUNTRY": "Macao SAR, China", "COUNTRY CODE": "MAC", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"MKD": {"ISO3166-1-UNLOC": "MK", "COUNTRY-NAME": "Macedonia, The former Yugoslav Republic of", "COUNTRY": "Macedonia, FYR", "COUNTRY CODE": "MKD", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MDG": {"ISO3166-1-UNLOC": "MG", "COUNTRY-NAME": "Madagascar", "COUNTRY": "Madagascar", "COUNTRY CODE": "MDG", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MWI": {"ISO3166-1-UNLOC": "MW", "COUNTRY-NAME": "Malawi", "COUNTRY": "Malawi", "COUNTRY CODE": "MWI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MYS": {"ISO3166-1-UNLOC": "MY", "COUNTRY-NAME": "Malaysia", "COUNTRY": "Malaysia", "COUNTRY CODE": "MYS", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MDV": {"ISO3166-1-UNLOC": "MV", "COUNTRY-NAME": "Maldives", "COUNTRY": "Maldives", "COUNTRY CODE": "MDV", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MLI": {"ISO3166-1-UNLOC": "ML", "COUNTRY-NAME": "Mali", "COUNTRY": "Mali", "COUNTRY CODE": "MLI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MLT": {"ISO3166-1-UNLOC": "MT", "COUNTRY-NAME": "Malta", "COUNTRY": "Malta", "COUNTRY CODE": "MLT", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"MHL": {"ISO3166-1-UNLOC": "MH", "COUNTRY-NAME": "Marshall Islands", "COUNTRY": "Marshall Islands", "COUNTRY CODE": "MHL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MQ": {"ISO3166-1-UNLOC": "MQ", "COUNTRY-NAME": "Martinique", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MRT": {"ISO3166-1-UNLOC": "MR", "COUNTRY-NAME": "Mauritania", "COUNTRY": "Mauritania", "COUNTRY CODE": "MRT", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MUS": {"ISO3166-1-UNLOC": "MU", "COUNTRY-NAME": "Mauritius", "COUNTRY": "Mauritius", "COUNTRY CODE": "MUS", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"YT": {"ISO3166-1-UNLOC": "YT", "COUNTRY-NAME": "Mayotte", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MEX": {"ISO3166-1-UNLOC": "MX", "COUNTRY-NAME": "Mexico", "COUNTRY": "Mexico", "COUNTRY CODE": "MEX", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"FSM": {"ISO3166-1-UNLOC": "FM", "COUNTRY-NAME": "Micronesia, Federated States of", "COUNTRY": "Micronesia, Fed. Sts.", "COUNTRY CODE": "FSM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MDA": {"ISO3166-1-UNLOC": "MD", "COUNTRY-NAME": "Moldova, Republic of", "COUNTRY": "Moldova", "COUNTRY CODE": "MDA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MCO": {"ISO3166-1-UNLOC": "MC", "COUNTRY-NAME": "Monaco", "COUNTRY": "Monaco", "COUNTRY CODE": "MCO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"MNG": {"ISO3166-1-UNLOC": "MN", "COUNTRY-NAME": "Mongolia", "COUNTRY": "Mongolia", "COUNTRY CODE": "MNG", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MNE": {"ISO3166-1-UNLOC": "ME", "COUNTRY-NAME": "Montenegro", "COUNTRY": "Montenegro", "COUNTRY CODE": "MNE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MS": {"ISO3166-1-UNLOC": "MS", "COUNTRY-NAME": "Montserrat", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MAR": {"ISO3166-1-UNLOC": "MA", "COUNTRY-NAME": "Morocco", "COUNTRY": "Morocco", "COUNTRY CODE": "MAR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MOZ": {"ISO3166-1-UNLOC": "MZ", "COUNTRY-NAME": "Mozambique", "COUNTRY": "Mozambique", "COUNTRY CODE": "MOZ", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MMR": {"ISO3166-1-UNLOC": "MM", "COUNTRY-NAME": "Myanmar", "COUNTRY": "Myanmar", "COUNTRY CODE": "MMR", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Low income", "INCOME CODE": "LIC"},
"NAM": {"ISO3166-1-UNLOC": "NA", "COUNTRY-NAME": "Namibia", "COUNTRY": "Namibia", "COUNTRY CODE": "NAM", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"NR": {"ISO3166-1-UNLOC": "NR", "COUNTRY-NAME": "Nauru", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"NPL": {"ISO3166-1-UNLOC": "NP", "COUNTRY-NAME": "Nepal", "COUNTRY": "Nepal", "COUNTRY CODE": "NPL", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Low income", "INCOME CODE": "LIC"},
"NLD": {"ISO3166-1-UNLOC": "NL", "COUNTRY-NAME": "Netherlands", "COUNTRY": "Netherlands", "COUNTRY CODE": "NLD", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"NCL": {"ISO3166-1-UNLOC": "NC", "COUNTRY-NAME": "New Caledonia", "COUNTRY": "New Caledonia", "COUNTRY CODE": "NCL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"NZL": {"ISO3166-1-UNLOC": "NZ", "COUNTRY-NAME": "New Zealand", "COUNTRY": "New Zealand", "COUNTRY CODE": "NZL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"NIC": {"ISO3166-1-UNLOC": "NI", "COUNTRY-NAME": "Nicaragua", "COUNTRY": "Nicaragua", "COUNTRY CODE": "NIC", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"NER": {"ISO3166-1-UNLOC": "NE", "COUNTRY-NAME": "Niger", "COUNTRY": "Niger", "COUNTRY CODE": "NER", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"NGA": {"ISO3166-1-UNLOC": "NG", "COUNTRY-NAME": "Nigeria", "COUNTRY": "Nigeria", "COUNTRY CODE": "NGA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"NU": {"ISO3166-1-UNLOC": "NU", "COUNTRY-NAME": "Niue", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"NF": {"ISO3166-1-UNLOC": "NF", "COUNTRY-NAME": "Norfolk Island", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MNP": {"ISO3166-1-UNLOC": "MP", "COUNTRY-NAME": "Northern Mariana Islands", "COUNTRY": "Northern Mariana Islands", "COUNTRY CODE": "MNP", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"NOR": {"ISO3166-1-UNLOC": "NO", "COUNTRY-NAME": "Norway", "COUNTRY": "Norway", "COUNTRY CODE": "NOR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"OMN": {"ISO3166-1-UNLOC": "OM", "COUNTRY-NAME": "Oman", "COUNTRY": "Oman", "COUNTRY CODE": "OMN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"PAK": {"ISO3166-1-UNLOC": "PK", "COUNTRY-NAME": "Pakistan", "COUNTRY": "Pakistan", "COUNTRY CODE": "PAK", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PLW": {"ISO3166-1-UNLOC": "PW", "COUNTRY-NAME": "Palau", "COUNTRY": "Palau", "COUNTRY CODE": "PLW", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PS": {"ISO3166-1-UNLOC": "PS", "COUNTRY-NAME": "Palestine, State of", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PAN": {"ISO3166-1-UNLOC": "PA", "COUNTRY-NAME": "Panama", "COUNTRY": "Panama", "COUNTRY CODE": "PAN", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PNG": {"ISO3166-1-UNLOC": "PG", "COUNTRY-NAME": "Papua New Guinea", "COUNTRY": "Papua New Guinea", "COUNTRY CODE": "PNG", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PRY": {"ISO3166-1-UNLOC": "PY", "COUNTRY-NAME": "Paraguay", "COUNTRY": "Paraguay", "COUNTRY CODE": "PRY", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PER": {"ISO3166-1-UNLOC": "PE", "COUNTRY-NAME": "Peru", "COUNTRY": "Peru", "COUNTRY CODE": "PER", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PHL": {"ISO3166-1-UNLOC": "PH", "COUNTRY-NAME": "Philippines", "COUNTRY": "Philippines", "COUNTRY CODE": "PHL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PN": {"ISO3166-1-UNLOC": "PN", "COUNTRY-NAME": "Pitcairn", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"POL": {"ISO3166-1-UNLOC": "PL", "COUNTRY-NAME": "Poland", "COUNTRY": "Poland", "COUNTRY CODE": "POL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"PRT": {"ISO3166-1-UNLOC": "PT", "COUNTRY-NAME": "Portugal", "COUNTRY": "Portugal", "COUNTRY CODE": "PRT", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"PRI": {"ISO3166-1-UNLOC": "PR", "COUNTRY-NAME": "Puerto Rico", "COUNTRY": "Puerto Rico", "COUNTRY CODE": "PRI", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"QAT": {"ISO3166-1-UNLOC": "QA", "COUNTRY-NAME": "Qatar", "COUNTRY": "Qatar", "COUNTRY CODE": "QAT", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"RE": {"ISO3166-1-UNLOC": "RE", "COUNTRY-NAME": "Reunion", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"ROM": {"ISO3166-1-UNLOC": "RO", "COUNTRY-NAME": "Romania", "COUNTRY": "Romania", "COUNTRY CODE": "ROM", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"RUS": {"ISO3166-1-UNLOC": "RU", "COUNTRY-NAME": "Russian Federation", "COUNTRY": "Russian Federation", "COUNTRY CODE": "RUS", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"RWA": {"ISO3166-1-UNLOC": "RW", "COUNTRY-NAME": "Rwanda", "COUNTRY": "Rwanda", "COUNTRY CODE": "RWA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BL": {"ISO3166-1-UNLOC": "BL", "COUNTRY-NAME": "Saint Barthélemy", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"SH": {"ISO3166-1-UNLOC": "SH", "COUNTRY-NAME": "Saint Helena, Ascension and Tristan Da Cunha", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"KN": {"ISO3166-1-UNLOC": "KN", "COUNTRY-NAME": "Saint Kitts and Nevis", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"LC": {"ISO3166-1-UNLOC": "LC", "COUNTRY-NAME": "Saint Lucia", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MF": {"ISO3166-1-UNLOC": "MF", "COUNTRY-NAME": "Saint Martin (French Part)", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PM": {"ISO3166-1-UNLOC": "PM", "COUNTRY-NAME": "Saint Pierre and Miquelon", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"VC": {"ISO3166-1-UNLOC": "VC", "COUNTRY-NAME": "Saint Vincent and the Grenadines", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"WSM": {"ISO3166-1-UNLOC": "WS", "COUNTRY-NAME": "Samoa", "COUNTRY": "Samoa", "COUNTRY CODE": "WSM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SMR": {"ISO3166-1-UNLOC": "SM", "COUNTRY-NAME": "San Marino", "COUNTRY": "San Marino", "COUNTRY CODE": "SMR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"STP": {"ISO3166-1-UNLOC": "ST", "COUNTRY-NAME": "Sao Tome and Principe", "COUNTRY": "São Tomé and Principe", "COUNTRY CODE": "STP", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SAU": {"ISO3166-1-UNLOC": "SA", "COUNTRY-NAME": "Saudi Arabia", "COUNTRY": "Saudi Arabia", "COUNTRY CODE": "SAU", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SEN": {"ISO3166-1-UNLOC": "SN", "COUNTRY-NAME": "Senegal", "COUNTRY": "Senegal", "COUNTRY CODE": "SEN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SRB": {"ISO3166-1-UNLOC": "RS", "COUNTRY-NAME": "Serbia", "COUNTRY": "Serbia", "COUNTRY CODE": "SRB", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SYC": {"ISO3166-1-UNLOC": "SC", "COUNTRY-NAME": "Seychelles", "COUNTRY": "Seychelles", "COUNTRY CODE": "SYC", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SLE": {"ISO3166-1-UNLOC": "SL", "COUNTRY-NAME": "Sierra Leone", "COUNTRY": "Sierra Leone", "COUNTRY CODE": "SLE", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"SGP": {"ISO3166-1-UNLOC": "SG", "COUNTRY-NAME": "Singapore", "COUNTRY": "Singapore", "COUNTRY CODE": "SGP", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"SXM": {"ISO3166-1-UNLOC": "SX", "COUNTRY-NAME": "Sint Maarten (Dutch Part)", "COUNTRY": "Sint Maarten (Dutch part)", "COUNTRY CODE": "SXM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"SVK": {"ISO3166-1-UNLOC": "SK", "COUNTRY-NAME": "Slovakia", "COUNTRY": "Slovak Republic", "COUNTRY CODE": "SVK", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SVN": {"ISO3166-1-UNLOC": "SI", "COUNTRY-NAME": "Slovenia", "COUNTRY": "Slovenia", "COUNTRY CODE": "SVN", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SLB": {"ISO3166-1-UNLOC": "SB", "COUNTRY-NAME": "Solomon Islands", "COUNTRY": "Solomon Islands", "COUNTRY CODE": "SLB", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SOM": {"ISO3166-1-UNLOC": "SO", "COUNTRY-NAME": "Somalia", "COUNTRY": "Somalia", "COUNTRY CODE": "SOM", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"ZAF": {"ISO3166-1-UNLOC": "ZA", "COUNTRY-NAME": "South Africa", "COUNTRY": "South Africa", "COUNTRY CODE": "ZAF", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"GS": {"ISO3166-1-UNLOC": "GS", "COUNTRY-NAME": "South Georgia and the South Sandwich Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"SSD": {"ISO3166-1-UNLOC": "SS", "COUNTRY-NAME": "South Sudan", "COUNTRY": "South Sudan", "COUNTRY CODE": "SSD", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ESP": {"ISO3166-1-UNLOC": "ES", "COUNTRY-NAME": "Spain", "COUNTRY": "Spain", "COUNTRY CODE": "ESP", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LKA": {"ISO3166-1-UNLOC": "LK", "COUNTRY-NAME": "Sri Lanka", "COUNTRY": "Sri Lanka", "COUNTRY CODE": "LKA", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"KNA": {"ISO3166-1-UNLOC": "U2", "COUNTRY-NAME": "null", "COUNTRY": "St. Kitts and Nevis", "COUNTRY CODE": "KNA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"LCA": {"ISO3166-1-UNLOC": "U4", "COUNTRY-NAME": "null", "COUNTRY": "St. Lucia", "COUNTRY CODE": "LCA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MAF": {"ISO3166-1-UNLOC": "U5", "COUNTRY-NAME": "null", "COUNTRY": "St. Martin (French part)", "COUNTRY CODE": "MAF", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"VCT": {"ISO3166-1-UNLOC": "U6", "COUNTRY-NAME": "null", "COUNTRY": "St. Vincent and the Grenadines", "COUNTRY CODE": "VCT", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SDN": {"ISO3166-1-UNLOC": "SD", "COUNTRY-NAME": "Sudan", "COUNTRY": "Sudan", "COUNTRY CODE": "SDN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SUR": {"ISO3166-1-UNLOC": "SR", "COUNTRY-NAME": "Suriname", "COUNTRY": "Suriname", "COUNTRY CODE": "SUR", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SJ": {"ISO3166-1-UNLOC": "SJ", "COUNTRY-NAME": "Svalbard and Jan Mayen", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"SWZ": {"ISO3166-1-UNLOC": "SZ", "COUNTRY-NAME": "Swaziland", "COUNTRY": "Swaziland", "COUNTRY CODE": "SWZ", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SWE": {"ISO3166-1-UNLOC": "SE", "COUNTRY-NAME": "Sweden", "COUNTRY": "Sweden", "COUNTRY CODE": "SWE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CHE": {"ISO3166-1-UNLOC": "CH", "COUNTRY-NAME": "Switzerland", "COUNTRY": "Switzerland", "COUNTRY CODE": "CHE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SYR": {"ISO3166-1-UNLOC": "SY", "COUNTRY-NAME": "Syrian Arab Republic", "COUNTRY": "Syrian Arab Republic", "COUNTRY CODE": "SYR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"TW": {"ISO3166-1-UNLOC": "TW", "COUNTRY-NAME": "Taiwan, Province of China", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"TJK": {"ISO3166-1-UNLOC": "TJ", "COUNTRY-NAME": "Tajikistan", "COUNTRY": "Tajikistan", "COUNTRY CODE": "TJK", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"TZA": {"ISO3166-1-UNLOC": "TZ", "COUNTRY-NAME": "Tanzania, United Republic of", "COUNTRY": "Tanzania", "COUNTRY CODE": "TZA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"THA": {"ISO3166-1-UNLOC": "TH", "COUNTRY-NAME": "Thailand", "COUNTRY": "Thailand", "COUNTRY CODE": "THA", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TMP": {"ISO3166-1-UNLOC": "TL", "COUNTRY-NAME": "Timor-Leste", "COUNTRY": "Timor-Leste", "COUNTRY CODE": "TMP", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"TGO": {"ISO3166-1-UNLOC": "TG", "COUNTRY-NAME": "Togo", "COUNTRY": "Togo", "COUNTRY CODE": "TGO", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"TK": {"ISO3166-1-UNLOC": "TK", "COUNTRY-NAME": "Tokelau", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"TON": {"ISO3166-1-UNLOC": "TO", "COUNTRY-NAME": "Tonga", "COUNTRY": "Tonga", "COUNTRY CODE": "TON", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TTO": {"ISO3166-1-UNLOC": "TT", "COUNTRY-NAME": "Trinidad and Tobago", "COUNTRY": "Trinidad and Tobago", "COUNTRY CODE": "TTO", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"TUN": {"ISO3166-1-UNLOC": "TN", "COUNTRY-NAME": "Tunisia", "COUNTRY": "Tunisia", "COUNTRY CODE": "TUN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TUR": {"ISO3166-1-UNLOC": "TR", "COUNTRY-NAME": "Turkey", "COUNTRY": "Turkey", "COUNTRY CODE": "TUR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TKM": {"ISO3166-1-UNLOC": "TM", "COUNTRY-NAME": "Turkmenistan", "COUNTRY": "Turkmenistan", "COUNTRY CODE": "TKM", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TCA": {"ISO3166-1-UNLOC": "TC", "COUNTRY-NAME": "Turks and Caicos Islands", "COUNTRY": "Turks and Caicos Islands", "COUNTRY CODE": "TCA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"TUV": {"ISO3166-1-UNLOC": "TV", "COUNTRY-NAME": "Tuvalu", "COUNTRY": "Tuvalu", "COUNTRY CODE": "TUV", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"UGA": {"ISO3166-1-UNLOC": "UG", "COUNTRY-NAME": "Uganda", "COUNTRY": "Uganda", "COUNTRY CODE": "UGA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"UKR": {"ISO3166-1-UNLOC": "UA", "COUNTRY-NAME": "Ukraine", "COUNTRY": "Ukraine", "COUNTRY CODE": "UKR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ARE": {"ISO3166-1-UNLOC": "AE", "COUNTRY-NAME": "United Arab Emirates", "COUNTRY": "United Arab Emirates", "COUNTRY CODE": "ARE", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GBR": {"ISO3166-1-UNLOC": "GB", "COUNTRY-NAME": "United Kingdom", "COUNTRY": "United Kingdom", "COUNTRY CODE": "GBR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"USA": {"ISO3166-1-UNLOC": "US", "COUNTRY-NAME": "United States", "COUNTRY": "United States", "COUNTRY CODE": "USA", "REGION": "North America", "REGION CODE": "NAM", "INCOME": "High income", "INCOME CODE": "HIC"},
"UM": {"ISO3166-1-UNLOC": "UM", "COUNTRY-NAME": "United States Minor Outlying Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"URY": {"ISO3166-1-UNLOC": "UY", "COUNTRY-NAME": "Uruguay", "COUNTRY": "Uruguay", "COUNTRY CODE": "URY", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"UZB": {"ISO3166-1-UNLOC": "UZ", "COUNTRY-NAME": "Uzbekistan", "COUNTRY": "Uzbekistan", "COUNTRY CODE": "UZB", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VUT": {"ISO3166-1-UNLOC": "VU", "COUNTRY-NAME": "Vanuatu", "COUNTRY": "Vanuatu", "COUNTRY CODE": "VUT", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VEN": {"ISO3166-1-UNLOC": "VE", "COUNTRY-NAME": "Venezuela", "COUNTRY": "Venezuela, RB", "COUNTRY CODE": "VEN", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"VNM": {"ISO3166-1-UNLOC": "VN", "COUNTRY-NAME": "Viet Nam", "COUNTRY": "Vietnam", "COUNTRY CODE": "VNM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VIR": {"ISO3166-1-UNLOC": "VG", "COUNTRY-NAME": "Virgin Islands, British", "COUNTRY": "Virgin Islands (U.S.)", "COUNTRY CODE": "VIR", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"WBG": {"ISO3166-1-UNLOC": "U7", "COUNTRY-NAME": "null", "COUNTRY": "West Bank and Gaza", "COUNTRY CODE": "WBG", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VI": {"ISO3166-1-UNLOC": "VI", "COUNTRY-NAME": "Virgin Islands, U.S.", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"WF": {"ISO3166-1-UNLOC": "WF", "COUNTRY-NAME": "Wallis and Futuna", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"EH": {"ISO3166-1-UNLOC": "EH", "COUNTRY-NAME": "Western Sahara", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"YEM": {"ISO3166-1-UNLOC": "YE", "COUNTRY-NAME": "Yemen", "COUNTRY": "Yemen, Rep.", "COUNTRY CODE": "YEM", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ZMB": {"ISO3166-1-UNLOC": "ZM", "COUNTRY-NAME": "Zambia", "COUNTRY": "Zambia", "COUNTRY CODE": "ZMB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ZWE": {"ISO3166-1-UNLOC": "ZW", "COUNTRY-NAME": "Zimbabwe", "COUNTRY": "Zimbabwe", "COUNTRY CODE": "ZWE", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"}
}
    try:
        # org['org_hq_country_locode'] 
        print "%s %s" % (org['org_hq_country_locode'], regions[org['org_hq_country_locode']]['REGION'])
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
        print "use: %s" % usage.strip()
        usage_split = usage.split(":")
        if len(usage_split) < 1:
            continue
        if len(usage_split) < 2:
            usage_split.append("")
        usage_split[0] = usage_split[0].strip()
        usage_split[1] = usage_split[1].strip()
        print "***%s, %s" % (usage_split[0], usage_split[1])

        try:
            # print "(%s)->%s" % (usage_split[0], usage_key[usage_split[0]])
            org[usage_key[usage_split[0]]] = True
            org[usage_key[usage_split[0]]+"_desc"] = usage_split[1]
        except:
            print "ERROR: "
        # print "usage_split[1] %s" % usage_split[1]
        # print usage_key[usage_split[0]]+"_desc"
    print org
    # delete unparsed key
    org.pop('usage_unparsed', None)



#   Append org if eligible
    if org['eligibility'] == 'Y' and org['org_confidence'] > 3 and org['org_hq_country'] != "Spain" and (org['latitude'] is not None) and org['latitude'] != 0 and org['longitude'] != 0 :
        org_list.append(org)
        print "appended"
        # print org['org_hq_city'], org['org_hq_country']
    else:
    	org_list_not_used.append(org)

#     #print org_list
print "============"
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
        if 0 == len(data_src) or None == data_src or "null" == data_src:
            org['data_type'] = None
            org['data_src_country_locode'] = None
            org['data_src_gov_level'] = None
            org['row_type'] = "data_use"
            continue
        org['data_type'], org['data_src_country_locode'], org['data_src_gov_level'] = data_src.split(";")
        org['row_type'] = "data_use"
        org['data_type'] = org['data_type'].strip()
        org['data_src_gov_level'] = org['data_src_gov_level'].strip()
        org['data_src_country_locode'] = org['data_src_country_locode'].strip()
        if  org['data_src_country_locode'] is not None and 3 == len(org['data_src_country_locode']) and 'EUR' != org['data_src_country_locode']:
            org['data_src_country_locode'] = regions[org['data_src_country_locode']]['ISO3166-1-UNLOC']

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

