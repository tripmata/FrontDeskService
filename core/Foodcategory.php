<?php
	/* Generated by Wixnit Class Builder 
	// Dec, 20/2019
	// Building class for Foodcategory
	*/

	class Foodcategory
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Sort = 0;
		public $Status = false;

		public $Meta = "";

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}


		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                if($arg == "default")
                {
                    $this->Id = "default";
                    $this->Name = "Default";
                }
                else
                {
                    $db = $this->subscriber->GetDB();

                    $res = $db->query("SELECT * FROM foodcategory WHERE foodcategoryid='$arg'");

                    if($res->num_rows > 0)
                    {
                        $row = $res->fetch_assoc();

                        $this->Id = $row['foodcategoryid'];
                        $this->Created = new WixDate($row['created']);
                        $this->Name = $row['name'];
                        $this->Sort = $row['sort'];
                        $this->Status = Convert::ToBool($row['status']);
                        $this->Meta = $row['meta'];
                    }
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$sort = Convert::ToInt($this->Sort);
			$status = Convert::ToInt($this->Status);

            $meta = addslashes(Router::BuildMeta($this->Name));

			if($res = $db->query("SELECT foodcategoryid FROM foodcategory WHERE foodcategoryid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE foodcategory SET name='$name',sort='$sort',status='$status',meta='$meta' WHERE foodcategoryid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT foodcategoryid FROM foodcategory WHERE foodcategoryid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO foodcategory(foodcategoryid,created,name,sort,status,meta) VALUES ('$id','$created','$name','$sort','$status','$meta')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM foodcategory WHERE foodcategoryid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM foodcategory WHERE name LIKE '%$term%' OR sort LIKE '%$term%' OR status LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Foodcategory($subscriber);
                $ret[$i]->Id = $row['foodcategoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Meta = $row['meta'];
                $i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='foodcategoryid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM foodcategory WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Foodcategory($subscriber);
                $ret[$i]->Id = $row['foodcategoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Meta = $row['meta'];
                $i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM foodcategory ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Foodcategory($subscriber);
                $ret[$i]->Id = $row['foodcategoryid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Meta = $row['meta'];
                $i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM foodcategory");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Foodcategory($subscriber);
				$ret[$i]->Id = $row['foodcategoryid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Sort = $row['sort'];
				$ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Meta = $row['meta'];
				$i++;
			}
			return $ret;
		}

        public static function ByMeta(Subscriber $subscriber, $meta)
        {

            $db = $subscriber->GetDB();
            $ret = null;

            if($meta !=  "default")
            {
                $res = $db->query("SELECT * FROM foodcategory WHERE meta='$meta'");
                if ($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $ret = new Foodcategory($subscriber);
                    $ret->Id = $row['foodcategoryid'];
                    $ret->Created = new WixDate($row['created']);
                    $ret->Name = $row['name'];
                    $ret->Sort = $row['sort'];
                    $ret->Status = Convert::ToBool($row['status']);
                    $ret->Meta = $row['meta'];
                }
            }
            else
            {
                $ret = new Foodcategory($subscriber);
                $ret->Initialize($meta);
            }
            return $ret;
        }
	}
