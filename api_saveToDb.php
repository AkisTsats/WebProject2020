<?php

include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

include("dbConnection.php");

$userID = $_SESSION['user']['id'];

$entityBody = file_get_contents('php://input');
$harID = time();
$name = $harID; //.$userID;


$d = date("d/m/Y");
$t = date("H:i:sa");

$dateOfUpload = $d." ".$t;

$query = "INSERT INTO files (name, user_id, dateOfUpload)
    VALUES('$name','$userID', '$dateOfUpload')";
mysqli_query($db, $query);




file_put_contents("./uploads/" . $name . ".json", $entityBody, FILE_TEXT);


$givenFile = json_decode($entityBody);


foreach ($givenFile->log->entries as $value) {
    //echo $value->serverIPAddress;
    $serverIPAddress = $value->serverIPAddress;
    $startedDateTime = $value->startedDateTime;

    $wait = $value->timings->wait;


    $req_method = $value->request->method;
    $req_url = $value->request->url;

    $res_status = $value->response->status;
    $res_statusText = $value->response->statusText;



    // $query = "INSERT INTO allentries (resStatus, resStatusText)
    // VALUES('$res_status','$res_statusText')";
    // mysqli_query($db, $query);

    // $query = "INSERT INTO allentries (reqMethod, reqUrl)
    // VALUES('$req_method','$req_url')";
    // mysqli_query($db, $query);

    foreach ($value->request->headers as $val) {

        if ($val->name == "content-type") {
            $req_content_type = $val->value;
            //echo $req_content_type;

        }
        if ($val->name == "cache-control") {
            $req_cache_control = $val->value;
            //echo $req_cache_control;

        }
        if ($val->name == "pragma") {
            $req_pragma = $val->value;
            //echo $req_pragma;

        }
        if ($val->name == "expires") {
            $req_expires = $val->value;
            //echo $req_expires;

        }
        if ($val->name == "age") {
            $req_age = $val->value;
            //echo $req_age;

        }
        if ($val->name == "last-modified") {
            $req_last_modified = $val->value;
            //echo $req_last_modified;

        }
        if ($val->name == "host") {
            $req_host = $val->value;
            //echo $req_host;

        }

        // $query = "INSERT INTO request (contentType, cacheControl, pragma, expires, age, lastModified, host)
        // VALUES('$req_content_type','$req_cache_control', '$req_pragma', '$req_expires', '$req_age', '$req_last_modified', '$req_host')";
        // mysqli_query($db, $query);
    }



    foreach ($value->response->headers as $val) {

        if ($val->name == "content-type") {
            $res_content_type = $val->value;
            //echo $res_content_type;

        }
        if ($val->name == "cache-control") {
            $res_cache_control = $val->value;
            //echo $res_cache_control;

        }
        if ($val->name == "pragma") {
            $res_pragma = $val->value;
            //echo $res_pragma;

        }
        if ($val->name == "expires") {
            $res_expires = $val->value;
            //echo $res_expires;

        }
        if ($val->name == "age") {
            $res_age = $val->value;
            //echo $res_age;

        }
        if ($val->name == "last-modified") {
            $res_last_modified = $val->value;
            //echo $res_last_modified;

        }

        if ($val->name == "host") {
            $res_host = $val->value;
            //echo $res_host;

        }

        // $query = "INSERT INTO response (contentType, cacheControl, pragma, expires, age, lastModified, host)
        // VALUES('$res_content_type','$res_cache_control', '$res_pragma', '$res_expires', '$res_age', '$res_last_modified', '$res_host')";
        // mysqli_query($db, $query);
    }


    $query = "INSERT INTO allentries (harID, startedDateTime, serverIPAddress, wait, resStatus, resStatusText, reqMethod, reqUrl, reqContentType, reqCacheControl, reqPragma, reqAge, reqLastModified, reqHost, reqExpires, resContentType, resCacheControl, resPragma, resAge, resLastModified, resHost, resExpires, userID ) 
    VALUES('$harID', '$startedDateTime','$serverIPAddress', '$wait', '$res_status','$res_statusText', '$req_method','$req_url', '$req_content_type', '$req_cache_control', '$req_pragma', '$req_age', '$req_last_modified', '$req_host', '$req_expires','$res_content_type', '$res_cache_control', '$res_pragma', '$res_age', '$res_last_modified', '$res_host', '$res_expires', '$userID' )";
    mysqli_query($db, $query);
}
