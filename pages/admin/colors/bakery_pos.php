<?php

    $username = "";

    $user = new User($subscriber);
    $user->Initialize($_REQUEST['usersess']);

    $module = new Modules($subscriber);

    $payment = new Paygateway($subscriber);

    $settings = new Pastrysettings($subscriber);

    $site = new Site($subscriber);


    if($_REQUEST['usersess'] == $subscriber->Id)
    {
        $username = "Admin Main";
    }
    else if(($user->Id != "") && ($user->Role->Bakerypos->WriteAccess))
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

					<link rel='stylesheet' type='text/css' href='".$cdn."css/w3.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."css/mat.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."css/semantic.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."css/space_app.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."css/draw.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."css/datepicker.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."css/kitchenpos.css'/>

					<link rel='stylesheet' type='text/css' href='".$cdn."fonts/lato/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."fonts/quicksand/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."fonts/montserrat/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$cdn."fonts/nunito/stylesheet.css'/>

					<script type='application/javascript' src='".$cdn."js/jquery.min.js'></script>
					<script type='application/javascript' src='".$cdn."js/functions.js'></script>
					<script type='application/javascript' src='".$cdn."js/semantic.min.js'></script>
					<script type='application/javascript' src='".$cdn."js/datepicker.min.js'></script>
					<script type='application/javascript' src='".$cdn."js/outlets.js'></script>
					<script type='application/javascript' src='".$cdn."js/pay.js'></script>
					<script type='application/javascript' src='".$cdn."js/print.min.js'></script>
					<script type='application/javascript' src='".$cdn."js/bakerypos.js'></script>
					<script src='https://js.paystack.co/v1/inline.js'></script>
                </head>
                <body style=''>
                    <audio id='alertSound'>
                        <source src='".$cdn."sound/posalert.mp3' type='audio/mp3';></source>
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
                                    <div class='item' onclick='openSavedOrder()'><i class='save icon'></i> Saved orders</div>
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
                            ".$subscriber->BusinessName."</h6>
                            <button id='activity-con' class='ui white sleak compact small button'><i class='spinner green-txt icon loading'></i> Connecting... </button>
							<span style='color: lightgray;'>Bakery / Pastries</span>
                        </div>
                    </div>
                    <div>
                        <div class='lift-1 pad-1'>
                            <div class='l-width-8' style='margin: auto;'>
                                <div class='w3-row'>
                                   
									<div class='w3-col l1 m1 s3'>
										<img src='".$host."cdn/images/icons/pastel/cake.png' style='width: 60px;'/>
									</div>
									<div class='w3-col l6 m6 s6'>
										<div style='padding-top: 10px;'>
											<div class='ui fluid large search'>
												<div id='sPrompt-con' class='ui fluid icon input'>
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
										<div class='n-dropdown'>
                                           <h3 class='n-dropbtn' id='order-con' style='margin-top: 20px; cursor: pointer; font-size: 21px;'>
                                                <i id='order-bell' class='bell red icon' style='position: relative;' onclick='openNotification()'>
                                                    <span id='alert-num' class='sleak' style='position: absolute; top: -10px; 
                                                    right: -10px;color: steelblue; 
                                                    border-radius: 50%; font-size: 14px; display: none;'>0</span>
                                                </i>
										    </h3>
                                           <div id='noteDropdown' class='n-dropdown-content' style=''>
                                           </div>
                                       </div>
									</div>
                                   <div class='w3-col l2 m1 s3 align-c right floated'>
										<button class='ui small  basic button' style='margin-top: 15px; cursor: pointer;'onclick='openFoodOrder()'>
											<i class='birthday cake red icon'></i> Pastry Orders
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
												<button class='ui right floated circular sleak green button'
														onclick='emptyTray()'>Empty Pastry basket</button>
                                                <h6 class='sleak' id='entity-text-con'></h6>
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
													<i class='shopping basket circular blue-text icon'></i> Pastry basket is empty
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
												<span id='currency-con'>".$subscriber->Currency->Symbol."</span>
												<span style='font-family: montserratregular;' id='total_con'>0.00</span>
											</span>
										</h3>
										<h6 style='font-family: montserratregular;'>
											<small>Taxes</small>
											<span style='float: right; font-family: Arial;'>
												<span id='currency-con'>".$subscriber->Currency->Symbol."</span>
												<span style='font-family: montserratregular;' id='tax_con'>0.00</span>
											</span>
										</h6>";

                                        if($module->Discount)
                                        {
                                            $ret->Content .="
                                            <h6 style='font-family: montserratregular;'>
                                                <small>Discount</small>
                                                <span style='float: right; font-family: Arial;'>
                                                    <span id='currency-con'>".$subscriber->Currency->Symbol."</span>
                                                    <span style='font-family: montserratregular;' id='discount_con'>0.00</span>
                                                </span>
                                            </h6>";
                                        }

										$ret->Content .= "
										<h6 style='font-family: montserratregular;'>
											<small>Subtotal</small>
											<span style='float: right; font-family: Arial;'>
												<span id='currency-con'>".$subscriber->Currency->Symbol."</span>
												<span style='font-family: montserratregular;' id='subtotal_con'>0.00</span>
											</span>
										</h6>
									</div>";

                                    if($module->Discount)
                                    {
                                        $ret->Content .= "
                                            <div class='pad-1 padding-t-1' style='background-color: whitesmoke;'>
                                                <div class='w3-row' style='margin-top: 10px;'>
                                                    <div class='w3-col l8 m8 s8'>
                                                        <label class='sleak' style='font-weight: bold; color: silver;'>
                                                            Add coupon and discount
                                                        </label>
                                                    </div>
                                                    <div class='w3-col l4 m4 s4 align-r'>
                                                        <button class='ui compact very basic small sleak button' style='font-weight: bold;' onclick='openDiscounts()'>
                                                            Discount
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class='' style='margin-top: 10px;'>
                                                    <div class='ui action fluid input'>
                                                        <input id='coupon_txt' type='text' placeholder='Coupon Code'/>
                                                        <button id='coupon_btn' class='ui sleak blue button' onclick='applyCoupon()'>Apply</button>
                                                    </div>
                                                </div>
                                                <div id='discount-list-con' style='margin-top: 20px;'>
                                                
                                                </div>
                                            </div>";
                                    }

									$ret->Content .= "
									<div class='pad-1 margin-t-2'>
										<h6 class='sleak' style='color: dimgrey; margin-bottom: 20px;'>Receive Payment</h6>
										<div>
										    <div class='ui labeled fluid input'>
										        <label class='ui sleak label'>Amount <span style='font-family: Lato;'> ".
                                                $subscriber->Currency->Symbol."</span></label>
										        <input id='payment-amount' type='text' value='0'/>
                                            </div>
                                        </div>
										<div class='w3-row' style='margin-top: 10px;'>";

                                            if($settings->Cash)
                                            {
                                                $ret->Content .= "
                                                    <div class='w3-col l4 m4 s6'>
                                                        <div>
                                                            <label><input class='with-gap' id='cash_pay' name='paytype' type='radio'/><span>Cash</span></label>
                                                        </div>
                                                    </div>";
                                            }
                                            if($settings->Pos)
                                            {
                                                $ret->Content .= "
                                                    <div class='w3-col l4 m4 s6'>
                                                        <div>
                                                            <label><input class='with-gap' id='pos_pay' name='paytype' type='radio' /><span>POS</span></label>
                                                        </div>
                                                    </div>";
                                            }
                                            if($settings->Others)
                                            {
                                                $ret->Content .= "
                                                    <div class='w3-col l4 m4 s6'>
                                                        <div>
                                                            <label><input class='with-gap' id='others_pay' name='paytype' type='radio' /><span>Others</span></label>
                                                        </div>
                                                    </div>";
                                            }

                                        $ret->Content .= "
                                        <input id='web_pay' type='hidden' value='false'/>
                                        <input id='order-id' type='hidden' value=''/>
										</div>
										<div class='w3-row' style='margin-top: 30px;'>";

                                            if((($payment->Paypalid) && ($payment->Paypalusername) && ($payment->Paypalpassword)) && ($settings->Online))
                                            {
                                                $ret->Content .="
                                                <div class='w3-col l4 m4 s6'>
                                                    <div>
                                                        <button class='ui circular compact sleak button'><i class='paypal blue icon'></i>paypal</button>
                                                    </div>
                                                </div>";
                                            }

                                            if((($payment->Paystackpublic) && ($payment->Paystackprivate)) && ($settings->Online))
                                            {
                                                $ret->Content .= "
                                                <div class='w3-col l3 m4 s6'>
                                                    <div>
                                                        <button id='paystack-btn' class='ui circular compact sleak button' onclick='initializePaystackPay()'>paystack</button>
                                                    </div>
                                                </div>";
                                            }

                                            if((($payment->Interswitchmarchantid)) && ($settings->Online))
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
									</div>
									
									
									<div class='pad-1 margin-t-1' style=''>
										<h6 style='font-family: quicksand_mediumregular; color: dimgrey;'>Complete order</h6>
										<button id='push_btn' class='ui sleak blue button' onclick='pushTray()'>Process and print Receipt</button>
										<button id='save_btn' class='ui sleak green button' onclick='launchsaveOrder()'> Save order</button>
									</div>
								</div>
							</div>
						</div>
					</div>
                    
                    
					<input id='get-customers-address' type='hidden' value='false'/>
					<input id='system-role-access' type='hidden' value='false'/>
					<input id='tax-pay-style' type='hidden' value='peritem'/>
					<input id='business-name' type='hidden' value='".$subscriber->BusinessName."'/>
					<input id='currency-symbol' type='hidden' value='".$subscriber->Currency->Symbol."'/>
					<input id='business-logo' type='hidden' value='http://".$subscriber->Domain."/files/".$site->Logo."'/>
					<input id='primary-color' type='hidden' value='".$site->PrimaryColor."'/>
					<input id='primary-font' type='hidden' value='".$site->TextFont."'/>
					<input id='secondary-color' type='hidden' value='".$site->SecondaryColor."'/>
					<input id='secondary-font' type='hidden' value='".$site->SecondaryFont."'/>
					<input id='business-email' type='hidden' value='".$subscriber->Email1."'/>
					<input id='business-address' type='hidden' value='".$subscriber->Address."'/>
					<input id='pos-user-name' type='hidden' value='".$user->Name." ".$user->Surname."'/>
					
					
					<input id='pos-type' type='hidden' value='pastry_item'/>
					<input id='pos-user' type='hidden' value='".$_REQUEST['usersess']."'/>
                </body>
            </html>";


end:;