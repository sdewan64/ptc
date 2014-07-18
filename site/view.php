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

$url=$_SERVER['REQUEST_URI'];
header("Refresh: 2; URL=$url"); 

require_once '../uses_constants/initSite.php';
$siteConstant->addFile('css', 'account.css');

echo $siteConstant->getHead();
echo $siteConstant->getMenu();

require_once '../uses_constants/class.DatabaseConstants.php';
require_once '../uses_classes/class.DBase.php';

$isAdAvailable = false;

$db = new DatabaseConstants();
$dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
$dBase->setDatabaseName($db->getDb());

if(!$dBase->connectDatabase()){
    die('SQL ERROR at db class vd fn');
}

$adsQuery = mysqli_query($dBase->getDbobj(), "SELECT * FROM ads WHERE isActive=1 AND Views < ViewLimit");
if(mysqli_num_rows($adsQuery)){
    $isAdAvailable = true;
}

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    $userQuery = mysqli_query($dBase->getDbobj(), "SELECT * FROM members WHERE username=\"".$_SESSION['username']."\"");
    if(mysqli_num_rows($userQuery)){
        $userData = mysqli_fetch_assoc($userQuery);
    }else{
        die('User Not Found!');
    }    
}
    
?>

<div style="padding-top: 100px">
    <center>
        <legend>
            View Ads
        </legend>
        
        <br>
        
        <fieldset id="rightBar" style="font-weight: bold;float: none;width: 800px">
            <p class="idx-subtitle" style="color: purple;text-decoration: underline">Click on any link to view the Advertisement</p>
           <?php
               if($isAdAvailable){
           ?>
            <table border="2" width="750px" style="text-align: center">
                <tr>
                    <td>AD Title</td>
                    <td>Link</td>
                    <td>Pays</td>
            <?php
                   if(isset($_SESSION['username']) && isset($_SESSION['password'])){
                        while($adsData = mysqli_fetch_assoc($adsQuery)){
                            $qry = mysqli_query($dBase->getDbobj(), 'SELECT isViewed from view where AdId='.$adsData['Id'].' AND MemberId='.$userData['id']);
                            $res = mysqli_fetch_assoc($qry);
                            $hash = md5(uniqid(mt_rand(),true));
                            $hash2 = md5(uniqid(mt_rand(),true));
                            if(!$res['isViewed']){
                                $lnk = 'viewad.php?AD='.$hash.'&l='.$adsData['Link'].'&aid='.$adsData['Id'].'&reg='.$hash2;
                                echo '<tr>';
                                echo '<td>'.$adsData['Title'].'</td>';
                                echo '<td><a href="'.$lnk.'" target="_blank">'.$adsData['Title'].'</a></td>';
                                echo '<td>'.$adsData['Pays'].' Taka</td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                    
                </tr>
            </table>
           <?php
                   }else{
                       while($adsData = mysqli_fetch_assoc($adsQuery)){
                            $hash = md5(uniqid(mt_rand(),true));
                            $hash2 = md5(uniqid(mt_rand(),true));
                            $lnk = 'viewad.php?AD='.$hash.'&l='.$adsData['Link'].'&aid='.$adsData['Id'].'&reg='.$hash2;
                            echo '<tr>';
                            echo '<td>'.$adsData['Title'].'</td>';
                            echo '<td><a href="'.$lnk.'" target="_blank">'.$adsData['Title'].'</a></td>';
                            echo '<td>'.$adsData['Pays'].' Taka</td>';
                            echo '</tr>';
                       }                       
                   }
               }else{
                   echo '<center><h3 style="color:red">No ads available right now.<br><br>Check back later.</h3></center>';
               }
           ?>
        </fieldset>
        
    </center>
</div>

<?php

echo $siteConstant->getTail();