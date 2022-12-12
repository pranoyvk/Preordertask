<?php
namespace Magento\PreOrderTask\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Data extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('PreOrder_Table', 'id');
    }
}
