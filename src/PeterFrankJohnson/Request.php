<?php
// src/PeterFrankJohnson/Request.php
/**
 * @Entity @Table(name="request")
 **/
class Request
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    public $id;
    /** @Column(type="integer") **/
    protected $client_id;    
    /** @Column(type="string") **/
    protected $method;
    /** @Column(type="string") **/
    protected $uri;
    /** @Column(type="string") **/
    protected $query_string;
    /** @Column(type="string") **/
    protected $protocol;
    /** @Column(type="datetime") **/
    protected $time;

    public function __construct() {
        if(isset($_SERVER['REQUEST_METHOD'])) {
            $this->method = $_SERVER['REQUEST_METHOD'];
        }
        if(isset($_SERVER['REQUEST_URI'])) {
            $this->uri = $_SERVER['REQUEST_URI'];
        }
        if(isset($_SERVER['QUERY_STRING'])) {
            $this->query_string = $_SERVER['QUERY_STRING'];
        }
        if(isset($_SERVER['SERVER_PROTOCOL'])) {
            $this->protocol = $_SERVER['SERVER_PROTOCOL'];
        }
        if(isset($_SERVER['REQUEST_TIME'])) {
            $this->time = $_SERVER['REQUEST_TIME'];
        }
        $this->save();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQueryString()
    {
        return $this->query_string;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function getTime()
    {
        return $this->time;
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