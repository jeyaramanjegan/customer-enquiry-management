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
use Jegan\Enquiry\Model\Enquiry;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Jegan\Enquiry\Api\Data\EnquiryInterface;
use Jegan\Enquiry\Model\EnquiryFactory;
use Jegan\Enquiry\Api\EnquiryRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;

/**
 * Class Save
 *
 * @package Jegan\Enquiry\Controller\Adminhtml\Enquiry
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var EnquiryFactory|mixed
     */
    private $_enquiryFactory;

    /**
     * @var EnquiryRepositoryInterface
     */
    private $_enquiryRepository;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param EnquiryFactory|null $enquiryFactory
     * @param EnquiryRepositoryInterface|null $enquiryRepository
     */
    public function __construct(
        Action\Context $context,
        EnquiryFactory $enquiryFactory = null,
        EnquiryRepositoryInterface $enquiryRepository = null
    ) {
        $this->_enquiryFactory = $enquiryFactory ?: ObjectManager::getInstance()->get(EnquiryFactory::class);
        $this->_enquiryRepository = $enquiryRepository ?: ObjectManager::getInstance()->get(EnquiryRepositoryInterface::class);
        parent::__construct($context);
    }

    /**
     * execute to save the enquiry
     *
     * @return Redirect|ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var Enquiry $model */
            $model = $this->_enquiryFactory->create();
            $data = array_filter($data, function($value) {
                return $value !== '';
            });
            $model->setData($data);
            try {
                $this->_enquiryRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the enquiry.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['enquiry_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the page.'));
            }
            return $resultRedirect->setPath('*/*/edit', ['enquiry_id' => $this->getRequest()->getParam('enquiry_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

