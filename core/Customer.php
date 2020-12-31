<?php
/* Generated by Wixnit Class Builder
// Feb, 03/2020
// Building class for Customer
*/

class Customer
{
    public $Id = "";
    public $Created = 0;
    public $Name = "";
    public $Surname = "";
    public $Phone = "";
    public $Email = "";
    private $Password = "";
    public $Country = "";
    public $State = "";
    public $City = "";
    public $Occupation = "";
    public $Kinname = "";
    public $Kinsurname = "";
    public $Organization = "";
    public $Zip = "";
    public $Lastseen = 0;
    public $Dateofbirth = 0;
    public $Monthofbirth = 0;
    public $Dayofbirth = 0;
    public $Newsletter = false;
    public $Active = false;
    public $Status = false;
    public $Sex = "";
    public $Guestid = "";
    public $Salutation = "";
    public $Profilepic = "";
    public $Idtype = "";
    public $Idnumber = "";
    public $Idimage = "";
    public $Street = "";
    public $Kinaddress = "";
    public $Destination = "";
    public $Origination = "";
    public $Guest = "";
    public $DOB = "";
    public $Address = "";
    public $InternalEmail = "";

    public $hasProperty = false;
    public $hasVehicle = false;
    public $hasLease = false;

    public $Bank = "";
    public $Accountname = "";
    public $Accountnumber = "";

    public $hasCorperate = false;

    public $Type = "customer";

    private $subscriber = null;

    public $isLodged = false;
    public $isActivated = false;

    public $Wallet = 0.0;
    public $Subscription = "";
    public $Corporate = false;
    public $Corporaterequest = false;
    public $Corporateresponse = false;

    function __construct($subscriber)
    {
        if(is_a($subscriber, "Subscriber"))
        {
            $this->subscriber = $subscriber;
        }
        else
        {
            $this->subscriber = new Subscriber();
            $this->Initialize($subscriber);
        }
    }

    public function Initialize($arg=null)
    {
        if($arg != null)
        {
            $db = DB::GetDB();

            $res = $db->query("SELECT * FROM customer WHERE customerid='$arg'");

            if($res->num_rows > 0)
            {
                $row = $res->fetch_assoc();

                $this->Id = $row['customerid'];
                $this->Created = new WixDate($row['created']);
                $this->Name = ucfirst($row['name']);
                $this->Surname = ucfirst($row['surname']);
                $this->Phone = $row['phone'];
                $this->Email = $row['email'];
                $this->Password = $row['password'];
                $this->Country = $row['country'];
                $this->State = $row['state'];
                $this->City = $row['city'];
                $this->Occupation = $row['occupation'];
                $this->Kinname = $row['kinname'];
                $this->Kinsurname = $row['kinsurname'];
                $this->Organization = $row['organization'];
                $this->Zip = $row['zip'];
                $this->Lastseen = new WixDate($row['lastseen']);
                $this->Dateofbirth = new WixDate($row['dateofbirth']);
                $this->Monthofbirth = $row['monthofbirth'];
                $this->Dayofbirth = $row['dayofbirth'];
                $this->Newsletter = Convert::ToBool($row['newsletter']);
                $this->Active = Convert::ToBool($row['active']);
                $this->Status = Convert::ToBool($row['status']);
                $this->Sex = $row['sex'];
                $this->Guestid = $row['guestid'];
                $this->Salutation = $row['salutation'];
                $this->Profilepic = $row['profilepic'];
                $this->Idtype = $row['idtype'];
                $this->Idnumber = $row['idnumber'];
                $this->Idimage = $row['idimage'];
                $this->Street = $row['street'];
                $this->Kinaddress = $row['kinaddress'];
                $this->Destination = $row['destination'];
                $this->Origination = $row['origination'];
                $this->Guest = $row['guest'];
                $this->Address = $row['address'];
                $this->DOB = $row['dob'];
                $this->InternalEmail = $row['internalEmail'];

                $this->Bank = $row['bank'];
                $this->Accountname = $row['accountname'];
                $this->Accountnumber = $row['accountnumber'];

                $this->Corporate = Convert::ToBool($row['corporate']);
                $this->Wallet = doubleval($row['wallet']);
                $this->Subscription = $row['subscription'];
                $this->Corporaterequest = Convert::ToBool($row['corporate_request']);
                $this->Corporateresponse = Convert::ToBool($row['corporate_response']);

                $this->CustomerDetails();

                // has customer created a password
                if ($row['password'] != '') $this->isActivated = true;
            }
        }
    }

