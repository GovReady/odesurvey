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
·         http://en.wikipedia.org/wiki/ISO_3166-1

For city level data, you can either use a Placefinder – Esri has one built into ArcGIS Online
·         http://www.arcgis.com/home/webmap/viewer.html?useExisting=1 (top right)

·         https://developers.arcgis.com/javascript/jssamples/index.html#search