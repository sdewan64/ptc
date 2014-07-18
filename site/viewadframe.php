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
require_once '../uses_constants/initSite.php';

?>
<style>
    body{
    // background-color: #090400;
    line-height: 1;
    font-family: sans-serif;
    background: #eedfcc url(../image/background.jpg) no-repeat center top;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    overflow-y: scroll;
    overflow-x: hidden;
    text-align: center;
   }
   div{
       padding-top:5px;
       color: green;
       font-weight: bold;
       font:bold 18px/1.5em Garamond,Georgia,"Times New Roman",Times,serif;
       color:#99D6FA;
       text-shadow: 0 1px 1px #000000;
       color: green;
   }
</style>

<script type="text/javascript" src="../uses_script/jquery.js"></script>
<script type="text/javascript">
var time = 31;

var getAdId = function(){
    var params = {};
    var param_array = window.location.href.split('?')[1].split('&');
    for(var i in param_array){
        x = param_array[i].split('=');
        params[x[0]] = x[1];
    }
    return params;
}();

var adid = getAdId.adid;

var auto_refresh = setInterval(function (){
    time--;
    if(time>=0){
        $('#timer').html(time+" seconds remaining...");
    }else if(time>=-3){
        $('#timer').html("Verifying and Crediting your account");
    }else if(time==-4){
        $.ajax({
            type: 'POST',
            data: 'adid='+adid,
            url: 'validateclick.php',
            success: function(data){
                $('#timer').html(data);
            }
        });
    }
}, 1000);
</script>

<body>
    <div id="timer"> </div>
</body>