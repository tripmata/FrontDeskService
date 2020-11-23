<?php

$integrations = new Integration($subscriber);

$ret->Content = "<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            
            <title>Site Map | ".$subscriber->BusinessName."</title>
            
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/materialize.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/semantic.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/w3.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/space_app.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/themes/default/css/page.css'/>";

            require_once ("addons/link.php");

            $ret->Content .="
            <script type='application/javascript' src='".$host."/cdn/js/jquery.min.js'></script>
            <script type='application/javascript' src='".$host."/cdn/js/easing.min.js'></script>
            <script type='application/javascript' src='".$host."/cdn/js/semantic.min.js'></script>
            <script type='application/javascript' src='".$host."/cdn/js/functions.js'></script>
            <script type='application/javascript' src='".$host."/cdn/js/WixnitEncoder.js'></script>
            <script type='application/javascript' src='".$host."/cdn/js/materialize.js'></script>
            <script type='application/javascript' src='".$host."/cdn/themes/default/js/page.js'></script>
        </head>
        <body>";
require("addons/header.php");

$ret->Content .="
            <div class='l-width-8' style='margin: auto;'>
                <div class='l-margin-t-3'>
                    <h5 class='sleak-m' style='color: dimgray;'>
                        <div class='icon-block' style='color: white; background-color: ".$site->PrimaryColor.";'>
                        <i class='sitemap icon'></i></div> Site Map
                    </h5><hr>
                    <div class='ui breadcrumb'>
                      <a class='section'>Home</a>
                      <i class='right chevron icon divider'></i>
                      <div class='section' style='color: black;'>Site Map</div>
                    </div>
                    <div class='w3-row'>
                        <div class='w3-col l6 m6 s12 l-pad-4'>
                        
                        </div>
                    </div>
                </div>
            </div>";





require("addons/footer.php");
$ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.="
        </body>
    </html>";