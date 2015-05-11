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
                    <span class="navbar-brand" data-i18n="title">Open Data Enterprise 2015 Survey</span>
                </div>
                <nav id="menu" class="navbar-collapse collapse" role="navigation">

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Start page</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="container-fluid" style="border:0px solid orange;">
            <div class="row">
                <div class="col-md-1 visible-md visible-lg" style="border:1px solid green;">
                    <div class="affix">
                        <!--
                        view recent
                        <br />
                        <a href="/survey/opendata/" target="_blank">new survey</a>
                        <br />
                        -->
                        <!--a href="">all</a-->
                        blah, blah, blah
                    </div>
                </div>
                <div class="col-md-10" style="border:0px solid blue;">
                    <div style="text-align:center;">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24f1f6631ca2737e86a02_Logo-Mark.png" width="60" alt="54c24f1f6631ca2737e86a02_Logo-Mark.png">
                        <img class="logo" src="http://uploads.webflow.com/54c24a0650f1708e4c8232a0/54c24fc57bbf1d8c4cfd6581_Logo-Text.png" width="400" alt="54c24fc57bbf1d8c4cfd6581_Logo-Text.png"></a>
                    </div>

                    <div style="margin:10% 30% 0 30%;height:600px;text-align:center;border:0px solid red;">
           
  <!--  Login form -->
  <form id="login_form" class="form-horizontal" style="border:0px dotted black;" action="/admin/login/" method="post">

    <div class="col-md-12" role="contact-titlebar"  id="role-contact-titlebar">
      <div class="section-title"><h3>Login</h3></div>
    </div>
    <div class="col-md-12" role="contact" id="role-contact">

        <div class="col-md-12">
          <div for="survey_contact_title">Username</div>
          <input type="text" class="form-control" id="survey_contact_title" name="survey_contact_title">

          <div for="survey_contact_email">Password</div>
          <input type="email" class="form-control" id="survey_contact_email" name="survey_contact_email" required>

        </div>

    </div><!-- /closes role contact -->

     <div class="" style="border:1px solid gray;">    
      <button class="btn btn-primary" style="margin:30px 0 10px 0; background-color: rgb(53, 162, 227);" id="btnSubmit" type="submit" name="submit" value="submit">SUBMIT</button>
    </div>

  </form>



                        
                    </div>

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