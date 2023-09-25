<?php
 
namespace Curso\Producto\Plugin\Model;
 
class Product
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $result += 10;
        return $result;
    }
}