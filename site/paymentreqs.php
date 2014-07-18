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
    
    //handling Paid Request
    if(isset($_GET['paid']) && isset($_GET['user'])){
        if($_GET['paid'] == 1){
            $userQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM members WHERE username="'.$_GET['user'].'"');
            $userData = mysqli_fetch_assoc($userQuery);
            $p = $userData['paid'] + $userData['unpaid'];
            $qry = "UPDATE members SET paid=".$p.",unpaid=0 WHERE username='".$_GET['user']."'";
            mysqli_query($dBase->getDbobj(), $qry);
            header('location: paymentreqs.php');
        }
    }
    
    $userQuery = mysqli_query($dBase->getDbobj(),'SELECT username,unpaid FROM members WHERE unpaid > 0');
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            Payment Requests
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
        <fieldset id="rightBar" style="font-weight: bold">
            <table id="keywords" border="2" width="500px" style="text-align: center">
                <tr>
                    <td>User Name</td>
                    <td>Requested Amount</td>
                    <td>Is Paid?</td>
                </tr>
                
                <?php
                    while($userData = mysqli_fetch_assoc($userQuery)){
                        echo '<tr>';
                        echo '<td>'.$userData['username'].'</td>';
                        echo '<td>'.$userData['unpaid'].'</td>';
                        echo '<td><a href="paymentreqs.php?paid=1&user='.$userData['username'].'">PAID</a>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </fieldset>
    
    
</div>

<?php
}

echo $siteConstant->getTail();