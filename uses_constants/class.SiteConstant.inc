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
/**
 * Description of SiteConstant
 *
 * @author Shaheed Ahmed Dewan Sagar
 */
class SiteConstant {
    
    public $title;
    public $link;
    public $header;
    public $loggedIn;
    
    private $cssFile = array();
    private $jsFile = array();
    private $jqFile = array();
    

    /**
     * initialized the class
     */
    public function __construct($t,$l,$h){
        $this->title = $t;
        $this->link = $l;
        $this->header = $h;
        $this->loggedIn = false;
    }
    /**
     * Returns header html upto body starting tag including external files
     * @return HTML
     */
    public function getHead(){
        $ht = '<!DOCTYPE html>';
        $ht .= '<html><head>
        <title id="title">'.$this->title.'</title>';
        
        foreach ($this->cssFile as $css) {
            $ht .= '<link rel="stylesheet" type="text/css" href="../uses_style/'.$css.'">';
        }
        
        foreach ($this->jsFile as $js) {
            $ht .= '<script type="text/javascript" src="../uses_script/'.$js.'"></script>';
        }
        
        $ht .= '</head><body><div id="header">'.$this->header.'</div>';
        
        return $ht;
    }
    
    /**
     * Returns ending body and html tag along with jqurey callings
     * @return html 
     */
    public function getTail(){
        $ht = "";
        foreach ($this->jqFile as $jq) {
            $ht .= '<script type="text/javascript" src="../uses_script/'.$jq.'"></script>';
        }
        $ht .= '</body></html>';
        return $ht;
    }
    
    /**
     * Returns the Menu
     * @return html
     */
    public function getMenu(){
        
        if(isset($_SESSION['username']) && isset($_SESSION['password'])||isset($_SESSION['adminusername']) && isset($_SESSION['adminpassword'])){
            $this->loggedIn = true;
        }
        if(!$this->loggedIn){
            $ht = '<ul id="menu">
                <li id="m1"><a href="#">Home</a></li>
                <li id="m2"><a href="#">View Ads</a></li>
                <li id="m3"><a href="#">Login</a></li>
                <li id="m4"><a href="#">Register</a></li>
              </ul>';
        }else{
            $ht = '<ul id="menu">
                <li id="m1"><a href="#">Home</a></li>
                <li id="m2"><a href="#">View Ads</a></li>
                <li id="m5"><a href="#">Account</a></li>
                <li id="m6"><a href="#">Logout</a></li>
              </ul>';
        }
        return $ht;
    }
    
    /**
     * Adds external files
     * example addFile("css","style.css");
     * example addFile("js","jscript.js");
     * example addFile("jq","jque.js");
     * @param string $type
     * @param string $fname
     */
    public function addFile($type,$fname){
        if($type == "css"){
            array_push($this->cssFile,$fname);
        }else if($type == "js"){
            array_push($this->jsFile,$fname);
        }else if($type == "jq"){
            array_push($this->jqFile,$fname);
        }
    }
}
