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
                    <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/pulse.css'/>
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
                        "<div id='reservations-con' class='l-width-8' style='margin: auto;'>
                        <div class='l-margin-t-5 s-margin-t-1 s-pad-1'>
                            <h4 style='font-weight: bold; font-family: ".$site->TextFont."'>
                            (<span id='reservation-count-con'>".$cart->Contentcount()."</span>) Reservations
                            </h4>
                        </div>
                        <div class='w3-row l-margin-t-4 s-margin-t-1'>
                            <div class='w3-col l8 m8 s12'>
                                <div id='items-main-con' class='l-width-xl w3-card curve s-no-curve' style='background-color: rgb(252,252,252);'>
                                <div class='w3-row' style='margin-top: 10px; margin-bottom: 10px;'>
                                    <div class='w3-col l7 m7 s7'>
                                        <h6 style='font-weight: bold; margin-left: 10px;'>Room / Item</h6>
                                    </div>
                                    <div class='w3-col l2 m2 s2'>
                                        <h6 style='font-weight: bold;'>Guests / QTY</h6>
                                    </div>
                                    <div class='w3-col l1 m1 s1 align-r'>
                                        <h6 style='font-weight: bold;'>Total</h6>
                                    </div>
                                </div>";

                                for($i = 0; $i < count($items); $i++)
                                {
                                    if($items[$i]->Type == "room_order")
                                    {
                                        $ret->Content .=
                                        "<div id='item-".$items[$i]->Id."-con' class='l-pad-1 s-pad-2 widget'  style='background-color: white;
                                            border-bottom: 1px solid whitesmoke; border-radius: 0px 0px 4px 4px;'>
                                            <div class='w3-row'>
                                                <div class='w3-col l2 m2 s3'>
                                                    <div>
                                                        <img src='".Router::ResolvePath("files/".$items[$i]->Roomcategory->Images[0], $path)."' style='width: 100%;'/></h5>
                                                    </div>
                                                </div>
                                                <div class='w3-col l5 m5 s9'>
                                                    <div class='l-pad-1'>
                                                        <h5 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'><span style='color: ".$site->PrimaryColor.";'>".
                                                            $items[$i]->Roomcategory->Name
                                                        ."</span>&nbsp;&nbsp;&nbsp;<small>
                                                        <span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span>".
                                                        number_format($items[$i]->Roomcategory->Price, 2)." / Night</small></h5>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>Occupancy: ".$items[$i]->Roomcategory->Baseoccupancy."</small>
                                                        </h6>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>Extra person price: <span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span>".
                                                            number_format($items[$i]->Roomcategory->Extraguestprice, 2)."</small>
                                                        </h6>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'><small>
                                                            <span id='".$items[$i]->Id."-start-date' order-id='".$items[$i]->Id."'  data-toggle='periodadjust' style='color: ".$site->PrimaryColor."; cursor: pointer;' onChange='alert()'>".
                                                            $items[$i]->Checkindate->Month."/".$items[$i]->Checkindate->Day."/".$items[$i]->Checkindate->Year
                                                            ."</span>&nbsp;&nbsp;&nbsp;<span>-</span>&nbsp;&nbsp;&nbsp;
                                                            <span id='".$items[$i]->Id."-stop-date' order-id='".$items[$i]->Id."' data-toggle='periodadjust' style='color: ".$site->PrimaryColor."; cursor: pointer;'>".
                                                            $items[$i]->Checkoutdate->Month."/".$items[$i]->Checkoutdate->Day."/".$items[$i]->Checkoutdate->Year
                                                        ."</span></small>
                                                        </h6>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small><span id='".$items[$i]->Id."-nights'>".Roomorder::Days($items[$i])."</span> night(s)</small>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s5'>
                                                    <div>
                                                        <div class=''  style='margin-top: 20px;'>
                                                            <label style='color: silver;' class='l-hide'>Guest(s): </label>
                                                            <input id='".$items[$i]->Id."-guest-count' style='border: none; background-color: transparent; max-width: 50px;' 
                                                            type='number' min='1' value='".$items[$i]->Guestcount."' onchange=\"changeBookingDetails('".$items[$i]->Id."')\"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l3 m3 s6 align-r'>
                                                    <div>
                                                        <div class='pad-1'>
                                                            <h6 style='margin-top: 10px; font-family: ".$site->SecondaryFont."; font-weight: bold;'>
                                                                <span style='font-family: arial;'>".
                                                                $subscriber->Currency->Symbol."</span> <span id='".$items[$i]->Id."-order-total'>".
                                                                number_format((doubleval($items[$i]->Total()) + doubleval($items[$i]->CalcTaxes())), 2)."</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s1 l-align-c s-align-r'>
                                                    <div>
                                                        <div class=''>
                                                            <h6 style='margin-top: 20px;'>
                                                                <i id='item-".$items[$i]->Id."-del-btn' class='trash red icon' 
                                                                style='cursor: pointer;' onclick=\"removeItem('".$items[$i]->Id."')\"></i>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }

                                    if($items[$i]->Type == "food_order")
                                    {
                                        $ret->Content .=
                                            "<div id='item-".$items[$i]->Id."-con' class='l-pad-1 s-pad-2 widget'  style='background-color: white;
                                            border-bottom: 1px solid whitesmoke; border-radius: 0px 0px 4px 4px;'>
                                            <div class='w3-row'>
                                                <div class='w3-col l2 m2 s3'>
                                                    <div>
                                                        <img src='".Router::ResolvePath("files/".(count($items[$i]->Food->Images) > 0 ? $items[$i]->Food->Images[0] : ""), $path)."' style='width: 100%;'/></h5>
                                                    </div>
                                                </div>
                                                <div class='w3-col l5 m5 s9'>
                                                    <div class='l-pad-1'>
                                                        <h5 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'><span style='color: ".$site->PrimaryColor.";'>".
                                                            $items[$i]->Food->Name
                                                            ."</span>&nbsp;&nbsp;&nbsp;<small>
                                                        <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span>".
                                                        number_format($items[$i]->Food->Price, 2)."</small></h5>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>served: ".($items[$i]->Immediate ? "Now" : $items[$i]->Orderdate->Month."/".$items[$i]->Orderdate->Day."/".$items[$i]->Orderdate->Year." at ".
                                                            ($items[$i]->Orderhour < 10 ? "0".$items[$i]->Orderhour : $items[$i]->Orderhour).":".($items[$i]->Ordermin < 10 ? "0".$items[$i]->Ordermin : $items[$i]->Ordermin).$items[$i]->Ordergmt)."</small>
                                                        </h6>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>Tax: <span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span>".
                                                            number_format($items[$i]->Food->Tax, 2)."</small>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s5'>
                                                    <div>
                                                        <div class=''  style='margin-top: 20px;'>
                                                            <label style='color: silver;' class='l-hide'>Quantity: </label>
                                                            <input id='".$items[$i]->Id."-quantity' style='border: none; background-color: transparent; max-width: 50px;' 
                                                            type='number' min='1' value='".$items[$i]->Quantity."' onchange=\"changeFoodQuantity('".$items[$i]->Id."')\"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l3 m3 s6 align-r'>
                                                    <div>
                                                        <div class='pad-1'>
                                                            <h6 style='margin-top: 10px; font-family: ".$site->SecondaryFont."; font-weight: bold;'>
                                                                <span style='font-family: arial;'>".
                                                                $subscriber->Currency->Symbol."</span>
                                                                <span id='".$items[$i]->Id."-order-total'>".
                                                                number_format((doubleval($items[$i]->Total()) + doubleval($items[$i]->CalcTaxes())), 2)."</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s1 l-align-c s-align-r'>
                                                    <div>
                                                        <div class=''>
                                                            <h6 style='margin-top: 20px;'>
                                                                <i id='item-".$items[$i]->Id."-del-btn' class='trash red icon' 
                                                                style='cursor: pointer;' onclick=\"removeItem('".$items[$i]->Id."')\"></i>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }

                                    if($items[$i]->Type == "drink_order")
                                    {
                                        $ret->Content .=
                                            "<div id='item-".$items[$i]->Id."-con' class='l-pad-1 s-pad-2 widget'  style='background-color: white;
                                            border-bottom: 1px solid whitesmoke; border-radius: 0px 0px 4px 4px;'>
                                            <div class='w3-row'>
                                                <div class='w3-col l2 m2 s3'>
                                                    <div>
                                                        <img src='".Router::ResolvePath("files/".(count($items[$i]->Drink->Images) > 0 ? $items[$i]->Drink->Images[0] : ""), $path)."' style='width: 100%;'/></h5>
                                                    </div>
                                                </div>
                                                <div class='w3-col l5 m5 s9'>
                                                    <div class='l-pad-1'>
                                                        <h5 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'><span style='color: ".$site->PrimaryColor.";'>".
                                                            $items[$i]->Drink->Name
                                                            ."</span>&nbsp;&nbsp;&nbsp;<small>
                                                        <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span>".
                                                        number_format($items[$i]->Drink->Price, 2)."</small></h5>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>served: ".($items[$i]->Immediate ? "Now" : $items[$i]->Orderdate->Month."/".$items[$i]->Orderdate->Day."/".$items[$i]->Orderdate->Year." at ".
                                                            ($items[$i]->Orderhour < 10 ? "0".$items[$i]->Orderhour : $items[$i]->Orderhour).":".($items[$i]->Ordermin < 10 ? "0".$items[$i]->Ordermin : $items[$i]->Ordermin).$items[$i]->Ordergmt)."</small>
                                                        </h6>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>Tax: <span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span>".
                                                            number_format($items[$i]->Drink->Tax, 2)."</small>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s5'>
                                                    <div>
                                                        <div class=''  style='margin-top: 20px;'>
                                                            <label style='color: silver;' class='l-hide'>Quantity: </label>
                                                            <input id='".$items[$i]->Id."-quantity' style='border: none; background-color: transparent; max-width: 50px;' 
                                                            type='number' min='1' value='".$items[$i]->Quantity."' onchange=\"changeDrinkQuantity('".$items[$i]->Id."')\"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l3 m3 s6 align-r'>
                                                    <div>
                                                        <div class='pad-1'>
                                                            <h6 style='margin-top: 10px; font-family: ".$site->SecondaryFont."; font-weight: bold;'>
                                                                <span style='font-family: arial;'>".
                                                                $subscriber->Currency->Symbol."</span>
                                                                <span id='".$items[$i]->Id."-order-total'>".
                                                                number_format((doubleval($items[$i]->Total()) + doubleval($items[$i]->CalcTaxes())), 2)."</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s1 l-align-c s-align-r'>
                                                    <div>
                                                        <div class=''>
                                                            <h6 style='margin-top: 20px;'>
                                                                <i id='item-".$items[$i]->Id."-del-btn' class='trash red icon' 
                                                                style='cursor: pointer;' onclick=\"removeItem('".$items[$i]->Id."')\"></i>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }

                                    if($items[$i]->Type == "pastry_order")
                                    {
                                        $ret->Content .=
                                            "<div id='item-".$items[$i]->Id."-con' class='l-pad-1 s-pad-2 widget'  style='background-color: white;
                                            border-bottom: 1px solid whitesmoke; border-radius: 0px 0px 4px 4px;'>
                                            <div class='w3-row'>
                                                <div class='w3-col l2 m2 s3'>
                                                    <div>
                                                        <img src='".Router::ResolvePath("files/".(count($items[$i]->Pastry->Images) > 0 ? $items[$i]->Pastry->Images[0] : ""), $path)."' style='width: 100%;'/></h5>
                                                    </div>
                                                </div>
                                                <div class='w3-col l5 m5 s9'>
                                                    <div class='l-pad-1'>
                                                        <h5 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'><span style='color: ".$site->PrimaryColor.";'>".
                                                        $items[$i]->Pastry->Name
                                                        ."</span>&nbsp;&nbsp;&nbsp;<small>
                                                        <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span>".
                                                        number_format($items[$i]->Pastry->Price, 2)."</small></h5>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>served: ".($items[$i]->Immediate ? "Now" : $items[$i]->Orderdate->Month."/".$items[$i]->Orderdate->Day."/".$items[$i]->Orderdate->Year." at ".
                                                            ($items[$i]->Orderhour < 10 ? "0".$items[$i]->Orderhour : $items[$i]->Orderhour).":".($items[$i]->Ordermin < 10 ? "0".$items[$i]->Ordermin : $items[$i]->Ordermin).$items[$i]->Ordergmt)."</small>
                                                        </h6>
                                                        <h6 style='font-family: ".$site->TextFont."; font-weight: bold; margin: 2px;'>
                                                            <small>Tax: <span style='font-family: Arial;'>".$subscriber->Currency->Symbol."</span>".
                                                            number_format($items[$i]->Pastry->Tax, 2)."</small>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s5'>
                                                    <div>
                                                        <div class=''  style='margin-top: 20px;'>
                                                            <label style='color: silver;' class='l-hide'>Quantity: </label>
                                                            <input id='".$items[$i]->Id."-quantity' style='border: none; background-color: transparent; max-width: 50px;' 
                                                            type='number' min='1' value='".$items[$i]->Quantity."' onchange=\"changePastryQuantity('".$items[$i]->Id."')\"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l3 m3 s6 align-r'>
                                                    <div>
                                                        <div class='pad-1'>
                                                            <h6 style='margin-top: 10px; font-family: ".$site->SecondaryFont."; font-weight: bold;'>
                                                                <span style='font-family: arial;'>".
                                                                $subscriber->Currency->Symbol."</span>
                                                                <span id='".$items[$i]->Id."-order-total'>".
                                                                number_format((doubleval($items[$i]->Total()) + doubleval($items[$i]->CalcTaxes())), 2)."</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='w3-col l1 m1 s1 l-align-c s-align-r'>
                                                    <div>
                                                        <div class=''>
                                                            <h6 style='margin-top: 20px;'>
                                                                <i id='item-".$items[$i]->Id."-del-btn' class='trash red icon' 
                                                                style='cursor: pointer;' onclick=\"removeItem('".$items[$i]->Id."')\"></i>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                }

                                $ret->Content .="
                                </div>
                            </div>
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
                                                $ret->Content .="
                                                <div class='pad-1' style='padding-top: 20px; padding-bottom: 20px;'>
                                                    <h6 style='font-family: ".$site->TextFont."; font-weight: bold;'>Have a coupon?</h6>
                                                    <div class='ui fluid action input'>
                                                        <input id='coupon-code' class='wix-textbox' type='text' placeholder='Coupon code'/>
                                                        <button id='coupon-btn' class='ui button' style='color: white; background-color: ".
                                                        $site->PrimaryColor."; font-weight: normal;' onclick='applyCoupon()'>Apply</button>
                                                    </div>
                                                    <div id='coupon-con' style='padding-top: 10px;'>";


                                                $coupons = $list->Getcouponlist();

                                                for($c = 0; $c < count($coupons);  $c++)
                                                {
                                                    $ret->Content .= "<div id='".$coupons[$c]->Id."-con' class='w3-row' style=''>
                                                        <div class='w3-col l6 m6 s6'>
                                                        <h6 style='font-family: ".$site->SecondaryFont."; color: ".$site->PrimaryColor.";'>".
                                                        $coupons[$c]->Title."</h6></div>
                                                        <div class='w3-col l4 m4 s4 align-r'>
                                                        <h6 style='font-family: ".$site->SecondaryFont."; color: ".$site->PrimaryColor.";'>".
                                                        ($coupons[$c]->Bypercentage ? number_format($coupons[$c]->Value)."%" :
                                                            "<span style='font-family: Lato;'>".
                                                            $subscriber->Currency->Symbol.number_format($coupons[$c]->Value)."</span>").
                                                        "</h6>
                                                        </div>
                                                        <div class='w3-col l2 m2 s2 align-r'>
                                                        <h6>
                                                        <i id='".$coupons[$c]->Id."-btn' class='times red icon' style='cursor: pointer;' 
                                                        title='remove coupon' onclick=\"removeCoupon('".$coupons[$c]->Id."')\"></i></h6>
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
                                            <div class='ww3-row' style='margin-top: 3px; ".(!$modules->Discount ? "display: none;" : "")."'>
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
                                                "<div class='ui left labeled button s-margin-t-1 s-margin-b-2' tabindex='0' onclick='ShowLogin()'>
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
                                            if($list->Hasroom())
                                            {
                                                $ret->Content .=
                                                    "<a href='" . Router::ResolvePath('order-detail', $path) . "'>
                                                    <div class='ui left labeled button s-margin-t-1 s-margin-b-2' tabindex='0'>
                                                        <label class='ui basic right pointing label' 
                                                        style='border: 1px solid " . $site->PrimaryColor . "; color: " . $site->PrimaryColor . ";'>
                                                            <i class='cart icon'></i>
                                                        </label>
                                                        <div class='ui button' style='background-color: " . $site->PrimaryColor . "; color: white; font-weight: normal;'>
                                                            Proceed
                                                        </div>
                                                    </div>
                                                </a>";
                                            }
                                            else
                                            {

                                                if($site->Payonline)
                                                {
                                                    $ret->Content .=
                                                        "<h6 style='font-family: ".$site->TextFont."; color: dimgray;'>How would you like to pay</h6>
                                                    <div class='w3-row'>
                                                        <div class='w3-col l7 m7 s7'>
                                                            <label>
                                                                <input id='pay-order-inroom' name='p-method' class='with-gap' type='radio' checked/>
                                                                <span>Pay cash in the room</span>
                                                            </label>
                                                        </div>
                                                        <div class='w3-col l5 m5 s5'>
                                                            <label>
                                                                <input id='pay-order-online' name='p-method' class='with-gap' type='radio'/>
                                                                <span>Pay online now</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <div id='order-btn' class='ui left labeled button s-margin-t-1 s-margin-b-2' tabindex='0' onclick='processOrderNow()'>
                                                        <label class='ui basic right pointing label' 
                                                        style='border: 1px solid " . $site->PrimaryColor . "; color: " . $site->PrimaryColor . ";'>
                                                            <i id='order-btn-icon' class='cart icon'></i>
                                                        </label>
                                                        <div id='order-btn-text' class='ui button' style='background-color: " . $site->PrimaryColor . "; 
                                                            color: white; font-weight: normal;'>
                                                            Send order
                                                        </div>
                                                    </div>";
                                                }
                                                else
                                                {
                                                    $ret->Content .=
                                                        "<h6 style='font-family: ".$site->SecondaryFont."; color: dimgray; line-height: 160%;'>
                                                            You'll pay cash when the order is delivered to your room
                                                        </h6>
                                                        <div class='ui left labeled button s-margin-t-1 s-margin-b-2' tabindex='0'>
                                                            <label class='ui basic right pointing label' 
                                                            style='border: 1px solid " . $site->PrimaryColor . "; color: " . $site->PrimaryColor . ";'>
                                                                <i class='cart icon'></i>
                                                            </label>
                                                            <div class='ui button' style='background-color: " . $site->PrimaryColor . "; color: white; font-weight: normal;'>
                                                                Send order
                                                            </div>
                                                        </div>";
                                                }
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