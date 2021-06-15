<form method="POST" action="<?= \Core\Route::getBP().'/customer/login' ?>">
    <h3>Вхід</h3>
    <h5>Email</h5>
       <div><input type="email" name="email"></div><br>
    <h5>Пароль</h5>
       <div><input type="password" name="password"></div><br>
   <input type="submit" name="submit">
    
</form>
<?php

var_dump($_SESSION);

var_dump($_POST);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

