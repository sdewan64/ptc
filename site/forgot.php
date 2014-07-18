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
$msg = '';
?>

<?php


if(isset($_POST['submit'])){
   require_once '../uses_constants/class.DatabaseConstants.php';
    require_once '../uses_classes/class.DBase.php';
    
    $valid = false;

    $db = new DatabaseConstants();
    $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
    $dBase->setDatabaseName($db->getDb());

    if(!$dBase->connectDatabase()){
        die('SQL ERROR at db class vd fn');
    }
    
    $userQuery = mysqli_query($dBase->getDbobj(), "SELECT password,email FROM members WHERE email=\"".$_POST['email']."\"");
    if(mysqli_num_rows($userQuery)){
        $userData = mysqli_fetch_assoc($userQuery);
        
        $admin_mail = 'admin@dumb.com';
        
        $to      = $userData['email'];
	$subject = 'Your Password';
	$message = 'Your password is : '.$userData['password'];
	$headers = 'From: ' . $admin_mail . "\r\n" .
    	'Reply-To: '. $admin_mail . "\r\n" .
    	'X-Mailer: PHP/' . phpversion();

	if(mail($to, $subject, $message, $headers)){
            $valid = true;
            $msg = 'Password has been sent to your Email Address';
	}else{
            $msg = 'Failed sending the email';
        }
        
    }else{
        $valid = false;
    }
}
?>

<form id="msform" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="top:100px;">
            <fieldset>
                <h2 class="fs-title">Forgot My Password</h2>
                <?php 
                    if(isset($_POST['submit']) && !$valid){
                        echo '<h3 class="fs-subtitle" style="color:red;">Invalid Email Address</h3>';
                    }else{
                        echo '<h3 class="fs-subtitle" style="color:green;">'.$msg.'</h3>';
                    }
                ?>
                <input type="email" name="email" placeholder="Enter your email address" autocomplete="off" autofocus="true" required="true" />
                <input type="submit" name="submit" class="submit action-button" value="Submit"/>
                
    </fieldset>
</form>

<?php

echo $siteConstant->getTail();