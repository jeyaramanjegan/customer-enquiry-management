<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model\ResourceModel\Enquiry;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @package Jegan\Enquiry\Model\ResourceModel\Enquiry
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'enquiry_id';

    /**
     * Initialize resource
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init(\Jegan\Enquiry\Model\Enquiry::class, \Jegan\Enquiry\Model\ResourceModel\Enquiry::class);
    }
}
