<?php

			$username = "";

			$menu = null;
            $m = new Menues($subscriber);

            $site = new Site($subscriber);

            $getaddress = new Boolean($site->Customersaddress);

            $user = new User($subscriber);
            $user->Initialize($_REQUEST['usersess']);

			if($_REQUEST['usersess'] == $subscriber->Id)
			{
				$username = "Admin Main";
				$m->AddAllMenue();
				$menu = $m->AdminMenu();
			}
			else if($user->Id != "")
            {
                $menu = $m->ByRole($user->Role);
                $username = $user->Name." ".$user->Surname;
            }

			$ret->Content = "

            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0' />

                    <title>".$subscriber->BusinessName." : . Admin</title>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/w3.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/mat.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/semantic.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/space_app.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/draw.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/datepicker.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/croppie.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/huebee.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/morris.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/pulse.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/froala_editor.pkgd.min.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/css/font_awesome/css/fontawesome-all.min.css'/>

					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/lato/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/quicksand/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/montserrat/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/nunito/stylesheet.css'/>
					<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/varelaround/stylesheet.css'/>

					<script type='application/javascript' src='".$host."cdn/js/jquery.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/login.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/draw.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/event.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/populate.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/worker.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/functions.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/router.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/messaging.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/semantic.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/datepicker.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/croppie.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/upload.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/raphael.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/morris.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/huebee.pkgd.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/froala_editor.pkgd.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/jquery.peity.min.js'></script>
					<script type='application/javascript' src='".$host."cdn/js/easypiechart.js'></script>

                </head>
                <body style='background-color: rgb(242,247,251);'>
					<div id='menu'>
						<div class='l-pad-2 m-pad-1'>
							<div>
								<div>
									<h3 style='color: white; font-family: quicksandregular; padding: 0px; margin: 0px;'>".$subscriber->BusinessName."</h3>
									<h6 style='color: white; font-family: quicksandregular; padding: 0px; margin: 0px; color: silver;'><small>".$username."</small></h6>
								</div>
							</div>
						</div>
						<br style='margin: 0px; padding: 0px;'/>
							<div class=''>
								<div>";

									for($i = 0; $i < count($menu); $i++)
									{
										$angle = "right";
										if(count($menu[$i]->SubMenu) > 0)
										{
											$angle = "down";
										}

										if($menu[$i]->Active)
										{
                                            if ($menu[$i]->Hash == "")
                                            {
                                                $ret->Content .= "<div class='menu-item outer-menu' onclick=\"openShell('" . $i . "')\">
											    <i class='" . $menu[$i]->Icon . " icon'></i> " . $menu[$i]->Name
                                                    . "<i class='angle " . $angle . " icon' style='color: silver; float: right;'></i> </div><div id='shell_" .
                                                    $i . "' class='shell-cont' style='display: none;'>";

                                                for ($j = 0; $j < count($menu[$i]->SubMenu); $j++)
                                                {
                                                    if ($menu[$i]->SubMenu[$j]->Active)
                                                    {
                                                        if ($menu[$i]->SubMenu[$j]->Hash == "")
                                                        {
                                                            $ret->Content .= "<div class='menu-item inner-menu' style='padding-left: 40px;'>" . $menu[$i]->SubMenu[$j]->Name
                                                                . "<i class='' style='color: silver;'></i> </div><div id='shell_" .
                                                                $menu[$i]->SubMenu[$j]->Name . "' class='inner_shell'></div>";
                                                        }
                                                        else
                                                        {
                                                            $ret->Content .= "<a href='" . $menu[$i]->SubMenu[$j]->Hash . "' style='text-decoration: none;'>
                                                            <div class='menu-item inner-menu' style='padding-left: 40px;'>" . $menu[$i]->SubMenu[$j]->Name .
                                                                "<i class='' style='color: silver;'></i> </div><div id='shell_" .
                                                                $menu[$i]->SubMenu[$j]->Name . "' class='inner_shell'></div></a>";
                                                        }
                                                    }
                                                }

                                                $ret->Content .= "</div>";
                                            }
                                            else
                                            {
                                                $angle = "right";

                                                $ret->Content .= "<a href='" . $menu[$i]->Hash . "' style='text-decoration: none;'>
											    <div class='menu-item outer-menu' onclick=\"openShell('" . $i . "')\">
											    <i class='" . $menu[$i]->Icon . " icon'></i> " . $menu[$i]->Name
                                                    . "<i class='angle " . $angle . " icon' style='color: silver; float: right;'></i> </div><div id='shell_" .
                                                    $i . "' class='shell-cont' style='display: none;'>";

                                                for ($j = 0; $j < count($menu[$i]->SubMenu); $j++)
                                                {
                                                    if ($menu[$i]->SubMenu[$j]->Active)
                                                    {
                                                        if ($menu[$i]->SubMenu[$j]->Hash == "")
                                                        {
                                                            $ret->Content .= "<div class='menu-item inner-menu' style='padding-left: 40px;'>" . $menu[$i]->SubMenu[$j]->Name
                                                                . "<i class='' style='color: silver;'></i> </div><div id='shell_" .
                                                                $menu[$i]->SubMenu[$j]->Name . "' class='inner_shell'></div>";
                                                        }
                                                        else
                                                        {
                                                            $ret->Content .= "<a href='" . $menu[$i]->SubMenu[$j]->Hash . "' style='text-decoration: none;'>
                                                            <div class='menu-item inner-menu' style='padding-left: 40px;'>" . $menu[$i]->SubMenu[$j]->Name .
                                                                "<i class='' style='color: silver;'></i> </div><div id='shell_" .
                                                                $menu[$i]->SubMenu[$j]->Name . "' class='inner_shell'></div></a>";
                                                        }
                                                    }
                                                }
                                                $ret->Content .= "</div></a>";
                                            }
                                        }
									}

									$ret->Content .= "<a href='#logout' style='text-decoration: none;'>
											<div class='menu-item outer-menu'>
											<i class='sign out icon'></i> Logout
											<i class='angle right icon' style='color: silver; float: right;'></i> </div><div id='shell_".
											$i."' class='shell-cont' style='display: none;'></div></a>";

									$ret->Content .= "
								</div>
							</div>
						</div>
					</div>
					<div id='page'>

					</div>
					<input id='get-customers-address' type='hidden' value='".$getaddress->ToString()."'/>
					<input id='business-name' type='hidden' value='".$subscriber->BusinessName."'/>
					<input id='business-email' type='hidden' value='".$subscriber->Email1."'/>
					<input id='system-role-access' type='hidden' value='false'/>
					<input id='currency-symbol' type='hidden' value='".$subscriber->Currency->Symbol."'/>
                </body>
            </html>";
