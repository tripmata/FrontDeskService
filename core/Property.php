<?php
	/* Generated by Wixnit Class Builder 
	// Apr, 21/2020
	// Building class for Property
	*/

	class Property
	{
		public $Id = "";
		public $Created = 0;
		public $Type = "";
		public $Name = "";
		public $Statename = "";
		public $Cityname = "";
		public $Phone1 = "";
		public $Phone2 = "";
		public $Email1 = "";
		public $Email2 = "";
		public $Banner = "";
		public $Formtype = "";
		public $Description = "";
		public $Address = "";
		public $State = "";
		public $City = "";
		public $Facilities = array();
		public $Gallery = array();
		public $Checkinm = 0;
		public $Checkinh = 0;
		public $Checkoutmin = 0;
		public $Checkouth = 0;
		public $Canceldays = 0;
		public $Cancelhours = 0;
		public $Rating = 0;
		public $Vies = 0;
		public $Cashonly = false;
		public $Cancellation = false;
		public $Damagedeposit = false;
		public $Earlycheckout = false;
		public $Partialpayment = false;
		public $Partialpaypercentage = false;
		public $Status = false;
		public $Approved = false;
		public $Suspended = false;
		public $Recomended = false;
		public $Damagedepositamount = 0;
		public $Partialpayamount = 0;
		public $Owner = "";
		public $Hms = false;
		public $Rules = [];
		public $Tandc = "";
		public $Childpolicy = "";

		public $Databasename = "";
		public $DatabasePassword = "";
		public $DatabaseUser = "";

		// non-db-members
		public $Price = 0;
		public $Meta = "";
		public $Star = 1;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM property WHERE propertyid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['propertyid'];
					$this->Created = new WixDate($row['created']);
					$this->Type = $row['type'];
					$this->Name = $row['name'];
					$this->Statename = $row['statename'];
					$this->Cityname = $row['cityname'];
					$this->Phone1 = $row['phone1'];
					$this->Phone2 = $row['phone2'];
					$this->Email1 = $row['email1'];
					$this->Email2 = $row['email2'];
					$this->Banner = $row['banner'];
					$this->Formtype = $row['formtype'];
					$this->Description = $row['description'];
					$this->Address = $row['address'];
					$this->State = new States($row['state']);
					$this->City = new City($row['city']);
					$this->Facilities = json_decode($row['facilities']);
					$this->Gallery = json_decode($row['gallery']);
					$this->Checkinm = $row['checkinm'];
					$this->Checkinh = $row['checkinh'];
					$this->Checkoutmin = $row['checkoutmin'];
					$this->Checkouth = $row['checkouth'];
					$this->Canceldays = $row['canceldays'];
					$this->Cancelhours = $row['cancelhours'];
					$this->Rating = $row['rating'];
					$this->Vies = $row['vies'];
					$this->Cashonly = Convert::ToBool($row['cashonly']);
					$this->Cancellation = Convert::ToBool($row['cancellation']);
					$this->Damagedeposit = Convert::ToBool($row['damagedeposit']);
					$this->Earlycheckout = Convert::ToBool($row['earlycheckout']);
					$this->Partialpayment = Convert::ToBool($row['partialpayment']);
					$this->Partialpaypercentage = Convert::ToBool($row['partialpaypercentage']);
					$this->Status = Convert::ToBool($row['status']);
					$this->Approved = Convert::ToBool($row['approved']);
					$this->Suspended = Convert::ToBool($row['suspended']);
					$this->Recomended = Convert::ToBool($row['recomended']);
					$this->Damagedepositamount = $row['damagedepositamount'];
					$this->Partialpayamount = $row['partialpayamount'];
					$this->Owner = new Customer($GLOBALS['subscriber']);
					$this->Owner->Initialize($row['owner']);
					$this->Hms = Convert::ToBool($row['hms']);
					$this->Rules = json_decode($row['rules']);
					$this->Tandc = $row['tandc'];
					$this->Childpolicy = $row['childpolicy'];
					$this->Databasename = $row['databasename'];
					$this->DatabasePassword = $row['databasepassword'];
					$this->DatabaseUser = $row['databaseuser'];
					$this->Meta = $row['meta'];
					$this->Star = $row['star'];
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$type = addslashes($this->Type);
			$name = addslashes($this->Name);
			$statename = addslashes($this->Statename);
			$cityname = addslashes($this->Cityname);
			$phone1 = addslashes($this->Phone1);
			$phone2 = addslashes($this->Phone2);
			$email1 = addslashes($this->Email1);
			$email2 = addslashes($this->Email2);
			$banner = addslashes($this->Banner);
			$formtype = addslashes($this->Formtype);
			$description = addslashes($this->Description);
			$address = addslashes($this->Address);
			$state = addslashes(is_a($this->State, "State") ? $this->State->Id : $this->State);
			$city = addslashes(is_a($this->City, "City") ? $this->City->Id : $this->City);
			$facilities = addslashes(json_encode($this->Facilities));
			$gallery = addslashes(json_encode($this->Gallery));
			$checkinm = Convert::ToInt($this->Checkinm);
			$checkinh = Convert::ToInt($this->Checkinh);
			$checkoutmin = Convert::ToInt($this->Checkoutmin);
			$checkouth = Convert::ToInt($this->Checkouth);
			$canceldays = Convert::ToInt($this->Canceldays);
			$cancelhours = Convert::ToInt($this->Cancelhours);
			$rating = Convert::ToInt($this->Rating);
			$vies = Convert::ToInt($this->Vies);
			$cashonly = Convert::ToInt($this->Cashonly);
			$cancellation = Convert::ToInt($this->Cancellation);
			$damagedeposit = Convert::ToInt($this->Damagedeposit);
			$earlycheckout = Convert::ToInt($this->Earlycheckout);
			$partialpayment = Convert::ToInt($this->Partialpayment);
			$partialpaypercentage = Convert::ToInt($this->Partialpaypercentage);
			$status = Convert::ToInt($this->Status);
			$approved = Convert::ToInt($this->Approved);
			$suspended = Convert::ToInt($this->Suspended);
			$recomended = Convert::ToInt($this->Recomended);
			$damagedepositamount = floatval($this->Damagedepositamount);
			$partialpayamount = floatval($this->Partialpayamount);
			$owner = addslashes(is_a($this->Owner, "Customer") ? $this->Owner->Id : $this->Owner);
			$hms = Convert::ToInt($this->Hms);
			$tandc = addslashes($this->Tandc);
			$childpolicy = addslashes($this->Childpolicy);

			$databasename = addslashes($this->Databasename);
			$databasepassword = addslashes($this->DatabasePassword);
			$databaseuser = addslashes($this->DatabaseUser);

			$meta = addslashes($this->Meta);

			$star = Convert::ToInt($this->Star);

			$r = [];
			for($i = 0; $i < count($this->Rules); $i++)
            {
                if($this->Rules[$i] != "")
                {
                    array_push($r, $this->Rules[$i]);
                }
            }
			$rules = json_encode($r);


			if($res = $db->query("SELECT propertyid FROM property WHERE propertyid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE property SET type='$type',name='$name',statename='$statename',cityname='$cityname',phone1='$phone1',phone2='$phone2',email1='$email1',email2='$email2',banner='$banner',formtype='$formtype',description='$description',address='$address',state='$state',city='$city',facilities='$facilities',gallery='$gallery',checkinm='$checkinm',checkinh='$checkinh',checkoutmin='$checkoutmin',checkouth='$checkouth',canceldays='$canceldays',cancelhours='$cancelhours',rating='$rating',vies='$vies',cashonly='$cashonly',cancellation='$cancellation',damagedeposit='$damagedeposit',earlycheckout='$earlycheckout',partialpayment='$partialpayment',partialpaypercentage='$partialpaypercentage',status='$status',approved='$approved',suspended='$suspended',recomended='$recomended',damagedepositamount='$damagedepositamount',partialpayamount='$partialpayamount',owner='$owner',hms='$hms',rules='$rules',tandc='$tandc',childpolicy='$childpolicy',databasename='$databasename',databasepassword='$databasepassword',databaseuser='$databaseuser',meta='$meta',star='$star' WHERE propertyid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT propertyid FROM property WHERE propertyid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO property(propertyid,created,type,name,statename,cityname,phone1,phone2,email1,email2,banner,formtype,description,address,state,city,facilities,gallery,checkinm,checkinh,checkoutmin,checkouth,canceldays,cancelhours,rating,vies,cashonly,cancellation,damagedeposit,earlycheckout,partialpayment,partialpaypercentage,status,approved,suspended,recomended,damagedepositamount,partialpayamount,owner,hms,rules,tandc,childpolicy,databasename,databasepassword,databaseuser,meta,star) VALUES ('$id','$created','$type','$name','$statename','$cityname','$phone1','$phone2','$email1','$email2','$banner','$formtype','$description','$address','$state','$city','$facilities','$gallery','$checkinm','$checkinh','$checkoutmin','$checkouth','$canceldays','$cancelhours','$rating','$vies','$cashonly','$cancellation','$damagedeposit','$earlycheckout','$partialpayment','$partialpaypercentage','$status','$approved','$suspended','$recomended','$damagedepositamount','$partialpayamount','$owner','$hms','$rules','$tandc','$childpolicy','$databasename','$databasepassword','$databaseuser','$meta','$star')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM property WHERE propertyid='$id'");

			//Deleting Associated Objects
			/*n			$this->State->Delete();

			$this->City->Delete();

			$this->Owner->Delete();
			*/
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM property WHERE `type` LIKE '%$term%' OR `name` LIKE '%$term%' OR statename LIKE '%$term%' OR cityname LIKE '%$term%' OR phone1 LIKE '%$term%' OR phone2 LIKE '%$term%' OR email1 LIKE '%$term%' OR email2 LIKE '%$term%' OR banner LIKE '%$term%' OR formtype LIKE '%$term%' OR `description` LIKE '%$term%' OR `address` LIKE '%$term%' OR `state` LIKE '%$term%' OR city LIKE '%$term%' OR facilities LIKE '%$term%' OR gallery LIKE '%$term%' OR checkinm LIKE '%$term%' OR checkinh LIKE '%$term%' OR checkoutmin LIKE '%$term%' OR checkouth LIKE '%$term%' OR canceldays LIKE '%$term%' OR cancelhours LIKE '%$term%' OR rating LIKE '%$term%' OR vies LIKE '%$term%' OR cashonly LIKE '%$term%' OR cancellation LIKE '%$term%' OR damagedeposit LIKE '%$term%' OR earlycheckout LIKE '%$term%' OR partialpayment LIKE '%$term%' OR partialpaypercentage LIKE '%$term%' OR `status` LIKE '%$term%' OR approved LIKE '%$term%' OR suspended LIKE '%$term%' OR recomended LIKE '%$term%' OR damagedepositamount LIKE '%$term%' OR partialpayamount LIKE '%$term%' OR `owner` LIKE '%$term%' OR hms LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new Property();
                $ret[$i]->Id = $row['propertyid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Statename = $row['statename'];
                $ret[$i]->Cityname = $row['cityname'];
                $ret[$i]->Phone1 = $row['phone1'];
                $ret[$i]->Phone2 = $row['phone2'];
                $ret[$i]->Email1 = $row['email1'];
                $ret[$i]->Email2 = $row['email2'];
                $ret[$i]->Banner = $row['banner'];
                $ret[$i]->Formtype = $row['formtype'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Address = $row['address'];
                $ret[$i]->State = new States($row['state']);
                $ret[$i]->City = new City($row['city']);
                $ret[$i]->Facilities = json_decode($row['facilities']);
                $ret[$i]->Gallery = json_decode($row['gallery']);
                $ret[$i]->Checkinm = $row['checkinm'];
                $ret[$i]->Checkinh = $row['checkinh'];
                $ret[$i]->Checkoutmin = $row['checkoutmin'];
                $ret[$i]->Checkouth = $row['checkouth'];
                $ret[$i]->Canceldays = $row['canceldays'];
                $ret[$i]->Cancelhours = $row['cancelhours'];
                $ret[$i]->Rating = $row['rating'];
                $ret[$i]->Vies = $row['vies'];
                $ret[$i]->Cashonly = Convert::ToBool($row['cashonly']);
                $ret[$i]->Cancellation = Convert::ToBool($row['cancellation']);
                $ret[$i]->Damagedeposit = Convert::ToBool($row['damagedeposit']);
                $ret[$i]->Earlycheckout = Convert::ToBool($row['earlycheckout']);
                $ret[$i]->Partialpayment = Convert::ToBool($row['partialpayment']);
                $ret[$i]->Partialpaypercentage = Convert::ToBool($row['partialpaypercentage']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Approved = Convert::ToBool($row['approved']);
                $ret[$i]->Suspended = Convert::ToBool($row['suspended']);
                $ret[$i]->Recomended = Convert::ToBool($row['recomended']);
                $ret[$i]->Damagedepositamount = $row['damagedepositamount'];
                $ret[$i]->Partialpayamount = $row['partialpayamount'];
                $ret[$i]->Owner = new Customer($GLOBALS['subscriber']);
                $ret[$i]->Owner->Initialize($row['owner']);
                $ret[$i]->Hms = Convert::ToBool($row['hms']);
                $ret[$i]->Rules = json_decode($row['rules']);
                $ret[$i]->Tandc = $row['tandc'];
                $ret[$i]->Childpolicy = $row['childpolicy'];
                $ret[$i]->Databasename = $row['databasename'];
                $ret[$i]->DatabasePassword = $row['databasepassword'];
                $ret[$i]->DatabaseUser = $row['databaseuser'];
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Star = $row['star'];
				$i++;
			}
			return $ret;
		}

		public static function Filter($term='', $field='propertyid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT propertyid FROM property WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Property($row['propertyid']);
				$i++;
			}
			return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT propertyid FROM property ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Property($row['propertyid']);
				$i++;
			}
			return $ret;
		}

		public static function All()
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM property");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Property();
				$ret[$i]->Id = $row['propertyid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Type = $row['type'];
				$ret[$i]->Name = $row['name'];
				$ret[$i]->Statename = $row['statename'];
				$ret[$i]->Cityname = $row['cityname'];
				$ret[$i]->Phone1 = $row['phone1'];
				$ret[$i]->Phone2 = $row['phone2'];
				$ret[$i]->Email1 = $row['email1'];
				$ret[$i]->Email2 = $row['email2'];
				$ret[$i]->Banner = $row['banner'];
				$ret[$i]->Formtype = $row['formtype'];
				$ret[$i]->Description = $row['description'];
				$ret[$i]->Address = $row['address'];
				$ret[$i]->State = new State($row['state']);
				$ret[$i]->City = new City($row['city']);
				$ret[$i]->Facilities = json_decode($row['facilities']);
				$ret[$i]->Gallery = json_decode($row['gallery']);
				$ret[$i]->Checkinm = $row['checkinm'];
				$ret[$i]->Checkinh = $row['checkinh'];
				$ret[$i]->Checkoutmin = $row['checkoutmin'];
				$ret[$i]->Checkouth = $row['checkouth'];
				$ret[$i]->Canceldays = $row['canceldays'];
				$ret[$i]->Cancelhours = $row['cancelhours'];
				$ret[$i]->Rating = $row['rating'];
				$ret[$i]->Vies = $row['vies'];
				$ret[$i]->Cashonly = Convert::ToBool($row['cashonly']);
				$ret[$i]->Cancellation = Convert::ToBool($row['cancellation']);
				$ret[$i]->Damagedeposit = Convert::ToBool($row['damagedeposit']);
				$ret[$i]->Earlycheckout = Convert::ToBool($row['earlycheckout']);
				$ret[$i]->Partialpayment = Convert::ToBool($row['partialpayment']);
				$ret[$i]->Partialpaypercentage = Convert::ToBool($row['partialpaypercentage']);
				$ret[$i]->Status = Convert::ToBool($row['status']);
				$ret[$i]->Approved = Convert::ToBool($row['approved']);
				$ret[$i]->Suspended = Convert::ToBool($row['suspended']);
				$ret[$i]->Recomended = Convert::ToBool($row['recomended']);
				$ret[$i]->Damagedepositamount = $row['damagedepositamount'];
				$ret[$i]->Partialpayamount = $row['partialpayamount'];
				$ret[$i]->Owner = new Customer($row['owner']);
				$ret[$i]->Hms = Convert::ToBool($row['hms']);
				$ret[$i]->Rules = json_decode($row['rules']);
				$ret[$i]->Tandc = $row['tandc'];
				$ret[$i]->Childpolicy = $row['childpolicy'];
                $ret[$i]->Databasename = $row['databasename'];
                $ret[$i]->DatabasePassword = $row['databasepassword'];
                $ret[$i]->DatabaseUser = $row['databaseuser'];
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Star = $row['star'];
				$i++;
			}
			return $ret;
		}

        public static function ByCustomer(Customer $customer)
        {
            $db = DB::GetDB();
            $ret = array();
            $i = 0;

            $id = is_a($customer, "Customer") ? $customer->Id : $customer;

            $res = $db->query("SELECT * FROM property WHERE `owner`='$id'");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Property();
                $ret[$i]->Id = $row['propertyid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Type = $row['type'];
                $ret[$i]->Name = $row['name'];
                $ret[$i]->Statename = $row['statename'];
                $ret[$i]->Cityname = $row['cityname'];
                $ret[$i]->Phone1 = $row['phone1'];
                $ret[$i]->Phone2 = $row['phone2'];
                $ret[$i]->Email1 = $row['email1'];
                $ret[$i]->Email2 = $row['email2'];
                $ret[$i]->Banner = $row['banner'];
                $ret[$i]->Formtype = $row['formtype'];
                $ret[$i]->Description = $row['description'];
                $ret[$i]->Address = $row['address'];
                $ret[$i]->State = new States($row['state']);
                $ret[$i]->City = new City($row['city']);
                $ret[$i]->Facilities = json_decode($row['facilities']);
                $ret[$i]->Gallery = json_decode($row['gallery']);
                $ret[$i]->Checkinm = $row['checkinm'];
                $ret[$i]->Checkinh = $row['checkinh'];
                $ret[$i]->Checkoutmin = $row['checkoutmin'];
                $ret[$i]->Checkouth = $row['checkouth'];
                $ret[$i]->Canceldays = $row['canceldays'];
                $ret[$i]->Cancelhours = $row['cancelhours'];
                $ret[$i]->Rating = $row['rating'];
                $ret[$i]->Vies = $row['vies'];
                $ret[$i]->Cashonly = Convert::ToBool($row['cashonly']);
                $ret[$i]->Cancellation = Convert::ToBool($row['cancellation']);
                $ret[$i]->Damagedeposit = Convert::ToBool($row['damagedeposit']);
                $ret[$i]->Earlycheckout = Convert::ToBool($row['earlycheckout']);
                $ret[$i]->Partialpayment = Convert::ToBool($row['partialpayment']);
                $ret[$i]->Partialpaypercentage = Convert::ToBool($row['partialpaypercentage']);
                $ret[$i]->Status = Convert::ToBool($row['status']);
                $ret[$i]->Approved = Convert::ToBool($row['approved']);
                $ret[$i]->Suspended = Convert::ToBool($row['suspended']);
                $ret[$i]->Recomended = Convert::ToBool($row['recomended']);
                $ret[$i]->Damagedepositamount = $row['damagedepositamount'];
                $ret[$i]->Partialpayamount = $row['partialpayamount'];
                $ret[$i]->Owner = new Customer($GLOBALS['subscriber']);
                $ret[$i]->Owner->Initialize($row['owner']);
                $ret[$i]->Hms = Convert::ToBool($row['hms']);
                $ret[$i]->Rules = json_decode($row['rules']);
                $ret[$i]->Tandc = $row['tandc'];
                $ret[$i]->Childpolicy = $row['childpolicy'];
                $ret[$i]->Databasename = $row['databasename'];
                $ret[$i]->DatabasePassword = $row['databasepassword'];
                $ret[$i]->DatabaseUser = $row['databaseuser'];
                $ret[$i]->Meta = $row['meta'];
                $ret[$i]->Star = $row['star'];
                $i++;
            }
            return $ret;
        }

        public function GetRooms()
        {
            $subscriber = new Subscriber($this->Databasename, $this->DatabaseUser, $this->DatabasePassword);
            return Room::Order($subscriber, 'price', 'DESC');
        }

        public function GetRoomCategories()
        {
            $subscriber = new Subscriber($this->Databasename, $this->DatabaseUser, $this->DatabasePassword);
            return Roomcategory::Order($subscriber, 'price', 'ASC');
        }

        public static function ByMeta($meta)
        {
            $db = DB::GetDB();

            $ret = new Property();

            $res = $db->query("SELECT * FROM property WHERE meta='$meta'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $ret->Id = $row['propertyid'];
                $ret->Created = new WixDate($row['created']);
                $ret->Type = $row['type'];
                $ret->Name = $row['name'];
                $ret->Statename = $row['statename'];
                $ret->Cityname = $row['cityname'];
                $ret->Phone1 = $row['phone1'];
                $ret->Phone2 = $row['phone2'];
                $ret->Email1 = $row['email1'];
                $ret->Email2 = $row['email2'];
                $ret->Banner = $row['banner'];
                $ret->Formtype = $row['formtype'];
                $ret->Description = $row['description'];
                $ret->Address = $row['address'];
                $ret->State = new States($row['state']);
                $ret->City = new City($row['city']);
                $ret->Facilities = json_decode($row['facilities']);
                $ret->Gallery = json_decode($row['gallery']);
                $ret->Checkinm = $row['checkinm'];
                $ret->Checkinh = $row['checkinh'];
                $ret->Checkoutmin = $row['checkoutmin'];
                $ret->Checkouth = $row['checkouth'];
                $ret->Canceldays = $row['canceldays'];
                $ret->Cancelhours = $row['cancelhours'];
                $ret->Rating = $row['rating'];
                $ret->Vies = $row['vies'];
                $ret->Cashonly = Convert::ToBool($row['cashonly']);
                $ret->Cancellation = Convert::ToBool($row['cancellation']);
                $ret->Damagedeposit = Convert::ToBool($row['damagedeposit']);
                $ret->Earlycheckout = Convert::ToBool($row['earlycheckout']);
                $ret->Partialpayment = Convert::ToBool($row['partialpayment']);
                $ret->Partialpaypercentage = Convert::ToBool($row['partialpaypercentage']);
                $ret->Status = Convert::ToBool($row['status']);
                $ret->Approved = Convert::ToBool($row['approved']);
                $ret->Suspended = Convert::ToBool($row['suspended']);
                $ret->Recomended = Convert::ToBool($row['recomended']);
                $ret->Damagedepositamount = $row['damagedepositamount'];
                $ret->Partialpayamount = $row['partialpayamount'];
                $ret->Owner = new Customer($GLOBALS['subscriber']);
                $ret->Owner->Initialize($row['owner']);
                $ret->Hms = Convert::ToBool($row['hms']);
                $ret->Rules = json_decode($row['rules']);
                $ret->Tandc = $row['tandc'];
                $ret->Childpolicy = $row['childpolicy'];
                $ret->Databasename = $row['databasename'];
                $ret->DatabasePassword = $row['databasepassword'];
                $ret->DatabaseUser = $row['databaseuser'];
                $ret->Meta = $row['meta'];
                $ret->Star = $row['star'];
            }
            return $ret;
        }

        public static function SearchActiveListing($term='')
        {
            $db = DB::GetDB();
            $ret = array();
            $i = 0;

            $res = $db->query("SELECT propertyid FROM property WHERE (approved=1) && (`status`=1) && (`type` LIKE '%$term%' OR `name` LIKE '%$term%' OR statename LIKE '%$term%' OR cityname LIKE '%$term%' OR phone1 LIKE '%$term%' OR phone2 LIKE '%$term%' OR email1 LIKE '%$term%' OR email2 LIKE '%$term%' OR `description` LIKE '%$term%' OR `address` LIKE '%$term%' OR `state` LIKE '%$term%' OR city LIKE '%$term%' OR facilities LIKE '%$term%')");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new Property($row['propertyid']);
                $i++;
            }
            return $ret;
		}

		public static function countActiveListing()
        {
            $db = DB::GetDB();
            $ret = 0;
			$ret = $db->query("SELECT propertyid FROM property WHERE (approved=1) && (`status`=1)")->num_rows;
			$db->close();
            return $ret;
		}
		
		public function CalcPrice()
		{
			$rooms = $this->GetRoomCategories();

			if(count($rooms) > 0)
			{
				$this->Price = $rooms[0]->Price;
			}
		}
	}
