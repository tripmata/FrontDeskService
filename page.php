<?php

    // set the default content type
    header('Content-Type: application/json');

    // require dependencies
    require_once ("loader.php");

    // get host url and cdn url from gateway
    $host = $urlConfiguration->host;
    $cdn = $urlConfiguration->storage;

    // clean $_REQUEST array
    Sanitize::removeHTMLFromRequests();

    $user = null;

    // @var stdClass $ret 
    $ret = new stdClass();

    // set the return type
    $ret->Type = "page";

    // @var Subscriber $subscriber
    $subscriber = new Subscriber();
    
    if (isset($_REQUEST['usersess']))
    {
        $user = new User($_REQUEST['usersess']);

        if($user->Property != null)
        {
            require_once ("pages/frontdesk1.php");
        }
        else
        {
            require_once ("pages/login.php");
        }
    }
    else
    {
        require_once ("pages/login.php");
    }

    // print json json
    echo json_encode($ret);