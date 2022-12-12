<?php

namespace Magento\PreOrderTask\Controller\Adminhtml\Mail;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\PreOrderTask\Helper\Mail;

class Cancel extends Action
{
    /**
     * Page Factory apply
     *
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * Mail function
     *
     * @var Mail
     */
    protected $helperMail;

    /**
     * Mail function
     *
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * Http function
     *
     * @var Http
     */
    protected $request;
    
    /**
     * Http function
     *
     * @var Http
     */
    protected $model;

    /**
     * Http function
     *
     * @var Http
     */
    protected $resource;

    /**
     * Constructor Injuction
     *
     * @param Context $context
     * @param PageFactory $rawFactory
     * @param Mail $helperMail
     * @param ResultFactory $resultFactory
     * @param Http $request
     * @param DataFactory $model
     * @param ResourceConnection $resource
     */

    public function __construct(
        Context $context,
        PageFactory $rawFactory,
        Mail $helperMail,
        ResultFactory $resultFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\PreOrderTask\Model\DataFactory $model,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->pageFactory = $rawFactory;
        $this->helperMail = $helperMail;
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->model = $model;
        $this->resource = $resource;
        parent::__construct($context);
    }

    /**
     * Controler execute method
     *
     * @return @var
     */
    
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $this->helperMail->sendEmail($this->getEmail(), 'cancelled');
        $this->messageManager->addSuccessMessage("Email send successfully");
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setPath('order');
        return $redirect;
    }

    /**
     * Controler execute method
     *
     * @return string
     */
    private function getEmail()
    {
          $data = $this->getOrder();
          return $data->getData()['email'];
    }

    /**
     *  Data
     *
     * @return @var
     */

    private function getOrder()
    {
        return $this->model->create()->load($this->request->getParam('id'));
    }
}
