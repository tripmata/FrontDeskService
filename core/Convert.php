<?php

    class Convert
    {
        public static function ToInt($arg)
        {
            $ret = 0;
            if(is_a($arg, "WixDate"))
            {
                $ret = $arg->getValue();
            }
            else if(is_array($arg))
            {
                $ret = count($arg);
            }
            else
            {
                $ret = $arg;
            }
            return intval($ret);
        }

        public static function ToBool($arg)
        {
            if($arg === "1")
            {
                return true;
            }
            else if($arg == "0")
            {
                return false;
            }
            else if(strtoupper($arg) === "TRUE")
            {
                return true;
            }
            else if(strtoupper($arg) === "FALSE")
            {
                return false;
            }
            else
            {
                return boolval($arg);
            }
        }

        public  static function ToPrivacy($arg)
        {
            if($arg === "1")
            {
                return 1;
            }
            else if($arg === "2")
            {
                return 2;
            }
            else if($arg === "3")
            {
                return 3;
            }
            else if($arg === "4")
            {
                return 4;
            }
            else if($arg === "5")
            {
                return 5;
            }
            else if($arg === "6")
            {
                return 6;
            }
            else if($arg === "7")
            {
                return 1;
            }
            else if($arg === "8")
            {
                return 8;
            }
            else if(strtoupper($arg) === "ONLY ME")
            {
                return 1;
            }
            else if(strtoupper($arg) === "FOLLOWERS ONLY")
            {
                return 2;
            }
            else if(strtoupper($arg) === "FOLLOWING ONLY")
            {
                return 3;
            }
            else if(strtoupper($arg) === "MY LEVEL ONLY")
            {
                return 4;
            }
            else if(strtoupper($arg) === "MY DEPARTMENT ONLY")
            {
                return 5;
            }
            else if(strtoupper($arg) === "MY FACULTY ONLY")
            {
                return 6;
            }
            else if(strtoupper($arg) === "MY SCHOOL ONLY")
            {
                return 7;
            }
            else if(strtoupper($arg) === "EVERY ONE")
            {
                return 8;
            }
            else if($arg == 1)
            {
                return 1;
            }
            else if($arg == 2)
            {
                return 2;
            }
            else if($arg == 3)
            {
                return 3;
            }
            else if($arg === 4)
            {
                return 4;
            }
            else if($arg === 5)
            {
                return 5;
            }
            else if($arg === 6)
            {
                return 6;
            }
            else if($arg === 7)
            {
                return 7;
            }
            else if($arg === 8)
            {
                return 8;
            }
            else if($arg === true)
            {
                return 8;
            }
            else if($arg === false)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public  static function ToPrivacyText($arg)
        {
            $val = Convert::ToPrivacyText($arg);

            switch ($val)
            {
                case 1:
                    return "Only Me";
                    break;
                case 2:
                    return "Followers Only";
                    break;
                case 3:
                    return "Following Only";
                    break;
                case 4:
                    return "My School Only";
                    break;
                case 5:
                    return "My Department Only";
                    break;
                case 6:
                    return "My Faculty Only";
                    break;
                case 7:
                    return "My School Only";
                    break;
                case 8:
                    return "Everyone";
                    break;
                default:
                    return "Unknown";
            }
        }

        public  static function ToPrivacyShort($arg)
        {
            $val = Convert::ToPrivacyText($arg);

            switch ($val)
            {
                case 1:
                    return "Only Me";
                    break;
                case 2:
                    return "Followers";
                    break;
                case 3:
                    return "Following";
                    break;
                case 4:
                    return "School";
                    break;
                case 5:
                    return "Department";
                    break;
                case 6:
                    return "Faculty";
                    break;
                case 7:
                    return "School";
                    break;
                case 8:
                    return "Everyone";
                    break;
                default:
                    return "Unknown";
            }
        }

        public static function NumbersToWords($number)
        {
            $ret = "unknown";

            switch (Convert::ToInt($number))
            {
                case 0:
                    $ret = "zero";
                    break;
                case 1:
                    return "one";
                    break;
                case 2:
                    return "two";
                    break;
                case 3:
                    return "three";
                    break;
                case 4:
                    return "four";
                    break;
                case 5:
                    return "five";
                    break;
                case 6:
                    return "six";
                    break;
                case 7:
                    return "seven";
                    break;
                case 8:
                    return "eight";
                    break;
                case 9:
                    return "nine";
                    break;
                case 10:
                    return "ten";
                    break;
                case 11:
                    return "eleven";
                    break;
                case 12:
                    return "twelve";
                    break;
                case 13:
                    return "thirteen";
                    break;
                case 14:
                    return "fourteen";
                    break;
                case 15:
                    return "fifteen";
                    break;
                case 16:
                    return "sixteen";
                    break;
                case 17:
                    return "seventeen";
                    break;
                case 18:
                    return "eighteen";
                    break;
                case 19:
                    return "nineteen";
                    break;
                case 20:
                    return "twenty";
                    break;
                case 21:
                    return "twenty one";
                    break;
                case 22:
                    return "twenty two";
                    break;
                case 23:
                    return "twenty three";
                    break;
                default:
                    $ret = "uncountable";

            }

            return $ret;
        }

        public static function MonthToNumber($month)
        {
            $ret = 0;

            if((strtolower(trim($month)) == "january") || (strtolower(trim($month)) == "jan"))
            {
                $ret = 1;
            }
            if((strtolower(trim($month)) == "february") || (strtolower(trim($month)) == "feb"))
            {
                $ret = 2;
            }
            if((strtolower(trim($month)) == "march") || (strtolower(trim($month)) == "mar"))
            {
                $ret = 3;
            }
            if((strtolower(trim($month)) == "april") || (strtolower(trim($month)) == "apr"))
            {
                $ret = 4;
            }
            if((strtolower(trim($month)) == "may") || (strtolower(trim($month)) == "may"))
            {
                $ret = 5;
            }
            if((strtolower(trim($month)) == "june") || (strtolower(trim($month)) == "jun"))
            {
                $ret = 6;
            }
            if((strtolower(trim($month)) == "july") || (strtolower(trim($month)) == "jul"))
            {
                $ret = 7;
            }
            if((strtolower(trim($month)) == "august") || (strtolower(trim($month)) == "aug"))
            {
                $ret = 8;
            }
            if((strtolower(trim($month)) == "september") || (strtolower(trim($month)) == "september"))
            {
                $ret = 9;
            }
            if((strtolower(trim($month)) == "october") || (strtolower(trim($month)) == "oct"))
            {
                $ret = 10;
            }
            if((strtolower(trim($month)) == "november") || (strtolower(trim($month)) == "nov"))
            {
                $ret = 11;
            }
            if((strtolower(trim($month)) == "december") || (strtolower(trim($month)) == "dec"))
            {
                $ret = 12;
            }
            if($ret === 0)
            {
                $ret = Convert::ToInt($month);
            }

            return $ret;
        }

        public static function IntToMonthShort($number)
        {
            $ret = "Unknown";

            if(Convert::ToInt($number) === 1)
            {
                $ret = "jan";
            }
            if(Convert::ToInt($number) === 2)
            {
                $ret = "feb";
            }
            if(Convert::ToInt($number) === 3)
            {
                $ret = "mar";
            }
            if(Convert::ToInt($number) === 4)
            {
                $ret = "apr";
            }
            if(Convert::ToInt($number) === 5)
            {
                $ret = "may";
            }
            if(Convert::ToInt($number) === 6)
            {
                $ret = "jun";
            }
            if(Convert::ToInt($number) === 7)
            {
                $ret = "jul";
            }
            if(Convert::ToInt($number) === 8)
            {
                $ret = "aug";
            }
            if(Convert::ToInt($number) === 9)
            {
                $ret = "sept";
            }
            if(Convert::ToInt($number) === 10)
            {
                $ret = "oct";
            }
            if(Convert::ToInt($number) === 11)
            {
                $ret = "nov";
            }
            if(Convert::ToInt($number) === 12)
            {
                $ret = "dec";
            }

            return $ret;
        }

        public static function IntToMonth($number)
        {
            $ret = "Unknown";

            if(Convert::ToInt($number) === 1)
            {
                $ret = "january";
            }
            if(Convert::ToInt($number) === 2)
            {
                $ret = "february";
            }
            if(Convert::ToInt($number) === 3)
            {
                $ret = "march";
            }
            if(Convert::ToInt($number) === 4)
            {
                $ret = "april";
            }
            if(Convert::ToInt($number) === 5)
            {
                $ret = "may";
            }
            if(Convert::ToInt($number) === 6)
            {
                $ret = "june";
            }
            if(Convert::ToInt($number) === 7)
            {
                $ret = "july";
            }
            if(Convert::ToInt($number) === 8)
            {
                $ret = "august";
            }
            if(Convert::ToInt($number) === 9)
            {
                $ret = "september";
            }
            if(Convert::ToInt($number) === 10)
            {
                $ret = "october";
            }
            if(Convert::ToInt($number) === 11)
            {
                $ret = "november";
            }
            if(Convert::ToInt($number) === 12)
            {
                $ret = "december";
            }

            return $ret;
        }
    }