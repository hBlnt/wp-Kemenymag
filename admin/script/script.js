"use strict";
window.addEventListener("DOMContentLoaded", init);

let timeout;

function init() {

    const isEmpty = value => value === '';
    const loginForm = document.querySelector('#loginForm');
    const categoryForm = document.querySelector('#categoryForm');

    if (loginForm !== null) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const adminUsername = document.querySelector('#adminUsername');
            const adminPassword = document.querySelector('#adminPassword');

            if (isEmpty(adminUsername.value.trim())) {
                showErrorMessage(adminUsername, "Username can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(adminUsername);
            }

            if (isEmpty(adminPassword.value.trim())) {
                showErrorMessage(adminPassword, "Password can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(adminPassword);
            }

            if (isValid) this.submit();
        });
    }

    if (categoryForm !== null) {
        categoryForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            const editID = document.querySelector('#editID');
            const editName = document.querySelector('#editName');
            const editDescription = document.querySelector('#editDescription');

            if (isEmpty(editID.value.trim())) {
                showErrorMessage(editID, "ID can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(editID);
            }

            if (isEmpty(editName.value.trim())) {
                showErrorMessage(editName, "Name can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(editName);
            }

            if (isEmpty(editDescription.value.trim())) {
                showErrorMessage(editDescription, "Description can't be empty.");
                isValid = false;
            } else {
                hideErrorMessage(editDescription);
            }

            if (isValid) this.submit();

        });
    }

}

function fill(id,name,description){
     var editName = document.getElementById("editName");
     var editID = document.getElementById("editID");
     var editDescription = document.getElementById("editDescription");

     editID.value = id;
     editName.value = name;
     editDescription.value = description;

}

function setID(id)
{
    var editID = document.getElementById("editID");

    editID.value = id;
}

function setHiddenInput(value) {
    document.getElementById("hiddenInput").value = value;
    document.getElementById("categoryForm").submit();
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


