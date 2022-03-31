<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Api\Data;

/**
 * Interface EnquiryInterface
 * @package Jegan\Enquiry\Api\Data
 */
interface EnquiryInterface
{
    const ENQUIRY_ID    = 'enquiry_id';
    const NAME          = 'name';
    const EMAIL         = 'email';
    const TELEPHONE     = 'telephone';
    const COMMENT       = 'comment';

    /**
     * Get ID
     *
     * @return mixed
     */
    public function getId();

    /**
     * Get name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Get email
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Get telephone
     *
     * @return mixed
     */
    public function getTelephone();

    /**
     * Get comment
     *
     * @return mixed
     */
    public function getComment();

    /**
     * Set ID
     *
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * Set email
     *
     * @param $email
     * @return mixed
     */
    public function setEmail($email);

    /**
     * Set telephone
     *
     * @param $telephone
     * @return mixed
     */
    public function setTelephone($telephone);

    /**
     * Set comment
     *
     * @param $comment
     * @return mixed
     */
    public function setComment($comment);
}
