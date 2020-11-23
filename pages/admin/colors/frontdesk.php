<?php

    $username = "";

    $user = new User($subscriber);
    $user->Initialize($_REQUEST['usersess']);

    if($_REQUEST['usersess'] == $subscriber->Id)
    {
        $username = "Admin Main";
    }
    else if(($user->Id != "") && ($user->Role->Frontdesk->WriteAccess))
    {
        $username = $user->Name." ".$user->Surname;
    }
    else
    {
        require_once ("error/access_denied_page.php");
        goto end;
    }

    $ret->Content = "

            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />

                    <title>Frontdesk . : ".$subscriber->BusinessName."</title>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/w3.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/mat.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/semantic.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/space_app.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/draw.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/datepicker.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/frontdesk.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/bookingstrip.css'/>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/lato/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/quicksand/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/montserrat/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/nunito/stylesheet.css'/>

					<script type='application/javascript' src='".$host."cdn/js/jquery.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/functions.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/semantic.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/datepicker.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/frontdesk.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/outlets.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/bookingstrip.js'></script>

                </head>
                <body style=''>
                    <div>
                        <div class='w3-container' style='padding: 4px; background-color: rgb(0,100,140); color: white;'>
                            <button class='ui sleak small compact red right floated button' onclick='logoutOutlet()'>Logout</button>
                            <div class='ui top right pointing dropdown' style='margin: 0px; padding-top: 4px; float: right; font-family: Lato; 
                                    font-size: 14px; color: dimgray; margin-right: 15px;'>
                                <div class='' style='color: white;'>
                                    <i class='user circle icon'></i> ".$username."
                                    <i class='angle down icon'></i>
                                </div>
                                <div class='menu'>
                                    <div class='item'><i class='user circle icon'></i> My Profile</div>
                                    <div class='item'><i class='area chart icon'></i> Report</div>
                                    <div class='divider'></div>
                                    <div class='item' onclick='openSecurity()'><i class='shield icon'></i> Security</div>
                                </div>
                             </div>
                            <button class='ui basic compact inverted small sleak-m button' style='float: right; margin-right: 25px;' onclick='openDataQue()'>
                                <small>
                                    <i class='circle green-txt icon'></i>
                                </small>
                                 Data Que
                            </button>
                            
                            <h6 style='margin: 0px; padding-top: 3px; float: right; font-family: Lato; 
                            font-size: 14px; color: white; margin-right: 25px; cursor: pointer;'>
                            <i class='th large icon'></i>
                            </h6>
                            
                            <h6 style='margin: 0px; padding-top: 4px; font-family: nunitoregular; display: inline-block;'>
                            ".$subscriber->BusinessName."</h6>
                            <button class='ui white sleak compact small button'><i class='spinner green-txt icon loading'></i> Connecting... </button>
                        </div>
                    </div>
                    <div>
                        <div class='lift-1'>
                            <div class='l-width-8' style='margin: auto;'>
                                <div class='w3-row'>
                                    <div class='w3-col l3 m4 s6'>
                                        <div class='align-c'>
                                            <div class='frontdesk-menu'>
                                                <img src='".$host."cdn/images/icons/pastel/map.png' style='width: 50px;'/>
                                                <h6 style='margin: 0px; font-family: Lato;'>Check In</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='w3-col l3 m4 s6'>
                                        <div class='align-c'>
                                            <div class='frontdesk-menu'>
                                                <img src='".$host."cdn/images/icons/pastel/guest_list.png' style='width: 50px;'/>
                                                <h6 style='margin: 0px; font-family: Lato;'>Guests List</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='w3-col l3 m4 s6'>
                                        <div class='align-c'>
                                            <div class='frontdesk-menu'>
                                                <img src='".$host."cdn/images/icons/pastel/calendar_2.png' style='width: 50px;'/>
                                                <h6 style='margin: 0px; font-family: Lato;'>Reservations</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='w3-col l3 m4 s6'>
                                        <div class='align-c'>
                                            <div class='frontdesk-menu'>
                                                <img src='".$host."cdn/images/icons/pastel/luggage.png' style='width: 50px;'/>
                                                <h6 style='margin: 0px; font-family: Lato;'>Check outs</h6>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					<div id='booking-strip' style='margin-top: 20px;'>
						
					</div>
                    
                    
					<input id='get-customers-address' type='hidden' value='false'/>
					<input id='system-role-access' type='hidden' value='false'/>
					<input id='currency-symbol' type='hidden' value='".$subscriber->Currency->Symbol."'/>
                </body>
            </html>";


    end:;