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

    $done = false;

    $db = new DatabaseConstants();
    $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
    $dBase->setDatabaseName($db->getDb());

    if(!$dBase->connectDatabase()){
        die('SQL ERROR at db class vd fn');
    }
    
    if(isset($_POST['submit'])){
        $qry = "UPDATE siteinfo SET title='".$_POST['title']."',link='".$_POST['link']."',header='".$_POST['header']."',payment1='".$_POST['p1']."',payment2='".$_POST['p2']."',payment3='".$_POST['p3']."',minimumtowithdraw='".$_POST['minimum']."',adminuser='".$_POST['auser']."',adminpass='".$_POST['apass']."' WHERE id=1";
        mysqli_query($dBase->getDbobj(), $qry);
        if(!mysqli_affected_rows($dBase->getDbobj())<1){
            $done = true;
        }
    }
    
    $siteQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM siteinfo WHERE id=1');
    $siteData = mysqli_fetch_assoc($siteQuery);
    
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            Edit Site Information
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
        <fieldset id="rightBar" style="font-weight: bold;height: 900px">
           <form id="msform" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <center>
                <?php
                    if(isset($_POST['submit']) && !$done){
                        echo '<h3 style="color:red;">Something went wrong.Check esinfo page.</h3>';
                    }
                    
                    if($done){
                        echo '<h3 style="color:green;">Information Changed Successfully.</h3>';
                    }
                ?>
                    
                    Site Title <input type="text" name="title" placeholder="Type the value" value="<?php echo $siteData['title']; ?>" required="true"/> <br><br>
                   Site Link <input type="text" name="link" placeholder="Type the value" value="<?php echo $siteData['link']; ?>" required="true"/><br><br>
                   Site Header <input type="text" name="header" placeholder="Type the value" value="<?php echo $siteData['header']; ?>" required="true"/><br><br>
                   Payment 1 <input type="text" name="p1" placeholder="Type the value" value="<?php echo $siteData['payment1']; ?>" required="true"/><br><br>
                   Payment 2 <input type="text" name="p2" placeholder="Type the value" value="<?php echo $siteData['payment2']; ?>" required="true"/><br><br>
                   Payment 3 <input type="text" name="p3" placeholder="Type the value" value="<?php echo $siteData['payment3']; ?>" required="true"/><br><br>
                   Minimum to Withdraw <input type="text" name="minimum" placeholder="Type the value" value="<?php echo $siteData['minimumtowithdraw']; ?>" required="true"/><br><br>
                   Admin username <input type="text" name="auser" placeholder="Type the value" value="<?php echo $siteData['adminuser']; ?>" required="true"/><br><br>
                   Admin password <input type="password" name="apass" placeholder="Type the value" value="<?php echo $siteData['adminpass']; ?>" required="true"/><br><br>
                    <input type="submit" name="submit" class="NormButton" Value="Submit" />
                </center>
            </form>
        </fieldset>
    
    
</div>

<?php
}

echo $siteConstant->getTail();