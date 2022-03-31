<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Controller\Adminhtml\Enquiry;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

/**
 * Class Index
 *
 * @package Jegan\Enquiry\Controller\Adminhtml\Enquiry
 */
class Index extends Action
{
    protected PageFactory $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        // TODO: Implement execute() method.
        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Jegan_Enquiry::enquiry_manage');
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Enquiry'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Customer Enquiry'), __('Customer Enquiry'));
        $resultPage->addBreadcrumb(__('Manage Enquiry'), __('Manage Enquiry'));

        return $resultPage;
    }
}
