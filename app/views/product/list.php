<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
<select name='sortfirst'>
    <option <?php echo filter_input(INPUT_POST, 'sortfirst') === 'price_ASC' ? 'selected' : '';?> value="price_ASC">від дешевших до дорожчих</option>
    <option <?php echo filter_input(INPUT_POST, 'sortfirst') === 'price_DESC' ? 'selected' : '';?> value="price_DESC">від дорожчих до дешевших</option>
</select>
<select name='sortsecond'>
  <option <?php echo filter_input(INPUT_POST, 'sortsecond') === 'qty_ASC' ? 'selected' : '';?>  value="qty_ASC">по зростанню кількості</option>
  <option <?php echo filter_input(INPUT_POST, 'sortsecond') === 'qty_DESC' ? 'selected' : '';?>  value="qty_DESC">по спаданню кількості</option>
</select>
    <div class="filterPrice" style="float: right">
Ціна від:<input style=" border-radius: 5px;" type="text" name="from" value="<?= filter_input(INPUT_POST, 'from')?>">
Ціна до:<input style=" border-radius: 5px;" type="text" name="to" value="<?= filter_input(INPUT_POST, 'to')?>"><br>
<input  type="submit" value="Застосувати" style="margin-left: 170px; margin-top: 10px; width: 200px; background-color: Silver; height: 30px; border-radius: 5px; color: whitesmoke"></div>
</form>

<?php if (\Core\Helper::isAdmin()===true) { ?>
<div class="add" style="margin-left: 200px; margin-top: 60px;"><button style="width: 200px;  background-color: Silver; height: 30px; border-radius: 5px; color: whitesmoke">
        <?= \Core\Url::getLink('/product/add', 'Додати товар'); ?>
</button></div>
<?php }; ?>
<?php

$products =  $this->get('products');

foreach($products as $product)  :
?>

    <div class="product" style=" border-radius: 5px;  margin-right: 350px; background-color: GhostWhite">
         <p class="sku"><b>Код:</b> <?php echo $product['sku']?></p>
         <h4><b><i><?php echo $product['name']?></i></b><h4>
                <p><b><i> Ціна:</i></b> <span class="price"><?php echo $product['price']?></span> грн</p>
        <p><b><i> Кількість:</i></b> <?php echo $product['qty']?></p>
        <p><b><i>Опис товару: </i></b><?php echo htmlspecialchars_decode($product['description'])?></p>
        <p><?php if(!$product['qty'] > 0) { echo 'Нема в наявності'; } ?></p>
        <?php if (\Core\Helper::isAdmin()===true) { ?>
        <p><button style="width: 200px;  background-color: Silver; height: 30px; border-radius: 5px; color: whitesmoke">
            <?= \Core\Url::getLink('/product/edit', 'Редагувати', array('id'=>$product['id'])); ?></button>
            <button style="width: 200px;  background-color: Silver; height: 30px; border-radius: 5px; color: whitesmoke">
            <?= \Core\Url::getLink('/product/delete', 'Видалити', array('id'=>$product['id'])); ?></button>
        </p><?php }; ?>
    </div>
<?php endforeach; ?>

<?php
echo "<pre>";
var_dump($_POST);
var_dump($_COOKIE);
echo "</pre>";