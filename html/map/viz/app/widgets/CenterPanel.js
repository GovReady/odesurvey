define(["react","widgets/SelectableGroup","widgets/SelectableItem"],function(e,t,a){"use strict";var n=React.createClass({displayName:"CenterPanel",getInitialState:function(){return{selectedTab:"map"}},handleChange:function(e){},switchTabs:function(e){this.setState({selectedTab:e.value})},componentWillReceiveProps:function(e){},loadSurvey:function(){var e="http://opendataenterprise.org/map/survey";window.open(e,"_blank")},render:function(){var e=this.props.keys,a=(this.handleClick,this.state,this.setState,e.tabs.items[0].value==this.state.selectedTab?{}:{display:"none"}),n=e.tabs.items[1].value==this.state.selectedTab?{}:{display:"none"};return e.tabs.changed=this.switchTabs,React.createElement("div",{id:"mapArea",className:e.id},React.createElement(t,{keys:e.tabs}),React.createElement("div",{id:e.mapId,style:a},React.createElement("div",{id:"survey-button",className:"survey-button",onClick:this.loadSurvey})),React.createElement("div",{id:e.tableId,style:n}))}});return function(e,t){return React.render(React.createElement(n,{keys:e}),document.getElementById(t))}});