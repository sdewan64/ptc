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

if(!isset($_SESSION['adminuser'])&&!isset($_SESSION['adminpassword'])){
    header('location: logout.php');
}else{
    $siteConstant->addFile('css', 'account.css');
    echo $siteConstant->getHead();
    echo $siteConstant->getMenu();
    
    require_once '../uses_constants/class.DatabaseConstants.php';
    require_once '../uses_classes/class.DBase.php';

    $db = new DatabaseConstants();
    $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
    $dBase->setDatabaseName($db->getDb());

    if(!$dBase->connectDatabase()){
        die('SQL ERROR at db class vd fn');
    }
    
    if(isset($_GET['user'])){
        $found = false;
        $userQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM members WHERE username="'.$_GET['user'].'"');
        $userData = mysqli_fetch_assoc($userQuery);
        if(mysqli_num_rows($userQuery)){
           $found = true; 
        }
    }
    
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            User Information
        </legend>
    
        <br>
    
        <fieldset id="leftBar">
            <p style="font-family: sans-serif;font-size: 24px;color:#0481b1;">
                <b><u>Admin Menu</u></b>
            </p>
            
            <p>
                <a href="esinfo.php" class="sideBarButton">Edit Site Information</a> <br><br>
                <a href="addad.php" class="sideBarButton">Add Advertisement</a> <br><br>
                <a href="paymentreqs.php" class="sideBarButton">Payment Requests</a> <br><br>
                <a href="gud.php" class="sideBarButton">Get User Detail</a> <br><br>
            </p>
        </fieldset>
    </center>
        <fieldset id="rightBar" style="font-weight: bold;height: 500px;color: purple;text-align: center">
           <?php
                if(isset($_GET['user'])){
                    if(!$found){
                        echo '<h2 style="color:red;text-align:center">No user exists with that username</h2>';
                    }else{
           ?>
            
            <hr>
            User Name : <?php echo $userData['username']; ?>
            <hr>
            Email Address : <?php echo $userData['email']; ?>
            <hr>
            Country : <?php echo $userData['country']; ?>
            <hr>
            Payment 1 : <?php echo $userData['paymenttype1']; ?>
            <hr>
            Payment 2 : <?php echo $userData['paymenttype2']; ?>
            <hr>
            Payment 3 : <?php echo $userData['paymenttype3']; ?>
            <hr>
            Membership : <?php echo $userData['membership']; ?>
            <hr>
            Balance : <?php echo $userData['balance']; ?>
            <hr>
            Paid : <?php echo $userData['paid']; ?>
            <hr>
            Unpaid : <?php echo $userData['unpaid']; ?>
            <hr>
            Self Clicks : <?php echo $userData['selfclick']; ?>
            <hr>
            Referral Clicks : <?php echo $userData['refclick']; ?>
            <hr>
            Self Click Earn : <?php echo $userData['selfclickearn']; ?>
            <hr>
            Referral Click Earn : <?php echo $userData['refclickearn']; ?>
            <hr>
            Reffered By : <?php echo $userData['referredby']; ?>
            <hr>
            
            <?php
                    }
                }else{
            ?>
            
            <form id="msform" method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <center>
                    Username<br><br><input type="text" name="user" placeholder="Enter a username" required="true"/><br><br>
                    <input type="submit" name="submit" class="NormButton" Value="Submit" />
                </center>
            </form>
            
            <?php
                }
            ?>
        </fieldset>
    
    
</div>

<?php
}

echo $siteConstant->getTail();