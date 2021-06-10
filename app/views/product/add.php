<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <p>Заповніть, будь-ласка, форму з інформацією про товар</p>
    <h5>Код товару:</h5>
       <div> <input type="text" name="sku"></div><br>
    <h5>Назва товару:</h5>
       <div><input type="text" name="name"></div><br>
    <h5>Ціна</h5>
       <div><input type="text" name="price"></div><br>
    <h5>Кількість</h5>
       <div><input type="text" name="qty"></div><br>
    <h5>Опис товару</h5>
       <div><input type="text" name="description"></div><br>
    <input type="submit" value="Додати товар">
    
</form>
<?php

//echo "<pre>";
//var_dump($_POST);
//echo "<pre>";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

