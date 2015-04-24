# - std lib
import os
import sys

# - 3rd party
import pandas
import requests

# - local
import agol

def get_parse_content(url):
    content_response = requests.get(url)
    content_response.raise_for_status()
    if 'results' in content_response.json().keys():
        df = pandas.DataFrame(content_response.json()['results'])
        return df

def refresh_agol(source_df, destination_feature_service_layer, token):
    features = agol.dataframe_to_point_features(source_df, x_field='longitude', y_field='latitude', wkid=4326)
    agol.delete_features(destination_feature_service_layer, where='1=1', token=token)
    agol.add_features(destination_feature_service_layer, features, token=token)
    return True

def main(environment):
    agol_token = agol.generate_token(environment.agol_user, environment.agol_pass)
    df = get_parse_content(environment.parse_data_endpoint)
    refresh_agol(df, environment.agol_feature_service_url, token=agol_token)
    return True

if __name__ == '__main__':

    from settings import env
    main(env)
