General Notes
=============

# Timeline

Please take note of the following targets and dates:

April 10: ODE will send BR a first dataset (c. 400 organizations) 
April 10-30: Data collection continues.
April 30: Map (beta)
May 1 - 12): Map testing and iteration
May 13: Official launch of the Map

# Map Resources
Country Codes
- http://en.wikipedia.org/wiki/ISO_3166-1

For city level data, you can either use a Placefinder – Esri has one built into ArcGIS Online
- http://www.arcgis.com/home/webmap/viewer.html?useExisting=1 (top right)
- https://developers.arcgis.com/javascript/jssamples/index.html#search
- http://www.geonames.org

# Configuring a remote host using ansible playbook

Note the `,` in the name of server to indicate the information is a list and not reference to an inventory file

```
# Dry run from local machine to remote machine
ansible-playbook -i 'odetest.govready.org,' -u root --check playbook-digitalocean.yml 

# Execute from local machine to remote machine
ansible-playbook -i 'odetest.govready.org,' -u root --check playbook-digitalocean.yml 
```

After configuring server, do the following.
- Create user with github access to repository (e.g., 'gregelin')
- Grant user sudo privileges
- CD into `~/.ssh` and create `rsa_id` key
- Cat and copy `rsa_id.pub` to computer clipboard and add to deploy keys
- Remember to create credentials.inc.php file

# How to use

http://192.168.56.101/survey/opendata/ will taky user to http://192.168.56.101/survey/opendata/start/
will create a record and direct them to survey.

