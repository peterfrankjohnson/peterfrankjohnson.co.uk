<?php

ini_set('display_errors',  true);
ini_set('error_reporting', E_ALL);

define('ROBOTS_TXT',       '/robots.txt' );
define('SITEMAPS_ORG_XML', '/sitemap.xml');
define('DOMAIN',           'peterfrankjohnson.co.uk');
define('HOSTNAME',         'www.peterfrankjohnson.co.uk');

require_once('Database.php');

function getCookie() {
    $cookie = null;
    if(isset($_SERVER['HTTP_COOKIE'])) {
        $cookie = $_SERVER['HTTP_COOKIE'];
    }
    return $cookie;
}

function createSession() {
    
}

function getSessionId() {
    $sessionId = null;

    $cookie = getCookie();

}

$requestUri = Request::Uri();

switch($requestUri) {
    case ROBOTS_TXT: {
        $url = HOSTNAME . SITEMAPS_ORG_XML;

  	header('Content-Type: text/plain');
  	print <<<END
Sitemap: http://$url

User-agent: *
Disallow:
END;
        unset($url);
  	break;
    }

    case SITEMAPS_ORG_XML: {
  	$urls = array (
            'http://' . HOSTNAME . '/',
            'http://' . HOSTNAME . '/test1',
            'http://' . HOSTNAME . '/test2',
            'http://' . HOSTNAME . '/test3'
        );
        header('Content-Type: text/xml');
  	print <<<END
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
END;

        foreach($urls as $url) {
            print '  <loc>' . $url . '</loc>';
        }

print <<<END
</urlset>
END;
        break;
    }

    case '/test1': {
        echo 'TEST 1';
  	break;
    }

    case '/test2': {
        echo 'TEST 2';
  	break;
    }

    case '/test3': {
        echo 'TEST 3';
  	break;
    }

    case '/': {
        $results = $database->query('SELECT * FROM request');
        if($results instanceof SQLite3Result) {
?>
<table>
    <tr>
        <th>ID</th>
        <th>Method</th>
        <th>Uri</th>
        <th>Query</th>
        <th>Protocol</th>
        <th>Time</th>
        <th>Headers</th>
    </tr>
<?php       while ($row = $results->fetchArray()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['method'] ?></td>
        <td><?= $row['uri']?></td>
        <td><?= $row['query']?></td>
        <td><?= $row['protocol']?></td>
        <td><?= $row['time']?></td>
        <td>
            <table>
<?php
                $statement = $database->prepare(
                    'SELECT * FROM request_header WHERE request_id=:id'
                );
                $statement->bindValue(':id', $row['id']);
                $result = $statement->execute();
                while ($row = $result->fetchArray()) {
?>
                <tr>
                    <td>
                        <pre><?= $row['name'] . ":" . $row['header'] ?></pre>
                    </td>
                </tr>
<?php           } ?>
            </table>
        </td>
    </tr>
<?php       } ?>
</table>
<?php
        } 
    break;
    }
    default: {
        header('HTTP/1.0 404 Not Found');
        break;
    }
}
