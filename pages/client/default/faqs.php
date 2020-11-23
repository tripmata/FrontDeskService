<?php

    if(!$modules->Faq)
    {
        require_once ("addons/404.php");
    }
    else
    {
        $integrations = new Integration($subscriber);
        $seo = new Seo($subscriber);

        $ret->Content = "<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                    
                    <!-- Seo -->
            
                    <meta name='robots' content='index, follow'/>
                    <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Homedescription, Seo::Faq)."'/>
                    <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Homekeywords, Seo::Faq)."'/>
                    
                    <!-- End Seo -->
                    
                    <title>".Seo::BuildTitle($subscriber,"FAQs | " . $subscriber->BusinessName, Seo::Faq)."</title>
                    
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
                <body>";
                require("addons/header.php");

                $ret->Content .= "
                    <div class='l-width-8 s-width-xl' style='margin: auto;'>
                        <div class='l-margin-t-3 s-margin-t-2'>
                            <h5 style='color: dimgray; font-family: ".$site->BoldFont.";'>
                                <div class='icon-block' style='color: white; background-color: 
                                ".$site->PrimaryColor."; font-family: ".$site->TextFont.";'>
                                <i class='question icon'></i></div> Frequently Asked Questions
                            </h5><hr>
                            <div class='ui breadcrumb'>
                              <a class='section' style='font-family: ".$site->SecondaryFont.";'>Home</a>
                              <i class='right chevron icon divider'></i>
                              <div class='section' style='color: black; font-family: ".$site->SecondaryFont.";'>FAQs</div>
                            </div>
                            <div class='margin-t-5'>
                                <div class=''>";

                $category = Faqcategory::Order($subscriber, 'sort', 'ASC');

                for ($i = 0; $i < count($category); $i++)
                {
                    if ($category[$i]->Status == true)
                    {
                        $ret->Content .= "<h4 style='font-family: montserratmedium; color: dimgray; 
                        font-family: ".$site->SecondaryFont."; font-weight: bold;'>" . $category[$i]->Name . "</h4>";

                        $content = Faq::Filter($subscriber, $category[$i]->Id, 'category', 'ORDER BY sort ASC');

                        if (count($content) > 0)
                        {
                            $ret->Content .= "<ul class='collapsible' style='list-style: none; margin: 0px; padding: 0px;;'>";

                            for ($j = 0; $j < count($content); $j++)
                            {
                                if($content[$j]->Status)
                                {
                                    $ret->Content .= "<li>
                                      <div class='collapsible-header' style='font-family: " . $site->TextFont . "; font-weight: bold;'>
                                      <i class='question circle icon' style='color: " . $site->PrimaryColor . "; font-size: 14px;'>
                                      </i>" . $content[$j]->Question . "</div>
                                      <div class='collapsible-body' style='font-size: 15px; color: dimgray; font-family: " . $site->SecondaryFont . ";'>
                                      <span>" . $content[$j]->Answer . "</span></div>
                                    </li>";
                                }
                            }

                            $ret->Content .= "</ul><br/>";
                        }
                        else
                        {
                            $ret->Content .= "<div class='pad-3 curve' style='background-color: whitesmoke;'>
                                    <h6 style='font-family: ".$site->TextFont."; color: silver;'>
                                    No Content for this FAQ Category</h6></div><br/>";
                        }
                    }
                }


                $ret->Content .=

                    "</div>
                            </div>
                        </div>
                    </div>";


                require("addons/footer.php");
                $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag.= "
                </body>
            </html>";
    }
