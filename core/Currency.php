<?php
	/* Generated by Wixnit Class Builder 
	// Jul, 06/2019
	// Building class for Currency
	*/

	class Currency
	{
		public $Id = "";
		public $Created = 0;
		public $Name = "";
		public $Country = "";
		public $Symbol = "";
		public $Country_code = "";
		public $Code = "";
		public $Value = 0;

		function __construct($arg=null)
		{
			if($arg != null)
			{
				$db = DB::GetDB();

				$res = $db->query("SELECT * FROM currency WHERE currencyid='$arg'");

				if($res->num_rows > 0)
				{
					$row = $res->fetch_assoc();
				
					$this->Id = $row['currencyid'];
					$this->Created = new WixDate($row['created']);
					$this->Name = ucwords($row['name']);
					$this->Country = ucwords($row['country']);
					$this->Symbol = $row['symbol'];
					$this->Country_code = $row['country_code'];
					$this->Value = $row['value'];
					$this->Code = strtoupper($row['code']);
				}
			}
		}

		public function Save()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$created = time();
			$name = addslashes($this->Name);
			$country = addslashes(strtolower($this->Country));
			$symbol = addslashes($this->Symbol);
			$country_code = addslashes(strtolower($this->Country_code));
			$value = floatval($this->Value);

			if($res = $db->query("SELECT currencyid FROM currency WHERE currencyid='$id'")->num_rows > 0)
			{
				$db->query("UPDATE currency SET name='$name',country='$country',symbol='$symbol',country_code='$country_code',value='$value' WHERE currencyid = '$id'");
			}
			else
			{
				redo: ;
				$id = Random::GenerateId(16);
				if($db->query("SELECT currencyid FROM currency WHERE currencyid='$id'")->num_rows > 0)
				{
					goto redo;
				}
				$this->Id = $id;
				$db->query("INSERT INTO currency(currencyid,created,name,country,symbol,country_code,value) VALUES ('$id','$created','$name','$country','$symbol','$country_code','$value')");
			}
		}

		public function Delete()
		{
			$db = DB::GetDB();

			$id = $this->Id;
			$db->query("DELETE FROM currency WHERE currencyid='$id'");
		}

		public static function Search($term='')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT currencyid FROM currency WHERE name LIKE '%$term%' OR country LIKE '%$term%' OR symbol LIKE '%$term%' OR country_code LIKE '%$term%' OR value LIKE '%$term%'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['currencyid'];
				$i++;
			}
			return Currency::GroupInitialize($ret);
		}

		public static function Filter($term='', $field='currencyid')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT currencyid FROM currency WHERE ".$field." ='$term'");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['currencyid'];
				$i++;
			}
			return Currency::GroupInitialize($ret);
		}

		public static function Order($field='id', $order='DESC')
		{
			$db = DB::GetDB();
			$ret = array();
			$i = 0;

			$res = $db->query("SELECT currencyid FROM currency ORDER BY ".$field." ".$order."");
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = $row['currencyid'];
				$i++;
			}
			return Currency::GroupInitialize($ret);
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
							$query = " WHERE Currencyid='".$array[$i]."'";
						}
						else
						{
							$query .= " OR Currencyid ='".$array[$i]."'";
						}
					}
				}
			}
			$i = 0;
			$res = $db->query("SELECT * FROM currency".$query." ORDER BY ".$orderBy." ".$order);
			while(($row = $res->fetch_assoc()) != null)
			{
				$ret[$i] = new Currency();
				$ret[$i]->Id = $row['currencyid'];
				$ret[$i]->Created = new WixDate($row['created']);
				$ret[$i]->Name = ucwords($row['name']);
				$ret[$i]->Country = ucwords($row['country']);
				$ret[$i]->Symbol = $row['symbol'];
				$ret[$i]->Country_code = $row['country_code'];
				$ret[$i]->Value = $row['value'];
				$ret[$i]->Code = strtoupper($row['code']);
				$i++;
			}
			return $ret;
		}



		//Hand crafted
        public static function ByName($name)
        {
            $ret = null;
            $res = DB::GetDB()->query("SELECT currencyid FROM currency WHERE country='$name'");
            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();
                $ret = new Currency($row['currencyid']);
            }
            return $ret;
        }

        public function ConvertTo(Currency $currency, $amount)
        {
            $toUsd = ($amount / $this->Value);
            return $toUsd * $currency->Value;
        }

        public static function FromLocation(Location $location)
        {
            $code = $location->CountryCode;
            $ret = Currency::ByCountry(Country::ByCode("us"));
            $res = DB::GetDB()->query("SELECT currencyid FROM currency WHERE country_code='$code'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();
                $ret = new Currency($row['currencyid']);
            }
            return $ret;
        }

        public static function ByCountry(Country $country)
        {
            $code = $country->Code;
            $ret = new Currency();
            $res = DB::GetDB()->query("SELECT currencyid FROM currency WHERE country_code='$code'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();
                $ret = new Currency($row['currencyid']);
            }
            return $ret;
        }

        public static function ByCode($code)
        {
            $ret = new Currency();
            $res = DB::GetDB()->query("SELECT currencyid FROM currency WHERE code='$code'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();
                $ret = new Currency($row['currencyid']);
            }
            return $ret;
        }
	}
