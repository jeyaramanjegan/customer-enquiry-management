<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Controller\Adminhtml\Enquiry;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Jegan\Enquiry\Model\Enquiry;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

/**
 * PHP version 7.4
 * Class Reply
 * @package Jegan\Enquiry\Controller\Adminhtml\Enquiry
 */
class Reply extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $_resultPageFactory;

    /**
     * @var Registry
     */
    protected Registry $_coreRegistry;

    /**
     * Reply constructor.
     * @param Action\Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * load layout, set active menu and breadcrumbs
     *
     * @return Page
     */
    protected function _initAction(): Page
    {
        /** @var Page $resultPage */

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Jegan_Enquiry::enquiry')
            ->addBreadcrumb(__('Enquiry'), __('Enquiry'))
            ->addBreadcrumb(__('Manage Enquiry'), __('Manage Enquiry'));
        return $resultPage;
    }

    /**
     * Enquiry reply form action
     *
     * @return Page
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('enquiry_id');
        $model = $this->_objectManager->create(Enquiry::class);

        $this->_coreRegistry->register('enquiry', $model);

        // 5. Build Reply form
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Reply Enquiry') : __(''),
            $id ? __('Reply Enquiry') : __('')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Enquiry'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Reply Enquiry'));
        return $resultPage;
    }
}
