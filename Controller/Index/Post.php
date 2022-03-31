<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Jegan\Enquiry\Model\ConfigInterface;
use Jegan\Enquiry\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Jegan\Enquiry\Model\Enquiry;
use Jegan\Enquiry\Model\EnquiryFactory;
use Jegan\Enquiry\Api\EnquiryRepositoryInterface;

class Post extends \Jegan\Enquiry\Controller\Index implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var
     */
    private Enquiry $model;

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @var MailInterface
     */
    private MailInterface $mail;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EnquiryFactory|mixed
     */
    private $_enquiryFactory;

    /**
     * @var EnquiryRepositoryInterface
     */
    private $_enquiryRepository;


    /**
     * Post constructor.
     *
     * @param Context $context
     * @param ConfigInterface $contactsConfig
     * @param Enquiry $model
     * @param MailInterface $mail
     * @param EnquiryFactory|null $enquiryFactory
     * @param EnquiryRepositoryInterface|null $enquiryRepository
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        Enquiry $model,
        MailInterface $mail,
        EnquiryFactory $enquiryFactory = null,
        EnquiryRepositoryInterface $enquiryRepository = null,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger = null
    ) {
        parent::__construct($context, $contactsConfig);
        $this->_enquiryFactory = $enquiryFactory ?: ObjectManager::getInstance()->get(EnquiryFactory::class);
        $this->_enquiryRepository = $enquiryRepository ?: ObjectManager::getInstance()->get(EnquiryRepositoryInterface::class);
        $this->context = $context;
        $this->mail = $mail;
        $this->model = $model;
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
    }

    /**
     *  Post user question
     *
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $request = $this->getRequest()->getPostValue();
        if ($request) {
            /** @var Enquiry $model*/
            $model = $this->_enquiryFactory->create();
            $model->setData($request);
            try {
                $this->_enquiryRepository->save($model);
                $this->sendEmail($this->validatedParams());
                $this->messageManager->addSuccessMessage(
                    __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
                );
                $this->dataPersistor->clear('enquiry');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->dataPersistor->set('enquiry', $this->getRequest()->getParams());
            } catch (\Exception $e) {
                $this->logger->critical($e);
                $this->messageManager->addErrorMessage(
                    __('An error occurred while processing your form. Please try again later.')
                );
                $this->dataPersistor->set('enquiry', $this->getRequest()->getParams());
            }
        }
        return $this->resultRedirectFactory->create()->setPath('enquiry/index');
    }

    /**
     * @param array $post Post data from contact form
     * @return void
     */
    private function sendEmail(array $post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    private function validatedParams(): array
    {
        $request = $this->getRequest();
        if (trim($request->getParam('name')) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($request->getParam('telephone')) === '') {
            throw new LocalizedException(__('Enter the telephone and try again.'));
        }
        if (false === \strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }
        if (trim($request->getParam('comment')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (trim($request->getParam('hideit')) !== '') {
            throw new \Exception();
        }

        return $request->getParams();
    }
}
