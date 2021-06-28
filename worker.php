<?php
    session_start();
    require_once ("loader.php");

    $host = $urlConfiguration->host;
    $cdn = $urlConfiguration->storage;

    // Please update your config.php file for this to work.
    // Simply run 'php deploy.php pull -/FrontDeskServices/config.php'
    $DOMAIN = isset($urlConfiguration->listing) ? $urlConfiguration->listing : '';
    
    $loggedUser = null;

    // clean $_REQUEST array
    Sanitize::removeHTMLFromRequests();
    
    // default time zone
    date_default_timezone_set("Africa/Lagos");

    $subscriber = new Subscriber();

    $path = "";
    if(isset($_REQUEST['path']))
    {
        $path = $_REQUEST['path'];
    }
    $router = new Router($path);

    $p = "";

    if(count($router->Args) > 1)
    {
        $p = $router->Args[(count($router->Args) - 2)];
    }

    $ret = new stdClass();
    $ret->Status = "access denied";
    $ret->Data = null;
    $ret->Message = "Login and try again";

    // get user session
    if (isset($_REQUEST['request_token']))
    {
        $data = json_decode(base64_decode($_REQUEST['request_token']));

        // set usersess
        if (is_object($data))
        {
            $_REQUEST['usersess'] = $data->usersess;
            $_REQUEST['property'] = $data->property;
        }
    }

    $job = isset($_REQUEST['job']) ? urldecode($_REQUEST['job']) : '<nada>';
    $property = isset($_REQUEST['property']) ? $_REQUEST['property'] : (isset($_REQUEST['propertyid']) ? $_REQUEST['propertyid'] : null);

    // set the property id
    if (!isset($_REQUEST['propertyid'])) $_REQUEST['propertyid'] = $property;

    switch($job)
    {
        case "get pos settings":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $ret->Data = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $ret->Data->DatabasePassword = "";
                        $ret->Data->DatabaseUser = "";
                        $ret->Data->Databasename = "";
                        $ret->Status = "success";
                    }
                }
            }
            break;

        case "get reservations":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {

                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $ret->Status = "success";

                        $page = $_REQUEST['Page'];
                        $perpage = $_REQUEST['Perpage'];
                        $filter = $_REQUEST['filter'];
                        $source = $_REQUEST['source'];
                        $payment_type = $_REQUEST['payment_type'];                        
                        //$filtervalue = $_REQUEST['Filtervalue'];
                        
                        $ret->Data = [];
                        $store = [];

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;

                        $ret->noShow = Reservation::noShowCount($property);
                        $ret->dueToday = Reservation::DueTodayCount($property);                        

                        if ($_REQUEST['searchterm'] != "")
                        {
                            $store = Reservation::Search($property, $_REQUEST['searchterm']);
                        }
                        else
                        {
                            $store = Reservation::applyFilter($property, $filter, $_REQUEST['dueDate'], $source, $payment_type);
                        }

                        $ret->Total = count($store);

                        $start = (($ret->Page - 1) * $ret->Perpage);
                        $stop = (($start + $ret->Perpage) - 1);

                        $x = 0;
                        for($i = $start; $i < count($store); $i++)
                        {
                            $ret->Data[$x] = $store[$i];
                            if($i == $stop){break;}
                            $x++;
                        }
                    }
                }
            }
        break;
        case "add customer id":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {

                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $ret->Status = "success";
                        $ret->Message = "Id added";

                        $customer = new CustomerByProperty($_REQUEST['customer']);
                        $customer->Idtype = $_REQUEST['idType'];
                        $customer->Idnumber = $_REQUEST['num'];
                        $customer->Idimage = $_REQUEST['idImage'];

                        $customer->Save();
                    }
                }
            }
            break;

        case "get inhouse":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {

                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $ret->Status = "success";

                        $page = $_REQUEST['Page'];
                        $perpage = $_REQUEST['Perpage'];
                        $filter = $_REQUEST['filter'];

                        $ret->Data = [];
                        $store = [];

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;

                        $ret->overDue = Lodging::overdueCount($subscriber);
                        $ret->dueToday = Lodging::dueTodayCount($subscriber);
                        $ret->arrival = Lodging::checkInTodayCount($subscriber); 

                        if($_REQUEST['searchterm'] != "")
                        {
                            $store = Lodging::Search($subscriber, $_REQUEST['searchterm']);
                        }
                        else
                        {
                            $store = Lodging::applyFilter($subscriber, $filter, $_REQUEST['dueDate']);
                        }
                        $ret->Total = count($store);

                        $start = (($ret->Page - 1) * $ret->Perpage);
                        $stop = (($start + $ret->Perpage) - 1);

                        $x = 0;
                        for($i = $start; $i < count($store); $i++)
                        {
                            $ret->Data[$x] = $store[$i];
                            if($i == $stop){break;}
                            $x++;
                        }

                    }
                }
            }
            break;

        case "get guest info":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $ret->Status = "success";
                        $ret->Data = new CustomerByProperty($_REQUEST['customer']);
                    }
                }
            }
            break;

        case "get customers":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $ret->Status = "success";

                        $page = $_REQUEST['Page'];
                        $perpage = $_REQUEST['Perpage'];
                        $filter = $_REQUEST['filter'];
                        //$filtervalue = $_REQUEST['Filtervalue'];

                        $ret->Data = [];
                        $store = [];

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;

                        $store = CustomerByProperty::Search($subscriber, $_REQUEST['searchterm']);

                        $ret->inHouse = Lodging::inHouseCount($subscriber);
                        $ret->todayCheckin = Lodging::checkInTodayCount($subscriber);
                        $ret->allGuest = CustomerByProperty::CountAll($subscriber);

                        $ret->Total = count($store);

                        $start = (($ret->Page - 1) * $ret->Perpage);
                        $stop = (($start + $ret->Perpage) - 1);

                        $x = 0;
                        for($i = $start; $i < count($store); $i++)
                        {
                            $ret->Data[$x] = $store[$i];
                            if($i == $stop){break;}
                            $x++;
                        }

                    }
                }
            }
        break;
        case "get tripmata customers":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $subscriber = new Subscriber();

                        $ret->Status = "success";

                        $page = $_REQUEST['Page'];
                        $perpage = $_REQUEST['Perpage'];
                        $filter = $_REQUEST['filter'];
                        //$filtervalue = $_REQUEST['Filtervalue'];

                        $ret->Data = [];
                        $store = [];

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;

                        $store = Customer::Search($subscriber, $_REQUEST['searchterm']);

                        $ret->Total = count($store);

                        $start = (($ret->Page - 1) * $ret->Perpage);
                        $stop = (($start + $ret->Perpage) - 1);

                        $x = 0;
                        for($i = $start; $i < count($store); $i++)
                        {
                            $ret->Data[$x] = $store[$i];
                            if($i == $stop){break;}
                            $x++;
                        }

                    }
                }
            }
        break;
        case 'confirm account ban':
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->ReadAccess)
                    {
                        // get database
                        $db = DB::GetDB();

                        // get type
                        $type = $_REQUEST['type'];

                        // get value
                        $value = $_REQUEST['value'];

                        // get customer
                        $customer = $db->query("SELECT customerid FROM customer WHERE `$type` = '$value'");

                        // are we good ??
                        if ($customer->num_rows > 0)
                        {
                            // fetch record
                            $customerId = $customer->fetch_assoc()['customerid'];

                            // get propertyid
                            $property = $_REQUEST['propertyid'];

                            // check if customer has been profiled for this property
                            $query = $db->query("SELECT * FROM customerByProperty WHERE customerid = '$customerId' AND propertyid = '$property'");

                            // set default status
                            $ret->status = 'success';

                            // are we good
                            if ($query->num_rows > 0)
                            {
                                // fetch 
                                $record = $query->fetch_assoc();

                                // is he/she banned 
                                if ($record['isBaned'] == 1)
                                {
                                    $ret->status = 'error';
                                    $ret->message = 'This customer has been banned';
                                }
                            }
                        }
                        else
                        {
                            // set default status
                            $ret->status = 'success';
                        }
                    }
                }
            }
        break;
        case "get pos discount":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $ret->Data = Discount::All($subscriber);
                        $ret->Status = "success";
                    }
                }
            }
            break;

        case "get pos receipt":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $ret->Data = new Receipt("standard");
                        $ret->Status = "success";
                    }
                }
            }
            break;

        case "get pos items":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                // mask name
                if (!defined('MASK_CATEGORY_NAME')) define('MASK_CATEGORY_NAME', true);

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $roomList = [];
                        $roomCat = Roomcategory::All($subscriber);

                        for($i = 0; $i < count($roomCat); $i++)
                        {
                            $r = new stdClass();
                            $r->category = preg_replace('/[\s]+/', '_', $roomCat[$i]->Name);
                            $r->price = $roomCat[$i]->Price;
                            $r->Id = $roomCat[$i]->Id;
                            $r->occupancy = $roomCat[$i]->Baseoccupancy;
                            $r->maxOccupancy = $roomCat[$i]->Maxoccupancy;
                            $r->rooms = [];

                            $rooms = Room::Filter($subscriber, $roomCat[$i]->Id, 'category');

                            for($j = 0; $j < count($rooms); $j++)
                            {
                                array_push($r->rooms, $rooms[$j]->Number);
                            }
                            array_push($roomList, $r);
                        }
                        $ret->Data = new stdClass();
                        $ret->Data->rooms = $roomList;

                        //add reservation
                        $ret->Data->reservations = Reservation::ByPeriod($property, FETCH_FOR_THIS_MONTH_ONLY);
                        $ret->Data->lodging = Lodging::byPeriod(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword), FETCH_FOR_THIS_MONTH_ONLY);
                        $ret->Status = "success";
                        
                    }
                }
            }
            break;

        case "process coupon":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        $coupon = Coupon::byCode($subscriber, $_REQUEST['code']);

                        if($coupon != null)
                        {
                            if (!$coupon->Used)
                            {
                                if (!(($coupon->Expires) && ($coupon->Expirydate < time())))
                                {
                                    $ret->Status = "success";
                                    $ret->Data = $coupon;
                                    $ret->Message = "Coupon retrieved successfully";
                                }
                                else
                                {
                                    $ret->Status = "coupon error";
                                    $ret->Message = "Expired coupon";
                                }
                            }
                            else
                            {
                                $ret->Status = "coupon error";
                                $ret->Message = "Used coupon";
                            }
                        }
                        else
                        {
                            $ret->Status = "coupon error";
                            $ret->Message = "Invalid code";
                        }
                    }
                }
            }
            break;

        case "frontdesk operation":
            if (isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                        $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                        if ($_REQUEST['operation'] === "checkout")
                        {
                            $ret->Message = "Hello Dan";

                            $lodging = new Lodging($subscriber);
                            $lodging->Initialize($_REQUEST['booking']);
                            $lodging->Checkedout = true;
                            $todayDate = strtotime(date("m/d/Y H:i:s", time()));
                            $lodging->Checkoutdate = new WixDate($todayDate);
                            // $lodging->Checkout = $todayDate;
                            for($i = 0; $i < count($lodging->Rooms); $i++)
                            {
                                if(($lodging->Rooms[$i]->Category->Name === $_REQUEST['category']) || ($lodging->Rooms[$i]->Number == $_REQUEST['room']))
                                {
                                    $lodging->Rooms[$i]->Checkedout = true;
                                    $lodging->Rooms[$i]->Checkout = new WixDate($todayDate);
                                    $lodging->Rooms[$i]->Checkouttime = new WixDate($todayDate);
                                    $lodging->User = $_REQUEST['posuser'];
                                    $lodging->Save();
                                    break;
                                }
                            }

                            $ret->Data = null;
                            $ret->Status = "success";
                            $ret->Message = "checkout completed";
                        }

                        if ($_REQUEST['operation'] === "reservation")
                        {
                            $guest = json_decode($_REQUEST['guest']);

                            $reservation = new Reservation();
                            $reservation->Total = doubleval($_REQUEST['total']);
                            $reservation->Discount = doubleval($_REQUEST['discount']);

                            $reservation->Adult = Convert::ToInt($guest->adults);
                            $reservation->Children = Convert::ToInt($guest->children);

                            if (doubleval($_REQUEST['paidAmount']) > 0)
                            {
                                $reservation->Paidamount = doubleval($_REQUEST['paidAmount']);
                                $reservation->Paid = true;
                            }

                            // add the platform
                            $reservation->PlatformName = isset($_REQUEST['platform']) ? $_REQUEST['platform'] : $reservation->PlatformName;

                            $customer = null;

                            if ($guest->phone != '' && CustomerByProperty::PhoneExist($guest->phone))
                            {
                                $customer = CustomerByProperty::ByPhone($guest->phone);
                            }
                            elseif ($guest->email != '' && CustomerByProperty::EmailExist($guest->email))
                            {
                                $customer = CustomerByProperty::ByEmail($guest->email);
                            }
                            
                            if ($customer == null)
                            {
                                $customer = new CustomerByProperty(new Subscriber());
                                $customer->Phone = $guest->phone;
                                $customer->Email = $guest->email;
                                $customer->Name = $guest->name;
                                $customer->Surname = $guest->surname;
                                $customer->Country = $guest->country;
                                $customer->State = $guest->state;
                                $customer->City = $guest->city;
                                $customer->Sex = $guest->sex;
                                $customer->DOB = $guest->dob;
                                $customer->Address = $guest->address;

                                $customer = $customer->fetchCustomerIdBeforeSaving();
                                // $customer->Save();
                            }

                            // $guest = Guest::ByCustomer($subscriber, $customer->Id);
                            
                            // if($guest === null)
                            // {
                            //     $guest = new Guest($subscriber);
                            //     $guest->Customer = $customer->Id;
                            //     $guest->Name = $customer->Name;
                            //     $guest->Surname = $customer->Surname;
                            //     $guest->Phone = $customer->Surname;
                            //     $guest->Email = $customer->Email;
                            //     $guest->Idtype = $customer->Idtype;
                            //     $guest->Idnumber = $customer->Idnumber;
                            //     $guest->Idimage = $customer->Idimage;
                            //     $guest->Save();
                            // }

                            $roomList = [];

                            $items = explode(",", $_REQUEST['items']);

                            for($i = 0; $i < count($items); $i++)
                            {
                                $r = explode(":", $items[$i]);

                                if(count($r) > 3)
                                {
                                    $cat = new Roomcategory($subscriber);
                                    $cat->Initialize($r[0]);

                                    $std = new stdClass();
                                    $std->Number = $r[2];
                                    $std->Room = $cat;
                                    $std->RoomId = $r[0];

                                    array_push($roomList, $std);
                                }
                            }

                            $reservation->Customer = $customer;
                            $reservation->Property = $property;

                            $checkin = new WixDate(intval($_REQUEST['checkindate']));
                            $checkout = new WixDate(intval($_REQUEST['checkoutdate']));

                            $reservation->Checkoutdate = new WixDate(strtotime($checkout->Month."/".$checkout->Day."/".$checkout->Year));
                            $reservation->Checkindate = new WixDate(strtotime($checkin->Month."/".$checkin->Day."/".$checkin->Year));

                            $reservation->Rooms = $roomList;
                            $reservation->Save();

                            // save payment
                            if ($reservation->Paid)
                            {
                                // save into revenue
                                Revenue::SaveFromArray([
                                    'amount'    => $reservation->Paidamount,
                                    'property'  => $property,
                                    'mode'      => $_REQUEST['method'],
                                    'customer'  => $reservation->Customer->Id,
                                    'code'      => 'reservation',
                                    'remark'    => 'Reservation from frontdesk',
                                    'userid'    => $_REQUEST['posuser'],
                                    'resid'     => $reservation->Id
                                ]);

                                // get db instance
                                $db = DB::GetDB();

                                // update paid amount manually
                                $db->query("UPDATE reservation SET paidamount = '{$reservation->Paidamount}' WHERE reservationid = '{$reservation->Id}'");
                            }

                            // apply coupon
                            Coupon::applyCoupon($reservation->Bookingnumber);

                            //retrieve and reprocess reservation
                            $ret->Data = new stdClass();
                            $ret->Data->type = "reservation";
                            $ret->Data->content = Reservation::ByPeriod($property);

                            $ret->Status = "success";
                            $ret->Message = "Reservation saved";
                        }

                        if ($_REQUEST['operation'] === "add payment")
                        {
                            $reservation = new Reservation($_REQUEST['booking']);
                            $reservation->Paidamount = doubleval($reservation->Paidamount) + doubleval($_REQUEST['amount']);
                            $reservation->Paid = true;

                            $paytrack = new Lodgingtransaction($subscriber);
                            $paytrack->Paytime = new WixDate($_REQUEST['time']);
                            $paytrack->User = $_REQUEST['posuser'];
                            $paytrack->Amount = doubleval($_REQUEST['amount']);
                            $paytrack->Lodging = $reservation->Id;
                            $paytrack->Method = $_REQUEST['method'];
                            $paytrack->Save();

                            $reservation->Save();

                            // save into revenue
                            Revenue::SaveFromArray([
                                'amount'    => doubleval($_REQUEST['amount']),
                                'property'  => $property,
                                'mode'      => $_REQUEST['method'],
                                'customer'  => $reservation->Customer->Id,
                                'code'      => 'payment',
                                'remark'    => 'Additional payment for reservation',
                                'userid'    => $_REQUEST['posuser']
                            ]);
                            
                            $ret->Status = "success";
                            $ret->Message = "transaction saved";
                            $ret->Data = null;
                        }

                        if ($_REQUEST['operation'] === "add bill")
                        {
                            $lodging = new Lodging($subscriber);
                            $lodging->Initialize($_REQUEST['booking']);

                            $lodging->Bills += doubleval($_REQUEST['total']);

                            $lodging->Save();

                            $ret->Message = "";
                            $ret->Data = null;
                            $ret->Status = "success";
                        }

                        if ($_REQUEST['operation'] === "deposit")
                        {
                            $lodging = new Lodging($subscriber);
                            $lodging->Initialize($_REQUEST['booking']);

                            $lodging->Paidamount = doubleval($lodging->Paidamount) + doubleval($_REQUEST['amount']);
                            $lodging->Paid = true;

                            // get the booking id
                            $bookingid = $lodging->Bookingnumber;  

                            /*
                            $paytrack = new Lodgingtransaction($subscriber);
                            $paytrack->Paytime = new WixDate($_REQUEST['time']);
                            $paytrack->User = $_REQUEST['posuser'];
                            $paytrack->Amount = doubleval($_REQUEST['amount']);
                            $paytrack->Lodging = $lodging->Id;
                            $paytrack->Method = $_REQUEST['method'];
                            $paytrack->Type = "lodging";
                            $paytrack->Save();
                            */

                            // save into revenue
                            Revenue::SaveFromArray([
                                'amount'    => $_REQUEST['amount'],
                                'property'  => $property,
                                'mode'      => $_REQUEST['method'],
                                'customer'  => $lodging->Guest->Id,
                                'code'      => 'deposit',
                                'remark'    => 'Frontdesk lodging deposit',
                                'userid'    => $_REQUEST['posuser']
                            ]);

                            // get db instance
                            $db = DB::GetDB();

                            // update reservation table
                            $query = $db->query("SELECT id FROM reservation WHERE booking = '{$bookingid}'");

                            // are we good ?
                            if ($query->num_rows > 0) :

                                // update paidamount
                                $db->query("UPDATE reservation SET paidamount = '{$lodging->Paidamount}', paid = 1 WHERE booking = '{$bookingid}'");

                            endif;

                            $fromEarlyCheckout = isset($_REQUEST['checkout']) ? true : false;
                            
                            $lodging->Save();
                            
                            $ret->Status = "success";
                            $ret->Message = "transaction saved";
                            $ret->Data = null;
                            
                            if($fromEarlyCheckout){
                                Lodging::Checkout($subscriber);
                                $ret->Data = new stdClass();
                                $ret->Data->type = 'checkout';
                                $ret->Data->content = Lodging::byPeriod(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword));
                            }
                        }

                        if ($_REQUEST['operation'] === "checkin")
                        {
                            $lodging = new Lodging($subscriber);

                            $guest = json_decode($_REQUEST['guest']);
                            $items = explode(",", $_REQUEST['items']);

                            $customer = null;

                            $rooms = [];
                            $newReservation = false;

                            if (Convert::ToBool($_REQUEST['fromReserve']))
                            {
                                $reservation = new Reservation($_REQUEST['booking']);
                                $reservation->Checkedin = true;
                                $reservation->Activated = true;
                                $reservation->Noshow = false;
                                $reservation->ArrivalTime = date('g:i a');

                                // add the platform
                                $reservation->PlatformName = isset($_REQUEST['platform']) ? $_REQUEST['platform'] : $reservation->PlatformName;

                                // @var bool $paid
                                $paid = $reservation->Paid;
                                $amountPaid = doubleval($reservation->Paidamount) + doubleval($reservation->Discount);

                                if (doubleval($_REQUEST['paidAmount']) > 0 && ($amountPaid < doubleval($reservation->Total)))
                                {
                                    // if (doubleval($reservation->Paidamount) == 0) :

                                    //     // update paid amount
                                    //     $reservation->Paidamount = doubleval($_REQUEST['paidAmount']);

                                    // else:

                                    //     if ($_REQUEST['paidAmount'] == $reservation->Paidamount) :

                                    //         // sum 
                                    //         $sumTotal = ($reservation->Paidamount + $_REQUEST['paidAmount'] + $reservation->Discount);

                                    //         // apply a  rule to check reservation total
                                    //         if ($sumTotal == $reservation->Total) :

                                    //             $reservation->Paidamount = $sumTotal;

                                    //         endif;

                                    //     elseif ($_REQUEST['paidAmount'] < $reservation->Paidamount) :

                                    //     endif;
                                        
                                    // endif;

                                    $reservation->Paidamount = (doubleval($reservation->Paidamount)) + doubleval($_REQUEST['paidAmount']);
                                    $reservation->Paid = true;
                                }

                                $reservation->Save();

                                $lodging->Guest = $reservation->Customer;
                                $lodging->Bookingnumber = $reservation->Bookingnumber;
                                $lodging->Children = Convert::ToInt($reservation->Children);
                                $lodging->Adults = Convert::ToInt($reservation->Adult);

                                // save customer
                                if ( ($reservation->Customer->Phone != '' && !CustomerByProperty::PhoneExist($reservation->Customer->Phone)) && 
                                ($reservation->Customer->Email != '' && !CustomerByProperty::EmailExist($reservation->Customer->Email)) )
                                {
                                    $customer = new CustomerByProperty(new Subscriber());
                                    $customer->Email = $reservation->Customer->Email;
                                    $customer->Id = $reservation->Customer->Id;
                                    $customer->Phone = $reservation->Customer->Phone;
                                    $customer->fetchCustomerIdBeforeSaving(CustomerByProperty::SAVE_ON_CHECKIN);
                                }

                                if ($paid == false)
                                {
                                    // save into revenue
                                    Revenue::SaveFromArray([
                                        'amount'    => $reservation->Paidamount,
                                        'property'  => $property,
                                        'mode'      => $_REQUEST['method'],
                                        'customer'  => $customer->Id,
                                        'code'      => 'lodging',
                                        'remark'    => 'Lodging from frontdesk',
                                        'userid'    => $_REQUEST['posuser'],
                                        'resid'     => $reservation->Id
                                    ]);

                                    // get db instance
                                    $db = DB::GetDB();

                                    // update paid amount manually
                                    $db->query("UPDATE reservation SET paidamount = '{$reservation->Paidamount}' WHERE reservationid = '{$reservation->Id}'");
                                }
                                
                            }
                            else
                            {
                                if ($guest->phone != '' && CustomerByProperty::PhoneExist($guest->phone))
                                {
                                    $customer = CustomerByProperty::ByPhone($guest->phone);
                                }
                                elseif ($guest->email != '' && CustomerByProperty::EmailExist($guest->email))
                                {
                                    $customer = CustomerByProperty::ByEmail($guest->email);
                                }
                                
                                if ($customer == null)
                                {
                                    $customer = new CustomerByProperty(new Subscriber());
                                    $customer->Phone = $guest->phone;
                                    $customer->Email = $guest->email;
                                    $customer->Name = $guest->name;
                                    $customer->Surname = $guest->surname;
                                    $customer->Country = $guest->country;
                                    $customer->State = $guest->state;
                                    $customer->City = $guest->city;
                                    $customer->Sex = $guest->sex;
                                    $customer->Dateofbirth = $guest->dob;
                                    $customer->DOB = $guest->dob;
                                    $customer->Address = $guest->address;

                                    $customer = $customer->fetchCustomerIdBeforeSaving(CustomerByProperty::SAVE_ON_CHECKIN);
                                    // $customer->Save();
                                }

                                $lodging->Guest = $customer;

                                $lodging->Children = Convert::ToInt($guest->children);
                                $lodging->Adults = Convert::ToInt($guest->adults);

                                // add to reservation
                                $reservation = new Reservation();
                                $reservation->Total = doubleval($_REQUEST['total']);
                                $reservation->Discount = doubleval($_REQUEST['discount']);

                                $reservation->Adult = Convert::ToInt($guest->adults);
                                $reservation->Children = Convert::ToInt($guest->children);
                                $reservation->ArrivalTime = date('g:i a');

                                if (doubleval($_REQUEST['paidAmount']) > 0)
                                {
                                    $reservation->Paidamount = doubleval($_REQUEST['paidAmount']);
                                    $reservation->Paid = true;
                                }

                                // add the platform
                                $reservation->PlatformName = isset($_REQUEST['platform']) ? $_REQUEST['platform'] : $reservation->PlatformName;

                                $roomList = [];

                                $items = explode(",", $_REQUEST['items']);

                                for ($i = 0; $i < count($items); $i++)
                                {
                                    $r = explode(":", $items[$i]);

                                    if(count($r) > 3)
                                    {
                                        $cat = new Roomcategory($subscriber);
                                        $cat->Initialize($r[0]);

                                        $std = new stdClass();
                                        $std->Number = $r[2];
                                        $std->Room = $cat;
                                        $std->RoomId = $r[0];

                                        array_push($roomList, $std);
                                    }
                                }

                                $reservation->Customer = $customer;
                                $reservation->Property = $property;
                                $reservation->Checkedin = 1;

                                $checkin = new WixDate(intval($_REQUEST['checkindate']));
                                $checkout = new WixDate(intval($_REQUEST['checkoutdate']));

                                $reservation->Checkoutdate = new WixDate(strtotime($checkout->Month."/".$checkout->Day."/".$checkout->Year));
                                $reservation->Checkindate = new WixDate(strtotime($checkin->Month."/".$checkin->Day."/".$checkin->Year));
                                $reservation->Rooms = $roomList;

                                $newReservation = true;

                                //$reservation->Save();
                            }

                            // $guest = Guest::ByCustomer($subscriber, $lodging->Guest->Id);
                            // if($guest === null)
                            // {
                            //     $guest = new Guest($subscriber);
                            //     $guest->Customer = $lodging->Guest->Id;
                            //     $guest->Name = $lodging->Guest->Name;
                            //     $guest->Surname = $lodging->Guest->Surname;
                            //     $guest->Phone = $lodging->Guest->Surname;
                            //     $guest->Email = $lodging->Guest->Email;
                            //     $guest->Idtype = $lodging->Guest->Idtype;
                            //     $guest->Idnumber = $lodging->Guest->Idnumber;
                            //     $guest->Idimage = $lodging->Guest->Idimage;
                            //     $guest->Save();
                            // }


                            $lodging->User = $_REQUEST['posuser'];

                            if (doubleval($_REQUEST['paidAmount']) > 0)
                            {
                                $lodging->Paidamount = doubleval($_REQUEST['paidAmount']);
                                $lodging->Paid = true;

                                if (Convert::ToBool($_REQUEST['fromReserve']) == false)
                                {
                                    // save into revenue
                                    Revenue::SaveFromArray([
                                        'amount'    => $lodging->Paidamount,
                                        'property'  => $property,
                                        'mode'      => $_REQUEST['method'],
                                        'customer'  => $lodging->Guest->Id,
                                        'code'      => 'lodging',
                                        'remark'    => 'Lodging from frontdesk',
                                        'userid'    => $_REQUEST['posuser'],
                                        'resid'     => $reservation->Id
                                    ]);
                                }

                            }
                            
                            $lodging->Discount = doubleval($_REQUEST['discount']);
                            $lodging->Taxes = doubleval($_REQUEST['taxes']);
                            $lodging->Total = doubleval($_REQUEST['total']);

                            // add the platform
                            $lodging->PlatformName = isset($_REQUEST['platform']) ? $_REQUEST['platform'] : $lodging->PlatformName;


                            $rooms = [];

                            for($i = 0; $i < count($items); $i++)
                            {
                                $r = explode(":", $items[$i]);
                                if(count($r) > 3)
                                {
                                    $pixel = new Lodgepixel($subscriber, new stdClass());

                                    $roomCat = Room::Filter($subscriber, $r[0], 'category');

                                    $rCat = null;

                                    for($j = 0; $j < count($roomCat); $j++)
                                    {
                                        if($roomCat[$j]->Number == $r[2])
                                        {
                                            $pixel->Id = $roomCat[$j]->Id;
                                            $rCat = $roomCat[$j]->Category;
                                        }
                                    }

                                    $pixel->Number = $r[2];

                                    $cc = new WixDate(Convert::ToInt($r[3]));
                                    $cch = strtotime($cc->Month."/".$cc->Day."/".$cc->Year);

                                    if($cch < strtotime(date("m/d/Y")))
                                    {
                                        $price = (round(strtotime(date("m/d/Y")) - $cch) / ((60 * 60) * 24)) * doubleval($rCat->Price);
                                        $lodging->Total = doubleval($lodging->Total - $price);
                                    }

                                    $checkin = new WixDate(strtotime(date("m/d/Y")));
                                    $checkout = new WixDate(Convert::ToInt($r[5]));

                                    $pixel->Checkin = new WixDate(strtotime($checkin->Month."/".$checkin->Day."/".$checkin->Year));
                                    $pixel->Checkout = new WixDate(strtotime($checkout->Month."/".$checkout->Day."/".$checkout->Year));

                                    $lodging->Checkin = $pixel->Checkin;
                                    $lodging->Checkout = $pixel->Checkout;

                                    array_push($rooms, $pixel);
                                }
                            }

                            //var_dump($lodging, $reservation); die;

                            $lodging->Rooms = $rooms;
                            $lodging->Checkincount = count($rooms);
                            $lodging->Save();

                            // save reservation
                            if ($newReservation) :

                                // add the booking id
                                $reservation->Bookingnumber = $lodging->Bookingnumber;

                                // save the reservation
                                $reservation->Save();

                            endif;
 
                            // apply coupon
                            if (Convert::ToBool($_REQUEST['fromReserve']) == false)
                            {
                                // apply coupon
                                Coupon::applyCoupon($lodging->Bookingnumber);
                            }

                            //Retrieve data for processing
                            $ret->Data = new stdClass();
                            $ret->Data->type = "lodging";
                            $ret->Data->content = Lodging::byPeriod(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword));

                            $ret->Status = "success";
                            $ret->Message = "checkin completed";
                        }

                        if ($_REQUEST['operation'] === "mark no-show")
                        {
                            $reservation = new Reservation($_REQUEST['booking']);
                            $reservation->Noshow = true;
                            
                            // log for approval
                            if (isset($_REQUEST['payment_method']) && isset($_REQUEST['message']))
                            {
                                $payment_method = $_REQUEST['payment_method'];
                                $bankname = isset($_REQUEST['bankname']) ? $_REQUEST['bankname'] : '';
                                $acc_name = isset($_REQUEST['acc_name']) ? $_REQUEST['acc_name'] : '';
                                $acc_number = isset($_REQUEST['acc_number']) ? $_REQUEST['acc_number'] : '';

                                if($_REQUEST['payment_method'] === 'others'){
                                    $payment_method = $_REQUEST['others_option'];
                                }

                                if($_REQUEST['payment_method'] === 'transfer'){
                                    $payment_method = $_REQUEST['payment_method'];
                                }

                                $reservation->RefundPaymentCondition = json_encode([
                                    'method'   => $payment_method,
                                    'message'  => $_REQUEST['message'],
                                    'loggedBy' => $_REQUEST['posuser'],
                                    'bank'     => $bankname,
                                    'acc_name'     => $acc_name,
                                    'acc_number'     => $acc_number,
                                ]);

                            }

                            $reservation->Save();

                            $ret->Status = "success";
                            $ret->Message = "No show marked. Pending Confirmation from Customer.";
                            $ret->Data = null;

                            if ($reservation->IsOnline == 1)
                            {
                                // send confirmation email
                                $reservation->sendConfirmationMail();
                            }
                        }

                        if ($_REQUEST['operation'] === "cancel reservation")
                        {
                            $reservation = new Reservation($_REQUEST['reservationid']);
                            $reservation->Cancelled = true;
                            $reservation->Noshow = false;
                            $reservation->Save();

                            $ret->Status = "success";
                            $ret->Message = "Reservation canceled successfully";
                            $ret->Data = null;
                        }

                        if($_REQUEST['operation'] === "early checkout"){
                            $booking_number = $_REQUEST['booking_no'];
                            $db = DB::GetDB();
                            $res = $db->query("SELECT * FROM reservation WHERE booking='$booking_number'");

                            $reservationid = null;
                            if($res->num_rows > 0){
                                $row = $res->fetch_assoc();
                                $reservationid = $row['reservationid']; 

                                Lodging::SendRefundRequest($reservationid); // Send refund request
                                Lodging::Checkout($subscriber); // Early checkout
                                
                                $ret->Data = new stdClass();
                                $ret->Data->type = 'checkout';
                                $ret->Data->content = Lodging::byPeriod(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword));                        
                                $ret->Status = "success";
                                $ret->Message = "Early checkout completed. Pending approval from Admin.";                            
                            }

                            
                            
                        }
                    }
                }
            }
        break;
        case "update admin user password":

            break;

        case "login":

            $user = User::GetUser($_REQUEST['user']);

            if($user != null)
            {
                if(($user->isPassword($_REQUEST['password'])) && ($user->Role->Frontdesk->WriteAccess))
                {
                    $pack = new stdClass();
                    $pack->Status = "success";
                    $pack->Data = new stdClass();
                    $pack->Data->setMethod = "session";
                    $pack->Data->setName = "usersess";
                    $pack->Data->setValue = $user->Id;
                    $pack->Data->Status = "success";

                    $ret->Type = "set";
                    $ret->Content = $pack;

                    $ret->Status = "success";
                    $ret->Message = "Customer logged in successfully";
                }
                else
                {
                    $ret->status = "failed";
                    $ret->message = "wrong password";
                }
            }
            else
            {
                $ret->status = "failed";
                $ret->message = "user nor found";
            }
        break;
        case "check room availability":

            // check lodging
            $rooms = Lodging::checkAvailability();
            
        break;
        case "confirm noshow":

            // check id
            if (!isset($_REQUEST['id'])) return $router->printJson(['status' => 'error', 'message' => 'Missing Request ID. Invalid Request.']);

            // get database instance
            $db = DB::GetDB();

            // verify id
            $reservation = $db->query("SELECT * FROM reservation WHERE reservationid = '{$_REQUEST['id']}'");

            // do we have such reservation
            if ($reservation->num_rows == 0) return $router->printJson(['status' => 'error', 'message' => 'Invalid Reservation Identifier. This request is flagged invalid']);

            // get row
            $row = $reservation->fetch_assoc();

            // flagged no show ?
            if ($row['noshow'] != 2) return $router->printJson(['status' => 'error', 'message' => 'Reservation is still active. Cannot continue with confirmation.']);

            // all checked
            if ($row['isApprovedBySuperAdmin'] == 1 && $row['isApprovedByPartnerAdmin'] == 1)
            {
                // update reservation
                $db->query("UPDATE reservation SET noshow = 1, isConfirmedByGuest = 1 WHERE reservationid = '{$_REQUEST['id']}'");

                // condition
                $condition = json_decode($row['refundPaymentCondition']);
                
                // save revenue
                Revenue::SaveFromArray([
                    'amount'    => $row['paidamount'],
                    'property'  => $row['property'],
                    'mode'      => $condition->method,
                    'customer'  => $row['customer'],
                    'code'      => 'refund',
                    'remark'    => 'Refund from super admin',
                    'userid'    => $condition->loggedBy
                ]);
            }
            else
            {
                if ($row['paid'] == 0) :

                    // update reservation
                    $db->query("UPDATE reservation SET noshow = 1, isConfirmedByGuest = 1 WHERE reservationid = '{$_REQUEST['id']}'");

                else:
                    
                    // update reservation
                    $db->query("UPDATE reservation SET noshow = 2, isConfirmedByGuest = 1 WHERE reservationid = '{$_REQUEST['id']}'");

                endif;
            }

            // TODO: Perform refund policy if customer made payment already
            // ...

            // all good
            header('location: ' . rtrim($urlConfiguration->origin, '/') . '/noshow-confirmed');

        break;
        case "save property customer":
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        // load customer
                        $customer = new Customer(new Subscriber());
                        $customer->Initialize($_REQUEST['id']);

                        // replace data
                        $customer->Profilepic = (isset($_REQUEST['profilePic']) && $_REQUEST['profilePic'] != '') ? $_REQUEST['profilePic'] : $customer->Profilepic;
                        $customer->Name = !empty($_REQUEST['name']) ? $_REQUEST['name'] : $customer->Name;
                        $customer->Surname = !empty($_REQUEST['surname']) ? $_REQUEST['surname'] : $customer->Surname;
                        $customer->Phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : $customer->Phone;
                        $customer->Email = !empty($_REQUEST['email']) ? $_REQUEST['email'] : $customer->Email;
                        $customer->Country = !empty($_REQUEST['country']) ? $_REQUEST['country'] : $customer->Country;
                        $customer->State = !empty($_REQUEST['state']) ? $_REQUEST['state'] : $customer->State;
                        $customer->City = !empty($_REQUEST['city']) ? $_REQUEST['city'] : $customer->City;
                        $customer->Address = !empty($_REQUEST['address']) ? $_REQUEST['address'] : $customer->Address;
                        $customer->Sex = !empty($_REQUEST['sex']) ? $_REQUEST['sex'] : $customer->Sex;
                        $customer->DOB = !empty($_REQUEST['dob']) ? $_REQUEST['dob'] : $customer->DOB;


                        // Check password
                        if ($customer->GetPassword() == '')
                        {
                            // update
                            $ret->Message = 'Profile updated successfully';
                            $ret->Status = 'success';

                            // run now
                            $customer->Save();
                        }
                        else
                        {
                            $ret->Message = 'Cannot perform update. Account has been locked by the user.';
                        }

                    }
                }
            }
        break;
        case 'calculate overdue bill':
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        // calculate biil
                        $newTotal = Lodging::CalculateAndAddExtraFee((new Subscriber), $_REQUEST['lodgingid']);

                        // show new total
                        $ret->status = $ret->Status = 'success';
                        $ret->total = $newTotal;
                        $ret->Message = 'New bill collected';
                    }
                }
            }
        break;
        case 'get report':
            if (isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "") $user->UpdateSeenTime();

                $settings = null;

                // update status
                $ret->Message = 'Not Read permission granted';

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->ReadAccess)
                    {
                       // @var Subscriber $subscriber
                       $subscriber = new Subscriber();
                       
                       // load revenue
                       $revenue = new Revenue($subscriber);

                       // update status
                       $ret->Message = 'No report at this time';

                       // get total income
                       $ret->Income = Revenue::TotalRevenue($user);
                       $ret->Refunds = Revenue::TotalRefunds($user);

                       // are we good ?
                       if ($ret->Income > 0 || $ret->Refunds > 0)
                       {
                          $ret->Status = 'success';
                          $ret->Message = 'Report generated';
                          $ret->Data = Revenue::applyFilter();
                          
                          if (count($ret->Data) == 0) $ret->Message = 'No record found!';
                       }
                    }
                }
            }
        break;
        case 'make user self reservation':

            // get the user token
            $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;

            // are we good ?
            if ($token !== null) :

                // get db instance
                $db = DB::GetDB();

                // verify token
                $query = $db->query("SELECT sessionid FROM `session` WHERE token = '{$token}'");

                // are we good ?
                if ($query->num_rows > 0) :

                    // get token record
                    $tokenRecord = $query->fetch_assoc();

                    // read data
                    parse_str(urldecode($_REQUEST['data']), $data);

                    // start here
                    $reservation = new Reservation();
                    $reservation->Discount = isset($data['discount_total']) ? doubleval($data['discount_total']) : 0;
                    $reservation->Total = doubleval($data['total']) + $reservation->Discount; 

                    $reservation->Adult = Convert::ToInt($data['adults']);
                    $reservation->Children = Convert::ToInt($data['children']);
                    $reservation->ArrivalTime = isset($data['arrival_time']) ? $data['arrival_time'] : $reservation->ArrivalTime;

                    // add paid amount
                    if (!isset($data['paidAmount'])) $data['paidAmount'] = 0;

                    if (doubleval($data['paidAmount']) > 0)
                    {
                        $reservation->Paidamount = doubleval($data['paidAmount']);
                        $reservation->Paid = true;
                    }

                    $customer = null;

                    // customer id
                    $customerId = $data['customerid'];

                    // get customer email address
                    $customerInfo = $db->query("SELECT email, phone FROM customer WHERE customerid = '$customerId'");

                    // fetch result
                    $customerInfo = $customerInfo->fetch_assoc();

                    // do we have an email
                    if ($customerInfo['email'] != '') :

                        // load customer by email address
                        $customer = Customer::ByEmail($customerInfo['email']);

                    else:

                        // load customer by phone
                        $customer = Customer::ByPhone($customerInfo['phone']);

                    endif;

                    // load subscriber
                    $subscriber = new Subscriber();

                    $roomList = [];

                    $cat = new Roomcategory($subscriber);
                    $cat->Initialize($data['id']);
                    $roomNumber = '001';

                    // get a room number
                    // $rooms = $db->query("SELECT RAND(*) FROM room WHERE category = '{$data['id']}' LIMIT 0, 1");

                    // // are we good ?
                    // if ($rooms->num_rows > 0) :

                    //     // update room number
                    //     $roomNumber = $rooms->fetch_assoc()['number'];

                    // endif;

                    $std = new stdClass();
                    $std->Number = '';
                    $std->Room = $cat;
                    $std->RoomId = $data['id'];

                    // @var string $randomRoomNumber
                    $randomRoomNumber = '';

                    // @var string $url
                    $url = $DOMAIN . 'print-property-avaliability/' . $cat->Id . '/' . $cat->Property->Id . '/' . strtotime($data['checkin']) . '/' . strtotime($data['checkout']);

                    // Check for avaliability
                    $ch = curl_init($url);

                    // get response with request
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // handle response
                    $response = curl_exec($ch);

                    // close connection
                    curl_close($ch);

                    // read object
                    $response = json_decode(trim($response));

                    if ($response->avaliability > 0) :

                        // loop through
                        foreach ($response->rooms as $number => $bool) :

                            if ($bool) :

                                // get the first
                                $std->Number = $number;

                                // break
                                break;

                            endif;

                        endforeach;

                    endif;
                    // die;
                    
                    // set now
                    $roomList[] = $std;

                    // load property
                    $property = $cat->Property;

                    $reservation->Customer = $customer;
                    $reservation->Property = $property;

                    // get diffrence
                    $checkInDate  = new \DateTime($data['checkin']);
                    $checkOutDate = new \DateTime($data['checkout']);

                    $reservation->Checkoutdate = strtotime($checkOutDate->format('m/d/Y'));
                    $reservation->Checkindate = strtotime($checkInDate->format('m/d/Y'));
                    $reservation->Rooms = $roomList;
                    $reservation->Save();

                    // save payment
                    if ($reservation->Paid && intval($reservation->Paidamount) > 0)
                    {
                        // save into revenue
                        Revenue::SaveFromArray([
                            'amount'    => $reservation->Paidamount,
                            'property'  => $property,
                            'mode'      => 'online',
                            'customer'  => $reservation->Customer->Id,
                            'code'      => 'reservation',
                            'remark'    => 'Online reservation',
                            'userid'    => '',
                            'resid'     => $reservation->Id
                        ]);
                    }

                    // reservation is online
                    $db->query("UPDATE reservation SET isonline = 1 WHERE reservationid = '{$reservation->Id}'");

                    // apply coupon
                    Coupon::applyCoupon($reservation->Bookingnumber);

                    //retrieve and reprocess reservation
                    $ret->Data = new stdClass();
                    $ret->Data->type = "reservation";
                    $ret->Data->content = Reservation::ByPeriod($property);
                    $ret->Data->reservationId = $reservation->Id;

                    $ret->Status = "success";
                    $ret->Message = "Reservation saved";

                    // delete token
                    if ($tokenRecord['sessionid'] == 'id_' . $customer->Id) :

                        // delete token
                        $db->query("DELETE FROM `session` WHERE token = '{$token}'");

                    endif;
                    

                endif;

            endif;

        break;
        case 'record revenue' :

            // get the user token
            $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;

            // are we good ?
            if ($token !== null) :

                // get db instance
                $db = DB::GetDB();

                // verify token
                $query = $db->query("SELECT sessionid FROM `session` WHERE token = '{$token}'");

                // are we good ?
                if ($query->num_rows > 0) :

                    Revenue::SaveFromArray([
                        'amount'    => (isset($_REQUEST['amount'])      ? $_REQUEST['amount'] : ''),
                        'property'  => (isset($_REQUEST['property'])    ? $_REQUEST['property'] : ''),
                        'mode'      => (isset($_REQUEST['mode'])        ? $_REQUEST['mode'] : ''),
                        'customer'  => (isset($_REQUEST['customer'])    ? $_REQUEST['customer'] : ''),
                        'code'      => (isset($_REQUEST['code'])        ? $_REQUEST['code'] : ''),
                        'remark'    => (isset($_REQUEST['remark'])      ? $_REQUEST['remark'] : ''),
                        'resid'     => (isset($_REQUEST['resid'])       ? $_REQUEST['resid'] : ''),
                        'userid'    => ''
                    ]);

                endif;
            
            endif;

        break;
        case 'create tmp account':

            // get the user token
            $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;

            // are we good ?
            if ($token !== null) :

                // get db instance
                $db = DB::GetDB();

                // verify token
                $query = $db->query("SELECT sessionid FROM `session` WHERE token = '{$token}'");

                // are we good ?
                if ($query->num_rows > 0) :

                    // create account
                    $customer = new Customer(new Subscriber());
                    $customer->Phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
                    $customer->Email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
                    $customer->Name = $_REQUEST['name'];
                    $customer->Surname = $_REQUEST['surname'];
                    $customer->Country = 'ng';
                    $customer->Save();

                    // delete token
                    $db->query("DELETE FROM `session` WHERE token = '{$token}'");

                    // all good
                    $ret->Status = 'success';
                    $ret->Message = 'Account Created successfully';

                endif;

            endif;

        break;
        case 'check network connection':

            if (isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                $settings = null;

                if ($user->Id == 'adxc0' || $user->Id != '') :

                    if ($user->Role->Frontdesk->WriteAccess) $ret->Status = 'success';

                endif;
            }

            // set the message
            $ret->Message = 'Your session has expired. Please logout and login again to continue. Also check the "Data Que" tab to track progress on your next login.';

        break;
        case 'update reservation':

            if (!isset($_REQUEST['reservation_id'])) return $router->printJson(['status' => 'error', 'message' => 'Missing Reservation ID. Invalid Request.']);
            $user = new User();
            $user->Initialize($_REQUEST['usersess']);

            $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
            $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);
            
            // get database instance
            $db = DB::GetDB();

            $reservation = $db->query("SELECT * FROM reservation WHERE reservationid = '{$_REQUEST['reservation_id']}'");

            // do we have such reservation
            if ($reservation->num_rows == 0) return $router->printJson(['status' => 'error', 'message' => 'Invalid Reservation Identifier. This request is flagged invalid']);

            $reservationObj = new Reservation($_REQUEST['reservation_id']);            

            $old_reservation = $reservation->fetch_assoc();
            if ($old_reservation['updated_by'] !== null) return $router->printJson(['status' => 'error', 'message' => 'This reservation has been updated before']);

            unset($old_reservation['rooms']);   
            
            $old_reservation['category'] = $reservationObj->Rooms[0]->Room->Id;
            $old_reservation['room'] = $reservationObj->Rooms[0]->Number;

            $roomArray = [];
            $roomObj = (object)null;
            $roomObj->room = $_REQUEST['category_id'];
            $roomObj->number = $_REQUEST['roomNo'];
            array_push($roomArray, $roomObj);
            $rooms = json_encode($roomArray);

            $stringifiedReservation = json_encode($old_reservation); 
            
            $id = $_REQUEST['reservation_id'];
            $user_id = $_REQUEST['user_id'];
            $total = floatval($_REQUEST['total']);
            $paidAmount = floatval($_REQUEST['paidAmount']);
            // $category = $_REQUEST['category'];

            $customer_id = $_REQUEST['customer_id'];            

            $checkin = new WixDate(intval($_REQUEST['checkIn']) / 1000);
            $checkout = new WixDate(intval($_REQUEST['checkOut']) / 1000);

            $indate = strtotime($checkin->Month."/".$checkin->Day."/".$checkin->Year);
			$outdate = strtotime($checkout->Month."/".$checkout->Day."/".$checkout->Year);            

            $discount = 0;
            // $checkedin = 1;
            $paid = 1;

            $db->query("UPDATE reservation SET checkindate='$indate',checkoutdate='$outdate' WHERE reservationid = '$id'");

            if($db->query("UPDATE reservation SET paid='$paid',rooms='$rooms',discount='$discount',old_entry='$stringifiedReservation',updated_by='$user_id',customer='$customer_id',paidAmount='$paidAmount',total='$total' WHERE reservationid = '$id'")){
                return $router->printJson(['status' => 'success', 'Data' => Reservation::ByPeriod($property, FETCH_FOR_THIS_MONTH_ONLY)]);                      
            }else{
                return $router->printJson(['status' => 'error', 'message' => 'Could not update reservation']);                      
            }
            
                        
        break;
        case 'update to checkedin': 
            if (!isset($_REQUEST['id'])) return $router->printJson(['status' => 'error', 'message' => 'Missing Reservation ID. Invalid Request.']);
            $user = new User();
            $user->Initialize($_REQUEST['usersess']);

            $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
            $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);
            
            // get database instance
            $db = DB::GetDB();

            // verify id
            $reservation = $db->query("SELECT * FROM reservation WHERE reservationid = '{$_REQUEST['id']}'");

            // do we have such reservation
            if ($reservation->num_rows == 0) return $router->printJson(['status' => 'error', 'message' => 'Invalid Reservation Identifier. This request is flagged invalid']);

            // get row
            $row = $reservation->fetch_assoc();
            
            $checkedin = 1;
            $activated = 1;
            $noshow = 0;
            
            // if($res = $db->query("SELECT reservationid FROM reservation WHERE reservationid='{$_REQUEST['id']}'")->num_rows > 0)
            // {
            //     $db->query("UPDATE reservation SET checkedin='$checkedin' WHERE reservationid = '{$_REQUEST['id']}'");
            //     $ret->Status = "success";
            //     $ret->Message = "Marked as checked in";
            // }else{
            //     $ret->Status = "error";
            //     $ret->Message = "There was error, please try again.";
            // }

            $movedToLodging = Reservation::moveReservationToLodging($subscriber, $property);
            if($movedToLodging)
            {
                $ret->Status = "success";
                $ret->Message = "Marked as checked in";
            }else{
                $ret->Status = "error";
                $ret->Message = "There was error, please try again.";
            }

        break;
        case 'occupancy report': 
            if (isset($_REQUEST['usersess'])){
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);
    
                if ($user->Id != "") $user->UpdateSeenTime();
    
                if ($user->Role->Frontdesk->WriteAccess){
                    $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                    $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);
    
                    $ret->Data = new stdClass();
                    $ret->Data->occupancyReport = Lodging::occupancyReport($subscriber, $_REQUEST['start'], $_REQUEST['stop']);
                    
                    $ret->Status = "success";
                    $ret->Message = "Successful";
                    // $ret->Data->test = Lodging::test($subscriber, $_REQUEST['start'], $_REQUEST['stop']);
                }
            }
        break;
        case 'checkin report':
            if (isset($_REQUEST['usersess'])){
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);
    
                if ($user->Id != "") $user->UpdateSeenTime();
    
                if ($user->Role->Frontdesk->WriteAccess){
                    $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                    $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);
    
                    $ret->Data = new stdClass();
                    $ret->Data->checkinReport = Lodging::checkinReport($subscriber, $_REQUEST['start'], $_REQUEST['stop']);
    
                    $ret->Status = "success";
                    $ret->Message = "Successful";

                    $todayDate = strtotime(date("m/d/Y H:i:s", time()));
                    $ret->Data->test2 = new WixDate($todayDate);
                    $ret->Data->test = $todayDate;
                    
                }
            }
        break;
        case 'get states':
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                if ($user->Id != "")
                {
                    $user->UpdateSeenTime();
                }

                $settings = null;

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item")
                {
                    if ($user->Role->Frontdesk->WriteAccess)
                    {
                        $subscriber = new Subscriber();

                        $ret->Status = "success";

                        $page = $_REQUEST['Page'];
                        $perpage = $_REQUEST['Perpage'];
                        $filter = $_REQUEST['filter'];
                        $term = $_REQUEST['searchterm'];
                        $states = [];

                        // $states = States::Search($_REQUEST['searchterm']);

                        $db = DB::GetDB();
                        $data = array();
                        $i = 0;

                        $res = $db->query("SELECT * FROM states WHERE country = '$term'");
                        while(($row = $res->fetch_assoc()) != null)
                        {
                            $obj = (object)null;
                            $obj->Id = $row['statesid'];
                            $obj->Code = $row['code'];
                            $obj->Name = ucwords($row['name']);
                            // $i++;
                            $data[] = $obj;
                        }
                        $db->close();
                        return $router->printJson(['Status' => 'success', 'Data' => $data, 'total' => count($data)]);

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;
                                                
                        // $ret->Total = count($data);
                        // $ret->Data = $data;
 
                        // $start = (($ret->Page - 1) * $ret->Perpage);
                        // $stop = (($start + $ret->Perpage) - 1);

                        // $x = 0;
                        // for($i = $start; $i < count($states); $i++)
                        // {
                        //     $ret->Data[$x] = $states[$i];
                        //     if($i == $stop){break;}
                        //     $x++;
                        // }
                    }
                }
            }
        break;
        case 'customer phone exist':
            if(isset($_REQUEST['usersess']))
            {
                $user = new User();
                $user->Initialize($_REQUEST['usersess']);

                $property = new Property(is_a($user->Property, "Property") ? $user->Property->Id : $user->Property);
                $subscriber = new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword);

                if ($user->Id != ""){
                    $user->UpdateSeenTime();
                }

                if (strtolower($_REQUEST['item_type']) == "frontdesk_item"){

                    $user_exists = CustomerByProperty::CustomerByNumber($subscriber, $_REQUEST['phone']);
                    if($user_exists === null){
                        $ret->Data = null;
                        $ret->Message = 'Number does not exist';
                        $ret->Status = 'error';
                    }else{
                        $ret->Data = $user_exists;
                        $ret->Message = 'Successful';
                        $ret->Status = 'success';
                    }
                }
            }
        break;

    }

    echo json_encode($ret);