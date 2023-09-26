<?php
 
namespace Curso\Producto\Plugin\Model;
 
class Product
{
    private $_logger;
    private $_helperData;
    private $_cart;

    /**Vars */
    private $_valueType;
    private $_customValue;
    private $_valueIncrement;
    private $_group;    

    /**
     * @var \Psr\Log\LoggerInterface
     * @var \Curso\Producto\Helper\Data
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Curso\Producto\Helper\Data $helperData,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Customer\Model\Session $customerSession

    ) {
        $this->_customerSession = $customerSession;
        $this->_logger = $logger;
        $this->_logger->info("Curso_ProduDatact: __construct");
        $this->_helperData = $helperData;
        $this->_cart = $cart;
        
        $this->_valueType = $this->_helperData->getValueType();
        $this->_customValue = $this->_helperData->getCustomValue();
        $this->_valueIncrement = $this->_helperData->getValueIncrement();
        $this->_customGroup = $this->_helperData->getCustomGroups();
        
        $this->_logger->info("Curso_Product _valueType:". $this->_valueType);
        $this->_logger->info("Curso_Product _customValue:". $this->_customValue);
        $this->_logger->info("Curso_Product _valueIncrement:". $this->_valueIncrement);
        $this->_logger->info("Curso_Product _group:". $this->_customGroup);
        
    }
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $customer =  $this->_cart->getQuote()->getCustomer();
        $customeGroup = $customer->getGroupId();
        if($customeGroup == null){
            $customeGroup = "0";
        }
        $customeGroup = $this->_customerSession->getCustomer()->getGroupId();
        if($this->_customGroup == null){
            return $result;
        }
        // Verify rules
        $groupIsGranted = $this->groupIsgranted($customeGroup, explode(",",$this->_customGroup));
        if(!$groupIsGranted){
            return $result;
        }
        // Value calculation
        $valuToOperate= $this->getValueToOperate($this->_valueType, $result);
        if($this->_valueIncrement){
            $result += $valuToOperate;
        }else{
            $result -= $valuToOperate;
        }
        return $result;
    }

    private function getValueToOperate($type, $productPrice){
        if($type == 'fixed'){
            return $this->_customValue;
        }else{
            return ($productPrice * $this->_customValue) / 100;
        }
    }

    private function groupIsgranted($currentCustomerGroup, $allowedGroups){
        $granted = false;
        foreach ($allowedGroups as $group) {
            if($group == $currentCustomerGroup){
                $granted = true;
            }
        }
        return $granted;
    }

}