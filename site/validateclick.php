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

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    require_once '../uses_constants/class.DatabaseConstants.php';
    require_once '../uses_classes/class.DBase.php';

    $prob = false;

    $db = new DatabaseConstants();
    $dBase = new DBase($db->getHost(), $db->getUser(), $db->getPass());
    $dBase->setDatabaseName($db->getDb());

    if(!$dBase->connectDatabase()){
        die('SQL ERROR at db class vd fn');
    }
    
    if(isset($_POST['adid'])){
        $adid = $_POST['adid'];
        $adsQuery = mysqli_query($dBase->getDbobj(),'SELECT * FROM ads WHERE Id='.$adid);
        
        if(mysqli_num_rows($adsQuery)){
            $adsData = mysqli_fetch_assoc($adsQuery);
            $paylast = $pays = $adsData['Pays'];
            $view = $adsData['Views'];
            $view++;
            
            if($view>=$adsData['ViewLimit']){
                mysqli_query($dBase->getDbobj(), 'UPDATE ads SET IsActive=0 WHERE Id="'.$adid.'"');
                mysqli_query($dBase->getDbobj(), 'UPDATE ads SET Views='.$view.' WHERE Id="'.$adid.'"');
                if(!mysqli_affected_rows($dBase->getDbobj())<2){
                    echo 'Something went wrong';
                    $prob = true;
                }
            }else{
                mysqli_query($dBase->getDbobj(), 'UPDATE ads SET Views='.$view.' WHERE Id="'.$adid.'"');
            }
        }else {
            echo 'Something went wrong';
        }
        
        $userQuery = mysqli_query($dBase->getDbobj(), 'SELECT * FROM members WHERE username="'.$_SESSION['username'].'"');
        $userData = mysqli_fetch_array($userQuery);
        
        $viewQuery = mysqli_query($dBase->getDbobj(), 'SELECT isViewed FROM view WHERE MemberId='.$userData['id'].' AND AdId='.$adid);
        $viewData = mysqli_fetch_assoc($viewQuery);
        
        if($viewData['isViewed']==0){

            mysqli_query($dBase->getDbobj(), 'UPDATE members SET selfclick='.($userData['selfclick']+1).' WHERE username="'.$userData['username'].'"');      
            mysqli_query($dBase->getDbobj(), 'UPDATE members SET balance='.($userData['balance']+$pays).' WHERE username="'.$userData['username'].'"');
            mysqli_query($dBase->getDbobj(), 'UPDATE members SET selfclickearn='.($userData['selfclickearn']+$pays).' WHERE username="'.$userData['username'].'"');

            //setting viewed in view table
            mysqli_query($dBase->getDbobj(), 'UPDATE view SET isViewed=1 WHERE MemberId='.$userData['id'].' AND AdId='.$adid);


            //Updating upline
            $pays = (float)$pays/2;
            $upline = $userData['referredby'];

            $userQueryu = mysqli_query($dBase->getDbobj(), 'SELECT * FROM members WHERE username="'.$upline.'"');
            $userDatau = mysqli_fetch_array($userQueryu);

            mysqli_query($dBase->getDbobj(), 'UPDATE members SET refclick='.($userDatau['refclick']+1).' WHERE username="'.$userDatau['username'].'"');  
            mysqli_query($dBase->getDbobj(), 'UPDATE members SET balance='.($userDatau['balance']+$pays).' WHERE username="'.$userDatau['username'].'"');
            mysqli_query($dBase->getDbobj(), 'UPDATE members SET refclickearn='.($userDatau['refclickearn']+$pays).' WHERE username="'.$userDatau['username'].'"');



            if(!$prob){
                echo 'Account Credited with '.$paylast.' Taka.<br>You can now close the tab.';
            }
        
        }else{
            echo 'Cheat Detected!';
        }
        
    }else{
        echo 'Something went wrong!11';
    }
    
}else{
    echo 'You would have been credited if you were a member.<br>Register free to earn by visiting sites like this.';
}