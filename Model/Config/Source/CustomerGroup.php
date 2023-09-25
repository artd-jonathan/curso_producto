<?php
namespace Curso\Producto\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class CustomerGroup implements OptionSourceInterface
{
    protected $_groupCollectionFactory;

    public function __construct(\Magento\Customer\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory)
    {
        $this->_groupCollectionFactory = $groupCollectionFactory;
    }
    /**
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $options = $this->_groupCollectionFactory->create()->toOptionArray();
        return $options;
    }
}