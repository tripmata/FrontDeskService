<?php

    if(!$modules->Kitchen)
    {
        require_once ("addons/404.php");
    }
    else
    {
        $category = "all";
        $pagenum = 1;

        $args = $router->Args;

        if(isset($args[0]))
        {
            $category = $args[0];
        }
        if(isset($args[1]))
        {
            $pagenum = Convert::ToInt($args[1]);
        }

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
                    <meta name='description' content='".Seo::Metadescription($subscriber, $seo->Pastrydescription, Seo::Pastry)."'/>
                    <meta name='keywords' content='".Seo::MetaKeywords($subscriber, $seo->Pastrykeywords, Seo::Pastry)."'/>
                    
                    <!-- End Seo -->
                    
                    <title>".Seo::BuildTitle($subscriber,"Pastries | " . $subscriber->BusinessName, Seo::Pastry)."</title>
                    
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
                    <div class='pad-2' style=' background-image: url(".$host."/cdn/themes/default/images/pastry_back.jpg".");
                    background-position: center; background-repeat: no-repeat; background-size: cover;'>
                         <div class='l-width-8' style='margin: auto;'>
                            <div class='l-margin-t-3'>
                                <div class='w3-row'>
                                    <div class='w3-col l1 m1 s2'>
                                        <img src='".$host."/cdn/images/icons/pastel/chocolate_cake.png' style='width: 65px; max-width: 100%;'/>
                                    </div>
                                    <div class='w3-col l11 m11 s10'>
                                        <h3 style='color: white; dimgray; font-family: ".$site->BoldFont."; margin-top: 20px;'>
                                            Pastry Corner
                                        </h3>
                                    </div>
                                </div>
                                <br/>
                                <div class='ui white-text breadcrumb'>
                                  <a href='".Router::ResolvePath("home", $path)."' class='section white-text' style='font-family: ".$site->SecondaryFont."'>Home</a>
                                  <i class='right chevron white-text icon divider'></i>
                                  <div class='section' style='font-family: ".$site->SecondaryFont."'>Pastry</div>
                                </div>
                            </div>
                        </div>
                    </div>";



                    $pastrycat = Pastrycategory::Order($subscriber, 'sort', 'DESC');

                    $catvalidlist = [];

                    for($i = 0; $i < count($pastrycat); $i++)
                    {
                        if($pastrycat[$i]->Status)
                        {
                            array_push($catvalidlist, $pastrycat[$i]);
                        }
                    }



                    $ret->Content .=
                        "<div class='l-hide'>
                            <div class='pad-1' style='background-color: rgb(250,251,255);'>
                                <div class='ui fluid search large pastry-search margin-t-1'>
                                    <div class='ui fluid icon input'>
                                        <input class='prompt' type='text' placeholder='Search pastries'>
                                        <i class='search inverted link icon' style='color: ".$site->PrimaryColor."'></i>
                                    </div>
                                    <div class='results'></div>
                                </div>
                            </div>
                        </div>";


                        if(count($catvalidlist) > 0)
                        {
                            $ret->Content .=
                                "<div class='l-hide' style='background-color: rgb(250,251,255);'>
                                    <div>
                                        <div class='pad-2'>
                                            <h6 class='ui header' style='float: right; margin: 0px; color: ".
                                                $site->PrimaryColor.";' onclick='showMobileCat()'>
                                                <i class='bars icon'></i>
                                            </h6>
                                            <h6 style='font-family: " . $site->TextFont . "; margin: 0px; 
                                            color: " . $site->PrimaryColor . "; font-weight: bold;'>
                                                Pastry Categories
                                            </h6>
                                        </div>
                                    </div>
                                </div>";
                        }



                $catt = $category == "all" ? "default" : $category;

                $cat = Pastrycategory::ByMeta($subscriber, $catt);

                $pastry = Pastry::Bycategory($subscriber, $cat, 'sort', 'DESC');




                $ret->Content .= "
                    <div class='w3-row l-width-l' style='margin: auto;'>
                        <div class='w3-col l8 m8 s12 s-margin-b-1'>
                            <div class='margin-t-2' style=''>
                                
                                <div class='l-width-8 pad-1' style='margin: auto;'>
                                    ".((($cat->Id != "") && ($cat->Id != "default")) ?
                                    "<h3 style='color: ".$site->PrimaryColor."; font-family: ".$site->TextFont."; display: inline;'>
                                    <i class='birthday cake icon'></i>".
                                    $cat->Name."</h3>" : "")."
                                    <h5 style='font-family: ".$site->TextFont."; color: dimgray;'>
                                        Showing ".(($pagenum * 12) - 11)." - ".
                                        ((($pagenum * 12) < count($pastry)) ? ($pagenum * 12) : count($pastry))
                                        ." of ".count($pastry)."
                                    </h5>
                                </div>
                                
                                <div class='w3-row l-width-8 s-width-xl' style='margin: auto;'>";

                                //$food = Food::Order($subscriber, 'sort', 'ASC');

                                $shown = 0;

                                for($i = (($pagenum - 1) * 12); $i < count($pastry); $i++)
                                {
                                    if(($pastry[$i]->Status) && ($pastry[$i]->Onsite))
                                    {
                                        $ret->Content .= "<div class='w3-col l4 m4 s6'>
                                            <div class='l-width-9 s-pad-t' style='margin: auto;'>
                                                <div class='widget margin-t-2 hover-item' style='cursor: pointer;' onclick=\"reservePastry('".$pastry[$i]->Id."')\">
                                                    <div style='position: relative;'>
                                                        <img src='".Router::ResolvePath("files/" . $pastry[$i]->Images[0], $path)."' style='width: 100%; border-radius: 6px;'/>
                                                        <div class='pad-1' style='position: absolute; top: 0px; width: 100%; height: 100%; border-radius: 6px;
                                                        background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,0), rgba(255,255,255,0), rgb(0,0,0));'>
                                                            <h6 style='color: white; bottom: 0px; left: 10px; font-family: ".$site->SecondaryFont."; position: absolute;'>
                                                                <span style='font-family: arial;'>".
                                                                $subscriber->Currency->Symbol."</span>".
                                                                number_format($pastry[$i]->Price, 2)."
                                                                &nbsp;&nbsp;&nbsp;&nbsp;".
                                                                ($pastry[$i]->Compareat > 0 ?  "<s>
                                                                <span style='font-family: Arial;'>".
                                                                $subscriber->Currency->Symbol."</span>".
                                                                number_format($pastry[$i]->Compareat, 2)."</s>" : "")."
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='pad-2 align-c' style='min-height: 110px;'>
                                                    <h6 style='color: black; font-family: ".$site->TextFont.";'>
                                                        <small><small><small>
                                                            <i class='circle icon' style='color: ".
                                                            $site->PrimaryColor.";'></i>
                                                        </small></small></small>"
                                                        .$pastry[$i]->Name.
                                                    "</h6>
                                                </div>
                                            </div>
                                        </div>";
                                        $shown++;
                                    }
                                    if($shown >= 12)
                                    {
                                        break;
                                    }
                                }

                                $ret->Content .= "</div>
                                </div>";

                                $num = count($pastry) / 12;


                                $ret->Content .=
                                    "<div>
                                        <div class='align-c'>
                                            <div class='ui compact menu pagination'>";

                                                if($pagenum > 1)
                                                {
                                                    $ret->Content .= "<a href='".Router::ResolvePath('pastries/'.$category."/".($pagenum - 1), $path)."'
                                                                    class='icon item' style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>
                                                                        <i class='left chevron icon'></i></a>";
                                                }
                                                for($i = 0; $i < $num; $i++)
                                                {
                                                    if($pagenum == ($i + 1))
                                                    {
                                                        $ret->Content .= "<a class='active item' style='font-family: ".
                                                            $site->TextFont."; color: ".$site->PrimaryColor.";'>".($i + 1)."</a>";
                                                    }
                                                    else
                                                    {
                                                        $ret->Content .= "<a href='".Router::ResolvePath('pastries/'.$category."/".($i + 1), $path)."' 
                                                        class='item' style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>".($i + 1)."</a>";
                                                    }
                                                }
                                                if($pagenum < $num)
                                                {
                                                    $ret->Content .= "<a href='".Router::ResolvePath('pastries/'.$category."/".($pagenum + 1), $path)."'
                                                    class='icon item' style='font-family: ".$site->TextFont."; color: ".$site->PrimaryColor.";'>
                                                    <i class='right chevron icon'></i></a>";
                                                }
                                                $ret->Content .=
                                            "</div>
                                        </div>
                                    </div>";

                                $ret->Content .="
                            </div>
                            <div class='w3-col l4 m4 s12'>
                                <div class='l-width-7' style='margin-top: 50px;'>";


                                    $ret->Content .=
                                    "<div class='s-hide'>
                                        <div class='pad-1' style='background-color: rgb(250,251,255);'>
                                            <div class='ui pastry-search fluid search'>
                                                <div class='ui fluid large icon input'>
                                                    <input class='prompt' type='text' placeholder='Search pastries'>
                                                    <i class='search inverted link icon' style='color: ".$site->PrimaryColor."'></i>
                                                </div>
                                                <div class='results'></div>
                                            </div>
                                        </div>
                                    </div>";


                                    if(count($catvalidlist) > 0)
                                    {
                                        $ret->Content .=
                                            "<div class='s-hide' style='margin-top: 10px; background-color: rgb(250,251,255);'>
                                                <div>
                                                    <div class='pad-2'>
                                                        <h5 style='font-family: ".$site->TextFont."; 
                                                        color: ".$site->PrimaryColor."; font-weight: bold;'>
                                                            Pastry Categories
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div id='category-content'>";

                                                    $ret->Content .=
                                                        "<a href='".Router::ResolvePath('pastries/all/1', $path)."'>
                                                            <div class='pad-1 hoverable'            
                                                                style='border-bottom: 1px solid whitesmoke; 
                                                                cursor: pointer;'>
                                                                <h6 style='font-family: ".$site->TextFont.";'>
                                                                    - &nbsp;All
                                                                </h6>
                                                            </div>
                                                        </a>";

                                                    for($j = 0; $j < count($catvalidlist); $j++)
                                                    {
                                                        $ret->Content .=
                                                        "<a href='".Router::ResolvePath('pastries/'.$catvalidlist[$j]->Meta.'/1', $path)."'>
                                                            <div class='pad-1 hoverable'            
                                                                style='border-bottom: 1px solid whitesmoke; 
                                                                cursor: pointer;'>
                                                                <h6 style='font-family: ".$site->TextFont.";'>
                                                                 - &nbsp;".$catvalidlist[$j]->Name.
                                                                "</h6>
                                                            </div>
                                                        </a>";
                                                    }

                                                    $ret->Content .="
                                                    </div>
                                                </div>
                                            </div>";
                                    }



                                    if(count($catvalidlist) > 0)
                                    {
                                        $ret->Content .=
                                            "<div style='margin-top: 10px; background-color: rgb(250,251,255);'>
                                                <div>
                                                    <div class='pad-2'>
                                                        <h5 style='font-family: ".$site->TextFont."; 
                                                        color: ".$site->PrimaryColor."; font-weight: bold;'>
                                                            Popular pastries
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div>";

                                                    $popular = Pastry::ByPopularity($subscriber);

                                                    for($j = 0; $j < count($popular); $j++)
                                                    {
                                                        $ret->Content .= "
                                                        <div class='w3-row hover-item' style='cursor: pointer;' onclick=\"reservePastry('".$popular[$i]->Id."')\">
                                                            <div class='w3-col l4 m4 s4 pad-1'>
                                                                <img src='".Router::ResolvePath("files/".$popular[$j]->Images[0], $path)."' style='width: 100%;'/>
                                                            </div>
                                                            <div class='w3-col l8  m8 s8 pad-1'>
                                                                <h6 style='font-family: ".$site->TextFont."; 
                                                                margin: 0px; margin-bottom: 3px;'>
                                                                ".$popular[$j]->Name.
                                                                "</h6>
                                                                 <h6 style='font-family: ".$site->TextFont."; 
                                                                 margin: 0px; color: ".$site->PrimaryColor."; margin-bottom: 3px;'>".
                                                                ($popular[$j]->Category->Id != "default" ?
                                                                "<small>".$popular[$j]->Category->Name."</small><br>" : "").
                                                                "<small><span style='font-family: Arial;'> ".
                                                                $subscriber->Currency->Symbol."</span>
                                                                ".number_format($popular[$j]->Price, 2)."</small>".
                                                                "</h6>
                                                            </div>
                                                        </div>";

                                                        if($j >= 3) {break;}
                                                    }

                                                    $ret->Content .="
                                                    </div>
                                                </div>
                                            </div>";
                                    }


                                    $ret->Content .= "
                                </div>
                            </div>
                        </div>";


                require("addons/footer.php");

                $ret->Content .= $integrations->Livechat.$integrations->Analytics.$integrations->Googletag."
                </body>
            </html>";
    }