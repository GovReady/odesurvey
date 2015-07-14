/**
 * Created by jnordling on 12/14/14.
 */
define([],function(){
  var agsserver = "https://services.arcgis.com/Fsk4zuQe2Ol9olZc/ArcGIS/rest/services";
  var runAs = 'production';
  var mode = {
              'develop': 'ode_organizations_staging_jul13',
              'staging': 'ode_organizations_staging_jul13',
              'production': 'ode_organizations_production_jul13'
          }
  var features = [agsserver,mode[runAs],'FeatureServer/0'].join('/');
    var countries = [agsserver,'country_centroids','FeatureServer/0'].join('/');
    var countryPolys = [agsserver,'Countries','FeatureServer/0'].join('/');

   return{
          pannel_state: true,
          default_basemap:"streets",

            tempCountryURL: 'http://services.arcgis.com/EDxZDh4HqQ1a9KvA/ArcGIS/rest/services/Countries_ISO2/FeatureServer/0',

          features: features,
          countries: countries,
          countryPolys: countryPolys,
          clusterStatFields: [
           'org_type'
            // 'data_type',
            // 'org_type',
            // 'data_src_gov_level'
          ],

          countryFields: {
            target: "org_hq_country_locode",
            source: "ISO3136"
          },

          panels: [
          {
              selected: true,
              value: 'map',
              label: 'Map Results'
          },
          {
              selected: false,
              value: 'Table',
              label: 'Table Results'
          }

        ],

          filters: [
                {
                    label: 'Region',
                    value: 'Region',
                    selected: false,
                    source: {
                        url:features,
                        field:'org_hq_country_region'
                    },
                    // source: {url:features,field:'Region'}
                    items: [
                        ]
                },
                {
                    label: 'Country',
                    value: 'Country',
                    selected: false,
                    source: {
                      url:countries, 
                      field:'org_hq_country_locode',
                      groupBy: ['SHORT_NAME','ISO3136'],
                      labelField: 'SHORT_NAME',
                      valueField: 'ISO3136',

                    },
                    items: [{
                                selected: false,
                                value: 'value1',
                                label: 'country 1'
                            },
                            {
                                selected: true,
                                value: 'value2',
                                label: 'country 2'
                            }
                    ]
                },
                {
                    label: 'Organization Type',
                    value: 'orgtype',
                    source: {
                      url:features, 
                      field:'org_type'
                    },
                    showStats:true,
                    // showStatCounts: [
                    //   {value:'For-profit',label:'For-profit Companies'},
                    //   {value:'NonProfit',label:'Nonprofit Companies'}.
                    //   {value:'Other'}
                    // ],

                    selected: false,
                    items: [{
                                selected: false,
                                value: 'value1',
                                label: 'radio 1'
                            }
                    ]
                },
                {
                    label: 'Industry Category',
                    value: 'industry',
                    selected: false,
                    source: {
                      url:features, 
                      field:'industry_id'
                    },
                    items: [
                    ]
                },
                {
                    label: 'Data Type',
                    value: 'datatype',
                    selected: false,
                    source: {
                      url:features, 
                      field:'data_type'
                    },
                    items: []
                },
                {
                    label: 'Application',
                    value: 'dataApplication',
                    selected: false,
                    //source: {
                    //  url:features,
                    //  field:'data_src_gov_level'
                    //},
                    items: [{
                            selected: false,
                            field: 'use_advocacy',
                            label: 'Advocacy',
                            value: 1
                        },
                        {
                            selected: false,
                            field: 'use_prod_srvc',
                            label: 'New Products and Services',
                            value: 1
                        },
                        {
                            selected: false,
                            field: 'use_org_opt',
                            label: 'Organizational Optimization',
                            value: 1
                        },
                        {
                            selected: false,
                            field: 'use_research',
                            label: 'Research',
                            value: 1
                        },
                        {
                            selected: false,
                            field: 'use_other',
                            label: 'Other',
                            value: 1
                        }
                    ]
                }
            ],

          basemaps_options :[
             {
                'name': 'Imagery',
                'thumbnail': 'http://www.arcgis.com/sharing/rest/content/items/413fd05bbd7342f5991d5ec96f4f8b18/info/thumbnail/imagery_labels.jpg'
             },
             {
                'name':'Streets',
                'thumbnail':'http://www.arcgis.com/sharing/rest/content/items/d8855ee4d3d74413babfb0f41203b168/info/thumbnail/world_street_map.jpg'
             },
             {
                'name':'Gray',
                'thumbnail':"http://www.arcgis.com/sharing/rest/content/items/8b3b470883a744aeb60e5fff0a319ce7/info/thumbnail/light_gray_canvas.jpg"
             },
             {
                'name':'GrayLabels',
                'thumbnail':"http://www.arcgis.com/sharing/rest/content/items/8b3b470883a744aeb60e5fff0a319ce7/info/thumbnail/light_gray_canvas.jpg"
             },
             {
                'name':'DarkGray',
                'thumbnail':"http://www.arcgis.com/sharing/rest/content/items/8b3b470883a744aeb60e5fff0a319ce7/info/thumbnail/light_gray_canvas.jpg"
             }
          ],
          layers:[
            {
              'name':'Layer1',
              'url':'#url'
            },
            {
              'name':'Layer2',
              'url':'#url'
            },
            {
              'name':'Layer2',
              'url':'#url'
            }
          ]
   }
});