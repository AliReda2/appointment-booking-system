document.addEventListener('DOMContentLoaded', function () {

	var listView = document.querySelector('.list-view');
	var gridView = document.querySelector('.grid-view');
	var projectsList = document.querySelector('.project-boxes');
	listView.addEventListener('click', function () {
		gridView.classList.remove('active');
		listView.classList.add('active');
		projectsList.classList.remove('jsGridView');
		projectsList.classList.add('jsListView');
	});
	gridView.addEventListener('click', function () {
		gridView.classList.add('active');
		listView.classList.remove('active');
		projectsList.classList.remove('jsListView');
		projectsList.classList.add('jsGridView');
	});

});

function toggleMainContent(mainIdToShow, clickedButton) {
	// Remove 'active' class from all buttons
	const allButtons = document.querySelectorAll('.app-sidebar .nav-button');
	allButtons.forEach(button => {
		button.classList.remove('active');
	});

	// Add 'active' class to the clicked button
	clickedButton.classList.add('active');

	// Hide all main sections
	const allMainSections = document.querySelectorAll('.projects-section');
	allMainSections.forEach(section => {
		section.style.display = 'none';
	});

	// Show the selected main section
	const mainToShow = document.getElementById(mainIdToShow);
	if (mainToShow) {
		mainToShow.style.display = 'block';
	} else {
		console.error("Element with ID " + mainIdToShow + " not found.");
	}
}

function filterTableP() {
	// Declare variables
	var input, filter, table, tr, td, i, j, txtValue;
	input = document.getElementsByClassName("record-searchP")[0];
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


function newPatient() {
	const newDoctorElement = document.querySelector('.newPatientD');
	if (newDoctorElement) {
		newDoctorElement.style.display = "flex";
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

function exit() {
	const newAssistantElement = document.querySelector('.newAssistant');
	const newPatientElement = document.querySelector('.newPatientD');
	if (newPatientElement) {
		newPatientElement.style.display = "none";
		newAssistantElement.style.display = "none";

	}
}

document.addEventListener('DOMContentLoaded', function () {
	const changeFormElement = document.getElementById('changeFormElement');

	if (changeFormElement) {
		changeFormElement.addEventListener('submit', function (event) {
			event.preventDefault();

			const newUsername = document.getElementById('newUsername').value;
			const newPassword = document.getElementById('newPassword').value;
			const newSpec = document.getElementById('newSpec').value;
			const newPhone = document.getElementById('newPhone').value;
			const newEmail = document.getElementById('newEmail').value;

			const xhr = new XMLHttpRequest();
			xhr.open('POST', 'update-doctor.php', true);
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
			xhr.send(`newUsername=${encodeURIComponent(newUsername)}&newPassword=${encodeURIComponent(newPassword)}&newSpec=${encodeURIComponent(newSpec)}&newPhone=${encodeURIComponent(newPhone)}&newEmail=${encodeURIComponent(newEmail)}`);
		});
	}
});
