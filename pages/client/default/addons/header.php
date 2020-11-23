<?php

    $cart = new Cart($subscriber);

    $logo = "";

    if($site->Logo == "")
    {
        $logo = Router::ResolvePath("files/logo.png", $path);
    }
    else
    {
        $logo = Router::ResolvePath("files/".$site->Logo, $path);
    }


    $ret->Content .= "
        <input id='prim-color' type='hidden' value='".$site->PrimaryColor."'/>
        <input id='prim-font' type='hidden' value='".$site->TextFont."'/>
        <input id='sec-color' type='hidden' value='".$site->SecondaryColor."'/>
        <input id='sec-font' type='hidden' value='".$site->SecondaryFont."'/>
        <input id='currency-symbol' type='hidden' value='".$subscriber->Currency->Symbol."'/>
        <div class='s-hide pad-2 l-width-8 w3-row' style='margin: auto;'>
        
        
            <div class='w3-col l1 m1 s2'>";
            if($site->ShowLogo)
            {
                $ret->Content .="<img src='".$logo."' style='max-height: 50px;'/>";
            }
            else
            {
                $ret->Content .= "<div style='color: transparent;'>.</div>";
            }

            $ret->Content .= "</div>
            <div class='w3-col l5 m5 s4'>";

            if($site->ShowName)
            {
                $ret->Content .="<h3 style='font-family: ".$site->TextFont."; margin-top: 10px;'>".$subscriber->BusinessName."</h3>";
            }
            else
            {
                $ret->Content .="<div style='color: transparent;'>.</div>";
            }

            $ret->Content .= "</div>";


            if($modules->Lodging)
            {
                $ret->Content .=
                    "<div class='w3-col l6 m6 s6'>
                        <div class='align-r'>
                            <h6 style='font-family: ".$site->SecondaryFont."; color: dimgray;'>
                                <a href='" . Router::ResolvePath("reservations", $path) . "'><i class='bed circular icon'></i> My Reservations</a> <span class='ui cart-content-count label'>".$cart->Contentcount()."</span>";

                        if ($customer->Id != "") {
                            $ret->Content .= "<small>Hello, " . $customer->Name . " " . $customer->Surname .
                                "<a style='text-decoration: none; cursor: pointer; color: " . $site->PrimaryColor . "'
                                        onclick='logout(this)'> 
                                        [Logout]</a></small>";
                        }

                        $ret->Content .=
                            "</h6>
                        </div>
                    </div>";
            }

            $ret->Content .=
        "</div>
        <div class='l-hide pad-1 w3-row'>";
        
            if($site->ShowLogo)
            {
                $ret->Content .= "
                    <div class='w3-col l3 m3 s3'>
                        <img src='".$logo."' style='max-height: 30px; margin-top: 10px;'/>
                    </div>";
            }
            else
            {
                $ret->Content .= "
                    <div class='w3-col l3 m3 s3' style='color: transparent;'>.</div>";
            }

            if($site->ShowName)
            {
                $ret->Content .= "
                    <div class='w3-col l9 m9 s9'>
                        <div class='align-r'>
                            <h6 style='font-family: quicksand_mediumregular; color: dimgray;'>
                                <a href='".Router::ResolvePath('reservations', $path)."'><i class='bed circular icon'></i>My Reservations</a> <span class='ui cart-content-count label'>".$cart->Contentcount()."</span>
                            </h6>
                        </div>
                    </div>";
            }


            $ret->Content .= "
        </div>
        <header class='w3-container s-pad-1 m-pad-1' style='background-color: ".$site->PrimaryColor.";'>
        <div class='w3-row'>
            <div class='w3-col l5 m5 s9 l-margin-t-2'>
                <h5 class='l-hide' style='font-family: ".$site->TextFont."; color: white;'><b>".$subscriber->BusinessName."</b></h5>
            </div>
            <div class='w3-col l5 m5 s1 l-margin-t-2 l-hide'>
                <h5 style='color: white;'>
                    <a href='".Router::ResolvePath('home', $path)."' style='color: white;'>
                        <i class='home icon'></i>
                    </a>
                </h5>
            </div>
            <div class='w3-col l7 m7 s2 align-r'>
                <ul class='s-hide m-hide m-menu' style='margin: 0px; font-family: ".$site->SecondaryFont.";'>
                    <a href='".Router::ResolvePath("home", $path)."'><li><i class='home icon'></i>Home</li></a>";

                    if($modules->Lodging || $modules->Kitchen || $modules->Bakery || $modules->Bar)
                    {
                        $ret->Content .= "
                            <li>
                            <div class='o-dropdown'  style='padding: 0px !important; margin: 0px !important;'>
                                <span class='o-dropbtn'> Our Hotel<i class='angle down icon'></i></span>
                                <div class='o-dropdown-content' style='right: 0px;'>
                                    <div class='w3-row'>";

                                        if($modules->Lodging)
                                        {
                                            $ret->Content .= "
                                                <div class='w3-col l6 m6 s6 margin-t-2'>
                                                    <a href='" . Router::ResolvePath('lodging', $path) . "'>
                                                        <div class='align-c'>
                                                            <img src='" . Router::ResolvePath($host . "cdn/images/icons/pastel/room.png") . "' style='width: 40px;'>
                                                            <h6 style='font-family: " . $site->TextFont . "; font-size: 15px;'>Lodging</h6>
                                                        </div>
                                                    </a>
                                                </div>";
                                        }
                                        if($modules->Kitchen) {
                                            $ret->Content .= "
                                                <div class='w3-col l6 m6 s6 margin-t-2'>
                                                    <a href='" . Router::ResolvePath('restaurant', $path) . "'>
                                                        <div class='align-c'>
                                                            <img src='" . Router::ResolvePath($host . "cdn/images/icons/pastel/utensil.png") . "' style='width: 40px;'>
                                                            <h6 style='font-family: " . $site->TextFont . "; font-size: 15px;'>Restaurant</h6>
                                                        </div>
                                                    </a>
                                                </div>";
                                        }

                                        if($modules->Bar)
                                        {
                                            $ret->Content .= "
                                                <div class='w3-col l6 m6 s6 margin-t-2'>
                                                    <a href='" . Router::ResolvePath('bar', $path) . "'>
                                                        <div class='align-c'>
                                                            <img src='" . Router::ResolvePath($host . "cdn/images/icons/pastel/toast.png") . "' style='width: 40px;'>
                                                            <h6 style='font-family: " . $site->TextFont . "; font-size: 15px;'>Bar</h6>
                                                        </div>
                                                    </a>
                                                </div>";
                                        }
                                        if($modules->Bakery)
                                        {
                                            $ret->Content .= "
                                                <div class='w3-col l6 m6 s6 margin-t-2'>
                                                    <a href='" . Router::ResolvePath('pastries', $path) . "'>
                                                        <div class='align-c'>
                                                            <img src='" . Router::ResolvePath($host . "cdn/images/icons/pastel/cake.png") . "' style='width: 40px;'>
                                                            <h6 style='font-family: " . $site->TextFont . "; font-size: 15px;'>Pastries</h6>
                                                        </div>
                                                    </a>
                                                </div>";
                                        }
                    $ret->Content .= "</div></div>
                            </div>
                            </li>";
                    }

                    if($modules->Faq)
                    {
                        $ret->Content .= "
                            <a href='" . Router::ResolvePath("faqs", $path) . "'><li><i class='question circle icon'></i>FAQs</li></a>";
                    }

                    if($modules->Contactus)
                    {
                        $ret->Content .= "
                            <a href='" . Router::ResolvePath("contactus", $path) . "'><li><i class='open envelope icon'></i>Contact Us</li></a>";
                    }


                    if($modules->Customers)
                    {
                        if ($customer->Id != "")
                        {
                            $ret->Content .= "
                              <li>
                                  <div class='hms-dropdown'  style='padding: 0px !important; margin: 0px !important;'>
                                        <span class='hms-dropbtn'><i class='user circle icon'></i> My Account<i class='angle down icon'></i></span>
                                        <div class='hms-dropdown-content' style='right: 0px;'>
                                      
                                        <ul style='background-color: " . $site->PrimaryColor . "'>
                                            <li style='padding: 0px; display: block;'><a href='" . Router::ResolvePath("account", $path) . "' style='color: white; display: inline-block;'>My Account</a></li>
                                            <li style='padding: 0px; display: block;'><a href='" . Router::ResolvePath("reservation", $path) . "' style='color: white; display: block;'>My reservations</a></li>
                                            <li style='padding: 0px; display: block;'><a href='" . Router::ResolvePath("order-history", $path) . "' style='color: white;'>Order history</a></li>
                                            <li style='padding: 0px; display: block;'><a href='" . Router::ResolvePath("lodging-history", $path) . "' style='color: white;'>Lodging history</a></li>
                                            <li style='padding: 0px; display: block;'><a href='" . Router::ResolvePath("profile", $path) . "' style='color: white;'>My Profile</a></li>
                                            <li style='padding: 0px; display: block;'><a href='" . Router::ResolvePath("password", $path) . "' style='color: white;'>Change Password</a></li>
                                            <li style='padding: 0px; display: block;'><a style='color: white;' onclick='logout(this)'>Logout</a></li>
                                        </ul>
                                      
                                    </div>
                                  </div>
                              </li>";
                        }
                        else
                        {
                            $ret->Content .= "<a onclick='ShowLogin()'><li><i class='sign in icon'></i>LogIn / Sign up</li></a>";
                        }
                    }


                    $ret->Content .=
                    "</ul>
                <div class='align-r l-hide'>
                    <h4 style='color: white; cursor: pointer; display: inline;' onclick='toggleMobMen()'>
                        <i class='bars icon'></i>
                    </h4>
                </div>
            </div>
        </div>
    </header>";


    //------------------------- mobile quick access button--------------


    //require_once ("quickaccess.php");



    //------------------------- Mobile menu design---------------------


    $ret->Content .=
    "<div class='not-visible' id='mobile-menu' style=\"overflow-y: auto; background-image: url('".$host."cdn/images/bgb.jpg'); background-position: center; background-size: cover;\">
        <div class=''>";
            if($customer->Id == "")
            {
                $ret->Content .=
                    "<h4 style='padding: 20px; font-family: ".$site->TextFont.";' onclick='toggleMobMen(); ShowLogin();'>
                        <i class='sign in icon'></i> Login / Signup</h5>";
            }
            else
            {
                $ret->Content .=
                    "<h5 style='padding: 20px; font-family: ".$site->TextFont.";'>
                        <i class='angle down icon' style='float: right;' onclick='openMobileAccountMenu(this)'></i>
                        <a href='".Router::ResolvePath('account', $path)."'>
                        <i class='user circle icon'></i> My Account</a></h5>";
            }

        $ret->Content .= "
        <div id='m-account-menu' style='display: none;'>
            <a href='".Router::ResolvePath('reservation', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='bed icon'></i> My reservations</h6>
            </a>
            <a href='".Router::ResolvePath('order-history', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='shopping basket icon'></i> Order history</h6>
            </a>
            <a href='".Router::ResolvePath('lodging-history', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='history icon'></i> Lodging history</h6>
            </a>
            <a href='".Router::ResolvePath('profile', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='user icon'></i> My profile</h6>
            </a>
            <a href='".Router::ResolvePath('password', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='unlock icon'></i> Change password</h6>
            </a>
            <a>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";' onclick='logout(this)'><i class='sign out icon'></i> Log out</h6>
            </a>
        </div>
        </div>
        <br/>
        <div>
            <a href='".Router::ResolvePath('home', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='home icon'></i> Home</h6>
            </a>
            <a href='".Router::ResolvePath('faqs', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='question circle icon'></i> FAQs</h6>
            </a>
            <a href='".Router::ResolvePath('contactus', $path)."'>
                <h6 class='m-menu-item' style='font-family: ".$site->SecondaryFont.";'><i class='open envelope icon'></i> Contact us</h6>
            </a>
        </div>
        <hr/>
        <div class='w3-row'>";

        if(($modules->Booking) && ($modules->Lodging))
        {
            $ret->Content .="
                <a href='".Router::ResolvePath('rooms', $path)."'>
                    <div class='w3-col l6 m6 s6 align-c pad-1'>
                        <img src='".$host."cdn/images/icons/pastel/room.png' style='width: 50px;'/>
                        <h6 style='font-family: ".$site->TextFont.";'>Lodging</h6>
                    </div>
                </a>";
        }
        if($modules->Kitchen)
        {
            $ret->Content .="
                <a href='".Router::ResolvePath('restaurant', $path)."'>
                    <div class='w3-col l6 m6 s6 align-c pad-1'>
                        <img src='".$host."cdn/images/icons/pastel/utensil.png' style='width: 50px;'/>
                        <h6 style='font-family: ".$site->TextFont.";'>Restaurant</h6>
                    </div>
                </a>";
        }
        if($modules->Bar)
        {
            $ret->Content .="
                <a href='".Router::ResolvePath('bar', $path)."'>
                    <div class='w3-col l6 m6 s6 align-c pad-1'>
                        <img src='".$host."cdn/images/icons/pastel/toast.png' style='width: 50px;'/>
                        <h6 style='font-family: ".$site->TextFont.";'>Bar</h6>
                    </div>
                </a>";
        }
        if($modules->Bakery)
        {
            $ret->Content .="
                <a href='".Router::ResolvePath('pastries', $path)."'>
                    <div class='w3-col l6 m6 s6 align-c pad-1'>
                        <img src='".$host."cdn/images/icons/pastel/cake.png' style='width: 50px;'/>
                        <h6 style='font-family: ".$site->TextFont.";'>Pastries</h6>
                    </div>
                </a>";
        }

        $ret->Content .="
        </div>
    </div>";
