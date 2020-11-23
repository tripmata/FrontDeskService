<?php

    if(!$modules->Terms)
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
                    <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Homedescription, Seo::TandC)."'/>
                    <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Homekeywords, Seo::TandC)."'/>
                    
                    <!-- End Seo -->
                    
                    <title>".Seo::BuildTitle($subscriber,"Terms & Conditions | " . $subscriber->BusinessName, Seo::TandC)."</title>
                    
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
                        <div class='l-margin-t-3 s-pad-1'>
                            <h5 style='color: dimgray; font-family: ".$site->BoldFont.";'>
                                <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                <i class='handshake icon'></i></div> Terms & Conditions
                            </h5><hr>
                            <div class='ui breadcrumb'>
                              <a class='section' style='font-family: ".$site->SecondaryFont.";'>Home</a>
                              <i class='right chevron icon divider'></i>
                              <div class='section' style='color: black; font-family: 
                              ".$site->SecondaryFont.";'>Terms & Conditions</div>
                            </div>
                            <div class='w3-row'>
                                <div class='w3-col l6 m6 s12 l-pad-4'>
                                
                                </div>
                            </div>
                        </div>
                    </div>";


                    if($site->Tandc == "")
                    {
                        $ret->Content .= "<div class='l-width-8' style='margin: auto;'>
                                <div class='pad-6'>
                                    <div class='align-c'>
                                        <img src='".$host."/cdn/images/icons/pastel/documents.png'/>
                                        <h2 style='font-family: ".$site->TextFont."; color: lightgray;'>
                                            Terms  and conditions
                                        </h2>
                                    </div>
                                </div>
                            </div>";
                    }
                    else
                    {
                        try {
                            $html = str_get_html($site->Tandc);

                            foreach ($html->find("p") as $i) {
                                $i->style = "font-family: " . $site->SecondaryFont . "; font-size: 16px; line-height: 160%; color: dimgray;";
                            }
                            foreach ($html->find("h1") as $i) {
                                $i->style = "font-family: " . $site->TextFont . "; line-height: 160%; color: " . $site->PrimaryColor . ";";
                            }
                            foreach ($html->find("h2") as $i) {
                                $i->style = "font-family: " . $site->TextFont . "; line-height: 160%; color: " . $site->PrimaryColor . ";";
                            }
                            foreach ($html->find("h3") as $i) {
                                $i->style = "font-family: " . $site->TextFont . "; line-height: 160%; color: " . $site->PrimaryColor . ";";
                            }
                            foreach ($html->find("h4") as $i) {
                                $i->style = "font-family: " . $site->TextFont . "; line-height: 160%; color: " . $site->PrimaryColor . ";";
                            }
                            foreach ($html->find("h5") as $i) {
                                $i->style = "font-family: " . $site->TextFont . "; line-height: 160%; color: " . $site->PrimaryColor . ";";
                            }
                            foreach ($html->find("h6") as $i) {
                                $i->style = "font-family: " . $site->TextFont . "; line-height: 160%; font-weight: bold; color: " . $site->PrimaryColor . ";";
                            }
                            $c = $html->save();
                            $ret->Content .= "<div class='l-width-8' style='margin: auto;'>" . $c . "</div>";
                        }
                        catch (Exception $exception)
                        {
                            $ret->Content .= "<div class='l-width-8' style='margin: auto;'>
                                <div class='pad-6'>
                                    <div class='align-c'>
                                        <img src='".$host."/cdn/images/icons/pastel/ban.png'/>
                                        <h4 style='font-family: ".$site->TextFont."; color: lightgray;'>
                                            There seem to be an error on this page
                                        </h2>
                                    </div>
                                </div>
                            </div>";
                        }
                    }


                require("addons/footer.php");
                $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.=
                "</body>
            </html>";
    }