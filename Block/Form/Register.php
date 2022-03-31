<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Block\Form;

use Magento\Framework\View\Element\Template;

/**
 * Class Register
 *
 * @package Jegan\Enquiry\Block\Form
 */
class Register extends Template
{
    /**
     * Register constructor.
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    /**
     * Returns action url for enquiry form
     *
     * @return string
     */
    public function getFormAction(): string
    {
        return $this->getUrl('enquiry/index/post', ['_secure' => true]);
    }
}
