<?php
	/* Generated by Wixnit Class Builder 
	// Dec, 20/2019
	// Building class for Laundry
	*/

	class Laundry
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Price = 0;
		public $Status = false;
		public $Tax = 0;

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM laundry WHERE laundryid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['laundryid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Name = $row['name'];
                    $this->Price = $row['price'];
                    $this->Status = Convert::ToBool($row['status']);
                    $this->Tax = $row['tax'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$price = floatval($this->Price);
			$status = Convert::ToInt($this->Status);
			$tax = floatval($this->Tax);

			if($res = $db->query("SELECT laundryid FROM laundry WHERE laundryid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE laundry SET name='$name',price='$price',status='$status',tax='$tax' WHERE laundryid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT laundryid FROM laundry WHERE laundryid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO laundry(laundryid,created,name,price,status,tax) VALUES ('$id','$created','$name','$price','$status','$tax')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM laundry WHERE laundryid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundry WHERE name LIKE '%$term%' OR price LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundry($subscriber);
                $ret[$i]->Id = $row['laundryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Tax = $row['tax'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='laundryid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundry WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundry($subscriber);
                $ret[$i]->Id = $row['laundryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Tax = $row['tax'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundry ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundry($subscriber);
                $ret[$i]->Id = $row['laundryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Tax = $row['tax'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundry");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Laundry($subscriber);
				$ret[$i]->Id = $row['laundryid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Price = $row['price'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Tax = $row['tax'];
				$i++;
			}
			return $ret;
		}
	}
