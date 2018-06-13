var fName = document.getElementById("first_name");
var lName  = document.getElementById("last_name");
var uEmail = document.getElementById("email_address");
var first  = document.getElementById('first');

if(fName != null && lName != null && uEmail != null) {
		
	fName.addEventListener('blur', fNameVal );	
	lName.addEventListener('blur', lNameVal );
	uEmail.addEventListener('blur', emailVal );
	


first.addEventListener("click", function(e) {
		
		globalVal = true;
		emailVal();
		fNameVal();
		lNameVal();
		
		if(!globalVal) {
			
			e.preventDefault();
		}

});

   function emailVal() {

		var value = uEmail.value;
		var error = uEmail.previousElementSibling.previousSibling;	
		var format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		
		if(value.length == 0) {
			
			error.innerHTML = 'is required';
			globalVal = false;
			
		}else if (!value.match(format)) {
			
			error.innerHTML = 'not valid email';
			globalVal = false;
			
		}else {
			
			error.innerHTML = '';
		}
		
   }

    function fNameVal() {

		var value = fName.value;
		var error = fName.previousElementSibling.previousSibling;
		
		if(value.length == 0) {
		
		    error.innerHTML = 'is required';
		    globalVal = false;
		    
		}else if(value.length > 30) {
		    
		    error.innerHTML = 'max 30 characters';
		    globalVal = false;
		    
		}else if(value.length < 3) {
		    
		    error.innerHTML = 'min 3 characters';
		    globalVal = false;
		}else {
		    
		    error.innerHTML = '';
		}
    }



    function lNameVal() {
	
	    var value = lName.value;
	    var error = lName.previousElementSibling.previousSibling;
	
	    if(value.length == 0) {
	
	        error.innerHTML = 'is required';
	        globalVal = false;
	        
	    }else if(value.length > 30) {
		    
		    error.innerHTML = 'max 30 characters';
		    globalVal = false;
		    
	    }else if(value.length < 3) {
		    
		    error.innerHTML = 'min 3 characters';
		    globalval = false;
	    }else {
		    
		    error.innerHTML = '';
	    }
	 }
   }


// second part 


var mNumber = document.getElementById('mobile_number');
var dBirth  = document.getElementById('date_of_birth');

if(mNumber != null && dBirth != null) {
	
  mNumber.addEventListener('blur', numVal);
  dBirth.addEventListener('blur', dateVal);



// submit
    second.onclick = function(e) {
		  
		 globalVal = true;
		  
		 numVal();
		 dateVal();
		 checkBox();
		 
		 if(!globalVal) {
			 
			e.preventDefault();
		 }
   }

function checkBox() {
	
	  var genEr = document.getElementById("genEr");
	  var male = document.getElementById("male");
	  var female = document.getElementById("female");
	  
	  if(male.checked != true && female.checked != true) {
		  
		  genEr.innerHTML = 'is required';
		  globalVal = false;
		  
	  }else {
		  
		  genEr.innerHTML = '';
	  }
	
} 




    function numVal() {
		
		 var value = mNumber.value;
		 var error = mNumber.previousElementSibling.previousSibling;	
		 
		 console.log(value.length);
		 
		 if(value.length == 0) {
			 
			 error.innerHTML = 'is required';
			 globalVal = false;
			 
		 }else if( value.length > 11 || value.length < 9 || isNaN(value)) {
			 
			 error.innerHTML = 'Phone num. only';
			 globalVal = false;
			 
		 }else {
			 
			 error.innerHTML = '';
		 }
    }


    function dateVal() {
		
		 var value = dBirth.value;
		 var error = dBirth.previousElementSibling.previousSibling;
		 var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
		 
		 if(value.length == 0) {
			 
			 error.innerHTML = 'is required';
			 globalVal = false;
			 
		 }else if(!value.match(pattern)) {
			 
			 error.innerHTML = 'format dd/mm/yyyy';
			 globalVal = false;
			 
		 }else {
			 
			 error.innerHTML = '';
		 }
	  }
   }
   
   

var text = document.getElementById('text');

if(text != null) { 
  text.addEventListener('blur', function(e){
		
		 var value = e.target.value;
		 var error = e.target.previousElementSibling.previousSibling;	
		 if(value.length > 500) {
			 error.innerHTML = "max char 500";
		 }else {
			 error.innerHTML = '';
		 }
  });
}