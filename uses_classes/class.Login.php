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
 * Description of class
 *
 * @author Shaheed Ahmed Dewan Sagar
 *         email : sdewan64@gmail.com
 */
require_once '../uses_constants/class.DatabaseConstants.php';
require_once 'class.DBase.php';

class Login {

    private $_id;
    private $_username;
    private $_password;
    private $_passmd5;
    
    private $_errors;
    private $_access;
    private $_login;
    private $_token;
    
    
    public function __construct() {
        $this->errors = array();
        $this->_login = isset($_POST['login']) ? true : false;
        $this->_access = false;
        if(isset($_POST['token'])){
            $this->_token = $_POST['token'];
        }
        
        $this->_id = 0;
        $this->_username = ($this->_login) ? $this->filter($_POST['username']) : $_SESSION['username'];
        $this->_password = ($this->_login) ? $this->filter($_POST['password']) : '';
        $this->_passmd5 = ($this->_login) ? md5($this->_password) : $_SESSION['password'];
    }
    
    public function isLoggedIn(){
        ($this->_login) ? $this->verifyPost() : $this->verifySession();
        return $this->_access;
    }
    
    public function filter($var){
        return preg_replace('/[^a-zA-Z0-9]/','',$var);
    }
    
    public function verifyPost(){
        
        try{
            if(!$this->isTokenValid()){
                throw new Exception ('Invalid Submission.Hacking attempt detacted!Administrator informed.');
            }
            
            if(!$this->verifyDatabase()){
                throw new Exception('Invalid Username/Password');
            }
            
            $this->_access = true;
            $this->registerSession();
                
        } catch (Exception $ex) {
            $this->_errors[] = $ex->getMessage();           
        }
    }
    
    public function verifySession(){
        if($this->sessionExist() && $this->verifyDatabase()){
            $this->_access = true;
        }
    }
    
    public function verifyDatabase(){
        $db = new DatabaseConstants();
        $dBase = new DBase($db->getHost(),$db->getUser(), $db->getPass());
        $dBase->setDatabaseName($db->getDb());
        if(!$dBase->connectDatabase()){
            die('SQL ERROR at db class vd fn');
        }
        
        $loginQuery = mysqli_query($dBase->getDbobj(),"SELECT id FROM members WHERE username=\"".$this->_username."\" AND passmd5=\"".$this->_passmd5."\"");
        
        if(mysqli_num_rows($loginQuery)){
            $loginData = mysqli_fetch_assoc($loginQuery);
            $this->_id = $loginData['id'];
            return true;
        }else {
            return false;
        }
        
//        while($loginData = mysqli_fetch_assoc($loginQuery)) {
//            if($loginData['username'] == $this->_username){
//                echo 'gothere<br>';
//                return true;
//            }
//        }
//       return false;
        
    }
    
    public function isTokenValid(){
        return (!isset($_SESSION['token']) || $this->_token != $_SESSION['token']) ? false:true;
    }
    
    public function registerSession(){
        $_SESSION['id'] = $this->_id;
        $_SESSION['username'] = $this->_username;
        $_SESSION['password'] = $this->_passmd5;
    }
    
    public function sessionExist(){
        return (isset($_SESSION['username']) && isset($_SESSION['password'])) ? true : false;
    }
    
    public function showErrors(){
        foreach($this->_errors as $key => $value){
            echo $value."<br>";
        }
    }
    
}
