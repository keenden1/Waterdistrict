@extends('layout.layoutuser')

@section('title', 'Application-For-Leave')
@section('header_title', "VILLASIS WATER DISTRICT")
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div id="section">
  <div class="image-side">
  <img src="{{ asset('logo/logo.png') }}" alt="Villasis Water District" class="image-side-img">
  <h2>APPLICATION FOR LEAVE</h2>
  </div>
  <div class="container" id="container">
  <form method="POST" action="{{ route('Application-For-Form-page') }}" id="leaveForm">
    @csrf

    <input type="hidden" name="email" value=" {{ Session::get('user_email') }}">
    <input type="hidden" name="fullname" value="{{ Session::get('fullname') }}">
      <div class="step step-1 active">
@if(session('error'))
    <div class="alert-danger">
        <strong>Error!</strong> {{ session('error') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

@if ($errors->any())
    <div class="alert-danger">
        <strong>Some fields need to be completed:</strong>
        <ul style="margin-top: 0; margin-bottom: 0 !important;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif        

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif
      <div class="form-group">
          <label for="department">Office/Department</label>
          <input type="text" id="department" name="department" required>
        </div>
    <div class="form-group-row">
    <div class="form-group">
        <label for="salary_grade">Salary Grade</label>
        <select id="salary_grade" name="salary_grade" required>
            <option value="" disabled selected>Select Salary Grade</option>
            <?php
            for ($i = 1; $i <= 33; $i++) {
                echo "<option value=\"$i\">$i</option>\n";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="step_grade">Step Grade</label>
        <select id="step_grade" name="step_grade" required>
            <option value="" disabled selected>Select Step Grade</option>
            <?php
            for ($i = 1; $i <= 8; $i++) {
                echo "<option value=\"$i\">$i</option>\n";
            }
            ?>
        </select>
    </div>
    </div>
        <div class="form-group">
          <label for="salary">Salary</label>
          <input type="text" name="salary" id="salary" readonly  style="background-color: rgba(128, 128, 128, 0.2);" placeholder="₱ ∗∗∗∗∗∗">
        </div>

        <div class="form-group">
          <label for="type">Type of leave to be availed of</label>
          <select id="type" name="type" required>
            <option value="" disabled selected>Select Leave Type</option>
            <option value="Vacation Leave">Vacation Leave</option>
            <option value="Mandatory/Forced Leave">Mandatory/Forced Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Maternity Leave">Maternity Leave</option>
            <option value="Paternity Leave">Paternity Leave</option>
            <option value="Special Privilage Leave">Special Privilage Leave</option>
            <option value="Solo Parent Leave">Solo Parent Leave</option>
            <option value="Study Leave">Study Leave</option>
            <option value="10-Day VAWC Leave">10-Day VAWC Leave</option>
            <option value="Rehabilitation Leave">Rehabilitation Leave</option>
            <option value="Special Leave Benifits for Woman">Special Leave Benifits for Woman</option>
            <option value="Special Emergency">Special Emergency</option>
            <option value="Adoption Leave">Adoption Leave</option>
            <option value="Others:">Others</option>
          </select>
        </div>
        <div class="form-group">
          <input type="text" id="Others_details" name="Others_details" class="underline-input" placeholder="(optional)"
          style="
           width: 100%;
            border: none;
            border-bottom: 1.5px solid rgba(128, 128, 128, 0.8);
            padding: 8px 5px;
            font-size: 16px;
            border-radius: 0;
            outline: none;
            background: transparent;
            color: #000;
          " >
        </div>

        <div class="form-group" >
          <label for="detail">Details of Leave</label>
          <select id="detail" name="detail" required>
            <option value="" disabled selected>Select Details of Leave</option>
            <optgroup label="Vacation Leave">
            <option value="Within Philippines">Within Philippines</option>
            <option value="Abroad">Abroad(Specify)</option>
            </optgroup>
            <optgroup label="Sick Leave" >
            <option value="In Hospital(Specify Illness)">In Hospital(Specify Illness)</option>
            <option value="Out Patient">Out Patientx(Specify Illness)</option>
            </optgroup>
            <optgroup label="Special Leave Benifits for Woman">
            <option value="Special Benifits for Women(Specify Illness)">Special Benifits for Women</option>
            </optgroup>
            <optgroup label="Study Leave">
            <option value="Completion of Masters Degree">Completion of Master's Degree</option>
            <option value="BAR/BOARD Examination Review">BAR/BOARD Examination Review</option>
            </optgroup>
            <optgroup label="Other Purpose">
            <option value="Monetization of Leave Credits">Monetization of Leave Credits</option>
            <option value="Terminal Leave">Terminal Leave</option>
            </optgroup>
          </select>
        </div>
        <div class="form-group" >
          <input type="text" id="specify_details" name="specify_details" class="underline-input" placeholder="Specify Details"
          style="
           width: 100%;
            border: none;
            border-bottom: 1.5px solid rgba(128, 128, 128, 0.8);
            padding: 8px 5px;
            font-size: 16px;
            border-radius: 0;
            outline: none;
            background: transparent;
            color: #000;
            margin-top:-50px;
          " >
        </div>
        <div class="form-group-row" >
            <div class="form-group" id="date_filing">
              <label for="startDate">Start Date</label>
              <input type="date" name="startDate" id="startDate" value="" placeholder="yyyy-mm-dd" required>
            </div>
            <div class="form-group" id="date_filing_1">
              <label for="endDate">End Date</label>
              <input type="date" name="endDate" id="endDate" value="" placeholder="yyyy-mm-dd" required>
            </div>
        </div>
    
        <div class="form-group" >
            <label for="Commutation">Commutation</label>
              <select id="commutation" name="commutation" required>
              <option value="" disabled selected>Select Leave Type</option>
              <option value="Not Requested">Not Requested</option>
              <option value="Requested">Requested</option>
          </select>
          </div>

          <div style="text-align: center;">
            <button type="button" class="submit-btn"  style="display:none;" onclick="previewForm()">Preview</button>
          
        </div>

      </div>
      <div id="previewModal" class="modal" style="display: none;" >
    <div class="modal-content" style="text-align: left;">
        <span class="close-btn" onclick="closePreview()">&times;</span>
        <h3 style="text-align: center;">Preview your details:</h3>
        <p><strong>Department:</strong> <span id="previewDepartment"></span></p>
        <p><strong>Name:</strong> <span>   {{ Session::get('formname') }}     </span></p>
        <p><strong>Date Filing:</strong> <span id="dateNow"></span></p>
        <p><strong>Position:</strong> <span>  {{ Session::get('position') }}      </span></p>
        <p><strong>Salary:</strong> <span id="previewSalary"></span></p>
        <p><strong>Type of Leave:</strong> <span id="previewType"></span></p>
        <p><strong>Other Details:</strong> <span id="previewOthersDetails"></span></p>
        <p><strong>Details of Leave:</strong> <span id="previewDetail"></span></p>
        <p><strong>Specify Details:</strong> <span id="previewSpecifyDetails"></span></p>
        <p><strong>Working Days:</strong> <span  id="workingDays"></span></p>
        <p><strong>Inclusive Dates:</strong> <span id="previewStartDate"></span> / <span id="previewEndDate"></span></p>
        <p><strong>Commutation:</strong> <span  id="previewcommutation"></span></p>
        <!-- Add other fields you want to preview here -->
        <div style="text-align: center;">
            <button type="submit" class="submit-btn" id="show-only" style="display: none;">Submit</button>
        </div>
    </div>
</div>
    </form>
   
  </div>
</div>
</div>

<style>
    .modal {
        display: none; 
        position: fixed;
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        position: relative;
        text-align: left;
    }
    

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Style for buttons inside the modal */
    .submit-btn {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }
     .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 5px;
        border-left: 5px solid #28a745;
        margin-bottom: 10px;
        position: relative;
        font-size: 14px;
    }

    /* Error Message */
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 5px;
        border-radius: 5px;
        border-left: 5px solid #dc3545;
        position: relative;
        font-size: 14px;
    }

    /* Close Button */
    .close-btn {
        position: absolute;
        top: 7px;
        right: 15px;
        font-size: 25px;
        cursor: pointer;
        color: inherit;
        background: none;
        border: none;
    }

    .close-btn:hover {
        opacity: 0.7;
    }

.nav__list a:nth-child(2) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(2)::before {
  content: "";
  position: absolute;
  left: 0;
  width: 5px;
  height: 42px;
  background-color: #cf222f;
}
.modal {
    display: flex;
    position: fixed;
    top: 50%;
    left: 50%;
    width: 100%;
    transform: translate(-50%, -50%);
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    justify-content: center;
    align-items: center;
    z-index: 99999;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    font-size: 16;
    max-width: 600px;
    width: 90%;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
.modal-content p{
    border: 1px solid transparent;
}
.modal-header {
    position: relative;
}
.modal-body h3{
  padding: 10px 0 ;
}
.progress-bar {
    position: absolute;
    top: -23px;
    width: 100%;
    height: 6px;
    background-color: #137d14;
    border-radius: 10px;

}

.icon-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
}
.checkmark img{
  margin: 20px;
}

.submitted-text {
    color: #137d14;
    font-weight: bold;
    font-size: 22px;
    margin-top: -10px;
}

.ok-btn {
    background-color: #137d14;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
}

.ok-btn:hover {
    background-color: #0e6a12;
}
#section {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 500px;
  
}
section{
  display: flex;
  align-items: center;
  justify-content: center;
}
.container {
  max-width: 500px;
  padding: 20px;
  box-shadow: 0px 0px 20px #00000020;
  border-radius: 8px;
  background-color: white;
}
.step {
  display: none;
}
.step.active {
  display: block;
}
.form-group {
  width: 100%;
  margin-top: 5px;
}
.form-group input {
  width: 100%;
  border: 1.5px solid rgba(128, 128, 128, 0.418);
  padding: 5px;
  font-size: 16px;
  border-radius: 4px;
}

