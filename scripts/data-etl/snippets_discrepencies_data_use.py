"""
Python snippets file for doing analysis of data_use_type 'Other' in profiles coming from surveys
Date: August 16, 2015
Author: Greg Elin

Usage:
  Do NOT run as a script
  Launch python interactive shell and copy and paste snippets into shell
"""


# Start in customers/OD\ Enterprise/flatfilejson

ff = "flatfile_debug_other_20150815.json"
with open(ff) as datafile:
  j = json.load(datafile)
    
# Test #1 on a specific profile
def reeepinfo(profile):
  """ Test script to figure out matching """
  if profile['profile_id'] == 'HmPmVfzgVN':
  	print profile['org_name']
  	print profile['row_type']
  	if profile['row_type'] == 'data_use':
  		print profile['data_type']
  		print profile['data_use_type']
  	else:
  		pass

for p in j['results']:
  reeepinfo(p)

# Test #2 on a specific profile
def reeepmatch(profile):
  """ Test script to figure out matching """
  if profile['profile_id'] == 'HmPmVfzgVN':
  	if profile['row_type'] == 'data_use':
  		if profile['data_type'] not in profile['data_use_type']:
  			print "%s, %s, %s, %s, %s" % (profile['org_name'], profile['profile_id'], profile['objectId'], profile['data_type'], profile['data_use_type'])
  		else:
  			pass
  	else:
  		pass
  else:
  	pass

for p in j['results']:
  reeepmatch(p)

# Results
"""
Renewable Energy and Energy Efficiency Partnership (REEEP)
data_use
Climate 
[u'Energy', u'Environment', u'Other']
Renewable Energy and Energy Efficiency Partnership (REEEP)
data_use
Environment
[u'Energy', u'Environment', u'Other']
Renewable Energy and Energy Efficiency Partnership (REEEP)
data_use
Energy
[u'Energy', u'Environment', u'Other']
Renewable Energy and Energy Efficiency Partnership (REEEP)
data_use
Climate 
[u'Energy', u'Environment', u'Other']
Renewable Energy and Energy Efficiency Partnership (REEEP)
data_use
Environment
[u'Energy', u'Environment', u'Other']
Renewable Energy and Energy Efficiency Partnership (REEEP)
data_use
Energy
[u'Energy', u'Environment', u'Other']
Renewable Energy and Energy Efficiency Partnership (REEEP)
org_profile
"""


#
# Test #3 - This works! IDENTIFIES ALL PROFILES HAVING A POTENTIAL ISSUE with data_use other.
#

# Loop through data and print out records with a data_use discrepancy
def data_use_other_no_match(profile):
    """Find profiles where data_type is not found in data_use_type, suggesting record is an other."""
    if profile['row_type'] == 'data_use' and 'data_use_type' in profile:
        if profile['data_type'] not in profile['data_use_type']:
            print "%s\t%s\t%s\t%s\t%s\t%s" % (profile['profile_id'], profile['objectId'], profile['org_name'], profile['org_profile_src'], profile['data_type'], profile['data_use_type'])
        else:
            pass
    else:
        pass
  			
# Loop through data and print out records with a data_use discrepancy
print "profile_id\tobjectId\torg_name\torg_profile_src\tdata_type\tdata_use_type"
for p in j['results']:
    data_use_other_no_match(p)


