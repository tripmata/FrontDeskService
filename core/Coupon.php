<?php
	/* Generated by Wixnit Class Builder 
	// Dec, 08/2019
	// Building class for Coupon
	*/

	class Coupon
	{
		public $Id = "";
		public $Created = 0;
		public $Title = "";
		public $Code = "";
		public $Bypercentage = false;
		public $Expires = false;
		public $Used = false;
		public $Status = false;

        /**
         * @var WixDate
         */
		public $Expirydate = 0;

		public $Value = 0;
		public $Usecount = 0;
		public $Booking = array();
		public $Food = array();
		public $Drinks = array();
		public $Pastries = array();
		public $Laundry = array();
		public $Pool = array();
		public $Services = array();

		public $Expired = false;

		private $subscriber = null;

		const Expired = "expired";
		const Used = "used";
		const Added = "added";


		function __construct(Subscriber $subscriber)
		{
            $this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM coupon WHERE couponid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['couponid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Title = $row['title'];
                    $this->Code = $row['code'];
                    $this->Bypercentage = Convert::ToBool($row['bypercentage']);
                    $this->Expires = Convert::ToBool($row['expires']);
                    $this->Used = Convert::ToBool($row['used']);
                    $this->Status = Convert::ToBool($row['status']);
                    $this->Expirydate = new WixDate($row['expirydate']);
                    $this->Value = $row['value'];
                    $this->Usecount = $row['usecount'];
                    $this->Booking = json_decode($row['booking']);
                    $this->Food = json_decode($row['food']);
                    $this->Drinks = json_decode($row['drinks']);
                    $this->Pastries = json_decode($row['pastries']);
                    $this->Laundry = json_decode($row['laundry']);
                    $this->Pool = json_decode($row['pool']);
                    $this->Services = json_decode($row['services']);

                    if($this->Expires)
                    {
                        if($this->Expirydate->getValue() < time())
                        {
                            $this->Expired = true;
                        }
                    }
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$title = addslashes($this->Title);
			$code = addslashes($this->Code);
			$bypercentage = Convert::ToInt($this->Bypercentage);
			$expires = Convert::ToInt($this->Expires);
			$used = Convert::ToInt($this->Used);
			$status = Convert::ToInt($this->Status);
			$expirydate = Convert::ToInt(is_a($this->Expirydate, "WixDate") ? $this->Expirydate->getValue() : $this->Expirydate);
			$value = floatval($this->Value);
			$usecount = Convert::ToInt($this->Usecount);
			$booking = addslashes(json_encode($this->Booking));
			$food = addslashes(json_encode($this->Food));
			$drinks = addslashes(json_encode($this->Drinks));
			$pastries = addslashes(json_encode($this->Pastries));
			$laundry = addslashes(json_encode($this->Laundry));
			$pool = addslashes(json_encode($this->Pool));
            $services = addslashes(json_encode($this->Services));

			if($res = $db->query("SELECT couponid FROM coupon WHERE couponid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE coupon SET title='$title',code='$code',bypercentage='$bypercentage',expires='$expires',used='$used',`status`='$status',expirydate='$expirydate',`value`='$value',usecount='$usecount',booking='$booking',food='$food',drinks='$drinks',pastries='$pastries',laundry='$laundry',`pool`='$pool',services='$services' WHERE couponid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT couponid FROM coupon WHERE couponid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO coupon(couponid,created,title,code,bypercentage,expires,used,`status`,expirydate,`value`,usecount,booking,food,drinks,pastries,laundry,`pool`,services) VALUES ('$id','$created','$title','$code','$bypercentage','$expires','$used','$status','$expirydate','$value','$usecount','$booking','$food','$drinks','$pastries','$laundry','$pool','$services')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM coupon WHERE couponid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT couponid FROM coupon WHERE title LIKE '%$term%' OR code LIKE '%$term%' OR bypercentage LIKE '%$term%' OR expires LIKE '%$term%' OR used LIKE '%$term%' OR status LIKE '%$term%' OR expirydate LIKE '%$term%' OR value LIKE '%$term%' OR usecount LIKE '%$term%' OR booking LIKE '%$term%' OR food LIKE '%$term%' OR drinks LIKE '%$term%' OR pastries LIKE '%$term%' OR laundry LIKE '%$term%' OR pool LIKE '%$term%' OR services LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['couponid'];
				$i++;
			}
			return Coupon::GroupInitialize($subscriber, $ret);
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='couponid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT couponid FROM coupon WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['couponid'];
				$i++;
			}
			return Coupon::GroupInitialize($subscriber, $ret);
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT couponid FROM coupon ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['couponid'];
				$i++;
			}
			return Coupon::GroupInitialize($subscriber, $ret);
		}

		public static function GroupInitialize(Subscriber $subscriber, $array=null, $orderBy='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$query = "";

			if(is_array($array) === true)
			{
				if(count($array) == 0)
				{
					return $ret;
				}
				else
				{
					for($i = 0; $i < count($array); $i++)
					{
						if($query == "")
						{
							$query = " WHERE Couponid='".$array[$i]."'";
						}
						else
						{
							$query .= " OR Couponid ='".$array[$i]."'";
						}
					}
				}
			}
			$i = 0;
			$res = $db->query("SELECT * FROM coupon".$query." ORDER BY ".$orderBy." ".$order);
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Coupon($subscriber);
				$ret[$i]->Id = $row['couponid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Title = $row['title'];
				$ret[$i]->Code = $row['code'];
				$ret[$i]->Bypercentage = Convert::ToBool($row['bypercentage']);
				$ret[$i]->Expires = Convert::ToBool($row['expires']);
				$ret[$i]->Used = Convert::ToBool($row['used']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Expirydate = new WixDate($row['expirydate']);
				$ret[$i]->Value = $row['value'];
				$ret[$i]->Usecount = $row['usecount'];
				$ret[$i]->Booking = json_decode($row['booking']);
				$ret[$i]->Food = json_decode($row['food']);
				$ret[$i]->Drinks = json_decode($row['drinks']);
				$ret[$i]->Pastries = json_decode($row['pastries']);
				$ret[$i]->Laundry = json_decode($row['laundry']);
				$ret[$i]->Pool = json_decode($row['pool']);
				$ret[$i]->Services = json_decode($row['services']);

                if($ret[$i]->Expires)
                {
                    if($ret[$i]->Expirydate->getValue() < time())
                    {
                        $ret[$i]->Expired = true;
                    }
                }

				$i++;
			}
			return $ret;
		}

		//Hand crafted
        public static function Usedcoupon(Subscriber $subscriber, $searchterm)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            if($searchterm == "")
            {
                $query = "SELECT * FROM coupon WHERE used=1";
            }
            else
            {
                $query = "SELECT * FROM coupon WHERE used=1 AND (title LIKE '%$searchterm%' OR code LIKE '%$searchterm%')";
            }

            $res = $db->query($query);
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Coupon($subscriber);
                $ret[$i]->Id = $row['couponid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Code = $row['code'];
                $ret[$i]->Bypercentage = Convert::ToBool($row['bypercentage']);
                $ret[$i]->Expires = Convert::ToBool($row['expires']);
                $ret[$i]->Used = Convert::ToBool($row['used']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Expirydate = Convert::ToBool($row['expirydate']);
                $ret[$i]->Value = $row['value'];
                $ret[$i]->Usecount = $row['usecount'];
                $ret[$i]->Booking = json_decode($row['booking']);
                $ret[$i]->Food = json_decode($row['food']);
                $ret[$i]->Drinks = json_decode($row['drinks']);
                $ret[$i]->Pastries = json_decode($row['pastries']);
                $ret[$i]->Laundry = json_decode($row['laundry']);
                $ret[$i]->Pool = json_decode($row['pool']);
                $ret[$i]->Services = json_decode($row['services']);
                $i++;
            }
            return $ret;
        }

        public static function Unusedcoupon(Subscriber $subscriber, $searchterm)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $tm = time();

            if($searchterm == "")
            {
                $query = "SELECT * FROM coupon WHERE used=0";
            }
            else
            {
                $query = "SELECT * FROM coupon WHERE used=0 AND (title LIKE '%$searchterm%' OR code LIKE '%$searchterm%')";
            }
            $res = $db->query($query);
            while(($row = $res->fetch_assoc()) != null)
            {
                if((($row['expires'] == 1) && ($row['expirydate'] > $tm)) || ($row['expires'] == 0))
                {
                    $ret[$i] = new Coupon($subscriber);
                    $ret[$i]->Id = $row['couponid'];
                    $ret[$i]->Created = new WixDate($row['created']);
                    $ret[$i]->Title = $row['title'];
                    $ret[$i]->Code = $row['code'];
                    $ret[$i]->Bypercentage = Convert::ToBool($row['bypercentage']);
                    $ret[$i]->Expires = Convert::ToBool($row['expires']);
                    $ret[$i]->Used = Convert::ToBool($row['used']);
                    $ret[$i]->Status = Convert::ToBool($row['status']);
                    $ret[$i]->Expirydate = Convert::ToBool($row['expirydate']);
                    $ret[$i]->Value = $row['value'];
                    $ret[$i]->Usecount = $row['usecount'];
                    $ret[$i]->Booking = json_decode($row['booking']);
                    $ret[$i]->Food = json_decode($row['food']);
                    $ret[$i]->Drinks = json_decode($row['drinks']);
                    $ret[$i]->Pastries = json_decode($row['pastries']);
                    $ret[$i]->Laundry = json_decode($row['laundry']);
                    $ret[$i]->Pool = json_decode($row['pool']);
                    $ret[$i]->Services = json_decode($row['services']);
                    $i++;
                }
            }
            return $ret;
        }

        public static function Expiredcoupon(Subscriber $subscriber, $searchterm)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $tm = time();

            if($searchterm == "")
            {
                $query = "SELECT * FROM coupon WHERE used=0 AND expires=1 AND expirydate < '$tm'";
            }
            else
            {
                $query = "SELECT * FROM coupon WHERE (used=0 AND expires=1 AND expirydate < '$tm') AND (title LIKE '%$searchterm%' OR code LIKE '%$searchterm%')";
            }

            $res = $db->query($query);
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Coupon($subscriber);
                $ret[$i]->Id = $row['couponid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Code = $row['code'];
                $ret[$i]->Bypercentage = Convert::ToBool($row['bypercentage']);
                $ret[$i]->Expires = Convert::ToBool($row['expires']);
                $ret[$i]->Used = Convert::ToBool($row['used']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Expirydate = Convert::ToBool($row['expirydate']);
                $ret[$i]->Value = $row['value'];
                $ret[$i]->Usecount = $row['usecount'];
                $ret[$i]->Booking = json_decode($row['booking']);
                $ret[$i]->Food = json_decode($row['food']);
                $ret[$i]->Drinks = json_decode($row['drinks']);
                $ret[$i]->Pastries = json_decode($row['pastries']);
                $ret[$i]->Laundry = json_decode($row['laundry']);
                $ret[$i]->Pool = json_decode($row['pool']);
                $ret[$i]->Services = json_decode($row['services']);
                $ret[$i]->Expired = true;
                $i++;
            }
            return $ret;
        }

        public static function Usedcount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = $db->query("SELECT * FROM coupon WHERE used=1")->num_rows;
            $db->close();
            return $ret;
        }

        public static function Unusedcount(Subscriber $subscriber)
        {
            return (self::Countall($subscriber) - (self::Usedcount($subscriber) + self::Expiredcount($subscriber)));
        }

        public static function Expiredcount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $tm = time();
            $ret = $db->query("SELECT * FROM coupon WHERE used=0 AND expires=1 AND expirydate < '$tm'")->num_rows;
            $db->close();
            return $ret;
        }

        public static function Countall(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = $db->query("SELECT * FROM coupon")->num_rows;
            $db->close();
            return $ret;
        }

        public static function byCode(Subscriber $subscriber, $code)
        {
            $db = $subscriber->GetDB();
            $ret = null;

            $res = $db->query("SELECT * FROM coupon WHERE code='$code'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Coupon($subscriber);
                $ret->Id = $row['couponid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Title = $row['title'];
                $ret->Code = $row['code'];
                $ret->Bypercentage = Convert::ToBool($row['bypercentage']);
                $ret->Expires = Convert::ToBool($row['expires']);
                $ret->Used = Convert::ToBool($row['used']);
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Expirydate = $row['expirydate'];
                $ret->Value = $row['value'];
                $ret->Usecount = $row['usecount'];
                $ret->Booking = json_decode($row['booking']);
                $ret->Food = json_decode($row['food']);
                $ret->Drinks = json_decode($row['drinks']);
                $ret->Pastries = json_decode($row['pastries']);
                $ret->Laundry = json_decode($row['laundry']);
                $ret->Pool = json_decode($row['pool']);
                $ret->Services = json_decode($row['services']);
            }
            return $ret;
        }

        public static function applyCoupon(string $bookingNumber)
        {
            if (isset($_REQUEST['coupons']))
            {
                // @var string $coupons
                $coupons = explode(',', $_REQUEST['coupons']);

                // are we good ??
                if (count($coupons) > 0)
                {
                    // load subscriber
                    $subscriber = new Subscriber();

                    // load coupons
                    foreach ($coupons as $coupon)
                    {
                        // create instance
                        $couponClass = new Coupon($subscriber);
                        $couponClass->Initialize($coupon);

                        // not expired
                        if ($couponClass->Expired == false && $couponClass->Used == false)
                        {
                            // subtract
                            $couponClass->Usecount--;

                            // are we done
                            if ($couponClass->Usecount <= 0) {

                                // all done
                                $couponClass->Usecount = 0;
                                $couponClass->Used = true;
                            }

                            // save 
                            $couponClass->Save();

                            // record usage
                            self::recordUsage($coupon, $bookingNumber);
                        }
                    }
                }
            }
        }

        public static function recordUsage(string $couponId, string $bookingNumber)
        {
            // load db
            $db = DB::GetDB();

            // get discount
            $discount = doubleval($_REQUEST['discount']);

            // get user
            $user = addslashes($_REQUEST['posuser']);

            // get property ID
            $propertyId = addslashes($_REQUEST['propertyid']);

            // get date created
            $created = time();

            // save now
            $db->query("INSERT INTO couponUsage (couponid,created,bookingid,amount,usedby,propertyid) VALUES ('$couponId', '$created', '$bookingNumber', '$discount', '$user', '$propertyId')");

        }
	}
