<?php

    $propertyName = "Centurion apartment";
    $username = "Dain";


    $ret->Content = "
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    
            <title>Trip mata : . Front Desk</title>
    
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/w3.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/mat.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/semantic.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/space_app.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/draw.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdesk.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/bookingstrip.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/lightpick.css'/>
    
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/lato/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/quicksand/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/comfortaa/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/montserrat/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/nunito/stylesheet.css'/>
    
            <script type='application/javascript' src='".$cdn."/js/jquery.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/functions.js'></script>
            <script type='application/javascript' src='".$cdn."/js/semantic.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/moment.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/lightpick.js'></script>
            <script type='application/javascript' src='".$cdn."/js/frontdesk.js'></script>
            <script type='application/javascript' src='".$cdn."/js/outlets.js'></script>
            <script type='application/javascript' src='".$cdn."/js/bookingstrip.js'></script>
        </head>
        <body style=''>
            <input id='pos-type' type='hidden' value='frontdesk_item'/>
            <audio id='alertSound'>
                <source src='".$cdn."/sound/posalert.mp3' type='audio/mp3';></source>
            </audio>
            <div>
                <div class='w3-container' style='padding: 4px; background-color: rgb(0,100,140); color: white;'>
                    <button id='logout-btn' class='ui sleak small compact red right floated button' onclick='logoutOutlet()'>Logout</button>
                    <div class='ui top right pointing dropdown' style='margin: 0px; padding-top: 4px; float: right; font-family: Lato; 
                            font-size: 14px; color: dimgray; margin-right: 15px;'>
                        <div class='' style='color: white;'>
                            <i class='user circle icon'></i> ".$username."
                            <i class='angle down icon'></i>
                        </div>
                        <div class='menu'>
                            <div class='item' onclick='openSecurity()'><i class='shield icon'></i> Security</div>
                        </div>
                     </div>
                    <button class='ui basic compact inverted small sleak-m button' style='float: right; margin-right: 25px;' onclick='openDataQue()'>
                        <small>
                            <i id='que-indicator' class='circle green icon'></i>
                        </small>
                         Data Que
                    </button>
                    
                    <div class='ui top right pointing dropdown' style='margin: 0px; padding-top: 4px; float: right; font-family: Lato; 
                            font-size: 14px; color: dimgray; margin-right: 25px;'>
                        <h6 style='margin: 0px; padding-top: 3px; float: right; font-family: Lato; 
                        font-size: 14px; color: white; cursor: pointer;'>
                        <i class='th large icon'></i>
                        </h6>
                        <div class='menu'>
                            <div class='item' onclick='openSavedOrder()'><i class='save icon'></i> Saved booking</div>
                            <div class='item' onclick='launchAddCustomer()'><i class='user circle icon'></i> Add customer</div>
                            <div class='item' onclick='launchAddStaff()'><i class='group icon'></i> Add staff</div>
                            <div class='divider'></div>
                            <div class='item' onclick='posTransactions()'><i class='shopping bag icon'></i> Transactions</div>
                            <div class='item' onclick='posAnalytics()'><i class='pie chart icon'></i> Report</div>
                            <div class='divider'></div>
                            <div class='item' onclick='loadPOSData({})'><i class='sync alternate icon'></i> Reload data</div>
                            <div id='alert-toggle-con' class='item' onclick='toggleAlert()'><i class='bell icon'></i> Silence order alert</div>
                            <div id='pmethod-toggle-con' class='item' onclick='togglePMethodRetain()'><i class='money icon'></i> Retain payment method</div>
                            <div id='preceipt-toggle-con' class='item' onclick='toggleReprint()'><i class='print icon'></i> Disable receipt reprint</div>
                        </div>
                    </div>
                    
                    <h6 style='margin: 0px; padding-top: 4px; font-family: nunitoregular; display: inline-block;'>
                    ".$propertyName."</h6>
                    <button id='activity-con' class='ui white sleak compact small button'><i class='spinner green-txt icon loading'></i> Connecting... </button>
                    <span style='color: lightgray;'>FrontDesk</span>
                </div>
            </div>               
            
            <div class='ui menu' style='margin: 0; border-radius: 0;'>
                <div class='active item'>
                    <i class='calendar alternate outline green check icon'></i> Arrivals
                </div>
                <a class='item'>
                    <i class='calendar alternate outline times red icon'></i> Departure
                </a>
                <a class='item'>
                    <i class='group blue icon'></i> Guests
                </a>
                <a class='item'>
                    <i class='calendar alternate outline blue icon'></i> Reservations
                </a>
                
                <div class='right menu'>
                <a class='ui item'>
                    <div class='n-dropdown'>
                       <label class='n-dropbtn' id='order-con' style='margin-top: 20px; cursor: pointer; font-size: 21px;'>
                            <i id='order-bell' class='bell red icon' style='position: relative;' onclick='openNotification()'>
                                <span id='alert-num' class='sleak' style='position: absolute; top: -10px; 
                                right: -10px;color: steelblue; 
                                border-radius: 50%; font-size: 14px; display: none;'>0</span>
                            </i>
                        </label>
                       <div id='noteDropdown' class='n-dropdown-content' style=''>
                       </div>
                   </div>
                </a>
                <div class='item'>
                  <div class='ui icon input'>
                    <input type='text' placeholder='Search...'>
                    <i class='search link icon'></i>
                  </div>
                </div>
              </div>
            </div>
            
            <div id='front-desk-main'></div>
            
        </body>
    </html>";

