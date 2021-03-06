<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 25/2020
	// Building class for Bakeryorder
	*/

	class Bakeryorder
	{
		public $Id = "";
		public $Created = 0;
		public $Customer = "";
		public $Pastrypixel = array();
		public $Total = 0;
		public $Taxes = 0;
		public $Discount = 0;
		public $Invoice = "";
		public $Room = "";
		public $Paid = false;
		public $Fullfilled = false;

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public function Initialize($arg)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM bakeryorder WHERE bakeryorderid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['bakeryorderid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Customer = new Customer($this->subscriber);
                    $this->Customer->Initialize($row['customer']);
                    $this->Pastrypixel = [];

                    $px =  json_decode($row['pastrypixel']);

                    for($i = 0; $i < count($px); $i++)
                    {
                        if($px != "")
                        {
                            $p = new Pastrypixel($this->subscriber, $px[$i]);
                            array_push($this->Pastrypixel, $p);
                        }
                    }

                    $this->Total = doubleval($row['total']);
                    $this->Taxes = doubleval($row['taxes']);
                    $this->Discount = doubleval($row['discount']);
                    //$this->Invoice = new Invoice($this->subscriber);
                    //$this->Invoice->Initialize($row['invoice']);
                    $this->Room = new Room($this->subscriber);
                    $this->Room->Initialize($row['room']);
                    $this->Paid = Convert::ToBool($row['paid']);
                    $this->Fullfilled = Convert::ToBool($row['fullfilled']);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$customer = addslashes(is_a($this->Customer, "Customer") ? $this->Customer->Id : $this->Customer);

			$total = addslashes($this->Total);
			$taxes = addslashes($this->Taxes);
			$discount = addslashes($this->Discount);
			$invoice = addslashes(is_a($this->Invoice, "Invoice") ? $this->Invoice->Id : $this->Invoice);
			$room = addslashes(is_a($this->Room, "Room") ? $this->Room->Id : $this->Room);
			$paid = Convert::ToInt($this->Paid);
			$fullfilled = Convert::ToInt($this->Fullfilled);

			$px = [];
			for($i = 0; $i < count($this->Pastrypixel); $i++)
            {
                array_push($px, is_a($this->Pastrypixel[$i], "Pastrypixel") ? $this->Pastrypixel[$i]->Pixelate() : $this->Pastrypixel[$i]);
            }
			$pastrypixel = json_encode($px);

			if($res = $db->query("SELECT bakeryorderid FROM bakeryorder WHERE bakeryorderid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE bakeryorder SET customer='$customer',pastrypixel='$pastrypixel',total='$total',taxes='$taxes',discount='$discount',invoice='$invoice',room='$room',paid='$paid',fullfilled='$fullfilled' WHERE bakeryorderid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT bakeryorderid FROM bakeryorder WHERE bakeryorderid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO bakeryorder(bakeryorderid,created,customer,pastrypixel,total,taxes,discount,invoice,room,paid,fullfilled) VALUES ('$id','$created','$customer','$pastrypixel','$total','$taxes','$discount','$invoice','$room','$paid','$fullfilled')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM bakeryorder WHERE bakeryorderid='$id'");

			//Deleting Associated Objects
			/*n			$this->Customer->Delete();

			$this->Pastrypixel->Delete();

			$this->Invoice->Delete();

			$this->Room->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakeryorder WHERE customer LIKE '%$term%' OR pastrypixel LIKE '%$term%' OR total LIKE '%$term%' OR taxes LIKE '%$term%' OR discount LIKE '%$term%' OR invoice LIKE '%$term%' OR room LIKE '%$term%' OR paid LIKE '%$term%' OR fullfilled LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Bakeryorder($subscriber);
                $ret[$i]->Id = $row['bakeryorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Customer = new Customer($subscriber);
                $ret[$i]->Customer->Initialize($row['customer']);
                $ret[$i]->Pastrypixel = json_decode($row['pastrypixel']);
                $ret[$i]->Total = $row['total'];
                $ret[$i]->Taxes = $row['taxes'];
                $ret[$i]->Discount = $row['discount'];
                //$ret[$i]->Invoice = new Invoice($subscriber);
                //$ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='bakeryorderid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakeryorder WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Bakeryorder($subscriber);
                $ret[$i]->Id = $row['bakeryorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Customer = new Customer($subscriber);
                $ret[$i]->Customer->Initialize($row['customer']);
                $ret[$i]->Pastrypixel = [];

                $px =  json_decode($row['pastrypixel']);

                for($j = 0; $j < count($px); $j++)
                {
                    if($px != "")
                    {
                        $p = new Pastrypixel($subscriber, $px[$j]);
                        array_push($ret[$i]->Pastrypixel, $p);
                    }
                }
                $ret[$i]->Total = $row['total'];
                $ret[$i]->Taxes = $row['taxes'];
                $ret[$i]->Discount = $row['discount'];
                //$ret[$i]->Invoice = new Invoice($subscriber);
                //$ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakeryorder ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Bakeryorder($subscriber);
                $ret[$i]->Id = $row['bakeryorderid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Customer = new Customer($subscriber);
                $ret[$i]->Customer->Initialize($row['customer']);
                $ret[$i]->Pastrypixel = json_decode($row['pastrypixel']);
                $ret[$i]->Total = $row['total'];
                $ret[$i]->Taxes = $row['taxes'];
                $ret[$i]->Discount = $row['discount'];
                //$ret[$i]->Invoice = new Invoice($subscriber);
                //$ret[$i]->Invoice->Initialize($row['invoice']);
                $ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM bakeryorder");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Bakeryorder($subscriber);
				$ret[$i]->Id = $row['bakeryorderid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Customer = new Customer($subscriber);
				$ret[$i]->Customer->Initialize($row['customer']);
				$ret[$i]->Pastrypixel = json_decode($row['pastrypixel']);
				$ret[$i]->Total = $row['total'];
				$ret[$i]->Taxes = $row['taxes'];
				$ret[$i]->Discount = $row['discount'];
				//$ret[$i]->Invoice = new Invoice($subscriber);
				//$ret[$i]->Invoice->Initialize($row['invoice']);
				$ret[$i]->Room = Lodging::Rooms($subscriber, $ret[$i]->Customer);
				$ret[$i]->Paid = Convert::ToBool($row['paid']);
				$ret[$i]->Fullfilled = Convert::ToBool($row['fullfilled']);
				$i++;
			}
			return $ret;
		}
	}
