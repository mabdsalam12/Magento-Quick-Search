<?php
    class Abdus_Qsearch_AjaxsearchController extends Mage_Core_Controller_Front_Action{
        public function indexAction(){
            $this->loadLayout();
            $this->renderLayout();
        }
        public function ajaxAction(){
            $keyword=$this->getRequest()->getParam('keyword');
            $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addFieldToFilter('name',array('like'=>'%'.$keyword.'%'))
            ->addAttributeToFilter('visibility',array('in'=>array(2,3,4)))
            ->setPageSize(6);
            $productArray=array();
            $baseUrl = Mage::getBaseUrl().'/';
            foreach($collection as $p){
                $productArray['p'][]=array(
                    'n'=>$p->getName(),
                    't'=>$p->getThumbnail(),
                    'p'=>number_format($p->getPrice(), '2', '.', ','),
                    'sp'=>number_format($p->getSpecialPrice(), '2', '.', ','),
                    'u'=>$p->getProductUrl(),
                );
            }
            $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
            $this->getResponse()->setBody(json_encode($productArray));


        }
    }
?>
