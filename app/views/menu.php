<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
    <?php 
        foreach($this->get('menuCollection') as $item)  :
    ?>
        <li>
            <?= \Core\Url::getLink($item['path'], $item['name']); ?>
        </li>
    <?php endforeach; ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo $this->getBP();?>/customer/register/"><span class="glyphicon glyphicon-user"></span><?php if (isset($_SESSION['id'])) {echo " ". \Core\Helper::getCustomerName();
        } else {echo "Sign Up";}?></a></li>
        <li><a href="<?php echo $this->getBP();?>/customer/login/"><span class="glyphicon glyphicon-log-in"></span><?php if (isset($_SESSION['id'])) {echo " Logout"; } else {echo " Login";}?></a></li>
    </ul>
  </div>
</nav>