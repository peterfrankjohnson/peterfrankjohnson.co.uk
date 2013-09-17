<?php

ini_set('display_errors',  true);
ini_set('error_reporting', E_ALL);

define('ROBOTS_TXT',       '/robots.txt' );
define('SITEMAPS_ORG_XML', '/sitemap.xml');
define('DOMAIN',           'peterfrankjohnson.co.uk');
define('HOSTNAME',         'www.peterfrankjohnson.co.uk');

// 1. Read all Request Data
//  - Method
//  - URI
//  - 

function getRequestUri() {
    $requestUri = null;
    if(isset($_SERVER['REQUEST_URI'])) {
        $requestUri = $_SERVER['REQUEST_URI'];
    }
    return $requestUri;
}

function getRequestMethod() {

}

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

$requestUri = getRequestUri();

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
	exit;
    	break;
    }
    case SITEMAPS_ORG_XML: {
        $urls = array (
            'http://' . HOSTNAME . '/',
            'http://' . HOSTNAME . '/test1',
            'http://' . HOSTNAME . '/test2',
            'http://' . HOSTNAME . '/test3'
        );
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
	exit;
        break;
    }

    case '/test1': {
        print <<<END
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Test 1</title>
    </head>
    <body>
        <p>Test 1</p>
    </body>
</html>
END;
	exit;
        break;
    }

    case '/test2': {
        print <<<END
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Test 2</title>
    </head>
    <body>
        <p>Test 2</p>
    </body>
</html>
END;
	exit;
        break;
    }

    case '/test3': {
        print <<<END
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Test 3</title>
    </head>
    <body>
        <p>Test 3</p>
    </body>
</html>
END;
	exit;
        break;
    }
}

require_once('Database.php');
