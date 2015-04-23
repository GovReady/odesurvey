## ArcGIS Online Integration Job

The following code synchronizes data from the ODE Parse API to an ArcGIS Online hosted-feature-service.


####Setup

- Install the latest version of Python 2.7.  If below version 2.7.9, install PIP also:

        $> yum install python
        $> yum install python-devel
        $> yum install python-pip

- Install 3rd-party python packages:

        $> cd ./scripts/agol-integration
        $> pip install -r requirements.txt



Running this job requires user credentials for ArcGIS Online with at minimum `publisher` level role. 

Set credentials by either:

- Adding credentials directly to `settings.py` file:

        import os

        class BaseSettings(object):

            def __init__(self):
                self.agol_user = os.environ.get('AGOL_USER', '<my user name>') # - add ArcGIS Online User ID or set environment variable
                self.agol_pass = os.environ.get('AGOL_PASS','<my user password>')  # - add ArcGIS Online User Pass or set environment variable

- Setting environment variables (edit `/etc/profile.d`):

        export AGOL_USER=<my user name>
        export AGOL_PASS=<my user password>

####Scheduling

Add script to crontab:

        22 4 * * 0 root <install_path>/scripts/agol-integration/arcgis_online_sync.sh

####Testing
To run associated tests:

    $> cd ./scripts/agol-integration
    $> nosetests -v


    ----------------------------------------------------------------------
    Ran 3 tests in 4.643s

    OK



