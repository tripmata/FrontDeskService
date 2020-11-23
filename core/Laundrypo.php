<?php
	/* Generated by Wixnit Class Builder 
	// Mar, 11/2020
	// Building class for Laundrypo
	*/

	class Laundrypo
	{
		public $Id = "";
		public $Created = 0;
		public $Supplier = "";
		public $Items = array();
		public $User = "";
		public $Receiver = "";
		public $Total = 0;
		public $Paidamount = 0;
		public $Note = "";
		public $Paid = false;
		public $Received = false;
		public $Pr = "";
		public $Receivedate = 0;
		public $Paydate = 0;

		public $Creditnote = "";

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

				$res = $db->query("SELECT * FROM laundrypo WHERE laundrypoid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['laundrypoid'];
					$this->Created = new WixDate($row['created']);
                    $this->Supplier = new Supplier($this->subscriber);
                    $this->Supplier->Initialize($row['supplier']);
                    $this->Items = [];

                    $it = json_decode($row['items']);
                    for($i = 0; $i < count($it); $i++)
                    {
                        $itm = new Purchaseorderitem($this->subscriber);
                        $itm->Initialize($it[$i]);

                        $tm = $itm->Item;
                        $itm->Item = new Laundryitem($this->subscriber);
                        $itm->Item->Initialize($tm);

                        array_push($this->Items, $itm);
                    }

                    $this->User = new User($this->subscriber);
                    $this->User->Initialize($row['user']);

                    $this->Receiver = new User($this->subscriber);
                    $this->Receiver->Initialize($row['receiver']);

                    $this->Total = doubleval($row['total']);
                    $this->Paidamount = doubleval($row['paidamount']);
                    $this->Note = $row['note'];
                    $this->Paid = Convert::ToBool($row['paid']);
                    $this->Received = Convert::ToBool($row['received']);
                    $this->Pr = $row['pr'];
                    $this->Receivedate = new WixDate($row['receivedate']);
                    $this->Paydate = new WixDate($row['paydate']);
                    $this->Creditnote = $row['creditnote'];
				}
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$supplier = addslashes(is_a($this->Supplier, "Supplier") ? $this->Supplier->Id : $this->Supplier);
			$items = "[]";
			$user = addslashes(is_a($this->User, "User") ? $this->User->Id : $this->User);
			$receiver = addslashes(is_a($this->Receiver, "User") ? $this->Receiver->Id : $this->Receiver);
			$total = floatval($this->Total);
			$paidamount = floatval($this->Paidamount);
			$note = addslashes($this->Note);
			$paid = Convert::ToInt($this->Paid);
			$received = Convert::ToInt($this->Received);
			$pr = addslashes($this->Pr);
			$receivedate = Convert::ToInt($this->Receivedate);
			$paydate = Convert::ToInt($this->Paydate);

			$creditnote = addslashes($this->Creditnote);

            $t = [];
            for($i = 0; $i < count($this->Items); $i++)
            {
                array_push($t, is_a($this->Items[$i], "Purchaseorderitem") ? $this->Items[$i]->Id : $this->Items[$i]);
            }
            $items = json_encode($t);

			if($res = $db->query("SELECT laundrypoid FROM laundrypo WHERE laundrypoid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE laundrypo SET supplier='$supplier',items='$items',user='$user',receiver='$receiver',total='$total',paidamount='$paidamount',note='$note',paid='$paid',received='$received',pr='$pr',receivedate='$receivedate',paydate='$paydate',creditnote='$creditnote' WHERE laundrypoid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT laundrypoid FROM laundrypo WHERE laundrypoid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO laundrypo(laundrypoid,created,supplier,items,user,receiver,total,paidamount,note,paid,received,pr,receivedate,paydate,creditnote) VALUES ('$id','$created','$supplier','$items','$user','$receiver','$total','$paidamount','$note','$paid','$received','$pr','$receivedate','$paydate','$creditnote')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM laundrypo WHERE laundrypoid='$id'");

			//Deleting Associated Objects
			/*n			$this->Supplier->Delete();

			$this->Items->Delete();

			$this->User->Delete();

			$this->Receiver->Delete();
			*/
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypo WHERE supplier LIKE '%$term%' OR items LIKE '%$term%' OR user LIKE '%$term%' OR receiver LIKE '%$term%' OR total LIKE '%$term%' OR paidamount LIKE '%$term%' OR note LIKE '%$term%' OR paid LIKE '%$term%' OR received LIKE '%$term%' OR pr LIKE '%$term%' OR receivedate LIKE '%$term%' OR paydate LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundrypo($subscriber);
                $ret[$i]->Id = $row['laundrypoid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Supplier = $row['supplier'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Receiver = $row['receiver'];
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Received = Convert::ToBool($row['received']);
                $ret[$i]->Pr = $row['pr'];
                $ret[$i]->Receivedate = new WixDate($row['receivedate']);
                $ret[$i]->Paydate = new WixDate($row['paydate']);
                $ret[$i]->Creditnote = $row['creditnote'];
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='laundrypoid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypo WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundrypo($subscriber);
                $ret[$i]->Id = $row['laundrypoid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Supplier = $row['supplier'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Receiver = $row['receiver'];
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Received = Convert::ToBool($row['received']);
                $ret[$i]->Pr = $row['pr'];
                $ret[$i]->Receivedate = new WixDate($row['receivedate']);
                $ret[$i]->Paydate = new WixDate($row['paydate']);
                $ret[$i]->Creditnote = $row['creditnote'];
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypo ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Laundrypo($subscriber);
                $ret[$i]->Id = $row['laundrypoid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Supplier = $row['supplier'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Receiver = $row['receiver'];
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Received = Convert::ToBool($row['received']);
                $ret[$i]->Pr = $row['pr'];
                $ret[$i]->Receivedate = new WixDate($row['receivedate']);
                $ret[$i]->Paydate = new WixDate($row['paydate']);
                $ret[$i]->Creditnote = $row['creditnote'];
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM laundrypo");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Laundrypo($subscriber);
				$ret[$i]->Id = $row['laundrypoid'];
				$ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Supplier = $row['supplier'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->User = $row['user'];
                $ret[$i]->Receiver = $row['receiver'];
                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Received = Convert::ToBool($row['received']);
                $ret[$i]->Pr = $row['pr'];
                $ret[$i]->Receivedate = new WixDate($row['receivedate']);
                $ret[$i]->Paydate = new WixDate($row['paydate']);
                $ret[$i]->Creditnote = $row['creditnote'];
				$i++;
			}
			return $ret;
		}


        public static function ByReference(Subscriber $subscriber, $refrence)
        {
            $db = $subscriber->GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT * FROM laundrypo WHERE pr='$refrence'");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Laundrypo($subscriber);
                $ret[$i]->Id = $row['laundrypoid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Supplier = new Supplier($subscriber);
                $ret[$i]->Supplier->Initialize($row['supplier']);
                $ret[$i]->Items = [];

                $it = json_decode($row['items']);
                for($j = 0; $j < count($it); $j++)
                {
                    $itm = new Purchaseorderitem($subscriber);
                    $itm->Initialize($it[$j]);

                    $tm = $itm->Item;
                    $itm->Item = new Laundryitem($subscriber);
                    $itm->Item->Initialize($tm);

                    array_push($ret[$i]->Items, $itm);
                }

                $ret[$i]->User = new User($subscriber);
                $ret[$i]->User->Initialize($row['user']);

                $ret[$i]->Receiver = new User($subscriber);
                $ret[$i]->Receiver->Initialize($row['receiver']);

                $ret[$i]->Total = doubleval($row['total']);
                $ret[$i]->Paidamount = doubleval($row['paidamount']);
                $ret[$i]->Note = $row['note'];
                $ret[$i]->Paid = Convert::ToBool($row['paid']);
                $ret[$i]->Received = Convert::ToBool($row['received']);
                $ret[$i]->Pr = $row['pr'];
                $ret[$i]->Receivedate = new WixDate($row['receivedate']);
                $ret[$i]->Paydate = new WixDate($row['paydate']);
                $ret[$i]->Creditnote = $row['creditnote'];

                $i++;
            }
            return $ret;
        }

        public function GenerateCreditNote($user)
        {
            $note = new Suppliercredit($this->subscriber);

            if($this->Creditnote != "")
            {
                $note->Initialize($this->Creditnote);
            }
            else
            {
                $tots = 0;
                for($i = 0; $i < count($this->Items); $i++)
                {
                    if($this->Items[$i]->Supplied > 0)
                    {
                        $item = new Itempixel();
                        $item->Item = $this->Items[$i]->Item->Name;
                        $item->Itemid = $this->Items[$i]->Item->Id;
                        $item->Type = "laundryitem";
                        $item->Quantity = $this->Items[$i]->Supplied;
                        $item->Price = $this->Items[$i]->Rate;
                        $item->Name = $this->Items[$i]->Item->Name;

                        $tots += (doubleval($item->Quantity) * doubleval($item->Price));

                        array_push($note->Items, $item);
                    }
                }
                $note->Total = $tots;
                $note->User = $user;
                $note->Reference = $this->Id;
                $note->Source = "laundry";
                $note->Hasquantity = true;
                $note->Supplier = $this->Supplier;

                $note->Save();

                $this->Creditnote = $note->Id;
                $this->Save();
            }
            return $note;
        }
	}
