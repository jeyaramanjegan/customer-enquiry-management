<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Block\Adminhtml\Enquiry\Comment;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Template;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Jegan\Enquiry\Api\EnquiryRepositoryInterface;

/**
 * Class Reply
 *
 * @package Jegan\Enquiry\Block\Adminhtml\Enquiry\Comment
 */
class Reply extends Template{

    /**
     * @var Context
     */
    private Context $context;
    /**
     * @var EnquiryRepositoryInterface
     */
    private EnquiryRepositoryInterface $_enquiryRepository;

    public function __construct(Template\Context $context,
                                Context $contexts,
                                EnquiryRepositoryInterface $enquiryRepository,
                                array $data = [],
                                ?JsonHelper $jsonHelper = null,
                                ?DirectoryHelper $directoryHelper = null)
    {
        $this->context = $contexts;
        $this->_enquiryRepository = $enquiryRepository;
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
    }

    /**
     *  Preparing global layout
     *
     * @return Reply
     */
    protected function _prepareLayout(): Reply
    {
        $this->addChild(
            'submit_button',
            \Magento\Backend\Block\Widget\Button::class,
            [
                'id' => 'submit_comment_button',
                'label' => __('Send Comment by Email'),
                'class' => 'action-secondary save'
            ]
        );
        return parent::_prepareLayout();
    }


    /**
     * Get submit url
     *
     * @return string
     */
    public function getSubmitUrl(): string
    {
        return $this->getUrl('*/*/addComment', ['id' => $this->_enquiryRepository->getById(
            $this->context->getRequest()->getParam('enquiry_id')
        )->getId()]);
    }

    /**
     * Get return url
     *
     * @return string
     */
    public function getReturnUrl(): string
    {
        return $this->getUrl('enquiry/enquiry/reply', ['enquiry_id' => $this->_enquiryRepository->getById(
            $this->context->getRequest()->getParam('enquiry_id')
        )->getId(), '_current' => true]);
    }
}
