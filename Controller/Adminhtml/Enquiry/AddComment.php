<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Controller\Adminhtml\Enquiry;

use Jegan\Enquiry\Api\EnquiryRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Jegan\Enquiry\Model\EnquiryFactory;
use Jegan\Enquiry\Model\MailInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

/**
 * Class AddComment
 *
 * @package Jegan\Enquiry\Controller\Adminhtml\Enquiry
 */
class AddComment extends Action implements HttpPostActionInterface
{
    const ENQUIRY_STATUS = 1;

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected JsonFactory $resultJsonFactory;

    /**
     * @var RawFactory
     */
    protected RawFactory $resultRawFactory;

    /**
     * @var EnquiryFactory|mixed
     */
    private $_enquiryFactory;

    /**
     * @var EnquiryRepositoryInterface
     */
    private EnquiryRepositoryInterface $_enquiryRepository;

    /**
     * @var MailInterface
     */
    private MailInterface $mail;

    /**
     * @var mixed|LoggerInterface
     */
    private $logger;

    /**
     * AddComment constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     * @param RawFactory $resultRawFactory
     * @param EnquiryFactory $enquiryFactory
     * @param MailInterface $mail
     * @param DataPersistorInterface $dataPersistor
     * @param EnquiryRepositoryInterface $enquiryRepository
     * @param LoggerInterface|null $logger
     */

    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                JsonFactory $resultJsonFactory,
                                RawFactory $resultRawFactory,
                                EnquiryFactory $enquiryFactory,
                                MailInterface $mail,
                                DataPersistorInterface $dataPersistor,
                                EnquiryRepositoryInterface $enquiryRepository,
                                LoggerInterface $logger = null
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->_enquiryFactory = $enquiryFactory;
        $this->_enquiryRepository = $enquiryRepository;
        $this->dataPersistor = $dataPersistor;
        $this->mail = $mail;
        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
        parent::__construct($context);
    }

    /**
     * Execute the admin comment to E-mail
     *
     * @return ResponseInterface|ResultInterface|void
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->getRequest()->setParam('enquiry_id', $this->getRequest()->getParam('id'));
        $data = $this->getRequest()->getPostValue();
        if (empty($data['admin_comment'])) {
            throw new LocalizedException(__('The comment is missing. Enter and try again.'));
        }
        if ($data){
            $model = $this->_enquiryFactory->create();
            $data = array_filter($data, function($value) {
                return $value !== '';
            });
            $model->setData($data);
            try {
                $this->_enquiryRepository->save($model);
                $this->sendEmail($this->validatedParams());
                $this->setEmailStatus($model);
                $this->messageManager->addSuccessMessage(
                    __('E-Mail has been sent to the Enquiry')
                );
                $this->dataPersistor->clear('enquiry');
            }catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (Exception $e) {
                $this->logger->critical($e);
                $this->messageManager->addErrorMessage(__('An error occurred while send your data. Please try again later.'));
                $this->dataPersistor->set('enquiry', $this->getRequest()->getParams());
            }
        }
    }

    /**
     * Post data from contact enquiry
     *
     * @param array $post
     */
    private function sendEmail(array $post)
    {
        $eMail = $this->_enquiryRepository->getById($post['enquiry_id'])->getEmail();
        $this->mail->send(
            $eMail,
            ['data' => new DataObject($post)]
        );
    }

    /**
     * Validate params
     *
     * @return array
     * @throws LocalizedException
     */
    private function validatedParams(): array
    {
        $request = $this->getRequest();
        if (trim($request->getParam('admin_comment')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        return $request->getParams();
    }

    /**
     * Update enquiry status
     *
     * @param $data
     */
    public function setEmailStatus($data){
        if ($data) {
            if (self::ENQUIRY_STATUS != $data->getStatus())
            {
                $data->setStatus(self::ENQUIRY_STATUS);
                $data->save();
            }
        }
    }
}
