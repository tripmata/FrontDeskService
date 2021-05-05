<?php

    class Lodgepixel extends Room
    {
        public $Checkin = 0;
        public $Checkout = 0;
        public $Checkedout = false;
        public $Checkouttime = 0;
        private $obj;

        function __construct(Subscriber $sub, $obj)
        {
            $this->subscriber = $sub;

            if(is_object($obj))
            {
                if(isset($obj->Checkin))
                {
                    $this->Checkin = new WixDate($obj->Checkin);
                }
                else
                {
                    $this->Checkin = new WixDate(time());
                }

                if(isset($obj->Checkout))
                {
                    $this->Checkout = new WixDate($obj->Checkout);
                }
                else
                {
                    $this->Checkout = new WixDate(time());
                }

                if(isset($obj->Checkedout))
                {
                    $this->Checkedout = Convert::ToBool($obj->Checkedout);
                }

                if(isset($obj->Checkouttime))
                {
                    $this->Checkouttime = new WixDate($obj->Checkouttime);
                }
                else
                {
                    $this->Checkouttime = new WixDate(time());
                }

                if (isset($obj->Id))
                {
                    parent::Initialize($obj->Id);
                }
            }
            else
            {
                $this->Checkin = new WixDate(time());
                $this->Checkout = new WixDate(time());
                $this->Checkouttime = new WixDate(time());
            }
            $this->obj = $obj;
        }

        public function Pixelate()
        {
            $std = new stdClass();
            $std->Checkin = $this->Checkin->getValue();
            $std->Checkout = $this->Checkout->getValue();
            $std->Checkedout = Convert::ToInt($this->Checkedout);
            $std->Checkouttime = $this->Checkouttime->getValue();

            $std->Id = $this->Id;
            return $std;
        }
    }