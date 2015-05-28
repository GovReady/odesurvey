import os

class BaseSettings(object):

    def __init__(self):
        self.agol_user = os.environ.get('AGOL_USER', '')  # - add ArcGIS Online User ID or set environment variable
        self.agol_pass = os.environ.get('AGOL_PASS', '')  # - add ArcGIS Online User Pass or set environment variable
        self.parse_data_endpoint = 'http://odetest.govready.org/survey/opendata/data/flatfile.json'
        self.arcgis_source_file = 'arcgis_flatfile.json'

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

# - set active environment
env = DevelopmentSettings()
# env = StagingSettings()
# env = ProductionSettings()

# - logging helper
import logging
import logging.handlers

def get_logger(file_name, logger_name='AppLogger', level=logging.INFO, return_handlers=False):

    # - logging setup
    log_formater = logging.Formatter("%(asctime)s    %(threadName)s    %(levelname)s    %(message)s")
    logger = logging.getLogger(logger_name)

    file_handler = logging.handlers.RotatingFileHandler(file_name, maxBytes=1024*1024*10, backupCount=1)
    file_handler.setFormatter(log_formater)
    file_handler.setLevel(level)
    logger.addHandler(file_handler)

    stream_handler = logging.StreamHandler()
    stream_handler.setFormatter(log_formater)
    stream_handler.setLevel(level)
    logger.addHandler(stream_handler)

    if return_handlers:
        return logger, [file_handler, stream_handler]

    return logger
