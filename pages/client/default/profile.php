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
                        
                        <title>User Profile | " . $subscriber->BusinessName . "</title>
                        
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/mat.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/semantic.min.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/croppie.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/datepicker.min.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/w3.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/space_app.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/themes/default/css/page.css'/>";

                        require_once ("addons/link.php");

                        $ret->Content .="
                        <script type='application/javascript' src='" . $host . "/cdn/js/jquery.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/easing.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/semantic.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/functions.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/upload.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/croppie.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/datepicker.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/WixnitEncoder.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/themes/default/js/page.js'></script>
                    </head>
                    <body>";
                    require("addons/header.php");

                    $ret->Content .= "
                        <div class='l-width-8' style='margin: auto;'>
                            <div class='l-margin-t-3 m-pad-1 s-pad-1'>
                                <h5 style='color: dimgray; font-family: " . $site->BoldFont . " ;'>
                                    <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                    <i class='user circle icon'></i></div> My Profile
                                </h5><hr>
                                <div class='ui breadcrumb'>
                                  <a href='" . Router::ResolvePath("home", $path) . "' class='section'>Home</a>
                                  <i class='right chevron icon divider'></i>
                                  <a href='" . Router::ResolvePath("account", $path) . "' class='section'>My Account</a>
                                  <i class='right chevron icon divider'></i>
                                  <div class='section' style='color: black;'>My Profile</div>
                                </div>
                            </div>
                        </div>
                        <div class='margin-t-6 margin-b-9'>
                            <div class='l-width-8' style='margin: auto;'>
                                <div class='w3-row'>
                                    <div class='w3-col l4 m4 s12'>
                                        <div class='l-width-xl curve w3-card'>
                                            <div class='pad-2' style='background-color: ".$site->PrimaryColor."; color: white; 
                                            padding-top: 60px; padding-bottom: 60px;'>
                                                <div style='background-color: rgba(255,255,255,0.2); border-radius: 50%; height: 150px; width: 150px; position: relative;'>
                                                    <img id='profile-img' src='".Router::ResolvePath("files/".$customer->Profilepic, $path)."' style='width: 100%; height: 100%; border-radius: 50%;'/>
                                                    <input id='profile-img-inp' type='file' onchange='uploadPic(this)' style='display: none;'/>
                                                    <input id='profile-img-input' type='hidden' value=''/>
                                                    <button id='profile-btn' class='ui icon white circular button' style='position: absolute; color: ".$site->PrimaryColor."; bottom: 0px; right: 0px;' 
                                                        onclick=\"getElement('profile-img-inp').click()\">
                                                        <i class='pencil icon'></i>
                                                    </button>
                                                </div>
                                                <h3 style='font-family: ".$site->SecondaryFont.";'>".$customer->Name." ".$customer->Surname."</h4>
                                                <h6 style='font-family: ".$site->SecondaryFont.";'>".$customer->Guestid."</h6>
                                            </div>
                                            <div>
                                                <div class='w3-row'>
                                                    <div class='w3-col l6 m6 s6'>
                                                        <div class='align-c pad-3' style='border: 1px solid lightgray;'>
                                                            <h1 style='font-family: ".$site->BoldFont."; color: dimgray;'>0</h1>
                                                            <h6 style='font-family: ".$site->SecondaryFont.";'>Lodging</h6>
                                                        </div>
                                                    </div>
                                                    <div class='w3-col l6 m6 s6'>
                                                        <div class='align-c pad-3' style='border: 1px solid lightgray;'>
                                                            <h1 style='font-family: ".$site->BoldFont."; color: dimgray;'>0</h1>
                                                            <h6 style='font-family: ".$site->SecondaryFont.";'>Food Orders</h6>
                                                        </div>
                                                    </div>
                                                    <div class='w3-col l6 m6 s6'>
                                                        <div class='align-c pad-3' style='border: 1px solid lightgray;'>
                                                            <h1 style='font-family: ".$site->BoldFont."; color: dimgray;'>0</h1>
                                                            <h6 style='font-family: ".$site->SecondaryFont.";'>Drinks orders</h6>
                                                        </div>
                                                    </div>
                                                    <div class='w3-col l6 m6 s6'>
                                                        <div class='align-c pad-3' style='border: 1px solid lightgray;'>
                                                            <h1 style='font-family: ".$site->BoldFont."; color: dimgray;'>0</h1>
                                                            <h6 style='font-family: ".$site->SecondaryFont.";'>Pastries Order</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='w3-col l8 m8 s12'>
                                        <div>
                                            <div class='pad-2 curve w3-card'>
                                                <div>";
                                                    if($site->Customerselfdatamgt)
                                                    {
                                                        $ret->Content .="
                                                            <button id='profile-edit-btn' class='ui circular button' style='background-color: ".$site->PrimaryColor."; 
                                                            color: white; font-family: ".$site->BoldFont.";' onclick='editProfile(this)'>
                                                                <i class='pencil icon'></i> Edit Profile
                                                            </button>";
                                                    }
                                                    else
                                                    {
                                                        $ret->Content .= "<div class='ui message'></div>";
                                                    }

                                                    $ret->Content .="
                                                </div>
                                                <hr/>
                                                <table class='ui very basic no-line table'>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='user circle icon' style='color: ".$site->SecondaryColor.";'></i> Name
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='name' class='profile-input profile-edit-con' type='text' placeholder='Name' value='".$customer->Name."' style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='user icon' style='color: ".$site->SecondaryColor.";'></i> Surname
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='sname' class='profile-input profile-edit-con' type='text' placeholder='Surname' value='".$customer->Surname."' style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='barcode icon' style='color: ".$site->SecondaryColor.";'></i> Guest ID
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input class='profile-input' type='text' placeholder='Guest ID' value='".$customer->Guestid."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='mobile icon' style='color: ".$site->SecondaryColor.";'></i> Phone
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input class='profile-input' type='text' placeholder='Phone number' value='".$customer->Phone."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='at icon' style='color: ".$site->SecondaryColor.";'></i> Email
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input class='profile-input' type='text' placeholder='Email address' value='".$customer->Email."' style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='venus mars icon' style='color: ".$site->SecondaryColor.";'></i> Gender
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='gender' class='profile-input' type='text' placeholder='Gender' value='".$customer->Sex."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: ".$site->BoldFont.";'>
                                                            <i class='calendar alternate icon' style='color: ".$site->SecondaryColor.";'></i> Date of birth
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='dob' data-toggle='datepicker' class='profile-input profile-edit-con' type='text' placeholder='Date of birth' value='".date("m/d/Y", $customer->Dateofbirth->getValue())."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>";

                                                if($site->Guestformtype != "SIMPLE")
                                                {
                                                    $ret->Content .= "
                                                    <tr>
                                                        <td style='font-family: " . $site->BoldFont . ";'>
                                                            <i class='map marker icon' style='color: " . $site->SecondaryColor . ";'></i> City
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='city' class='profile-input profile-edit-con' type='text' placeholder='City of origin' value='" . $customer->City . "' style='font-family: " . $site->SecondaryFont . ";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: " . $site->BoldFont . ";'>
                                                            <i class='map marker icon' style='color: " . $site->SecondaryColor . ";'></i> State
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='state' class='profile-input profile-edit-con' type='text' placeholder='State of origin' value='" . $customer->State . "' style='font-family: " . $site->SecondaryFont . ";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: " . $site->BoldFont . ";'>
                                                            <i class='map icon' style='color: " . $site->SecondaryColor . ";'></i> Country
                                                        </td>
                                                        <td>
                                                            <select id='country' class='ui search profile-input dropdown'>
                                                                <option>".($customer->Country == "" ? "Select country" : $customer->Country)."</option>";
                                                                $countries = Country::GroupInitialize(null);
                                                                for($i = 0; $i < count($countries); $i++)
                                                                {
                                                                    $ret->Content .= "<option>".$countries[$i]->Name."</option>";
                                                                }
                                                            $ret->Content .= "
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-family: " . $site->BoldFont . ";'>
                                                            <i class='map icon' style='color: " . $site->SecondaryColor . ";'></i> Street
                                                        </td>
                                                        <td>
                                                            <div class='ui input'>
                                                                <input id='street' class='profile-input profile-edit-con' type='text' placeholder='House number avenu etc' value='" . $customer->Street . "' style='font-family: " . $site->SecondaryFont . ";' disabled/>
                                                            </div>
                                                        </td>
                                                    </tr>";
                                                }
                                                $ret->Content .="
                                                </table>
                                            </div>";

                                                if($site->Guestformtype == "DETAILED")
                                                {
                                                    $ret->Content .= "
                                                        <div class='pad-2 curve w3-card' style='margin-top: 10px;'>
                                                            <table class='ui very basic no-line table'>
                                                                <tr>
                                                                    <td style='font-family: ".$site->BoldFont.";'>
                                                                        <i class='suitcase icon' style='color: ".$site->SecondaryColor.";'></i> Occupation
                                                                    </td>
                                                                    <td>
                                                                        <div class='ui input'>
                                                                            <input id='occupation' class='profile-input profile-edit-con' type='text' placeholder='Your occupation' value='".$customer->Occupation."' style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-family: ".$site->BoldFont.";'>
                                                                        <i class='id badge icon' style='color: ".$site->SecondaryColor.";'></i> ID Type
                                                                    </td>
                                                                    <td>
                                                                        <div class='ui input'>
                                                                            <input class='profile-input' type='text' placeholder='Id type' value='".$customer->Idtype."' style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-family: ".$site->BoldFont.";'>
                                                                        <i class='id badge icon' style='color: ".$site->SecondaryColor.";'></i> ID Number
                                                                    </td>
                                                                    <td>
                                                                        <div class='ui input'>
                                                                            <input class='profile-input' type='text' placeholder='Id number' value='".$customer->Idnumber."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-family: ".$site->BoldFont.";'>
                                                                        <i class='user circle icon' style='color: ".$site->SecondaryColor.";'></i> Next of kin name
                                                                    </td>
                                                                    <td>
                                                                        <div class='ui input'>
                                                                            <input id='kin-name' class='profile-input profile-edit-con' type='text' placeholder='' value='".$customer->Kinname."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-family: ".$site->BoldFont.";'>
                                                                        <i class='map marker icon' style='color: ".$site->SecondaryColor.";'></i> Next of kin address
                                                                    </td>
                                                                    <td>
                                                                        <div class='ui input'>
                                                                            <input id='kin-address' class='profile-input profile-edit-con' type='text' placeholder='' value='".$customer->Kinaddress."'  style='font-family: ".$site->SecondaryFont.";' disabled/>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>";
                                                }

                                            $ret->Content .= "
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
