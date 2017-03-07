<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Model_Catalog_Product {

    const COLLECTION_LIMIT = 1000;

    public function getCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->joinField('is_in_stock', 'cataloginventory/stock_item', 'is_in_stock', 'product_id=entity_id', '{{table}}.stock_id=1', 'left')
                ->addAttributeToSelect(array('sku', 'name', 'description'))
                ->addAttributeToFilter('is_in_stock', array('neq' => 0))
                ->addAttributeToFilter(array(
				array(
					'attribute' => 'description',
					'neq' => '&nbsp;'),
				array(
					'attribute' => 'short_description',
					'neq' => '&nbsp;'),
			))
                ->addAttributeToFilter(array(
				array(
					'attribute' => 'description',
					'null' => false),
				array(
					'attribute' => 'short_description',
					'null' => false),
			))
                ->addAttributeToFilter('visibility', array(
                    'in' => 4
                ))->addAttributeToFilter(
                'status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));
        
        $collection->getSelect()->limit(self::COLLECTION_LIMIT);
        return $collection;
    }

}
