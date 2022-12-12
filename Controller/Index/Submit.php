<?php
 
namespace Magento\PreOrderTask\Controller\Index;
 
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\PreOrderTask\Model\DataFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
 
class Submit extends Action
{
    /**
     * Page Factory apply
     *
     * @var PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * Data Factory apply
     *
     * @var DataFactory
     */
    protected $_FormModel;

    /**
     * Constructor Injection
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Data $_FormModel
     */

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        DataFactory $_FormModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_FormModel = $_FormModel;
        parent::__construct($context);
    }

    /**
     * Controler execute method
     *
     * @return @var
     */

    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPost();
            if ($data) {
                $model = $this->_FormModel->create();
                $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("your PreOrder Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl('/');
        return $resultRedirect;
    }
}
