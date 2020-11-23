<?php
	/* Generated by Wixnit Class Builder 
	// Dec, 20/2019
	// Building class for Drink
	*/

	class Drink
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Category = "";
		public $Onsite = false;
		public $Status = false;
		public $Showpromo = false;
		public $Reservable = false;
		public $Trackinventory = false;
		public $Sort = 0;
		public $Price = 0;
		public $Tax = 0;
		public $Compareat = 0;
		public $Images = array();
		public $Description = "";
		public $Promotext = "";
		public $Pos = true;
		public $Barcode = "";
		public $Costprice = 0.0;

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

                $res = $db->query("SELECT * FROM drink WHERE drinkid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['drinkid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Name = $row['name'];
                    $this->Category = new Drinkcategory($this->subscriber);
                    $this->Category->Initialize($row['category']);
                    $this->Onsite = Convert::ToBool($row['onsite']);
                    $this->Status = Convert::ToBool($row['status']);
                    $this->Showpromo = Convert::ToBool($row['showpromo']);
                    $this->Reservable = Convert::ToBool($row['reservable']);
                    $this->Trackinventory = Convert::ToBool($row['trackinventory']);
                    $this->Sort = $row['sort'];
                    $this->Price = $row['price'];
                    $this->Tax = $row['tax'];
                    $this->Compareat = $row['compareat'];
                    $this->Images = json_decode($row['images']);
                    $this->Description = $row['description'];
                    $this->Promotext = $row['promotext'];
                    $this->Pos = Convert::ToBool($row['pos']);
                    $this->Barcode = $row['barcode'];
                    $this->Costprice = $row['cost'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$category = addslashes(is_a($this->Category, "drinkcategory") ? $this->Category->Id : $this->Category);
			$onsite = Convert::ToInt($this->Onsite);
			$status = Convert::ToInt($this->Status);
			$showpromo = Convert::ToInt($this->Showpromo);
			$reservable = Convert::ToInt($this->Reservable);
			$trackinventory = Convert::ToInt($this->Trackinventory);
			$sort = Convert::ToInt($this->Sort);
			$price = floatval($this->Price);
			$tax = floatval($this->Tax);
			$compareat = floatval($this->Compareat);
			$images = addslashes(json_encode($this->Images));
			$description = addslashes($this->Description);
			$promotext = addslashes($this->Promotext);
			$pos = Convert::ToInt($this->Pos);
			$barcode = addslashes($this->Barcode);
			$cost = floatval($this->Costprice);

			if($res = $db->query("SELECT drinkid FROM drink WHERE drinkid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE drink SET name='$name',category='$category',onsite='$onsite',status='$status',showpromo='$showpromo',reservable='$reservable',trackinventory='$trackinventory',sort='$sort',price='$price',tax='$tax',compareat='$compareat',images='$images',description='$description',promotext='$promotext',pos='$pos',barcode='$barcode',cost='$cost' WHERE drinkid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT drinkid FROM drink WHERE drinkid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO drink(drinkid,created,name,category,onsite,status,showpromo,reservable,trackinventory,sort,price,tax,compareat,images,description,promotext,pos,barcode,cost) VALUES ('$id','$created','$name','$category','$onsite','$status','$showpromo','$reservable','$trackinventory','$sort','$price','$tax','$compareat','$images','$description','$promotext','$pos','$barcode','$cost')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM drink WHERE drinkid='$id'");

			//Deleting Associated Objects
			/*n			$this->Category->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM drink WHERE name LIKE '%$term%' OR category LIKE '%$term%' OR onsite LIKE '%$term%' OR status LIKE '%$term%' OR showpromo LIKE '%$term%' OR reservable LIKE '%$term%' OR trackinventory LIKE '%$term%' OR sort LIKE '%$term%' OR price LIKE '%$term%' OR tax LIKE '%$term%' OR compareat LIKE '%$term%' OR images LIKE '%$term%' OR description LIKE '%$term%' OR promotext LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Drink($subscriber);
                $ret[$i]->Id = $row['drinkid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Category = new Drinkcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Showpromo = Convert::ToBool($row['showpromo']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Trackinventory = Convert::ToBool($row['trackinventory']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Tax = $row['tax'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Pos = Convert::ToBool($row['pos']);
                $ret[$i]->Barcode = $row['barcode'];
                $ret[$i]->Costprice = $row['cost'];
                $i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='drinkid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM drink WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Drink($subscriber);
                $ret[$i]->Id = $row['drinkid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Category = new Drinkcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Showpromo = Convert::ToBool($row['showpromo']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Trackinventory = Convert::ToBool($row['trackinventory']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Tax = $row['tax'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Pos = Convert::ToBool($row['pos']);
                $ret[$i]->Barcode = $row['barcode'];
                $ret[$i]->Costprice = $row['cost'];
                $i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM drink ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Drink($subscriber);
                $ret[$i]->Id = $row['drinkid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Category = new Drinkcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Showpromo = Convert::ToBool($row['showpromo']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Trackinventory = Convert::ToBool($row['trackinventory']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Tax = $row['tax'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Pos = Convert::ToBool($row['pos']);
                $ret[$i]->Barcode = $row['barcode'];
                $ret[$i]->Costprice = $row['cost'];
                $i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM drink");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Drink($subscriber);
				$ret[$i]->Id = $row['drinkid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
                $ret[$i]->Category = new Drinkcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
				$ret[$i]->Onsite = Convert::ToBool($row['onsite']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Showpromo = Convert::ToBool($row['showpromo']);
				$ret[$i]->Reservable = Convert::ToBool($row['reservable']);
				$ret[$i]->Trackinventory = Convert::ToBool($row['trackinventory']);
				$ret[$i]->Sort = $row['sort'];
				$ret[$i]->Price = $row['price'];
				$ret[$i]->Tax = $row['tax'];
				$ret[$i]->Compareat = $row['compareat'];
				$ret[$i]->Images = json_decode($row['images']);
				$ret[$i]->Description = $row['description'];
				$ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Pos = Convert::ToBool($row['pos']);
                $ret[$i]->Barcode = $row['barcode'];
                $ret[$i]->Costprice = $row['cost'];
				$i++;
			}
			return $ret;
		}


        //Hand crafted
        public static function ByBarcode(Subscriber $subscriber, $code)
        {
            $ret = new Drink($subscriber);

            $db = $subscriber->GetDB();

            $res = $db->query("SELECT * FROM drink WHERE barcode='$code'");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret->Id = $row['drinkid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Name = $row['name'];
                $ret->Category = new Drinkcategory($subscriber);
                $ret->Category->Initialize($row['category']);
                $ret->Onsite = Convert::ToBool($row['onsite']);
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Showpromo = Convert::ToBool($row['showpromo']);
                $ret->Reservable = Convert::ToBool($row['reservable']);
                $ret->Trackinventory = Convert::ToBool($row['trackinventory']);
                $ret->Sort = $row['sort'];
                $ret->Price = $row['price'];
                $ret->Tax = $row['tax'];
                $ret->Compareat = $row['compareat'];
                $ret->Images = json_decode($row['images']);
                $ret->Description = $row['description'];
                $ret->Promotext = $row['promotext'];
                $ret->Pos = Convert::ToBool($row['pos']);
                $ret->Barcode = $row['barcode'];
                $ret->Costprice = $row['cost'];
            }

            return $ret;
        }


        public static function BarcodeExist(Subscriber $subscriber, $code)
        {
            $ret = false;
            $db = $subscriber->GetDB();
            $ret = $db->query("SELECT drinkid FROM drink WHERE barcode='$code'")->num_rows > 0 ? true : false;
            $db->close();
            return $ret;
        }



        public static function ByPopularity(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM drink WHERE status=1 AND onsite=1 LIMIT 10");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Drink($subscriber);
                $ret[$i]->Id = $row['drinkid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Category = new Drinkcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Showpromo = Convert::ToBool($row['showpromo']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Trackinventory = Convert::ToBool($row['trackinventory']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Tax = $row['tax'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Pos = Convert::ToBool($row['pos']);
                $ret[$i]->Barcode = $row['barcode'];
                $ret[$i]->Costprice = $row['cost'];
                $i++;
            }
            return $ret;
        }


        public static function Bycategory(Subscriber $subscriber, Drinkcategory $drinkcategory, $sortfiled='id', $sortorder='ASC')
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $catid = $drinkcategory->Id;

            if($catid == "default")
            {
                $res = $db->query("SELECT * FROM drink WHERE status=1 AND onsite=1 ORDER BY ".$sortfiled." ".$sortorder);
            }
            else
            {
                $res = $db->query("SELECT * FROM drink WHERE status=1 AND onsite=1 AND category='$catid' ORDER BY ".$sortfiled." ".$sortorder);
            }


            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Drink($subscriber);
                $ret[$i]->Id = $row['drinkid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Category = new Drinkcategory($subscriber);
                $ret[$i]->Category->Initialize($row['category']);
                $ret[$i]->Onsite = Convert::ToBool($row['onsite']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Showpromo = Convert::ToBool($row['showpromo']);
                $ret[$i]->Reservable = Convert::ToBool($row['reservable']);
                $ret[$i]->Trackinventory = Convert::ToBool($row['trackinventory']);
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Price = $row['price'];
                $ret[$i]->Tax = $row['tax'];
                $ret[$i]->Compareat = $row['compareat'];
                $ret[$i]->Images = json_decode($row['images']);
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Promotext = $row['promotext'];
                $ret[$i]->Pos = Convert::ToBool($row['pos']);
                $ret[$i]->Barcode = $row['barcode'];
                $ret[$i]->Costprice = $row['cost'];
                $i++;
            }
            return $ret;
        }
	}
