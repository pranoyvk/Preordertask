<?php

namespace Magento\PreOrderTask\Model;

use Magento\Framework\Model\AbstractModel;

class Data extends AbstractModel
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('Magento\PreOrderTask\Model\ResourceModel\Data');
    }
}
