<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Block\Adminhtml\Enquiry\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\Exception\NoSuchEntityException;
use Jegan\Enquiry\Api\EnquiryRepositoryInterface;

/**
 * Class GenericButton
 *
 * @package Jegan\Enquiry\Block\Adminhtml\Enquiry\Edit
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected Context $context;

    /**
     * @var Registry
     */
    protected Registry $registry;

    /**
     * @var EnquiryRepositoryInterface
     */
    private EnquiryRepositoryInterface $_enquiryRepository;

    /**
     * GenericButton constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param EnquiryRepositoryInterface $enquiryRepository
     */
    public function __construct(
        Context $context,
        Registry $registry,
        EnquiryRepositoryInterface $enquiryRepository
    ) {
        $this->context = $context;
        $this->registry = $registry;
        $this->_enquiryRepository = $enquiryRepository;
    }

    /**
     * Return Enquiry ID
     *
     * @return null
     */
    public function getEnquiryId()
    {
        try {
            return $this->_enquiryRepository->getById(
                $this->context->getRequest()->getParam('enquiry_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
