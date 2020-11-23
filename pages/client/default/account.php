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
                    
                    <title>My Account | " . $subscriber->BusinessName . "</title>
                    
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/mat.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/semantic.min.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/w3.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/space_app.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/themes/default/css/page.css'/>
                    <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/datepicker.min.css'/>";

                    require_once ("addons/link.php");

                    $ret->Content .="
                    <script type='application/javascript' src='".$host."/cdn/js/jquery.min.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/easing.min.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/semantic.min.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/functions.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/themes/default/js/page.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/datepicker.min.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/initial.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/global.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/component.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/cash.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/carousel.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/animation.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/anime.min.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/toasts.js'></script>
                    <script type='application/javascript' src='".$host."/cdn/js/materialize/collapsible.js'></script>
                </head>
                <body>";
            require("addons/header.php");

            $ret->Content .= "
                    <div class='l-width-8' style='margin: auto;'>
                        <div class='l-margin-t-3'>
                            <div class='s-pad-1'>
                                <h5 class='sleak-m' style='color: dimgray;'>
                                    <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                    <i class='user circle icon'></i></div> My Account
                                </h5><hr>
                                <div class='ui breadcrumb'>
                                  <a href='" . Router::ResolvePath("home", $path) . "' class='section'>Home</a>
                                  <i class='right chevron icon divider'></i>
                                  <div class='section' style='color: black;'>My Account</div>
                                </div>
                            </div>
                            <div class='w3-row'>
                                <div >
                                    <div class='align-r s-hide'>
                                        <h5 style='font-family: ".$site->TextFont."; color: darkgray; text-align: right;'>
                                            <span><i class='sign out icon'></i>
                                            <a style='color: " . $site->PrimaryColor . "; cursor: pointer;' onclick='logout(this)'>Logout</a></span>
                                        </h5>
                                    </div>
                                </div>
                                <div >
                                    <div class='l-hide pad-2'>
                                        <h6 style='font-family: lato; color: darkgray; text-align: right;'>&nbsp;&nbsp;
                                            <span><i class='sign out icon'></i>
                                            <a style='color: " . $site->PrimaryColor . "; cursor: pointer;' onclick='logout(this)'>Logout</a></span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class='l-margin-t-5 s-margin-t-4'>
                                <div class='w3-row'>
                                    <div class='w3-col l4 m4 s12 pad-t'>
                                        <a href='" . Router::ResolvePath("reservation", $path) . "' style='text-decoration: none;'>
                                            <div class='w3-card-2 hoverable curve' style='width: 100%;'>
                                                <div class='w3-row'>
                                                    <div class='w3-col l4 m4 s12 l-pad-2 s-pad-1'>
                                                        <img src='".$host."/cdn/images/icons/pastel/calendar.png'/>
                                                    </div>
                                                    <div class='w3-col l8 m8 s12 l-pad-2 s-pad-1'>
                                                        <h4 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                                            My reservation
                                                        </h4>
                                                        <p>
                                                            Manage all your reservations easily
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    <div class='w3-col l4 m4 s12 pad-t'>
                                        <a href='" . Router::ResolvePath("lodging-history", $path) . "' style='text-decoration: none;'>
                                            <div class='w3-card-2 hoverable curve' style='width: 100%;'>
                                                <div class='w3-row'>
                                                    <div class='w3-col l4 m4 s12 l-pad-2 s-pad-1'>
                                                        <img src='".$host."/cdn/images/icons/pastel/room.png'/>
                                                    </div>
                                                    <div class='w3-col l8 m8 s12 l-pad-2 s-pad-1'>
                                                        <h4 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                                            Lodging history
                                                        </h4>
                                                        <p>
                                                            Manage all your reservations easily
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    <div class='w3-col l4 m4 s12 pad-t'>
                                        <a href='" . Router::ResolvePath("order-history", $path) . "' style='text-decoration: none;'>
                                            <div class='w3-card-2 hoverable curve' style='width: 100%;'>
                                                <div class='w3-row'>
                                                    <div class='w3-col l4 m4 s12 l-pad-2 s-pad-1'>
                                                        <img src='".$host."/cdn/images/icons/pastel/roomservice.png' style='width: 64px;'/>
                                                    </div>
                                                    <div class='w3-col l8 m8 s12 l-pad-2 s-pad-1'>
                                                        <h4 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                                            Order history
                                                        </h4>
                                                        <p>
                                                            Manage all your order history easily
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    
                                    <div class='w3-col l4 m4 s12 pad-t'>
                                        <a href='" . Router::ResolvePath("profile", $path) . "' style='text-decoration: none;'>
                                            <div class='w3-card-2 hoverable curve' style='width: 100%;'>
                                                <div class='w3-row'>
                                                    <div class='w3-col l4 m4 s12 l-pad-2 s-pad-1'>
                                                        <img src='".$host."/cdn/images/icons/pastel/verified_user.png' style='width: 64px;'/>
                                                    </div>
                                                    <div class='w3-col l8 m8 s12 l-pad-2 s-pad-1'>
                                                        <h4 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                                            My profile
                                                        </h4>
                                                        <p>
                                                            Add edit and update your inrmation
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    
                                    <div class='w3-col l4 m4 s12 pad-t'>
                                        <a href='" . Router::ResolvePath("password", $path) . "' style='text-decoration: none;'>
                                            <div class='w3-card-2 hoverable curve' style='width: 100%;'>
                                                <div class='w3-row'>
                                                    <div class='w3-col l4 m4 s12 l-pad-2 s-pad-1'>
                                                        <img src='".$host."/cdn/images/icons/pastel/unlock_checked.png' style='width: 64px;'/>
                                                    </div>
                                                    <div class='w3-col l8 m8 s12 l-pad-2 s-pad-1'>
                                                        <h4 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                                            Change password
                                                        </h4>
                                                        <p>
                                                            Change your password and be safe
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
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