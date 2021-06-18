<?php

    $user = new User($_REQUEST['usersess']);

    $propertyName = $user->Property->Name;
    $username = $user->Username;
    $font = "quicksandregular";
    $requestToken = isset($_REQUEST['handshake']) ? 'data-token="'.$_REQUEST['handshake'].'"' : '';

    // change username
    $username = $requestToken != '' ? 'Admin' : $username;

    // get main
    $main = $requestToken == '' ? '' : '<{domain}>';

    // create content
    $ret->Content = "
    <!DOCTYPE html>
    <html data-property='".$user->Property->Id."' ".$requestToken.">
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    
            <title>$propertyName : . Front Desk</title>
    
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/w3.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/mat.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/semantic.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/space_app.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/draw.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdesk1.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdesk2.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdeskmenu.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/bookingstrip1.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/lightpick.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/line-awesome.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."../client/css/croppie.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."../client/css/datepicker.min.css'/>
    
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/lato/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/quicksand/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/comfortaa/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/montserrat/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/nunito/stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/fonts/varelaround/stylesheet.css'/>
            <link rel='icon' type='image/png' href='".$cdn."/../../logo/favicon.png'/>
            <script type='text/javascript'>var url = {\"storage\" : \"".$cdn."\", \"host\" : \"".$host."\", \"main\" : \"".$main."\"}</script>
            <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js'></script>
            <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/jquery.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/functions.js'></script>
            <script type='application/javascript' src='".$cdn."/js/semantic.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/moment.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/lightpick.js'></script>
            <script type='application/javascript' src='".$cdn."/js/frontdesk1.js'></script>
            <script type='application/javascript' src='".$cdn."/js/frontdesk3.js'></script>
            <script type='application/javascript' src='".$cdn."/js/outlets.js'></script>
            <script type='application/javascript' src='".$cdn."/js/bookingstrip1.js'></script>
            <script type='application/javascript' src='".$cdn."/js/selection.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/print.min.js'></script>
            <script type='application/javascript' src='".$cdn."../client/js/croppie.min.js'></script>
            <script type='application/javascript' src='".$cdn."../client/js/datepicker.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/upload.js'></script>
            <style type='text/css'>.ui.payment-mode-wrapper .menu .item::after{display:none !important;}</style>
        </head>
        <body style=''>
            <input id='pos-type' type='hidden' value='frontdesk_item'/>
            <audio id='alertSound'>
                <source src='".$cdn."/sound/posalert.mp3' type='audio/mp3'/>
            </audio>
            <div>
                <div class='w3-container' style='padding: 4px; background-color: rgb(0,100,140); color: white;'>
                    <button id='logout-btn' class='ui sleak small compact red right floated button' onclick='logoutOutlet()'>Logout</button>
                    <div class='ui top right pointing dropdown' style='margin: 0px; padding-top: 4px; float: right; font-family: Lato; 
                            font-size: 14px; color: dimgray; margin-right: 15px;'>
                        <div class='' style='color: white; font-family: Nunito;'>
                            <i class='user circle icon'></i> ".$username."
                            <i class='angle down icon'></i>
                        </div>
                        <div class='menu'>
                            <div class='item' onclick='openSecurity()'><i class='shield icon'></i> Security</div>
                        </div>
                     </div>
                    <button class='ui basic compact inverted small button' style='float: right; font-family: Nunito; margin-right: 25px;' onclick='openDataQue()'>
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
                            <!--<div class='item' onclick='launchAddCustomer()'><i class='user circle icon'></i> Add customer</div>-->
                            <!--<div class='item' onclick='launchAddStaff()'><i class='group icon'></i> Add staff</div>-->
                            <div class='divider'></div>
                            <div class='item' onclick='posTransactions()'><i class='shopping bag icon'></i> Transactions</div>
                            <div class='item' onclick='posAnalytics()'><i class='pie chart icon'></i> Report</div>
                            <div class='divider'></div>
                            <div class='item' onclick='loadPOSData({})'><i class='sync alternate icon'></i> Reload data</div>
                            <div id='alert-toggle-con' class='item' onclick='toggleAlert()'><i class='bell icon'></i> Silence order alert</div>
                            <!--<div id='pmethod-toggle-con' class='item' onclick='togglePMethodRetain()'><i class='money icon'></i> Retain payment method</div>-->
                            <div id='preceipt-toggle-con' class='item' onclick='toggleReprint()'><i class='print icon'></i> Disable receipt reprint</div>
                        </div>
                    </div>
                    
                    <h6 style='margin: 0px; padding-top: 4px; font-family: Nunito; display: inline-block;'>
                        ".$propertyName."
                    </h6>
                    <button id='activity-con' class='ui white compact small button' style='font-family: Nunito;'>
                    <i class='spinner green-txt icon loading'></i> Connecting... 
                    </button>
                    <span style='color: lightgray; font-family: Nunito;'>FrontDesk</span>
                </div>
            </div>               
            
            <div class='ui menu' style='margin: 0; border-radius: 0;'>
                <a id='checkin-tab' class='active front-desk-tab item' onclick='switchTab(this)' style='font-family: Nunito;'>
                    <i class='la la-calendar' style='font-size: 26px;'></i> &nbsp;Calendar
                </a>
                <a id='checkout-tab' class='item front-desk-tab' onclick='switchTab(this)' style='font-family: Nunito;'>
                    <i class='la la-calendar-times-o' style='font-size: 26px;'></i> &nbsp;In-House / Departure
                </a>
                <a id='reservation-tab' class='item front-desk-tab' onclick='switchTab(this)' style='font-family: Nunito;'>
                    <i class='la la-calendar-check-o' style='font-size: 26px;'></i> &nbsp;Reservations
                </a>
                <a id='guest-tab' class='item front-desk-tab' onclick='switchTab(this)' style='font-family: Nunito;'>
                    <i class='la la-user' style='font-size: 26px;'></i> &nbsp;Customers
                </a>
                <a id='report-tab' class='item front-desk-tab' onclick='switchTab(this)' style='font-family: Nunito;'>
                    <i class='la la-chart-pie' style='font-size: 26px;'></i> &nbsp;Report
                </a>
                
                <div class='right menu'>
                     <a class='item'>
                        <div class='n-dropdown'>
                           <label class='n-dropbtn' id='order-con' style='cursor: pointer; font-size: 18px; '>
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
                    <a class='item'>
                        <button class='ui blue compact small button'>
                             Guest request
                        </button>
                    </a>
                </div>
            </div>
            
            <div id='front-desk-main'></div>

            <div id='frontdesk__modal' class='frontdesk__modal'>
                <div class='frontdesk__modalcontent animate-zoom'>
                    <div id='frontdesk__cont' style='overflow:auto;height:100%;'></div>                    
                </div>
            </div>

            <div id='update__reservation' class='frontdesk__modal'>
                <div id='update__reservationinner' class='form__modalcontent animate-zoom'></div>
            </div>
            <div id='preview__reservation' class='frontdesk__modal'>
                <div id='preview__reservationinner' class='form__modalcontent animate-zoom'></div>
            </div>
            
            <input id='pos-user' type='hidden' value='".$user->Id."'/>
            
            <input id='currency-symbol' type='hidden' value='&#8358;'/>
            <input id='primary-color' type='hidden' value='rgb(0,100,140)'/>
            <input id='secondary-color' type='hidden' value='rgb(0,100,140)'/>
            <input id='business-name' type='hidden' value='".$user->Property->Name."'/>
            <input id='business-email' type='hidden' value=''/>
            <input id='business-name' type='hidden' value='".$user->Property->Name."'/>
        </body>
    </html>";