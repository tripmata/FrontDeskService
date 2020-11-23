<?php

    $ret->Content .= "
    <div class='l-margin-t-4' id='contact-con' style=\"background-image: url('".$host."/cdn/images/bgb.jpg'); background-position: center; background-size: cover;\">
                <div style='background-color: rgba(0,0,0,0.5); width: 100%; height: 100%;'>";

                    if($modules->Newsletter)
                    {
                        $ret->Content .= "
                            <div class='align-c'>
                                <div class='l-width-4' style='margin: auto;'>
                                    <div class='w3-container l-pad-3 s-pad-2'>
                                        <h3 class='' style='font-family: ".$site->SecondaryFont."; color: white;'>
                                            <i class='envelope open icon'></i>
                                            Subscribe
                                        </h3>
                                        <p style='color: white; font-family: ".$site->SecondaryFont.";'>Get relevant info with</p>
                                        <div class=''>
                                            <div class='ui fluid labeled action input'>
                                                <label class='ui sleak label'><i class='at icon'></i></label>
                                                <input id='newsletter-email' type='text' style='font-family: ".$site->SecondaryFont.";'/>
                                                <button id='email-subscribe-btn' class='ui sleak button' 
                                                style='background-color: " . $site->PrimaryColor . "; color: white; font-family: ".$site->SecondaryFont.";' onclick='saveSubscriberEmail()'>
                                                    <i class='open envelope icon'></i><span clas='s-hide'>Subscribe</span>
                                                </button>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }


                    if($modules->Contactus)
                    {
                        $integ = new Integration($subscriber);

                        $ret->Content .=
                            "<div>
                                <div class='l-pad-2 s-pad-1 align-c'>
                                    <div style='line-height: 180%;'>";

                                    if(($integ->Facebook != "") || ($integ->Telegram != "") || ($integ->Whatsapp != "") ||
                                        ($integ->Linkedin != "") || ($integ->Google != "") || ($integ->Instagram != "") ||
                                        ($integ->Twitter != ""))
                                    {
                                        $ret->Content .="
                                        <h6 style='font-family: ".$site->TextFont."; display: inline; color: white;'>
                                            Follow us
                                        </h6>";
                                    }

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


                    
                    $ret->Content .= "
                    <div class='align-c pad-1' style='background-color: rgba(0,0,0,0.6); color: white; font-family: lato;'>
                        <h6 style='font-family: lato; line-height: 200%;'>";
                        if($modules->Lodging)
                        {
                            $ret->Content .= "
                            <a href='".Router::ResolvePath("lodging",$path)."' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                            if($page == "lodging"){$ret->Content .= "color: ".$site->PrimaryColor.";";}
                             $ret->Content .= "'>Lodging</a> &nbsp;&nbsp;|&nbsp;&nbsp; ";
                        }

                        if($modules->Kitchen)
                        {
                            $ret->Content .= "
                                <a href='" . Router::ResolvePath("restaurant", $path) . "' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                                if ($page == "restaurant") {$ret->Content .= "color: " . $site->PrimaryColor . ";";}
                                $ret->Content .= "'>Restaurant</a> &nbsp;&nbsp;| &nbsp;&nbsp; ";
                        }

                        if($modules->Bar)
                        {
                            $ret->Content .= "
                                <a href='" . Router::ResolvePath("bar", $path) . "' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                            if ($page == "bar") {$ret->Content .= "color: " . $site->PrimaryColor . ";";}
                            $ret->Content .= "'>Bar</a> &nbsp;&nbsp;| &nbsp;&nbsp; ";
                        }

                        if($modules->Bakery)
                        {
                            $ret->Content .= "
                                                        <a href='" . Router::ResolvePath("pastries", $path) . "' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                            if ($page == "pastries") {$ret->Content .= "color: " . $site->PrimaryColor . ";";}
                            $ret->Content .= "'>Pastries</a> &nbsp;&nbsp;| &nbsp;&nbsp; ";
                        }

                        if($modules->Aboutus)
                        {
                            $ret->Content .= "
                                <a href='" . Router::ResolvePath("aboutus", $path) . "' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                            if ($page == "aboutus") {$ret->Content .= "color: " . $site->PrimaryColor . ";";}
                            $ret->Content .= "'>About Us</a> &nbsp;&nbsp;| &nbsp;&nbsp; ";
                        }

                        if($modules->Policy)
                        {
                            $ret->Content .= "
                                <a href='".Router::ResolvePath("privacy",$path)."' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                                if($page == "privacy"){$ret->Content .= "color: ".$site->PrimaryColor.";";}
                                $ret->Content .= "'>Privacy & Security Policy</a>  &nbsp;&nbsp;| &nbsp;&nbsp; ";
                        }

                        if($modules->Faq)
                        {
                            $ret->Content .= "
                                <a href='".Router::ResolvePath("faqs",$path)."' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                                if($page == "faqs"){$ret->Content .= "color: ".$site->PrimaryColor.";";}
                                $ret->Content .= "'>FAQs</a> &nbsp;&nbsp;| &nbsp;&nbsp; ";
                        }


                        if($modules->Terms)
                        {
                            $ret->Content .= "
                                <a href='".Router::ResolvePath("terms",$path)."' style='text-decoration: none; font-family: ".$site->SecondaryFont.";";
                                if($page == "terms"){$ret->Content .= "color: ".$site->PrimaryColor.";";}
                                $ret->Content .= "'>Terms & Conditions</a> ";
                        }

                        $ret->Content .= "
                        </h6>
                        <h6 style='color: dimgray; font-family: ".$site->SecondaryFont.";'>Copyright &copy;".date('Y')." ".$subscriber->BusinessName.". All Rights Reserved</h6>
                        
                    </div>
                </div>
            </div>
    ";