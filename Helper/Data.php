<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Helper;

use Jegan\Enquiry\Model\ConfigInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\View as CustomerViewHelper;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Enquiry base helper
 *
 * Class Data
 * @package Jegan\Enquiry\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = ConfigInterface::XML_PATH_ENABLED;

    /**
     * Customer session
     *
     * @var Session
     */
    protected Session $_customerSession;

    /**
     * @var CustomerViewHelper
     */
    protected CustomerViewHelper $_customerViewHelper;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $postData = null;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerViewHelper $customerViewHelper
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        CustomerViewHelper $customerViewHelper
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerViewHelper = $customerViewHelper;
        parent::__construct($context);
    }

    /**
     * Check if enabled
     *
     * @return mixed
     */
    public function isEnabled(): mixed
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName(): string
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return '';
        }
        $customer = $this->_customerSession->getCustomerDataObject();
        return trim($this->_customerViewHelper->getCustomerName($customer));
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getUserEmail(): string
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return '';
        }
        $customer = $this->_customerSession->getCustomerDataObject();
        return $customer->getEmail();
    }

    /**
     * Get value from POST by key
     *
     * @param string $key
     * @return string
     */
    public function getPostValue(string $key): string
    {
        if (null === $this->postData) {
            $this->postData = (array) $this->getDataPersistor()->get('enquiry');
            $this->getDataPersistor()->clear('enquiry');
        }
        if (isset($this->postData[$key])) {
            return (string) $this->postData[$key];
        }
        return '';
    }

    /**
     * Get Data Persistor
     *
     * @return DataPersistorInterface
     */
    private function getDataPersistor(): DataPersistorInterface
    {
        if ($this->dataPersistor === null) {
            $this->dataPersistor = ObjectManager::getInstance()
                ->get(DataPersistorInterface::class);
        }
        return $this->dataPersistor;
    }
}
