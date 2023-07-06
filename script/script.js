"use strict";
window.addEventListener("DOMContentLoaded", init);

let timeout;

function init() {
    const strengthBadge = document.getElementById('strengthDisp');
    const registerFirstname = document.querySelector('#registerFirstname');
    const registerLastname = document.querySelector('#registerLastname');
    const registerEmail = document.querySelector('#registerEmail');
    const registerPassword = document.querySelector('#registerPassword');
    const registerPasswordConfirm = document.querySelector('#registerPasswordConfirm');

    const registerAge = document.querySelector('#registerAge');
    const registerPhone = document.querySelector('#registerPhone');

    const resetPassword = document.querySelector('#resetPassword');
    const resetPasswordConfirm = document.querySelector('#resetPasswordConfirm');

    const registerGenderMale = document.querySelector('#registerGenderMale');
    const registerGenderFemale = document.querySelector('#registerGenderFemale');

    const registerUserTypeUser = document.querySelector('#registerUserTypeUser');
    const registerUserTypeTrainer = document.querySelector('#registerUserTypeTrainer');


    const registerTrainerBiography = document.querySelector('#registerTrainerBiography');

    //const registerGender = document.querySelectorAll('input[name="gender"]:checked');
    //const registerRole= document.querySelectorAll('input[name="usertype"]:checked');


    const fl = document.querySelector('#fl');
    const registerForm = document.querySelector('#registerForm');
    const loginForm = document.querySelector('#loginForm');
    const forgetForm = document.querySelector('#forgetForm');
    const resetForm = document.querySelector('#resetForm');
    const editForm = document.querySelector('#editForm');
    const insertForm = document.querySelector('#insertForm');
    
    const trainerProgramForm1 = document.querySelector('#trainerProgramForm1');
    const trainerProgramForm2 = document.querySelector('#trainerProgramForm2');

    if (fl !== null) {
        fl.addEventListener('click', function (e) {
            let forgetForm = document.querySelector('#forgetForm');

            if (forgetForm.style.display !== "block") {
                forgetForm.style.display = "block";
                this.textContent = 'Hide form.';
            } else {
                forgetForm.style.display = "none";
                this.textContent = 'Have you forgotten your password?';
            }

            e.preventDefault();
        });
    }

    if (registerForm !== null) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (validateForm()) this.submit();
        });
    }

    if (insertForm !== null) {
        insertForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;


            const insertExerciseTitle =document.querySelector('#insertExerciseTitle');
            const insertExerciseUnit =document.querySelector('#insertExerciseUnit');
            const insertExerciseImage =document.querySelector('#insertExerciseImage');
            const insertExerciseLink =document.querySelector('#insertExerciseLink');
            const insertExerciseDescription =document.querySelector('#insertExerciseDescription');

            const file = insertExerciseImage.files[0];

            if (isEmpty(insertExerciseImage.value.trim())) {
                showErrorMessage(insertExerciseImage, "Image can't be empty.");
                isValid = false;
            }
            else if (!isFileImage(file)) {
                showErrorMessage(insertExerciseImage, "File must be an image.");
                isValid = false;
            }
            else {
                hideErrorMessage(insertExerciseImage);
            }

            if (isEmpty(insertExerciseTitle.value.trim())) {
                showErrorMessage(insertExerciseTitle, "Title can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(insertExerciseTitle);
            }

            if (isEmpty(insertExerciseUnit.value.trim())) {
                showErrorMessage(insertExerciseUnit, "Choose a unit.");
                isValid = false;
            } else {
                hideErrorMessage(insertExerciseUnit);
            }


            if (isEmpty(insertExerciseLink.value.trim())) {
                showErrorMessage(insertExerciseLink, "Link can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(insertExerciseLink);
            }

            if (isEmpty(insertExerciseDescription.value.trim())) {
                showErrorMessage(insertExerciseDescription, "Description can't be empty.");
                isValid = false;
            }
            else {
                hideErrorMessage(insertExerciseDescription);
            }

            if (isValid) this.submit();
        });
    }

    if (trainerProgramForm1 !== null) {
        trainerProgramForm1.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;


            const programName =document.querySelector('#programName');
            const programCategory =document.querySelector('#programCategory');
            const programDay =document.querySelector('#programDay');

            if (isEmpty(programName.value.trim())) {
                showErrorMessage(programName, "Name your program!");
                isValid = false;
            } else {
                hideErrorMessage(programName);
            }

            if (isEmpty(programCategory.value.trim())) {
                showErrorMessage(programCategory, "Choose a category.");
                isValid = false;
            } else {
                hideErrorMessage(programCategory);
            }

            if (isEmpty(programDay.value.trim())) {
                showErrorMessage(programDay, "Choose at least 1 day.");
                isValid = false;
            } else {
                hideErrorMessage(programDay);
            }

            if (isValid) this.submit();
        });
    }

    if (trainerProgramForm2 !== null) {
        trainerProgramForm2.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;


            const numberInput = document.querySelectorAll('input[type="number"]');

            numberInput.forEach(function (numberInput){
            if (isEmpty(numberInput.value.trim())) {
                showErrorMessage(numberInput, "Type in your exercise count!");
                isValid = false;
            } else if (isNaN(numberInput.value.trim()) || numberInput.value.trim()   <= 0) {
                showErrorMessage(numberInput, "Please enter a positive number!");
                isValid = false;
            }
            else {
                hideErrorMessage(numberInput);
            }
            });

            if (isValid) this.submit();
        });
    }


    if (loginForm !== null) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const loginUsername = document.querySelector('#loginUsername');
            const loginPassword = document.querySelector('#loginPassword');

            if (isEmpty(loginUsername.value.trim())) {
                showErrorMessage(loginUsername, "Username can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(loginUsername);
            }

            if (isEmpty(loginPassword.value.trim())) {
                showErrorMessage(loginPassword, "Password can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(loginPassword);
            }

            if (isValid) this.submit();
        });
    }

    if (forgetForm !== null) {
        forgetForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const forgetEmail = document.querySelector('#forgetEmail');

            if (isEmpty(forgetEmail.value.trim())) {
                showErrorMessage(forgetEmail, 'Email can not be empty.');
                isValid = false;
            } else if (!isValidEmail(forgetEmail.value.trim())) {
                showErrorMessage(forgetEmail, 'Email is in incorrect format!');
                isValid = false;
            } else {
                hideErrorMessage(forgetEmail);
            }

            if (isValid) this.submit();
        });
    }

    if (resetForm !== null) {
        resetForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const resetEmail = document.querySelector('#resetEmail');
            const resetPassword = document.querySelector('#resetPassword');
            const resetPasswordConfirm = document.querySelector('#resetPasswordConfirm');

            if (isEmpty(resetEmail.value.trim())) {
                showErrorMessage(resetEmail, 'Email can not be empty.');
                isValid = false;
            } else if (!isValidEmail(resetEmail.value.trim())) {
                showErrorMessage(resetEmail, 'Email is in incorrect format!');
                isValid = false;
            } else {
                hideErrorMessage(resetEmail);
            }

            if (isEmpty(resetPassword.value.trim())) {
                showErrorMessage(resetPassword, 'Password can not be empty.');
                isValid = false;
            } else if ((resetPassword.value.trim().length)<8) {
                showErrorMessage(resetPassword, 'Password is not long enough! (min 8 characters)');
                isValid = false;
            } else {
                hideErrorMessage(resetPassword);
            }

            if (isEmpty(resetPasswordConfirm.value.trim())) {
                showErrorMessage(resetPasswordConfirm, 'Password can not be empty.');
                isValid = false;
            } else if (resetPassword.value.trim() !== resetPasswordConfirm.value.trim()) {
                showErrorMessage(resetPasswordConfirm, 'Your passwords don\'t match!');
                isValid = false;
            } else {
                hideErrorMessage(resetPasswordConfirm);
            }

            if (isValid) this.submit();
        });
    }
    if (editForm !== null) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const editPassword = document.querySelector('#editPassword');
            const editPasswordConfirm = document.querySelector('#editPasswordConfirm');
            const editAge = document.querySelector('#editAge');
            const editPhone = document.querySelector('#editPhone');

            if ((editPassword.value.trim().length)>0 && (editPassword.value.trim().length)<8) {
                showErrorMessage(editPassword, 'Password is not long enough! (min 8 characters)');
                isValid = false;
            } else {
                hideErrorMessage(editPassword);
            }
            if (editPassword.value.trim() !== editPasswordConfirm.value.trim()) {
                showErrorMessage(editPasswordConfirm, 'Your passwords don\'t match!');
                isValid = false;
            } else {
                hideErrorMessage(editPasswordConfirm);
            }

            if(isEmpty(editAge.value.trim()))
            {
                hideErrorMessage(editAge);
            }
            else if(isNaN(editAge.value.trim())) {
                showErrorMessage(editAge, "Type in a number.");
                isValid = false;
            }
            else if((editAge.value.trim())<=0){
                showErrorMessage(editAge, "Type in a realistic number.");
                isValid = false;
            }
            else {
                hideErrorMessage(editAge);
            }

            if(isEmpty(editPhone.value.trim()))
            {
                hideErrorMessage(editPhone);
            }
            else if(isNaN(editPhone.value.trim())){
                showErrorMessage(editPhone, "Type in a phone number.");
                isValid = false;
            }
            else if((editPhone.value.trim())<=0){
                showErrorMessage(editPhone, "Type in a realistic phone number.");
                isValid = false;
            } else {
                hideErrorMessage(editPhone);
            }



            if (isValid) this.submit();

        });
    }

}


