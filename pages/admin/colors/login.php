<?php

    $site = new Site($subscriber);

    $logo = "";

    if($site->Logo == "")
    {
        $logo = Router::ResolvePath("files/logo.png", $path);
    }
    else
    {
        $logo = Router::ResolvePath("files/".$site->Logo, $path);
    }

    $ret->Content =
    "<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            
            <title>".$subscriber->BusinessName." : . login</title>
            
            <link rel='stylesheet' type='text/css' href='".$host."cdn/css/semantic.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."cdn/css/space_app.css'/>
            
            <link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/lato/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/quicksand/stylesheet.css'/>
            
            <script type='application/javascript' src='".$host."cdn/js/login.js'></script>
            <script type='application/javascript' src='".$host."cdn/js/functions.js'></script>
            <script type='application/javascript' src='".$host."cdn/js/jquery.min.js'></script>
            <script type='application/javascript' src='".$host."cdn/js/semantic.min.js'></script>
        </head>
        <body style='background-image: url(".$host."cdn/images/back.png)'>
            <div class='l-width-3' style='margin: auto; margin-top: 150px;'>
                <div class='l-margin-t-9 l-pad-2'>
                    <div class='l-width-8' style='margin: auto;'>
                        <form action='' onsubmit='return login()'>
                            <div class='align-c pad-2'>
                                <img src='".$logo."' style='max-width: 100px;'>
                            </div>
                            <div id='user-con' class='ui fluid input'>
                                <input id='user' type='text' placeholder='Username / email' onkeypress='unError(this)' onchange='unError(this)'/>
                            </div>
                            <div id='password-con' class='ui fluid input' style='margin-top: 10px;'>
                                <input id='password' type='password' placeholder='Password' onkeypress='unError(this)' onchange='unError(this)'/>
                            </div>
                            <h5 style='float: right; font-weight: normal; cursor: pointer;'>
                            <a href='".$router->Page."/".Router::ResolvePath("password-reset", $path)."'>Reset password</a></h5>
                            <button id='lg-btn' class='ui blue compact button'  style='margin-top: 10px; font-family: quicksandregular;'>Login</button>
                        </form>
                    </div>
                </div>
            </div>
            <h5 class='align-c' style='position: fixed; bottom: 5px; font-family: quicksandregular; width: 100%;'>Powered By <a href='http://gigahotels.com'>Giga Hotels</a></h5>
        </body>
    </html>";