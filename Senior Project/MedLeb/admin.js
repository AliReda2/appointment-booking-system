function displayDiv(divIdToShow, clickedLi) {
    // Remove 'active' class from all <a> tags
    const allLinks = document.querySelectorAll('.side-menu a');
    allLinks.forEach(link => {
        link.classList.remove('active');
    });

    // Add 'active' class to the clicked <a> tag
    const clickedLink = clickedLi.querySelector('a');
    if (clickedLink) {
        clickedLink.classList.add('active');
    }

    // Hide all divs
    const allDivs = document.querySelectorAll('.content-div');
    allDivs.forEach(div => {
        div.style.display = 'none';
    });

    // Show the selected div
    const divToShow = document.getElementById(divIdToShow);
    if (divToShow) {
        divToShow.style.display = 'block';
    } else {
        console.error("Element with ID " + divIdToShow + " not found.");
    }
}


function newDoctor() {
    const newDoctorElement = document.querySelector('.newDoctor');
    if (newDoctorElement) {
        newDoctorElement.style.display = "block";
    } else {
        console.error("Element with class 'newDoctor' not found.");
    }
}


function newPatient() {
    const newDoctorElement = document.querySelector('.newPatient');
    if (newDoctorElement) {
        newDoctorElement.style.display = "block";
    } else {
        console.error("Element with class 'newPatient' not found.");
    }
}

function newAssistant() {
    const newAssistantElement = document.querySelector('.newAssistant');
    if (newAssistantElement) {
        newAssistantElement.style.display = "flex";
    } else {
        console.error("Element with class 'newAssistant' not found.");
    }
}

function editAssistant(element) {
    // Get assistant details from data attributes
    var id = element.getAttribute('data-id');
    var name = element.getAttribute('data-name');
    var email = element.getAttribute('data-email');
    var phone = element.getAttribute('data-phone');
    var doctorId = element.getAttribute('data-doctor-id');

    // Populate the form fields
    document.querySelector('input[name="assistant_id"]').value = id;
    document.querySelector('input[name="Aname"]').value = name;
    document.querySelector('input[name="Aemail"]').value = email;
    document.querySelector('input[name="Aphone"]').value = phone;
    document.querySelector('select[name="Adoctor"]').value = doctorId;

    // Show the edit form
    document.querySelector('.editAssistant').style.display = 'flex';
}



function editDoctor(element) {
    // Get doctor details from data attributes
    var id = element.getAttribute('data-id');
    var name = element.getAttribute('data-name');
    var email = element.getAttribute('data-email');
    var phone = element.getAttribute('data-phone');
    var spec = element.getAttribute('data-spec');

    // Populate the form fields
    document.querySelector('input[name="doctor_id"]').value = id;
    document.querySelector('input[name="Dname"]').value = name;
    document.querySelector('input[name="Demail"]').value = email;
    document.querySelector('input[name="Dphone"]').value = phone;
    document.querySelector('input[name="Dspec"]').value = spec;

    // Show the edit form
    document.querySelector('.editDoctor').style.display = 'flex';
}


function exit() {
    const editAssistantElement = document.querySelector('.editAssistant');
    const editDoctorElement = document.querySelector('.editDoctor');
    const newAssistantElement = document.querySelector('.newAssistant');
    const newDoctorElement = document.querySelector('.newDoctor');
    const newPatientElement = document.querySelector('.newPatient');
    if (newDoctorElement) {
        newDoctorElement.style.display = "none";
        newPatientElement.style.display = "none";
        newAssistantElement.style.display = "none";
        editAssistantElement.style.display = "none";
        editDoctorElement.style.display = "none";
    }
}



document.addEventListener('DOMContentLoaded', function () {
    const loginFormElement = document.getElementById('loginFormElement');
    const changeFormElement = document.getElementById('changeFormElement');

    if (changeFormElement) {
        changeFormElement.addEventListener('submit', function (event) {
            event.preventDefault();

            const newUsername = document.getElementById('newUsername').value;
            const newPassword = document.getElementById('newPassword').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update-admin.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        const changeErrorMessage = document.getElementById('changeErrorMessage');
                        const changeSuccessMessage = document.getElementById('changeSuccessMessage');
                        if (response.success) {
                            changeSuccessMessage.textContent = response.message;
                            changeSuccessMessage.style.display = 'block';
                            changeErrorMessage.style.display = 'none';
                        } else {
                            changeErrorMessage.textContent = response.message;
                            changeErrorMessage.style.display = 'block';
                            changeSuccessMessage.style.display = 'none';
                        }
                    } catch (e) {
                        console.error("Failed to parse JSON response:", xhr.responseText);
                    }
                }
            };
            xhr.send(`newUsername=${encodeURIComponent(newUsername)}&newPassword=${encodeURIComponent(newPassword)}`);
        });
    }
});

function filterTableP() {
    // Declare variables
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementsByClassName("record-search")[0];
    filter = input.value.toUpperCase();
    table = document.getElementById("patientTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, starting from index 1 to exclude the header row
    for (i = 1; i < tr.length; i++) {
        var found = false;
        // Loop through all table cells in the current row
        for (j = 0; j < tr[i].cells.length; j++) {
            td = tr[i].cells[j];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Break out of the inner loop if a match is found in this row
                }
            }
        }
        // Show or hide the row based on whether a match was found
        if (found) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
function filterTableD() {
    // Declare variables
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementsByClassName("record-searchD")[0];
    filter = input.value.toUpperCase();
    table = document.getElementById("doctorTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, starting from index 1 to exclude the header row
    for (i = 1; i < tr.length; i++) {
        var found = false;
        // Loop through all table cells in the current row
        for (j = 0; j < tr[i].cells.length; j++) {
            td = tr[i].cells[j];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Break out of the inner loop if a match is found in this row
                }
            }
        }
        // Show or hide the row based on whether a match was found
        if (found) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

function filterTableA() {
    // Declare variables
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementsByClassName("record-searchA")[0];
    filter = input.value.toUpperCase();
    table = document.getElementById("assistantTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, starting from index 1 to exclude the header row
    for (i = 1; i < tr.length; i++) {
        var found = false;
        // Loop through all table cells in the current row
        for (j = 0; j < tr[i].cells.length; j++) {
            td = tr[i].cells[j];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Break out of the inner loop if a match is found in this row
                }
            }
        }
        // Show or hide the row based on whether a match was found
        if (found) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}