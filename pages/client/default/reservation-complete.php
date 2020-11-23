<?php

if(!$modules->Booking)
{
    require_once ("addons/404.php");
}
else
{
    $router = new Router($path);

    $reservation =  null;

    if(count($router->Args) == 0)
    {
        require_once ("addons/404.php");
    }
    else
    {
        $reservation = new Reservation($subscriber);
        $reservation->Initialize($router->Args[0]);

        if ($reservation->Id == "")
        {
            require_once("addons/404.php");
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
                    
                    <title> Reservation completed | ".$subscriber->BusinessName."</title>
                    
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
                <body style='background-color: whitesmoke;'>";

            $ret->Content .= "<div style='background-color: white;'>";
            require("addons/header.php");
            $ret->Content .= "</div>


                        <div class='l-margin-t-5'>
                            <div class='l-width-7 m-width-xl l-pad-4 m-pad-2 s-pad-1' style='background-color: white; margin: auto;'>
                                <div class='align-c'>
                                    <h1 class='ui icon header'><i class='check circular green icon'></i></h1>
                                    <h3 style='font-family: ".$site->TextFont."; color: dimgray;'>Reservation completed!</h3>
                                    <br/>
                                    <h6 style='font-family: ".$site->TextFont."; font-weight: bold;'>Booking Number</h6>
                                    <h6>".$reservation->Bookingnumber."</h6>
                                </div>
                                <br/>
                                <table class='ui table' style='font-size: 15px; font-family: ".$site->TextFont.";'>
                                    <tr>
                                        <td>Arrival</td>    
                                        <td>".date("D, d/M/Y", $reservation->Arrival->getValue())."</td>    
                                    </tr>";

                                    if($reservation->Roomorders > 0)
                                    {

                                        $ret->Content .= " <tr>
                                                    <td>Rooms</td>    
                                                    <td>".$reservation->Roomorders." booked</td>    
                                                </tr>";
                                    }
                                $ret->Content .="
                                </table>
                                <br/>
                                <table class='ui table' style='font-size: 15px; font-family: ".$site->TextFont.";'>
                                    <tr>
                                        <td>Subtotal</td>    
                                        <td><span style='font-family: Lato;'> ".
                                            $subscriber->Currency->Symbol."</span>".
                                            number_format($reservation->Subtotal, 2)."
                                        </td>    
                                    </tr>
                                    <tr>
                                        <td>Taxes</td>    
                                        <td><span style='font-family: Lato;'> ".
                                            $subscriber->Currency->Symbol."</span>".
                                            number_format($reservation->Tax, 2)."
                                        </td>    
                                    </tr>
                                    <tr>
                                        <td>Discount</td>    
                                        <td>".$subscriber->Currency->Symbol.number_format($reservation->Discount + $reservation->Coupon, 2)."</td>    
                                    </tr>
                                    <tr>
                                        <td>Total</td>    
                                        <td><span style='font-family: Lato;'>".
                                            $subscriber->Currency->Symbol."</span>".
                                            number_format($reservation->Total, 2)."
                                        </td>    
                                    </tr>
                                    <tr>
                                        <td>Payment</td>    
                                            <td>".($reservation->Paid ?
                                            "<span style='color: forestgreen;'><i class='check green icon'></i> Paid</span>" :
                                            "<span style='color: maroon;'><i class='times red icon'></i> Unpaid</span>")."
                                        </td>    
                                    </tr>
                                </table>
                                <h6 style='font-family: ".$site->TextFont."; font-weight: bold;'>
                                    You can manage all your reservations and booking history from within 
                                    <a href='".Router::ResolvePath("reservation", $path)."' style='color: steelblue;'>
                                        your account
                                    </a>
                                </h6>
                            </div>
                        </div>";



            require("addons/footer.php");

            $ret->Content .= "
                </body>
            </html>";
        }
    }
}