    public function Save()
    {
        $db = DB::GetDB();

        $id = $this->Id;
        $created = time();
        $name = addslashes($this->Name);
        $surname = addslashes($this->Surname);
        $phone = addslashes($this->Phone);
        $email = addslashes($this->Email);
        $password = addslashes($this->Password);
        $country = addslashes($this->Country);
        $state = addslashes($this->State);
        $city = addslashes($this->City);
        $occupation = addslashes($this->Occupation);
        $kinname = addslashes($this->Kinname);
        $kinsurname = addslashes($this->Kinsurname);
        $organization = addslashes($this->Organization);
        $zip = addslashes($this->Zip);
        $lastseen = Convert::ToInt($this->Lastseen);
        $dateofbirth = Convert::ToInt($this->Dateofbirth);
        $monthofbirth = Convert::ToInt($this->Monthofbirth);
        $dayofbirth = Convert::ToInt($this->Dayofbirth);
        $newsletter = Convert::ToInt($this->Newsletter);
        $active = Convert::ToInt($this->Active);
        $status = Convert::ToInt($this->Status);
        $sex = addslashes($this->Sex);
        $guestid = addslashes($this->Guestid);
        $salutation = addslashes($this->Salutation);
        $profilepic = addslashes($this->Profilepic);
        $idtype = addslashes($this->Idtype);
        $idnumber = addslashes($this->Idnumber);
        $idimage = addslashes($this->Idimage);
        $street = addslashes($this->Street);
        $kinaddress = addslashes($this->Kinaddress);
        $destination = addslashes($this->Destination);
        $origination = addslashes($this->Origination);
        $guest = addslashes(is_a($this->Guest, "Guest") ? $this->Guest->Id : $this->Guest);
        $address = addslashes($this->Address);
        $dob = addslashes($this->DOB);

        $bank = addslashes($this->Bank);
        $accountname = addslashes($this->Accountname);
        $accountnumber = addslashes($this->Accountnumber);

        $corporate = Convert::ToInt($this->Corporate);
        $wallet = doubleval($this->Wallet);
        $subscription = Convert::ToInt($this->Subscription);
        $copRequest = Convert::ToInt($this->Corporaterequest);
        $copResponse = Convert::ToInt($this->Corporateresponse);
        $internalEmail = substr($this->Id, 0, 5) . '@tripmata.com';

        if($res = $db->query("SELECT customerid FROM customer WHERE customerid='$id'")->num_rows > 0)
        {
            $db->query("UPDATE customer SET `name`='$name',surname='$surname',phone='$phone',email='$email',`password`='$password',country='$country',`state`='$state',city='$city',occupation='$occupation',kinname='$kinname',kinsurname='$kinsurname',organization='$organization',zip='$zip',lastseen='$lastseen',dateofbirth='$dateofbirth',monthofbirth='$monthofbirth',dayofbirth='$dayofbirth',newsletter='$newsletter',active='$active',`status`='$status',sex='$sex',guestid='$guestid',salutation='$salutation',profilepic='$profilepic',idtype='$idtype',idnumber='$idnumber',idimage='$idimage',street='$street',kinaddress='$kinaddress',destination='$destination',origination='$origination',guest='$guest',bank='$bank',accountname='$accountname',accountnumber='$accountnumber',wallet='$wallet',subscription='$subscription',corporate='$corporate',corporate_request='$copRequest',corporate_response='$copResponse',`address`='$address',dob='$dob',internalEmail='$internalEmail' WHERE customerid = '$id'");
        }
        else
        {
            redo: ;
            $id = Random::GenerateId(16);
            if($db->query("SELECT customerid FROM customer WHERE customerid='$id'")->num_rows > 0)
            {
                goto redo;
            }
            $this->Id = $id;
            $internalEmail = substr($this->Id, 0, 5) . '@tripmata.com';
            $db->query("INSERT INTO customer(customerid,created,`name`,surname,phone,email,`password`,country,`state`,city,occupation,kinname,kinsurname,organization,zip,lastseen,dateofbirth,monthofbirth,dayofbirth,newsletter,active,`status`,sex,guestid,salutation,profilepic,idtype,idnumber,idimage,street,kinaddress,destination,origination,guest,bank,accountname,accountnumber,wallet,subscription,corporate,corporate_request,corporate_response,`address`,dob,internalEmail) VALUES ('$id','$created','$name','$surname','$phone','$email','$password','$country','$state','$city','$occupation','$kinname','$kinsurname','$organization','$zip','$lastseen','$dateofbirth','$monthofbirth','$dayofbirth','$newsletter','$active','$status','$sex','$guestid','$salutation','$profilepic','$idtype','$idnumber','$idimage','$street','$kinaddress','$destination','$origination','$guest','$bank','$accountname','$accountnumber','$wallet','$subscription','$corporate','$copRequest','$copResponse','$address','$dob','$internalEmail')");
        }
    }

