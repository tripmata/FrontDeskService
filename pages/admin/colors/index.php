<?php

		if(count($router->Args) > 0)
		{
			if($router->Args[0] == "password-reset")
			{
				require("password_reset.php");
				goto end;
			}
			if($router->Args[0] == "attendance")
			{
				require("attendance.php");
				goto end;
			}
            if($router->Args[0] == "dashboard")
            {
                require("main.php");
                goto end;
            }
            if($router->Args[0] == "frontdesk")
            {
                require("frontdesk.php");
                goto end;
            }
            if(($router->Args[0] == "kitchen") || ($router->Args[0] == "restaurant"))
            {
                require("kitchen_pos.php");
                goto end;
            }
            if($router->Args[0] == "bakery")
            {
                require("bakery_pos.php");
                goto end;
            }
            if($router->Args[0] == "bar")
            {
                require("bar_pos.php");
                goto end;
            }
            if($router->Args[0] == "pool")
            {
                require("pool_pos.php");
                goto end;
            }
            if($router->Args[0] == "laundry")
            {
                require("laundry_pos.php");
                goto end;
            }
		}
		
		if(isset($_REQUEST['usersess']))
		{
			if($_REQUEST['usersess'] == $subscriber->Id)
			{
				require("main.php");
			}
			else
			{
				if($user->Id != "")
				{
					if($user->Role->Frontdesk->WriteAccess)
					{
						require("frontdesk.php");
					}
					else if($user->Role->Kitchenpos->WriteAccess)
					{
						require("kitchen_pos.php");
					}
					else if($user->Role->Barpos->WriteAccess)
					{
						require_once ("bar_pos.php");
					}
                    else if($user->Role->Bakerypos->WriteAccess)
                    {
                        require_once ("bakery_pos.php");
                    }
                    else if($user->Role->Laundrypos->WriteAccess)
                    {
                        require_once ("laundry_pos.php");
                    }
                    else if($user->Role->Poolpos->WriteAccess)
                    {
                        require_once ("pool_pos.php");
                    }
					else
					{
						require("main.php");
					}
				}
				else
				{
					require("login.php");
				}
			}
		}
		else
		{
			require("login.php");
		}
		
		end: ;
?>