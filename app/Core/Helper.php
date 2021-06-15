<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;


class Helper {
    
     public static function getCustomer()
   {
        if (!empty($_SESSION['id'])) {
        return self::getModel('customer')->initCollection()
            ->filter(array('customer_id'=>$_SESSION['id']))
            ->getCollection()
            ->selectFirst();
        } else {
            return null;
        }

    }
    
    public static function getCustomerName()
    {
        $customer = self::getCustomer();
        return isset($customer) ? $customer['first_name']. " " . $customer['last_name'] : 
            "Friend";
            
        }
     public static function getModel($name)
    {
        $name = '\\Models\\' . ucfirst($name);
        $model = new $name();
        return $model;
    }
    }
    

