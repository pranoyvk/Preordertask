<?php

namespace Magento\PreOrderTask\Controller\Adminhtml\Mail;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\PreOrderTask\Helper\Mail;
use Magento\Framework\App\Request\Http;
use Magento\PreOrderTask\Model\DataFactory;
use Magento\Framework\App\ResourceConnection;

class Cancel extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var Mail
     */
    protected $helperMail;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Http
     */
    protected $request;
    
    /**
     * @var Http
     */
    protected $model;

    /**
     * @var Http
     */
    protected $resource;

    /**
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
        Http $request,
        DataFactory $model,
        ResourceConnection $resource
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
     * By using this method to send the mail
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
     *  To get the customer email
     *
     * @return string
     */
    private function getEmail()
    {
          $data = $this->getOrder();
          return $data->getData()['email'];
    }

    /**
     *  To load the particular row from the grid
     *
     * @return @var
     */

    private function getOrder()
    {
        return $this->model->create()->load($this->request->getParam('id'));
    }
}
