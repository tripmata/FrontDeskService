<?php

    $username = "";

    
	/*
	if(!isset($_REQUEST['usageset']))
	{
		require_once ("error/access_denied_page.php");
        goto end;
	}
    else
    {
		if($_REQUEST['usageset'] != "attendance")
		{
			require_once ("error/access_denied_page.php");
			goto end;
		}
    }
	*/

    $ret->Content = "

            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />

                    <title>Restaurant POS . : ".$subscriber->BusinessName."</title>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/w3.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/mat.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/semantic.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/space_app.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/draw.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/datepicker.min.css'/>
				

					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/lato/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/quicksand/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/montserrat/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/nunito/stylesheet.css'/>

					<script type='application/javascript' src='".$host."cdn/js/jquery.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/functions.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/semantic.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/datepicker.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/attendance.js'></script>

                </head>
                <body style=''>
                    <div>
                        <div class='w3-container' style='padding: 4px; background-color: rgb(0,100,140);'>
                            <button class='ui sleak small compact red right floated button'>Exit / close</button>
                            <button class='ui basic inverted compact small sleak-m button' style='float: right; margin-right: 20px;' onclick='openDataQue()'>
                                <small>
                                    <i class='circle green-txt icon'></i>
                                </small>
                                Data Que
                            </button>
                            
                            <h6 style='margin: 0px; padding-top: 4px; font-family: nunitoregular; color: white;  display: inline-block;'>
                            ".$subscriber->BusinessName."</h6>
                            <button class='ui white sleak compact small button'><i class='spinner green-txt icon loading'></i> Connecting... </button>
                        </div>
                    </div>
                    <div>
                        <div class='lift-1 pad-1'>
                            <div class='l-width-8' style='margin: auto;'>
                                <div class='w3-row'>
									<div class='w3-col l1 m1 s3'>
										<img src='".$host."cdn/images/icons/pastel/people.png' style='width: 60px;'/>
									</div>
									<div class='w3-col l8 m6 s6'>
										<div style='padding-top: 10px;'>
											<h2 class='sleak' style='margin-top: 6px; font-weight: normal; color: dimgray;'>Staff Attendance</h2>
										</div>
									</div>
									<div class='w3-col l3 m1 s6 align-r'>
										<h2 style='margin-top: 15px; cursor: pointer;'>
											<i class='search blue-txt icon'></i>
										</h2>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					<div class='l-margin-t-8'>
						<div>
							<div class='align-c'>";
								
								if($subscriber->Attendancemethod == "fingerprint")
								{
									$ret->Content .=
									"<img src='".$host."cdn/images/icons/pastel/fingerprint_rec.png' style=''/>
									<br/>
									<h3 class='sleak-b' style='font-weight: normal; color: dimgray;'>
										Scan your right tomb to sign in / out
									</h3>";
								}
								else if($subscriber->Attendancemethod == "idcard")
								{
									$ret->Content .=
									"<img src='".$host."cdn/images/icons/pastel/idcard.png' style='width: 120px;'/>
									<br/>
									<h3 class='sleak-b' style='font-weight: normal; color: dimgray;'>
										Scan your ID card to sign in / out
									</h3>";
								}
								else
								{
									$ret->Content .=
									"<img src='".$host."cdn/images/icons/pastel/fingerprint_rec.png' style=''/>
									<br/><br/>
									<h3 class='sleak-b' style='font-weight: normal; color: dimgray;'>
										Unbale to determin attendance data gathering method
									</h3>";
								}
								
								$ret->Content .=
								"<h2 id='time-con' style='font-family: nunitoregular; font-weight: normal;'>00:00:00</h2>
								<h6 id='date-con' style='font-family: nunitoregular; font-weight: normal;'></h6>
							</div>
						</div>
					</div>
					
					
                    
					<input id='get-customers-address' type='hidden' value='false'/>
					<input id='system-role-access' type='hidden' value='false'/>
					<input id='currency-symbol' type='hidden' value='".$subscriber->Currency->Symbol."'/>
					<input id='time-format' type='hidden' value='12'/>
					<input id='show-seconds' type='hidden' value='true'/>
                </body>
            </html>";


end:;