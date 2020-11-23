<?php
	/* Generated by Wixnit Class Builder 
	// Jan, 10/2020
	// Building class for Contactcollectionitem
	*/

	class Contactcollectionitem
	{
		public $Id = "";
		public $Created = 0;
		public $Contactid = "";
		public $Source = "";
		public $Collectionid = "";

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

                $res = $db->query("SELECT * FROM contactcollectionitem WHERE contactcollectionitemid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['contactcollectionitemid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Contactid = $row['contactid'];
                    $this->Source = $row['source'];
                    $this->Collectionid = $row['collectionid'];
                }
            }
        }


		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$contactid = addslashes($this->Contactid);
			$source = addslashes($this->Source);
			$collectionid = addslashes($this->Collectionid);

			if($res = $db->query("SELECT contactcollectionitemid FROM contactcollectionitem WHERE contactcollectionitemid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE contactcollectionitem SET contactid='$contactid',source='$source',collectionid='$collectionid' WHERE contactcollectionitemid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT contactcollectionitemid FROM contactcollectionitem WHERE contactcollectionitemid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO contactcollectionitem(contactcollectionitemid,created,contactid,source,collectionid) VALUES ('$id','$created','$contactid','$source','$collectionid')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM contactcollectionitem WHERE contactcollectionitemid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollectionitem WHERE contactid LIKE '%$term%' OR source LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Contactcollectionitem($subscriber);
                $ret[$i]->Id = $row['contactcollectionitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Contactid = $row['contactid'];
                $ret[$i]->Source = $row['source'];
                $ret[$i]->Collectionid = $row['collectionid'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='contactcollectionitemid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollectionitem WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Contactcollectionitem($subscriber);
                $ret[$i]->Id = $row['contactcollectionitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Contactid = $row['contactid'];
                $ret[$i]->Source = $row['source'];
                $ret[$i]->Collectionid = $row['collectionid'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollectionitem ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Contactcollectionitem($subscriber);
                $ret[$i]->Id = $row['contactcollectionitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Contactid = $row['contactid'];
                $ret[$i]->Source = $row['source'];
                $ret[$i]->Collectionid = $row['collectionid'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM contactcollectionitem");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Contactcollectionitem($subscriber);
				$ret[$i]->Id = $row['contactcollectionitemid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Contactid = $row['contactid'];
				$ret[$i]->Source = $row['source'];
                $ret[$i]->Collectionid = $row['collectionid'];
				$i++;
			}
			return $ret;
		}

		public static function Exist(Subscriber $subscriber, $contact, $source, $collection)
        {
            $db = $subscriber->GetDB();

            $res = $db->query("SELECT * FROM contactcollectionitem WHERE contactid='$contact' AND source='$source' AND collectionid='$collection'");
            $db->close();

            if($res->num_rows > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
	}