    public function Delete()
    {
        $db = DB::GetDB();

        $id = $this->Id;
        $db->query("DELETE FROM customer WHERE customerid='$id'");

        //Deleting Associated Objects
        /*
        $guest = $this->GetGuest();
        $guest->Delete();
        */
    }

    public static function Search(Subscriber $subscriber, $term='')
    {
        $db = DB::GetDB();
        $ret = array();
        $i = 0;

        $res = $db->query("SELECT * FROM customer WHERE name LIKE '%$term%' OR surname LIKE '%$term%' OR phone LIKE '%$term%' OR email LIKE '%$term%' OR password LIKE '%$term%' OR country LIKE '%$term%' OR state LIKE '%$term%' OR city LIKE '%$term%' OR occupation LIKE '%$term%' OR kinname LIKE '%$term%' OR kinsurname LIKE '%$term%' OR organization LIKE '%$term%' OR zip LIKE '%$term%' OR lastseen LIKE '%$term%' OR dateofbirth LIKE '%$term%' OR monthofbirth LIKE '%$term%' OR dayofbirth LIKE '%$term%' OR newsletter LIKE '%$term%' OR active LIKE '%$term%' OR status LIKE '%$term%' OR sex LIKE '%$term%' OR guestid LIKE '%$term%' OR salutation LIKE '%$term%' OR profilepic LIKE '%$term%' OR idtype LIKE '%$term%' OR idnumber LIKE '%$term%' OR idimage LIKE '%$term%' OR street LIKE '%$term%' OR kinaddress LIKE '%$term%' OR destination LIKE '%$term%' OR origination LIKE '%$term%' OR guest LIKE '%$term%'");
        while(($row = $res->fetch_assoc()) != null)
        {
            $ret[$i] = new Customer($subscriber);
            $ret[$i]->Id = $row['customerid'];
            $ret[$i]->Created = new WixDate($row['created']);
            $ret[$i]->Name = ucfirst($row['name']);
            $ret[$i]->Surname = ucfirst($row['surname']);
            $ret[$i]->Phone = $row['phone'];
            $ret[$i]->Email = $row['email'];
            $ret[$i]->Password = $row['password'];
            $ret[$i]->Country = $row['country'];
            $ret[$i]->State = $row['state'];
            $ret[$i]->City = $row['city'];
            $ret[$i]->Occupation = $row['occupation'];
            $ret[$i]->Kinname = $row['kinname'];
            $ret[$i]->Kinsurname = $row['kinsurname'];
            $ret[$i]->Organization = $row['organization'];
            $ret[$i]->Zip = $row['zip'];
            $ret[$i]->Lastseen = new WixDate($row['lastseen']);
            $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
            $ret[$i]->Monthofbirth = $row['monthofbirth'];
            $ret[$i]->Dayofbirth = $row['dayofbirth'];
            $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
            $ret[$i]->Active = Convert::ToBool($row['active']);
            $ret[$i]->Status = Convert::ToBool($row['status']);
            $ret[$i]->Sex = $row['sex'];
            $ret[$i]->Guestid = $row['guestid'];
            $ret[$i]->Salutation = $row['salutation'];
            $ret[$i]->Profilepic = $row['profilepic'];
            $ret[$i]->Idtype = $row['idtype'];
            $ret[$i]->Idnumber = $row['idnumber'];
            $ret[$i]->Idimage = $row['idimage'];
            $ret[$i]->Street = $row['street'];
            $ret[$i]->Kinaddress = $row['kinaddress'];
            $ret[$i]->Destination = $row['destination'];
            $ret[$i]->Origination = $row['origination'];
            $ret[$i]->Guest = $row['guest'];
            $ret[$i]->Address = $row['address'];
            $ret[$i]->InternalEmail = $row['internalEmail'];
            $ret[$i]->DOB = $row['dob'];

            $ret[$i]->Bank = $row['bank'];
            $ret[$i]->Accountname = $row['accountname'];
            $ret[$i]->Accountnumber = $row['accountnumber'];

            $ret[$i]->Corporate = Convert::ToBool($row['corporate']);
            $ret[$i]->Wallet = doubleval($row['wallet']);
            $ret[$i]->Subscription = $row['subscription'];
            $ret[$i]->Corporaterequest = Convert::ToBool($row['corporate_request']);
            $ret[$i]->Corporateresponse = Convert::ToBool($row['corporate_response']);

            // has customer created a password
            if ($row['password'] != '') $ret[$i]->isActivated = true;

            $i++;
        }
        
        return $ret;
    }

