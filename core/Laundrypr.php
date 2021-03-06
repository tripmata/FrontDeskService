<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 12/2020
	// Building class for Laundrypr
	*/

	class Laundrypr
	{
		public $Id = "";
		public $Created = 0;
		public $Reference = "";
		public $Note = "";
		public $Items = array();
		public $Fulfilled = false;
		public $Order_reference = "";
		public $User = "";
		public $Total = 0;

		private $subscriber = null;

        public $Type = "laundry_pr";

		function __construct(Subscriber $subscriber)
		{
			$this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM laundrypr WHERE laundryprid='$arg'");

                if($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['laundryprid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Reference = $row['refrence'];
                    $this->Note = $row['note'];
                    $this->Items = [];
                    $this->Total = $row['total'];
                    $this->Order_reference = $row['order_reference'];

                    $items = json_decode($row['items']);

                    for($i = 0; $i < count($items); $i++)
                    {
                        if($items[$i] != "")
                        {
                            $it = new Purchaserequestitem($this->subscriber);
                            $it->Initialize($items[$i]);

                            if($it->Item != "")
                            {
                                $fi = new Laundryitem($this->subscriber);
                                $fi->Initialize($it->Item);
                                $it->Item = $fi;
                            }
                            array_push($this->Items, $it);
                        }
                    }
                    $this->Fulfilled = Convert::ToBool($row['fulfilled']);
                    //$this->Order_reference = new Laundrypo($this->subscriber);
                    //$this->Order_reference->Initialize($row['order_reference']);
                    $this->User = new User($this->subscriber);
                    $this->User->Initialize($row['user']);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
            if($this->Reference == "")
            {
                $ref = "pr-".Random::GenerateId(10);
                while($db->query("SELECT refrence FROM laundrypr WHERE refrence='$ref'")->num_rows > 0)
                {
                    $ref = "pr-".Random::GenerateId(10);
                }
                $this->Reference = $ref;
            }
			$refrence = addslashes($this->Reference);
			$note = addslashes($this->Note);

			$fulfilled = Convert::ToInt($this->Fulfilled);
			$order_reference = addslashes(is_a($this->Order_reference, "Laundrypo") ? $this->Order_reference->Id : $this->Order_reference);
			$user = addslashes(is_a($this->User, "User") ? $this->User->Id : $this->User);
			$total = 0.0;

            $it = [];
            for($i = 0; $i < count($this->Items); $i++)
            {
                array_push($it, is_a($this->Items[$i], "Purchaserequestitem") ? $this->Items[$i]->Id : $this->Items[$i]);

                if(is_a($this->Items[$i], "Purchaserequestitem"))
                {
                    $total += (($this->Items[$i]->Quantity) * ($this->Items[$i]->Rate));
                }
                else
                {
                    $t = new Purchaserequestitem($this->subscriber);
                    $t->Initialize($this->Items[$i]);
                    $total += (($t->Quantity) * ($t->Rate));
                }
            }
            $items = addslashes(json_encode($it));

			if($res = $db->query("SELECT laundryprid FROM laundrypr WHERE laundryprid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE laundrypr SET refrence='$refrence',note='$note',items='$items',fulfilled='$fulfilled',order_reference='$order_reference',user='$user',total='$total' WHERE laundryprid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT laundryprid FROM laundrypr WHERE laundryprid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO laundrypr(laundryprid,created,refrence,note,items,fulfilled,order_reference,user,total) VALUES ('$id','$created','$refrence','$note','$items','$fulfilled','$order_reference','$user','$total')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM laundrypr WHERE laundryprid='$id'");


            for($i = 0; $i < count($this->Items); $i++)
            {
                if(is_a($this->Items[$i], "Purchaserequestitem"))
                {
                    $this->Items[$i]->Delete();
                }
                else
                {
                    $prid = $this->Items[$i];
                    $db->query("DELETE FROM purchaserequestitem WHERE purchaserequestitemid='$prid'");
                }
            }

            if($this->Order_reference != "")
            {

            }
			//Deleting Associated Objects
			/*n			$this->Items->Delete();

			$this->Order_reference->Delete();

			$this->User->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypr WHERE refrence LIKE '%$term%' OR note LIKE '%$term%' ORDER BY id DESC");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundrypr($subscriber);
                $ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Total = $row['total'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='laundryprid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypr WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundrypr($subscriber);
                $ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = $row['user'];
                $ret[$i]->Total = $row['total'];

				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypr ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundrypr($subscriber);
                $ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = $row['user'];
                $ret[$i]->Total = $row['total'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypr");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Laundrypr($subscriber);
				$ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Total = $row['total'];
				$i++;
			}
			return $ret;
		}

        public static function Fulfilled(Subscriber $subscriber, $term='')
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM laundrypr WHERE (refrence LIKE '%$term%' OR note LIKE '%$term%') AND fulfilled=1 ORDER BY id DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Laundrypr($subscriber);
                $ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Total = $row['total'];
                $i++;
            }
            return $ret;
        }

        public static function Pending(Subscriber $subscriber, $term='')
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM laundrypr WHERE (refrence LIKE '%$term%' OR note LIKE '%$term%') AND (fulfilled=0 AND order_reference='') ORDER BY id DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Laundrypr($subscriber);
                $ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Total = $row['total'];
                $i++;
            }
            return $ret;
        }

        public static function Processing(Subscriber $subscriber, $term='')
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM laundrypr WHERE (refrence LIKE '%$term%' OR note LIKE '%$term%') AND (fulfilled=0 AND order_reference!='') ORDER BY id DESC");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Laundrypr($subscriber);
                $ret[$i]->Id = $row['laundryprid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Reference = $row['refrence'];
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret[$i]->Order_reference = $row['order_reference'];
                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);
                $ret[$i]->Total = $row['total'];
                $i++;
            }
            return $ret;
        }

        public static function FulfilledCount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $res = $db->query("SELECT id FROM laundrypr WHERE fulfilled=1");
            $db->close();
            return $res->num_rows;
        }

        public static function PendingCount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $res = $db->query("SELECT id FROM laundrypr WHERE fulfilled=0 AND order_reference=''");
            $db->close();
            return $res->num_rows;
        }

        public static function ProcessingCount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $res = $db->query("SELECT id FROM laundrypr WHERE fulfilled=0 AND order_reference!=''");
            $db->close();
            return $res->num_rows;
        }

        public static function AllCount(Subscriber $subscriber)
        {
            $db = $subscriber->GetDB();
            $res = $db->query("SELECT id FROM laundrypr");
            $db->close();
            return $res->num_rows;
        }


        public function GenerateOrder($itList, $user)
        {
            if($this->Order_reference == "")
            {
                $suppliers = [];
                $items = [];

                $db = $this->subscriber->GetDB();

                for($i = 0; $i < count($itList); $i++)
                {
                    if(!in_array($itList[$i]->supplier, $suppliers))
                    {
                        array_push($suppliers, $itList[$i]->supplier);
                    }

                    $items[$itList[$i]->item] = $itList[$i]->supplier;
                }


                $orderRef = "po-".Random::GenerateId(16);
                while(($db->query("SELECT order_reference FROM laundrypr WHERE order_reference='$orderRef'")->num_rows > 0))
                {
                    $orderRef = "po-".Random::GenerateId(16);
                }
                $this->Order_reference = $orderRef;
                $this->Save();


                for($i = 0; $i < count($suppliers); $i++)
                {
                    $po = new Laundrypo($this->subscriber);
                    $po->Supplier = new Supplier($this->subscriber);
                    $po->Supplier->Initialize($suppliers[$i]);
                    $po->Pr = $this->Order_reference = $orderRef;
                    $po->User = $user;
                    $po->Save();

                    for($j = 0; $j < count($this->Items); $j++)
                    {
                        if(isset($items[$this->Items[$j]->Item->Id]))
                        {
                            if($items[$this->Items[$j]->Item->Id] == $suppliers[$i])
                            {
                                $poitem = new Purchaseorderitem($this->subscriber);
                                $poitem->Item = $this->Items[$j]->Item;
                                $poitem->Quantity = $this->Items[$j]->Quantity;
                                $poitem->Rate = $this->Items[$j]->Rate;
                                $poitem->Po = $this->Id;
                                $poitem->Save();

                                $po->Total += ($poitem->Quantity * $poitem->Rate);
                                array_push($po->Items, $poitem);
                            }
                        }
                    }

                    $po->Save();
                }
                return $this->Order_reference;
            }
            else
            {
                return $this->Order_reference;
            }
        }

        public static function ByReference(Subscriber $subscriber, $reference)
        {
            $db = $subscriber->GetDB();
            $ret = null;

            $res = $db->query("SELECT * FROM laundrypr WHERE order_reference='$reference'");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret = new Laundrypr($subscriber);
                $ret->Id = $row['laundryprid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Reference = $row['refrence'];
                $ret->Note = $row['note'];
                $ret->Items = json_decode($row['items']);
                $ret->Fulfilled = Convert::ToBool($row['fulfilled']);
                $ret->Order_reference = $row['order_reference'];
                $ret->User = new User($subscriber);
                $ret->User->Initialize($row['user']);
                $ret->Total = doubleval($row['total']);
            }
            return $ret;
        }
	}