label{
  font-size: 16px;
}
.submit-btn{
  margin-top: 20px;
  padding: 10px 30px;
  border: none;
  outline: none;
  background-color: rgb(180, 220, 255);
  font-family: "Montserrat";
  font-size: 18px;
  cursor: pointer;
}
button.previous-btn {
  float: left;
}
button.submit-btn {
  background-color: aquamarine;
}

.image-side-img {
        width: 30%;
        max-width: 95px; 
}
.image-side{
  display: flex;
  justify-content: space-evenly;
  width: 100%;
}
.form-group-row {
    display: flex;
    gap: 20px; /* Adds spacing between the two dropdowns */
}

.form-group-row .form-group {
    flex: 1; /* Ensures equal width */
}

/* Styling the select dropdown */
.form-group select {
  width: 100%;
  border: 1.5px solid rgba(128, 128, 128, 0.418);
  padding: 5px;
  font-size: 16px;
  margin-top: 5px;
  border-radius: 4px;
  background-color: white;

  cursor: pointer;
}
#section{
  margin-bottom: 30px;
}
.form-group select:focus {
  border-color: #007bff;  /* Highlight border on focus */
}

.form-group select option {
  font-size: 16px;
  padding: 5px;
}
/* Style the error messages */
.error-message {
  color: red;
  font-size: 14px;
  margin-top: 5px;
}

