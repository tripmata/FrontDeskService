<?php


    class Receipt
    {
        public $Header = null;
        public $Footer = null;
        public $Row = null;
        public $Links = [];
        public $Definitions = null;
        public $Style = null;

        public $isValid = false;

        function __construct($arg)
        {
            $filePath = "pages/receipt/".strtolower($arg)."/";

            $valid = true;

            if((file_exists($filePath."style.css")) && ($valid))
            {
                $res = fopen($filePath."style.css", "r");
                $this->Style = fread($res, filesize($filePath."style.css"));
                fclose($res);
            }
            else
            {
                $valid = false;
            }

            if((file_exists($filePath."header.json")) && ($valid))
            {
                $res = fopen($filePath."header.json", "r");
                $this->Header = json_decode(fread($res, filesize($filePath."header.json")));
                fclose($res);
            }
            else
            {
                $valid = false;
            }

            if((file_exists($filePath."footer.json")) && ($valid))
            {
                $res = fopen($filePath."footer.json", "r");
                $this->Footer = json_decode(fread($res, filesize($filePath."footer.json")));
                fclose($res);
            }
            else
            {
                $valid = false;
            }

            if((file_exists($filePath."definition.json")) && ($valid))
            {
                $res = fopen($filePath."definition.json", "r");
                $this->Definitions = json_decode(fread($res, filesize($filePath."definition.json")));
                fclose($res);
            }
            else
            {
                $valid = false;
            }

            if((file_exists($filePath."links.json")) && ($valid))
            {
                $res = fopen($filePath."links.json", "r");
                $this->Links = json_decode(fread($res, filesize($filePath."links.json")));
                fclose($res);
            }
            else
            {
                $valid = false;
            }

            if((file_exists($filePath."row.json")) && ($valid))
            {
                $res = fopen($filePath."row.json", "r");
                $this->Row = json_decode(fread($res, filesize($filePath."row.json")));
                fclose($res);
            }
            else
            {
                $valid = false;
            }
            $this->isValid = $valid;
        }


        public static function All()
        {
            $filePath = "pages/receipt/index.xml";
            $ret = [];

            if(file_exists($filePath))
            {
                $xml = simplexml_load_file($filePath);

                for($i = 0; $i < count($xml->layout); $i++)
                {
                    array_push($ret, new Receipt(strtolower($xml->layout[$i]->name)));
                }
            }
            return $ret;
        }
    }