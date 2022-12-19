<?php

namespace Magento\PreOrderTask\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;
    
    /**
     * @param Context     $context
     * @param PageFactory $rawFactory
     */
    public function __construct(
        Context $context,
        PageFactory $rawFactory
    ) {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }
    /**
     * Title declaration
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Magento_PreOrderTask::manager');
        $resultPage->getConfig()->getTitle()->prepend(__('PreOrder Sales'));

        return $resultPage;
    }
}