/* Highlight input fields with errors */
.error {
  border-color: red;
}

/* Optional: Style the 'next' and 'previous' buttons when an error occurs */
button.next-btn:disabled {
  background-color: #ddd;
  cursor: not-allowed;
}
h2{
  font-weight: 800;
}
  @media (max-width: 850px) {
    .header{
    font-size: 12px;
    
  }
  h2{
    font-size: larger;
  }
  #section{
    margin-top: 50px;
  }
}
</style>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
 document.addEventListener("DOMContentLoaded", function () {
    // Type of Leave Selection
    const typeSelect = document.getElementById("type");
    const othersInput = document.getElementById("Others_details");
    const detailSelect = document.getElementById("detail");
    const specifyInput = document.getElementById("specify_details");

    // Hide the input fields by default
    othersInput.style.display = "none";
    specifyInput.style.display = "none";

    typeSelect.addEventListener("change", function () {
        // Reset the Details of Leave selection & Specify input
        detailSelect.selectedIndex = 0; // Reset dropdown
        specifyInput.value = ""; // Clear input
        specifyInput.style.display = "none"; // Hide input field

        // Show input field only when "Others" is selected
        othersInput.style.display = (typeSelect.value === "Others:") ? "inline-block" : "none";
    });

    detailSelect.addEventListener("change", function () {
        const selectedValue = detailSelect.value.trim();

        // List of options that should NOT show the input field
        const excludeOptions = [
            "Monetization of Leave Credits",
            "Terminal Leave",
            "Completion of Master's Degree",
            "BAR/BOARD Examination Review"
        ];

        specifyInput.style.display = excludeOptions.includes(selectedValue) ? "none" : "inline-block";

        // Reset specify_details input if a new option is selected
        specifyInput.value = "";
    });
});




