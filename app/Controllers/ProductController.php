<?php
namespace Controllers;

use Core\Controller;
use Core\View;
use Core\DB;

/**
 * Class ProductController
 */
class ProductController extends Controller
{
    public function indexAction()
    {
        $this->forward('product/list');
    }

    /**
     *
     */
    public function listAction()
    {
        $this->set('title', "Товари");

        $products = $this->getModel('Product')
            ->initCollection()
            ->filterPrice()
            ->sort($this->getSortParams())
            ->getCollection()
            ->select();
        $this->set('products', $products);

        $this->renderLayout();
    }

    /**
     *
     */
    public function viewAction()
    {
        $this->set('title', "Карточка товара");

        $product = $this->getModel('Product')
            ->initCollection()
            ->filter(['id',$this->getId()])
            ->getCollection()
            ->selectFirst();
        $this->set('products', $product);

        $this->renderLayout();
    }

    /**
     *
     */
    public function editAction()
    {
        $model = $this->getModel('Product');
        $this->set('saved', 0);
        $this->set("title", "Редагування товару");
        $id = filter_input(INPUT_GET, 'id');
        if (isset($id) && !empty($_POST)) {
            $values = $model->getPostValues();
            $values  = $model->myValidator($values);
            $this->set('saved', 1);
            $model->saveItem($id, $values);
           
        }
        $this->set('product', $model->getItem($this->getId()));

        $this->renderLayout();
    }

    /**
     *
     */
    public function addAction()
    {

        $model = $this->getModel('Product');
        $this->set("title","Додавання товару");
        if ($values = $model->getPostValues()) {
            $values  = $model->myValidator($values);
            $model->addItem($values);
            
            $lastId = $model->getLast();
          $road= "/product/edit?id={$lastId}";
          //$road = "/product/success";
            self::redirect($road);
           echo "Товар додано!";
        }
        $this->renderLayout();
    }

    /**
     * @return array
     */
  /*  public function getSortParams()
    {
        $params = [];
        $sortfirst = filter_input(INPUT_POST, 'sortfirst');
        if ($sortfirst === "price_DESC") {
            $params['price'] = 'DESC';
        } else {
            $params['price'] = 'ASC';
        }
        $sortsecond = filter_input(INPUT_POST, 'sortsecond');
        if ($sortsecond === "qty_DESC") {
            $params['qty'] = 'DESC';
        } else {
            $params['qty'] = 'ASC';
        }
        
        return $params;

    }
*/
    /**
     * @return array
     */
    //Using Cookie
      public function getSortParams()
    {
        $params = [];
        $sortfirst = filter_input(INPUT_POST, 'sortfirst');
        if (isset($sortfirst) && empty($_COOKIE['sortCookie1'])) {
            setcookie('sortCookie1', $sortfirst);
        }
         if (!empty($_COOKIE['sortCookie1'])) {
            $sortfirst = $_COOKIE['sortCookie1'];
        }
        
        if ($sortfirst === "price_DESC") {
            $params['price'] = 'DESC';
        } else {
            $params['price'] = 'ASC';
        }
        $sortsecond = filter_input(INPUT_POST, 'sortsecond');
         if (isset($sortsecond) && empty($_COOKIE['sortCookie2'])) {
            setcookie('sortCookie2', $sortsecond);
        }
          if (!empty($_COOKIE['sortCookie2'])) {
            $sortsecond = $_COOKIE['sortCookie2'];
        }
        if ($sortsecond === "qty_DESC") {
            $params['qty'] = 'DESC';
        } else {
            $params['qty'] = 'ASC';
        }
        
      if (!empty($_COOKIE['sortCookie1']) && isset($_POST['sortfirst']) && 
              $_COOKIE['sortCookie1']!==$_POST['sortfirst']) {
         // setcookie('sortCookie1', '');
          setcookie('sortCookie1', $_POST['sortfirst']);
      }
      $sortfirst = $_COOKIE['sortCookie1'];
      
       if (!empty($_COOKIE['sortCookie2']) && isset($_POST['sortsecond']) && 
              $_COOKIE['sortCookie2']!==$_POST['sortsecond']) {
         // setcookie('sortCookie1', '');
          setcookie('sortCookie2', $_POST['sortsecond']);
      }
      $sortsecond = $_COOKIE['sortCookie2'];
        return $params;

    }

    
    public function getSortParams_old()
    {
        /*
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else 
        { 
            $sort = "name";
        }
         * 
         */
        $sort = filter_input(INPUT_GET, 'sort');
        if (!isset($sort)) {
            $sort = "name";
        }
        /*
        if (isset($_GET['order']) && $_GET['order'] == 1) {
            $order = "ASC";
        } else {
            $order = "DESC";
        }
         * 
         */
        if (filter_input(INPUT_GET, 'order') == 1) {
            $order = "DESC";
        } else {
            $order = "ASC";
        }
        
        return array($sort, $order);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        
        if (isset($_GET['id'])) {
         
            return $_GET['id'];
        } else {
            return NULL;
        }
        
        return filter_input(INPUT_GET, 'id');
    }
    
    public function deleteAction()
    {
    
        $model = $this->getModel('Product');
        $this->set('deleted', 0);
        $this->set("title", "Видалення товару");
       // $id = filter_input(INPUT_GET, 'id');
        $id = filter_input(INPUT_GET, 'id');
        if (($id) && isset($_POST['delete'])) {
            $this->set('deleted', 1);
            //$db= new DB();
            //$db->deleteEntity();
           $model->deleteItem($id);
            //$model->deleteItem($this->id);
           self::redirect('/product/list');
        }
        
        $this->renderLayout();
    }
    
     public function lastId() 
    {
         $db= new DB();
         $this->last= $db->lastInsertId();
         return $this;
    }
    
    public function unloadAction()
    {
        $products = $this->getModel('Product')
            ->initCollection()
            ->getCollection()->select();
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><products/>');

        foreach ($products as $product) {
            $xmlProduct = $xml->addChild('product');
            $xmlProduct->addChild('id',$product['id']);
            $xmlProduct->addChild('sku',$product['sku']);
            $xmlProduct->addChild('name',$product['name']);
            $xmlProduct->addChild('price',$product['price']);
            $xmlProduct->addChild('qty',$product['qty']);
            $xmlProduct->addChild('description',$product['description']);
        }
        //$xml->asXML('public/products.xml');
        //echo Helper::redirectDownload('/public/products.xml');

        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        $dom->saveXML();

        $file = fopen('public/products.xml','w');
        fwrite($file, $dom->saveXML());
        fclose($file);
        
    
        $this->setView();
        $this->renderLayout();
       
 
    }
}