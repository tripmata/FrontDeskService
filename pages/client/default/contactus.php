<?php

    if(!$modules->Contactus)
    {
        require_once ("addons/404.php");
    }
    else
    {
        $integrations = new Integration($subscriber);
        $seo = new Seo($subscriber);

        $ret->Content = "<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    
                    <!-- Seo -->
            
                    <meta name='robots' content='index, follow'/>
                    <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Homedescription, Seo::Contactus)."'/>
                    <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Homekeywords, Seo::Contactus)."'/>
                    
                    <!-- End Seo -->
                    
                    <title>".Seo::BuildTitle($subscriber,"Contact Us | " . $subscriber->BusinessName, Seo::Contactus)."</title>
                    
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
                            <div class='l-width-8 s-width-xl' style='margin: auto;'>
                                <div class='l-margin-t-3 s-margin-t-2'>
                                    <h5 class='sleak-m' style='color: dimgray; font-family: ".$site->TextFont.";'>
                                        <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                        <i class='group icon'></i></div> Contact Us
                                    </h5><hr>
                                    <div class='ui breadcrumb' style='font-family: ".$site->SecondaryFont.";'>
                                      <a href='".Router::ResolvePath("home", $path)."' class='section'>Home</a>
                                      <i class='right chevron icon divider'></i>
                                      <div class='section' style='color: black;'>Contact Us</div>
                                    </div>
                                    <div class='margin-t-5'>
                                        <div class='w3-row s-width-xl' style='margin: auto;'>
                                        
                                        <div class='w3-col l7  m7 s12'>
                                            <div>
                                                <h2 style='font-family: ".$site->TextFont.";'>
                                                    <i class='paper plane icon' style='color: ".$site->PrimaryColor.";'></i>
                                                     Send us a message
                                                </h2>
                                                <p style='font-family: ".$site->SecondaryFont.";'>
                                                    We'll get back to you as soon as we can.    
                                                </p>
                                            </div>
                                            <div style='margin-top: 20px;'>
                                                <div class='ui fluid large input'>
                                                    <input id='contact-names' class='wix-textbox' type='text' placeholder='Full name' style='font-family: ".$site->SecondaryFont.";'/>
                                                </div>
                                                <div class='w3-row' style='margin-top: 5px;'>
                                                    <div class='w3-col l5 m12 s12'>
                                                        <div class='ui fluid large input l-width-xl' style='margin-top: 5px;'>
                                                            <input id='contact-phone' class='wix-textbox' type='text' placeholder='Phone' style='font-family: ".$site->SecondaryFont.";'/>
                                                        </div>
                                                    </div>
                                                    <div class='w3-col l7 m12 s12'>
                                                        <div class='ui fluid large input' style='margin-top: 5px;'>
                                                            <input id='contact-email' class='wix-textbox' type='text' placeholder='Email' style='font-family: ".$site->SecondaryFont.";'/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style='margin-top: 10px;'>
                                                    <div class='ui form'>
                                                        <div class='field' style='margin-top: 5px;'>
                                                            <textarea id='contact-message' class='wix-textbox' rows='4' placeholder='Write message here' 
                                                            style='font-family: ".$site->SecondaryFont.";'></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style='margin-top: 10px;'>
                                                    <div id='contact-btn' class='ui labeled button' tabindex='0' onclick='sendMessage()'>
                                                        <div id='contact-btn-icon' class='ui button' style='background-color: ".$site->PrimaryColor."; color: white;'>
                                                            <i class='paper plane icon'></i>
                                                        </div>
                                                        <a id='contact-btn-txt' class='ui basic left pointing label' style='font-family: 
                                                        ".$site->SecondaryFont."; color: ".$site->PrimaryColor.";'>
                                                            Send
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class='w3-col l5 m5 s12'>
                                            <div class='l-width-9 l-float-r s-margin-t-8 s-margin-b-7'>
                                                <h3 style='color: ".$site->PrimaryColor."; font-family: ".$site->TextFont.";'>Other Channels</h3>
                                                <p style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                                    You can also reach us using these other channels
                                                </p>";

                                                if($modules->Contactus)
                                                {
                                                    $integ = new Integration($subscriber);

                                                    $ret->Content .=
                                                        "<div class=''>
                                                            <div class=''>
                                                                <div>";

                                                                if($integ->Facebook != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Facebook."' target='_blank'>
                                                                            <button class='ui facebook icon button'>
                                                                                <i class='facebook f icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }
                                                                if($integ->Twitter != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Twitter."' target='_blank'>
                                                                            <button class='ui twitter icon button'>
                                                                                <i class='twitter icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }
                                                                if($integ->Instagram != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Instagram."' target='_blank'>
                                                                            <button class='ui instagram icon button'>
                                                                                <i class='instagram icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }
                                                                if($integ->Google != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Google."' target='_blank'>
                                                                            <button class='ui google plus icon button'>
                                                                                <i class='google plus icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }
                                                                if($integ->Linkedin != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Linkedin."' target='_blank'>
                                                                            <button class='ui linkedin icon button'>
                                                                                <i class='linkedin icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }
                                                                if($integ->Whatsapp != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Whatsapp."' target='_blank'>
                                                                            <button class='ui whatsapp green icon button'>
                                                                                <i class='whatsapp icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }
                                                                if($integ->Telegram != "")
                                                                {
                                                                    $ret->Content .=
                                                                        "<a href='".$integ->Telegram."' target='_blank'>
                                                                            <button class='ui twitter icon button'>
                                                                                <i class='telegram icon'></i>
                                                                            </button>
                                                                        </a>";
                                                                }

                                                                $ret->Content .="
                                                                </div>
                                                            </div>
                                                        </div>";
                                                }

                                                if(($modules->Contactus) && (($subscriber->Phone1 != "") || ($subscriber->Phone2 != "")))
                                                {
                                                    $ret->Content .= "<br/><hr/>
                                                    <h5 style='font-family: ".$site->BoldFont."; color: ".$site->PrimaryColor.";'>Give us a call</h5>";

                                                    if($subscriber->Phone1 != "")
                                                    {
                                                        $ret->Content .= "<h6 style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                                        <i class='mobile icon' style='color: ".$site->PrimaryColor.";'></i> ".$subscriber->Phone1."</h6>";
                                                    }
                                                    if($subscriber->Phone2 != "")
                                                    {
                                                        $ret->Content .= "<h6 style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                                        <i class='mobile icon' style='color: ".$site->PrimaryColor.";'></i> ".$subscriber->Phone2."</h6>";
                                                    }
                                                }

                                                if(($modules->Contactus) && (($subscriber->Email1 != "") || ($subscriber->Email2 != "")))
                                                {
                                                    $ret->Content .= "<br/><hr/>
                                                    <h5 style='font-family: ".$site->BoldFont."; color: ".$site->PrimaryColor.";'>Send us a mail</h5>
                                                    <p style='color: dimgray; font-family: ".$site->SecondaryFont.";'>
                                                        We are always read and happy to hear from you.
                                                    </p>";

                                                    if($subscriber->Phone1 != "")
                                                    {
                                                        $ret->Content .= "<h6 style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                                        <i class='open envelope icon' style='color: ".$site->PrimaryColor.";'></i> ".$subscriber->Email1."</h6>";
                                                    }
                                                    if($subscriber->Phone2 != "")
                                                    {
                                                        $ret->Content .= "<h6 style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                                        <i class='open envelope icon' style='color: ".$site->PrimaryColor.";'></i> ".$subscriber->Email2."</h6>";
                                                    }
                                                }

                                                $ret->Content .= "
                                            </div>
                                            </div>";




                                    $ret->Content .=

                                        "</div>
                                    </div>
                                </div>
                            </div>";


                require_once("addons/footer.php");

                $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.= "
                </body>
            </html>";
    }