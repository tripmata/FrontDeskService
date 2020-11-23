<?php

    $username = "";

    $user = new User($subscriber);
    $user->Initialize($_REQUEST['usersess']);

    $module = new Modules($subscriber);

    $payment = new Paygateway($subscriber);


    if($_REQUEST['usersess'] == $subscriber->Id)
    {
        $username = "Admin Main";
    }
    else if(($user->Id != "") && ($user->Role->Barpos->WriteAccess))
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

                    <title>Restaurant POS . : ".$subscriber->BusinessName."</title>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/w3.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/mat.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/semantic.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/space_app.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/draw.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/datepicker.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/frontdesk.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/kitchenpos.css'/>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/lato/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/quicksand/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/montserrat/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/nunito/stylesheet.css'/>

					<script type='application/javascript' src='".$host."cdn/js/jquery.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/functions.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/semantic.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/datepicker.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/outlets.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/barpos.js'></script>

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
							<span style='color: lightgray;'>Bar / Drinks</span>
                        </div>
                    </div>
                    <div>
                        <div class='lift-1 pad-1'>
                            <div class='l-width-8' style='margin: auto;'>
                                <div class='w3-row'>
                                   
									<div class='w3-col l1 m1 s3'>
										<img src='".$host."cdn/images/icons/pastel/glass_cups.png' style='width: 60px;'/>
									</div>
									<div class='w3-col l6 m6 s6'>
										<div style='padding-top: 10px;'>
											<div class='ui fluid large search'>
												<div class='ui fluid icon input'>
													<input id='sPrompt' class='prompt' type='text' placeholder='Item Barcode / Name'
												   onkeyup='keyPress(this, event)' onkeydown='checkP()'>
													<i class='search blue-text icon'></i></div><div class='results'>
												</div>
											</div>
										</div>
									</div>
									<div class='w3-col l2 m1 s3 align-c'>
										<h2 style='margin-top: 15px;'>
											<i id='menu-icon' class='th green-txt icon' style='cursor:pointer;' onclick='toggleMenu()'></i>
										</h2>
									</div>
									<div class='w3-col l1 m1 s3 align-c'>
										<h3 style='margin-top: 20px; cursor: pointer; font-size: 21px;'>
											<i class='bell red icon'></i>
										</h3>
									</div>
                                   <div class='w3-col l2 m1 s3 align-c right floated'>
										<button class='ui small  basic button' style='margin-top: 15px; cursor: pointer;'>
											<i class='martini glass red icon'></i> Drinks Orders
										</button>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
					
			
					
					
					
					
					<div class='w3-row l-width-9' style='margin: auto; margin-bottom: 50px;'>
						<div class='w3-col l8 m6 s12 l-margin-t-3'>
							<div>
								<table class='ui w3-card-2 table' style='font-family: montserratregular;'>
									<thead>
										<tr>
											<td colspan='6'>
												<button class='ui right floated circular sleak green-back button'
														onclick='emptyTray()'>Empty Drinks Tab</button>
											</td>
										</tr>
										<tr>
											<th>Item</th>
											<th>Price</th>
											<th>Tax</th>
											<th>Quantity</th>
											<th>Total</th>
											<th>Remove</th>
										</tr>
									</thead>
									<tbody id='product-con'>
										<tr>
											<td colspan='5'>
												<h3 class='sleak pad-2' style='color: silver;'>
													<i class='martini glass circular blue-text icon'></i> Drinks Tab is empty
												</h3>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class='w3-col l4 m6 s12 l-margin-t-3'>
							<div style='padding-left: 20px;'>


								<input id='cart_id' type='hidden' value=''/>
								<input id='trans_date' type='hidden' value=''/>


								<div class='curve w3-card-2 widget'>
									<div id='total_place' class='pad-2'>
										<h3 style='font-family: montserratregular;'>
											<small>Total</small>
											<span style='float: right; font-family: Arial;'>
												<span id='currency-con'></span>
												<span style='font-family: montserratregular;' id='total_con'>0.00</span>
											</span>
										</h3>
										<h6 style='font-family: montserratregular;'>
											<small>Taxes</small>
											<span style='float: right; font-family: Arial;'>
												<span id='currency-con'></span>
												<span style='font-family: montserratregular;' id='tax_con'>0.00</span>
											</span>
										</h6>";

                                        if($module->Discount)
                                        {
                                            $ret->Content .="
                                            <h6 style='font-family: montserratregular;'>
                                                <small>Discount</small>
                                                <span style='float: right; font-family: Arial;'>
                                                    <span id='currency-con'></span>
                                                    <span style='font-family: montserratregular;' id='total_con'>0.00</span>
                                                </span>
                                            </h6>";
                                        }

                                        $ret->Content .= "
										<h6 style='font-family: montserratregular;'>
											<small>Subtotal</small>
											<span style='float: right; font-family: Arial;'>
												<span id='currency-con'></span>
												<span style='font-family: montserratregular;' id='subtotal_con'>0.00</span>
											</span>
										</h6>
									</div><hr style='padding: 0px; margin: 0px;'/>
									<div class='pad-1 margin-t-2'>
										<h6 class='sleak' style='color: dimgrey; margin-bottom: 20px;'>Payment</h6>
										<div class='w3-row'>
											<div class='w3-col l4 m4 s6'>
												<div>
													<label><input class='with-gap' id='cash_pay' name='paytype' type='radio' checked/><span>Cash</span></label>
												</div>
											</div>
											<div class='w3-col l4 m4 s6'>
												<div>
													<label><input class='with-gap' id='pos_pay' name='paytype' type='radio' /><span>POS</span></label>
												</div>
											</div>
											<div class='w3-col l4 m4 s6'>
												<div>
													<label><input class='with-gap' id='pos_pay' name='paytype' type='radio' /><span>Others</span></label>
												</div>
											</div>
										</div>
										<div class='w3-row' style='margin-top: 30px;'>";

                                            if(($payment->Paypalid) && ($payment->Paypalusername) && ($payment->Paypalpassword))
                                            {
                                                $ret->Content .="
                                                <div class='w3-col l4 m4 s6'>
                                                    <div>
                                                        <button class='ui circular compact sleak button'><i class='paypal blue icon'></i>paypal</button>
                                                    </div>
                                                </div>";
                                            }

                                            if(($payment->Paystackpublic) && ($payment->Paystackprivate))
                                            {
                                                $ret->Content .= "
                                                <div class='w3-col l3 m4 s6'>
                                                    <div>
                                                        <button class='ui circular compact sleak button'>paystack</button>
                                                    </div>
                                                </div>";
                                            }

                                            if(($payment->Interswitchmarchantid))
                                            {
                                                $ret->Content .= "
                                                <div class='w3-col l5 m4 s6 align-r'>
                                                    <div>
                                                        <button class='ui circular compact sleak button'><i class='exclamation blue icon'></i>interswitch</button>
                                                    </div>
                                                </div>";
                                            }

                                            $ret->Content .="
										</div>
									</div>";

                                        if($module->Discount)
                                        {
                                            $ret->Content .= "
                                            <div class='pad-1 margin-t-1' style='background-color: whitesmoke;'>
                                                <h6 style='font-family: quicksand_mediumregular; color: dimgrey;'>Use Coupon</h6>
                                                <div class='ui input'>
                                                    <input class='' id='coupon_txt' type='text' placeholder='Coupon Code'/>
                                                </div>
                                                <button id='coupon_btn' class='ui sleak blue-back button' onclick='applyCoupon()'>Apply</button>
                                            </div>";
                                        }

                                        $ret->Content .= "
									<div class='pad-1 margin-t-1' style=''>
										<h6 style='font-family: quicksand_mediumregular; color: dimgrey;'>Push tray</h6>
										<button id='push_btn' class='ui sleak blue-back button' onclick='pushCart()'>Push Tray and print Receipt</button>
										<button id='push_btn' class='ui sleak green-back button' onclick='saveOrder()'> Save order</button>
									</div>
								</div>
							</div>
						</div>
					</div>
                    
                    
					<input id='get-customers-address' type='hidden' value='false'/>
					<input id='system-role-access' type='hidden' value='false'/>
					<input id='tax-pay-style' type='hidden' value='peritem'/>
					<input id='currency-symbol' type='hidden' value='".$subscriber->Currency->Symbol."'/>
                </body>
            </html>";


end:;