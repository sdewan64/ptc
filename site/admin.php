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
    require_once '../uses_constants/class.DatabaseConstants.php';
    require_once '../uses_classes/class.DBase.php';

    $db = new DatabaseConstants();
    $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
    $dBase->setDatabaseName($db->getDb());

    if(!$dBase->connectDatabase()){
        die('SQL ERROR at db class vd fn');
    }

    $siteQuery = mysqli_query($dBase->getDbobj(),'SELECT adminuser,adminpass FROM siteinfo WHERE id=1');
    $siteData = mysqli_fetch_assoc($siteQuery);
    
    if($_POST['username'] == $siteData['adminuser'] && $_POST['password'] == $siteData['adminpass']){
        $_SESSION['adminusername'] = $_POST['username'];
        $_SESSION['adminpassword'] = $_POST['password'];
        
        header('location: adminaccount.php');
    }
}
    
?>

<form id="msform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="top:100px;">
            <fieldset>
                <h2 class="fs-title">Login to Admin Account</h2>
                <?php 
                    if(isset($_POST['login'])){
                        echo '<h3 class="fs-subtitle" style="color:red;">Invalid Username/Password</h3>';
                    }
                ?>
                <input type="text" name="username" placeholder="Username" autocomplete="off" autofocus="true" />
                <input type="password" name="password" placeholder="Password" />
                <input type="submit" name="login" class="submit action-button" value="Login"/>
    </fieldset>
</form>

<?php

echo $siteConstant->getTail();