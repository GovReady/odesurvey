define(["dojo/Deferred","map/map_config","widgets/StatisticsPane","widgets/WidgetFactory","cluster"],function(e,t,r,a,i){var o={};return o.create=function(e){var r,i,o=t.features,s=L.esri.Layers.featureLayer(o,{}),n=t.countries,u=L.esri.Layers.featureLayer(n,{}),l=new L.MarkerClusterGroup({singleMarkerMode:!0,showCoverageOnHover:!1,maxClusterRadius:50}),c={cluster:{obj:L.popup(),content:"<div id='{}'></div>",id:"clusterPopup"},marker:{obj:L.popup(),content:"<div class='markerPopup' id='{}'></div>",id:"markerPopup",titleField:"org_name",displayFields:[{field:"org_hq_country",label:"Country"},{field:"org_hq_city",label:"City"},{field:"org_year_founded",label:"Founding Year"},{field:"org_size_id",label:"Size"},{field:"org_type",label:"Organization Type"},{field:"org_url",label:"URL"},{field:"org_description",label:"Description"},{field:"org_profile_category",label:"Entry Based On"}],idField:"profile_id"}};l.addTo(e);var d={features:s,countries:u,clusterLayer:l,markers:[],statistics:[]},p=function(e,t){var r=_.pluck(e,"attributes").filter(function(e){return e[t]?!0:void 0});return _.countBy(r,t)},f=function(e){return t.clusterStatFields.map(function(t){return t?{fieldName:t,count:p(e,t)}:!1}).filter(function(e){return e})},b=function(t,r,a){t.obj.setLatLng(r).setContent(t.content.replace("{}",t.id)).openOn(e),a&&new a.constructor(a.props,t.id)},g=function(e,t,r){var a=c.marker,i=a.displayFields.map(function(t){var r={label:t.label,value:e.attributes[t.field]};return r});"1"==e.attributes.use_advocacy&&i.push({label:"Application",value:"Advocacy: "+e.attributes.use_advocacy_desc}),"1"==e.attributes.use_prod_srvc&&i.push({label:"Application",value:"New Products and Services: "+e.attributes.use_prod_srvc_desc}),"1"==e.attributes.use_org_opt&&i.push({label:"Application",value:"Organizational Optimization: "+e.attributes.use_org_opt_desc}),"1"==e.attributes.use_research&&i.push({label:"Application",value:"Research: "+e.attributes.use_research_desc}),"1"==e.attributes.use_other&&i.push({label:"Application",value:"Other: "+e.attributes.use_other_desc});var o={label:e.attributes[a.titleField],selected:r,toggle:t||!1};return{items:i,title:o,showContent:r,profileID:{value:e.attributes.profile_id}}},v=function(e){var t=c.marker,r=g(e,!1,!0);b(t,e.getLatLng(),{constructor:a.CompanyPopup,props:r})};return l.on("clusterclick",function(t){var r=t.layer.getAllChildMarkers(),i=r.map(function(e){return g(e,!0,!1)}),o=c.cluster,s={companies:i};e.getZoom()>=9&&b(o,t.latlng,{constructor:a.ClusterPopup,props:s})}),d.clearSearch=function(){document.getElementById("search-box").value="",i=""},d.selectCountries=function(e){u.setWhere(e)},d.setSearchFilter=function(t){i=t,e.filterFeatures()},d.updateClusterLayer=function(t){l.clearLayers(),d.markers=t.features.map(function(e){var t=e.geometry,r=new L.marker([t.coordinates[1],t.coordinates[0]]);return e.properties.org_year_founded=e.properties.org_year_founded?parseInt(e.properties.org_year_founded):"",r.attributes=e.properties,r.on("click",function(e){v(r)}),r});var r=[],a=_.filter(d.markers,function(e){return _.contains(r,e.attributes.profile_id)?!1:(r.push(e.attributes.profile_id),!0)});i&&(a=_.filter(a,function(e){return e.attributes.org_name.toLowerCase().indexOf(i.toLowerCase())>-1||e.attributes.org_description.toLowerCase().indexOf(i.toLowerCase())>-1?!0:!1}),d.markers=_.filter(d.markers,function(e){return e.attributes.org_name.toLowerCase().indexOf(i.toLowerCase())>-1||e.attributes.org_description.toLowerCase().indexOf(i.toLowerCase())>-1?!0:!1})),d.statistics=f(a);var o=_.pluck(d.markers,"attributes"),s=_.keys(_.groupBy(o,"org_hq_country_locode")).length;e.updateStatistics({stats:d.statistics,totalCases:a.length,totalCountries:s}),l.addLayers(a),d.updateTableData(d.markers)},d.getDataCellString=function(e){var t="";return e.data_type&&(t+=e.data_type+", "),e.data_src_country_locode&&(t+=e.data_src_country_name+", "),e.data_src_gov_level&&(t+=e.data_src_gov_level),t.trim().length>0&&(t+=";\n"),t},d.updateTableData=function(e){var t=[],i={};_.forEach(e,function(e){_.contains(t,e.attributes.profile_id)?i[e.attributes.profile_id].attributes.dataCell+=d.getDataCellString(e.attributes):(t.push(e.attributes.profile_id),e.attributes.dataCell=d.getDataCellString(e.attributes),i[e.attributes.profile_id]=e)});var o=[];_.forEach(i,function(e){o.push(e)}),r=a.TableResults(o,"tableDiv")},d.exportTableData=function(){r.exportTableData()},d.exportTableDataJSON=function(){r.exportTableDataJSON()},d},o});