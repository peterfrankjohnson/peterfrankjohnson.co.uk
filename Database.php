<?php

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

$database = new Database();

$database->exec(
    'CREATE TABLE IF NOT EXISTS request (
        id INTEGER PRIMARY KEY,
        method STRING,
        uri STRING,
        query STRING,
        protocol STRING,
        time INTEGER
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
$database->exec(
    'INSERT INTO request VALUES(
        NULL, ' .
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