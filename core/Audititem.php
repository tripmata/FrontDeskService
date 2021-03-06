<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 15/2020
	// Building class for Audititem
	*/

	class Audititem
	{
		public $Id = "";
		public $Created = 0;
		public $Item = "";
		public $Stock = "";
		public $Counted = "";
		public $Note = "";

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

                $res = $db->query("SELECT * FROM audititem WHERE audititemid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['audititemid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Item = $row['item'];
                    $this->Stock = $row['stock'];
                    $this->Counted = $row['counted'];
                    $this->Note = $row['note'];
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$item = addslashes(is_string($this->Item) ? $this->Item : $this->Item->Id);
			$stock = addslashes($this->Stock);
			$counted = addslashes($this->Counted);
			$note = addslashes($this->Note);

			if($res = $db->query("SELECT audititemid FROM audititem WHERE audititemid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE audititem SET item='$item',stock='$stock',counted='$counted',note='$note' WHERE audititemid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT audititemid FROM audititem WHERE audititemid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO audititem(audititemid,created,item,stock,counted,note) VALUES ('$id','$created','$item','$stock','$counted','$note')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM audititem WHERE audititemid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM audititem WHERE item LIKE '%$term%' OR stock LIKE '%$term%' OR counted LIKE '%$term%' OR note LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Audititem($subscriber);
                $ret[$i]->Id = $row['audititemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Item = $row['item'];
                $ret[$i]->Stock = $row['stock'];
                $ret[$i]->Counted = $row['counted'];
                $ret[$i]->Note = $row['note'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='audititemid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM audititem WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Audititem($subscriber);
                $ret[$i]->Id = $row['audititemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Item = $row['item'];
                $ret[$i]->Stock = $row['stock'];
                $ret[$i]->Counted = $row['counted'];
                $ret[$i]->Note = $row['note'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM audititem ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Audititem($subscriber);
                $ret[$i]->Id = $row['audititemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Item = $row['item'];
                $ret[$i]->Stock = $row['stock'];
                $ret[$i]->Counted = $row['counted'];
                $ret[$i]->Note = $row['note'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM audititem");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Audititem($subscriber);
				$ret[$i]->Id = $row['audititemid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Item = $row['item'];
				$ret[$i]->Stock = $row['stock'];
				$ret[$i]->Counted = $row['counted'];
				$ret[$i]->Note = $row['note'];
				$i++;
			}
			return $ret;
		}
	}
