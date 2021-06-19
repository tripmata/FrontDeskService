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

            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>
            
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/w3.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/semantic.min.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/mat.css'/>

            <link rel='stylesheet' type='text/css' href='".$cdn."/css/space_app.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/draw.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdesk1.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdesk2.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/frontdeskmenu.css'/>
            <link rel='stylesheet' type='text/css' href='".$cdn."/css/virtual-select.min.css'/>
            
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
            <script type='text/javascript'>var url = {\"storage\" : \"".$cdn."\", \"host\" : \"".$host."\", \"main\" : \"".$main."\", \"listing\" : \"".$listing."\"}</script>
            <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js'></script>
            <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js'></script>

            <script type='application/javascript' src='".$cdn."/js/jquery.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/functions.js'></script>
            <script type='application/javascript' src='".$cdn."/js/semantic.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/moment.min.js'></script>
            <script type='application/javascript' src='".$cdn."/js/lightpick.js'></script>
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

            <div id='wrapper'>
                <header class='main__header'>
                    <div class='header__container'>

                        <a href='#' class='header__logo'>".$propertyName."</a>

                        <!--<div class='header__search'>
                            <input type='search' placeholder='Search' class='header__input'>
                            <i class='bx bx-search header__icon'></i>
                        </div>-->

                        <div class='dropdown__options'>
                            <div class='dropdown dropdown-6 center__vertical'>
                                <i class='bx bxs-grid-alt' id='setting__icon'></i>

                                <ul class='dropdown_menu'>
                                    <li class='dropdown_item' onclick='openSavedOrder()'>                                
                                        <i class='bx bx-save'></i>Saved booking
                                    </li>
                                    <li class='dropdown_item' onclick='posAnalytics()'>                                
                                        <i class='pie chart icon center__vertical' style='display:flex;'></i>Report
                                    </li>
                                    <li class='dropdown_item' onclick='posTransactions()'> 
                                        <i class='bx bxs-briefcase'></i>Transactions                              
                                    </li>
                                    <li class='dropdown_item' onclick='loadPOSData({})'>                                
                                        <i class='bx bx-refresh'></i>Reload Data
                                    </li>
                                    <li class='dropdown_item' id='alert-toggle-con' onclick='toggleAlert()'>                                
                                        <i class='bx bxs-bell-ring'></i>Silence order alert
                                    </li>
                                    <li class='dropdown_item' id='preceipt-toggle-con' onclick='toggleReprint()'>
                                        <i class='bx bx-printer'></i>Disable receipt reprint
                                    </li>                        
                                </ul>
                            </div>                                                        
                                 
                            <button id='activity-con' class='ui white compact small button' style='font-family: Nunito;'>
                                <i class='spinner green-txt icon loading'></i> Connecting... 
                            </button>             

                            <div class='ui top right pointing dropdown' id='current_user' style='margin: 0px; padding-top: 4px; float: right; font-family: Lato; 
                                    font-size: 14px; color: dimgray; margin-right: 15px;'>
                                <div class='' style='color: white; font-family: Nunito;'>
                                    <i class='user circle icon'></i> ".$username."
                                    <i class='angle down icon'></i>
                                </div>
                                <div class='menu'>
                                    <div class='item' onclick='openSecurity()'><i class='shield icon'></i> Security</div>
                                </div>
                            </div>

                            <button class='ui basic compact inverted small button header__menubtn' style='float: right; font-family: Nunito; margin-right: 25px;' onclick='openDataQue()'>
                                <small>
                                    <i id='que-indicator' class='circle green icon'></i>
                                </small>
                                Data Que
                            </button>

                            <i class='bx bxs-bell' id='alert__btn'></i>

                        </div>

                        <div class='header__toggle'>
                            <i class='bx bx-menu' id='header-toggle'></i>
                        </div>
                    </div>
                </header>

                <div class='fontdesk__nav' id='navbar'>
                    <aside class='nav__container'>
                        <div>
                            <a href='#' class='nav__link nav__logo'>
                                <i class='bx bxs-disc nav__icon' ></i>
                                <span class='nav__logo-name'>Tripmata</span>
                            </a>
            
                            <div class='nav__list'>
                                <div class='nav__items'>
                                    <h3 class='nav__subtitle'>Frontdesk</h3>    

                                    <a id='checkin-tab' onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bx-calendar nav__icon' ></i>
                                        <span class='nav__name'>Calendar</span>
                                    </a>                                                        

                                    <a id='reservation-tab' onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bx-calendar-check nav__icon' ></i>
                                        <span class='nav__name'>Reservations</span>
                                    </a>

                                    <a id='checkout-tab' onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bx-calendar-x nav__icon' ></i>
                                        <span class='nav__name'>In-House/Depature</span>
                                    </a>

                                    <a id='guest-tab' onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bx-user nav__icon' ></i>
                                        <span class='nav__name'>Guests</span>
                                    </a>

                                    <div class='nav__dropdown'>
                                        <a href='#' class='nav__link'>
                                            <i class='bx bx-pie-chart-alt nav__icon' ></i>
                                            <span class='nav__name'>Report</span>
                                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                                        </a>

                                        <div class='nav__dropdown-collapse'>
                                            <div class='nav__dropdown-content'>
                                                <a onclick='switchTab(this)' id='revenue-tab' class='nav__dropdown-item'>Revenue</a>
                                                <a onclick='switchTab(this)' id='occuppancy-tab' class='nav__dropdown-item'>Occupancy</a>
                                                <a onclick='switchTab(this)' id='checkin-report-tab' class='nav__dropdown-item'>Checkin</a>
                                            </div>
                                        </div>
                                    </div>

                                    <a onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bxs-user-detail nav__icon' ></i>
                                        <span class='nav__name'>Guest Review</span>
                                    </a>

                                    <a onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bx-id-card nav__icon' ></i>
                                        <span class='nav__name'>Channel Manager</span>
                                    </a>

                                    <a onclick='switchTab(this)' class='nav__link'>
                                        <i class='bx bx-drink nav__icon' ></i>
                                        <span class='nav__name'>Room Service</span>
                                    </a>

                                    

                                    
                                </div>
                            </div>
                        </div>

                        <a onclick='logoutOutlet()' class='nav__link nav__logout'>
                            <i class='bx bx-log-out nav__icon' ></i>
                            <span class='nav__name'>Log Out</span>
                        </a>
                    </aside>
                </div>

                <main>
                    <section id='front-desk-main'>
                    </section>                    
                </main>
                
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
            </div>
            
            <input id='pos-user' type='hidden' value='".$user->Id."'/>
            
            <input id='currency-symbol' type='hidden' value='&#8358;'/>
            <input id='primary-color' type='hidden' value='rgb(0,100,140)'/>
            <input id='secondary-color' type='hidden' value='rgb(0,100,140)'/>
            <input id='business-name' type='hidden' value='".$user->Property->Name."'/>
            <input id='business-email' type='hidden' value=''/>
            <input id='business-name' type='hidden' value='".$user->Property->Name."'/>
        </body>
        <script type='application/javascript' src='".$cdn."/js/frontdesk2.js'></script>
        <script type='application/javascript' src='".$cdn."/js/frontdesk3.js'></script>
        <script type='application/javascript' src='".$cdn."/js/virtual-select.min.js'></script>

    </html>";