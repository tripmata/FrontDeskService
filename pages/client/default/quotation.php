    <?php

    $router = new Router($path);

    if(count($router->Args) < 2)
    {
        require_once ("addons/404.php");
        goto end;
    }
    else
    {
        $session = Quotationsession::GetSession($subscriber, $router->Args[0], $router->Args[1]);

        $integrations = new Integration($subscriber);


        $ret->Content = "<!DOCTYPE html>
                <html>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                        
                        <meta name='robots' content='noindex, nofollow'/>
                        
                        <title>Supply quotation request | " . $subscriber->BusinessName . "</title>
                        
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
                        <script type='application/javascript' src='".$host."/cdn/themes/default/js/quotation.js'></script>
                    </head>
                    <body style='background-color: whitesmoke;'>
                    
                    <div style='background-color: #fff;'>";
        require("addons/header.php");

        if($session == null)
        {
            $ret->Content .=
                "</div>
                    <div class='l-pad-t-5'>
                        <div class='l-width-6 w3-card' style='margin: auto; background-color: white;'>
                            <div id='reviews-completion-con'>
                                <div class='pad-3'>
                                    <div class='margin-t-5 margin-b-5 align-c'>
                                        <img src='".$host."cdn/images/icons/pastel/caution.png' />
                                        <h4 style='font-family: ".$site->TextFont."; font-weight: bold; line-height: 180%;'>
                                        Sorry!!<br/>The request have been disabled or deleted</h4>
                                        <br/>
                                        <a href='".Router::ResolvePath('home', $path)."'>
                                            <button class='ui button' style='background-color: ".$site->PrimaryColor."; 
                                            color: white; font-family: ".$site->SecondaryFont.";'><i class='home icon'></i>
                                             Home</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        else
        {
            if($session->Responded)
            {
                $ret->Content .=
                    "</div>
                        <div class='l-pad-t-5'>
                            <div class='l-width-6 w3-card' style='margin: auto; background-color: white;'>
                                <div id='reviews-completion-con'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                            <img src='".$host."cdn/images/icons/pastel/checkall.png' />
                                            <h4 style='font-family: ".$site->TextFont."; font-weight: bold; line-height: 180%;'>
                                            We've already received your quotation
                                            </h4>
                                            <h6 style='font-family: ".$site->TextFont."; font-weight: bold; color: dimgray;'>
                                            Thank you for your time</h6>
                                            <br/>
                                            <a href='".Router::ResolvePath('home', $path)."'>
                                                <button class='ui button' style='background-color: ".$site->PrimaryColor."; 
                                                color: white; font-family: ".$site->SecondaryFont.";'><i class='home icon'></i>
                                                 Home</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
            else
            {
                $quotation = null;


                if($session->Type == "bar_item")
                {
                    $quotation = new Barquotation($subscriber);
                }
                else if($session->Type == "kitchen_item")
                {
                    $quotation = new Kitchenquotation($subscriber);
                }
                else if($session->Type == "laundry_item")
                {
                    $quotation = new Laundryquotation($subscriber);
                }
                else if($session->Type == "pastry_item")
                {
                    $quotation = new Pastryquotation($subscriber);
                }
                else if($session->Type == "pool_item")
                {
                    $quotation = new Poolquotation($subscriber);
                }
                else if($session->Type == "room_item")
                {
                    $quotation = new Roomquotation($subscriber);
                }
                else if($session->Type == "store_item")
                {
                    $quotation = new Storequotation($subscriber);
                }

                if($quotation == null)
                {
                    $ret->Content .=
                        "</div>
                            <div class='l-pad-t-5'>
                                <div class='l-width-6 w3-card' style='margin: auto; background-color: white;'>
                                    <div id='reviews-completion-con'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                        <img src='".$host."cdn/images/icons/pastel/caution.png' />
                                        <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>Sorry!!<br/>The request have been disabled or deleted</h4>
                                        <br/>
                                        <a href='".Router::ResolvePath('home', $path)."'>
                                            <button class='ui button' style='background-color: ".$site->PrimaryColor."; 
                                            color: white; font-family: ".$site->SecondaryFont.";'><i class='home icon'></i>
                                             Home</button>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>";

                }
                else
                {
                    $quotation->Initialize($session->Quotation);

                    $ret->Content .=
                    "</div>
                        <div class='l-pad-t-5'>
                            <div class='l-width-6' style='margin: auto;'>
                                <div id='quote-main-con' class=''>
                                    <div class='l-pad-2 s-pad-1'>
                                        <div class=''>
                                       
                                            <input id='session-id' type='hidden' value='".$session->Id."'/>
                                            <input id='item_type' type='hidden' value='".$session->Type."'/>
                                        
                                            <h3 style='color: dimgray; font-family: ".$site->TextFont.";'>Quotation request</h3>";

                                            $ret->Content .=
                                                "<table class='ui table' style='font-size: 15px;'>
                                                    <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>We are willing to buy</th>
                                                            <th style='text-align: right;'>Price per item</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";

                                                    for($i = 0; $i < count($quotation->Items); $i++)
                                                    {
                                                        if($quotation->Items[$i]->inSuppliers($session->Supplier))
                                                        {
                                                            $ret->Content .=
                                                                "<tr>
                                                                <td>".$quotation->Items[$i]->Item->Name."</td>
                                                                <td>".
                                                                    $quotation->Items[$i]->Quantity." ".
                                                                    ($quotation->Items[$i]->Quantity != 1 ?
                                                                        $quotation->Items[$i]->Item->Pluralunit :
                                                                        $quotation->Items[$i]->Item->Unit)."
                                                                </td>
                                                                <td style='text-align: right;'>
                                                                    <div class='ui input'>
                                                                        <input class='price-input' itemid='".$quotation->Items[$i]->Item->Id."' type='text' value='0.00' style='text-align: right; border: none;'/>
                                                                    </div>
                                                                </td>
                                                                </tr>";
                                                        }
                                                    }

                                                    $ret->Content .="        
                                                    </tbody>
                                                </table>
                                                <div>
                                                    <button class='ui blue sleak button' onclick='sendQuotation()'>
                                                        <i class='paper plane icon'></i> Send quotation
                                                    </button>
                                                </div>";



                                            $ret->Content .="
                                        </div>
                                    </div>
                                </div>
                                <div id='quote-completion-con' style='display: none;'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                            <img src='".$host."cdn/images/icons/pastel/check_outline.png' />
                                            <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>Quotation sent successfully</h4>
                                            <h6 style='font-family: ".$site->TextFont."; font-weight: bold; color: dimgray;'>Do have a nice day</h6>
                                            <br/>
                                            <a href='".Router::ResolvePath('home', $path)."'>
                                                <button class='ui button' style='background-color: ".$site->PrimaryColor."; 
                                                color: white; font-family: ".$site->SecondaryFont.";'><i class='home icon'></i>
                                                 Home</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id='quote-loading-con' style='display: none;'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                            <div class='ui huge active inline loader'></div>
                                            <br/><br/>
                                            <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>Sending quotation...</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";

                }
            }
        }

        require("addons/footer.php");
        $ret->Content .= $integrations->Livechat.= "
                    </body>
                </html>";

    }
    end:;