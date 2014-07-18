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
    include '../uses_classes/class.Login.php';
    
    $login = new Login();
    
    if($login->isLoggedIn()){
        $siteConstant->loggedIn = true;
        $siteConstant->addFile('css', 'account.css');

        echo $siteConstant->getHead();
        echo $siteConstant->getMenu();
    }else{
        include 'logout.php';
        header('location: index.php');
    }
    
    if($siteConstant->loggedIn){
        require_once '../uses_constants/class.DatabaseConstants.php';
        require_once '../uses_classes/class.DBase.php';
        
        $db = new DatabaseConstants();
        $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
        $dBase->setDatabaseName($db->getDb());
        
        if(!$dBase->connectDatabase()){
            die('SQL ERROR at db class vd fn');
        }
        
        $siteQuery = mysqli_query($dBase->getDbobj(),'SELECT title,link,header FROM siteinfo WHERE id=1');
        $siteData = mysqli_fetch_assoc($siteQuery);
        
        $userQuery = mysqli_query($dBase->getDbobj(), "SELECT * FROM members WHERE username=\"".$_SESSION['username']."\"");
        if(mysqli_num_rows($userQuery)){
            $userData = mysqli_fetch_assoc($userQuery);
        }else{
            die('User Not Found!');
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
            <hr>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your referral link : <a href="<?php echo "index.php?ref=".$userData['username']; ?>"><?php echo $siteData['link']."index.php?ref=".$userData['username']; ?></a>
            <hr>
            <span style="color: red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Membership : <?php echo $userData['membership']; ?></span>
            <hr>
            <span style="color: blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total ads viewed by you : <?php echo $userData['selfclick']; ?></span>
            <hr>
            <span style="color: blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total ads viewed by your referrals : <?php echo $userData['refclick']; ?></span>
            <hr>
            <span style="color: blueviolet">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Earned from your views : <?php echo $userData['selfclickearn']; ?> &nbsp; Taka</span>
            <hr>
            <span style="color: blueviolet">Total Earned from your referrals views : <?php echo $userData['refclickearn']; ?> &nbsp; Taka</span>
            <hr>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Earned so far :  <?php echo ($userData['paid']+$userData['unpaid']+$userData['balance']); ?> &nbsp; Taka
            <hr>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Paid : <?php echo $userData['paid']; ?> &nbsp; Taka
            <hr>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unpaid : <?php echo $userData['unpaid']; ?> &nbsp; Taka
            <hr>
            <span style="color:green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Account Balance : <?php echo $userData['balance']; ?> &nbsp; Taka</span>
            <hr>
        </fieldset>
    
    
</div>

<?php
    $dBase->closeDatabse();
    }

echo $siteConstant->getTail();