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

        $db = new DatabaseConstants();
        $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
        $dBase->setDatabaseName($db->getDb());

        if(!$dBase->connectDatabase()){
            die('SQL ERROR at db class vd fn');
        }

        $userQuery = mysqli_query($dBase->getDbobj(), "SELECT username,selfclick,balance,paid,unpaid FROM members WHERE referredby=\"".$_SESSION['username']."\"");
        if(mysqli_num_rows($userQuery)){
            //continue
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
            <center>
                <table border="2" width="500px" style="text-align: center">
                    <tr>
                        <td>User Name</td>
                        <td>Total Self Clicks</td>
                        <td>Total Earned</td>
                    </tr>
                    <?php
                        while($userData = mysqli_fetch_assoc($userQuery)){
                            $earn = $userData['balance'] + $userData['paid'] + $userData['unpaid'];
                            echo '<tr>';
                            echo '<td>'.$userData['username'].'</td>';
                            echo '<td>'.$userData['selfclick'].'</td>';
                            echo '<td>'.$earn.'</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </center>
        </fieldset>
    
    
</div>




<?php
        $dBase->closeDatabse();
    }else{
        header('location: logout.php');
    }
echo $siteConstant->getTail();