    public static function Filter(Subscriber $subscriber, $term='', $field='customerid')
    {
        $db = DB::GetDB();
        $ret = array();
        $i = 0;

        $res = $db->query("SELECT * FROM customer WHERE ".$field." ='$term'");
        while(($row = $res->fetch_assoc()) != null)
        {
            $ret[$i] = new Customer($subscriber);
            $ret[$i]->Id = $row['customerid'];
            $ret[$i]->Created = new WixDate($row['created']);
            $ret[$i]->Name = ucfirst($row['name']);
            $ret[$i]->Surname = ucfirst($row['surname']);
            $ret[$i]->Phone = $row['phone'];
            $ret[$i]->Email = $row['email'];
            $ret[$i]->Password = $row['password'];
            $ret[$i]->Country = $row['country'];
            $ret[$i]->State = $row['state'];
            $ret[$i]->City = $row['city'];
            $ret[$i]->Occupation = $row['occupation'];
            $ret[$i]->Kinname = $row['kinname'];
            $ret[$i]->Kinsurname = $row['kinsurname'];
            $ret[$i]->Organization = $row['organization'];
            $ret[$i]->Zip = $row['zip'];
            $ret[$i]->Lastseen = new WixDate($row['lastseen']);
            $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
            $ret[$i]->Monthofbirth = $row['monthofbirth'];
            $ret[$i]->Dayofbirth = $row['dayofbirth'];
            $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
            $ret[$i]->Active = Convert::ToBool($row['active']);
            $ret[$i]->Status = Convert::ToBool($row['status']);
            $ret[$i]->Sex = $row['sex'];
            $ret[$i]->Guestid = $row['guestid'];
            $ret[$i]->Salutation = $row['salutation'];
            $ret[$i]->Profilepic = $row['profilepic'];
            $ret[$i]->Idtype = $row['idtype'];
            $ret[$i]->Idnumber = $row['idnumber'];
            $ret[$i]->Idimage = $row['idimage'];
            $ret[$i]->Street = $row['street'];
            $ret[$i]->Kinaddress = $row['kinaddress'];
            $ret[$i]->Destination = $row['destination'];
            $ret[$i]->Origination = $row['origination'];
            $ret[$i]->Guest = $row['guest'];
            $ret[$i]->Address = $row['address'];
            $ret[$i]->InternalEmail = $row['internalEmail'];
            $ret[$i]->DOB = $row['dob'];

            $ret[$i]->Bank = $row['bank'];
            $ret[$i]->Accountname = $row['accountname'];
            $ret[$i]->Accountnumber = $row['accountnumber'];

            $ret[$i]->Corporate = Convert::ToBool($row['corporate']);
            $ret[$i]->Wallet = doubleval($row['wallet']);
            $ret[$i]->Subscription = $row['subscription'];
            $ret[$i]->Corporaterequest = Convert::ToBool($row['corporate_request']);
            $ret[$i]->Corporateresponse = Convert::ToBool($row['corporate_response']);

            // has customer created a password
            if ($row['password'] != '') $ret[$i]->isActivated = true;

            $i++;
        }
        return $ret;
    }

