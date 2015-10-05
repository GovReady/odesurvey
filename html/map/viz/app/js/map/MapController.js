define(["map/map_config","map/LayerControl","main/fetcher","widgets/StatisticsPane","widgets/LeftPanel"],function(t,o,e,n,i){"use strict";var r,a,s,l,u,m={},c=function(t){t.filters=[];var o=m.getFiltersLabels();_.forEach(o,function(o){_.forEach(o,function(o){t.filters.push({label:o})})}),document.getElementById("filterStats")?new n(t,"filterStats"):setTimeout(function(){n(t,"filterStats")},1e3)},f=function(){var t=function(){console.log("filter clusters"),m.filterFeatures(m.getFilters())};r.filterFeatures=function(){console.log("filter clusters"),m.filterFeatures(m.getFilters())},r.on("zoomend",t),r.on("dragend",t),r.on("zoomstart",m.closePopups)};return m.closePopups=function(){r.closePopup()},m.setMetaProps=function(t){u=t},m.queryForCountryCode=function(o){var e=new L.esri.Tasks.Query({url:t.tempCountryURL});e.contains(o.latlng).returnGeometry(!0).run(function(t,o,e){if(o.features[0]){var n=o.features[0].properties.ISO2;_.forEach(u.accordian.items,function(t){"Country"===t.label&&_.forEach(t.items,function(t){t.value==n?t.selected=!0:t.selected=!1})});new i(u,"leftPanel")}})},m.getFiltersLabels=function(){return s.labels},m.getFilters=function(){var t=_.keys(s).map(function(t){if(s[t].length){var o=["(",s[t].join(","),")"].join("");return{fieldName:t,value:o,operator:"in"}}});return t.filter(function(t){return t})},m.clearFilter=function(){_.keys(s).forEach(function(t){"labels"==t?_.keys(s[t]).forEach(function(o){s[t][o]=[]}):s[t]=[]}),m.filterFeatures(!1),r.layerControl.clearSearch(),l._zoomHome()},m.updateFilter=function(t,o,e,n){return s[o]=t.map(function(t){return"'{}'".replace("{}",t)}),s.labels[o]=n,e&&this.filterFeatures(this.getFilters()),s},m.filterFeatures=function(o){var n;n=o?e.getQueryString(o):"1=1";var i=r.getBounds();L.esri.Tasks.query({url:t.features}).where(n).within(i).run(function(t,o,e){r.layerControl.updateClusterLayer(o)})},m.selectCountries=function(t,o){var e=o+" in "+["('",t.join("','"),"')"].join("");t.length||(e="1=1"),r.layerControl.selectCountries(e)},m.mapResize=function(){r.invalidateSize()},m.changeBaseMap=function(t){r.remove(a),a=L.esri.basemapLayer(t.target.id).addTo(r)},m.getMap=function(){return r},m.init=function(e){var n=20.89009754221236,i=30.03990936279297,u=2;r=new L.Map(e,{zoomControl:!1,maxZoom:10,minZoom:2}).setView([n,i],u),a=L.esri.basemapLayer("Topographic").addTo(r),L.control.scale().addTo(r),r.layerControl=o.create(r),s={},s.labels={},_.pluck(t.filters,"source").forEach(function(t){t&&(s[t.field]=[],s.labels[t.field]=[])}),r.updateStatistics=c,f(),L.Control.zoomHome=L.Control.extend({options:{position:"topright",zoomInText:"+",zoomInTitle:"Zoom in",zoomOutText:"-",zoomOutTitle:"Zoom out",zoomHomeText:'<i class="fa fa-home" style="line-height:1.65;"></i>',zoomHomeTitle:"Zoom home"},onAdd:function(t){var o="gin-control-zoom",e=L.DomUtil.create("div",o+" leaflet-bar"),n=this.options;return this._zoomInButton=this._createButton(n.zoomInText,n.zoomInTitle,o+"-in",e,this._zoomIn),this._zoomHomeButton=this._createButton(n.zoomHomeText,n.zoomHomeTitle,o+"-home",e,this._zoomHome),this._zoomOutButton=this._createButton(n.zoomOutText,n.zoomOutTitle,o+"-out",e,this._zoomOut),this._updateDisabled(),r.on("zoomend zoomlevelschange",this._updateDisabled,this),e},onRemove:function(t){r.off("zoomend zoomlevelschange",this._updateDisabled,this)},_zoomIn:function(t){this._map.zoomIn(t.shiftKey?3:1)},_zoomOut:function(t){this._map.zoomOut(t.shiftKey?3:1)},_zoomHome:function(t){r.setView([n,i],u)},_createButton:function(t,o,e,n,i){var r=L.DomUtil.create("a",e,n);return r.innerHTML=t,r.href="#",r.title=o,L.DomEvent.on(r,"mousedown dblclick",L.DomEvent.stopPropagation).on(r,"click",L.DomEvent.stop).on(r,"click",i,this).on(r,"click",this._refocusOnMap,this),r},_updateDisabled:function(){var t=this._map,o="leaflet-disabled";L.DomUtil.removeClass(this._zoomInButton,o),L.DomUtil.removeClass(this._zoomOutButton,o),t._zoom===t.getMinZoom()&&L.DomUtil.addClass(this._zoomOutButton,o),t._zoom===t.getMaxZoom()&&L.DomUtil.addClass(this._zoomInButton,o)}}),l=new L.Control.zoomHome,l.addTo(r)},m});