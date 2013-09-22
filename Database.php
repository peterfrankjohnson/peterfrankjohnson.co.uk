<?php

/*

require_once('opsworks.php');
$opsworks = new OpsWorks();
$database = $opsworks->db;

    $database->host,
    $database->username,
    $database->password,
    $database->database,
    3306

unset($opsworks);

*/


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
            'SELECT * FROM request_header WHERE name = :name and value = :value'
        );
        $statement->bindValue(':name', $headerName);
        $statement->bindValue(':value', $headerValue);
        $result = $statement->execute();
        if($result) {
            $row = $result->fetchArray();
            $headerId = $row['id'];
        } elseif ($headerId == '') {
            $database->exec(
                'INSERT INTO request_header VALUES( ' .
                    'NULL, ' .
                    "'" . $headerName . "', " .
                    "'" . $headerValue . "'" .
                ' );'
            );
            $headerId = $database->lastInsertRowId();
        }
        $database->exec(
            'INSERT INTO request_has_request_header VALUES( ' .
                'NULL, ' .
                $requestId . ',' .
                $headerId .
            ' );'
        );
    }
}
