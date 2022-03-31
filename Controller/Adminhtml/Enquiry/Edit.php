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
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Jegan\Enquiry\Model\Enquiry;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Backend\App\Action\Context;

/**
 * Class Edit
 *
 * @package Jegan\Enquiry\Controller\Adminhtml\Enquiry
 */
class Edit extends Action implements HttpGetActionInterface
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
     * Edit constructor.
     *
     * @param Context $context
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
     * @return Page
     */
    protected function _initAction(): Page
    {
        // load layout, set active menu and breadcrumbs
        /** @var Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Jegan_Enquiry::enquiry')
            ->addBreadcrumb(__('Enquiry'), __('Enquiry'))
            ->addBreadcrumb(__('Manage Enquiry'), __('Manage Enquiry'));
        return $resultPage;
    }

    /**
     * @return Page|Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('enquiry_id');
        $model = $this->_objectManager->create(Enquiry::class);

        // 2. Initial checking
        if ($id) {
          $model->load($id);
            if (!$model->getId()) {

                $this->messageManager->addErrorMessage(__('This enquiry no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('enquiry', $model);

        // 5. Build edit form
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Enquiry') : __('New Enquiry'),
            $id ? __('Edit Enquiry') : __('New Enquiry')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Enquiry'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Enquiry'));

        return $resultPage;
    }
}