    public static function Order(Subscriber $subscriber, $field='id', $order='DESC')
    {
        $db = DB::GetDB();
        $ret = array();
        $i = 0;

        $res = $db->query("SELECT * FROM customer ORDER BY ".$field." ".$order."");
        while(($row = $res->fetch_assoc()) != null)
        {
            $ret[$i] = new Customer($subscriber);
            $ret[$i]->Id = $row['customerid'];
            $ret[$i]->Created = new WixDate($row['created']);
            $ret[$i]->Name = ucfirst($row['name']);
            $ret[$i]->Surname = ucfirst($row['surname']);
            $ret[$i]->Phone = $row['phone'];
            $ret[$i]->Email = $row['email'];
            $ret[$i]->Password = $row['password'];
            $ret[$i]->Country = $row['country'];
            $ret[$i]->State = $row['state'];
            $ret[$i]->City = $row['city'];
            $ret[$i]->Occupation = $row['occupation'];
            $ret[$i]->Kinname = $row['kinname'];
            $ret[$i]->Kinsurname = $row['kinsurname'];
            $ret[$i]->Organization = $row['organization'];
            $ret[$i]->Zip = $row['zip'];
            $ret[$i]->Lastseen = new WixDate($row['lastseen']);
            $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
            $ret[$i]->Monthofbirth = $row['monthofbirth'];
            $ret[$i]->Dayofbirth = $row['dayofbirth'];
            $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
            $ret[$i]->Active = Convert::ToBool($row['active']);
            $ret[$i]->Status = Convert::ToBool($row['status']);
            $ret[$i]->Sex = $row['sex'];
            $ret[$i]->Guestid = $row['guestid'];
            $ret[$i]->Salutation = $row['salutation'];
            $ret[$i]->Profilepic = $row['profilepic'];
            $ret[$i]->Idtype = $row['idtype'];
            $ret[$i]->Idnumber = $row['idnumber'];
            $ret[$i]->Idimage = $row['idimage'];
            $ret[$i]->Street = $row['street'];
            $ret[$i]->Kinaddress = $row['kinaddress'];
            $ret[$i]->Destination = $row['destination'];
            $ret[$i]->Origination = $row['origination'];
            $ret[$i]->Guest = $row['guest'];
            $ret[$i]->Address = $row['address'];
            $ret[$i]->InternalEmail = $row['internalEmail'];
            $ret[$i]->DOB = $row['dob'];

            $ret[$i]->Bank = $row['bank'];
            $ret[$i]->Accountname = $row['accountname'];
            $ret[$i]->Accountnumber = $row['accountnumber'];

            $ret[$i]->Corporate = Convert::ToBool($row['corporate']);
            $ret[$i]->Wallet = doubleval($row['wallet']);
            $ret[$i]->Subscription = $row['subscription'];
            $ret[$i]->Corporaterequest = Convert::ToBool($row['corporate_request']);
            $ret[$i]->Corporateresponse = Convert::ToBool($row['corporate_response']);

            // has customer created a password
            if ($row['password'] != '') $ret[$i]->isActivated = true;

            $i++;
        }
        return $ret;
    }

