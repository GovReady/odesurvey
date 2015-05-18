import os

from nose.plugins.attrib import attr
import pandas
import requests 

from agol_integration import settings
from agol_integration import agol
from agol_integration import agol_integration

class TestAgolIntegration(object):

    def setup(self):
        self.test_settings = settings.DevelopmentSettings()
        self.token = agol.generate_token(self.test_settings.agol_user, self.test_settings.agol_pass)

    def test_get_parse_content(self):
        df = agol_integration.get_parse_content(self.test_settings.arcgis_source_file)
        assert isinstance(df, pandas.DataFrame)
        assert not df.empty

    def test_refresh_agol(self):
        df = agol_integration.get_parse_content(self.test_settings.arcgis_source_file)
        result = agol_integration.refresh_agol(df, self.test_settings.agol_feature_service_url, self.token)
        assert result
    
    @attr('main')
    def test_main(self):
        result = agol_integration.main(self.test_settings)
        assert result
