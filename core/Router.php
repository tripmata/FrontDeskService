<?php

    class Router
    {
        public $Page = "";
        public $Args = Array();

        public $ErrorPage = true;
        public $ErrorPagePath = "";

        private $paths = Array();
        private $routes = Array();

        private $redirects = Array();
        private $redirectPath = Array();

        private $home = "";

        function __construct($path=null)
        {
			if($path != null)
			{
				$ds = explode("/", trim($path, "/"));

				for ($i = 0; $i < count($ds); $i++)
				{
					if ($i == 0)
					{
						$this->Page = $ds[0];
					}
					else
					{
						$this->Args[count($this->Args)] = $ds[$i];
					}
				}
			}
			else
			{
				if(isset($_SERVER['PATH_INFO']))
				{
					$ds = explode("/", trim($_SERVER['PATH_INFO'], "/"));

					for ($i = 0; $i < count($ds); $i++)
					{
						if ($i == 0)
						{
							$this->Page = $ds[0];
						}
						else
						{
							$this->Args[count($this->Args)] = $ds[$i];
						}
					}
				}
			}
        }

        public function AddHome($home)
        {
            $this->home = $home;
        }


        public function AddRoute($route, $path)
        {
            $this->paths[count($this->paths)] = $path;
            $this->routes[count($this->routes)] = $route;
        }

        public function Redirect($page, $to)
        {
            $this->redirects[count($this->redirects)] = $page;
            $this->redirectPath[count($this->redirectPath)] = $to;
        }

        public static function ResolvePath($path, $pathInfo=null)
        {
            $ret = $path;
            $prepend = "";
            $extra = false;

            if((isset($pathInfo)) && ($pathInfo != ""))
            {
                $tmp = explode("/", $pathInfo);

                if($tmp[(count($tmp) - 1)] == "")
                {
                    $extra = true;
                }

                $ds = explode("/", trim($pathInfo, "/"));
                for($i = 0; $i < (count($ds) - 1); $i++)
                {
                    $prepend .= "../";
                }
            }

            if($extra)
            {
                $ret = "../".$ret;
            }

            return $prepend.$ret;
        }

        public function MapRoutes()
        {
            if(($this->home == $this->Page) || ($this->Page == ""))
            {
                require_once ($this->home);
                return;
            }

            for($i = 0; $i < count($this->redirects); $i++)
            {
                if(trim(strtolower($this->Page) == trim(strtolower($this->redirects[$i]))))
                {
                    header("Location: ".$this->redirectPath[$i]);
                    return;
                }
            }
            for($i = 0; $i < count($this->routes); $i++)
            {
                if(trim(strtolower($this->Page) == trim(strtolower($this->routes[$i]))))
                {
                    require_once ($this->paths[$i]);
                    return;
                }
            }

            if($this->ErrorPage == true)
            {
                if($this->ErrorPagePath != "")
                {
                    require_once ($this->paths[$i]);
                    return;
                }
                else
                {
                    echo "
                        <!DOCTYPE html>
                        <html>
                            <head>
                                <title>Error : : Not Found</title>
                            </head>
                            <body style='text-align: center;'>
                                <h1 style='color: dimgray; font-family: Arial; font-size: 3em;'>404</h1>
                                <h3 style='color: lightgray; font-family: Segoe UI; font-weight: normal;'>
                                    The requested page was not found
                                </h3>
                            </body>
                        </html>
                    ";
                }
            }
        }


        public static function BuildMeta($url)
        {
            $pre = explode(" ", strtolower(trim($url)));
            $meta = "";

            for($i = 0; $i < count($pre); $i++)
            {
                if($i == 0)
                {
                    $meta = $pre[0];
                }
                else
                {
                    $meta .= "-".$pre[$i];
                }
            }
            return $meta;
        }

        // print formatted json data to screen
        public function printJson(array $data) : int
        {
            // print json string
            echo json_encode($data, JSON_PRETTY_PRINT);

            // return 0
            return 0;
        }
    }