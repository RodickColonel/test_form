<?php
session_start();
require_once "controller/All.php";
require_once "controller/function.php";
require_once "controller/config.php";

$All = new All($DB_credential);


if(isset($_POST["first_name"]) and isset($_POST["last_name"]) and isset($_POST["email_address"]) ) {
	
	
$rule = array(
	'first_name'    => array('fieldName'=>'first_name','required'=>true,'maxLeng'=>30,'minLeng'=>3),
	'last_name'     => array('fieldName'=>'last_name','required'=>true,'maxLeng'=>30,'minLeng'=>3),
	'email_address' => array('fieldName'=>'email_address','required'=>true,'email'=>true,
	                         'valueExist'=> ['vision', 'email_address'])
     );
	
	$All->validate($_POST, $rule);
	
	if(count($All->getErrors()) == 0) {
		
		$_SESSION["first"] = $_POST;
		
	}
	
	
}
if(isset($_SESSION["first"])) {
	
	if(isset($_POST["mobile_number"]) and isset($_POST["date_of_birth"])) {
		
	$rule = array(
	 'mobile_number' => array('fieldName'=>'mobile_number','required'=>true,'maxLeng'=>11,'minLeng'=>9),
     'date_of_birth' => array('fieldName'=>'date_of_birth','required'=>true),
     'gender'        => array('fieldName'=>'gender','required'=>true)
	);
		
		$All->validate($_POST, $rule);
		
		if(count($All->getErrors()) == 0) {
			
			$_SESSION['second'] = $_POST;
		}
		
	}
}

if(isset($_SESSION["second"])) {
	
	if(isset($_POST["comments"])) {
		
		// insert into database
		
		
    $sql  = "INSERT INTO vision(first_name, last_name, email_address,";
    $sql .= "mobile_number, gender, date_of_birth, comments) ";
    $sql .= " VALUES(?,?,?,?,?,?,?)";
    
    $f_name = isset($_SESSION['first']['first_name']) ? $_SESSION['first']['first_name'] : '';
    $l_name = isset($_SESSION['first']['last_name']) ? $_SESSION['first']['last_name'] : '';
    $email  = isset($_SESSION['first']['email_address']) ? $_SESSION['first']['email_address'] : '';
    $mobile = isset($_SESSION['second']['mobile_number']) ? $_SESSION['second']['mobile_number'] : '';
    $birth  = isset($_SESSION['second']['date_of_birth']) ? $_SESSION['second']['date_of_birth'] : '';
    $gender  = isset($_SESSION['second']['gender']) ? $_SESSION['second']['gender'] : '';
    $comments = !empty($_POST["comments"]) ? $_POST["comments"] : 'No comments';
    $data = array($f_name,$l_name,$email,$mobile,$gender,$birth,$comments);
     
     
     
     
     
     $All->doQuery($sql, $data);
     
     if(count($All->errors()) == 0) {
	     
	     session_destroy();
	     header("Location: welcome.php");
     } 
     	
 
	}
}

?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Simple test </title>
  <meta name="description" content="Simple form data">
  <meta name="radek kuhnel" content="Rodick Colonel">

  <link rel="stylesheet" href="style/main.css">
</head>

<body>
	
<div class="main-form">
	
<div class="section-form"><small>Step 1 Your details</small></div>

<?php if(!isset($_SESSION["first"])) { ?>

	<div class="body-form">
	<form method="post" action="index.php">
	<div class="div-form">	
	<label for="first_name">First name:</label>
	<small class="error">* <?php echo $All->getErrors('first_name'); ?></small><br>
	<input type="text" name="first_name" id="first_name"
	value="<?php echo $All::set('first_name'); ?>">
	</div>
	<div class="div-form">
	<label for="last_name">Last name</label>
	<small class="error">* <?php echo $All->getErrors('last_name'); ?></small><br>
	<input type="text" name="last_name" id="last_name"
	value="<?php echo $All::set('last_name'); ?>">
	</div>
	
	<div class="div-form">
	<label for="email_address">Email address</label>
	<small class="error">* <?php echo $All->getErrors('email_address'); ?></small><br>
	<input type="text" name="email_address" id="email_address"
	value="<?php echo $All::set('email_address'); ?>">
	</div>
	
	<input type="submit" value="Next >" id="first">
	
	
	</form>
		
	</div>
	
<?php  } ?>	
		


<div class="section-form"><small>Step 2 Your details</small></div>

<?php if(isset($_SESSION["first"]) and !isset($_SESSION["second"])) { ?>

	<div class="body-form">
	<form method="post" action="index.php">
	<div class="div-form">	
	<label for="mobile_number">Mobile number</label>
	<small class="error">* <?php echo $All->getErrors('mobile_number'); ?></small><br>
	<input type="text" name="mobile_number" 
	value="<?php echo $All::set('mobile_number'); ?>" id="mobile_number"> 	     
	</div>
	
	<div class="div-form">
	<label for="date_of_birth">Date of birth</label>
	<small class="error">* <?php echo $All->getErrors('date_of_birth'); ?></small><br>
	<input type="text" name="date_of_birth" id="date_of_birth" placeholder="format: dd/mm/yyyy"
	value="<?php echo $All::set('date_of_birth'); ?>">
	</div>
	
	
	<div class="div-form">
	<label>Gender</label>
	<small class="error" id="genEr">* <?php echo $All->getErrors('gender'); ?></small><br>
	<input type="radio" name="gender" value="" 
	<?php echo $All::set('gender') == '' ? 'checked' : ''; ?> hidden >
	<label for="male">Male</label>
	<input type="radio" name="gender" id="male" value="male" id="male"
	<?php echo $All::set('gender') == 'male' ? 'checked' : ''; ?> >
	<label for="female">Female</label>
	<input type="radio" name="gender" id="female" value="female" id="female"
	<?php echo $All::set('gender') == 'female' ? 'checked' : ''; ?> >
	</div>
	
	<input type="submit" value="Next  >"  id="second">
	</form>	
	</div>
	
<?php } ?>

<div class="section-form"><small>Step 3 Final Comments</small></div>
<?php  if(isset($_SESSION['second'])) { ?>

	<div class="body-form">
	<form method="post" action="index.php">
	<label for="comments">Your Comments</label>
	<small class="error"></small><br>
	<textarea cols="40" rows="4" name="comments" id="text"><?php echo $All::set('comments'); ?></textarea>
	<input type="submit" value="Submit">
	</form>	
	</div>

<?php } ?>
</div>	
	
	
	
  <script src="js/script.js"></script>
</body>
</html>