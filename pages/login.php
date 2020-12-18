<?php

    $color = "rgb(0,100,140)";
    $font = "comfortaalight";

$ret->Content = "
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />

        <title>Sign in to TripMata Front Desk Dashboard</title>

        <link rel='stylesheet' type='text/css' href='".$cdn."/css/w3.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/css/mat.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/css/semantic.min.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/css/space_app.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/css/draw.css'/>

        <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/lato/stylesheet.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/quicksand/stylesheet.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/comfortaa/stylesheet.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/montserrat/stylesheet.css'/>
        <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/nunito/stylesheet.css'/>
        <link rel='icon' type='image/png' href='".$cdn."/../../logo/favicon.png'/>

        <script type='application/javascript' src='".$cdn."/js/jquery.min.js'></script>
        <script type='application/javascript' src='".$cdn."/js/functions.js'></script>
        <script type='application/javascript' src='".$cdn."/js/semantic.min.js'></script>
        <script type='application/javascript' src='".$cdn."/js/login.js'></script>
    </head>
    <body style=\"background-image: url('".$cdn."/images/back.png')\">
        <div style='margin-top: 100px;'>
            <form action='' method='post' onsubmit='return login()'>
                <div class='l-width-3' style='margin: auto;'>
                    <div class='l-width-7' style='margin: auto;'>   
                        <div class='align-c'>
                            <img src='".$cdn."/images/icons/pastel/frontdesk.png' style='width: 100px;'/>
                        </div>
                        <div class='margin-t-2 margin-b-2 align-c'>
                            <h2 style='font-family: comfortaalight;'><span id='property-name'>Tripmata</span> Front Desk</h2>
                        </div>
                        <div class='ui fluid input' style='margin-top: 20px;'>
                            <input id='user' class='wix-textbox' type='text' placeholder='User name'/>
                        </div>
                        <div class='ui fluid input' style='margin-top: 10px;'>
                            <input id='password' class='wix-textbox' type='password' placeholder='Password'/>
                        </div>
                        <br/><br/>
                        <button id='lg-btn' class='ui blue button' style='font-family: comfortaalight;'>
                            <i class='sign in icon'></i> Sign in
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>";

