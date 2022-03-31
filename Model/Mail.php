<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Area;

/**
 * Class Mail
 *
 * @package Jegan\Enquiry\Model
 */
class Mail implements MailInterface
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $contactsConfig;

    /**
     * @var TransportBuilder
     */
    private TransportBuilder $transportBuilder;

    /**
     * @var StateInterface
     */
    private StateInterface $inlineTranslation;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Mail constructor.
     *
     * @param ConfigInterface $contactsConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param StoreManagerInterface|null $storeManager
     */
    public function __construct(
        ConfigInterface $contactsConfig,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager = null
    ) {
        $this->contactsConfig = $contactsConfig;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager ?: ObjectManager::getInstance()->get(StoreManagerInterface::class);
    }

    /**
     * Send email from enquiry form
     *
     * @param string $replyTo
     * @param array $variables
     * @throws LocalizedException
     * @throws MailException
     * @throws NoSuchEntityException
     */
    public function send($replyTo, array $variables)
    {
        /** @see \Magento\Contact\Controller\Index\Post::validatedParams() */
        $replyToName = !empty($variables['data']['name']) ? $variables['data']['name'] : null;
        $this->inlineTranslation->suspend();
        try {
            if ($variables['data']['admin_comment']){
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($this->contactsConfig->emailCommentTemplate())
                    ->setTemplateOptions(
                        [
                            'area' => Area::AREA_FRONTEND,
                            'store' => $this->storeManager->getStore()->getId()
                        ]
                    )
                    ->setTemplateVars($variables)
                    ->setFrom($this->contactsConfig->emailSender())
                    ->addTo($replyTo)
                    ->getTransport();
            }
            else{
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier($this->contactsConfig->emailTemplate())
                    ->setTemplateOptions(
                        [
                            'area' => Area::AREA_FRONTEND,
                            'store' => $this->storeManager->getStore()->getId()
                        ]
                    )
                    ->setTemplateVars($variables)
                    ->setFrom($this->contactsConfig->emailSender())
                    ->addTo($this->contactsConfig->emailRecipient())
                    ->setReplyTo($replyTo, $replyToName)
                    ->getTransport();
            }
            $transport->sendMessage();
        } finally {
            $this->inlineTranslation->resume();
        }
    }
}
