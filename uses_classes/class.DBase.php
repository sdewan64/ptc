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
class DBase {
    private $_host;
    private $_user;
    private $_pass;
    private $_databaseName;
    
    private $_dbobj;
    
    public function __construct($h,$u,$p) {
        $this->_host = $h;
        $this->_user = $u;
        $this->_pass = $p;
    }
    
    public function setDatabaseName($dn){
        $this->_databaseName = $dn;
    }
    
    public function connectDatabase(){
        $this->_dbobj = mysqli_connect($this->_host,  $this->_user, $this->_pass);
        if(!$this->_dbobj){
            die(mysqli_error());
        }
        
        if($this->_databaseName == NULL){
            die('You must specify a database name before connecting');
        }else{
            if(!mysqli_select_db($this->_dbobj,$this->_databaseName)){
                die(mysqli_errno($this->_dbobj));
            }
        }
        return true;
    }
    
    public function closeDatabse(){
        mysqli_close($this->_dbobj);
    }
    
    public function getDbobj(){
        return $this->_dbobj;
    }
    
}
