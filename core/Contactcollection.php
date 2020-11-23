<?php
	/* Generated by Wixnit Class Builder 
	// Jan, 10/2020
	// Building class for Contactcollection
	*/

	class Contactcollection
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Issystem = false;

		public $Itemcount = 0;

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

                $res = $db->query("SELECT * FROM contactcollection WHERE contactcollectionid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['contactcollectionid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Name = $row['name'];
                    $this->Issystem = Convert::ToBool($row['issystem']);

                    $this->runItemCount();
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$issystem = Convert::ToInt($this->Issystem);

			if($res = $db->query("SELECT contactcollectionid FROM contactcollection WHERE contactcollectionid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE contactcollection SET name='$name',issystem='$issystem' WHERE contactcollectionid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT contactcollectionid FROM contactcollection WHERE contactcollectionid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO contactcollection(contactcollectionid,created,name,issystem) VALUES ('$id','$created','$name','$issystem')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM contactcollection WHERE contactcollectionid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollection WHERE issystem=0 AND name LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Contactcollection($subscriber);
                $ret[$i]->Id = $row['contactcollectionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Issystem = Convert::ToBool($row['issyetm']);
                $ret[$i]->runItemCount();
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='contactcollectionid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollection WHERE issystem=0 AND ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Contactcollection($subscriber);
                $ret[$i]->Id = $row['contactcollectionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Issystem = Convert::ToBool($row['issyetm']);
                $ret[$i]->runItemCount();
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollection WHERE issystem=0 AND ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Contactcollection($subscriber);
                $ret[$i]->Id = $row['contactcollectionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->runItemCount();
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollection WHERE issystem=0");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Contactcollection($subscriber);
				$ret[$i]->Id = $row['contactcollectionid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
                $ret[$i]->runItemCount();
				$i++;
			}
			return $ret;
		}

		//Hand crafted methods

        public function runItemCount()
        {
            $db = $this->subscriber->GetDB();
            $id = $this->Id;
            $res = $db->query("SELECT * FROM contactcollectionitem WHERE collectionid='$id'");
            $db->close();
            $this->Itemcount = $res->num_rows;
        }

        public function Getitems()
        {
            $db = $this->subscriber->GetDB();
            $ret = array();
            $i = 0;

            $id = $this->Id;

            $res = $db->query("SELECT * FROM contactcollectionitem WHERE collectionid='$id'");
            $db->close();
            while(($row = $res->fetch_assoc()) != null)
            {
                if(strtolower($row['source']) === "customer")
                {
                    $ret[$i] = new Customer($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "customer")
                {
                    $ret[$i] = new Customer($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "guest")
                {
                    $ret[$i] = new Guest($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "subguest")
                {
                    $ret[$i] = new Subguest($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "supplier")
                {
                    $ret[$i] = new Supplier($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "staff")
                {
                    $ret[$i] = new Staff($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "subscriber")
                {
                    $ret[$i] = new Contact($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                if(strtolower($row['source']) === "message")
                {
                    $ret[$i] = new Message($this->subscriber);
                    $ret[$i]->Initialize($row['contactid']);
                }
                $i++;
            }
            return $ret;
        }


        public function Additem($itemid, $source)
        {
            if(!Contactcollectionitem::Exist($this->subscriber, $itemid, $source, $this->Id))
            {
                $item = new Contactcollectionitem($this->subscriber);
                $item->Source = $source;
                $item->Contactid = $itemid;
                $item->Collectionid = $this->Id;
                $item->Save();
            }
        }

        public function Removeitem($contactid, $source)
        {
            $db = $this->subscriber->GetDB();
            $id = $this->Id;
            $db->query("DELETE FROM contactcollectionitem WHERE contactid='$contactid' AND source='$source' AND collectionid='$id'");
        }

        public static function Removefromalllist(Subscriber $subscriber, $contactid, $source)
        {
            $db = $subscriber->GetDB();
            $db->query("DELETE FROM contactcollectionitem WHERE contactid='$contactid' AND source='$source'");
        }
	}
