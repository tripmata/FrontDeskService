<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 14/2020
	// Building class for Printer
	*/

	class Printer
	{
		public $Id = "";
		public $Created = 0;
		public $Document = "";
		public $Meta = "";
		public $Session = "";
		public $Printobject = array();
		public $Expires = false;
		public $Expiary = 0;

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

                $res = $db->query("SELECT * FROM printer WHERE printerid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['printerid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Document = $row['document'];
                    $this->Meta = $row['meta'];
                    $this->Session = $row['session'];
                    $this->Printobject = json_decode($row['printobject']);
                    $this->Expires = Convert::ToBool($row['expires']);
                    $this->Expiary = $row['expiary'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$document = addslashes($this->Document);
			$meta = addslashes($this->Meta);
			$session = addslashes($this->Session);
			$printobject = addslashes(json_encode($this->Printobject));
			$expires = Convert::ToInt($this->Expires);
			$expiary = Convert::ToInt($this->Expiary);

			if($res = $db->query("SELECT printerid FROM printer WHERE printerid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE printer SET document='$document',meta='$meta',session='$session',printobject='$printobject',expires='$expires',expiary='$expiary' WHERE printerid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT printerid FROM printer WHERE printerid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO printer(printerid,created,document,meta,session,printobject,expires,expiary) VALUES ('$id','$created','$document','$meta','$session','$printobject','$expires','$expiary')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM printer WHERE printerid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM printer WHERE document LIKE '%$term%' OR meta LIKE '%$term%' OR session LIKE '%$term%' OR printobject LIKE '%$term%' OR expires LIKE '%$term%' OR expiary LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Printer($subscriber);
                $ret[$i]->Id = $row['printerid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Document = $row['document'];
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Session = $row['session'];
                $ret[$i]->Printobject = json_decode($row['printobject']);
                $ret[$i]->Expires = Convert::ToBool($row['expires']);
                $ret[$i]->Expiary = $row['expiary'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='printerid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT printerid FROM printer WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Printer($subscriber);
                $ret[$i]->Id = $row['printerid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Document = $row['document'];
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Session = $row['session'];
                $ret[$i]->Printobject = json_decode($row['printobject']);
                $ret[$i]->Expires = Convert::ToBool($row['expires']);
                $ret[$i]->Expiary = $row['expiary'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT printerid FROM printer ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Printer($subscriber);
                $ret[$i]->Id = $row['printerid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Document = $row['document'];
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Session = $row['session'];
                $ret[$i]->Printobject = json_decode($row['printobject']);
                $ret[$i]->Expires = Convert::ToBool($row['expires']);
                $ret[$i]->Expiary = $row['expiary'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM printer");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Printer($subscriber);
				$ret[$i]->Id = $row['printerid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Document = $row['document'];
				$ret[$i]->Meta = $row['meta'];
				$ret[$i]->Session = $row['session'];
				$ret[$i]->Printobject = json_decode($row['printobject']);
				$ret[$i]->Expires = Convert::ToBool($row['expires']);
				$ret[$i]->Expiary = $row['expiary'];
				$i++;
			}
			return $ret;
		}

		public static function SafePrint(Subscriber $subscriber, $printObject, $document, $expires=true, $expiry=1440)
        {
            $db = $subscriber->GetDB();

            $ret = new Printer($subscriber);
            $ret->Printobject = json_encode($printObject);
            $ret->Document = $document;
            $ret->Expires = $expires;
            $ret->Expiary = $expiry;


            $session = Random::GenerateId(16);
            while($db->query("SELECT id FROM printer WHERE session='$session'")->num_rows > 0)
            {
                $ret->Session = Random::GenerateId(16);
            }
            $ret->Session = $session;

            $meta= Random::GenerateId(16);
            while($db->query("SELECT id FROM printer WHERE meta='$meta'")->num_rows > 0)
            {
                $ret->Meta = Random::GenerateId(16);
            }
            $ret->Meta = $meta;
            $ret->Save();
            return $ret;
        }

        public static function ByMeta(Subscriber $subscriber, $meta)
        {
            $db  = $subscriber->GetDB();
            $ret = null;
            $res = $db->query("SELECT * FROM printer WHERE meta='$meta'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Printer($subscriber);
                $ret->Id = $row['printerid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Document = $row['document'];
                $ret->Meta = $row['meta'];
                $ret->Session = $row['session'];
                $ret->Printobject = json_decode($row['printobject']);
                $ret->Expires = Convert::ToBool($row['expires']);
                $ret->Expiary = $row['expiary'];
            }
            return $ret;
        }
	}
