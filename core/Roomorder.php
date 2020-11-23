<?php
	/* Generated by Wixnit Class Builder
	// Dec, 19/2019
	// Building class for Roomorder
	*/

	class Roomorder extends Order
	{
		public $Id = "";
		public $Created = 0;
		public $Room = "";

        /**
         * @var WixDate
         */
		public $Checkindate = 0;
        /**
         * @var WixDate
         */
		public $Checkoutdate = 0;
		public $Invoice = "";
		public $Paid = false;
		public $Guest = "";
		public $Guestcount = 0;
		public $Extraservices = array();
		public $Roomcategory = "";

		public $Stayperiod = 0;

		protected $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
            $this->Type = "room_order";
            $this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM roomorder WHERE roomorderid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['roomorderid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Room = new Room($row['room']);
                    $this->Checkindate = new WixDate($row['checkindate']);
                    $this->Checkoutdate = new WixDate($row['checkoutdate']);
                    $this->Invoice = new Invoice($row['invoice']);
                    $this->Paid = Convert::ToBool($row['paid']);
                    $this->Guest = new Guest($this->subscriber);
                    $this->Guest->Initialize($row['guest']);
                    $this->Guestcount = $row['guestcount'];
                    $this->Extraservices = json_decode($row['extraservices']);
                    $this->Roomcategory = new roomcategory($row['roomcategory']);
                    $this->Itemkey = $row['itemkey'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$room = addslashes(is_a($this->Room, "Room") ? $this->Room->Id : $this->Room);
			$checkindate = is_a($this->Checkindate, "WixDate") ? $this->Checkindate->getValue() : Convert::ToInt($this->Checkindate);
			$checkoutdate = is_a($this->Checkoutdate, "WixDate") ? $this->Checkoutdate->getValue() : Convert::ToInt($this->Checkoutdate);
			$invoice = addslashes(is_a($this->Invoice, "Invoice") ? $this->Invoice->Id : $this->Invoice);
			$paid = Convert::ToInt($this->Paid);
			$guest = addslashes(is_a($this->Guest, "Guest") ? $this->Guest->Id : $this->Guest);
			$guestcount = Convert::ToInt($this->Guestcount);
			$extraservices = addslashes(json_encode($this->Extraservices));
			$roomcategory = addslashes(is_a($this->Roomcategory, "roomcategory") ? $this->Roomcategory->Id : $this->Roomcategory);
            $itemkey = addslashes($this->Itemkey);

            if($res = $db->query("SELECT roomorderid FROM roomorder WHERE roomorderid='$id'")->num_rows > 0)
            {
                $db->query("UPDATE roomorder SET room='$room',checkindate='$checkindate',checkoutdate='$checkoutdate',invoice='$invoice',paid='$paid',guest='$guest',guestcount='$guestcount',extraservices='$extraservices',roomcategory='$roomcategory',itemkey='$itemkey' WHERE roomorderid = '$id'");
            }
            else
            {
                redo: ;
                $id = Random::GenerateId(16);
                if($db->query("SELECT roomorderid FROM roomorder WHERE roomorderid='$id'")->num_rows > 0)
                {
                    goto redo;
                }
                $this->Id = $id;
                $db->query("INSERT INTO roomorder(roomorderid,created,room,checkindate,checkoutdate,invoice,paid,guest,guestcount,extraservices,roomcategory,itemkey) VALUES ('$id','$created','$room','$checkindate','$checkoutdate','$invoice','$paid','$guest','$guestcount','$extraservices','$roomcategory','$itemkey')");
            }
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM roomorder WHERE roomorderid='$id'");

			//Deleting Associated Objects
			/*n			$this->Room->Delete();

			$this->Invoice->Delete();

			$this->Guest->Delete();

			$this->Roomcategory->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

            $res = $db->query("SELECT * FROM roomorder WHERE room LIKE '%$term%' OR checkindate LIKE '%$term%' OR checkoutdate LIKE '%$term%' OR invoice LIKE '%$term%' OR paid LIKE '%$term%' OR guest LIKE '%$term%' OR guestcount LIKE '%$term%' OR extraservices LIKE '%$term%' OR roomcategory LIKE '%$term%' OR itemkey LIKE '%$term%'");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Roomorder($subscriber);
                $ret[$i]->Id = $row['roomorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Room($row['room']);
                $ret[$i]->Checkindate = new WixDate($row['checkindate']);
                $ret[$i]->Checkoutdate = new WixDate($row['checkoutdate']);
                $ret[$i]->Invoice = new Invoice($row['invoice']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Guest = new Guest($subscriber);
								$ret[$i]->Guest->Initialize($row['guest']);
                $ret[$i]->Guestcount = $row['guestcount'];
                $ret[$i]->Extraservices = json_decode($row['extraservices']);
                $ret[$i]->Roomcategory = new roomcategory($row['roomcategory']);
                $ret[$i]->Itemkey = $row['itemkey'];
                $i++;
            }
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='roomorderid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomorder WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomorder($subscriber);
                $ret[$i]->Id = $row['roomorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Room($row['room']);
                $ret[$i]->Checkindate = new WixDate($row['checkindate']);
                $ret[$i]->Checkoutdate = new WixDate($row['checkoutdate']);
                $ret[$i]->Invoice = new Invoice($row['invoice']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
								$ret[$i]->Guest = new Guest($subscriber);
								$ret[$i]->Guest->Initialize($row['guest']);
                $ret[$i]->Guestcount = $row['guestcount'];
                $ret[$i]->Extraservices = json_decode($row['extraservices']);
                $ret[$i]->Roomcategory = new roomcategory($row['roomcategory']);
                $ret[$i]->Itemkey = $row['itemkey'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomorder ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Roomorder($subscriber);
                $ret[$i]->Id = $row['roomorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Room($row['room']);
                $ret[$i]->Checkindate = new WixDate($row['checkindate']);
                $ret[$i]->Checkoutdate = new WixDate($row['checkoutdate']);
                $ret[$i]->Invoice = new Invoice($row['invoice']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
								$ret[$i]->Guest = new Guest($subscriber);
								$ret[$i]->Guest->Initialize($row['guest']);
                $ret[$i]->Guestcount = $row['guestcount'];
                $ret[$i]->Extraservices = json_decode($row['extraservices']);
                $ret[$i]->Roomcategory = new roomcategory($row['roomcategory']);
                $ret[$i]->Itemkey = $row['itemkey'];
                $i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM roomorder");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Roomorder($subscriber);
				$ret[$i]->Id = $row['roomorderid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Room = new Room($row['room']);
				$ret[$i]->Checkindate = new WixDate($row['checkindate']);
				$ret[$i]->Checkoutdate = new WixDate($row['checkoutdate']);
				$ret[$i]->Invoice = new Invoice($row['invoice']);
				$ret[$i]->Paid = Convert::ToBool($row['paid']);
				$ret[$i]->Guest = new Guest($subscriber);
				$ret[$i]->Guest->Initialize($row['guest']);
				$ret[$i]->Guestcount = $row['guestcount'];
				$ret[$i]->Extraservices = json_decode($row['extraservices']);
				$ret[$i]->Roomcategory = new roomcategory($row['roomcategory']);
                $ret[$i]->Itemkey = $row['itemkey'];
				$i++;
			}
			return $ret;
		}

		public static function ByItemkey(Subscriber $subscriber, $key)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM roomorder WHERE itemkey='$key'");

            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Roomorder($subscriber);
                $ret[$i]->Id = $row['roomorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Room = new Room($subscriber);
                $ret[$i]->Room->Initialize($row['room']);
                $ret[$i]->Checkindate = new WixDate($row['checkindate']);
                $ret[$i]->Checkoutdate = new WixDate($row['checkoutdate']);
                $ret[$i]->Invoice = new Invoice($subscriber);
                $ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Guest = new Guest($subscriber);
                $ret[$i]->Guest->Initialize($row['guest']);
                $ret[$i]->Guestcount = $row['guestcount'];
                $ret[$i]->Extraservices = json_decode($row['extraservices']);
                $ret[$i]->Roomcategory = new roomcategory($subscriber);
                $ret[$i]->Roomcategory->Initialize($row['roomcategory']);
                $ret[$i]->Itemkey = $row['itemkey'];
                $i++;
            }
            return $ret;
        }

        public static function Calc(Roomorder $roomorder)
        {
            $ret = 0;

            $d = $roomorder->Checkoutdate->getValue() - $roomorder->Checkindate->getValue();
            $days = ($d / ((60 * 60) * 24));
            $ret += ($roomorder->Roomcategory->Price * $days);

            if($roomorder->Guestcount > $roomorder->Roomcategory->Baseoccupancy)
            {
                $ret += ($roomorder->Roomcategory->Extraguestprice * ($roomorder->Guestcount - $roomorder->Roomcategory->Baseoccupancy)) * $days;
            }

            return $ret;
        }

        public static function CalculateTaxes(Roomorder $roomorder, $compound=false)
        {
            /*
            if($compound)
            {
                $ret = doubleval($foodorder->Food->Tax);
            }
            else
            {
                $ret = (doubleval($foodorder->Food->Tax) * $foodorder->Quantity);
            }
            return $ret;
            */
            return 0;
        }

        public static function Days(Roomorder $roomorder)
        {
            $d = $roomorder->Checkoutdate->getValue() - $roomorder->Checkindate->getValue();
            return ($d / ((60 * 60) * 24));
        }
	}
