<?php

    if(!$modules->Contactus)
    {
        require_once ("addons/404.php");
    }
    else
    {

        $router = new Router($path);

        $integrations = new Integration($subscriber);
        $seo = new Seo($subscriber);

        $room =  null;

        if(count($router->Args) == 0)
        {
            require_once ("lodging.php");
            goto end;
        }
        else
        {
            $room = Roomcategory::ByMeta($subscriber, $router->Args[0]);

            if(($room->Id === "") || (!$room->Status) || (!$room->Onsite))
            {
                require_once ("addons/404.php");
                goto end;
            }
        }

        $ret->Content = "<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    
                    <!-- Seo -->
            
                    <meta name='robots' content='index, follow'/>
                    <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Lodgingdescription, Seo::Room, $room)."'/>
                    <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Lodgingkeywords, Seo::Room, $room)."'/>
                    
                    <!-- End Seo -->
                    
                    <title>".Seo::BuildTitle($subscriber,"Room | " . $subscriber->BusinessName, Seo::Room, $room)."</title>
                    
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
                    <div class='pad-2' style=' background-image: url(".$host."/cdn/themes/default/images/lodging_back.jpg".");
                    background-position: center; background-repeat: no-repeat; background-size: 100%;'>
                         <div class='l-width-8' style='margin: auto;'>
                            <div class='l-margin-t-3'>
                                <div class='w3-row'>
                                    <div class='w3-col l1 m1 s2'>
                                        <img src='".$host."/cdn/images/icons/pastel/mat.png' style='width: 65px; max-width: 100%;'/>
                                    </div>
                                    <div class='w3-col l11 m11 s10'>
                                        <h3 style='color: white; dimgray; font-family: ".$site->BoldFont."; margin-top: 20px;'>
                                            Lodging / ".$room->Name."
                                        </h3>
                                    </div>
                                </div>
                                <br/>
                                <div class='ui white-text breadcrumb'>
                                  <a href='".Router::ResolvePath("home", $path)."' class='section white-text' style='font-family: ".$site->SecondaryFont."'>Home</a>
                                  <i class='right chevron white-text icon divider'></i>
                                  <a href='".Router::ResolvePath("lodging", $path)."' class='section white-text' style='font-family: ".$site->SecondaryFont."'>Rooms & Lodging</a>
                                  <i class='right chevron white-text icon divider'></i>
                                  <div class='section' style='font-family: ".$site->SecondaryFont."'>".$room->Name."</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='w3-row'>
                        <div class='w3-col l7 m6 s12'>
                            <div class='' style='margin-top: 30px;'>
                                <div class='w3-row l-width-8' style='margin: auto;'>
                                    <div class='image-frame'>
                                        <img id='main-frame-image' src='".Router::ResolvePath("files/".$room->Images[0], $path)."' 
                                        style='width: 100%; border: 10px solid rgba(150,150,150,0.1); border-radius: 8px;'/>
                                    </div>
                                    <div>
                                        <div class='w3-row'>";

                                            if(count($room->Images) > 0)
                                            {
                                                $ret->Content .="
                                                <div class='w3-col l3 m3 s3'>
                                                    <div class='pad-1'>
                                                        <img class='room-gallery' src='".Router::ResolvePath("files/".$room->Images[0], $path)."' style='width: 100%; cursor: pointer;' onclick='setImageFrame(this)'/>
                                                    </div>
                                                </div>";
                                            }
                                            if(count($room->Images) > 1)
                                            {
                                                $ret->Content .="
                                                <div class='w3-col l3 m3 s3'>
                                                    <div class='pad-1' style='width: 100%;'>
                                                        <img class='room-gallery' src='".Router::ResolvePath("files/".$room->Images[1], $path)."' style='width: 100%; cursor: pointer;' onclick='setImageFrame(this)'/>
                                                    </div>
                                                </div>";
                                            }
                                            if(count($room->Images) > 2)
                                            {
                                                $ret->Content .="
                                                <div class='w3-col l3 m3 s3'>
                                                    <div class='pad-1' style='width: 100%;'>
                                                        <img class='room-gallery' src='".Router::ResolvePath("files/".$room->Images[2], $path)."' onclick='setImageFrame(this)'/>
                                                    </div>
                                                </div>";
                                            }
                                            if(count($room->Images) > 3)
                                            {
                                                $ret->Content .="
                                                <div class='w3-col l3 m6 s3'>
                                                    <div class='pad-1' style='width: 100%;'>
                                                        <img class='room-gallery' src='".Router::ResolvePath("files/".$room->Images[3], $path)."' onclick='setImageFrame(this)'/>
                                                    </div>
                                                </div>";
                                            }

                                        $ret->Content .="
                                        </div>
                                    </div>
                                    <hr/>
                                    <div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='w3-col l5 m6 s12'>
                            <div>
                                <div style='margin-top: 30px;'>
                                    <div class='l-width-8 s-pad-1 s-align-c' style='margin: auto;'>
                                        <h3 style='font-family: ".$site->TextFont."'>
                                            <span style='color: silver;'>Room Type: </span>
                                            <span style='color: ".$site->PrimaryColor."';>".
                                            $room->Name
                                            ."</span>
                                        </h3>
                                        <p style='color: dimgray; font-family: ".$site->SecondaryFont."'>".$room->Description."</p>
                                        <hr/>
                                        <h6 style='font-family: ".$site->TextFont."'>
                                            <span style='color: darkgray;'>Price: </span>
                                            <span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span> ".
                                            number_format($room->Price, 2)."<small> / Night</small>";

                                            if($room->Compareat > 0)
                                            {
                                                $ret->Content .= "&nbsp;&nbsp;&nbsp;<s><span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span>".
                                                number_format($room->Compareat, 2)."<small> / Night</small></s>";
                                            }

                                        $ret->Content .="
                                        </h6>
                                        <h6 style='font-family: ".$site->TextFont."'>
                                            <span style='color: silver;'>Occupancy: </span>".
                                            $room->Baseoccupancy."
                                        </h6>
                                        <h6 style='font-family: ".$site->TextFont."'>
                                            <span style='color: silver;'>Max Occupancy: </span>".
                                            $room->Maxoccupancy."
                                        </h6>
                                        <h6 style='font-family: ".$site->TextFont."'>
                                            <span style='color: silver;'>Chilldren policy: </span>".
                                            ($room->Childrenpolicy ? "Allowed" : "Not-Allowed")."
                                        </h6>
                                        <h6 style='font-family: ".$site->TextFont."'>
                                            <span style='color: silver;'>Pets: </span>".
                                            ($room->Pets ? "Allowed" : "Not-Allowed")."
                                        </h6>
                                        <h6 style='font-family: ".$site->TextFont."'>
                                            <span style='color: silver;'>Smoking: </span>".
                                            ($room->Smokingpolicy ? "Allowed" : "Not-Allowed")."
                                        </h6>";

                                            if(count($room->Features) > 0)
                                            {

                                                $ret->Content .="
                                                <hr>
                                                <h4 style='font-family: ".$site->SecondaryFont."; color: ".$site->PrimaryColor.";'>
                                                    <i class='angle double right icon'></i> Features
                                                </h4>
                                                <ul>";

                                                for($k = 0; $k < count($room->Features); $k++)
                                                {
                                                    $ret->Content .= "<li>".$room->Features[$k]."</li>";
                                                }
                                                $ret->Content .= "</ul>";
                                            }
                                        
                                        $ret->Content .="
                                        <hr/>
                                        <div class=''>
                                            <button class='ui circular button' style='font-family: ".$site->TextFont."; 
                                            background-color: ".$site->PrimaryColor."; color: white;' onclick=\"bookRoom('".$room->Id."')\">
                                                Book Room
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";

                require_once ("addons/footer.php");

                $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag."
                </body>
            </html>";


        end: ;
    }