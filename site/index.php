
<?php
/**
The MIT License (MIT)

Shaheed Ahmed Dewan Sagar
Email : sdewan64@gmail.com
Ahsanullah University of Science and Technology, Dhaka, Bangladesh.
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

$siteConstant->addFile('css','account.css');

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
$siteQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM siteinfo WHERE id=1');
$siteData = mysqli_fetch_assoc($siteQuery);

?>
<?php

    if(isset($_GET['ref'])){
        $_SESSION['ref'] = $_GET['ref'];
    }

?>

<div style="padding-top: 100px">
    <center>
        <p><span class="idx-title" style="font-size: 48px"> GET PAID </span></p>
        <p><span class="idx-title" style="color:#eee;">EVERY <span style="font:bold 38px Verdana,Arial,Helvetica,sans-serif;">30</span> SECONDS!</span></p>
        <p class="idx-subtitle" style="margin-top:14px;width:520px;color: purple">Now you can earn just by viewing ads.</p>
    
        <br><br>
        <p class="idx-subtitle" style="font:bold 38px Verdana,Arial,Helvetica,sans-serif;font-size: 24px;color:#000;text-align: center">
            Welcome! <br>
            Now you can multiply your earnings just by viewing advertisements. <br>
            At <?php echo $siteData['title']; ?> you get paid just for browsing our advertisers' websites.
        </p>
        
        <br><br><br>
        
    </center>
        
    <p class="idx-subtitle" style="font:bold 38px Verdana,Arial,Helvetica,sans-serif;font-size: 18px;color:green;text-align: center">
                <span style="text-decoration: underline">Benefits as a Member : <br><br></span>
                As a member you can earn simply by viewing all the advertisements we display. <br><br>
                -Effortless income <br>
                - Earn from home <br>
                - Guaranteed ads daily <br>
                - Detailed statistics <br>
                - Upgrade opportunities <br>
                - A dedicated community <br>
                - Enhanced management <br>
                - Millions of potential clients <br>
                - Demographic filter <br>
                - Strong anti-cheat protection <br>
                - Detailed statistics <br>
                - Your needs, your choice <br>
                - Secure and stable environment <br>
                - Professional support<br>
                - Instant services<br>
                - High traffic<br>
                - Innovative ideas<br>
                - Customer oriented business<br>
                - Registration is FREE!<br>
    </p>
<br><br><p class="idx-subtitle" style="color:red;text-align:center;">All Rights Reserved by Shaheed Ahmed Dewan Sagar &copy; 2014</p>
</div>
<?php

echo $siteConstant->getTail();