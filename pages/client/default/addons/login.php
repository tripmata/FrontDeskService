<?php

    $ret->Content = "<!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            
            <title>Login | ".$subscriber->BusinessName."</title>
            
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/mat.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/semantic.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/w3.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/space_app.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/themes/default/css/page.css'/>
            <link rel='stylesheet' type='text/css' href='".$host."/cdn/css/datepicker.min.css'/>";

            require_once ("link.php");

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
        require("header.php");

            $ret->Content .="
            <div class='l-width-8' style='margin: auto;'>
                <div class='l-margin-t-3'>
                    


                <div class='margin-t-9 margin-b-9'>
                              <div class='ui very basic segment'>
                                <div class='ui two column very relaxed stackable grid'>
                                  <div class='column'>
                                    <div class='l-width-8 s-hide'>
                                      <img src='".$logo."' style='width: 70px;'/>
                                      <h3 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                        ".$subscriber->BusinessName."
                                      </h3>
                                      <ul class='ui list'>
                                        <li style='font-family:".$site->SecondaryFont."; line-height: 150%; color: dimgray;'>
                                          Secure your account with a password that is easy to remember to you
                                          but hard for anybody else to guess.
                                        </li>
                                        <li style='font-family:".$site->SecondaryFont."; line-height: 150%; color: dimgray;'>
                                          Use a combination of numbers, alphabets
                                          and symbols to make a strong password.
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                  <div class='middle aligned column'>
                                    <div class='l-pad-3'>
                                      <div class='l-width-8'>
                                        <div>
                                          <div class='w3-row' style='margin-bottom: 10px;'>
                                            <div class='w3-col l2 m3 s4'>
                                            <img src='".$host."cdn/images/icons/pastel/guests.png' style='width: 50px;'/>
                                            </div>
                                            <div class='w3-col l10 m9 s8'>
                                              <h3 style='font-family: ".$site->TextFont."; margin-top: 10px;'>
                                                Login
                                              </h3>
                                            </div>
                                          </div>
                                        </div>
                                        <form action='' method='' onsubmit='return logIN()'>
                                          <div class='ui left icon fluid input'>
                                            <i class='user circle icon'></i>
                                            <input id='login-email' class='wix-textbox' type='text' placeholder='Email or Phone number'/>
                                          </div>
                                          <div class='ui left icon fluid input' style='margin-top: 5px;'>
                                            <i class='lock icon'></i>
                                            <input id='login-password' class='wix-textbox' type='password' placeholder='Password'/>
                                          </div>
                                          <button id='login-btn' class='ui button' style='background-color: ".$site->PrimaryColor."; color: white; font-family: ".$site->TextFont."; margin-top: 10px;'><i class='sign in icon'></i>Login
                                          </button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class='ui vertical divider s-hide'>
                                  <i class='shield icon' style='color: ".$site->PrimaryColor." ;'></i>
                                </div>
                              </div>
                            </div>



                </div>
            </div>";

        require ("footer.php");
		$ret->Content .=
		"</body>
	</html>";
