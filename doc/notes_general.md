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

To create an admin account, fill out user information inside html/map/survey/signup.php script and call from browser. This will create a proper account in Parse database with encrypted password.

# Dev / Staging / Production for Map

In the file app/js/map/map_config.js the first few lines set up where the application gets the data:11
```
  var agsserver = "https://services5.arcgis.com/w1WEecz5ClslKH2Q/ArcGIS/rest/services";
  var runAs = 'develop';
  var mode = {
              'develop': 'ode_organizations_dev',
              'staging': 'ode_organizations_staging',
              'production': 'ode_organizations_dev'
          }
```

To change the service the application pulls from you need to change the line 
```
  var runAs = 'develop’;
```

To which mode you’d like: ‘develop’, ‘staging’, ‘production'

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

Right after them is a block of code that sets which environment is passed back to the integration script:

```
# - set active environment
env = DevelopmentSettings()
# env = StagingSettings()
# env = ProductionSettings()
```

Only one should be uncommented at a time. The one not commented out sets the environment and which service is updated/overwritten.

# Miscellaneous Working Notes



