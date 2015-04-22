## ArcGIS Online Integration Job

The following code synchronizes data from the ODE Parse API to an ArcGIS Online hosted-feature-service.

###Configuration

####Add ArcGIS Online Account Credentials
Running this job requires credentials for ArcGIS Online with at minimum `publisher` role. 

###Testing
To run associated tests:

    $> cd ./scripts/agol-integration
    $> nosetests -v

`
----------------------------------------------------------------------
Ran 3 tests in 4.643s

OK
`


