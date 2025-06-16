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

        
        <div id="emergency_code" class="form-group" style="display: none; align-items: center; gap: 10px; margin-top:10px;">
          <label style="margin-right: 10px;">Is this an emergency?</label>

          <label style="display: flex; align-items: center; gap: 5px;">
            <input type="radio" name="is_emergency" id="emergencyYes" value="yes">
            Yes
          </label>

          <label style="display: flex; align-items: center; gap: 5px;">
            <input type="radio" name="is_emergency" id="emergencyNo" value="no" checked>
            No
          </label>
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
            <option value="Special Privilege Leave">Special Privilege Leave</option>
            <option value="Solo Parent Leave">Solo Parent Leave</option>
            <option value="Study Leave">Study Leave</option>
            <option value="10-Day VAWC Leave">10-Day VAWC Leave</option>
            <option value="Rehabilitation Leave">Rehabilitation Leave</option>
            <option value="Special Benifits for Women">Special Leave Benifits for Woman</option>
            <option value="Special Emergency">Special Emergency(Calamity)</option>
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

        <div class="form-group" id="details_groupss">
          <label for="detail">Details of Leave</label>
          <select id="detail" name="detail">
            <option value="" disabled selected>Select Details of Leave</option>
            <optgroup label="Vacation Leave">
            <option value="Within Philippines">Within Philippines</option>
            <option value="Abroad">Abroad(Specify)</option>
            </optgroup>
            <optgroup label="Sick Leave" >
            <option value="In Hospital(Specify Illness)">In Hospital(Specify Illness)</option>
            <option value="Out Patient(Specify Illness)">Out Patient(Specify Illness)</option>
            </optgroup>
            <optgroup label="Special Leave Benifits for Woman">
            <option value="Special Benifits for Women">Special Benifits for Women</option>
            </optgroup>
            <optgroup label="Study Leave">
            <option value="Completion of Masters Degree">Completion of Master's Degree</option>
            <option value="BAR/BOARD Examination Review">BAR/BOARD Examination Review</option>
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

         <div class="form-group" id="other_purpose_group">
          <label for="other_purpose_detail">Other Purpose</label>
          <select id="other_purpose_detail" name="other_purpose_detail">
            <option value="" disabled selected>Select Other Purpose</option>
            <option value="Monetization of Leave Credits">Monetization of Leave Credits</option>
            <option value="Terminal Leave">Terminal Leave</option>
          </select>
        </div>

       <div class="form-group" id="number_group">
          <input type="number" id="number" name="number" class="underline-input" placeholder="0" min="0"
          style="
            display:none;
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
              <input type="date" name="startDate" id="startDate" value="" placeholder="yyyy-mm-dd" >
            </div>
            <div class="form-group" id="date_filing_1">
              <label for="endDate">End Date</label>
              <input type="date" name="endDate" id="endDate" value="" placeholder="yyyy-mm-dd" >
            </div>
        </div>
    
        <div class="form-group" >
            <label for="Commutation">Commutation</label>
              <select id="commutation" name="commutation" >
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
        <p id="otherDetailsWrapper"><strong>Other Details:</strong> <span id="previewOthersDetails"></span></p>
        <p id="otherDetailsWrapper2"><strong>Details of Leave:</strong> <span id="previewDetail"></span></p>
        <p id="otherDetailsWrapper1"><strong>Other Purpose:</strong> <span id="previewother_purpose_detail"></span></p>
        <p id="otherDetailsWrapper3"><strong>Specify Details:</strong> <span id="previewSpecifyDetails"></span></p>
        <p id="otherDetailsWrapper4"><strong>Working Days:</strong> <span  id="workingDays"></span></p>
        <p id="otherDetailsWrapper5"><strong>Inclusive Dates:</strong> <span id="previewStartDate"></span> - <span id="previewEndDate"></span></p>
        <p><strong>Commutation:</strong> <span  id="previewcommutation"></span></p>
        <!-- Add other fields you want to preview here -->
        <div style="text-align: center;">
            <button type="button" class="submit-btn" id="show-only" onclick="document.getElementById('leaveForm').submit();">Submit</button>
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
    const typeSelect = document.getElementById("type");
    const detailSelect = document.getElementById("detail");
    const dateFiling = document.getElementById("date_filing");
    const dateFiling_2 = document.getElementById("date_filing_1");
    const submitButton = document.querySelector(".submit-btn"); // used as Preview button
    const detailGroup = detailSelect.closest(".form-group");
    const dateFilingGroup = dateFiling.closest(".form-group");
    const dateFilingGroup_2 = dateFiling_2.closest(".form-group");
    const typeOthersDetails = document.getElementById("Others_details");
    const specifyDetails = document.getElementById("specify_details");
    const otherPurposeGroup = document.getElementById("other_purpose_group");
    const emergencyCode = document.getElementById("emergency_code");
    const optGroups = document.querySelectorAll("#detail optgroup");
    

    const excludeOptions = [
        "Monetization of Leave Credits",
        "Terminal Leave",
        "Completion of Master's Degree",
        "BAR/BOARD Examination Review"
    ];

    const previewTypes = [
        "Mandatory/Forced Leave",
        "Maternity Leave",
        "Paternity Leave",
        "Solo Parent Leave",
        "Study Leave",
        "10-Day VAWC Leave",
        "Rehabilitation Leave",
        "Adoption Leave",
        "Others:",
        "Special Emergency",
        "Special Privilege Leave",
        "Special Benifits for Women"
    ];
