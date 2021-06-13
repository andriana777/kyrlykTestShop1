<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <p>Заповніть, будь-ласка, форму</p>
    <h5>Ім'я</h5>
       <div> <input type="text" name="firstname"></div><br>
    <h5>Прізвище</h5>
       <div><input type="text" name="lastname"></div><br>
    <h5>Телефон</h5>
       <div><input type="tel" name="telephone"></div><br>
    <h5>Електронна пошта</h5>
       <div><input type="email" name="email"></div><br>
    <h5>Місто проживання</h5>
       <div><input type="text" name="city"></div><br>
    <h5>Пароль</h5>
       <div><input type="password" name="password"></div><br>
   
      
    <input type="submit" name="submit" value="Зареєструватись">
    
</form>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

