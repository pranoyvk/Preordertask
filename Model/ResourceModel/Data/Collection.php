<?php

namespace Magento\PreOrderTask\Model\ResourceModel\Data;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('Magento\PreOrderTask\Model\Data', 'Magento\PreOrderTask\Model\ResourceModel\Data');
    }
}