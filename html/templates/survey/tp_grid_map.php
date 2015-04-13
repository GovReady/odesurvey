<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Open Data Survey 2015 - List</title>
        <link href="/css3/bootstrap.css" rel="stylesheet" />
        <link href="/dist/jquery.bootgrid.css" rel="stylesheet" />
        <script src="/js3/modernizr-2.8.1.js"></script>
        <style>
            @-webkit-viewport { width: device-width; }
            @-moz-viewport { width: device-width; }
            @-ms-viewport { width: device-width; }
            @-o-viewport { width: device-width; }
            @viewport { width: device-width; }

            body { padding-top: 70px; }
            
            .column .text { color: #f00 !important; }
            .cell { font-weight: bold; }
        </style>
    </head>
    <body>
        <header id="header" class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar">t1</span>
                        <span class="icon-bar">t2</span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand" data-i18n="title">Open Data Enpterprise 2015 Survey</span>
                </div>
                <nav id="menu" class="navbar-collapse collapse" role="navigation">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Recently submitted surveys</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="container-fluid" style="border:0px solid orange;">
            <div class="row">
                <div class="col-md-1 visible-md visible-lg" style="border:0px solid green;">
                    <div class="affix">
                        <a href="/survey/opendata/list/new/">view recent</a>
                        <br />
                        <a href="/survey/opendata/" target="_blank">new survey</a>
                        <br />
                        map
                        <!--a href="">all</a-->
                    </div>
                </div>
                <div class="col-md-10" style="border:0px solid blue;">
                    <div style="text-align:center;margin-bottom:60px;">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24f1f6631ca2737e86a02_Logo-Mark.png" width="60" alt="54c24f1f6631ca2737e86a02_Logo-Mark.png">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24fc57bbf1d8c4cfd6581_Logo-Text.png" width="400" alt="54c24fc57bbf1d8c4cfd6581_Logo-Text.png"></a>
                    </div>


<div>
(map goes here)
</div>

                    <button id="removeSelected" type="button" class="btn btn-default">Remove Selected</button>
                    <button id="clear" type="button" class="btn btn-default">Clear</button>
                    <button id="init" type="button" class="btn btn-default">Init</button>
                    <!--div class="table-responsive"-->
                        <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-identifier="true">ID</th>
                                    <th data-column-id="organization" data-order="asc" data-align="left" data-header-align="left">Organization</th>
                                    <th data-column-id="type" data-order="asc" data-align="left" data-header-align="left">Type</th>
                                    
                                    <th data-column-id="founded" data-css-class="cell" data-filterable="true">Year founded</th>
                                    <th data-column-id="survey" data-formatter="link" data-sortable="false">Survey</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php
    foreach ($org_profiles as $org_profile) {
        // echo "<pre>"; print_r($org_profile); echo "..".$org_profile['org_name']."</pre>";
        if ( array_key_exists('org_name', $org_profile) && $org_profile['org_profile_status'] == 'submitted') { 
            echo "<tr>";
            echo "<td>".$org_profile['objectId']."</td>";
            echo "<td>".$org_profile['org_name']."</td>";
            echo "<td>".$org_profile['org_type']."</td>";
            echo "<td>${org_profile['org_year_founded']}</td>";
            echo "<td><a href='/survey/opendata/".$org_profile['objectId']."/submitted'>".$org_profile['objectId']."</a></td>";
            echo "</tr>";
        }
    }
?>
                            </tbody>
                        </table>
                    <!--/div-->
                </div>
            </div>
        </div>

        <footer id="footer" style="margin-top:50px;text-align:center;">
            © Copyright 2015, Center for Open Data Enterprise
        </footer>

        <script src="/lib/jquery-1.11.1.min.js"></script>
        <script src="/js3/bootstrap.js"></script>
        <script src="/dist/jquery.bootgrid.js"></script>
        <script>
            $(function()
            {
                function init()
                {
                    $("#grid").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"/survey/opendata/" + row.id + "/submitted/\">" + row.organization + " survey</a>";
                            }
                        }
                    });
                }
                
                init();
                
                
                $("#clear").on("click", function ()
                {
                    $("#grid").bootgrid("clear");
                });
                
                $("#removeSelected").on("click", function ()
                {
                    $("#grid").bootgrid("remove");
                });
                
                $("#init").on("click", init);
            });
        </script>
    </body>
</html>