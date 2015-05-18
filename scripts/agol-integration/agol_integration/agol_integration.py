# - std lib

import json
import sys

# - 3rd party
import pandas

# - local
import agol

def get_parse_content(file_path):
    with open(file_path, 'r') as d:
        content_response = json.loads(d.read())
        if 'results' in content_response.keys():
            df = pandas.DataFrame(content_response['results'])
            return df

def refresh_agol(source_df, destination_feature_service_layer, token):
    features = agol.dataframe_to_point_features(source_df, x_field='longitude', y_field='latitude', wkid=4326)
    agol.delete_features(destination_feature_service_layer, where='1=1', token=token)
    agol.add_features(destination_feature_service_layer, features, token=token)
    return True

def create_schema_file(input_file, output_file):
    with open(input_file, 'r') as data:
        j = json.loads(data.read())['results']
        df = pandas.DataFrame(j)
        df.head(2).to_csv(output_file, index=False, encoding='utf8')

def main(environment):
    agol_token = agol.generate_token(environment.agol_user, environment.agol_pass)
    df = get_parse_content(environment.arcgis_source_file)
    df = df.where((pandas.notnull(df)), None)  # - nan to None
    df = df[df.latitude.notnull() & df.longitude.notnull()]
    refresh_agol(df, environment.agol_feature_service_url, token=agol_token)
    return True

if __name__ == '__main__':

    if len(sys.argv) > 1 and sys.argv[1] == 'build_schema':
        create_schema_file(sys.argv[2], sys.argv[3])
        sys.exit(0)

    from settings import env
    main(env)