    public static function All(Subscriber $subscriber)
    {
        $db = DB::GetDB();
        $ret = array();
        $i = 0;

        $res = $db->query("SELECT * FROM customer");
        while (($row = $res->fetch_assoc()) != null)
        {
            $ret[$i] = new Customer($subscriber);
            $ret[$i]->Id = $row['customerid'];
            $ret[$i]->Created = new WixDate($row['created']);
            $ret[$i]->Name = ucfirst($row['name']);
            $ret[$i]->Surname = ucfirst($row['surname']);
            $ret[$i]->Phone = $row['phone'];
            $ret[$i]->Email = $row['email'];
            $ret[$i]->Password = $row['password'];
            $ret[$i]->Country = $row['country'];
            $ret[$i]->State = $row['state'];
            $ret[$i]->City = $row['city'];
            $ret[$i]->Occupation = $row['occupation'];
            $ret[$i]->Kinname = $row['kinname'];
            $ret[$i]->Kinsurname = $row['kinsurname'];
            $ret[$i]->Organization = $row['organization'];
            $ret[$i]->Zip = $row['zip'];
            $ret[$i]->Lastseen = new WixDate($row['lastseen']);
            $ret[$i]->Dateofbirth = new WixDate($row['dateofbirth']);
            $ret[$i]->Monthofbirth = $row['monthofbirth'];
            $ret[$i]->Dayofbirth = $row['dayofbirth'];
            $ret[$i]->Newsletter = Convert::ToBool($row['newsletter']);
            $ret[$i]->Active = Convert::ToBool($row['active']);
            $ret[$i]->Status = Convert::ToBool($row['status']);
            $ret[$i]->Sex = $row['sex'];
            $ret[$i]->Guestid = $row['guestid'];
            $ret[$i]->Salutation = $row['salutation'];
            $ret[$i]->Profilepic = $row['profilepic'];
            $ret[$i]->Idtype = $row['idtype'];
            $ret[$i]->Idnumber = $row['idnumber'];
            $ret[$i]->Idimage = $row['idimage'];
            $ret[$i]->Street = $row['street'];
            $ret[$i]->Kinaddress = $row['kinaddress'];
            $ret[$i]->Destination = $row['destination'];
            $ret[$i]->Origination = $row['origination'];
            $ret[$i]->Guest = $row['guest'];
            $ret[$i]->Address = $row['address'];
            $ret[$i]->DOB = $row['dob'];
            $ret[$i]->InternalEmail = $row['internalEmail'];

            $ret[$i]->Bank = $row['bank'];
            $ret[$i]->Accountname = $row['accountname'];
            $ret[$i]->Accountnumber = $row['accountnumber'];

            $ret[$i]->Corporate = Convert::ToBool($row['corporate']);
            $ret[$i]->Wallet = doubleval($row['wallet']);
            $ret[$i]->Subscription = $row['subscription'];
            $ret[$i]->Corporaterequest = Convert::ToBool($row['corporate_request']);
            $ret[$i]->Corporateresponse = Convert::ToBool($row['corporate_response']);

            // has customer created a password
            if ($row['password'] != '') $ret[$i]->isActivated = true;

            $i++;
        }
        return $ret;
    }

    public function GetGuest()
    {
        $ret = new Guest($this->subscriber);
        $ret->Initialize($this->Guest);
        return $ret;
    }

    public function SetGuest($guest)
    {

        //Presuming Object has a Save Method
        /*
        if(is_a($guest, "Guest"))
        {
            $guest->Save();
        }
        */
        $this->Guest = is_a($guest, "Guest") ? $guest->Id : $guest;
    }

    public static function CountAll(Subscriber $subscriber)
    {
        $db = $subscriber->GetDB();
        $ret = array();
        $i = 0;

        $ret = $db->query("SELECT id FROM customer")->num_rows;
        $db->close();
        return $ret;
    }

    //Hand crafted
    public static function EmailExist($email)
    {
        $email = strtolower(trim($email));
        $db = DB::GetDB();
        return ($db->query("SELECT email FROM customer WHERE email='$email'")->num_rows > 0) ? true : false;
    }

    public static function PhoneExist($phone)
    {
        $db = DB::GetDB();
        return $db->query("SELECT phone FROM customer WHERE phone='$phone'")->num_rows > 0 ? true : false;
    }

    public static function GuestExist($guestid, Subscriber $sub)
    {
        $db = $sub->GetDB();
        return $db->query("SELECT guestid FROM customer WHERE guestid='$guestid'")->num_rows > 0 ? true : false;
    }

    public static function isLoggedin()
    {
        return false;
    }

    public function SetPassword($password)
    {
        $this->Password = $password;
    }

    public function GetPassword()
    {
        return $this->Password;
    }

    public static function ByEmail($email)
    {
        $email = strtolower(trim($email));
        $db = DB::GetDB();

        $ret = new Customer(new Subscriber());

        $res = $db->query("SELECT customerid FROM customer WHERE email='$email'");

        if($res->num_rows > 0)
        {
            $row = $res->fetch_assoc();
            $ret->Initialize($row['customerid']);
        }

        return $ret;
    }

    public static function ByPhone($phone)
    {
        $phone = strtolower(trim($phone));
        $db = DB::GetDB();

        $ret = new Customer(new Subscriber());

        $res = $db->query("SELECT customerid FROM customer WHERE phone='$phone'");

        if($res->num_rows > 0)
        {
            $row = $res->fetch_assoc();
            $ret->Initialize($row['customerid']);
        }
        
        return $ret;
    }

    public function CustomerDetails()
    {
        $id = $this->Id;

        $db = DB::GetDB();

        $this->hasProperty = $db->query("SELECT id FROM property WHERE owner='$id'")->num_rows > 0 ? true : false;
        $this->hasVehicle = $db->query("SELECT id FROM vehicle WHERE owner='$id'")->num_rows > 0 ? true : false;
    }
}
