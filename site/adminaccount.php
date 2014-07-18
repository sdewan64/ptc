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
    
    $userQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM members');
    $adsQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM ads WHERE IsActive=1');
    
    $pnd = $paid = $bal = 0;
    while($userData = mysqli_fetch_assoc($userQuery)){
        $pnd += $userData['unpaid'];
        $paid += $userData['paid'];
        $bal += $userData['balance'];
    }
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            Admin Account
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
        <fieldset id="rightBar" style="font-weight: bold;color: purple;text-align: center">
            <br><br>
            <hr>
            <span style="color: purple">Site Status</span>
            <hr>
            Total Members : <?php echo mysqli_num_rows($userQuery); ?>
            <hr>
            Total Active Ads : <?php echo mysqli_num_rows($adsQuery); ?>
            <hr>
            Total Views Served : <?php 
                $cnt = 0;
                $cntU = 0;
                while($adsData = mysqli_fetch_assoc($adsQuery)){
                    $cnt += $adsData['Views'];
                    $cntU += $adsData['ViewLimit'];
                }
                echo $cnt;
            ?>
            <hr>
            Total Unserved Views : <?php 
                $rs = $cntU - $cnt;
                if($rs<0){
                    $rs = $rs * (-1);
                }
                echo $rs;
            ?>
            <hr>
            Total Amount of Pending Payments : <?php echo $pnd; ?> Taka
            <hr>
            Total Amount of Cash Paid : <?php echo $paid; ?> Taka
            <hr>
            Total Amount of money distributed among members : <?php echo ($pnd+$paid+$bal); ?> Taka
            <hr>
            
        </fieldset>
    
    
</div>

<?php
}

echo $siteConstant->getTail();