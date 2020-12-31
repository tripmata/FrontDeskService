<?php
    session_start();
    require_once ("loader.php");

    $host = $urlConfiguration->host;
    $cdn = $urlConfiguration->storage;
    
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
                        //$filtervalue = $_REQUEST['Filtervalue'];
                        

                        $ret->Data = [];
                        $store = [];

                        $ret->Page = $page;
                        $ret->Perpage = $perpage;

                        $ret->noShow = Reservation::noShowCount($property);
                        $ret->dueToday = Reservation::DueTodayCount($property);

                        if($_REQUEST['searchterm'] != "")
                        {
                            $store = Reservation::Search($property, $_REQUEST['searchterm']);
                        }
                        else
                        {
                            $store = Reservation::applyFilter($property, $filter, $_REQUEST['dueDate']);
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
                            $r->category = $roomCat[$i]->Name;
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
                        $ret->Data->reservations = Reservation::ByPeriod($property);
                        $ret->Data->lodging = Lodging::byPeriod(new Subscriber($property->Databasename, $property->DatabaseUser, $property->DatabasePassword));
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

                            for($i = 0; $i < count($lodging->Rooms); $i++)
                            {
                                if(($lodging->Rooms[$i]->Category->Name === $_REQUEST['category']) || ($lodging->Rooms[$i]->Number == $_REQUEST['room']))
                                {
                                    $lodging->Rooms[$i]->Checkedout = true;
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

                            if(doubleval($_REQUEST['paidAmount']) > 0)
                            {
                                $reservation->Paidamount = doubleval($_REQUEST['paidAmount']);
                                $reservation->Paid = true;
                            }

                            $customer = null;

                            if (CustomerByProperty::PhoneExist($guest->phone))
                            {
                                $customer = CustomerByProperty::ByPhone($guest->phone);
                            }
                            elseif (CustomerByProperty::EmailExist($guest->email))
                            {
                                $customer = CustomerByProperty::ByEmail($guest->email);
                            }
                            else
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
                                    $std->Number = 1;
                                    $std->Room = $cat;

                                    array_push($roomList, $std);
                                }
                            }

                            $reservation->Customer = $customer;
                            $reservation->Property = $property;

                            $checkin = new WixDate(intval($_REQUEST['checkoutdate']));
                            $checkout = new WixDate(intval($_REQUEST['checkindate']));

                            $reservation->Checkoutdate = new WixDate(strtotime($checkin->Month."/".$checkin->Day."/".$checkin->Year));
                            $reservation->Checkindate = new WixDate(strtotime($checkout->Month."/".$checkout->Day."/".$checkout->Year));
                            $reservation->Rooms = $roomList;
                            $reservation->Save();

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
                            $reservation->Paidamount += doubleval($reservation->Paidamount) + doubleval($_REQUEST['amount']);
                            $reservation->Paid = true;

                            $paytrack = new Lodgingtransaction($subscriber);
                            $paytrack->Paytime = new WixDate($_REQUEST['time']);
                            $paytrack->User = $_REQUEST['posuser'];
                            $paytrack->Amount = doubleval($_REQUEST['amount']);
                            $paytrack->Lodging = $reservation->Id;
                            $paytrack->Method = $_REQUEST['method'];
                            $paytrack->Save();

                            $reservation->Save();

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

                            $lodging->Save();

                            $ret->Status = "success";
                            $ret->Message = "transaction saved";
                            $ret->Data = null;
                        }

                        if ($_REQUEST['operation'] === "checkin")
                        {
                            $lodging = new Lodging($subscriber);


                            $guest = json_decode($_REQUEST['guest']);
                            $items = explode(",", $_REQUEST['items']);

                            $customer = null;

                            $rooms = [];

                            if (Convert::ToBool($_REQUEST['fromReserve']))
                            {
                                $reservation = new Reservation($_REQUEST['booking']);
                                $reservation->Checkedin = true;
                                $reservation->Activated = true;
                                $reservation->Noshow = false;

                                if(doubleval($_REQUEST['paidAmount']) > 0)
                                {
                                    $reservation->Paidamount = (doubleval($reservation->Paidamount)) + doubleval($_REQUEST['paidAmount']);
                                    $reservation->Paid = true;
                                }
                                $reservation->Save();

                                $lodging->Guest = $reservation->Customer;

                                $lodging->Children = Convert::ToInt($reservation->Children);
                                $lodging->Adults = Convert::ToInt($reservation->Adult);

                                // save customer
                                if (!CustomerByProperty::PhoneExist($reservation->Customer->Phone) && !CustomerByProperty::EmailExist($reservation->Customer->Email))
                                {
                                    $customer = new CustomerByProperty(new Subscriber());
                                    $customer->Email = $reservation->Customer->Email;
                                    $customer->Id = $reservation->Customer->Id;
                                    $customer->Phone = $reservation->Customer->Phone;
                                    $customer->fetchCustomerIdBeforeSaving(CustomerByProperty::SAVE_ON_CHECKIN);
                                }
                                
                            }
                            else
                            {
                                if (CustomerByProperty::PhoneExist($guest->phone))
                                {
                                    $customer = CustomerByProperty::ByPhone($guest->phone);
                                }
                                elseif (CustomerByProperty::EmailExist($guest->email))
                                {
                                    $customer = CustomerByProperty::ByEmail($guest->email);
                                }
                                else
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
                            }
                            
                            $lodging->Discount = doubleval($_REQUEST['discount']);
                            $lodging->Taxes = doubleval($_REQUEST['taxes']);
                            $lodging->Total = doubleval($_REQUEST['total']);


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

                            $lodging->Rooms = $rooms;
                            $lodging->Checkincount = count($rooms);
                            $lodging->Save();

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
                                $reservation->RefundPaymentCondition = json_encode([
                                    'method'   => $_REQUEST['payment_method'],
                                    'message'  => $_REQUEST['message'],
                                    'loggedBy' => $_REQUEST['posuser']
                                ]);
                            }

                            $reservation->Save();

                            $ret->Status = "success";
                            $ret->Message = "No show marked. Pending Confirmation from Customer.";
                            $ret->Data = null;

                            if ($reservation->IsOnline == 1 && floatval($reservation->Paidamount) > 0)
                            {
                                // send confirmation email
                                $reservation->sendConfirmationMail();
                            }
                        }

                        if ($_REQUEST['operation'] === "cancel reservation")
                        {
                            $reservation = new Reservation($_REQUEST['booking']);
                            $reservation->Cancelled = true;
                            $reservation->Noshow = false;
                            $reservation->Save();

                            $ret->Status = "success";
                            $ret->Message = "No show marked";
                            $ret->Data = null;
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
            }
            else
            {
                // update reservation
                $db->query("UPDATE reservation SET noshow = 2, isConfirmedByGuest = 1 WHERE reservationid = '{$_REQUEST['id']}'");
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
    }

    echo json_encode($ret);