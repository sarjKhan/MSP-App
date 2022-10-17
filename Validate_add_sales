var dueDateError = document.getElementById('due_date_error');
var itemNameError = document.getElementById('item_name_error');
var quantityError = document.getElementById('iqantity_error');

/*
function validateItemName() {
    var itemName = document.getElementById('itemname').value;
    if (itemName.length == 0) {
        itemNameError.innerHTML = '<br>Must have an item';
        return false;
    }
    itemNameError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}
*/
function validateDueDate() {
    var dueDate = document.getElementById('due_date').value;
    var d_now = new Date();
    var d_inp = new Date(dueDate)
    if (d_now.getTime() >= d_inp.getTime()) {
        dueDateError.innerHTML = '<br>Must be a future Date';
        return false;
    }
    if (dueDate.length == 0) {
        dueDateError.innerHTML = '<br>Must have a due date';
        return false;
    }
    dueDateError.innerHTML ='<i class="fa-solid fa-circle-check"></i>';
	return true;
}

    function validateForm() {
        var submitError = document.getElementById('submit_error');

        if (!validateDueDate()){
            submitError.style.display = 'block';
            submitError.innerHTML = '<br>Please fix errors to submit';

            setTimeout(() => {
                submitError.style.display = 'none';
            }, 3500);
            return false;
        }
    }
