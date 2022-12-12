<?php

namespace Magento\PreOrderTask\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

class Mail extends AbstractHelper
{

    /**
     * TransportBuilder apply
     *
     * @var TransportBuilder
     */

    protected $transportBuilder;

    /**
     * StoreManagerInterface apply
     *
     * @var StoreManagerInterface
     */

    protected $storeManager;

    /**
     * StateInterface apply
     *
     * @var StateInterface
     */

    protected $inlineTranslation;

    /**
     * Constructor Injuction
     *
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $state
     */

    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        parent::__construct($context);
    }
    /**
     * Send mail
     *
     * @param string $email
     * @param string $action
     */

    public function sendEmail($email, $action)
    {
        // this is an example and you can change template id,fromEmail,toEmail,etc as per your need.
        $templateId = 'email_cancel_template'; // template id
        $fromEmail = 'sales@example.com';  // sender Email id
        $fromName = 'Admin';             // sender Name
        $toEmail = $email; // receiver email id

        try {
            // template variables pass here
            $templateVars = [
                'status' => $action
            ];
                $postObject = new \Magento\Framework\DataObject();
                $postObject->setData($templateVars);
            $storeId = $this->storeManager->getStore()->getId();

            $from = ['email' => $fromEmail, 'name' => $fromName];
            $this->inlineTranslation->suspend();

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $storeId
            ];
            $transport = $this->transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($from)
                ->addTo($toEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }
}
