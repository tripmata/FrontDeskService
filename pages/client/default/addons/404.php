<?php
$ret->Content = "<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    
                    <title>404 | " . $subscriber->BusinessName . "</title>
                    
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/semantic.min.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/w3.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/space_app.css'/>";

                    require_once ("link.php");

                    $ret->Content .="
                </head>
                <body>
                    <div style='margin-top: 200px; text-align: center;'>
                        <h1 style='text-align: center; font-family: ".$site->TextFont."; font-size: 5em;'>404</h1>
                        <h3 style='color: darkgray; font-family: ".$site->TextFont.";'>Page Not Found</h3>
                        <a href='".Router::ResolvePath("home", $path)."'>
                            <button class='ui circular button' 
                            style='background-color: ".$site->PrimaryColor."; color: white; font-weight: normal; 
                            font-family: ".$site->TextFont."; margin-top: 50px;'>
                                <i class='home icon'></i> Take Me Home
                            </button>
                        </a>
                    </div>
                </body>
            </html>";