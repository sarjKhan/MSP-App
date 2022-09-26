//const form = document.getElementById('members_form');

var fnameError = document.getElementById('fname_error');
var lnameError = document.getElementById('lname_error');
var phoneError= document.getElementById('phone_error');
var emailError = document.getElementById('email_error');

function validateFName(){
	var fname = document.getElementById('f_name').value;
	if (fname.length == 0 || fname.length <=1 || fname== null){
		fnameError.innerHTML = '<br>Cannot be empty or less than 2 characters';	
		return false;
	}
	if(!fname.match(/^[a-zA-Z]+$/)) {
		fnameError.innerHTML = '<br>Must be correct letter format';
		return false;
	}

	fnameError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}


function validateLName(){
	var lname = document.getElementById('l_name').value;
	if (lname.length == 0 || lname== null){
		lnameError.innerHTML = '<br>Cannot be empty';	
		return false;
	}
	if(!lname.match(/^[a-zA-Z]+$/)) {
		lnameError.innerHTML = '<br>Must be correct letter format';
		return false;
	}
	lnameError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

function validatePhone(){
	var phone = document.getElementById('phone').value;
	if (phone.length == 0 || phone== null){
		phoneError.innerHTML = '<br>Cannot be empty';	
		return false;
	}
	if (phone.length != 10){
		phoneError.innerHTML = '<br>Phone number must be 10 digits';	
		return false;
	}
	if(!phone.match(/^[0-9]{10}$/)) {
		phoneError.innerHTML = '<br>Only number format';
		return false;
	}
	phoneError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

function validateEmail(){
	var email = document.getElementById('email').value;
	if (email.length == 0 || email == null){
		emailError.innerHTML = '<br>Cannot be empty';	
		return false;
	}
	if (!email.match(/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9.-]{3,}\.[a-zA-Z]{2,4}/)) {
		emailError.innerHTML = '<br>Must use correct email format';	
		return false;
	}
	emailError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

function validateForm(){
	var submitError = document.getElementById('submit_error');

	if (!validateFName() || !validateLName() || !validatePhone() || !validateEmail() || submitError == null){
		submitError.style.display = 'block';
		submitError.innerHTML = '<br>Please fix errors to submit';
		setTimeout(() => {
			submitError.style.display ='none';
		}, 2500);
		return false;
	}
}

/*
form.addEventListener('submit', (e) => {
	var fname = document.getElementById('f_name').value;
	let messages = [];
	if (fname.length == 0 || fname== null){
		messages.push('Cannot be empty')	
	}

	if(!fname.match(/[A-Za-z]/)) {
		messages.push('Must be correct letter format')
	}

	if (messages.length > 0){
	e.preventDefault()
	fnameError.innerText = messages.join(', ')
	}
})
*/