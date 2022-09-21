var submitError = document.getElementById('submit_error');

function validateForm(){
	var fname = document.getElementById('f_name').value;
	var lname = document.getElementById('l_name').value;
	var phone = document.getElementById('phone').value;
	var email = document.getElementById('email').value;
	var mem_id = document.getElementById('mem_id').value;

	if (fname.length == 0 && lname.length == 0 && phone.length == 0 && email.length == 0 && mem_id.length == 0){
		submitError.style.display = 'block';
		submitError.innerHTML = '<br>At least one field must be entered to search';
		setTimeout(() => {
			submitError.style.display ='none';
		}, 3500);
		return false;
	} 		
}