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
class Register {
    
    private $username;
    private $password;
    private $cpassword;
    private $passmd5;
    private $email;
    
    private $errors;
    private $token;
    
    private $name;
    private $country;
    private $payment1;
    private $payment2;
    private $payment3;
    private $ref;
    
    public function __construct() {
        $this->errors = array();
        
        $this->username = $this->filter($_POST['username']);
        $this->password = $this->filter($_POST['password']);
        $this->cpassword = $this->filter($_POST['cpassword']);
        $this->email = $this->filter($_POST['mail']);
        $this->name = $this->filter($_POST['name']);
        $this->country = $this->filter($_POST['country']);
        $this->payment1 = $this->filter($_POST['payment1']);
        $this->payment2 = $this->filter($_POST['payment2']);
        $this->payment3 = $this->filter($_POST['payment3']);
        $this->ref = $this->filter($_POST['ref']);
        
        $this->passmd5 = md5($this->password);
        $this->token = $this->filter($_POST['token']);
    }
    
    public function process(){
        if($this->validToken() && $this->validData()){
            $this->register();
        }
        return count($this->errors) ? false : true;
    }
    
    public function filter($var){
        return preg_replace('/[^a-zA-Z0-9@.]/','',$var);        
    }
    
    public function register(){
        $db = new DatabaseConstants();
        $dBase = new DBase($db->getHost(),$db->getUser(), $db->getPass());
        $dBase->setDatabaseName($db->getDb());
        if(!$dBase->connectDatabase()){
            die('SQL ERROR at db class vd fn');
        }
        
        $qry = "INSERT INTO members (id,username,password,passmd5,email,country,paymenttype1,paymenttype2,paymenttype3,referredby) VALUES('','".$this->username."','".$this->password."','".$this->passmd5."','".$this->email."','".$this->country."','".$this->payment1."','".$this->payment2."','".$this->payment3."','".$this->ref."')";
        mysqli_query($dBase->getDbobj(), $qry);
        if(mysqli_affected_rows($dBase->getDbobj())<1){
            $this->errors[] = 'Could not process form';
        }
        $dBase->closeDatabse();
    }
    
    public function getErrors(){
        return $this->errors;
    }
    
    public function validData(){
        
        if($this->password != $this->cpassword){
            $this->errors[] = 'Passwords does not match';
        }
        
        if($this->country == "Country..."){
            $this->errors[] = 'You must select a valid country';
        }
        
        $db = new DatabaseConstants();
        $dBase = new DBase($db->getHost(),$db->getUser(), $db->getPass());
        $dBase->setDatabaseName($db->getDb());
        if(!$dBase->connectDatabase()){
            die('SQL ERROR at db class vd fn');
        }
        
        $qry = "Select username FROM members WHERE username=\"".$this->username."\"";
        $res = mysqli_query($dBase->getDbobj(), $qry);
        
        if(mysqli_num_rows($res)){
            $this->errors[] = 'Username Already Taken!';
        }
        
        $qry = "Select email FROM members WHERE email=\"".$this->email."\"";
        $res2 = mysqli_query($dBase->getDbobj(), $qry);
        
        if(mysqli_num_rows($res2)){
            $this->errors[] = 'Email Address is Already registered!';
        }
        
        return count($this->errors) ? false : true;
    }
    
    public function validToken(){
        if(!isset($_SESSION['token']) || $this->token != $_SESSION['token']){
            $this->errors[] = 'Invalid Submission';
        }
        return count($this->errors) ? false : true;
    }
}
