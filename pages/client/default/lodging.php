<?php

    if(!$modules->Lodging)
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
                    <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Lodgingdescription, Seo::Lodging)."'/>
                    <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Lodgingkeywords, Seo::Lodging)."'/>
                    
                    <!-- End Seo -->
                    
                    <title>".Seo::BuildTitle($subscriber,"Lodging | " . $subscriber->BusinessName, Seo::Lodging)."</title>
                    
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
                    background-position: center; background-repeat: no-repeat; background-size: cover;'>
                         <div class='l-width-8' style='margin: auto;'>
                            <div class='l-margin-t-3'>
                                <div class='w3-row'>
                                    <div class='w3-col l1 m1 s2'>
                                        <img src='".$host."/cdn/images/icons/pastel/mat.png' style='width: 65px; max-width: 100%;'/>
                                    </div>
                                    <div class='w3-col l11 m11 s10'>
                                        <h3 style='color: white; dimgray; font-family: ".$site->BoldFont."; margin-top: 20px;'>
                                            Lodging
                                        </h3>
                                    </div>
                                </div>
                                <br/>
                                <div class='ui white-text breadcrumb'>
                                  <a href='".Router::ResolvePath("home", $path)."' class='section white-text' style='font-family: ".$site->SecondaryFont."'>Home</a>
                                  <i class='right chevron white-text icon divider'></i>
                                  <div class='section' style='font-family: ".$site->SecondaryFont."'>Rooms & Lodging</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='w3-row'>
                        <div class='w3-col l8 m8 s12'>
                            <div class='' style='margin-top: 20px;'>
                                <div class='w3-row l-width-9' style='margin: auto;'>";

                                $roomcats = Roomcategory::Order($subscriber, 'sort', 'ASC');

                                for($i = 0; $i < count($roomcats); $i++)
                                {
                                    if($roomcats[$i]->Status)
                                    {
                                        $ret->Content .= "<div class='w3-col l6 m6 s12'>
                                            <div class='l-width-9' style='margin: auto;'>
                                                <div class='widget' style='margin-top: 30px; border: 10px solid rgba(100,100,100,0.1); border-radius: 10px;'>
                                                    <div style='position: relative;'>
                                                        <img src='".Router::ResolvePath("files/" . $roomcats[$i]->Images[0], $path)."' style='width: 100%;'/>
                                                        <div class='pad-1' style='position: absolute; top: 0px; width: 100%; height: 100%; 
                                                        background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,0), rgb(0,0,0));'>
                                                            <h6 style='color: white; bottom: 0px; left: 10px; font-family: ".$site->SecondaryFont."; position: absolute;'>
                                                                <span style='font-family: arial;'>".
                                                                $subscriber->Currency->Symbol."</span>".number_format($roomcats[$i]->Price, 2)."
                                                                &nbsp;&nbsp;&nbsp;&nbsp;".
                                                                ($roomcats[$i]->Compareat > 0 ?  "<s><span style='font-family: arial;'>".
                                                                    $subscriber->Currency->Symbol."</span>".number_format($roomcats[$i]->Compareat, 2)."</s>" : "")."
                                                            </h6>
                                                            <h5 class='ui label' style='color: white; font-family: ".$site->TextFont.";
                                                            background-color: ".$site->PrimaryColor."; background-color: ".$site->PrimaryColor.";'>"
                                                                .$roomcats[$i]->Name.
                                                            "</h5>".

                                                            ($roomcats[$i]->Smokingpolicy ?
                                                            "<img src='".$host."/cdn/images/icons/pastel/smoking.png' title='Smoking allowed'
                                                            style='width: 30px; right: 10px; position: absolute; background-color: rgba(255,255,255,0.4); border-radius: 4px; padding: 5px;''/>" :
                                                                "<img src='".$host."/cdn/images/icons/pastel/no_smoking.png' title='Non-Smoking Room' 
                                                            style='width: 30px; right: 10px; position: absolute; background-color: rgba(255,255,255,0.4); border-radius: 4px; padding: 5px;''/>").

                                                            ($roomcats[$i]->Pets ?
                                                            "<img src='".$host."/cdn/images/icons/pastel/pet.png' title='Pets allowed' 
                                                            style='width: 30px; right: 90px; position: absolute; background-color: rgba(255,255,255,0.4); border-radius: 4px; padding: 5px;''/>" :
                                                                "<img src='".$host."/cdn/images/icons/pastel/no_animal.png' title='Pets not allowed' 
                                                            style='width: 30px; right: 90px; position: absolute; background-color: rgba(255,255,255,0.4); border-radius: 4px; padding: 5px;''/>").

                                                            ($roomcats[$i]->Childrenpolicy ?
                                                            "<img src='".$host."/cdn/images/icons/pastel/children.png' title='Children allowed' 
                                                            style='width: 30px; right: 50px; position: absolute; background-color: rgba(255,255,255,0.4); border-radius: 4px; padding: 5px;'/>" :
                                                                "<img src='".$host."/cdn/images/icons/pastel/no_children.png' title='Children not allowed' 
                                                            style='width: 30px; right: 50px; position: absolute; background-color: rgba(255,255,255,0.4); border-radius: 4px; padding: 5px;'/>").
                                                        
                                                        "</div>
                                                    </div>
                                                    <div>
                                                        <div class='pad-1'>
                                                            <a href='".Router::ResolvePath("rooms/".$roomcats[$i]->Meta, $path)."'>
                                                                <button class='ui circular button' style='font-family: 
                                                                ".$site->SecondaryFont."; color: white; background-color: 
                                                                ".$site->PrimaryColor."; font-weight: normal;'>Details
                                                                </button>
                                                            </a>
                                                            <button class='ui basic circular button' style='font-family: 
                                                            ".$site->SecondaryFont."; color: white; ' onclick=\"bookRoom('".$roomcats[$i]->Id."')\">Book Room</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                }

                                $ret->Content .= "</div>
                                </div>
                            </div>
                            <div class='w3-col l4 m4 s12'>
                                <div class='l-width-9 s-pad-1 s-align-c' style='margin-top: 50px;'>
                                    <h3 style='color: ".$site->PrimaryColor."; font-family: ".$site->TextFont.";'>Easy Booking Engine</h3>
                                    <p style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                        Booking Online is easier and ensures your room is available before your arrival. 
                                        You can also make reservations at the hotel front desk.
                                    </p>
                                    <p style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                        <i class='map marker icon' style='color: ".$site->PrimaryColor.";'></i> ".
                                        $subscriber->Address."
                                    </p>";

                                    if(($modules->Contactus) && (($subscriber->Phone1 != "") || ($subscriber->Phone2 != "")))
                                    {
                                        $ret->Content .= "<br/><hr/>
                                        <h5 style='font-family: ".$site->BoldFont."; color: ".$site->PrimaryColor.";'>Call and make reservations</h5>";

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
                                        <h5 style='font-family: ".$site->BoldFont."; color: ".$site->PrimaryColor.";'>Email and make reservations</h5>
                                        <p style='color: dimgray; font-family: ".$site->SecondaryFont.";'>Send us a mail with the details of your reservations. We'll contact you.</p>";

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
                            </div>
                    </div>";


                require("addons/footer.php");

                $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag."
                </body>
            </html>";
    }