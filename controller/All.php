<?php
class All  {
	
	 // driver, database and host
     protected $dsn;
     // user to access database
	 protected $user;
     // password to access database
	 protected $password;  
	  // connection handler 
	 public $pdo;	 
	 // data from database
	 public $data;	  
	 // database query
	 protected $query;
	 // last operaton id 
	 public $last_insert_id;
	 // error exception 
	 public $errors;
	 // validate properties
	 public $validate_errors    = array();
	 protected $check  = false;
	 public $post_data = array();
		 
	
	
	public function __construct($data) {
		
			 	
	    if(count($data) == 3) {
			   $this->dsn      = $data['dsn'];
			   $this->user     = $data['user'];
			   $this->password = $data['password'];
		     }
		     
		     		
		try {
			 
			  $this->pdo = new PDO($this->dsn, $this->user, $this->password);
			  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {

              $this->errors = $e->getMessage();
            
             // echo "<h1>Server is temporary down please come back later on.</h1>";  
              
        die();
		}
		
	}
	
	public function simpleQurey($sql,$data) {
		 
		
	}
	
	
    public function doQuery($sql, $data = null) {

              $this->query = $this->pdo->prepare($sql);
         
              $this->pdo->beginTransaction();
          
        try {
              $this->query->execute($data);
		      
		      $this->pdo->commit();
		      $this->last_insert_id = $this->pdo->lastInsertId();
	  
   } catch (PDOException $e) {
	
	          $this->errors =  $e->getmessage();
	          $this->pdo->rollBack();
       }
   }  
	
	public function getData() {
		
		    return $this->query;
		
	}
   
 		
	public function lastInsertId() {
		
		   return $this->last_insert_id;
	}
    
	public function errors() {
		 
		   return $this->errors;
	}
	
	// disconnect any active database connection 
	public function emptyPDO() {
		
		   $this->pdo = null;
		   $this->data_fetch = null;
	}

	
    public static function set($name, $second = null) {
			
	    if($second != null) {
			
		if(isset($_SESSION[$name][$second])) {
				
			  return  $_SESSION[$name][$second];
			
		 }elseif(isset($_POST[$name][$second])) {
			 
			 return $_POST[$name][$second];
		 }
		
		}	
		
		if(isset($_POST[$name])) {
			 
			 return $_POST[$name];
			 
		}elseif(isset($_GET[$name]))  {
			
			 return $_GET[$name];
			
		}elseif(isset($_SESSION[$name])) {
			
			 return $_SESSION[$name];
			 
		}elseif(isset($_COOKIE[$name])) {
			
			return $_COOKIE[$name];
			
			}elseif(isset($_FILES[$name]))  {
				
			return $_FILES[$name];
			
		}else {
			
			return false;
		}
  }


	
    public function validate($post, $rules) {
    
       
       foreach($rules as $name => $array_rules) {
	       
	       if(isset($post[$name])) {
		      
		       $post_value  = trim($post[$name]);
		       
		       if(isset($array_rules["fieldName"])) {
		            
		            $field_name = $array_rules["fieldName"];
		       }
		   
		   
		   if(isset($array_rules["required"])) {
			   			   
			   $this->required($post_value, $field_name, $array_rules["required"]);
			   
		   }    
		    
		   if(isset($array_rules["maxLeng"])) { 
			   
			   $this->maxLeng($post_value, $field_name, $array_rules["maxLeng"]);
			   
		   }
		   if(isset($array_rules["minLeng"])) {
			   
			   $this->minLeng($post_value, $field_name, $array_rules["minLeng"]);
			   
		  }
		   if(isset($array_rules["number"])) { 
			   
			   $this->number($post_value, $field_name, $array_rules["number"]);
			   
		   }
		   
		   if(isset($array_rules["isString"])) { 
			   
			   $this->isString($post_value, $field_name, $array_rules["isString"]);
			   
		   }
		   
		   
		   if(isset($array_rules["email"])) { 
			   
			   $this->email($post_value, $field_name, $array_rules["email"]);
			   
		   }
		   
		   
      	   if(isset($array_rules["passwordMatch"])) { 
	      	   
	      	   $this->passwordMatch($post_value, $field_name, $post[$array_rules["passwordMatch"]]);
	      	   
      	   }
      	   
	   	   if(isset($array_rules["valueExist"])) { 

              $this->valueExist($post_value, $field_name, $array_rules["valueExist"]);


	   	   }
	    }
     }
    }
	
    public function required($post, $field_name, $rule = null) {
	 
	   if(empty($post)) {
		 $this->validate_errors[$field_name]  = "is required.";
	   }
	
   }
 
    public function maxLeng($post, $field_name, $rule = null) {
	 
	   if(strlen($post) > $rule) {
		   $this->validate_errors[$field_name] = "max characters ".$rule;
	   }
    }
 
    public function minLeng($post, $field_name, $rule = null) {
	 
	   if(strlen($post) < $rule and !empty($post)) {
		   $this->validate_errors[$field_name] = "min characters ".$rule;
	  }
  }

    public function number($post , $field_name, $rule = null) {
	 
	   if(!is_numeric($post)) {
		  $this->validate_errors[$field_name] = "has to be number.";
	   }
	 
   }
 
    public function isString($post, $field_name, $rule = null) {
	 
	    if(!empty($post)) {
	      if(!is_string($post)) {
		   $this->validate_errors[$field_name] = "has to be string.";
	      }
	   }
 }
 
    public function email($post, $field_name, $rule = null) {
	 
	 if(!empty($post)) {
        if(!filter_var($post, FILTER_VALIDATE_EMAIL)) {
	     
	     $this->validate_errors[$field_name] = "is not valid.";
       }
     }
} 
 
    public function passwordMatch($post, $field_name, $rule = null) {
	
	   if(!empty($post)) {
	     	if($post != $rule) {
			 $this->validate_errors[$field_name] = "does not match.";
		  }
	  }
    } 
    public function valueExist($post, $field_name, $rule = null) {
	    
			    if(!empty($post)) {
			    $table   = $rule[0];
			    $column  = $rule[1];
			    $value[] = $post;
			    
			    $sql = "SELECT * FROM $table WHERE $column = ?";
			    $this->doQuery($sql, $value);
			    
	    if(count($this->errors) == 0) {
		    
		       $data_len = $this->query->fetch(PDO::FETCH_ASSOC);
            
            if(count($data_len) > 1) {
               
		       $this->validate_errors[$field_name] = "already exists";
		   
		    }
	     }
	   } 
    }
 
    public function getErrors($name = null) {
	
	   if($name != null) {
	 
	     if(isset($this->validate_errors[$name])) {
		 // return one value 
		   return $this->validate_errors[$name];
		 
	     }	
	    }else {
		 // return array
		   return $this->validate_errors;
	 }
 }
}


