## ArcGIS Online Integration Job

The following code synchronizes data from the ODE Parse API to an ArcGIS Online hosted-feature-service.


####Add ArcGIS Online Account Credentials
Running this job requires credentials for ArcGIS Online with at minimum `publisher` role. 

Set credentials by either:

- Add directly to settings.py file:

    import os

    class BaseSettings(object):

        def __init__(self):
            self.agol_user = os.environ.get('AGOL_USER', '<my user name>') # - add ArcGIS Online User ID or set environment variable
            self.agol_pass = os.environ('AGOL_PASS','<my user password>')  # - add ArcGIS Online User Pass or set environment variable

- Set environment variables

    export AGOL_USER=<my user name>
    export AGOL_PASS=<my user password>

###Testing
To run associated tests:

    $> cd ./scripts/agol-integration
    $> nosetests -v


    ----------------------------------------------------------------------
    Ran 3 tests in 4.643s

    OK



