<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Jegan\Enquiry\Api\Data\EnquiryInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;

/**
 * Class Enquiry
 *
 * @package Jegan\Enquiry\Model
 */
class Enquiry extends AbstractModel implements EnquiryInterface
{
    const KEY_ID = 'enquiry_id';
    const CACHE_TAG = 'enquirysaver_enquiries';

    /**
     * Enquiry constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(Context $context,
                                Registry $registry,
                                AbstractResource $resource = null,
                                AbstractDb $resourceCollection = null,
                                array $data = [])
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource
     */
    public function _construct()
   {
       $this->_init(\Jegan\Enquiry\Model\ResourceModel\Enquiry::class);
       parent::_construct();
   }

    /**
     * Get cache identities
     *
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get name
     *
     * @return array|mixed|null
     */
    public function getName()
    {
        return $this->getData(EnquiryInterface::NAME);
    }

    /**
     * Set name
     *
     * @param $name
     * @return Enquiry|mixed
     */
    public function setName($name)
    {
        return $this->setData(EnquiryInterface::NAME, $name);
    }

    /**
     * Get email
     *
     * @return array|mixed|null
     */
    public function getEmail()
    {
        return $this->getData(EnquiryInterface::EMAIL);
    }

    /**
     * Set email
     *
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData(EnquiryInterface::EMAIL, $email);
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->getData(EnquiryInterface::TELEPHONE);
    }

    /**
     * Set telephone
     *
     * @param $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        return $this->setData(EnquiryInterface::TELEPHONE, $telephone);
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->getData(EnquiryInterface::COMMENT);
    }

    /**
     * Set comment
     *
     * @param $comment
     * @return $this
     */
    public function setComment($comment)
    {
        return $this->setData(EnquiryInterface::COMMENT, $comment);
    }
}
