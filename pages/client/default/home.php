<?php
    $modules = new Modules($subscriber);

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
            <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Homedescription, Seo::Homepage)."'/>
            <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Homekeywords, Seo::Homepage)."'/>
            
            <!-- End Seo -->
            
            <title>".Seo::BuildTitle($subscriber,"Home | " . $subscriber->BusinessName, Seo::Homepage)."</title>
            
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

        $banner = Banner::Order($subscriber, 'sort', 'ASC');


        $colorBand = "";

        for($i = 0; $i < count($banner); $i++)
        {
            if ($banner[$i]->Status === true)
            {
                $ret->Content .= "<span id='slide-main-text-".$i."' style='display: none;'>".$banner[$i]->Text."</span>
                                <span id='slide-sub-text-".$i."' style='display: none;'>".$banner[$i]->Subtext."</span>";
            }
        }

        $ret->Content .="
             <div id='slider-carousel' class='carousel carousel-slider center l-overflow-visible'>
                <div class='carousel-fixed-item align-c s-hide'>
                    <div style='margin-bottom: 40px;'>";


                    $ret->Content .="
                        <div class='l-margin-r-xxl l-margin-l-xxl'>
                        <h1 id='main-text' style='font-family: ".$site->TextFont."; color: white;'></h1>
                        <h6 id='sub-text' style='font-family:".$site->TextFont."; color: white;'></h6>
                        </div>";



                        $roomcats = Roomcategory::Order($subscriber, 'sort', 'ASC');

                        if($modules->Booking)
                        {
                            $ret->Content .=
                                "</div>
                                    <div>
                                        <div class='widget pad-1 curve l-width-7' style='margin: auto; position: relative; margin-bottom: 50px;'>
                                            <div class='w3-row'>
                                                <div class='w3-col l3'>
                                                    <div class='pad-1'>
                                                        <div class='ui left icon fluid input'>
                                                            <i class='calendar alternate icon'></i>
                                                            <input id='checkin-date' autocomplete='off' data-toggle='datepicker' class='wix-textbox' placeholder='Check In date' style='font-family: ".$site->SecondaryFont.";'/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l3'>
                                                    <div class='pad-1'>
                                                        <div class='ui left icon fluid input'>
                                                            <i class='calendar alternate icon'></i>
                                                            <input id='checkout-date' autocomplete='off' data-toggle='datepicker' class='wix-textbox' placeholder='Check out date'  style='font-family: ".$site->SecondaryFont.";'/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l4'>
                                                    <div class='pad-1'>
                                                        <select id='room-cat-select' class='ui fluid dropdown wix-select' style='font-family: ".$site->SecondaryFont.";'>
                                                            <option value=''>Select room type</option>";

                                            for ($i = 0; $i < count($roomcats); $i++) {
                                                if ($roomcats[$i]->Status) {
                                                    $ret->Content .= "<option value='" . $roomcats[$i]->Id . "'>"
                                                        . $roomcats[$i]->Name . " - " . $subscriber->Currency->Symbol . number_format($roomcats[$i]->Price, 2) . "</option>";
                                                }
                                            }

                                            $ret->Content .=
                                                "</select>
                                                    </div>
                                                </div>
                                                <div class='w3-col l2'>
                                                    <div class='pad-1'>
                                                        <button class='ui waves-effect sleak fluid button' style='font-family: ".$site->SecondaryFont."; background-color: " . $site->PrimaryColor . "; color: white;' onclick='reserveRoom()'>
                                                            <i class='bed icon'></i>Reserve
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                        }


                        $ret->Content .= "</div></div>";

                        for($i = 0; $i < count($banner); $i++)
                        {
                            if($banner[$i]->Status === true)
                            {
                                $ret->Content .= "<div id='".$i."' class='carousel-item white-text' href='#".Convert::NumbersToWords(($i + 1))."!'>
                                    <img src='".Router::ResolvePath("files/".$banner[$i]->Image, $path)."' 
                                    style='max-height: 500px; width: 100%; filter: brightness(50%);'/>
                                </div>";
                            }
                        }


                        $ret->Content .="</div>";



                         //-------------------------   booking engine display for mobile-----------------------

                        if(($modules->Lodging) && ($modules->Booking))
                        {
                            $ret->Content .= "<div class='l-hide align-c pad-1' style=''>
                                <div class='ui fluid large left icon input'>
                                    <i class='calendar alternate outline icon'></i>
                                    <input id='m-checkin-date' class='wix-textbox' data-toggle='datepicker' autocomplete='off' placeholder='Check in date'/>
                                </div>
                                <div class='ui fluid large left icon input' style='margin-top: 5px;'>
                                    <i class='calendar alternate outline icon'></i>
                                    <input id='m-checkout-date' class='wix-textbox' data-toggle='datepicker' autocomplete='off' placeholder='Check out date'/>
                                </div>
                                <div style='margin-top: 5px'>
                                    <select id='m-room-cat-select' class='ui fluid big-dropdown dropdown wix-select' style='font-family: ".$site->SecondaryFont."; padding: 5px;'>
                                        <option value=''>Select room type</option>";

                                            for ($i = 0; $i < count($roomcats); $i++) {
                                                if ($roomcats[$i]->Status) {
                                                    $ret->Content .= "<option value='" . $roomcats[$i]->Id . "'>"
                                                        . $roomcats[$i]->Name . " - " . $subscriber->Currency->Symbol . number_format($roomcats[$i]->Price, 2) . "</option>";
                                                }
                                            }

                                        $ret->Content .=
                                    "</select>
                                </div>
                                <button id='m-reserve-btn' class='ui fluid big button' style='color: white; margin-top: 5px; background-color: ".
                                    $site->PrimaryColor."; font-family: ".$site->SecondaryFont.";' onclick='m_reserveRoom()'>
                                    <i class='bed icon'></i> Reserve
                                </button>";

                                $ret->Content .= "</div>";
                        }




                        if(($modules->Lodging) && ($modules->Booking))
                        {

                            $ret->Content .= "
                            <div>
                                <div class='margin-t-9 margin-b-9'>
                                    <div class=''>
                                        <div class='align-c'>
                                            <h2 style='font-family: " . $site->TextFont . "'>Make Your Reservation</h2>
                                            <h4><i class='bed circular icon' style='color: white; background-color: " . $site->PrimaryColor . "'></i> </h4>
                                        </div>
                                        <div class='margin-t-6'>
                                            <div class='l-width-8' style='margin: auto;'>
                                                <div class=''>
                                                    <div class='w3-row'>";

                                                        for ($i = 0; $i < count($roomcats); $i++)
                                                        {
                                                            if ($roomcats[$i]->Status)
                                                            {
                                                                $ret->Content .=
                                                                    "<div class='w3-col l4 m6 s12'>
                                                                    <div class='pad-2'>
                                                                        <div class='' style='border-radius: 5px; position: relative;'>
                                                                            <div>
                                                                                <img src='" . Router::ResolvePath("files/" . $roomcats[$i]->Images[0], $path) . "' style='width: 100%; border-radius: 6px;'/>
                                                                            </div>
                                                                            <div class='pad-1 room-listing' onmouseenter=\"showSlip('".$roomcats[$i]->Id."')\" onmouseleave=\"hideSlip('".$roomcats[$i]->Id."')\">
                                                                                <label id='room-book-slip-".$roomcats[$i]->Id."' class='room-book-strip' style='background-color: ".$site->SecondaryColor.";
                                                                                 font-family: ".$site->SecondaryFont.";' onclick=\"bookRoom('".$roomcats[$i]->Id."', null, null)\">Book room</label>
                                                                                <a href='".Router::ResolvePath("rooms/".$roomcats[$i]->Meta, $path)."'>
                                                                                    <label id='room-detail-slip-".$roomcats[$i]->Id."' class='room-book-strip' style='margin-top: 40px; background-color: ".$site->SecondaryColor.";
                                                                                        font-family: ".$site->SecondaryFont.";'>See details
                                                                                    </label>
                                                                                </a>
                                                                                <h6 style='float: right; font-family: ".$site->SecondaryFont."; color: white; bottom: 0px; position: absolute; right: 10px;'><span style='font-family: arial;'>" .
                                                                                    $subscriber->Currency->Symbol ."</span>". number_format($roomcats[$i]->Price, 2) . " / <small>Night</small>".
                                                                                    ($roomcats[$i]->Compareat > 0 ?
                                                                                    "<br/><s><span style='font-family: arial;'>".
                                                                                    $subscriber->Currency->Symbol ."</span>". number_format($roomcats[$i]->Compareat, 2) . " / <small>Night</small></s>" : "")."
                                                                                </h6>
                                                                                <h5 class='ui label' style='font-family: " . $site->TextFont . "; color: white; background-color: " . $site->PrimaryColor . "; font-weight: bold;'>" . $roomcats[$i]->Name . "</h5>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>";
                                                        }
                                                    }

                                                    $ret->Content .=
                                                        "</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";

                            $ret->Content .= "</div></div></div>";
                        }





                        if(($modules->Pagetext) && ($site->PageText != ""))
                        {

                            try {
                                $html = str_get_html($site->PageText);

                                foreach ($html->find("p") as $i) {
                                    $i->style = "font-family: " . $site->SecondaryFont . "; font-size: 16px; line-height: 160%; color: black;";
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

                                $ret->Content .= "
                                    <div class='s-hide'>
                                        <div class='' style=\"background-color: rgb(250,250,250); 
                                        background-image: url('".$host."/cdn/images/text-bg.jpg'); background-position: center;
                                        background-size: cover; background-repeat: no-repeat;\">
                                            <div class='w3-row'>
                                                <div class='w3-col l10 m10 s12'>
                                                    <div class='l-width-7 l-pad-4 s-pad-2' style='margin: auto;'>
                                                        ".$c."
                                                    </div>
                                                </div>
                                                <!--
                                                <div class='w3-col l6 m6 s12'>
                                                    <div class='width-7 l-pad-4' style='margin: auto;'>
                                                       <img src=''/>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div>
                                    </div>";
                            }
                            catch (Exception $exception)
                            {

                            }
                        }





//----------------------------------------Our services logic --------------------------

                        if($modules->Services)
                        {
                            $services = Services::Order($subscriber, 'sort', 'ASC');

                            $ret->Content .=
                                "<div>
                                    <div class=''>
                                        <div class=''>
                                            <div class='align-c'>
                                                <br/><br/>
                                                <h2 style='font-family: " . $site->TextFont . "'>Our Services</h2>
                                                <!--<h4><i class='group circular icon' style='color: white; background-color: " . $site->PrimaryColor . "'></i> </h4>-->
                                            </div>
                                            <div class='margin-t-6'>
                                                <div class='l-width-9' style='margin: auto;'>
                                                    <div class=''>
                                                        <div class='w3-row'>";



                                                        for($i = 0; $i < count($services); $i++)
                                                        {
                                                            if($services[$i]->Status)
                                                            {
                                                                $icon = "";

                                                                if($services[$i]->Icontype == "icon")
                                                                {
                                                                    $icon = "<h3 class='ui icon header '>
                                                                            <i class='".$services[$i]->Icon." circular icon'
                                                                            style='color: ".$site->PrimaryColor.";'></i></h3>";
                                                                }
                                                                else if($services[$i]->Icontype == "image")
                                                                {
                                                                    $icon = "<img src='".Router::ResolvePath("files/".$services[$i]->Icon, $path)."' 
                                                                    style='width: 80px;'/>";
                                                                }

                                                                $ret->Content .=
                                                                    "<div class='w3-col l3 m6 s6 l-pad-2 s-pad-1 l-margin-b-7 s-margin-b-4'>
                                                                        <div class=''>
                                                                            <div>
                                                                                <div class='align-c'>".$icon."</div>
                                                                            </div>
                                                                            <div class='align-c'>
                                                                                <div>
                                                                                    <h3 style='font-family: ".$site->BoldFont.";'>".
                                                                                        $services[$i]->Heading."
                                                                                    </h3>
                                                                                    <p style='font-family: ".$site->SecondaryFont."; 
                                                                                        font-weight: bold; color: dimgray; line-height: 170%;'>".
                                                                                        $services[$i]->Body."
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>";
                                                            }
                                                        }


                                                    $ret->Content .=
                                                        "</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }





                //-------------------------------------Facilities logic --------------------------

                if($modules->Facilities)
                {
                    $facilities = Facilities::Order($subscriber, 'sort', 'ASC');

                    if($colorBand == "")
                    {
                        $colorBand = "background-color: rgb(250,250,250);"; //background-color: rgb();
                    }
                    else
                    {
                        $colorBand = "";
                    }

                    $ret->Content .=
                        "<div style='".$colorBand."'>
                            <div class=''>
                                <div class=''>
                                    <div class='align-c' style=''>
                                        <br/><br/><br/>
                                        <h2 style='font-family: " . $site->TextFont . "'>Our Facilities</h2>
                                    </div>
                                    <div class='margin-t-6'>
                                        <div class='l-width-9' style='margin: auto;'>
                                            <div class=''>
                                                <div class='w3-row'>";


                                                for($i = 0; $i < count($facilities); $i++)
                                                {
                                                    if($facilities[$i]->Status)
                                                    {
                                                        $icon = "";

                                                        if($facilities[$i]->Icontype == "icon")
                                                        {
                                                            $icon = "<h1><i class='".$facilities[$i]->Icon." icon'
                                                                    style='color: ".$site->PrimaryColor.";'></i></h1>";
                                                        }

                                                        $ret->Content .=
                                                            "<div class='w3-col l4 m6 s12 l-pad-2 s-pad-1 l-margin-b-7 s-margin-b-4'>
                                                                <div class='w3-row'>
                                                                    <div class='w3-col l3 m4 s4'>
                                                                        <div class='align-c'>".$icon."</div>
                                                                    </div>
                                                                    <div class='w3-col l9 m8 s8'>
                                                                        <div>
                                                                            <h4 style='font-family: ".$site->BoldFont.";'>".
                                                                                $facilities[$i]->Heading."
                                                                            </h4>
                                                                            <p style='font-family: ".$site->SecondaryFont."; 
                                                                                font-weight: bold; color: dimgray; line-height: 170%;'>".
                                                                                $facilities[$i]->Body."
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>";
                                                    }
                                                }


                                                    $ret->Content .=
                                                "</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
                }




                //-------- place for the testimonial --------------------------

                if($modules->Testimonials)
                {
                    if($colorBand == "")
                    {
                        $colorBand = "background-color: rgb(250,250,250);"; //background-color: rgb(250,250,250);
                    }
                    else
                    {
                        $colorBand = "";
                    }

                    $testimonial = Testimonial::Order($subscriber, 'sort', 'ASC');
                    $ret->Content .=
                    "<div style='".$colorBand."'>
                        <div class=''>
                            <div class=''>
                                <div class='align-c s-width-9' style='margin: auto;'>
                                    <br/><br/>
                                    <h2 style='font-family: " . $site->TextFont . "'>What Our Customers Say About Us</h2>
                                    <!--<h4><i class='group circular icon' style='color: white; background-color: " . $site->PrimaryColor . "'></i> </h4>-->
                                </div>
                                <div class='margin-t-6'>
                                    <div class='l-width-9' style='margin: auto; text-align: center;'>
                                        <div class='' style='display: inline;'>
                                            <div class=''>
                                                <div id='testimonial-carousel' class='carousel' style=''>";


                                                for($i = 0; $i < count($testimonial); $i++)
                                                {
                                                    $stars = "";

                                                    for($j = 0; $j < 5; $j++)
                                                    {
                                                        if($j < $testimonial[$i]->Rating)
                                                        {
                                                            $stars  .= "<i class='yellow-text star icon'></i>";
                                                        }
                                                        else
                                                        {
                                                            $stars  .= "<i class='star icon' style='color: lightgray;'></i>";
                                                        }
                                                    }


                                                    $ret->Content .="
                                                    <a class='carousel-item w3-card-2 l-width-5 s-width-8 l-pad-3 s-pad-2 curve' href='#".Convert::NumbersToWords(($i + 1))."!' 
                                                        style='height: 230px; width: 400px; background-color: white;'>
                                                        <div class='w3-row'>
                                                            <div class='w3-col l3 m3 s3'>
                                                                <img src='".Router::ResolvePath('files/'.$testimonial[$i]->Image, $path)."' 
                                                                style='border-radius: 50%; max-width: 100%;'/>
                                                            </div>
                                                            <div class='w3-col l9 m9 s9 align-r'>
                                                                <h5 style='font-family: ".$site->TextFont."; color:".$site->PrimaryColor."; 
                                                                font-weight: bold; margin-top: 20px;'>".
                                                                $testimonial[$i]->Name."</h5>
                                                                ".$stars."
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p style='font-family: ".$site->SecondaryFont."; line-height: 160%; 
                                                                font-size: 14px; margin-top: 10px; color: dimgray;'>
                                                                <i class='quote left icon'></i> ".$testimonial[$i]->Body." <i class='quote right icon'></i>
                                                            </p>
                                                        </div>    
                                                    </a>";
                                                }
                                                    
                                                    $ret->Content .="
                                                </div>";


                                                $ret->Content .=
                                            "</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                }





                //---------------------------------- Team Logic ------------------------------------------

                if($modules->Team)
                {

                    if($colorBand == "")
                    {
                        $colorBand = "background-color: rgb(250,250,250);"; //background-color: rgb(250,250,250);
                    }
                    else
                    {
                        $colorBand = "";
                    }

                    $ret->Content .= "
                        <div style='".$colorBand."'>
                            <div class='margin-b-9'>
                                <div class=''>
                                    <div class='align-c'>
                                        <br/><br/>
                                        <h2 style='font-family: " . $site->TextFont . "'>Meet our team</h2>
                                    </div>
                                    <div class='margin-t-6'>
                                        <div class='l-width-8' style='margin: auto;'>
                                            <div class=''>
                                                <div class='w3-row'>";

                                                $team = Team::Order($subscriber, 'sort', 'ASC');

                                                for ($i = 0; $i < count($team); $i++)
                                                {
                                                    if($team[$i]->Status)
                                                    {
                                                        $ret->Content .=
                                                            "<div class='w3-col l3 m4 s12'>
                                                        <div class='pad-2 align-c'>
                                                            <div class=''>
                                                                <div style='border-radius: 50%; border: 4px solid lightgray; display: inline-block;'>
                                                                    <img src='" . Router::ResolvePath("files/" . $team[$i]->Image, $path) . "' 
                                                                    style='width: 170px; height: 170px; border-radius: 50%; border: 4px solid white;'/>
                                                                </div>
                                                                <div class='pad-1' style=''>
                                                                    <h5 style='font-family: " . $site->BoldFont . "; color: ".$site->PrimaryColor.";'>" . $team[$i]->Name . "</h5>
                                                                    <h6 style='font-family: " . $site->TextFont . "; color: black; bottom: 0px; right: 10px;'>" .
                                                                        $team[$i]->Description . "</h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>";
                        }

                    }

                    $ret->Content .=
                        "</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                }





//--------------------------------------- Gallery logic ----------------------------------


                if($modules->Gallery)
				{
                    if($colorBand == "")
                    {
                        $colorBand = "background-color: rgb(250,250,250);"; //background-color: rgb(250,250,250);
                    }
                    else
                    {
                        $colorBand = "";
                    }

                    $ret->Content .= "
                <div style='".$colorBand."'>
                    <div class='margin-t-9 margin-b-9'>
                        <div class=''>
                            <div class='align-c'>
                                <br/><br/>
                                <h2 style='font-family: " . $site->TextFont . "'>Our Gallery</h2>
                                <!--<h4><i class='group circular icon' style='color: white; background-color: " . $site->PrimaryColor . "'></i> </h4>-->
                            </div>
                            <div class='margin-t-6'>
                                <div class='l-width-9' style='margin: auto;'>
                                    <div class=''>
                                        <div class='w3-row'>";

                    $gallery = Gallery::Order($subscriber, 'sort', 'ASC');

                    for ($i = 0; $i < count($gallery); $i++) {
                        if ($gallery[$i]->Status) {
                            $ret->Content .=
                                "<div class='w3-col l3 m4 s6'>
                                                      <div class='l-pad-2 s-pad-t'>
                                                          <div class='' style='border-radius: 5px; position: relative;' onmouseenter='galleryEntered(" . $i . ")' onmouseleave='galleryLeft(" . $i . ")'>
                                                              <div>
                                                                  <img src='" . Router::ResolvePath("files/" . $gallery[$i]->Image, $path) . "' style='width: 100%; border-radius: 6px;'/>
                                                              </div>
                                                              <div id='gallery-cover-" . $i . "' class='pad-1' style='position: absolute; top: 1px; width: 100%; height: 99%; 
                                                                  border-radius: 6px;'>
                                                                  <h6 id='gallery-description-" . $i . "' style='float: right; font-family: ".$site->SecondaryFont."; color: white; bottom: 0px; position: absolute;
                                                                    display: none; line-height: 150%;'>" .
                                $gallery[$i]->Description . "</h6>
                                                                  <h5 style='font-family: " . $site->TextFont . "; color: white; 
                                                                    text-shadow: white 2px 2px 10px 5px; font-weight: bold;'>" . $gallery[$i]->Heading . "</h5>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>";
                        }
                    }

                    $ret->Content .=
                        "</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";

                }




        require("addons/footer.php");

        $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.=
        "</body>
    </html>";
