import os


class BaseSettings(object):

    def __init__(self):
        self.agol_user = '' # - add ArcGIS Online User ID
        self.agol_pass = '' # - add ArcGIS Online User Pass

class DevelopmentSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = ''

class StagingSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = ''

class ProductionSettings(BaseSettings):

    def __init__(self):
        BaseSettings.__init__(self)
        self.agol_feature_service_url = ''

env = DevelopmentSettings()


