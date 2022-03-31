<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Index
 *
 * @package Jegan\Enquiry\Controller\Index
 */
class Index extends \Jegan\Enquiry\Controller\Index implements HttpGetActionInterface
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        // TODO: Implement execute() method.
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