let validateForm = () => {

    let isValid = true;

    if(registerUserTypeTrainer.checked){
        if (isEmpty(registerTrainerBiography.value.trim())) {
            showErrorMessage(registerTrainerBiography, "Type in your biography!!");
            isValid = false;
        } else {
            hideErrorMessage(registerTrainerBiography);
        }
    }

    let registerRadioGender = document.querySelectorAll('input[name="gender"]:checked');
    let checkedRadioGender = registerRadioGender.length>0 ? true : false;
    if(!checkedRadioGender) {
        showErrorMessage(registerGender, "Choose a gender.");
        isValid = false;
    }else {
        hideErrorMessage(registerGender);
    }

    let registerRadioUserType = document.querySelectorAll('input[name="usertype"]:checked');
    let checkedRadioUserType = registerRadioUserType.length>0 ? true : false;
    if(!checkedRadioUserType) {
        showErrorMessage(registerUserType, "Choose a role.");
        isValid = false;
    }else {
        hideErrorMessage(registerUserType);
    }

    if (isEmpty(registerFirstname.value.trim())) {
        showErrorMessage(registerFirstname, "Firstname can't be empty.");
        isValid = false;
    } else {
        hideErrorMessage(registerFirstname);
    }

    if (isEmpty(registerAge.value.trim())) {
        showErrorMessage(registerAge, "Age can't be empty.");
        isValid = false;
    }else if(isNaN(registerAge.value.trim())){
        showErrorMessage(registerAge, "Type in a number.");
        isValid = false;
    }
    else if((registerAge.value.trim())<=0){
        showErrorMessage(registerAge, "Type in a realistic number.");
        isValid = false;
    }
    else {
        hideErrorMessage(registerAge);
    }

    if (isEmpty(registerPhone.value.trim())) {
        showErrorMessage(registerPhone, "Phone number can't be empty.");
        isValid = false;
    }
    else if(isNaN(registerPhone.value.trim())){
        showErrorMessage(registerPhone, "Type in a phone number.");
        isValid = false;
    }
    else if((registerPhone.value.trim())<=0){
        showErrorMessage(registerPhone, "Type in a realistic phone number.");
        isValid = false;
    } else {
        hideErrorMessage(registerPhone);
    }

    if (isEmpty(registerLastname.value.trim())) {
        showErrorMessage(registerLastname, "Lastname can't be empty.");
        isValid = false;
    } else {
        hideErrorMessage(registerLastname);
    }

    if (isEmpty(registerEmail.value.trim())) {
        showErrorMessage(registerEmail, 'Email can not be empty.');
        isValid = false;
    } else if (!isValidEmail(registerEmail.value.trim())) {
        showErrorMessage(registerEmail, 'Email is in incorrect format!');
        isValid = false;
        inputError(registerEmail);
    } else {
        hideErrorMessage(registerEmail);
    }

    if (isEmpty(registerPassword.value.trim())) {
        showErrorMessage(registerPassword, 'Password can not be empty.');
        isValid = false;
    } else if ((registerPassword.value.trim().length)<8) {
        showErrorMessage(registerPassword, 'Password is not long enough strong! (minimum 8 characters)');
        isValid = false;
    } else {
        hideErrorMessage(registerPassword);
    }

    if (isEmpty(registerPasswordConfirm.value.trim())) {
        showErrorMessage(registerPasswordConfirm, 'Password can not be empty.');
        isValid = false;
    } else if (registerPassword.value.trim() !== registerPasswordConfirm.value.trim()) {
        showErrorMessage(registerPasswordConfirm, 'Your passwords don\'t match!');
        isValid = false;
    } else {
        hideErrorMessage(registerPasswordConfirm);
    }


    return isValid;
};

const isEmpty = value => value === '';

const isValidEmail = (email) => {
    let rex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return rex.test(email);
}


const showErrorMessage = (field, message) => {
    const error = field.nextElementSibling;
    error.classList.add('error');
    error.innerText = message;
};

const hideErrorMessage = (field) => {
    const error = field.nextElementSibling;
    error.classList.remove('error');
    error.innerText = '';
}

function isFileImage(file) {
    const acceptedImageTypes = ['image/gif', 'image/jpeg', 'image/png'];

    return file && acceptedImageTypes.includes(file['type'])
}



