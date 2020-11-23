<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 13/2020
	// Building class for Pastryquotation
	*/

	class Pastryquotation
	{
		public $Id = "";
		public $Created = 0;
		public $Displayreference = "";
		public $Sms = false;
		public $Email = false;
		public $Associatedsuppliers = false;
		public $Responded = false;
		public $Responsecomplete = false;
		public $Note = "";
		public $Suppliers = array();
		public $Items = array();

        public $Type = "pastry_quotation";

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

                $res = $db->query("SELECT * FROM pastryquotaion WHERE pastryquotaionid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['pastryquotaionid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Displayreference = $row['displayreference'];
                    $this->Sms = Convert::ToBool($row['sms']);
                    $this->Email = Convert::ToBool($row['email']);
                    $this->Associatedsuppliers = Convert::ToBool($row['associatedsuppliers']);
                    $this->Responded = Convert::ToBool($row['responded']);
                    $this->Responsecomplete = Convert::ToBool($row['responsecomplete']);
                    $this->Note = $row['note'];

                    $this->Suppliers = [];
                    $sup = json_decode($row['suppliers']);
                    for($i = 0; $i < count($sup); $i++)
                    {
                        $this->Suppliers[$i] = new Supplier($this->subscriber);
                        $this->Suppliers[$i]->Initialize($sup[$i]);
                    }

                    $this->Items = [];
                    $itm = json_decode($row['items']);
                    for($i = 0; $i < count($itm); $i++)
                    {
                        $this->Items[$i] = new Quotationitem($this->subscriber);
                        $this->Items[$i]->Initialize($itm[$i]);

                        $it = $this->Items[$i]->Item;
                        $this->Items[$i]->Item = new Pastryitem($this->subscriber);
                        $this->Items[$i]->Item->Initialize($it);
                    }
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$displayreference = addslashes($this->Displayreference);
			$sms = Convert::ToInt($this->Sms);
			$email = Convert::ToInt($this->Email);
			$associatedsuppliers = Convert::ToInt($this->Associatedsuppliers);
			$responded = Convert::ToInt($this->Responded);
			$responsecomplete = Convert::ToInt($this->Responsecomplete);
			$note = addslashes($this->Note);


            $sp = [];
            for($i = 0; $i < count($this->Suppliers); $i++)
            {
                if(is_a($this->Suppliers[$i], "Supplier"))
                {
                    array_push($sp, $this->Suppliers[$i]->Id);
                }
                else
                {
                    if($this->Suppliers[$i] != "")
                    {
                        array_push($sp, $this->Suppliers[$i]);
                    }
                }
            }
            $suppliers = addslashes(json_encode($sp));


            $it = [];
            for($i = 0; $i < count($this->Items); $i++)
            {
                if(is_a($this->Items[$i], "Quotationitem"))
                {
                    array_push($it, $this->Items[$i]->Id);
                }
                else
                {
                    if($this->Items[$i] != "")
                    {
                        array_push($it, $this->Items[$i]);
                    }
                }
            }
            $items = addslashes(json_encode($it));



            if($res = $db->query("SELECT pastryquotaionid FROM pastryquotaion WHERE pastryquotaionid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE pastryquotaion SET displayreference='$displayreference',sms='$sms',email='$email',associatedsuppliers='$associatedsuppliers',responded='$responded',responsecomplete='$responsecomplete',note='$note',suppliers='$suppliers',items='$items' WHERE pastryquotaionid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT pastryquotaionid FROM pastryquotaion WHERE pastryquotaionid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO pastryquotaion(pastryquotaionid,created,displayreference,sms,email,associatedsuppliers,responded,responsecomplete,note,suppliers,items) VALUES ('$id','$created','$displayreference','$sms','$email','$associatedsuppliers','$responded','$responsecomplete','$note','$suppliers','$items')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM pastryquotaion WHERE pastryquotaionid='$id'");
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM pastryquotaion WHERE displayreference LIKE '%$term%' OR sms LIKE '%$term%' OR email LIKE '%$term%' OR associatedsuppliers LIKE '%$term%' OR responded LIKE '%$term%' OR responsecomplete LIKE '%$term%' OR note LIKE '%$term%' OR suppliers LIKE '%$term%' OR items LIKE '%$term%' ORDER BY id DESC");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Pastryquotation($subscriber);
                $ret[$i]->Id = $row['pastryquotaionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Displayreference = $row['displayreference'];
                $ret[$i]->Sms = Convert::ToBool($row['sms']);
                $ret[$i]->Email = Convert::ToBool($row['email']);
                $ret[$i]->Associatedsuppliers = Convert::ToBool($row['associatedsuppliers']);
                $ret[$i]->Responded = Convert::ToBool($row['responded']);
                $ret[$i]->Responsecomplete = Convert::ToBool($row['responsecomplete']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Suppliers = json_decode($row['suppliers']);
                $ret[$i]->Items = json_decode($row['items']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='pastryquotaionid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM pastryquotaion WHERE ".$field." ='$term' ORDER BY id DESC");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Pastryquotation($subscriber);
                $ret[$i]->Id = $row['pastryquotaionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Displayreference = $row['displayreference'];
                $ret[$i]->Sms = Convert::ToBool($row['sms']);
                $ret[$i]->Email = Convert::ToBool($row['email']);
                $ret[$i]->Associatedsuppliers = Convert::ToBool($row['associatedsuppliers']);
                $ret[$i]->Responded = Convert::ToBool($row['responded']);
                $ret[$i]->Responsecomplete = Convert::ToBool($row['responsecomplete']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Suppliers = json_decode($row['suppliers']);
                $ret[$i]->Items = json_decode($row['items']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM pastryquotaion ORDER BY ".$field." ".$order." ORDER BY id DESC");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Pastryquotation($subscriber);
                $ret[$i]->Id = $row['pastryquotaionid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Displayreference = $row['displayreference'];
                $ret[$i]->Sms = Convert::ToBool($row['sms']);
                $ret[$i]->Email = Convert::ToBool($row['email']);
                $ret[$i]->Associatedsuppliers = Convert::ToBool($row['associatedsuppliers']);
                $ret[$i]->Responded = Convert::ToBool($row['responded']);
                $ret[$i]->Responsecomplete = Convert::ToBool($row['responsecomplete']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Suppliers = json_decode($row['suppliers']);
                $ret[$i]->Items = json_decode($row['items']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM pastryquotaion ORDER BY id DESC");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Pastryquotation($subscriber);
				$ret[$i]->Id = $row['pastryquotaionid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Displayreference = $row['displayreference'];
				$ret[$i]->Sms = Convert::ToBool($row['sms']);
				$ret[$i]->Email = Convert::ToBool($row['email']);
				$ret[$i]->Associatedsuppliers = Convert::ToBool($row['associatedsuppliers']);
				$ret[$i]->Responded = Convert::ToBool($row['responded']);
				$ret[$i]->Responsecomplete = Convert::ToBool($row['responsecomplete']);
				$ret[$i]->Note = $row['note'];
				$ret[$i]->Suppliers = json_decode($row['suppliers']);
				$ret[$i]->Items = json_decode($row['items']);
				$i++;
			}
			return $ret;
		}

        //Hand crafted
        public function GenerateReference()
        {
            if($this->Displayreference == "")
            {
                $db = $this->subscriber->GetDB();
                $ref = Random::GenerateId(6);
                while($db->query("SELECT id FROM roomquotaion WHERE displayreference='$ref'")->num_rows > 0)
                {
                    $ref = Random::GenerateId(6);
                }
                $this->Displayreference = $ref;
            }
        }
	}
