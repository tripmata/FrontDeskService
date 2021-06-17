<?php
	/* Generated by Wixnit Class Builder 
	// Jan, 15/2020
	// Building class for Review
	*/

	class Review
	{
		public $Id = "";
		public $Created = 0;
		public $Title = "";
		public $Body = "";
		public $Items = array();
		public $Send = "";
		public $Ignored = "";
		public $Responded = "";

		public $Responsecount = 0;
		public $Sendcount = 0;

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
            $this->subscriber = $subscriber;
		}

		public function Initialize($arg=null)
        {
            if ($arg != null)
            {
                $db = $this->subscriber->GetDB();

                $res = $db->query("SELECT * FROM review WHERE reviewid='$arg'");

                if ($res->num_rows > 0)
                {
                    $row = $res->fetch_assoc();

                    $this->Id = $row['reviewid'];
                    $this->Created = new WixDate($row['created']);
                    $this->Title = $row['title'];
                    $this->Body = $row['body'];
                    $this->Items = json_decode($row['items']);
                    $this->Send = $row['send'];
                    $this->Ignored = $row['ignored'];
                    $this->Responded = $row['responded'];

                    $this->Responsecount = Reviewsession::Responsecount($this->subscriber, $this->Id);
                    $this->Sendcount = Reviewsession::Sentcount($this->subscriber, $this->Id);
                }
            }
        }

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$created = time();
			$title = addslashes($this->Title);
			$body = addslashes($this->Body);
			$items = addslashes(json_encode(is_a($this->Items, "reviewitem") ? $this->Items->GetArray() : $this->Items));
			$send = addslashes($this->Send);
			$ignored = addslashes($this->Ignored);
			$responded = addslashes($this->Responded);

			if($res = $db->query("SELECT reviewid FROM review WHERE reviewid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE review SET title='$title',body='$body',items='$items',send='$send',ignored='$ignored',responded='$responded' WHERE reviewid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT reviewid FROM review WHERE reviewid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO review(reviewid,created,title,body,items,send,ignored,responded) VALUES ('$id','$created','$title','$body','$items','$send','$ignored','$responded')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM review WHERE reviewid='$id'");

			//Deleting Associated Objects

			$items = $this->GetItems();
			for($i = 0; $i < count($items); $i++)
            {
                $items[$i]->Delete();
            }
			Reviewsession::Deletesessions($this->subscriber, $this);
		}

		public static function Search(Subscriber $subscriber, $term='')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM review WHERE title LIKE '%$term%' OR body LIKE '%$term%' OR items LIKE '%$term%' OR send LIKE '%$term%' OR ignored LIKE '%$term%' OR responded LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Review($subscriber);
                $ret[$i]->Id = $row['reviewid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Send = $row['send'];
                $ret[$i]->Ignored = $row['ignored'];
                $ret[$i]->Responded = $row['responded'];
                $ret[$i]->Responsecount = Reviewsession::Responsecount($subscriber, $row['reviewid']);
                $ret[$i]->Sendcount = Reviewsession::Sentcount($subscriber, $row['reviewid']);
				$i++;
			}
			return $ret;
		}

		public static function Filter(Subscriber $subscriber, $term='', $field='reviewid')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM review WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Review($subscriber);
                $ret[$i]->Id = $row['reviewid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Send = $row['send'];
                $ret[$i]->Ignored = $row['ignored'];
                $ret[$i]->Responded = $row['responded'];
                $ret[$i]->Responsecount = Reviewsession::Responsecount($subscriber, $row['reviewid']);
                $ret[$i]->Sendcount = Reviewsession::Sentcount($subscriber, $row['reviewid']);
				$i++;
			}
			return $ret;
		}

		public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM review ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Review($subscriber);
                $ret[$i]->Id = $row['reviewid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Title = $row['title'];
                $ret[$i]->Body = $row['body'];
                $ret[$i]->Items = json_decode($row['items']);
                $ret[$i]->Send = $row['send'];
                $ret[$i]->Ignored = $row['ignored'];
                $ret[$i]->Responded = $row['responded'];
                $ret[$i]->Responsecount = Reviewsession::Responsecount($subscriber, $row['reviewid']);
                $ret[$i]->Sendcount = Reviewsession::Sentcount($subscriber, $row['reviewid']);
				$i++;
			}
			return $ret;
		}

		public static function All(Subscriber $subscriber)
		{
			$db = $subscriber->GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM review");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Review($subscriber);
				$ret[$i]->Id = $row['reviewid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Title = $row['title'];
				$ret[$i]->Body = $row['body'];
				$ret[$i]->Items = json_decode($row['items']);
				$ret[$i]->Send = $row['send'];
				$ret[$i]->Ignored = $row['ignored'];
				$ret[$i]->Responded = $row['responded'];
                $ret[$i]->Responsecount = Reviewsession::Responsecount($subscriber, $row['reviewid']);
                $ret[$i]->Sendcount = Reviewsession::Sentcount($subscriber, $row['reviewid']);
				$i++;
			}
			return $ret;
		}

		public function GetItems()
		{
			$db = $this->subscriber->GetDB();
			$ret = array();
			$i = 0;

			$id = $this->Id;

			$res = $db->query("SELECT * FROM reviewitem WHERE reviewid='$id'");

			while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Reviewitem($this->subscriber);
                $ret[$i]->Id = $row['reviewitemid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Question = $row['question'];
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Reviewid = $row['reviewid'];
                $ret[$i]->Maxrating = $row['maxrating'];
                $ret[$i]->Sort = $row['sort'];
                $ret[$i]->Comment = $row['comment'];
                $ret[$i]->Options = json_decode($row['options']);
                $ret[$i]->InitResponse();
                $i++;
            }

            return $ret;
		}

		public function SetItems($items)
		{

			//Presuming Object has a Save Method
			/*
			if(is_a($items, "reviewitem"))
			{
				$items->Save();
			}
			*/
			$this->Items = is_a($items, "reviewitem") ? $items->Id : $items;
		}


		public function Clearitems()
        {

        }

        public function Additems($reviewitems)
        {
            if($this->Id == "")
            {
                $this->Save();
            }
            for($i = 0; $i < count($reviewitems); $i++)
            {
                $reviewitems[$i]->Reviewid = $this->Id;
                $reviewitems[$i]->Save();
            }
        }
	}