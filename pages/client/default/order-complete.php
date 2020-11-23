<?php

if(!$modules->Booking)
{
    require_once ("addons/404.php");
}
else
{
    $integrations = new Integration($subscriber);

    $ret->Content = "<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    
                    <meta name='robots' content='noindex, nofollow'/>
                    
                    <title> My reservations | ".$subscriber->BusinessName."</title>
                    
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
                    
                    <script type='application/javascript' src='".$host."/cdn/js/pay.js'></script>
                    
                    <script src='https://js.paystack.co/v1/inline.js'></script>
                </head>
                <body style='background-color: whitesmoke;'>";

                    $ret->Content .= "<div style='background-color: white;'>";
                    require("addons/header.php");
                    $ret->Content .= "</div>";


                    $cart = new Cart($subscriber);
                    $list = Discount::process($subscriber, $cart->GetOrderlist());

                    $total = 0;
                    $subtotal = 0;
                    $discount = 0;
                    $taxes = 0;

                    if($cart->Contentcount() > 0)
                    {
                        $items = $cart->Content();

                        $subtotal = $list->GetTotal();
                        $discount = $list->TotalDiscount();
                        $taxes = $list->GetTax();
                        $total = (($taxes + $subtotal) - $discount);

                        $ret->Content .=
                            "<div class='l-width-8' style='margin: auto;'>
                        <div class='l-margin-t-5 s-margin-t-1 s-pad-1'>
                            <h4 style='font-weight: bold; font-family: ".$site->TextFont."'>
                                <i class='user circle icon'></i> Guest Information
                            </h4>
                        </div>
                        <div class='w3-row l-margin-t-4 s-margin-t-1'>
                            <div class='w3-col l8 m8 s12'>
                                <div id='items-main-con' class='l-width-xl w3-card curve s-no-curve' style='background-color: rgb(252,252,252);'>
                                <div class='pad-1' style='margin-top: 10px; margin-bottom: 10px;'>
                                    <h6 style='font-weight: bold; margin-left: 10px;'>Guest info</h6>
                                </div>
                                
                                <div class='pad-1' style='background-color: white; '>
                                    <br/>
                                    <div class='w3-row'>
                                        <div class='w3-col l6 m6 s12'>
                                            <div class='ui l-width-xl fluid large left icon input ".((!$site->Customerselfdatamgt && ($customer->Name != "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                <i class='user circle icon' style='color: ".$site->PrimaryColor."'></i>
                                                <input id='reservation-name' class='wix-textbox' type='text' value='".$customer->Name."' placeholder='Name' style='font-family: ".$site->SecondaryFont.";'/>
                                            </div>
                                        </div>
                                        <div class='w3-col l6 m6 s12'>
                                            <div class='ui fluid large input ".((!$site->Customerselfdatamgt && ($customer->Surname != "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                <input id='reservation-sname' class='wix-textbox' type='text' value='".$customer->Surname."' placeholder='Surname' style='font-family: ".$site->SecondaryFont.";'/>
                                            </div>
                                        </div>
                                    </div><br/>
                                    
                                    <div class='w3-row'>
                                        <div class='w3-col l8 m8 s12'>
                                            <div class='ui l-width-xl fluid large left icon input ".((!$site->Customerselfdatamgt && ($customer->Email != "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                <i class='at icon' style='color: ".$site->PrimaryColor."'></i>
                                                <input id='reservation-email' class='wix-textbox' type='text' value='".$customer->Email."' placeholder='Email address' style='font-family: ".$site->SecondaryFont.";' disabled/>
                                            </div>
                                        </div>
                                        <div class='w3-col l4 m4 s12'>
                                            <div class='ui fluid large left icon input ".((!$site->Customerselfdatamgt && ($customer->Phone != "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                <i class='mobile icon' style='color: ".$site->PrimaryColor."'></i>
                                                <input id='reservation-phone' class='wix-textbox' type='text' value='".$customer->Phone."' placeholder='Phone number' style='font-family: ".$site->SecondaryFont.";'/>
                                            </div>
                                        </div>
                                    </div><br/>
                                    
                                    <div class='w3-row'>
                                        <div class='w3-col l4 m6 s12'>
                                            <label style='margin-top: 5px;'>
                                                <input class='with-gap' type='radio' name='gender' ".((!$site->Customerselfdatamgt && ($customer->Name!= "")) ? "disabled" : "")." checked/>
                                                <span>Male</span>
                                            </label>
                                        </div>
                                        <div class='w3-col l8 m6 s12'>
                                            <label style='margin-top: 5px;'>
                                                <input id='female-check' class='with-gap' type='radio' name='gender' ".((!$site->Customerselfdatamgt && ($customer->Name!= "")) ? "disabled" : "")."/>
                                                <span>Female</span>
                                            </label>
                                        </div>
                                    </div><br/>";


                                    if($site->Customersaddress)
                                    {
                                        $country = Country::GroupInitialize(null);

                                        $options = "";
                                        for($i = 0; $i < count($country); $i++)
                                        {
                                            $options .= "<option>".$country[$i]->Name."</option>";
                                        }


                                        $ret->Content .= "
                                        <div class='w3-row'>
                                            <div class='w3-col l7 m7 s12'>
                                                <div class='l-width-xl' style='margin-top: 5px;'>
                                                    <select id='reservation-country' class='ui search big-dropdown fluid dropdown ".((!$site->Customerselfdatamgt && ($customer->Country != "")) ? "disabled" : "")."'>
                                                        ".($customer->Country == "" ? "<option value=''>Select country</option>" : "<option>".$customer->Country."</option>")."
                                                        ".$options."
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='w3-col l5 m5 s12'>
                                                <div class='ui fluid large left icon input ".((!$site->Customerselfdatamgt && ($customer->State != "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                    <i class='map marker icon' style='color: ".$site->PrimaryColor."'></i>
                                                    <input id='reservation-state' class='wix-textbox' type='text' value='".$customer->State."' placeholder='State' style='font-family: ".$site->SecondaryFont.";'/>
                                                </div>
                                            </div>
                                        </div><br/>
                                        
                                        <div class='w3-row'>
                                            <div class='w3-col l4 m4 s12'>
                                                <div class='ui l-width-xl large left icon fluid input ".((!$site->Customerselfdatamgt && ($customer->City!= "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                    <i class='map marker icon' style='color: ".$site->PrimaryColor."'></i>
                                                    <input id='reservation-city' class='wix-textbox' type='text' value='".$customer->City."' placeholder='City' style='font-family: ".$site->SecondaryFont.";'/>
                                                </div>
                                            </div>
                                            <div class='w3-col l8 m8 s12'>
                                                <div class='ui left icon large fluid input ".((!$site->Customerselfdatamgt && ($customer->Street != "")) ? "disabled" : "")."' style='margin-top: 5px;'>
                                                    <i class='map icon' style='color: ".$site->PrimaryColor."'></i>
                                                    <input id='reservation-street' class='wix-textbox' type='text' value='".$customer->Street."' placeholder='Street address' style='font-family: ".$site->SecondaryFont.";'/>
                                                </div>
                                            </div>
                                        </div><br/>";
                                    }


                                    $ret->Content .="
                                  
                                    <div class='ui form'>
                                        <div class='field'>
                                            <textarea id='reservation-request' placeholder='Special request' class='wix-textbox' rows='2'></textarea>
                                        </div>
                                    </div>
                                    
                                </div>
                                </div>
                                </div>";




                        $ret->Content .="
                            <div class='w3-col l4 m4 s12'>
                                <div class='w3-card curve s-no-curve'>
                                    <div class='pad-1' style='background-color: rgb(252,252,252); 
                                        border-radius: 4px 4px 0px 0px;'>
                                        <h6 style='font-family: ".$site->TextFont."; 
                                        font-weight: bold;'>Reservation Summary</h6>
                                    </div>
                                    <div style='background-color: white; 
                                        border-radius: 0px 0px 4px 4px;'>";


                                        if($modules->Discount)
                                        {
                                            $ret->Content .= "
                                            <div class='pad-1' style='padding-top: 20px; padding-bottom: 20px;'>
                                                <h6 style='font-family: ".$site->TextFont."; font-weight: bold;'>Added coupons</h6>
                                                <div id='coupon-con'>
                                                ".(count($list->Couponlist) == 0 ?
                                                        "<h6 class='sleak' style='color: dimgray;'>
                                                    No coupons have been applied
                                                </h6>" :"");

                                                $coupons = $list->Getcouponlist();

                                                for($c = 0; $c < count($coupons);  $c++)
                                                {
                                                    $ret->Content .= "<div id='".$coupons[$c]->Id."-con' class='w3-row' style=''>
                                                        <div class='w3-col l8 m8 s8'>
                                                        <h6 style='font-family: ".$site->SecondaryFont."; color: ".$site->PrimaryColor.";'>".
                                                        $coupons[$c]->Title."</h6></div>
                                                        <div class='w3-col l4 m4 s4 align-r'>
                                                        <h6 style='font-family: ".$site->SecondaryFont."; color: ".$site->PrimaryColor.";'>".
                                                        ($coupons[$c]->Bypercentage ? number_format($coupons[$c]->Value)."%" :
                                                            "<span style='font-family: Lato;'>".
                                                            $subscriber->Currency->Symbol.number_format($coupons[$c]->Value)."</span>").
                                                        "</h6>
                                                        </div>
                                                        </div>";
                                                }

                                                $ret->Content .= "
                                                </div>
                                            </div>";
                                        }


                                      $ret->Content .= "
                                        <div class='pad-1' style='".($modules->Discount ? "background-color: rgb(252, 252, 252);" : "background: white;")."'>
                                            <div class='w3-row'>
                                                <div class='w3-col l5 m5 s5'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <small>Subtotal</small>
                                                    </h5>
                                                </div>
                                                <div class='w3-col l7 m7 s7 align-r'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <small><span style='font-family: arial;'>".$subscriber->Currency->Symbol."</span> 
                                                        <span id='subtotal-main-con'>".number_format($subtotal, 2)."</span></small>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class='w3-row' style='margin-top: 3px;'>
                                                <div class='w3-col l5 m5 s5'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <small>Taxes</small>
                                                    </h5>
                                                </div>
                                                <div class='w3-col l7 m7 s7 align-r'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <small><span style='font-family: arial;'>".$subscriber->Currency->Symbol."</span> 
                                                        <span id='taxes-main-con'>".number_format($taxes, 2)."</span></small>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class='ww3-row' style='margin-top: 3px; ".(!$modules->Discount ? "display: none; height: 0px;" : "")."'>
                                                <div class='w3-col l5 m5 s5'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <small>Discount</small>
                                                    </h5>
                                                </div>
                                                <div class='w3-col l7 m7 s7 align-r'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <small><span style='font-family: arial;'>".$subscriber->Currency->Symbol."</span> 
                                                        <span id='discount-main-con'>".number_format($discount, 2)."</span></small>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class='w3-row' style='margin-top: 35px;'>
                                                <div class='w3-col l5 m5 s5'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        Total
                                                    </h5>
                                                </div>
                                                <div class='w3-col l7 m7 s7 align-r'>
                                                    <h5 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                                        <span style='font-family: arial;'>".$subscriber->Currency->Symbol."</span> 
                                                        <span id='total-main-con'>".number_format($total, 2)."</span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='pad-1'>";

                                        if($customer->Id == "")
                                        {
                                            $ret->Content .=
                                                "<div class='ui left labeled fluid button s-margin-t-1 s-margin-b-2' tabindex='0' onclick='ShowLogin()'>
                                                    <a class='ui basic right pointing label' 
                                                    style='border: 1px solid ".$site->PrimaryColor."; color: ".$site->PrimaryColor.";'>
                                                        <i class='sign in icon'></i>
                                                    </a>
                                                    <div class='ui button' style='background-color: ".$site->PrimaryColor."; color: white; font-weight: normal;'>
                                                        Login / Signup
                                                    </div>
                                                </div>";
                                }
                                else
                                {
                                    $settings = new Site($subscriber);

                                    if($settings->Payonline == true)
                                    {
                                        $ret->Content .=
                                                "<div id='online-btn' class='ui left labeled button s-margin-t-1 s-margin-b-2' tabindex='0'>
                                                    <a class='ui basic right pointing label' 
                                                    style='border: 1px solid ".$site->PrimaryColor."; color: ".$site->PrimaryColor.";'>
                                                        <i class='credit card icon'></i>
                                                    </a>
                                                    <div class='ui button' style='background-color: ".$site->PrimaryColor."; color: white; font-weight: normal;'>
                                                        Pay now
                                                    </div>
                                                </div>";

                                        if($settings->Nopayreservation)
                                        {
                                            $ret->Content .=
                                                "<button id='at-hotel-btn' class='ui button' style='background-color: ".$site->PrimaryColor."; color: white; font-weight: normal;' onclick='payAtHotel(this)'>
                                                    Pay at the hotel
                                                </button>";
                                        }
                                    }
                                    else
                                    {
                                        $ret->Content .=
                                            "<h6 class='sleak' style='color: dimgray;'>
                                                Payment will be made at the hotel
                                            </h6>
                                            <div id='reserve-btn' class='ui left labeled fluid button s-margin-t-1 s-margin-b-2' tabindex='0' onclick='nopayreservation()'>
                                                <a class='ui basic right pointing label' 
                                                    style='border: 1px solid ".$site->PrimaryColor."; color: ".$site->PrimaryColor.";'>
                                                    <i id='reserve-btn-icon' class='check icon'></i>
                                                </a>
                                                <div id='reserve-btn-text' class='ui button' style='background-color: ".$site->PrimaryColor."; color: white; font-weight: normal;'>
                                                    Done
                                                </div>
                                            </div>";
                                    }
                                }


                                $ret->Content .="
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
    }
    else
    {
        $ret->Content .=
            "<div class='' style='margin-top: 170px; margin-bottom: 170px;'>
                            <div class='align-c'>
                                <img src='".$host."/cdn/images/icons/pastel/reservation.png'/>
                                <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                    You have no reservations yet
                                </h4>
                            </div>
                        </div>";
    }



    require("addons/footer.php");

    $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.= "
                </body>
            </html>";
}