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
?>

<?php
session_start();
    
require_once '../uses_constants/initSite.php';
$siteConstant->addFile('css', 'account.css');
echo $siteConstant->getHead();
echo $siteConstant->getMenu();

    if(isset($_SESSION['username']) && isset($_SESSION['password'])){

        require_once '../uses_constants/class.DatabaseConstants.php';
        require_once '../uses_classes/class.DBase.php';
        
        $done = false;

        $db = new DatabaseConstants();
        $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
        $dBase->setDatabaseName($db->getDb());

        if(!$dBase->connectDatabase()){
            die('SQL ERROR at db class vd fn');
        }

        $userQuery = mysqli_query($dBase->getDbobj(), "SELECT passmd5 FROM members WHERE username=\"".$_SESSION['username']."\"");
        if(mysqli_num_rows($userQuery)){
            $userData = mysqli_fetch_assoc($userQuery);
        }else{
            die('User Not Found!');
        }
        
        //Handling Action POST call
        if(isset($_POST['submit'])){
            if($_POST['pass']!=$_POST['cpass'] || md5($_POST['oldpass'])!=$userData['passmd5']){
                $done = false;
            }else{
                $mdp5 = md5($_POST['pass']);
                $qry = "UPDATE members SET password='".$_POST['pass']."',passmd5='".$mdp5."' WHERE username='".$_SESSION['username']."'";
                mysqli_query($dBase->getDbobj(), $qry);
                if(!mysqli_affected_rows($dBase->getDbobj())<1){
                    $done = true;
                }
            }
        }
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            Account Detail
        </legend>
    
        <br>
    
        <fieldset id="leftBar">
            <p style="font-family: sans-serif;font-size: 24px;color:#0481b1;">
                <b><u>User Menu</u></b>
            </p>
            
            <p>
                <a href="account.php" class="sideBarButton">View Summary</a> <br><br>
                <a href="request.php" class="sideBarButton">Request Payment</a> <br><br>
                <a href="refs.php" class="sideBarButton">Direct Referrals</a> <br><br>
                <a href="settings.php" class="sideBarButton">Account Setting</a> <br><br>
            </p>
        </fieldset>
    </center>
        <fieldset id="rightBar" style="font-weight: bold">
            <form id="msform" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <center>
                <?php
                    if(isset($_POST['submit']) && !$done){
                        echo '<h3 style="color:red;">Passwords does not match or Old Password is not correct</h3>';
                    }
                    
                    if($done){
                        echo '<h3 style="color:green;">Password Changed Successfully.</h3>';
                    }
                ?>
                    
                    <input type="password" name="pass" placeholder="Enter New Password" required="true"/> <br><br>
                    <input type="password" name="cpass" placeholder="Re-type New Password" required="true"/><br><br>
                    <input type="password" name="oldpass" placeholder="Enter Old Password" required="true"/><br><br>
                    <input type="submit" name="submit" class="NormButton" Value="Submit" />
                </center>
            </form>
        </fieldset>
    
    
</div>




<?php
        $dBase->closeDatabse();
    }else{
        header('location: logout.php');
    }
echo $siteConstant->getTail();