# Links 
- [Final question text](https://docs.google.com/a/odenterprise.org/document/d/1kULpKCE5lIuQ3oWBKzWOYFnGgudKPE3R9xeeix86zrs/edit)
- [Sample data](https://docs.google.com/a/odenterprise.org/spreadsheets/d/1I7rVX0y-ligniOMlFFZG4jYTiOML7DEACk_ARrbExjk/edit#gid=1692297685)

# Snippets

## Mailgun

```
curl -s --user 'api:key-c70b6xxxxxxxxxxxx' \
https://api.mailgun.net/v3/sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org/messages \
-F from='Excited User <mailgun@sandboxc1675fc5cc30472ca9bd4af8028cbcdf.mailgun.org>' \
-F to=greg@odenterprise.org \
-F subject='Hello' \
-F text='Testing some Mailgun awesomness!'
```

## ArcGIS Online
```
http://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/find?f=pjson&text=Raleigh, NC, USA
```

### Placefinder

Country Codes
- http://en.wikipedia.org/wiki/ISO_3166-1

For city level data, you can either use a Placefinder – Esri has one built into ArcGIS Online
- http://www.arcgis.com/home/webmap/viewer.html?useExisting=1 (top right)
- https://developers.arcgis.com/javascript/jssamples/index.html#search


# Admin
Administration is still under development.

To create an admin account, fill out user information inside `html/map/survey/signup.php` script and call from browser. This will create a proper account in Parse database with encrypted password.

# Update the Map Visualization (Publishing profiles to ArcGIS Online to)

The map is updated by publishing data from the Parse.com database to ArcGIS Online Feature service. Publishing fresh data involves the following steps:
1. Opening a terminal
2. Navagating to the directory with the `agol_integration.py` script
3. Setting environment variables to access AGOL and set target feature
4. Running python script
5. Checking output

The `agol_integration.py` script requires username and password and target feature enviornment (development, staging, production) to  be set.
(Service being used by map is defined in the file `html/map/viz/app/js/map/map_config.js`.)

#### Example terminal session of these steps:

```
# navigate to repository
cd /path/projects/odesurvey

# navigate to directory with agol_integration.py script
cd scripts/agol-integration/agol_integration

# set environmental variables
AGOL_USER=myuserame
export AGOL_USER
AGOL_PASS=mypassword
export AGOL_PASS
AGOL_ENV=development
export AGOL_ENV

# Run agol_integration.py
python agol_integration.py

```

*NOTE* If you receive an error starting with "InsecurePlatformWarning: A true SSLContext object is not available. This prevents urllib3 from configuring SSL appropriately and may cause certain SSL connections to fail...", correct this issue by installing requests-security module using pip with the shell command: `sudo pip install requests[security]`

#### Example terminal session output from command `python agol_integration.py`
```

Parsing data from json file http://www.opendataenterprise.org/map/survey/data/flatfile.json
found 0 problematic records (see problem_records.json)
Updating AGOL Development environment schema https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0 for account myuserame
/Library/Python/2.7/site-packages/pandas/util/decorators.py:81: FutureWarning: the 'outtype' keyword is deprecated, use 'orient' instead
  warnings.warn(msg, FutureWarning)
deleted 2728 items from https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 100 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 200 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 300 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 400 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 500 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 600 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 700 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 800 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 900 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1000 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1100 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1200 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1300 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1400 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1500 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1600 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1700 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1800 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 1900 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2000 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2100 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2200 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2300 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2400 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2500 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2600 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2700 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
successfully added 2728 items, failed to add 0 items to https://services.arcgis.com/Fsk4zuQe2Ol9olZc/arcgis/rest/services/ode_organizations_dev_0715/FeatureServer/0
```

# Dev / Staging / Production for Map

### In the viz app source files

In the file `viz-src/src/app/js/map/map_config.js` the first few lines set up where the application gets the data:11
```
  var agsserver = "https://services5.arcgis.com/w1WEecz5ClslKH2Q/ArcGIS/rest/services";
  var runAs = 'develop';
  var mode = {
    'develop': 'ode_organizations_dev',
    'staging': 'ode_organizations_staging',
    'production': 'ode_organizations_dev'
  }
```

To change the service the application pulls from in the source you need to change the line to which mode you’d like: ‘develop’, ‘staging’, ‘production'

```
  var runAs = 'develop’;
```

### In the viz app compiled files

These lines are compiled into the file `html/map/viz/app/js/map/map_config.js` to be displayed as:
```
  var e="https://services5.arcgis.com/w1WEecz5ClslKH2Q/ArcGIS/rest/services",a="develop",t={develop:"ode_organizations_dev",staging:"ode_organizations_staging",production:"ode_organizations_dev"},
```

To change the service the application pulls from in the compiled app change the value to which mode you’d like: ‘develop’, ‘staging’, ‘production'

```
  a="develop"
```

AGOL Python Integration:
To change to service to be updated when running the script:

In the file scripts/agol-integration/agol-integration/settings.py there are three class, one for each of the environments:

```
class DevelopmentSettings(BaseSettings):
    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = 'https://services5.arcgis.com/w1WEecz5ClslKH2Q/arcgis/rest/services/ode_organizations_dev/FeatureServer/0'

class StagingSettings(BaseSettings):
    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = 'https://services5.arcgis.com/w1WEecz5ClslKH2Q/arcgis/rest/services/ode_organizations_staging/FeatureServer/0'

class ProductionSettings(BaseSettings):
    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = 'https://services5.arcgis.com/w1WEecz5ClslKH2Q/arcgis/rest/services/ode_organizations_production/FeatureServer/0'
```

# Using ArcGIS Online Web Interface to Manage Features

## Example update

### Docs
http://resources.arcgis.com/en/help/arcgis-rest-api and navigate to `Your own services` > `Feature Service` > `Update Features`

### Example
https://services5.arcgis.com/[appid]/ArcGIS/rest/services/ode_organizations_staging/FeatureServer/0/updateFeatures

Enter the following into field for `features`
[
    {
      "attributes" : {
      "FID": 12242,
        "org_name" : "Farm Canada XX"
      }
    }
]

Use the `FID` (Feature ID) as the `objectid`. To obtain the `FID`, run a query at url
https://services5.arcgis.com/[appid]/ArcGIS/rest/services/ode_organizations_staging/FeatureServer/0/query


# Miscellaneous Working Notes