</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const typeSelect = document.getElementById("type");
    const detailSelect = document.getElementById("detail");
    const dateFiling = document.getElementById("date_filing");
    const dateFiling_2 = document.getElementById("date_filing_1");
    const submitButton = document.querySelector(".submit-btn");
    const detailGroup = detailSelect.closest(".form-group");
    const dateFilingGroup = dateFiling.closest(".form-group");
    const dateFilingGroup_2 = dateFiling_2.closest(".form-group");
    const typeOthersDetails = document.getElementById("Others_details");
    const specifyDetails = document.getElementById("specify_details");
    const optGroups = document.querySelectorAll("#detail optgroup");

    // Hide elements initially
    detailGroup.style.display = "none";
    dateFilingGroup.style.display = "none";
    dateFilingGroup_2.style.display = "none";
    submitButton.style.display = "none";
    typeOthersDetails.style.display = "none";
    specifyDetails.style.display = "none";

    // Show Details of Leave based on Type selection
    typeSelect.addEventListener("change", function () {
        const selectedType = typeSelect.value;

        // Reset detail selection and hide initially
        detailSelect.value = "";
        detailGroup.style.display = "none";
        dateFilingGroup.style.display = "none";
        dateFilingGroup_2.style.display = "none";
        submitButton.style.display = "none";

        if (selectedType) {
            detailGroup.style.display = "block"; // Show details of leave
        }

        // Hide all options and optgroups
        optGroups.forEach(group => {
            group.style.display = "none";
            Array.from(group.children).forEach(option => {
                option.style.display = "none";
            });
        });

        let matchingGroup = document.querySelector(`optgroup[label*="${selectedType}"]`);
        if (matchingGroup) {
            matchingGroup.style.display = "block";
            Array.from(matchingGroup.children).forEach(option => {
                option.style.display = "block";
            });
        } else {
            // Show "Other Purpose" if no match
            let otherGroup = document.querySelector('optgroup[label="Other Purpose"]');
            if (otherGroup) {
                otherGroup.style.display = "block";
                Array.from(otherGroup.children).forEach(option => {
                    option.style.display = "block";
                });
            }
        }

        // Show "Others Details" input if "Others" is selected
        typeOthersDetails.style.display = selectedType === "Others:" ? "inline-block" : "none";
    });

    // Show Date Filing based on Details selection
    detailSelect.addEventListener("change", function () {
        dateFilingGroup.style.display = detailSelect.value ? "block" : "none";
        dateFilingGroup_2.style.display = detailSelect.value ? "block" : "none";
        submitButton.style.display = detailSelect.value ? "inline-block" : "none";
    });
});


</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
        const leaveTypeSelect = document.getElementById("type"); // The dropdown for Type of Leave
        const startDateInput = document.getElementById("startDate");
        const endDateInput = document.getElementById("endDate");

        // Mapping leave types to their required advance days
        const leaveAdvanceDays = {
            "Vacation Leave": 5,
            "Mandatory/Forced Leave": 1,
            "Sick Leave": 5,
            "Maternity Leave": 1,
            "Paternity Leave": 1,
            "Special Privilage Leave": 7,
            "Solo Parent Leave": 7,
            "Study Leave": 1,
            "10-Day VAWC Leave": 1,
            "Rehabilitation Leave": 7,
            "Special Leave Benifits for Woman": 5,
            "Special Emergency": 5,
            "Adoption Leave": 1
        };

        // Initialize Flatpickr for start date without setting any initial value
        const startDatePicker = flatpickr(startDateInput, {
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: null, // Ensure no initial value is set
            onChange: function(selectedDates, dateStr, instance) {
            // Set the startDateInput as required when the date is selected
            startDateInput.required = true;
    }
        });

        const endDatePicker = flatpickr(endDateInput, {
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: null, // Ensure no initial value is set
            onChange: function(selectedDates, dateStr, instance) {
                // Set the endDateInput as required when the date is selected
                endDateInput.required = true;
            }
        });

        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            if (!startDateInput.value || !endDateInput.value) {
                alert("Please select both start and end dates.");
                event.preventDefault(); // Prevent form submission
            }
        });
        // Function to update the start date based on leave type
        function updateStartDate() {
            const leaveType = leaveTypeSelect.value;
            const daysToAdd = leaveAdvanceDays[leaveType] || 1; // Default to 1 day if not listed
            const newStartDate = new Date();
            newStartDate.setDate(newStartDate.getDate() + daysToAdd);

            // Set the new min date for start date
            startDatePicker.set("minDate", newStartDate);

            // Ensure end date is at least the same as the new start date
            endDatePicker.set("minDate", newStartDate);
        }

        // Listen for changes in the leave type dropdown
        leaveTypeSelect.addEventListener("change", updateStartDate);
    });


    document.addEventListener("DOMContentLoaded", function () {
    const salaryGradeSelect = document.getElementById("salary_grade");
    const stepGradeSelect = document.getElementById("step_grade");
    const salaryInput = document.getElementById("salary");

    // Function to fetch salary when both salary grade and step grade are selected
    function updateSalary() {
        const salaryGrade = salaryGradeSelect.value;
        const stepGrade = stepGradeSelect.value;

        // Log the values for debugging
        console.log("Selected Salary Grade:", salaryGrade);
        console.log("Selected Step Grade:", stepGrade);

        // Check if both salary grade and step grade are selected
        if (salaryGrade && stepGrade) {
            // Make an AJAX request to fetch the salary based on the selected values
            fetch("{{ url('/get-salary') }}?salary_grade=" + salaryGrade + "&step_grade=" + stepGrade)
                .then(response => {
                    // Log the response status and response body
                    console.log("Response status:", response.status);
                    return response.json();
                })
                .then(data => {
                    console.log("Received data:", data);  // Log the received data
                    // Update the salary input with the fetched salary
                    if (data.salary) {
                        // Format the salary to include the currency format (Php)
                        const formattedSalary = new Intl.NumberFormat('en-PH', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }).format(data.salary);
                        
                        salaryInput.value = formattedSalary;
                    } else {
                        salaryInput.value = "Salary not found";
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    salaryInput.value = "Error fetching salary";
                });
        }
    }

    // Listen for changes in salary grade or step grade
    salaryGradeSelect.addEventListener("change", updateSalary);
    stepGradeSelect.addEventListener("change", updateSalary);
});