//locate
    // Initial hide
    detailGroup.style.display = "none";
    dateFilingGroup.style.display = "none";
    dateFilingGroup_2.style.display = "none";
    submitButton.style.display = "none";
    typeOthersDetails.style.display = "none";
    specifyDetails.style.display = "none";
    otherPurposeGroup.style.display = "none";
    emergencyCode.style.display = "none";

    // On Type Change
    typeSelect.addEventListener("change", function () {
        const selectedType = typeSelect.value;

        // Reset
        detailSelect.value = "";
        specifyDetails.value = "";
        detailGroup.style.display = "none";
        dateFilingGroup.style.display = "none";
        dateFilingGroup_2.style.display = "none";
        submitButton.style.display = "none";
        specifyDetails.style.display = "none";
        typeOthersDetails.style.display = "none";
        otherPurposeGroup.style.display = "none";
        emergencyCode.style.display = "none";

         Array.from(otherPurposeGroup.querySelectorAll("input, select, textarea")).forEach(el => {
        el.value = "";
    });

        // Show Others input if "Others:" selected
      // Show Other Purpose dropdown only when "Others:" is selected
      if (selectedType === "Others:") {
          specify_details.style.display = "inline-block";
          date_filing.style.display = "inline-block";
          date_filing_1.style.display = "inline-block";
          // Listen to changes in 'other_purpose_detail'
        
      }
          const otherPurposeSelect = document.getElementById("other_purpose_detail");
          const startDateInput = document.getElementById("date_filing");
          const endDateInput = document.getElementById("date_filing_1");
          const specify_detailsInput = document.getElementById("specify_details");
          const detailInput = document.getElementById("details_groupss");
          const numberInput = document.getElementById("number");

          otherPurposeSelect.addEventListener("change", function () {
              const selectedPurpose = otherPurposeSelect.value;

              if (selectedPurpose === "Monetization of Leave Credits" ) {
                  // Hide start and end date
                  dateFilingGroup.style.display = "none";
                  dateFilingGroup_2.style.display = "none";
                  startDateInput.style.display = "none";
                  endDateInput.style.display = "none";
                  specify_detailsInput.style.display = "none";
                  detailInput.style.display = "none";
                  numberInput.style.display = "inline-block";

                   Array.from(specify_detailsInput.querySelectorAll("input, select, textarea")).forEach(el => {
                    el.value = "";});
                   Array.from(detailInput.querySelectorAll("input, select, textarea")).forEach(el => {
                  el.value = "";});
                   Array.from(numberInput.querySelectorAll("input, select, textarea")).forEach(el => {
                  el.value = "";});
                  
              } else {
                  // Show start and end date
                  dateFilingGroup.style.display = "block";
                  dateFilingGroup_2.style.display = "block";
                  startDateInput.style.display = "block";
                  endDateInput.style.display = "block";
                  specify_detailsInput.style.display = "inline-block";
                  detailInput.style.display = "inline-block";
                  numberInput.style.display = "none";
              }
          });


        // Show Preview button if selected type matches specific ones
        if (previewTypes.includes(selectedType)) {
            submitButton.style.display = "inline-block";
        }
        // Also show start and end date fields for these types
    // Show Preview button if selected type matches specific ones
     if (previewTypes.includes(selectedType)) {
    submitButton.style.display = "inline-block";

    if (selectedType !== "Others:") {
        dateFilingGroup.style.display = "block";
        dateFilingGroup_2.style.display = "block";
    }
  


}

        // Show Details group if needed
        if (
            selectedType === "Vacation Leave" ||
            selectedType === "Sick Leave" ||
            selectedType === "Special Privilege Leave" ||
            selectedType === "Study Leave"
            
        ) {
            detailGroup.style.display = "block";
        }
         if (
          selectedType === "Special Benifits for Women" 
        ) {
            specify_details.style.display = "inline-block";
        }

        // Show "Other Purpose"
        if (["Vacation Leave", "Sick Leave"].includes(selectedType)) {
            otherPurposeGroup.style.display = "block";
            dateFilingGroup.style.display = "block";
            dateFilingGroup_2.style.display = "block";
            submitButton.style.display = "inline-block";
        }

        // Show emergency code block
        if (
            selectedType === "10-Day VAWC Leave" ||
            selectedType === "Special Emergency" ||
            selectedType === "Rehabilitation Leave" ||
            selectedType === "Sick Leave" ||
            selectedType === "Special Privilege Leave"
        ) {
            emergencyCode.style.display = "flex";
        }


        // Reset all detail options
        optGroups.forEach(group => {
            group.style.display = "none";
            Array.from(group.children).forEach(option => {
                option.style.display = "none";
            });
        });

        // Show matching optgroup
        const matchingGroup = document.querySelector(`optgroup[label*="${selectedType}"]`);
        if (matchingGroup) {
            matchingGroup.style.display = "block";
            Array.from(matchingGroup.children).forEach(option => {
                option.style.display = "block";
            });
        }

        // Special case: show Vacation group for "Special Privilege Leave"
        if (selectedType === "Special Privilege Leave") {
            const vacationGroup = document.querySelector('optgroup[label="Vacation Leave"]');
            if (vacationGroup) {
                vacationGroup.style.display = "block";
                Array.from(vacationGroup.children).forEach(option => {
                    option.style.display = "block";
                });
            }
        }

        // Show Other Purpose group
        const otherGroup = document.querySelector('optgroup[label="Other Purpose"]');
        if (
            ["Vacation Leave", "Sick Leave", "Others:"].includes(selectedType) &&
            otherGroup
        ) {
            otherGroup.style.display = "block";
            Array.from(otherGroup.children).forEach(option => {
                option.style.display = "block";
            });
        }
    });

    // On Detail Change
    detailSelect.addEventListener("change", function () {
        const selectedValue = detailSelect.value.trim();

        // Show or hide specify field
        specifyDetails.style.display = excludeOptions.includes(selectedValue) ? "none" : "inline-block";
        specifyDetails.value = "";

        const show = selectedValue !== "";
        dateFilingGroup.style.display = show ? "block" : "none";
        dateFilingGroup_2.style.display = show ? "block" : "none";
        submitButton.style.display = show ? "inline-block" : submitButton.style.display;
    
        const groupA  =  document.getElementById("other_purpose_group");
       
         if (
            selectedValue === "In Hospital(Specify Illness)" ||
            selectedValue === "Out Patient(Specify Illness)" ||
            selectedValue === "Within Philippines" ||
            selectedValue === "Abroad"
        ) {
            groupA.style.display = "none";
        }

      


    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const leaveTypeSelect = document.getElementById("type");
    const startDateInput = document.getElementById("startDate");
    const endDateInput = document.getElementById("endDate");
    const emergencyYes = document.getElementById("emergencyYes");
    const emergencyNo = document.getElementById("emergencyNo");

    const leaveAdvanceDays = {
        "Vacation Leave": 5,
        "Mandatory/Forced Leave": 5,
        "Sick Leave": 5,
        "Maternity Leave": 1,
        "Paternity Leave": 1,
        "Special Privilege Leave": 7,
        "Solo Parent Leave": 7,
        "Study Leave": 1,
        "10-Day VAWC Leave": 1,
        "Rehabilitation Leave": 7,
        "Special Benifits for Woman": 5,
        "Special Emergency": 5,
        "Adoption Leave": 1
    };

    const disableWeekends = [
    function(date) {
        // return true to disable
        return (date.getDay() === 0 || date.getDay() === 6); // Sunday (0) or Saturday (6)
    }
];
   const startDatePicker = flatpickr(startDateInput, {
    dateFormat: "Y-m-d",
    minDate: "today",
    defaultDate: null,
    disable: disableWeekends,
    onChange: function(selectedDates, dateStr) {
        startDateInput.required = false;

        if (selectedDates.length > 0) {
            const selectedStart = selectedDates[0];
            endDatePicker.set("minDate", selectedStart);

            const currentEnd = endDateInput._flatpickr.selectedDates[0];
            if (currentEnd && currentEnd < selectedStart) {
                endDateInput.value = '';
            }
        }
    }
});


    const endDatePicker = flatpickr(endDateInput, {
        dateFormat: "Y-m-d",
        minDate: "today",
          disable: disableWeekends,
        defaultDate: null,
        onChange: function(selectedDates, dateStr) {
            endDateInput.false = true;
        }
    });

    function updateStartDate() {
        const leaveType = leaveTypeSelect.value;
        let daysToAdd = leaveAdvanceDays[leaveType] || 1;

        // If emergency is selected, override the restriction
        if (emergencyYes.checked) {
            daysToAdd = 0;
        }

        const newStartDate = new Date();
        newStartDate.setDate(newStartDate.getDate() + daysToAdd);

        startDatePicker.set("minDate", newStartDate);
        endDatePicker.set("minDate", newStartDate);
    }

    // Run updateStartDate on leave type change
    leaveTypeSelect.addEventListener("change", updateStartDate);

    // Also run updateStartDate when emergency selection changes
    emergencyYes.addEventListener("change", updateStartDate);
    emergencyNo.addEventListener("change", updateStartDate);

    // Validate form on submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (!startDateInput.value || !endDateInput.value) {
            alert("Please select both start and end dates.");
            event.preventDefault();
        }
    });

    // Salary Grade Logic
    const salaryGradeSelect = document.getElementById("salary_grade");
    const stepGradeSelect = document.getElementById("step_grade");
    const salaryInput = document.getElementById("salary");

    function updateSalary() {
        const salaryGrade = salaryGradeSelect.value;
        const stepGrade = stepGradeSelect.value;

        if (salaryGrade && stepGrade) {
            fetch("{{ url('/get-salary') }}?salary_grade=" + salaryGrade + "&step_grade=" + stepGrade)
                .then(response => response.json())
                .then(data => {
                    if (data.salary) {
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

    salaryGradeSelect.addEventListener("change", updateSalary);
    stepGradeSelect.addEventListener("change", updateSalary);
});
</script>
<script>
function formatDate(input) {
    if (!input) return '------';

    const date = new Date(input);
    if (isNaN(date)) return '------'; // handle invalid dates

    const day = date.getDate().toString().padStart(2, '0');
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

function previewForm() {
    // Capture form values
    const department = document.getElementById('department').value || '------';
    const salary = document.getElementById('salary').value || '------'; 
    const type = document.getElementById('type').value || '------';
    const Others_details = document.getElementById('Others_details').value || '------';
    const detail = document.getElementById('detail').value || '------';
    const specify_details = document.getElementById('specify_details').value || '------';
    const commutation = document.getElementById('commutation').value || '------';
    const other_purpose_detail = document.getElementById('other_purpose_detail').value || '------';
    const number_const = document.getElementById('number').value || '------';
    // Format dates
    const rawStartDate = document.getElementById('startDate').value;
    const rawEndDate = document.getElementById('endDate').value;
    const startDate = formatDate(rawStartDate);
    const endDate = formatDate(rawEndDate);

    // Show/hide other detail wrappers
    const otherDetailsWrapper = document.getElementById('otherDetailsWrapper');
    otherDetailsWrapper.style.display = Others_details !== '------' ? 'block' : 'none';

    const otherDetailsWrapper1 = document.getElementById('otherDetailsWrapper1');
    otherDetailsWrapper1.style.display = other_purpose_detail !== '------' ? 'block' : 'none';

    const otherDetailsWrapper2 = document.getElementById('otherDetailsWrapper2');
    otherDetailsWrapper2.style.display = detail !== '------' ? 'block' : 'none';

    const otherDetailsWrapper3 = document.getElementById('otherDetailsWrapper3');
    otherDetailsWrapper3.style.display = specify_details !== '------' ? 'block' : 'none';



    // Function to calculate working days between two dates
    function calculateWorkingDays(start, end) {
        let startDate = new Date(start);
        let endDate = new Date(end);
        let workingDays = 0;

        while (startDate <= endDate) {
            const dayOfWeek = startDate.getDay();
            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Monday-Friday
                workingDays++;
            }
            startDate.setDate(startDate.getDate() + 1);
        }
        return workingDays;
    }

    // Calculate working days only if both dates are valid
    let workingDays = '------';
    if (rawStartDate && rawEndDate) {
        workingDays = calculateWorkingDays(rawStartDate, rawEndDate) + ' day/s';
    }

    
    const otherDetailsWrapper4 = document.getElementById('otherDetailsWrapper4');
    otherDetailsWrapper4.style.display = workingDays !== '------' ? 'block' : 'none';

    const otherDetailsWrapper5 = document.getElementById('otherDetailsWrapper5');
    otherDetailsWrapper5.style.display = workingDays !== '------' ? 'block' : 'none';



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
    document.getElementById('previewother_purpose_detail').innerText = other_purpose_detail;
    

    // Define special leave types that should show the submit button regardless
  const forcedTypes = [
    "Mandatory/Forced Leave",
    "Maternity Leave",
    "Paternity Leave",
    "Solo Parent Leave",
    "Study Leave",
    "10-Day VAWC Leave",
    "Rehabilitation Leave",
    "Adoption Leave",
    "Special Benifits for Women",
];

// Check form requirements
  const typeTrimmed = type.trim(); // ✅ Define this first

  const isBasicValid = department !== '------' && salary !== '------' && rawStartDate !== '' && rawEndDate !== '';
  const isFullyValid = isBasicValid && detail !== '------';
  const isOthersValid = typeTrimmed === "Others:" && other_purpose_detail !== '------' && department !== '------' && salary !== '------';
  
  const isnumber = number_const !== '------';
  const monitize = typeTrimmed === "Vacation Leave" || typeTrimmed === "Sick Leave" && isnumber;
  const submitButton = document.getElementById('show-only');

    if (isFullyValid || isOthersValid || monitize || (forcedTypes.includes(typeTrimmed) && isBasicValid)) {
        submitButton.style.display = 'inline-block';
    } else {
        submitButton.style.display = 'none';
    }


      // Show the modal
      document.getElementById('previewModal').style.display = 'block';
  }

function closePreview() {
    document.getElementById('previewModal').style.display = 'none';
}

// Set today's date
const currentDate = new Date();
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
const day = currentDate.getDate();
const month = months[currentDate.getMonth()];
const year = currentDate.getFullYear();
const formattedDate = `${month} ${day}, ${year}`;
document.getElementById('dateNow').innerText = formattedDate;

</script>

@endsection
