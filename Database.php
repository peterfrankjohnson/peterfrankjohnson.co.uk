<?php

class Client {
    public static function IP() {
// X-Forwarded-For can be faked.
// How do we test this? Traceroute?
// 
// Can we test anything in real-time?
//
// http://stackoverflow.com/questions/3003145/how-to-get-client-ip-address-in-php
        if($ip == Client::XForwardedFor()) {
            return $ip;
        }
        if($ip == Client::RemoteAddr()) {
            return $ip;
        }
        return null;
    }

    public static function XForwardedFor() {
        if(isset($_SERVER['X_FORWARDED_FOR'])) {
            return $_SERVER['X_FORWARDED_FOR'];
        }
        return null;
    }

    public static function RemoteAddr() {
        if(isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return null;
    }
}

class Database extends SQLite3
{
    function __construct()
    {
        $this->open('sqlite3.db');
    }
}

class Request {
    public static function Method(){
        if(isset($_SERVER['REQUEST_METHOD'])) {
            return $_SERVER['REQUEST_METHOD'];
        }
        return null;
    }

    public static function Uri(){
        if(isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }
        return null;
    }

    public static function QueryString(){
        if(isset($_SERVER['QUERY_STRING'])) {
            return $_SERVER['QUERY_STRING'];
        }
        return null;
    }

    public static function Protocol(){
        if(isset($_SERVER['SERVER_PROTOCOL'])) {
            return $_SERVER['SERVER_PROTOCOL'];
        }
        return null;
    }

    public static function Time(){
        if(isset($_SERVER['REQUEST_TIME'])) {
            return $_SERVER['REQUEST_TIME'];
        }
        return null;
    }

    public static function Header($key) {
        $key = strtoupper(str_replace('-', '_', $key));
        $key = 'HTTP_' . $key;
        if(isset($_SERVER[$key])) {
            return (string) "" . $_SERVER[$key];
        }
        return (string) "";
    }
}

class Response {
}

$database = new Database();

$database->exec(
    'CREATE TABLE IF NOT EXISTS client (
        id INTEGER PRIMARY KEY,
        ip_address STRING,
        x_forwarded_for STRING,
        remote_addr STRING
    )'
);

$database->exec(
    'CREATE TABLE IF NOT EXISTS request (
        id INTEGER PRIMARY KEY,
        client_id INTEGER,
        method STRING,
        uri STRING,
        query STRING,
        protocol STRING,
        time INTEGER
    )'
);

$database->exec(
    'CREATE TABLE IF NOT EXISTS request_has_request_header (
        id INTEGER PRIMARY KEY,
        request_id INTEGER,
        request_header_id INTEGER
    )'
);

$database->exec(
    'CREATE TABLE IF NOT EXISTS request_header (
        id INTEGER PRIMARY KEY,
        request_id INTEGER,
        name STRING,
        header STRING
    )'
);

$statement = $database->prepare(
    'SELECT * FROM client WHERE ip_address = :ip_address'
);
$statement->bindValue(':ip_address', Client::IP());
$result = $statement->execute();
if($result) {
    $row = $result->fetchArray();
    $client_id = $row['id'];
}
if ($client_id == '') {
    $database->exec(
        'INSERT INTO client VALUES(
            NULL, ' .
            "'" . Client::IP() . "'" .  
            "'" . Client::XForwardedFor() . "'" .  
            "'" . Client::RemoteAddr() . "'" .  
        ')'
    );
    $client_id = $database->lastInsertRowId();
}

$database->exec(
    'INSERT INTO request VALUES(
        NULL, ' .
        $client_id . ', ' .
        "'" . Request::Method() . "', " .
        "'" . Request::Uri() . "', " .
        "'" . Request::QueryString() . "', " .
        "'" . Request::Protocol() . "', " .
        "'" . Request::Time() . "'" .
    ')'
);

$requestId = $database->lastInsertRowId();

$headers = array(
    'Host',
    'User-agent',
    'Cookie',
    'Referer',
    'Accept',
    'Accept-Charset',
    'Accept-Encoding',
    'Accept-Language',
    'Connection'
);

foreach ($headers as $headerName) {
    $headerValue = Request::Header($headerName);
    if($headerValue != "") {
        $statement = $database->prepare(
            'SELECT * FROM request_header WHERE name = ":name" and value = ":value"'
        );
        $statement->bindValue(':name', $headerName);
        $statement->bindValue(':value', $headerValue);
        $result = $statement->execute();
        if($result) {
            $row = $result->fetchArray();
            $header_id = $row['id'];
        }
        if ($header_id == '') {
            $database->exec(
                'INSERT INTO request_header VALUES( ' .
                    'NULL, ' .
                    $requestId . ', ' .
                    "'" . $headerName . "', " .
                    "'" . $headerValue . "'" .
                ')'
            );
        }
    }
}
