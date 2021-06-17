
<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <p>Відредагуйте, будь-ласка, інформацію про товар</p>
    <div>Код товару<br>
        <input type="text" name="sku" value="<?php echo $product['sku']?>"></div><br>
    <div>Назва товару<br>
        <input type="text" name="name" value="<?php echo $product['name']?>"></div><br>
    <div>Ціна<br>
        <input type="text" name="price" value="<?php echo $product['price']?>"></div><br>
    <div>Кількість<br>
        <input type="text" name="qty" value="<?php echo $product['qty']?>"></div><br>
    <div>Опис товару<br>
        <input type="text" name="description" value="<?php echo $product['description']?>"></div><br>
    <input type="submit" value="Внести зміни">
    <input type="reset" value="Очистити форму">
    
</form>
<?php

var_dump($_POST);
var_dump($_GET);


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

