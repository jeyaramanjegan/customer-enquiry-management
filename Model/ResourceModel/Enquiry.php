<?php
/**
 * @copyright   Copyright 2022 © jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model\ResourceModel;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Enquiry
 *
 * @package Jegan\Enquiry\Model\ResourceModel
 */
class Enquiry extends AbstractDb
{
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManagerInterface;

    /**
     * Enquiry constructor.
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param null $connectionName
     */
    public function __construct(Context $context,  StoreManagerInterface $storeManager, $connectionName = null)
    {
        $this->storeManagerInterface = $storeManager;
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource
     */
    public function _construct()
    {
        $this->_init('enquirysaver_enquiries','enquiry_id');
    }

    /**
     * @param AbstractModel $object
     * @return Enquiry
     */
    protected function _beforeSave(AbstractModel $object): Enquiry
    {
        try {
            $object->setStoreId($this->storeManagerInterface->getStore()->getId());
        } catch (NoSuchEntityException $e) {
        }
        return parent::_beforeSave($object);
    }
}
