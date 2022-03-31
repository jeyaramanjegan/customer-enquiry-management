<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model;

/**
 * Interface MailInterface
 *
 * @package Jegan\Enquiry\Model
 */
interface MailInterface
{
    /**
     * Send email from enquiry form
     *
     * @param $replyTo
     * @param array $variables
     * @return mixed
     */
    public function send($replyTo, array $variables);
}
