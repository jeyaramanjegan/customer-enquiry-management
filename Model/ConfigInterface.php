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
 * Interface ConfigInterface
 *
 * @package Jegan\Enquiry\Model
 */
interface ConfigInterface
{
    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_RECIPIENT = 'enquiry/email/recipient_email';

    /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER = 'enquiry/email/sender_email_identity';

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_TEMPLATE = 'enquiry/email/email_template';

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_COMMENT_TEMPLATE = 'enquiry/email/email_comment_template';

    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = 'enquiry/enquiry/enabled';

    /**
     * Check if contacts module is enabled
     *
     * @return mixed
     */
    public function isEnabled();

    /**
     * Return email template identifier
     *
     * @return mixed
     */
    public function emailTemplate();

    /**
     * Return email Comment template
     *
     * @return mixed
     */
    public function emailCommentTemplate();

    /**
     * Return email sender address
     *
     * @return mixed
     */
    public function emailSender();

    /**
     * Return email recipient address
     *
     * @return mixed
     */
    public function emailRecipient();
}
