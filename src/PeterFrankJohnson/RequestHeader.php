<?php
// src/PeterFrankJohnson/RequestHeader.php
/**
 * @Entity @Table(name="request_header")
 **/
class RequestHeader
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    public $id;
    /** @Column(type="integer") **/
    protected $request_id;
    /** @Column(type="integer") **/
    protected $field_name_id;
    /** @Column(type="integer") **/
    protected $field_value_id;

    public function getId()
    {
    	return $this->id;
    }

    public function setFieldName($fieldName)
    {

    }

    public function setFieldValue($fieldValue)
    {

    }
}