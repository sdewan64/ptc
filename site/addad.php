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
    $done = false;
    
    require_once '../uses_constants/class.DatabaseConstants.php';
    require_once '../uses_classes/class.DBase.php';

    $db = new DatabaseConstants();
    $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
    $dBase->setDatabaseName($db->getDb());

    if(!$dBase->connectDatabase()){
        die('SQL ERROR at db class vd fn');
    }
    
    //handling submit
    if(isset($_POST['submit'])){
        $adquery = 'INSERT INTO ads (Title,Link,ViewLimit,Pays) VALUES ("'.$_POST['title'].'","'.$_POST['link'].'","'.$_POST['views'].'","'.$_POST['pays'].'")';
        mysqli_query($dBase->getDbobj(), $adquery);
        if(!mysqli_affected_rows($dBase->getDbobj())<1){
            $done = true;
        }
        $id = 0;
        $qryE = mysqli_query($dBase->getDbobj(), 'SELECT Id FROM ads');
        while($dataE = mysqli_fetch_assoc($qryE)){
            $id = $dataE['Id'];
        }
        
        $userQueryE = mysqli_query($dBase->getDbobj(),'SELECT id FROM members');
        while($userDataE = mysqli_fetch_assoc($userQueryE)){
            mysqli_query($dBase->getDbobj(), 'INSERT INTO view (MemberId,AdId) VALUES ("'.$userDataE['id'].'","'.$id.'")');
        }
    }
    
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            Add Advertisement's
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
        <fieldset id="rightBar" style="font-weight: bold;height: 470px">
           <form id="msform" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <center>
                <?php
                    if(isset($_POST['submit']) && !$done){
                        echo '<h3 style="color:red;">Something went wrong!</h3>';
                    }
                    
                    if($done){
                        echo '<h3 style="color:green;">Advertisement Added and is Active.</h3>';
                    }
                ?>
                    
                    Title <input type="text" name="title" placeholder="Enter Site Title" required="true"/> <br><br>
                    Link to Page <input type="text" name="link" placeholder="Enter Site Link" required="true"/><br><br>
                    Number of Viewers to send<input type="text" name="views" placeholder="Enter number of views to send" required="true"/><br><br>
                    Pays<input type="text" name="pays" placeholder="Enter amount to pay per view" required="true"/><br><br>
                    <input type="submit" name="submit" class="NormButton" Value="Submit" />
                </center>
            </form>
        </fieldset>
    
    
</div>

<?php
}

echo $siteConstant->getTail();