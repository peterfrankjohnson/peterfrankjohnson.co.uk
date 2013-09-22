<?php
// src/PeterFrankJohnson/Response.php
/**
 * @Entity @Table(name="response")
 **/
class Response
{
    /** @Id @Column(type="integer") @GeneratedValue **/
	public $id;
	/** @Column(type="integer") */
	public $request_id;
	/** @Column(type="integer") */
	public $code;
	/** @Column(type="integer") */
	public $protocol;

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
    	return $this->response_code;
    }

	public function setCode($response_code)
	{
		$this->response_code = $response_code;
	}

    public function getProtocol()
    {
    	return $this->protocol;
    }

	public function setProtocol($protocol)
	{
		$this->protocol = $protocol;
	}
}