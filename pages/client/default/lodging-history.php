<?php

    if(!$modules->Customers)
    {
        require_once ("addons/404.php");
    }
    else
    {
        if ($customer->Id == "")
        {
            require_once("addons/login.php");
        }
        else
        {
            $ret->Content = "<!DOCTYPE html>
                <html>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                        
                        <meta name='robots' content='noindex, nofollow'/>
                        
                        <title>Lodging history | " . $subscriber->BusinessName . "</title>
                        
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/mat.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/semantic.min.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/w3.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/space_app.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/themes/default/css/page.css'/>";

                        require_once ("addons/link.php");

                        $ret->Content .="
                        <script type='application/javascript' src='" . $host . "/cdn/js/jquery.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/easing.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/semantic.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/functions.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/WixnitEncoder.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/materialize.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/themes/default/js/page.js'></script>
                    </head>
                    <body>";
                    require("addons/header.php");

                    $ret->Content .= "
                        <div class='l-width-8' style='margin: auto;'>
                            <div class='l-margin-t-3 m-pad-1 s-pad-1'>
                                <h5 style='color: dimgray; font-family: " . $site->BoldFont . " ;'>
                                    <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                    <i class='history icon'></i></div> Lodging history
                                </h5><hr>
                                <div class='ui breadcrumb'>
                                  <a href='" . Router::ResolvePath("home", $path) . "' class='section'
                                  style='font-family: ".$site->SecondaryFont.";'>Home</a>
                                  <i class='right chevron icon divider'></i>
                                  <a href='" . Router::ResolvePath("account", $path) . "' class='section'
                                  style='font-family: ".$site->SecondaryFont.";'>My Account</a>
                                  <i class='right chevron icon divider'></i>
                                  <div class='section' style='color: black; font-family: ".$site->SecondaryFont.";'>Lodging history</div>
                                </div>
        
        
                                <div class='margin-t-9 margin-b-9'>
                                    <div class='w3-row'>
                                        <div class='w3-col l2 m3 s12 s-hide'>
                                            <div class='ui vertical fluid tabular menu'>
                                                <a href='".Router::ResolvePath('reservation', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    My reservations
                                                </a>
                                                <a class='active item' style='font-family: ".$site->SecondaryFont.";'>
                                                    Lodging history
                                                </a>
                                                <a href='".Router::ResolvePath('order-history', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    Order history
                                                </a>
                                                <a href='".Router::ResolvePath('profile', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    My profile
                                                </a>
                                                <a href='".Router::ResolvePath('password', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    Change password
                                                </a>
                                            </div>
                                        </div>
                                        <div class='w3-col l10 m9 s12'>
                                            <div class='l-width-9' style='margin: auto;'>
                                                <div class='l-pad-2 align-c'>
                                                    <h3 class='ui icon header' style='font-family: ".$site->TextFont."; color: silver; font-weight: normal;'>
                                                        <i class='history icon'></i>
                                                        No Lodging history yet
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                
                            </div>
                        </div>";


                    require("addons/footer.php");
                    $ret->Content .=
                        "</body>
              </html>";
        }
    }
