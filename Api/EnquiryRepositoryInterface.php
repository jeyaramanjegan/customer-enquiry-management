<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Api;

use Jegan\Enquiry\Api\Data\EnquiryInterface;

/**
 * Interface EnquiryRepositoryInterface
 *
 * @package Jegan\Enquiry\Api
 */
interface EnquiryRepositoryInterface
{
    /**
     * Save enquiry.
     *
     * @param EnquiryInterface $enquiry
     * @return mixed
     */
    public function save(EnquiryInterface $enquiry);

    /**
     *  Retrieve enquiry.
     *
     * @param $enquiryId
     * @return mixed
     */
    public function getById($enquiryId);

    /**
     * Delete enquiry.
     *
     * @param EnquiryInterface $enquiry
     * @return bool
     */
    public function delete(EnquiryInterface $enquiry);

    /**
     * Delete enquiry by ID.
     *
     * @param $enquiryId
     * @return bool
     */
    public function deleteById($enquiryId);
}