# Result
"""
profile_id	objectId	org_name	org_profile_src	data_type	data_use_type
970	UEah9lNf8o	Hacks / Hackers Uruguay	Regional Supporter - DATA Uruguay	Other	[u'Null']
1018	vdxanPug6s	JSC Gosbook	World Bank Pipeline research	Other	[u'Null']
e5Q0Hcpcxs	nDLYrQXT2S	Suzuki Engineering	Adelheid & Andre	Other	[u'Other (Sports)']
e5Q0Hcpcxs	RZoxNGsZ6R	Suzuki Engineering	Adelheid & Andre	Other	[u'Other (Sports)']
1233	cbUydasxLf	ScoopMonkey	Roundtables	Transportation	[u'transportation']
1236	uzSJx3PDrC	Sentencing Project	CODE research	Legal	[u'legal']
1380	fRuPcDuoCA	www.2595.tw	Regional Supporter - Weather Risk	Other	[u'Other (Animal rights)']
989	e5oqsKKFnb	infographics.tw	Regional Supporter - Weather Risk	Other	[u'Null', u'Null']
989	gRhKriijMH	infographics.tw	Regional Supporter - Weather Risk	Other	[u'Null', u'Null']
HmPmVfzgVN	GmnmD5ObPz	Renewable Energy and Energy Efficiency Partnership (REEEP)	survey	Climate 	[u'Energy', u'Environment', u'Other']
HmPmVfzgVN	jsoivQaW8p	Renewable Energy and Energy Efficiency Partnership (REEEP)	survey	Climate 	[u'Energy', u'Environment', u'Other']
601	E0Ckr1fkru	Code for Pakistan	survey	Government operations	[u'Education', u'Energy', u'Geospatial/mapping', u'Health/healthcare', u'Transportation']
601	vTkeA0kQZH	Code for Pakistan	survey	Government operations	[u'Education', u'Energy', u'Geospatial/mapping', u'Health/healthcare', u'Transportation']
Y9mcRE2wWq	iVVJxem5Tk	MapYourProperty	survey	Other	[u'Demographics and social', u'Environment', u'Geospatial/mapping', u'Housing', u'Legal', u'Transportation', u'Other (Planning) ']
Y9mcRE2wWq	qY7tSEY5cm	MapYourProperty	survey	Other	[u'Demographics and social', u'Environment', u'Geospatial/mapping', u'Housing', u'Legal', u'Transportation', u'Other (Planning) ']
Y9mcRE2wWq	YOzrtdrWl7	MapYourProperty	survey	Other	[u'Demographics and social', u'Environment', u'Geospatial/mapping', u'Housing', u'Legal', u'Transportation', u'Other (Planning) ']
Y9mcRE2wWq	ijGBEfnZoZ	MapYourProperty	survey	Other	[u'Demographics and social', u'Environment', u'Geospatial/mapping', u'Housing', u'Legal', u'Transportation', u'Other (Planning) ']
652	2NWHOd00s2	Development Initiatives	ODI (Public Candidate Database)	Other	[u'Null', u'Null', u'Null', u'Null', u'Government operations']
652	HCJF5lbGl1	Development Initiatives	ODI (Public Candidate Database)	Other	[u'Null', u'Null', u'Null', u'Null', u'Government operations']
652	aushhdRJj3	Development Initiatives	ODI (Public Candidate Database)	Other	[u'Null', u'Null', u'Null', u'Null', u'Government operations']
652	eypqXLLEUx	Development Initiatives	ODI (Public Candidate Database)	Other	[u'Null', u'Null', u'Null', u'Null', u'Government operations']
547	qkm6zYIwkU	Bloomberg	OD500 US (unsubmitted)	None	[u'Null']
655	U145N3blK3	Digital Data Divide	CODE research	None	[u'Consumer']
504	GAA2kgQmaq	Aldevra	Roundtables	Other	[u'Other (Veterans Affairs)']
565	UZEltQVouv	Cambia	Roundtables	None	[u'Health/healthcare']
566	IuFJg3bfyt	Cambridge Systematics	Roundtables	Transportation	[u'transportation', u'transportation', u'Environment']
566	7c2fh4dJph	Cambridge Systematics	Roundtables	Transportation	[u'transportation', u'transportation', u'Environment']
568	q7Wcpsp6QD	Capital Post	Roundtables	Other	[u'Other (Veterans Affairs)']
621	nvVojTJIhI	Corporate Europe Observatory	IODC - Impact Session: IM2	None	[u'Agriculture', u'Environment', u'Economics']
653	IIcaacAxg0	DhilCare	Regional Supporter - Ennovent	Health/healthcare	[u'Health/healhcare']
665	R02spICOEE	Dublinked	Regional Supporter - Insight Centre	Other	[u'Null']
919	wpi33MSFSG	Flo Apps	CODE research	Other	[u'Null', u'Null']
919	OZFXxsHAnD	Flo Apps	CODE research	Other	[u'Null', u'Null']
944	AVCaxIYV55	George Washington University Office of Military and Veteran Student Services	Roundtables	Other	[u'Education', u'Health/healthcare', u'Other (Veterans Affairs)']
974	LMtVESewMO	Heineken	Regional Supporter - Capgemini Group	Agriculture	[u'Weather', u'agriculture']
984	IDN7WkaD5H	IHS	Roundtables	None	[u'Transportation', u'Agriculture', u'Health/healthcare', u'Economics', u'Legal']
997	XWS0LrK1Rd	Institute for Veterans and Military Families at Syracuse University (IVMF)	Roundtables	Other	[u'Other (Veterans Affairs)']
1010	5Ss8mQDUGb	Iraq and Afghanistan Veterans of America (IAVA)	Roundtables	Other	[u'Other (Veterans Affairs)']
1023	IoPHFUK8D6	Kathmandu Living Labs	CODE research	Other	[u'Null', u'Null']
1023	lr5dT6IxYd	Kathmandu Living Labs	CODE research	Other	[u'Null', u'Null']
1078	YKlzj2QSA7	Minesoft	Roundtables	Other	[u'Education', u'Health/healthcare', u'Other (Veterans Affairs)']
1094	GtkxrTrDqU	Niew Labs	CODE research	Demographics and social	[u'Demographics and Social', u'Economics']
VE0cUzqZVg	x9TOhUNLcV	equipment.data	survey	Other	[u'Other (Infrastructure) ']
1348	9nGyrKlGVQ	Veterans Enterprise Technology Solutions	Roundtables	Other	[u'Other (defense)']
1347	7dxW9DeT6z	vCloud'N'Sci.fi	CODE research	Other	[u'Null', u'Null']
1347	Y5gj5s7vWZ	vCloud'N'Sci.fi	CODE research	Other	[u'Null', u'Null']
1332	1vaFiq3YrQ	Unite US	Roundtables	Other	[u'Other (Veterans Affairs)']
1293	Fz87TG6Beq	The Better With Data Society	CODE research	Other	[u'Null', u'Null']
1293	BFEE0FTAY3	The Better With Data Society	CODE research	Other	[u'Null', u'Null']
1145	GkNhLkntuS	Open Referral	Roundtables	Other	[u'Legal', u'Other (Veterans Affairs)', u'Health/healthcare']
1150	iTtbUVy6NP	OpenGov	OD500 US (submitted)	Other	[u'Null']
1209	ATVBmBA9Ti	Reboot	IODC - Impact Session: IM1	None	[u'Health/healthcare', u'']
1209	Kfcy0Vst6h	Reboot	IODC - Impact Session: IM1	None	[u'Health/healthcare', u'']
1222	ekGWFqREq1	Roadify-Transit	OD500 US (submitted)	Other	[u'Null']
1254	yz4gTeRM5H	Socrata	OD500 US (submitted)	Other	[u'Null', u'Null']
1254	UzeBMSAS2i	Socrata	OD500 US (submitted)	Other	[u'Null', u'Null']
1275	tUpJUbmXyP	Student Veterans of America	Roundtables	Other	[u'Education', u'Other (Veterans Affairs)']
"""
