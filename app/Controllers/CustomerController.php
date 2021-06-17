<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use Core\Controller;
use Core\View;

class CustomerController extends Controller {
    
    public function loginAction()
    {   $_SESSION = [];
        $this->set('title', "Вхід");
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
        {
            $email = filter_input(INPUT_POST, 'email');
            //$password = md5(filter_input(INPUT_POST, 'password'));
            $password = (filter_input(INPUT_POST, 'password'));
            $params =array (
                'email' => $email,
                'password' => $password
            );
           // $_SESSION =[];
            $customer = $this->getModel('customer')->initCollection()
                ->filter($params)
                ->getCollection()
                ->selectFirst();
             // $this->set('customer', $customer);
          
     
            //if(isset($customer)) {
            if(!empty($customer)) {
                
                $_SESSION['id'] = $customer['customer_id'];
                self::redirect('/index/index');
               // $this->redirect('/index/index');
                  var_dump($customer);
                  echo $_SESSION['id'];
            } else {
                var_dump(session_status());
                //var_dump(session_id());
                echo "Щось пішло не так...";
                $this->invalid_password = 1;
            }
        }
        $this->renderLayout();
    }

    public function logoutAction()
    {

        $_SESSION = [];

        // expire cookie

        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 3600, "/");
        }

        session_destroy();
        $this->redirect('/index/index');
    }

  public function registerAction()
    {

        $model = $this->getModel('Customer');
        $this->set("title", "Реєстрація користувача");
        if ($values = $model->getPostValues()) {
           // $values  = $model->myValidator($values);
          //$model->addUser($values);
            $model->addItem($values);
            
            
          //$road= "/product/list";
          $road = "/customer/registerOk";
            self::redirect($road);
        }
        $this->renderLayout();
    }

    
}


