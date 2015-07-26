[![Stories in Ready](https://badge.waffle.io/GovReady/odesurvey.png?label=ready&title=Ready)](https://waffle.io/GovReady/odesurvey)
# Open Data Impact Survey
Version 1.4

This is the first centralized, searchable database of open data use cases from around the world. Your contribution makes it possible to better understand the value of open data and encourage its use globally. Information collected will be displayed on http://www.opendataenterprise.org and will be made available as open data.

# License

TBD

# Requirements

- Virtualbox
- Vagrant
- Ansible
- Parse.com account and/or crendentials.inc.php file for parse.com

# Quickstart

1. Launch the virtual machine to get the GovReady CentOS environment
```
cd odesurvey
cd vm/basic
vagrant up
```

2. Open browser and go to location `http://192.168.56.101`

If the URL does not work check `vm/basic/Vagrantfile` and check file Vagrant configuration.

# Links

## General
1. [UN Locodes](http://www.unece.org/cefact/locode/welcome.html)
1. [UN Locodes subdivisions](http://www.unece.org/cefact/locode/subdivisions.html)
1. [Locodes stack overflow](http://stackoverflow.com/questions/7066825/is-there-an-iso-standard-for-city-identification)
1. [GSMAIntelligence](https://gsmaintelligence.com)

## Snippets
1. [x-editable demo.js see validate](http://vitalets.github.io/x-editable/assets/demo.js)
1. [x-editable mock ajax and console](http://vitalets.github.io/x-editable/assets/demo-mock.js)

# Credits

- Survey content: Audrey Ariss, Gustavo Magalhaus and all of Center for Open Data Enterprise
- Survey coding, CSS, Database and Adminstration: Greg Elin, GovReady.com
- Design: Sumiko Carter, ThreeSpot.com
- Map: BlueRaster
- Using ArcGIS Online
- Using SlimPHP Framework
- Using Parse PHP API Library - https://github.com/apotropaic/parse.com-php-library/blob/parse.com-php-library_v1/README.md
- Using jQuery Bootgrid - http://www.jquery-bootgrid.com

# Change Log

## Version 1.4
- Improved parsing on imported data
- Further work on edit page

## Version 1.3
- Improved language localization

## Version 1.2
- Guidance overlay
- Updated URL paths
- full integration of webflow, survey, with map hidden

## Version 1.1
- Improve parsing of inventory spreadsheet
- Updated URL paths
- Add login to restrict access to login pages

## Version 1.0
- Final survey content
- Final survey design
- Data submission and storage
- Early stage API for ARCGIS online and start of record management
- Simple start page

