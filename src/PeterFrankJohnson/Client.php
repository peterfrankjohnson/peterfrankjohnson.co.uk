<?php
// src/PeterFrankJohnson/Client.php
/**
 * @Entity @Table(name="clients")
 **/
class Client {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $ip;
    /** @Column(type="string") **/
    protected $x_forwarded_for;
    /** @Column(type="string") **/
    protected $remote_addr;

    public function __construct() {
// X-Forwarded-For can be faked.
// How do we test this? Traceroute?
// 
// Can we test anything in real-time?
//
// We are storing both values so that they can be checked somehow later on.
//
// http://stackoverflow.com/questions/3003145/how-to-get-client-ip-address-in-php
        if(isset($_SERVER['X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['X_FORWARDED_FOR'];
            $this->x_forwarded_for = $_SERVER['X_FORWARDED_FOR'];
            $this->remote_addr = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }

// Store for later, just incase.
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $this->remote_addr = $_SERVER['REMOTE_ADDR'];
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getXForwardedFor()
    {
        return $this->x_forwarded_for;
    }
    public function getRemoteAddr()
    {
        return $this->remote_addr;
    }

}