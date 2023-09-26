<?php
namespace Curso\Producto\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_CUSTOM_SECTION = 'curso_producto';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOM_SECTION . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getValueType($storeId = null)
    {
        return $this->getConfigValue('/general/value_type', $storeId);
    }

    public function getCustomValue($storeId = null)
    {
        return $this->getConfigValue('/general/custom_value', $storeId);
    }

    public function getValueIncrement($storeId = null)
    {
        return $this->getConfigValue('/general/value_increment', $storeId);
    }

    public function getCustomGroups($storeId = null)
    {
        return $this->getConfigValue('/general/custom_groups', $storeId);
    }

}