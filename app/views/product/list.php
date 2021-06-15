<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
<select name='sortfirst'>
    <option <?php echo filter_input(INPUT_POST, 'sortfirst') === 'price_ASC' ? 'selected' : '';?> value="price_ASC">від дешевших до дорожчих</option>
    <option <?php echo filter_input(INPUT_POST, 'sortfirst') === 'price_DESC' ? 'selected' : '';?> value="price_DESC">від дорожчих до дешевших</option>
</select>
<select name='sortsecond'>
  <option <?php echo filter_input(INPUT_POST, 'sortsecond') === 'qty_ASC' ? 'selected' : '';?>  value="qty_ASC">по зростанню кількості</option>
  <option <?php echo filter_input(INPUT_POST, 'sortsecond') === 'qty_DESC' ? 'selected' : '';?>  value="qty_DESC">по спаданню кількості</option>
</select>
Ціна від:<input type="text" name="from" value="">Ціна до:<input type="text" name="to" value=""><br>
<input type="submit" value="Застосувати" style="margin-left: 370px; margin-top: 10px">
</form>

<?php if (\Core\Helper::isAdmin()===true) { ?>
<div class="product"><p>
        <?= \Core\Url::getLink('/product/add', 'Додати товар'); ?>
</p></div>
<?php }; ?>
<?php

$products =  $this->get('products');

foreach($products as $product)  :
?>

    <div class="product">
        <p class="sku">Код: <?php echo $product['sku']?></p>
        <h4><?php echo $product['name']?><h4>
        <p> Ціна: <span class="price"><?php echo $product['price']?></span> грн</p>
        <p> Кількість: <?php echo $product['qty']?></p>
        <p> Опис товару: <?php echo htmlspecialchars_decode($product['description'])?></p>
        <p><?php if(!$product['qty'] > 0) { echo 'Нема в наявності'; } ?></p>
        <?php if (\Core\Helper::isAdmin()===true) { ?>
        <p>
            <?= \Core\Url::getLink('/product/edit', 'Редагувати', array('id'=>$product['id'])); ?>
            <?= \Core\Url::getLink('/product/delete', 'Видалити', array('id'=>$product['id'])); ?>
        </p><?php }; ?>
    </div>
<?php endforeach; ?>

<?php
echo "<pre>";
var_dump($_POST);
echo "</pre>";