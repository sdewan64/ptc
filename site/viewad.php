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

echo $siteConstant->getHead();

$link = $_GET['l'];
$adid = $_GET['aid'];

$framelink = 'viewadframe.php?adid='.$adid;

?>
<style>
    html, body {
    margin: 0px;
    padding: 0px;
    border: 0px;
    width: 100%;
    height: 100%;
}
    #siteFrame {
        width: 100%;
        height: 10%;
        margin: 0px;
        padding: 0px;
        background: blue;
        border: 0px;
        display: block;    
}
#adFrame {
        width: 100%;
        height: 90%;
        margin: 0px;
        padding: 0px;
        background: blue;
        border: 0px;
        display: block;
        
}
</style>
<iframe id='siteFrame' name='siteFrame' src='<?php echo $framelink; ?>' scrolling='no'><p>Your browser does not support iframes.</p></iframe>
<iframe id='adFrame' name='adFrame' src='<?php echo $link; ?>' scrolling='yes'><p>Your browser does not support iframes.</p></iframe>