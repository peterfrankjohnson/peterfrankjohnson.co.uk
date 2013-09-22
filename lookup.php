<?php

// This needs to be implemented as a worker process.
// This does not need to be done whilst the page is loading, it can be a queued job or a cronjob.

// Also create a similar script to do this with Geocoding IP's of Clients to see where the visitors are coming from.

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

/*
$ip = '123.125.66.120';  // Baidu
$ip = '65.55.211.186';   // MSNbot
*/
$ip = '66.249.66.1';     // Googlebot

// Reverse Lookup of IP Address and determine Hostname
$hostname = gethostbyaddr ($ip);
if($hostname and ($hostname != $ip)) {
    $hostname_parts = explode ('.', $hostname);

    $tld = array_pop($hostname_parts);

    switch ($tld) {
        case 'ru':
        case 'org':
        case 'net':
        case 'com': {
            $host = array_pop($hostname_parts);
            break;
        }

        case 'uk': {
            $tld = array_pop($hostname_parts) . "." . $tld;
            $host = array_pop($hostname_parts);
        }
    }

    switch ($host) {

        case 'baidu': {
            print "Baiduspider\n";
            break;
        }

        case 'bing': {
            print "Bingbot\n";
            break;
        }

        case 'googlebot': {
            print "Googlebot\n";
            break;
        }

        case 'msn': {
            print "MSNbot\n";
            break;
        }

        case 'yandex': {
            print "Yandexbot\n";
            break;
        }

        default: {
            print "Error$%^$!";
            break;
        }
    }

// Forward Lookup - Resolve Hostname to IP Address and Check against original IP

// PHP is slow at doing this.
// Google example uses host program, this is much quicker.
// https://support.google.com/webmasters/answer/80553?hl=en

    if (gethostbyname ($hostname) == $ip) {
        print "Robot has been successfully verified!\n";
    }
}

