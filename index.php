<?php

ini_set('display_errors',  true);
ini_set('error_reporting', E_ALL);

define('ROBOTS_TXT',       '/robots.txt' );
define('SITEMAPS_ORG_XML', '/sitemap.xml');
define('DOMAIN',           'peterfrankjohnson.co.uk');
define('HOSTNAME',         'www.peterfrankjohnson.co.uk');
define('GOOGLE_WMT_CODE',  '8a5687b63d43957f');
define('GOOGLE_WMT_FILE',  '/google' . GOOGLE_WMT_CODE . '.html');

$hosts = array ( 'www.peterfrankjohnson.co.uk', 'peterfrankjohnson.co.uk', '127.0.0.1' )

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

// 1. Check URI (If full URL then agent is trying to use server as a proxy. We then return 400 - Bad Request)
// 2. Check Method, if method is not allowed e.g GET on a POST form then return 405 - Method not allowed.
// 3. Check Accept, Accept-Encoding, etc.. If the agent does not allow identity and also does not specify an alternative then we return 406 - Not Acceptable
// 4. Check security. Is Authentication required for the given URI, if so is the client authenticated. Return

// Proxy Request
if ((substr($requestUri, 0, strlen('http://')) == 'http://') OR (substr($requestUri, 0, strlen('https://')) == 'https://')) {
// Return 400 - Bad Request
	http_response_code(400);
}

// if ( ! in_array ( $hosts, Request::Header ( 'Host' ) ) ) {
//	http_response_code(400);
//}

// Check Method
// if () {
//	http_response_code(405);
// }

// Content Negotiation
// if ( Request::Header('Accept') == '*;q=0' ) {
// Return 406 - Not Acceptable
//	http_response_code(406);
//}

switch($requestUri) {
	case GOOGLE_WMT_FILE: {
		header('Content-Type: text/html');
                print 'google-site-verification: google' . GOOGLE_WMT_CODE . '.html';
		break;
	}
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
        header('Content-Type: text/xml; charset=utf-8');
  		print <<<END
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
END;

        foreach($urls as $url) {
            print '    <url>';
            print '        <loc>' . $url . '</loc>';
            print '    </url>';
        }

		print <<<END
</urlset>
END;
        break;
    }

    case '/': {
    	header ('Content-Type: text/html; charset=utf-8');
    	print <<<END
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Peter Frank Johnson's Domain</title>
		<style type="text/css">
@media all {
	body {
		background-color:#000;
		border:0;
		color:#f0f0f0;
		margin:0;
		padding:0;
	}

	pre {
		font-family: monospace;
		margin-left: auto;
		margin-right: auto;
		width: 96%;
		font-size: 150%;
	}
}
		</style>
	</head>
	<body>
		<pre>
================================================================================
 peterfrankjohnson.co.uk
================================================================================

 ADA OS
--------

 ADA Compiler
--------------

 ADA Debugger
--------------
		</pre>
	</body>
</html>
END;
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

    case '/admin/requests': {
    	require_once('www/admin/requests.php');
    	break;
    }

    default: {
        header('HTTP/1.0 404 Not Found');
        break;
    }
}
