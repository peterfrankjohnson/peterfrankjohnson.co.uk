<?php

class Database extends SQLite3
{
    function __construct()
    {
        $this->open('mysqlitedb.db');
    }
}

$database = new Database();
$database->exec(
    'CREATE TABLE IF NOT EXISTS request (
        id INTEGER PRIMARY KEY,
        method STRING,
        uri STRING
    )'
);
$database->exec(
    'CREATE TABLE IF NOT EXISTS request_header (
        id INTEGER PRIMARY KEY,
        request_id INTEGER,
        header STRING
    )'
);
$database->exec(
    'INSERT INTO request VALUES(
        NULL, ' .
        "'" . $_SERVER['REQUEST_METHOD'] . "', " .
        "'" . $_SERVER['REQUEST_URI'] . "'" .
    ')'
);

$requestId = $database->lastInsertRowId();
$database->exec(
    'INSERT INTO request_header VALUES( ' .
        'NULL, ' .
        $requestId . ', ' .
        "'" . $_SERVER['HTTP_COOKIE'] . "'" .
    ')'
);

?>
<table>
<tr>
<th>ID</th><th>Method</th><th>Uri</th>
</tr>
<?php
$results = $database->query('SELECT * FROM request');
while ($row = $results->fetchArray()) {
?>
<tr>
<td><?= $row['id'] ?></td><td><?= $row['method'] ?></td><td><?= $row['uri']?></td>

</tr>
<?php
}
?>
</table>
