//const form = document.getElementById('members_form');

var fnameError = document.getElementById('fname_error');
var lnameError = document.getElementById('lname_error');
var phoneError= document.getElementById('phone_error');
var addressError = document.getElementById('address_error');
var submitError = document.getElementById('submit-error')

function validateFName(){
	var fname = document.getElementById('f_name').value;
	if (fname.length == 0 || fname.length <=2 || fname== null){
		fnameError.innerHTML = 'Cannot be empty or less than 3 characters';	
		return false;
	}
	if(!fname.match(/^[a-zA-Z]+$/)) {
		fnameError.innerHTML = 'Must be correct letter format';
		return false;
	}

	fnameError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}


function validateLName(){
	var lname = document.getElementById('l_name').value;
	if (lname.length == 0 || lname== null){
		lnameError.innerHTML = 'Cannot be empty';	
		return false;
	}
	if(!lname.match(/^[a-zA-Z]+$/)) {
		lnameError.innerHTML = 'Must be correct letter format';
		return false;
	}
	lnameError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

function validatePhone(){
	var phone = document.getElementById('phone').value;
	if (phone.length == 0 || phone== null){
		phoneError.innerHTML = 'Cannot be empty';	
		return false;
	}
	if (phone.length != 10){
		phoneError.innerHTML = 'Phone number must be 10 digits';	
		return false;
	}
	if(!phone.match(/^[0-9]{10}$/)) {
		phoneError.innerHTML = 'Only number format';
		return false;
	}
	phoneError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

function validateAddress(){
	var address = document.getElementById('address').value;
	if (address.length == 0 || address == null){
		addressError.innerHTML = 'Cannot be empty';	
		return false;
	}
	addressError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

function validateForm(){
	if (!validateFName() || !validateLName() || !validatePhone() || !validateAddress()){
		submitError.style.display = 'block';
		submitError.innerHTML = 'Please fix errors to submit';
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