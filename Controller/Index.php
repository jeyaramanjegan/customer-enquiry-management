<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Controller;

use Jegan\Enquiry\Model\ConfigInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Class Index
 *
 * @package Jegan\Enquiry\Controller
 */
abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_RECIPIENT = ConfigInterface::XML_PATH_EMAIL_RECIPIENT;

    /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER = ConfigInterface::XML_PATH_EMAIL_SENDER;

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_TEMPLATE = ConfigInterface::XML_PATH_EMAIL_TEMPLATE;

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_COMMENT_TEMPLATE = ConfigInterface::XML_PATH_EMAIL_COMMENT_TEMPLATE;

    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = ConfigInterface::XML_PATH_ENABLED;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $contactsConfig;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param ConfigInterface $contactsConfig
     */
    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig
    ) {
        parent::__construct($context);
        $this->contactsConfig = $contactsConfig;
    }

    /**
     *  Dispatch request
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->contactsConfig->isEnabled()) {
            throw new NotFoundException(__('Page not found.'));
        }
        return parent::dispatch($request);
    }
}
