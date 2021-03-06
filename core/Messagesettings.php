<?php
	/* Generated by Wixnit Class Builder 
	// Feb, 19/2020
	// Building class for Messagesettings
	*/

	class Messagesettings
	{
		public $Lowunitphone = "";
		public $Tagprocessing = "";
		public $Ononiruapikey = "";
		public $Lowunitpoint = 0;

		private $subscriber = null;

		function __construct(Subscriber $subscriber)
		{
		    $this->subscriber = $subscriber;

			$db = $this->subscriber->GetDB();

			$res = $db->query("SELECT * FROM messagesettings");

			if($res->num_rows > 0)
			{
				$row = $res->fetch_assoc();
			
				$this->Lowunitphone = $row['lowunitphone'];
				$this->Tagprocessing = $row['tagprocessing'];
				$this->Ononiruapikey = $row['ononiruapikey'];
				$this->Lowunitpoint = $row['lowunitpoint'];
			}
			else
			{
				$this->Save();
			}
		}

		public function Save()
		{
			$db = $this->subscriber->GetDB();

			$lowunitphone = addslashes($this->Lowunitphone);
			$tagprocessing = addslashes($this->Tagprocessing);
			$ononiruapikey = addslashes($this->Ononiruapikey);
			$lowunitpoint = Convert::ToInt($this->Lowunitpoint);

			if($res = $db->query("SELECT * FROM messagesettings")->num_rows > 0)
			{
				$db->query("UPDATE messagesettings SET lowunitphone='$lowunitphone',tagprocessing='$tagprocessing',ononiruapikey='$ononiruapikey',lowunitpoint='$lowunitpoint'");
			}
			else
			{
				$db->query("INSERT INTO messagesettings(lowunitphone,tagprocessing,ononiruapikey,lowunitpoint) VALUES ('$lowunitphone','$tagprocessing','$ononiruapikey','$lowunitpoint')");
			}
		}

		public function Delete()
		{
			$db = $this->subscriber->GetDB();

			$db->query("DELETE FROM messagesettings");
		}
	}
