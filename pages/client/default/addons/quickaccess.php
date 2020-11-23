<?php

    $ret->Content .="
                    <span class='action-tabs l-hide' style='position: fixed; bottom: 80px; left: 22px; z-index: 300; display: none;'>
                        <button class='ui icon w3-card-2 circular big button w3-card-1' 
                            style='background-color: ".$site->PrimaryColor."; color: white;'>
                                <i class='bed icon'></i>
                        </button>
                        <label class='w3-text-shadow-white' style='color: ".
                        $site->PrimaryColor."; font-family: ".$site->SecondaryFont.";'>Select room</label>
                    </span>
                    
                    <span class='action-tabs l-hide' style='position: fixed; bottom: 135px; left: 22px; z-index: 300; display: none;'>
                        <button class='ui icon w3-card-2 circular large button w3-card-1' 
                            style='background-color: ".$site->PrimaryColor."; color: white;'>
                                <i class='utensils icon'></i>
                        </button>
                        <label class='w3-text-shadow-white' style='color: ".
                        $site->PrimaryColor."; font-family: ".$site->SecondaryFont.";'>Restaurant</label>
                    </span>
                    
                    <span class='action-tabs l-hide' style='position: fixed; bottom: 185px; left: 22px; z-index: 300; display: none;'>
                        <button class='ui icon w3-card-2 circular large button w3-card-1' 
                            style='background-color: ".$site->PrimaryColor."; color: white;'>
                                <i class='martini glass icon'></i>
                        </button>
                        <label class='w3-text-shadow-white' style='color: ".
                        $site->PrimaryColor."; font-family: ".$site->SecondaryFont.";'>Bar</label>
                    </span>
                    
                    <span class='action-tabs l-hide' style='position: fixed; bottom: 235px; left: 25px; z-index: 300; display: none;'>
                        <button class='ui icon w3-card-2 circular button w3-card-1' 
                            style='background-color: ".$site->PrimaryColor."; color: white;'>
                                <i class='birthday cake icon'></i>
                        </button>
                        <label class='w3-text-shadow-white' style='color: ".
                        $site->PrimaryColor."; font-family: ".$site->SecondaryFont.";'>Pastries</label>
                    </span>
                    
                    
                    <button class='ui icon pulse w3-card-2 circular huge button w3-card-1 l-hide' 
                        style='background-color: ".$site->PrimaryColor."; color: white; position: fixed;
                        bottom: 20px; left: 20px; z-index: 300;' onclick='toggleActionTab()'><i class='times icon'></i>
                    </button>";