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
            $reservations = Reservation::ByCustomer($subscriber, $customer);

            $ret->Content = "<!DOCTYPE html>
                <html>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                        
                        <title>My Reservation | " . $subscriber->BusinessName . "</title>
                        
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/mat.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/semantic.min.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/w3.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/css/space_app.css'/>
                        <link rel='stylesheet' type='text/css' href='" . $host . "/cdn/themes/default/css/page.css'/>";

                        require_once ("addons/link.php");

                        $ret->Content .="
                        <script type='application/javascript' src='" . $host . "/cdn/js/jquery.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/easing.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/semantic.min.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/functions.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/js/WixnitEncoder.js'></script>
                        <script type='application/javascript' src='" . $host . "/cdn/themes/default/js/page.js'></script>
                    </head>
                    <body>";
                    require("addons/header.php");

                    $ret->Content .= "
                        <div class='l-width-8' style='margin: auto;'>
                            <div class='l-margin-t-3 s-pad-1'>
                                <h5 style='color: dimgray; font-family: " . $site->BoldFont . ";'>
                                    <div class='icon-block' style='color: white; background-color: " . $site->PrimaryColor . ";'>
                                    <i class='bed icon'></i></div> My Reservations
                                </h5><hr>
                                <div class='ui breadcrumb'>
                                  <a href='" . Router::ResolvePath("home", $path) . "' class='section' 
                                  style='font-family: ".$site->SecondaryFont.";'>Home</a>
                                  <i class='right chevron icon divider'></i>
                                  <a href='" . Router::ResolvePath("account", $path) . "' class='section'
                                  style='font-family: ".$site->SecondaryFont.";'>My Account</a>
                                  <i class='right chevron icon divider'></i>
                                  <div class='section' style='color: black; 
                                  font-family: ".$site->SecondaryFont.";'>My Reservations</div>
                                </div>
        
        
                                <div class='margin-t-9 margin-b-9'>
                                    <div class='w3-row'>
                                        <div class='w3-col l2 m3 s12 s-hide'>
                                            <div class='ui vertical fluid tabular menu'>
                                                <a class='active item' style='font-family: ".$site->SecondaryFont.";'>
                                                    My reservations
                                                </a>
                                                <a href='".Router::ResolvePath('lodging-history', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    Lodging history
                                                </a>
                                                <a href='".Router::ResolvePath('order-history', $path)."'  class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    Order history
                                                </a>
                                                <a href='".Router::ResolvePath('profile', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    My profile
                                                </a>
                                                <a href='".Router::ResolvePath('password', $path)."' class='item' style='font-family: ".$site->SecondaryFont.";'>
                                                    Change password
                                                </a>
                                            </div>
                                        </div>
                                        <div class='w3-col l10 m9 s12'>
                                            <div  id='reservation-con' class='l-width-9' style='margin: auto;'>";

                                                $router = new Router($path);

                                                if(isset($router->Args[0]))
                                                {
                                                    $reservation = new Reservation($subscriber);
                                                    $reservation->Initialize($router->Args[0]);

                                                    if($reservation->Id != "")
                                                    {
                                                        $ret->Content .=
                                                            "<div class='w3-row'>
                                                                <div class='w3-col l1 m2 s2'>
                                                                    <img src='".$host."/cdn/images/icons/pastel/roomservice.png' style='height: 60px;'/>
                                                                </div>
                                                                <div class='w3-col l10 m10 s10'>
                                                                    <h3 class='' style='font-weight: normal; font-family: ".$site->TextFont."; margin-top: 20px;'>
                                                                        Reservation detail
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class='margin-t-3 margin-b-3'>
                                                                <div>
                                                                    <!--
                                                                    <button class='ui button' style='background-color: ".
                                                                        $site->PrimaryColor."; color: white;'>
                                                                        <i class='credit card alternate icon'></i> Pay Now
                                                                    </button>
                                                                    -->
                                                                </div>
                                                            </div>
                                                            
                                                            <div>
                                                                <div>
                                                                    <br/>";

                                                                    for($i = 0; $i < count($reservation->Roomreservation); $i++)
                                                                    {
                                                                        $ret->Content .=
                                                                            "<div class='w3-card-2 l-pad-2 s-pad-1 curve' style='margin-bottom: 10px;'>
                                                                                <h5 style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>".
                                                                                    $reservation->Roomreservation[$i]->Roomcategory->Name." Room
                                                                                </h5>
                                                                                <table class='ui very basic collapsed table'>
                                                                                    <tr>
                                                                                        <td>From</td>
                                                                                        <td>".date("D, d/M/Y", $reservation->Roomreservation[$i]->Checkin->getValue())."</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>To</td>
                                                                                        <td>".date("D, d/M/Y", $reservation->Roomreservation[$i]->Checkout->getValue())."</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Guests</td>
                                                                                        <td>".number_format( $reservation->Roomreservation[$i]->Guestcount)."</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>";
                                                                    }

                                                                    for($i = 0; $i < count($reservation->Foodreservation); $i++)
                                                                    {
                                                                        $ret->Content .=
                                                                            "<div class='w3-card-2 l-pad-2 s-pad-1 curve' style='margin-bottom: 10px;'>
                                                                                <h5 style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>".
                                                                                    $reservation->Foodreservation[$i]->Food->Name."
                                                                                </h5>
                                                                                <table class='ui very basic collapsed table'>
                                                                                    <tr>
                                                                                        <td>Served</td>
                                                                                        <td>".date("D, d/M/Y", $reservation->Foodreservation[$i]->Orderday->getValue())."
                                                                                            at ".$reservation->Foodreservation[$i]->Orderhour.":".
                                                                                            $reservation->Foodreservation[$i]->Ordermin." ".$reservation->Foodreservation[$i]->Ordergmt."
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Quantity</td>
                                                                                        <td>".number_format( $reservation->Foodreservation[$i]->Quantity)."</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>";
                                                                    }

                                                                    for($i = 0; $i < count($reservation->Drinkreservation); $i++)
                                                                    {
                                                                        $ret->Content .=
                                                                            "<div class='w3-card-2 l-pad-2 s-pad-1 curve' style='margin-bottom: 10px;'>
                                                                                <h5 style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>".
                                                                                    $reservation->Drinkreservation[$i]->Drink->Name."
                                                                                </h5>
                                                                                <table class='ui very basic collapsed table'>
                                                                                    <tr>
                                                                                        <td>Served</td>
                                                                                        <td>".date("D, d/M/Y", $reservation->Drinkreservation[$i]->Orderday->getValue())."
                                                                                            at ".$reservation->Drinkreservation[$i]->Orderhour.":".
                                                                                            $reservation->Drinkreservation[$i]->Ordermin." ".$reservation->Drinkreservation[$i]->Ordergmt."
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Quantity</td>
                                                                                        <td>".number_format( $reservation->Drinkreservation[$i]->Quantity)."</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>";
                                                                    }

                                                                    for($i = 0; $i < count($reservation->Pastryreservation); $i++)
                                                                    {
                                                                        $ret->Content .=
                                                                            "<div class='w3-card-2 l-pad-2 s-pad-1 curve' style='margin-bottom: 10px;'>
                                                                                <h5 style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>".
                                                                                    $reservation->Pastryreservation[$i]->Pastry->Name."
                                                                                </h5>
                                                                                <table class='ui very basic collapsed table'>
                                                                                    <tr>
                                                                                        <td>Served</td>
                                                                                        <td>".date("D, d/M/Y", $reservation->Pastryreservation[$i]->Orderday->getValue())."
                                                                                            at ".$reservation->Pastryreservation[$i]->Orderhour.":".
                                                                                            $reservation->Pastryreservation[$i]->Ordermin." ".$reservation->Pastryreservation[$i]->Ordergmt."
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Quantity</td>
                                                                                        <td>".number_format( $reservation->Pastryreservation[$i]->Quantity)."</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>";
                                                                    }
                                                                    
                                                                    $ret->Content .="
                                                                    <table class='ui very basic celled table' style='font-family: ".$site->SecondaryFont.";'>
                                                                        <tr>
                                                                            <td>Booking number</td>
                                                                            <td>".$reservation->Bookingnumber."</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Booked</td>
                                                                            <td>".date("D, d/M/Y")."</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Arrival</td>
                                                                            <td>".date("D, d/M/Y", $reservation->Arrival->getValue())."</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Departure</td>
                                                                            <td>".date("D, d/M/Y", $reservation->Departure->getValue())."</td>
                                                                        </tr>
                                                                    </table>
                                                                    <br/>
                                                                    <table class='ui very basic celled table' style='font-family: ".$site->SecondaryFont.";'>
                                                                        <tr>
                                                                            <td>Subtotal</td>
                                                                            <td>
                                                                                <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span> 
                                                                                ".number_format($reservation->Subtotal, 2)."
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Taxes</td>
                                                                            <td>
                                                                                <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span> 
                                                                                ".number_format($reservation->Tax, 2)."
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Discount</td>
                                                                            <td>
                                                                                <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span> 
                                                                                ".number_format($reservation->Discount, 2)."
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Total</td>
                                                                            <td>
                                                                                <span style='font-family: Lato;'>".$subscriber->Currency->Symbol."</span> 
                                                                                ".number_format($reservation->Total, 2)."
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Paid</td>
                                                                            <td>
                                                                                ".($reservation->Paid ?
                                                                                    "<b style='color: forestgreen;'><i class='check green icon'></i> Paid" :
                                                                                    "<b style='color: maroon;'><i class='times red icon'></i> Unpaid")."
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>";

                                                    }
                                                    else
                                                    {
                                                        $ret->Content .= "
                                                        <div class='l-pad-2 align-c'>
                                                            <h3 class='ui icon header' style='font-family: ".$site->TextFont."; color: silver; font-weight: normal;'>
                                                                <i class='ban icon' style='color: rgba(255, 0,0,0.1);'></i>
                                                                Reservation may have been deleted or is corrupt
                                                            </h3>
                                                        </div>";
                                                    }
                                                }
                                                else
                                                {
                                                    if(count($reservations) > 0)
                                                    {
                                                        for($i = 0; $i < count($reservations); $i++)
                                                        {
                                                            $ret->Content .=
                                                                "<div id='".$reservations[$i]->Id."-reservation' class='curve w3-card hoverable l-pad-2 s-pad-1' style='margin-bottom: 3px; cursor: pointer;'>
                                                                <div class='w3-row'>
                                                                    <a href='".Router::ResolvePath("reservation/".$reservations[$i]->Id, $path)."'>
                                                                        <div class='w3-col l2 m3 s4'>
                                                                            <div>
                                                                                <small style='color: silver; font-family: ".$site->SecondaryFont.";'>Booking number</small><br/>
                                                                                <label style='font-family: ".$site->SecondaryFont.";'>".$reservations[$i]->Bookingnumber."</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class='w3-col l2 m2 s3'>
                                                                            <div style='margin-top: 10px; font-family: ".$site->SecondaryFont.";'>
                                                                            ".($reservations[$i]->Paid ? "<span class='green-back status'>Paid</span>" : "<span class='red-back status'>Unpaid</span>")."
                                                                            </div>
                                                                        </div>
                                                                        <div class='w3-col l3 m3 s5 s-hide'>
                                                                            <div>
                                                                                <small style='color: silver; font-family: ".$site->SecondaryFont.";'>Arrival</small><br/>
                                                                                <label>".date("D, d/M/Y", $reservations[$i]->Arrival->getValue())."</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class='w3-col l3 m3 s3 s-hide'>
                                                                            <div>
                                                                                <small style='color: silver; font-family: ".$site->SecondaryFont.";'>Departure</small><br/>
                                                                                <label style='font-family: ".$site->SecondaryFont.";'>".date("D, d/M/Y", $reservations[$i]->Departure->getValue())."</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class='w3-col l1 m1 s3'>
                                                                            <div>
                                                                                <small style='color: silver; font-family: ".$site->SecondaryFont.";'>Booked</small><br/>
                                                                                <label style='font-family: ".$site->SecondaryFont.";'>".$reservations[$i]->Roomorders." room(s)</label>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    <div class='w3-col l1 m1 s2'>
                                                                        <div class='align-r' style='margin-top: 10px;'>
                                                                            <div class='ui top right pointing dropdown'>
                                                                                <i id='".$reservations[$i]->Id."-btn' class='vertical ellipsis icon'></i>
                                                                                <div class='menu'>
                                                                                    <a href='".
                                                                                        Router::ResolvePath("reservation/".$reservations[$i]->Id, $path).
                                                                                        "' class='item' style='font-family: ".$site->SecondaryFont.";'>Booking detail
                                                                                    </a>
                                                                                    ".((!$reservations[$i]->Paid && ($site->Payonline)) ?
                                                                                        "<div class='item'><i class='credit card icon'></i> Pay now</div>" : "")."
                                                                                    ".(!$reservations[$i]->Paid ?
                                                                                    "<div class='item' onclick=\"cancelReservation('".$reservations[$i]->Id."')\">
                                                                                    <i class='times icon'></i> Cancel</div>" : "")."
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $ret->Content .= "
                                                        <div class='l-pad-2 align-c'>
                                                            <h3 class='ui icon header' style='font-family: ".$site->TextFont."; color: silver; font-weight: normal;'>
                                                                <i class='bed icon'></i>
                                                                You have no reservation yet
                                                            </h3>
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


                    require("addons/footer.php");
                    $ret->Content .=
                        "</body>
              </html>";
        }
    }
