<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\ViewModel;

use Jegan\Enquiry\Helper\Data;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class UserDataProvider
 *
 * @package Jegan\Enquiry\ViewModel
 */
class UserDataProvider implements ArgumentInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * UserDataProvider constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->helper->getPostValue('name') ?: $this->helper->getUserName();
    }

    /**
     * Get user telephone
     *
     * @return string
     */
    public function getUserTelephone()
    {
        return $this->helper->getPostValue('telephone');
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->helper->getPostValue('email') ?: $this->helper->getUserEmail();
    }

    /**
     * Get user comment
     *
     * @return string
     */
    public function getUserComment()
    {
        return $this->helper->getPostValue('comment');
    }
}
