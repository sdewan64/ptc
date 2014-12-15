<?php

/**
The MIT License (MIT)

Shaheed Ahmed Dewan Sagar
Email : sdewan64@gmail.com
Ahsanullah University of Science and Technology,Dhaka,Bangladesh.
Copyright (c) 2014                      

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
session_start();

require_once '../uses_constants/initSite.php';

$siteConstant->addFile('css', 'form.css');
$siteConstant->addFile('css', 'font-awesome.css');


echo $siteConstant->getHead();
echo $siteConstant->getMenu();
?>

<?php


if(isset($_POST['login'])){
    include '../uses_classes/class.Login.php';
    
    $login = new Login();
    
    if($login->isLoggedIn()){
        $siteConstant->loggedIn = true;
        header('location: account.php');
    }else{
        //warning shown on the form
        $siteConstant->loggedIn = false;
    }
}

$token = $_SESSION['token'] = md5(uniqid(mt_rand(),true));
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
	echo "<br /><br /><br /><center><h3 style=\"color:red;\"><b>You are already Logged in!</b></h3></center>";
}else{    
?>

<form id="msform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="top:100px;">
            <fieldset>
                <h2 class="fs-title">Login</h2>
                <?php 
                    if(isset($_POST['login'])){
                        echo '<h3 class="fs-subtitle" style="color:red;">Invalid Username/Password</h3>';
                    }
                ?>
                <input type="text" name="username" placeholder="Username" autocomplete="off" autofocus="true" required="true" />
                <input type="password" name="password" placeholder="Password" required="true" />
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
                <input type="submit" name="login" class="submit action-button" value="Login"/>
                
                <h3 class="fs-subtitle"><a href="forgot.php">Forgot your password?</a></h3>
    </fieldset>
</form>

<?php
}
echo $siteConstant->getTail();