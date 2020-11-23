<?php

    if(!isset($router->Args[0]))
    {
        require_once ("addons/404.php");
    }
    else
    {
        $printer = Printer::ByMeta($subscriber, $router->Args[0]);

        if($printer == null)
        {
            $ret->Content .= $printer->Meta;

            //require_once ("addons/404.php");
        }
        else
        {
            $doc = json_decode($printer->Printobject);

            $ret->Content = "<!DOCTYPE html>
            <html style='background-color: gray;'>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    
                    <title>".ucwords($printer->Document)."</title>
                    
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
                <body class='l-width-7' style='margin: auto; margin-bottom: 100px; height: auto; background-color: white; min-height: 100%;'>";


                $logo = "";
                if($site->Logo == "")
                {
                    $logo = Router::ResolvePath("files/logo.png", $path);
                }
                else
                {
                    $logo = Router::ResolvePath("files/".$site->Logo, $path);
                }

                if($printer->Document == "item timeline")
                {
                    $item = null;
                    $timeline = null;

                    $source = "Unknown";

                    if($doc->Type == "bar_item")
                    {
                        $item = new Baritem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Bar inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Barinventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Barinventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Barinventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Barinventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Barinventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Barinventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    if($doc->Type == "kitchen_item")
                    {
                        $item = new Kitchenitem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Kitchen inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Kitcheninventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Kitcheninventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Kitcheninventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Kitcheninventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Kitcheninventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Kitcheninventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    if($doc->Type == "laundry_item")
                    {
                        $item = new Laundryitem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Laundry inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Laundryinventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Laundryinventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Laundryinventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Laundryinventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Laundryinventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Laundryinventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    if($doc->Type == "pastry_item")
                    {
                        $item = new Pastryitem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Pastry inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Pastryinventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Pastryinventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Pastryinventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Pastryinventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Pastryinventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Pastryinventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    if($doc->Type == "pool_item")
                    {
                        $item = new Poolitem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Pool inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Poolinventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Poolinventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Poolinventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Poolinventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Poolinventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Poolinventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    if($doc->Type == "room_item")
                    {
                        $item = new Roomitem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Room inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Roominventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Roominventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Roominventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Roominventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Roominventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Roominventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    if($doc->Type == "store_item")
                    {
                        $item = new Roomitem($subscriber);
                        $item->Initialize($doc->Item);

                        $source = "Store inventory";

                        $store = null;

                        $span = new Timespan(new WixDate($doc->Startdate), new WixDate($doc->Stopdate), true);

                        if(strtolower($doc->Filter) == "all")
                        {
                            $store = Storeinventoryactivity::TimelineAll($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "usage")
                        {
                            $store = Storeinventoryactivity::TimelineUsage($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "restocking")
                        {
                            $store = Storeinventoryactivity::TimelineRestocking($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "surplus")
                        {
                            $store = Storeinventoryactivity::TimelineSurplus($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "damages")
                        {
                            $store = Storeinventoryactivity::TimelineDamages($subscriber, $span, $doc->Item);
                        }
                        if(strtolower($doc->Filter) == "Returns")
                        {
                            $store = Storeinventoryactivity::TimelineReturns($subscriber, $span, $doc->Item);
                        }
                    }
                    $stats = Inventoryactivity::BuildStatistics($store);
                    $ret->Content .=
                        "<br/>
                            <div class='margin-t-3'>
                            <div class='l-width-8' style='margin: auto;'>
                                ".($site->ShowLogo ? "<img src='".$logo."' style='width: 80px;'/>" : "")."
                                <h5 class='sleak' style='font-weight: bold; color: dimgray;'>".$subscriber->BusinessName."</h5>
                                <h3 class='sleak' style='font-weight: bold;'>".$item->Name." Time line report</h3>
                                <div class='l-align-r'>
                                    <h6 class='sleak' style='color: dimgray;'>
                                        <span style='color: gray;'>Start date:</span> ".
                                        date("D, M/d/Y", strtotime($doc->Startdate))."
                                    </h6>
                                    <h6 class='' style='color: dimgray;'>
                                        <span style='color: dimgray;'>Stop date:</span> ".
                                        date("D, M/d/Y", strtotime($doc->Stopdate))."
                                    </h6>
                                    <h6 class='' style='color: dimgray;'>
                                        <span style='color: gray;'>Source: </span>
                                        ".$source."
                                    </h6>
                                    <h6 class='' style='color: dimgray;'>
                                        <span style='color: gray;'>Item: </span>
                                        ".$item->Name."
                                    </h6>
                                    <h6 class='' style='color: dimgray;'>
                                        <span style='color: gray;'>Applied filter: </span>
                                        ".$doc->Filter."
                                    </h6>
                                </div>
                                
                                <h4 class='sleak' style='font-weight: bold;'>Statistics</h4>
                                
                                <div class='margin-bottom: 50px;'>
                                    <table class='ui very basic striped table' style='font-size: 15px;'>
                                        <tr>
                                            <td>Current stock</td>
                                            <td colspan='2'>".
                                                number_format($item->Stock)." ".
                                                ($item->Stock == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Restocking</td>
                                            <td>".
                                                number_format($stats->Restocking)." ".
                                                ($stats->Restocking == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                            <td>".
                                                number_format($stats->RestockingEvents)." ".
                                                ($stats->RestockingEvents == 1 ? "Event" : "Events")."
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Usage</td>
                                            <td>".
                                                number_format($stats->Usage)." ".
                                                ($stats->Usage == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                            <td>".
                                                number_format($stats->UsageEvents)." ".
                                                ($stats->UsageEvents == 1 ? "Event" : "Events")."
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Surplus</td>
                                            <td>".
                                                number_format($stats->Surplus)." ".
                                                ($stats->Surplus == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                            <td>".
                                                number_format($stats->SurplusEvents)." ".
                                                ($stats->SurplusEvents == 1 ? "Event" : "Events")."
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Damages / Losses</td>
                                            <td>".
                                                number_format($stats->Damage)." ".
                                                ($stats->Damage == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                            <td>".
                                                number_format($stats->DamageEvents)." ".
                                                ($stats->DamageEvents == 1 ? "Event" : "Events")."
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Return</td>
                                            <td>".
                                                number_format($stats->Return)." ".
                                                ($stats->Return == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                            <td>".
                                                number_format($stats->ReturnEvents)." ".
                                                ($stats->ReturnEvents == 1 ? "Event" : "Events")."
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sale</td>
                                            <td>".
                                                number_format($stats->Sale)." ".
                                                ($stats->Sale == 1 ? $item->Unit : $item->Pluralunit)."
                                            </td>
                                            <td>".
                                                number_format($stats->SaleEvents)." ".
                                                ($stats->SaleEvents == 1 ? "Event" : "Events")."
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <br/>
                                    <h4 class='sleak' style='font-weight: bold;'>Time line</h4>
                                    <table class='ui very basic padded no-line celled table' style='font-size: 16px;'>";

                                    for($i = 0; $i < count($store); $i++)
                                    {
                                        $ret->Content .=
                                            "<tr>
                                                <td style='text-align: right; vertical-align: top;'>".
                                                    $store[$i]->Created->WeekDay.", ".
                                                    $store[$i]->Created->MonthName."/".
                                                    $store[$i]->Created->Day."/".
                                                    $store[$i]->Created->Year."
                                                </td>
                                                <td style='line-height: 190%;'>".
                                            ((($store[$i]->Type == "usage") ||
                                                ($store[$i]->Type == "damage") ||
                                                ($store[$i]->Type == "return") ||
                                                ($store[$i]->Type == "sold")) ?
                                                "<i class='arrow up circular red icon'></i>" :
                                                "<i class='arrow down circular green icon'></i>")." ".
                                                    $store[$i]->Difference."  ".
                                                    ($stats->Sale == 1 ? $item->Unit : $item->Pluralunit)." <b>".
                                                    ($store[$i]->Type == "usage" ? "<b>Used</b>" :
                                                        ($store[$i]->Type == "damage" ? "<b>Damaged</b>" :
                                                        ($store[$i]->Type == "return" ? "<b>Returned</b>" :
                                                        ($store[$i]->Type == "sold" ? "<b>Sold</b>" :
                                                        ($store[$i]->Type == "surplus" ? "<b>Surplus</b>" :
                                                        ($store[$i]->Type == "restocking" ? "<b>Restocked</b>" : "Opening stock"
                                                        ))))))."</b><br/>
                                                    
                                                        Old Stock: ".$store[$i]->Initialstock."<br/>
                                                        New Stock: ".$store[$i]->Newstock."<br/>
                                                        Recorded by: ".$store[$i]->User->Name." ".$store[$i]->User->Surname."<br/>
                                                </td>
                                            </tr>";
                                    }

                                    $ret->Content .="
                                    </table>
                                    <br/>
                                    
                                </div>
                            </div>
                        </div>";
                }
                if($printer->Document == "quotation")
                {
                    $quotation = null;
                    $source = "Unknown";

                    if($doc->Type == "bar_item")
                    {
                        $quotation = new Barquotation($subscriber);
                        $source = "Bar inventory";
                    }
                    if($doc->Type == "kitchen_item")
                    {
                        $quotation = new Kitchenquotation($subscriber);
                        $source = "Kitchen inventory";
                    }
                    if($doc->Type == "laundry_item")
                    {
                        $quotation = new Laundryquotation($subscriber);
                        $source = "Laundry inventory";
                    }
                    if($doc->Type == "pastry_item")
                    {
                        $quotation = new Pastryquotation($subscriber);
                        $source = "Pastry inventory";
                    }
                    if($doc->Type == "pool_item")
                    {
                        $quotation = new Poolquotation($subscriber);
                        $source = "Pool inventory";
                    }
                    if($doc->Type == "room_item")
                    {
                        $quotation = new Roomquotation($subscriber);
                        $source = "Room inventory";
                    }
                    if($doc->Type == "store_item")
                    {
                        $quotation = new Storequotation($subscriber);
                        $source = "Store inventory";
                    }

                    $quotation->Initialize($doc->Quotation);

                    $ret->Content .= "
                    <br/>
                    <div class='margin-t-3'>
                    <div class='l-width-9' style='margin: auto;'>
                    ".($site->ShowLogo ? "<img src='".$logo."' style='width: 80px;'/>" : "")."
                        <h5 class='sleak' style='font-weight: bold; color: dimgray;'>".$subscriber->BusinessName."</h5>
                        <h3 class='sleak' style='font-weight: bold;'></h3>
                        <div class='l-align-r'>
                        <h6 class='' style='color: dimgray;'>
                            <span style='color: gray;'>Source: </span>
                            ".$source."
                        </h6>
                    </div>
                    <table class='ui celled structured table'>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Supplier</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>";

                        for($q= 0; $q < count($quotation->Items); $q++)
                        {
                            $ret->Content .=
                                "<tr>
                                    <td rowspan='".(count($quotation->Items[$q]->Pixel) > 0 ?
                                    count($quotation->Items[$q]->Pixel) : 1)."'>".
                                    $quotation->Items[$q]->Item->Name."</td>
                                    
                                    <td rowspan='".(count($quotation->Items[$q]->Pixel) > 0 ?
                                    count($quotation->Items[$q]->Pixel) : 1)."'>".
                                    number_format($quotation->Items[$q]->Quantity)."</td>
     
                                    ".(count($quotation->Items[$q]->Pixel) > 0 ?
                                    "<td>".($quotation->Items[$q]->Pixel[0]->Supplier->Company != "" ?
                                        $quotation->Items[$q]->Pixel[0]->Supplier->Company :
                                        $quotation->Items[$q]->Pixel[0]->Supplier->Contactperson)."</td>" :
                                    "<td><span class='red'>Item has no suppliers</span></td>")."
                                    
                                    ".(count($quotation->Items[$q]->Pixel) > 0 ?
                                    "<td>".$subscriber->Currency->Symbol.
                                    number_format($quotation->Items[$q]->Pixel[0]->Price, 2)."</td>" :
                                    "<td><span class='red'>Item has no suppliers</span></td>")."
                                    
                                    ".(count($quotation->Items[$q]->Pixel) > 0 ?
                                    "<td>".$subscriber->Currency->Symbol.number_format(
                                        doubleval($quotation->Items[$q]->Pixel[0]->Price) *
                                        ($quotation->Items[$q]->Quantity), 2)."</td>" :
                                    "<td><span class='red'>Item has no suppliers</span></td>")."
                                    
                                </tr>";


                                if(count($quotation->Items[$q]->Pixel) > 1)
                                {
                                    for($m = 1; $m < count($quotation->Items[$q]->Pixel); $m++)
                                    {
                                        $ret->Content .=
                                            "<tr>
                                            <td>".($quotation->Items[$q]->Pixel[$m]->Supplier->Company != "" ?
                                                $quotation->Items[$q]->Pixel[$m]->Supplier->Company :
                                                $quotation->Items[$q]->Pixel[$m]->Supplier->Contactperson)."</td>
                                            <td>".$subscriber->Currency->Symbol.
                                            number_format($quotation->Items[$q]->Pixel[$m]->Price, 2)."</td>
                                            <td>".$subscriber->Currency->Symbol.
                                            number_format(($quotation->Items[$q]->Pixel[$m]->Price *
                                                $quotation->Items[$q]->Quantity), 2)."</td>
                                        </tr>";
                                    }
                                }
                        }

                        $ret->Content .="
                        </tbody>
                    </table>
                    <br/>
                    </div>
                    </div>";
                }
                if($printer->Document == "audit")
                {
                    $audit = null;
                    $list = null;

                    $source = "Unknown";

                    if($doc->Type == "bar_item")
                    {
                        $audit = new Baraudit($subscriber);
                        $list = Baritem::All($subscriber);
                        $source = "Bar inventory";
                    }
                    if($doc->Type == "kitchen_item")
                    {
                        $audit = new Kitchenaudit($subscriber);
                        $list = Kitchenitem::All($subscriber);
                        $source = "Kitchen inventory";
                    }
                    if($doc->Type == "laundry_item")
                    {
                        $audit = new Laundryaudit($subscriber);
                        $list = Laundryitem::All($subscriber);
                        $source = "Laundry inventory";
                    }
                    if($doc->Type == "pastry_item")
                    {
                        $audit = new Pastryaudit($subscriber);
                        $list = Pastryitem::All($subscriber);
                        $source = "Pastry inventory";
                    }
                    if($doc->Type == "pool_item")
                    {
                        $audit = new Poolaudit($subscriber);
                        $list = Poolitem::All($subscriber);
                        $source = "Pool inventory";
                    }
                    if($doc->Type == "room_item")
                    {
                        $audit = new Roomaudit($subscriber);
                        $list = Roomitem::All($subscriber);
                        $source = "Room inventory";
                    }
                    if($doc->Type == "store_item")
                    {
                        $audit = new Storeaudit($subscriber);
                        $list = Storeitem::All($subscriber);
                        $source = "Store inventory";
                    }

                    $audit->Initialize($doc->Audit);

                    $ret->Content .= "
                        <br/>
                        <div class='margin-t-3'>
                        <div class='l-width-9' style='margin: auto;'>
                        ".($site->ShowLogo ? "<img src='".$logo."' style='width: 80px;'/>" : "")."
                            <h5 class='sleak' style='font-weight: bold; color: dimgray;'>".$subscriber->BusinessName."</h5>
                            <h3 class='sleak' style='font-weight: bold;'>Inventory auditing</h3>
                            <div class='l-align-r'>
                            <h6 class='' style='color: dimgray;'>
                                <span style='color: gray;'>Source: </span>
                                ".$source."
                            </h6>
                        </div>
                        <table class='ui celled structured table'>
                            <thead>
                                <tr>
                                    <th>sn</th>
                                    <th>Item</th>
                                    <th>Counted</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Difference</th>
                                </tr>
                            </thead>
                            <tbody>";

                    $lst = [];
                    for($l = 0; $l < count($audit->Items); $l++)
                    {
                        array_push($lst, $audit->Items[$l]->Item);
                    }


                    for($q= 0; $q < count($list); $q++)
                    {
                        if(in_array($list[$q]->Id, $lst))
                        {
                            for($t = 0; $t < count($lst); $t++)
                            {
                                if($audit->Items[$t]->Item == $list[$q]->Id)
                                {
                                    $ret->Content .=
                                    "<tr>
                                        <td>".($q + 1)."</td>
                                        <td>
                                            ".$list[$q]->Name . "
                                        </td>
                                        <td>
                                            ".number_format($audit->Items[$t]->Counted)." <span style='color: silver'>
                                                ".(intval($audit->Items[$t]->Counted) == 1 ? $list[$q]->Unit : $list[$q]->Pluralunit)."</span>
                                        </td>
                                        <td>
                                            ".number_format($audit->Items[$t]->Stock)." <span style='color: silver'>
                                                ".(intval($audit->Items[$t]->Counted) == 1 ? $list[$q]->Unit : $list[$q]->Pluralunit)."</span>
                                        </td>
                                        <td>
                                            ".(intval($audit->Items[$t]->Counted) == intval($audit->Items[$t]->Stock) ?
                                                "<i class='check green icon'></i> Accurate" :
                                                    ((intval($audit->Items[$t]->Counted) > intval($audit->Items[$t]->Stock)) ?
                                                    "<i class='arrow up blue icon'></i> Surplus" :
                                                    "<i class='arrow down red icon'></i> Shortage"))."
                                        </td>
                                        <td>
                                            ".(intval($audit->Items[$t]->Counted) == intval($audit->Items[$t]->Stock) ?
                                                "0" : ((intval($audit->Items[$t]->Counted) > intval($audit->Items[$t]->Stock)) ?
                                                number_format(intval($audit->Items[$t]->Counted) - intval($audit->Items[$t]->Stock)) :
                                                number_format(intval($audit->Items[$t]->Stock) - intval($audit->Items[$t]->Counted))))."
                                        </td>
                                    </tr>";
                                }
                            }
                        }
                        else
                        {
                            $ret->Content .=
                                "<tr>
                                    <td>".($q + 1)."</td>
                                    <td>
                                        ".$list[$q]->Name . "
                                    </td>
                                    <td>
                                        <span style='color: silver;'>No data</span>
                                    </td>
                                    <td>
                                        <span style='color: silver;'>No data</span>
                                    </td>
                                    <td>
                                        <span style='color: silver;'>No data</span>
                                    </td>
                                    <td>
                                        <span style='color: silver;'>No data</span>
                                    </td>
                                </tr>";
                        }
                    }

                    $ret->Content .="
                            </tbody>
                        </table>
                        <br/>
                        </div>
                        </div>";
                }
                if($printer->Document == "purchase order")
                {
                    $order = null;

                    $source = "Unknown";

                    if($doc->Type == "bar_item")
                    {
                        $order = new Barpo($subscriber);
                        $source = "Bar inventory";
                    }
                    if($doc->Type == "kitchen_item")
                    {
                        $order = new Kitchenpo($subscriber);
                        $source = "Kitchen inventory";
                    }
                    if($doc->Type == "laundry_item")
                    {
                        $order = new Laundrypo($subscriber);
                        $source = "Laundry inventory";
                    }
                    if($doc->Type == "pastry_item")
                    {
                        $order = new Pastrypo($subscriber);
                        $source = "Pastry inventory";
                    }
                    if($doc->Type == "pool_item")
                    {
                        $order = new Poolaudit($subscriber);
                        $source = "Pool inventory";
                    }
                    if($doc->Type == "room_item")
                    {
                        $order = new Roompo($subscriber);
                        $source = "Room inventory";
                    }
                    if($doc->Type == "store_item")
                    {
                        $order = new Storeaudit($subscriber);
                        $source = "Store inventory";
                    }

                    $order->Initialize($doc->Order);

                    $ret->Content .= "
                            <br/>
                            <div class='margin-t-3'>
                            <div class='l-width-9' style='margin: auto;'>
                            ".($site->ShowLogo ? "<img src='".$logo."' style='width: 80px;'/>" : "")."
                                <h5 class='sleak' style='font-weight: bold; color: dimgray;'>".$subscriber->BusinessName."</h5>
                                <h3 class='sleak' style='font-weight: bold;'>Purchase Order</h3>
                                <h6 class='' style='color: dimgray;'>
                                    <span style='color: gray;'>#</span>".$order->Pr."
                                </h6>
                                <div style='text-align: right;'>
                                 <h5 class='' style='color: dimgray; font-family: ".$site->TextFont."; font-weight: bold;'>
                                    ".($order->Supplier->Company != "" ? $order->Supplier->Company : $order->Supplier->Contactperson)."
                                </h5>
                                <h6 class='' style='color: dimgray;'>
                                    ".$order->Supplier->Phone."
                                </h6>
                                <h6 class='' style='color: dimgray;'>
                                    ".$order->Supplier->Email."
                                </h6>
                                <h6 class='' style='color: dimgray;'>
                                    ".$order->Supplier->Address."
                                </h6>
                              
                                <h6 class='' style='color: dimgray;'>
                                    <span style='color: gray;'>Raised: </span>".$order->Created->WeekDay.", 
                                     ".$order->Created->Day."/".$order->Created->MonthName."/".$order->Created->Year."
                                </h6>
                            </div>
                            <table class='ui celled structured table'>
                                <thead>
                                    <tr>
                                        <th style='background-color: rgb(100,100,100); color: white;'>sn</th>
                                        <th style='background-color: rgb(100,100,100); color: white;'>Item</th>
                                        <th style='background-color: rgb(100,100,100); color: white;'>Requested Qty</th>".
                                        ($order->Received ? "<th style='background-color: rgb(100,100,100); color: white;'>Received</th>" : "")
                                        ."<th style='background-color: rgb(100,100,100); color: white;'>Rate</th>
                                        <th style='background-color: rgb(100,100,100); color: white;'>Total</th>
                                    </tr>
                                </thead>
                                <tbody>";


                    $tots = 0;
                    for($q= 0; $q < count($order->Items); $q++)
                    {
                        $ret->Content .=
                            "<tr>
                                <td>".($q + 1)."</td>
                                <td>
                                    ".$order->Items[$q]->Item->Name . "
                                </td>
                                <td>
                                    ".number_format($order->Items[$q]->Quantity)."
                                </td>
                                ".($order->Received ? "<td>".$order->Items[$q]->Supplied."</td>" : "")."
                                <td>
                                    ".$subscriber->Currency->Symbol.number_format($order->Items[$q]->Rate, 2)."
                                </td>
                                <td>
                                    ".$subscriber->Currency->Symbol.number_format(doubleval($order->Items[$q]->Rate) * doubleval($order->Items[$q]->Quantity), 2)."
                                </td>
                            </tr>";

                        $tots += (doubleval($order->Items[$q]->Rate) * doubleval($order->Items[$q]->Supplied));
                    }
                    $ret->Content .="
                                <tr>
                                    <td colspan='".($order->Received ? "5" : "4")."' style='text-align: right;'>Total</td>
                                    <td>".$subscriber->Currency->Symbol.number_format($order->Total)."</td>
                                </tr>";

                    if($order->Received)
                    {
                        $ret->Content .="
                                <tr>
                                    <td colspan='".($order->Received ? "5" : "4")."' style='text-align: right;'>Received Total</td>
                                    <td>".$subscriber->Currency->Symbol.number_format($tots)."</td>
                                </tr>";
                    }

                    $ret->Content .="
                                </tbody>
                            </table>
                            <br/>
                            </div>
                            </div>";
                }
                if($printer->Document == "supplier credit")
                {
                    $note = new Suppliercredit($subscriber);
                    $note->Initialize($doc->Note);
                    $source = $note->Source;


                    $ret->Content .= "
                        <br/>
                        <div class='margin-t-3'>
                        <div class='l-width-9' style='margin: auto;'>
                        ".($site->ShowLogo ? "<img src='".$logo."' style='width: 80px;'/>" : "")."
                            <h5 class='sleak' style='font-weight: bold; color: dimgray;'>".$subscriber->BusinessName."</h5>
                            <h3 class='sleak' style='font-weight: bold;'>Supplier Credit</h3>
                            <h6 class='' style='color: dimgray;'>
                                <span style='color: gray;'>#</span>".$note->Id."
                            </h6>
                            <div style='text-align: right;'>
                             <h5 class='' style='color: dimgray; font-family: ".$site->TextFont."; font-weight: bold;'>
                                ".($note->Supplier->Company != "" ? $note->Supplier->Company : $note->Supplier->Contactperson)."
                            </h5>
                            <h6 class='' style='color: dimgray;'>
                                ".$note->Supplier->Phone."
                            </h6>
                            <h6 class='' style='color: dimgray;'>
                                ".$note->Supplier->Email."
                            </h6>
                            <h6 class='' style='color: dimgray;'>
                                ".$note->Supplier->Address."
                            </h6>
                          
                            <h6 class='' style='color: dimgray;'>
                                <span style='color: gray;'>Generated: </span>".$note->Created->WeekDay.", 
                                 ".$note->Created->Day."/".$note->Created->MonthName."/".$note->Created->Year."
                            </h6>
                        </div>
                        <table class='ui celled structured table'>
                            <thead>
                                <tr>
                                    <th style='background-color: rgb(100,100,100); color: white;'>sn</th>
                                    <th style='background-color: rgb(100,100,100); color: white;'>Item</th>
                                    <th style='background-color: rgb(100,100,100); color: white;'>Quantity</th>
                                    <th style='background-color: rgb(100,100,100); color: white;'>Rate</th>
                                    <th style='background-color: rgb(100,100,100); color: white;'>Total</th>
                                </tr>
                            </thead>
                            <tbody>";

                $tots = 0;
                $items = $note->Items;
                for($q= 0; $q < count($items); $q++)
                {
                    $ret->Content .=
                        "<tr>
                            <td>".($q + 1)."</td>
                            <td>
                                ".$items[$q]->Name . "
                            </td>
                            <td>
                                ".number_format($items[$q]->Quantity)."
                            </td>
                            <td>
                                ".$subscriber->Currency->Symbol.number_format($items[$q]->Price, 2)."
                            </td>
                            <td>
                                ".$subscriber->Currency->Symbol.number_format(doubleval($items[$q]->Price) * doubleval($items[$q]->Quantity), 2)."
                            </td>
                        </tr>";

                    $tots += (doubleval($items[$q]->Price) * doubleval($items[$q]->Quantity));
                }
                /*
                $ret->Content .="
                            <tr>
                                <td colspan='4' style='text-align: right;'>Total</td>
                                <td>".$subscriber->Currency->Symbol.number_format($note->Total)."</td>
                            </tr>";
                */

                $ret->Content .="
                            </tbody>
                        </table>";

                    $ret->Content .= "
                            <div class='w3-container' style='text-align: right;'>
                                <table style='float: right; font-size: 16px;'>
                                    <tr>
                                        <td>Total:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td>".$subscriber->Currency->Symbol." ".number_format($note->Total, 2)."</td>
                                    </tr>
                                    <tr>
                                        <td>Paid:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td>".$subscriber->Currency->Symbol." ".number_format($note->Paidamount, 2)."</td>
                                    </tr>
                                    <tr>
                                        <td>Balance:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td>".$subscriber->Currency->Symbol." ".number_format(doubleval($note->Total) - doubleval($note->Paidamount), 2)."</td>
                                    </tr>
                                </table>
                            </div>";

                    $ret->Content .="
                        <br/>
                        </div>
                        </div>";

            }


                    $ret->Content .=
                "</body></html>";
        }
    }