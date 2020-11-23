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
                    
                    <title>Change Password | " . $subscriber->BusinessName . "</title>
                    
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
                        <div class='l-margin-t-3'>
                            <div class='s-pad-1'>
                                <h5 class='sleak-m' style='color: dimgray;'>
                                    <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                    <i class='unlock icon'></i></div> Change Password
                                </h5><hr>
                                <div class='ui breadcrumb s-pad-1'>
                                  <a href='" . Router::ResolvePath("home", $path) . "' class='section'>Home</a>
                                  <i class='right chevron icon divider'></i>
                                  <a href='" . Router::ResolvePath("account", $path) . "' class='section'>My Account</a>
                                  <i class='right chevron icon divider'></i>
                                  <div class='section' style='color: black;'>Change Password</div>
                                </div>
                            </div>
    
    
                            <div class='margin-t-9 margin-b-9'>
                                  <div class='ui very basic segment'>
                                    <div class='ui two column very relaxed stackable grid'>
                                      <div class='column'>
                                        <div class='l-width-8'>
                                          <img src='" . $host . "/cdn/images/icons/pastel/shield.png' style='width: 70px;'/>
                                          <h4 style='font-family: " . $site->TextFont . "; color: dimgray;'>Change password</h4>
                                          <p style='color: darkgray;'>
                                            Secure your account with a password that is easy to remember to you
                                            but hard for anybody else to guess.
                                          </p>
                                          <p style='color: darkgray; font-family:" . $site->SecondaryFont . ";'>
                                            Use a combination of numbers, alphabets
                                            and symbols to make a strong password.
                                          </p>
                                        </div>
                                      </div>
                                      <div class='middle aligned column'>
                                        <div class='l-pad-3'>
                                          <div class='l-width-8'>
                                            <div class='ui left icon fluid input'>
                                              <i class='unlock icon'></i>
                                              <input id='old-password' class='wix-textbox' type='password' placeholder='Old Password'/>
                                            </div>
                                            <div class='ui left icon fluid input' style='margin-top: 5px;'>
                                              <i class='lock icon'></i>
                                              <input id='new-password' class='wix-textbox' type='password' placeholder='New Password'/>
                                            </div>
                                            <div class='ui left icon fluid input' style='margin-top: 5px;'>
                                              <i class='lock icon'></i>
                                              <input id='confirm-password' class='wix-textbox' type='password' placeholder='Re-type New Password'/>
                                            </div>
                                            <button id='save-btn' class='ui button' style='background-color: " . $site->PrimaryColor . "; color: white; font-family: " . $site->TextFont . "; margin-top: 5px;' onclick='savePassword()'>Save password</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class='ui vertical divider s-hide'>
                                      <i class='shield icon' style='color: " . $site->PrimaryColor . " ;'></i>
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
