    <?php

    $router = new Router($path);

    $room =  null;

    if(count($router->Args) == 0)
    {
        require_once ("addons/404.php");
        goto end;
    }
    else
    {
        $session = new Reviewsession($subscriber);
        $session->Initialize($router->Args[0]);

        $channel = "";

        if(isset($router->Args[1]))
        {
            $channel = $router->Args[1];
        }

        $integrations = new Integration($subscriber);


        $ret->Content = "<!DOCTYPE html>
                <html>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                        
                        <meta name='robots' content='noindex, nofollow'/>
                        
                        <title>Customers review | " . $subscriber->BusinessName . "</title>
                        
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
                        <script type='application/javascript' src='".$host."/cdn/themes/default/js/review.js'></script>
                    </head>
                    <body style='background-color: whitesmoke;'>
                    
                    <div style='background-color: #fff;'>";
        require("addons/header.php");

        if($session->Id == "")
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
                                        Sorry!!<br/>The review has been disabled or deleted</h4>
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
                                            We've already received your response
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
                $review = new Review($subscriber);
                $review->Initialize($session->Reviewid);

                if($review->Id == "")
                {
                    $ret->Content .=
                        "</div>
                            <div class='l-pad-t-5'>
                                <div class='l-width-6 w3-card' style='margin: auto; background-color: white;'>
                                    <div id='reviews-completion-con'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                        <img src='".$host."cdn/images/icons/pastel/caution.png' />
                                        <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>Sorry!!<br/>The review has been disabled or deleted</h4>
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
                    $items = $review->GetItems();
                    
                    $ret->Content .=
                    "</div>
                        <div class='l-pad-t-5'>
                            <div class='l-width-6 w3-card' style='margin: auto; background-color: white;'>
                                <div id='review-main-con' class=''>
                                    <div class='l-pad-9 s-pad-2'>
                                        <div class=''>
                                            <h2 style='font-family: ".$site->TextFont."; font-weight: bold;'>".$review->Title."</h2>
                                            <h6 style='font-family: ".$site->SecondaryFont."; color: dimgray; line-height: 180%;'>".
                                            $review->Body.
                                            "</h6>
                                            <br/><br/>
                                            <input id='session-id' type='hidden' value='".$session->Id."'/>
                                            <input id='review-channel' type='hidden' value='".$channel."'/>
                                            <div class='review-con' id='review-item-0-con' review-item-type='".$items[0]->Type."' item-id='".$items[0]->Id."'>";
                                                if($items[0]->Type === "star-rating")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>".$items[0]->Question."</h6>
                                                        <div id='review-item-0' class='ui huge star rating' data-rating='0' data-max-rating='".$items[0]->Maxrating."'></div>";
                                                }
                                                if ($items[0]->Type === "heart-rating")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[0]->Question . "</h6>
                                                                        <div id='review-item-0' class='ui huge heart rating' data-rating='0' data-max-rating='" . $items[0]->Maxrating . "'></div>";
                                                }
                                                if ($items[0]->Type === "multiple-select")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[0]->Question . "</h6>
                                                                        <div class=''>";

                                                    for($j = 0; $j < count($items[0]->Options); $j++)
                                                    {
                                                        $ret->Content .= "<br/><label><input id='review-item-0-option-".$j."' data-text='".$items[0]->Options[$j]."' class='filled-in' type='checkbox' /><span>
                                                                    <h6 style='display: inline; font-family: ".$site->BoldFont."; color: dimgray;'>".
                                                            $items[0]->Options[$j]."</h6></span></label>";
                                                    }

                                                    $ret->Content .=
                                                        "</div>";
                                                }
                                                if ($items[0]->Type === "single-select")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[0]->Question . "</h6>
                                                                                        <div class=''>";

                                                    for($j = 0; $j < count($items[0]->Options); $j++)
                                                    {
                                                        $ret->Content .= "<br/><label><input id='review-item-0-option-".$j."' data-text='".$items[0]->Options[$j]."' class='with-gap' name='select-option-0' type='radio' /><span>
                                                                                                <h6 style='display: inline; font-family: ".$site->BoldFont."; color: dimgray;'>".
                                                            $items[0]->Options[$j]."</h6></span></label>";
                                                    }

                                                    $ret->Content .=
                                                        "</div>";
                                                }
                                                if ($items[0]->Type === "comment-box")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[0]->Question . "</h6>
                                                                    <div class='ui form'>
                                                                        <div class='field'>
                                                                            <textarea id='review-item-0' class='wix-textbox' rows='3' style='font-family: ".$site->TextFont.";'></textarea>
                                                                        </div>
                                                                    </div>";
                                                }

                                                if(count($items) > 1)
                                                {
                                                    $ret->Content .= "<div class='margin-t-4 align-r'>
                                                            <button class='ui button' style='color: white; 
                                                            background-color: ".$site->PrimaryColor.";' onclick='nextItemCon(0)'>Next</button>
                                                        </div>";
                                                }
                                                else
                                                {
                                                    $ret->Content .= "<div class='align-r margin-t-4 ' onclick='reviewCompleted()'>
                                                            <button class='ui button' style='color: white; background-color: ".$site->PrimaryColor.";'>Finish</button>
                                                        </div>";
                                                }

                                                $ret->Content .="
                                            </div>";

                                            for($i = 1; $i < count($items); $i++)
                                            {
                                                $ret->Content .= "
                                                <div class='review-con' id='review-item-".$i."-con' review-item-type='".$items[$i]->Type."' item-id='".$items[$i]->Id."' style='display: none;'>";
                                                if ($items[$i]->Type === "star-rating")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[$i]->Question . "</h6>
                                                            <div id='review-item-".$i."' class='ui huge star rating' data-rating='0' data-max-rating='" . $items[$i]->Maxrating . "'></div>";
                                                }
                                                if ($items[$i]->Type === "heart-rating")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[$i]->Question . "</h6>
                                                            <div id='review-item-".$i."' class='ui huge heart rating' data-rating='0' data-max-rating='" . $items[$i]->Maxrating . "'></div>";
                                                }
                                                if ($items[$i]->Type === "multiple-select")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[$i]->Question . "</h6>
                                                            <div class=''>";

                                                    for($j = 0; $j < count($items[$i]->Options); $j++)
                                                    {
                                                        $ret->Content .= "<br/><label><input id='review-item-".$i."-option-".$j."' data-text='".$items[$i]->Options[$j]."' class='filled-in' type='checkbox' /><span>
                                                                    <h6 style='display: inline; font-family: ".$site->BoldFont."; color: dimgray;'>".
                                                            $items[$i]->Options[$j]."</h6></span></label>";
                                                    }

                                                    $ret->Content .=
                                                        "</div>";
                                                }
                                                if ($items[$i]->Type === "single-select")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[$i]->Question . "</h6>
                                                            <div class=''>";

                                                            for($j = 0; $j < count($items[$i]->Options); $j++)
                                                            {
                                                                $ret->Content .= "<br/><label><input id='review-item-".$i."-option-".$j."' data-text='".$items[$i]->Options[$j]."' class='with-gap' name='select-option-".$i."' type='radio' /><span>
                                                                    <h6 style='display: inline; font-family: ".$site->BoldFont."; color: dimgray;'>".
                                                                    $items[$i]->Options[$j]."</h6></span></label>";
                                                            }

                                                            $ret->Content .=
                                                                "</div>";
                                                }
                                                if ($items[$i]->Type === "comment-box")
                                                {
                                                    $ret->Content .= "<h4 style='font-family: " . $site->TextFont . "; font-weight: bold;'>" . $items[$i]->Question . "</h6>
                                                            <div class='ui form'>
                                                                <div class='field'>
                                                                    <textarea id='review-item-".$i."' class='wix-textbox' rows='3' style='font-family: ".$site->TextFont.";'></textarea>
                                                                </div>
                                                            </div>";
                                                }

                                                if ((count($items) - 1) > $i)
                                                {
                                                    $ret->Content .= "<div class='margin-t-4 align-r'>
                                                                <button class='ui basic button' style='color: ".$site->PrimaryColor.";' onclick='previousItemCon(".$i.")'>Back</button>
                                                                <button class='ui button' style='color: white; 
                                                                background-color: ".$site->PrimaryColor.";' onclick='nextItemCon(".$i.")'>Next</button>
                                                            </div>";
                                                }
                                                else
                                                {
                                                    $ret->Content .= "<div class='align-r margin-t-4 '>
                                                                <button class='ui basic button' style='color: ".$site->PrimaryColor.";' onclick='previousItemCon(".$i.")'>Back</button>
                                                                <button class='ui button' style='color: white; background-color: ".$site->PrimaryColor.";' onclick='reviewCompleted()'>Finish</button>
                                                            </div>";
                                                }

                                                $ret->Content .= "
                                                </div>";
                                            }

                                            $ret->Content .="
                                        </div>
                                    </div>
                                </div>
                                <div id='reviews-completion-con' style='display: none;'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                            <img src='".$host."cdn/images/icons/pastel/check_outline.png' />
                                            <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>Response sent successfully</h4>
                                            <h6 style='font-family: ".$site->TextFont."; font-weight: bold; color: dimgray;'>Thank you for your time</h6>
                                            <br/>
                                            <a href='".Router::ResolvePath('home', $path)."'>
                                                <button class='ui button' style='background-color: ".$site->PrimaryColor."; 
                                                color: white; font-family: ".$site->SecondaryFont.";'><i class='home icon'></i>
                                                 Home</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id='review-loading-con' style='display: none;'>
                                    <div class='pad-3'>
                                        <div class='margin-t-5 margin-b-5 align-c'>
                                            <div class='ui huge active inline loader'></div>
                                            <br/><br/>
                                            <h4 style='font-family: ".$site->TextFont."; font-weight: bold;'>Sending response...</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";

                }
            }
        }

        require("addons/footer.php");
        $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.= "
                    </body>
                </html>";

    }
    end:;