</script>
<script>
   function previewForm() {
    // Capture form values
    const department = document.getElementById('department').value || '------';
    const salary = document.getElementById('salary').value || '------'; 
    const type = document.getElementById('type').value || '------';
    const Others_details = document.getElementById('Others_details').value || '------';
    const detail = document.getElementById('detail').value || '------';
    const specify_details = document.getElementById('specify_details').value || '------';
    const startDate = document.getElementById('startDate').value || '------';
    const endDate = document.getElementById('endDate').value || '------';
    const commutation = document.getElementById('commutation').value || '------';

    

    // Function to calculate working days between two dates
    function calculateWorkingDays(startDate, endDate) {
        var start = new Date(startDate);
        var end = new Date(endDate);
        var workingDays = 0;

        // Loop through each date from start to end
        while (start <= end) {
            var dayOfWeek = start.getDay();
            // Check if the day is a weekday (Monday - Friday)
            if (dayOfWeek != 0 && dayOfWeek != 6) { // 0 = Sunday, 6 = Saturday
                workingDays++;
            }
            start.setDate(start.getDate() + 1); // Move to the next day
        }

        return workingDays;
    }

    // Calculate working days if startDate and endDate are not "------"
    let workingDays = '------';
    if (startDate !== '------' && endDate !== '------') {
        workingDays = calculateWorkingDays(startDate, endDate) + ' day/s';
    }

    // Populate preview modal
    document.getElementById('previewDepartment').innerText = department;
    document.getElementById('previewSalary').innerText = salary;
    document.getElementById('previewType').innerText = type;
    document.getElementById('previewOthersDetails').innerText = Others_details;
    document.getElementById('previewDetail').innerText = detail;
    document.getElementById('previewSpecifyDetails').innerText = specify_details;
    document.getElementById('previewStartDate').innerText = startDate;
    document.getElementById('previewEndDate').innerText = endDate;
    document.getElementById('workingDays').innerText = workingDays;
    document.getElementById('previewcommutation').innerText = commutation;
    // Check if mandatory fields are filled (excluding Others_details and Specify_details)
    const isFormValid = department !== '------' && salary !== '------' && type !== '------' && detail !== '------' && startDate !== '------' && endDate !== '------';

    // Show or hide the Submit button
    const submitButton = document.getElementById('show-only');
    if (isFormValid) {
        submitButton.style.display = 'inline-block'; // Show the Submit button if valid
    } else {
        submitButton.style.display = 'none'; // Hide the Submit button if any required field is missing
    }
    // Show the modal
    document.getElementById('previewModal').style.display = 'block';
}


function closePreview() {
    // Close the modal
    document.getElementById('previewModal').style.display = 'none';
}
// Get the current date
const currentDate = new Date();

// Array to store the names of months
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// Get the day, month, and year
const day = currentDate.getDate();
const month = months[currentDate.getMonth()];
const year = currentDate.getFullYear();

// Format the date as "Month Day, Year"
const formattedDate = `${month} ${day}, ${year}`;

// Set the formatted date in the <span> element
document.getElementById('dateNow').innerText = formattedDate;


</script>
@endsection
