<?php
	/* Generated by Wixnit Class Builder 
	// Jul, 06/2019
	// Building class for City
	*/

	class City
	{
		public $Id = "";
		public $Created = 0;
		public $Country = "";
		public $State = "";
		public $Name = "";
		public $Longitude = 0;
		public $Latitude = 0;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM city WHERE cityid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['cityid'];
					$this->Created = new WixDate($row['created']);
					$this->Country = $row['country'];
					$this->State = $row['state'];
					$this->Name = ucwords($row['name']);
					$this->Longitude = $row['lng'];
					$this->Latitude = $row['lat'];
				}
                $db->close();
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$country = addslashes($this->Country);
			$state = addslashes($this->State);
			$name = addslashes($this->Name);
			$long = floatval($this->Longitude);
			$lat = floatval($this->Latitude);

			if($res = $db->query("SELECT cityid FROM city WHERE cityid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE city SET country='$country',state='$state',name='$name',lng='$long',lat='$lat' WHERE cityid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT cityid FROM city WHERE cityid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO city(cityid,created,country,state,name,lng,lat) VALUES ('$id','$created','$country','$state','$name','$long','$lat')");
			}
            $db->close();
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM city WHERE cityid='$id'");
            $db->close();
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM city WHERE country LIKE '%$term%' OR state LIKE '%$term%' OR name LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
                $ret[$i] = new City();
                $ret[$i]->Id = $row['cityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->Name = ucwords($row['name']);
                $ret[$i]->Longitude = $row['lng'];
                $ret[$i]->Latitude = $row['lat'];
                $i++;
			}
            $db->close();
			return $ret;
		}

		public static function Filter($term='', $field='cityid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM city WHERE ".$field." ='$term'");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new City();
                $ret[$i]->Id = $row['cityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->Name = ucwords($row['name']);
                $ret[$i]->Longitude = $row['lng'];
                $ret[$i]->Latitude = $row['lat'];
                $i++;
            }
            $db->close();
            return $ret;
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT * FROM city ORDER BY ".$field." ".$order."");
            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new City();
                $ret[$i]->Id = $row['cityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->Name = ucwords($row['name']);
                $ret[$i]->Longitude = $row['lng'];
                $ret[$i]->Latitude = $row['lat'];
                $i++;
            }
            $db->close();
            return $ret;
		}

		public static function GroupInitialize($array=null, $orderBy='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$query = "";

			if(is_array($array) === true)
			{
				if(count($array) == 0)
				{
					return $ret;
				}
				else
				{
					for($i = 0; $i < count($array); $i++)
					{
						if($query == "")
						{
							$query = " WHERE Cityid='".$array[$i]."'";
						}
						else
						{
							$query .= " OR Cityid ='".$array[$i]."'";
						}
					}
				}
			}
			$i = 0;
			$res = $db->query("SELECT * FROM city".$query." ORDER BY ".$orderBy." ".$order);
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new City();
				$ret[$i]->Id = $row['cityid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Country = $row['country'];
				$ret[$i]->State = $row['state'];
				$ret[$i]->Name = ucwords($row['name']);
				$ret[$i]->Longitude = $row['lng'];
				$ret[$i]->Latitude = $row['lat'];
				$i++;
			}
            $db->close();
			return $ret;
		}

        public static function ByCountry($country)
        {
            $code = is_a($country, "Country") ? strtolower($country->Code) : strtolower($country);
            $ret = array();
            $i = 0;

            $db = DB::GetDB();
            $res = $db->query("SELECT * FROM city WHERE country='$code' ORDER by name ASC");

            while(($row = $res->fetch_assoc()) != null)
            {
                $ret[$i] = new City();
                $ret[$i]->Id = $row['cityid'];
                $ret[$i]->Created = new WixDate($row['created']);
                $ret[$i]->Country = $row['country'];
                $ret[$i]->State = $row['state'];
                $ret[$i]->Name = ucwords($row['name']);
                $ret[$i]->Longitude = $row['lng'];
                $ret[$i]->Latitude = $row['lat'];
                $i++;
            }
            $db->close();
            return $ret;
        }
	}
