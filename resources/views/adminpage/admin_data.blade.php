@extends('layout.layout')

@section('title', 'Employee-Input')
@section('header_title', "Employee Data")
@section('content')
<!-- Firebase App (the core Firebase SDK) -->
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<!-- Firebase Auth -->
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/17119/tablesort.min.js"></script>

<!-- @php

chdir('C:\xampp\htdocs\waterdistrict');  // your Laravel project path

do {
    $output = [];
    $return_var = 1;  // initialize as failure
    exec('php artisan schedule:run 2>&1', $output, $return_var);

    if ($return_var !== 0) {

        sleep(10);  // wait 10 seconds before retry
    }
} while ($return_var !== 0);
@endphp -->




<div class="search_div" style="display: flex; align-items:center; justify-content:space-between; margin: 0 10px;">
    <h1>Employee Name: {{ $name}} </h1>
    <button class="btn2" onclick="openLeaveModal()">&nbsp;&nbsp;Update&nbsp;&nbsp;</button>
</div>
<div class="scroll" style="max-height: 520px; overflow-y: auto; border: 1px solid #ccc; margin-top:20px; border-radius:5px;">
    <table id="leaveTable">
  <thead>
    <tr>
        <th colspan="3" style="text-align: center; border-right:1px solid black; border-bottom:1px solid black; ">Period</th>
        <th colspan="5" style="text-align: center; border-right:1px solid black; border-bottom:1px solid black; ">Particular</th>
        <th colspan="4" style="text-align: center; border-right:1px solid black; border-bottom:1px solid black; ">Vacation Leave</th>
        <th colspan="4" style="text-align: center; border-right:1px solid black; border-bottom:1px solid black; ">Sick Leave</th>
        <th colspan="3" style="text-align: center;  overflow: visible; border-bottom:1px solid black; position:relative;"><span class="tooltip">Legend:<span class="tooltip-text" style="text-align: left;">
            VL: Vacation Leave <br>
            SL: Sick Leave <br>
            FL: Forced Leave <br>
            SPL: Special Leave <br>
            A: Absent <br>
            HD: Half Day <br>
            EA: Excused Absences <br>
            MON: Monetization <br>
        </span></span>
      <a href="javascript:void(0);" class="open-password-popup" style="position:absolute; top:5px; right:20px; font-size:24px; text-decoration:none; color:black;">
        <i class='bx bx-cog'></i>
      </a>
      </th>
    </tr>
    <div id="passwordPopup" class="password-popup-overlay" style="display: none;">
  <div class="password-popup">
    <span class="close-popup">&times;</span>
    <form method="POST" action="{{ route('change-password') }}">
      @csrf
      <label>Current Password</label>
      <input type="password" name="current_password" required>

      <label>New Password</label>
      <input type="password" name="new_password" required>

      <label>Confirm New Password</label>
      <input type="password" name="new_password_confirmation" required>

      <button type="submit">Change Password</button>
    </form>
  </div>
</div>

    <tr>
      <th>Year</th>
      <th>Month</th>
      <th>Date</th>

      <th>VL</th>
      <th>FL</th>
      <th>SL</th>
      <th>SPL</th>
      <th>Other</th>

      <th>Earned</th>
      <th style=" overflow: visible;"><span class="tooltip">With Pay<span class="tooltip-text">ABSENCES/UNDERTIME  <br> with PAY</span></span></th>
      <th>Balance</th>
      <th style=" overflow: visible;"><span class="tooltip">Without Pay<span class="tooltip-text">ABSENCES/UNDERTIME  <br> without PAY</span></span></th>

       <th>Earned</th>
      <th style=" overflow: visible;"><span class="tooltip">With Pay<span class="tooltip-text">ABSENCES/UNDERTIME  <br> with PAY</span></span></th>
      <th>Balance</th>
      <th style=" overflow: visible;"><span class="tooltip">Without Pay<span class="tooltip-text">ABSENCES/UNDERTIME <br> without PAY</span></span></th>
      <th style=" overflow: visible;"><span class="tooltip">Credits<span class="tooltip-text">Total Leave <br> Credits Earned</span></span></th>
      <th style=" overflow: visible;"><span class="tooltip">Dates & Action<span class="tooltip-text">Date & Action <br> taken on Application <br> For Leave</span></span></th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  @forelse($employee as $index  => $employees)
      <tr>
        <td>{{ $employees->year ?? '' }}</td>
      @php
          $monthName = $employees->month ? \Carbon\Carbon::create()->month($employees->month)->format('F') : '';
      @endphp
      <td>{{ $monthName }}</td>

        <td>{{ $employees->date ?? '' }}</td>
        <td>{{ $employees->vl ?? '' }}</td>
        <td>{{ $employees->fl ?? '' }}</td>
        <td>{{ $employees->sl ?? '' }}</td>
        <td>{{ $employees->spl ?? '' }}</td>
        <td>{{ $employees->other ?? '' }}</td>
        <td>{{ $employees->vl_earned ?? '' }}</td>
        <td>{{ $employees->vl_absences_withpay ?? '' }}</td>
        <td>{{ $employees->vl_balance ?? '' }}</td>
        <td>{{ $employees->vl_absences_withoutpay ?? '' }}</td>
        <td>{{ $employees->sl_earned ?? '' }}</td>
        <td>{{ $employees->sl_absences_withpay ?? '' }}</td>
        <td>{{ $employees->sl_balance ?? '' }}</td>
        <td>{{ $employees->sl_absences_withoutpay ?? '' }}</td>
        <td>{{ $employees->total_leave_earned ?? '' }}</td>
        <td></td>
        <td>
          <a href="javascript:void(0);" onclick="confirmDeleteWithPassword('{{ $employees->id }}')">
            <i class='bx bxs-trash-alt' style="color: red;"></i>
          </a>


        </td>
      </tr>
    @empty
      <tr>
        <td colspan="19" style="text-align: center;">No records found.</td>
      </tr>
    @endforelse
  </tbody>

</table>

<!-- this -->

</div>


@if(session('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Success',
  text: '{{ session("success") }}',
  confirmButtonText: 'OK'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
  icon: 'error',
  title: 'Error',
  text: '{{ session("error") }}',
  confirmButtonText: 'OK'
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
  icon: 'error',
  title: 'Please check the form and correct the following:',
  html: `{!! implode('<br>', $errors->all()) !!}`,
  confirmButtonText: 'OK'
});
</script>
@endif


<div id="leaveModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeLeaveModal()">&times;</span>
    <div style="display: flex; align-items:center;">    <h2>Add Record</h2></div>

    <form action="{{ route('leaves.store') }}" method="POST">
      @csrf
         <input type="hidden" value="{{$employee_id_new}}" name="employee_id">
      <div class="step active">
          <h4>Period</h4>
          <label for="month">Month</label>
          <select id="month" name="month" >
            <option value="" disabled selected>Select..</option>
            <?php
                for ($i = 1; $i <= 12; $i++) {
                    $monthName = date('F', mktime(0, 0, 0, $i, 1)); 
                    echo "<option value=\"$i\">$monthName</option>\n";
                }
            ?>
        </select>
        <label for="year">Year</label>
        <select id="year" name="year" >
            <option value="" disabled selected>Select..</option>
            <?php
                $currentYear = date('Y'); // Get the current year
                for ($i = $currentYear; $i >= 2010; $i--) {
                    echo "<option value=\"$i\">$i</option>\n";
                }
            ?>
          </select>
        <label for="date">Date</label>
        <input type="text" name="date" placeholder="Date/Days e.g. 1-10 or 1,10" />
        <label for="monthly_salary">Monthly Salary</label>
        <input type="number" name="monthly_salary" id="monthly_salary" placeholder="123.."/>

        
      </div>

      <div class="step">
          <h4>Particular</h4>
        <input type="number" step="0.250" min="0" name="vl" placeholder="VL(Vacation Leave)" />
        <input type="number" step="0.250" min="0" name="fl" placeholder="fl(Forced Leave)" />
        <input type="number" step="0.250" min="0" name="sl" placeholder="SL(Sick Leave)" />
        <input type="number" step="0.250" min="0" name="spl" placeholder="spl(Special Leave)" />
        <input type="number" step="0.250" min="0" name="other" placeholder="Other" />
      </div>

      <div class="step">
           <h4>Vacation Leave</h4>
        <label for="vl_earned">Earned</label>
        <input type="number"  name="vl_earned" value="1.250" />
        <label for="vl_absences_withpay">Absences/Undertime with pay</label>
        <input type="number"  name="vl_absences_withpay"  />
        <label for="vl_absences_withoutpay">Absences/Undertime without pay</label>
        <input type="number"  name="vl_absences_withoutpay"  />
      </div>

      <div class="step">
          <h4>Sick Leave</h4>
        <label for="sl_earned">Earned</label>
        <input type="number"  name="sl_earned" value="1.250" />
        <label for="sl_absences_withpay">Absences/Undertime with pay</label>
        <input type="number"  name="sl_absences_withpay"  />
        <label for="sl_absences_withoutpay">Absences/Undertime without pay</label>
        <input type="number"  name="sl_absences_withoutpay"  />
      </div>
      
      <div class="step">
     
         
          <h4>Absences/Tardiness</h4>
          <label for="day">Day</label>
         <input type="number" max="30" name="day_A_T"/>
         <label for="hour">Hour</label>
         <input type="number" max="59" name="hour_A_T"/>
         <label for="minutes">Minutes</label>
         <input type="number" max="59" name="minutes_A_T"/>
         <label for="times">Times</label>
         <input type="number"  name="times_A_T"/>
      </div>
        <div class="step">
          <h4>Undertime</h4>
          <label for="day">Day</label>
         <input type="number"  name="day_Under"/>
         <label for="hour">Hour</label>
         <input type="number"  name="hour_Under"/>
         <label for="minutes">Minutes</label>
         <input type="number"  name="minutes_Under"/>
         <label for="times">Times</label>
         <input type="number"  name="times_Under"/>
      

         

      </div>

      <div class="nav-buttons">
        <button type="button" id="backBtn" onclick="prevStep()">Back</button>
        <button type="button" id="nextBtn" onclick="nextStep()">Next</button>
        <button type="submit" id="submitBtn" style="display:none;" class="button_2">Save</button>
      </div>
     
      
    </form>
  </div>
</div>
<style>
 

 .modal {
        display: none;
        position: fixed;
        z-index: 99999999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.4);
      
    }
    .modal-content {
        width: 90%;
        background: white;
        margin: 5% auto;
        padding: 30px;
        border-radius: 10px;
     
        max-width: 600px;
        position: relative;
    }
    .close {
        position: absolute;
        right: 20px;
        top: 15px;
        font-size: 20px;
        cursor: pointer;
    }
    .step {
        display: none;
        flex-direction: column;
    }
    .step2{
        display: flex;
        flex-direction: column;
    }
    .step.active {
        display: flex;
    }
    input ,select{
        margin: 8px 0;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        margin-top: 15px;
        padding: 10px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
     .button_2 {
        margin-top: 15px;
        padding: 10px;
        background:rgb(4, 97, 32);
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .button_2:hover {
        background: rgb(0, 255, 115); 
        color: black;
        }
    .nav-buttons {
        display: flex;
        justify-content: space-between;
    }
    .final-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    }
    /* as */


  .btn2 {
    background-color: #89CFF0; /* Soft Blue */
    color: white;
    border: none;
    padding: 10px 5px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    height: 50px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
  }

  .btn2:hover {
    background-color: #72B4E0; /* Slightly darker blue on hover */
  }

  .btn2:active {
    background-color: #5A9BCF; /* Even darker blue on click */
    transform: scale(0.98);
  }
   .scroll::-webkit-scrollbar {
    width: 5px;
    border-radius: 10px;
  }

.scroll::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.scroll::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

.scroll::-webkit-scrollbar-thumb:hover {
  background: #555;
}
    /* active_click */
/*Active links*/
.nav__list a:nth-child(6) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(6)::before {
  content: "";
  position: absolute;
  left: 0;
  width: 5px;
  height: 42px;
  background-color: #cf222f;
}

select{
      
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 6px;
        background: #ffffff;
        color: #333;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        outline: none;
    }
    input{
        padding: 7px 11px;
        font-size: 16px;
        border-radius: 6px;
        background: #ffffff;
        color: #333;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        outline: none;
    }

    select:hover,input:hover {
        border-color: #1E3A8A;
    }

    select:focus,input:focus {
        border-color: #1E3A8A;
        box-shadow: 0 0 5px rgba(30, 58, 138, 0.5);
    }

    /* Styling the dropdown arrow */
    select::-ms-expand,input::-ms-expand {
        display: none;
    }

    select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 30px; /* Space for custom arrow */
        background: url('data:image/svg+xml;utf8,<svg fill="%234A90E2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5H7z"/></svg>') no-repeat right 10px center;
        background-size: 15px;
    }
      th[role=columnheader]:not(.no-sort) {
	cursor: pointer;
}

th[role=columnheader]:not(.no-sort):after {
	content: '';
	float: right;
	margin-top: 7px;
	border-width: 0 4px 4px;
	border-style: solid;
	border-color: #333 transparent;
	visibility: hidden;
	opacity: 0;
	-ms-user-select: none;
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
}

th[aria-sort=ascending]:not(.no-sort):after {
	border-bottom: none;
	border-width: 4px 4px 0;
}

th[aria-sort]:not(.no-sort):after {
	visibility: visible;
	opacity: 0.4;
}

th[role=columnheader]:not(.no-sort):hover:after {
	visibility: visible;
	opacity: 1;
}

table {
      font-size: small ;
      width: 100%;
      border-collapse: separate;
      min-width: 300px;
      border-spacing: 0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
  }
  thead {
      background-color: #f8f8f8;
      font-weight: bold;
  }
  th, td {
      padding: 10px;
      text-align: left;
      white-space: nowrap; /* Prevent text from wrapping */
      text-overflow: ellipsis; /* Show "..." when text is too long */
      max-width: 145px;
      overflow: hidden;
     
  }

  tbody tr:nth-child(odd) {
      background-color:rgb(209, 208, 208);
  }
 
  .status {
      font-weight: bold;
  }
  .pending {
      color: gray;
  }
  .approved {
      color: green;
  }
  .declined {
      color: red;
  }
  .table-container {
    width: 100%;
    overflow-x: auto; /* Makes table scrollable on small screens */
}
@media screen and (min-width: 768px) {
    #myPopover{
        margin-top: 20px;
  }
  }
  @media screen and (max-width: 768px) {
  h1{
    padding-top: 12px;
  }
 
  .spanless{
   gap: 2px !important;
  }
  .search_div{
    margin: 0 !important;
  }
  .card p{
    font-size: 11px;
  }
  #header{
    font-size: medium;
  }
  }


    .row {
      display: flex;
      justify-content: space-between;
    }

    .label {
      font-weight: bold;
    }
    .pending-dot {
        width: 12px; /* Adjust size */
        height: 12px;
        background-color: #FFC107; /* Yellow color for pending */
        border-radius: 50%; /* Makes it a circle */
        display: inline-block; /* Ensures it behaves like a dot */
        margin-right: 10px;
        }
        .green-dot {
        width: 12px; /* Adjust size as needed */
        height: 12px;
        background-color: #00C86F; /* Adjust green color */
        border-radius: 50%; /* Makes it a perfect circle */
        display: inline-block; /* Ensures it behaves like a dot */
        margin-right: 10px;
        }
    
        .red-dot {
        width: 12px; /* Adjust size as needed */
        height: 12px;
        background-color: #333 ; /* Adjust gray color */
        border-radius: 50%; /* Makes it a perfect circle */
        display: inline-block; /* Ensures it behaves like a dot */
        margin-right: 10px;
        }
         .tooltip {
            position: relative;
            cursor: pointer;
            text-decoration: underline;
        }
        .tooltip .tooltip-text {
            visibility: hidden;
            width: 180px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            top: 125%; 
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        .btn4{
            padding: 8px 13px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
           .btn5{
            padding: 8px 13px;
            background-color:rgb(0, 255, 89);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .password-popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  display: flex;
  align-items: center;
  justify-content: center;
}

.password-popup {
  background: white;
  padding: 20px;
  border-radius: 8px;
  position: relative;
  max-width: 400px;
  width: 90%;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
}

.password-popup label {
  display: block;
  margin-top: 10px;
}

.password-popup input {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
}

.password-popup button {
  margin-top: 15px;
  padding: 10px;
  width: 100%;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.password-popup .close-popup {
  position: absolute;
  top: 5px;
  right: 10px;
  cursor: pointer;
  font-size: 20px;
}

</style>
<script>

document.getElementById("sortType").addEventListener("change", function () {
        let table = document.getElementById("leaveTable").getElementsByTagName("tbody")[0];
        let rows = Array.from(table.getElementsByTagName("tr"));
        let sortType = this.value;

        rows.sort((rowA, rowB) => {
            let cellA, cellB;

            if (sortType === "name") {
                cellA = rowA.cells[0].textContent.toLowerCase();
                cellB = rowB.cells[0].textContent.toLowerCase();
            } else if (sortType === "leaveType") {
                cellA = rowA.cells[1].textContent.toLowerCase();
                cellB = rowB.cells[1].textContent.toLowerCase();
            } else if (sortType === "date") {
                cellA = new Date(rowA.cells[2].textContent);
                cellB = new Date(rowB.cells[2].textContent);
            }

            return cellA > cellB ? 1 : -1;
        });

        rows.forEach(row => table.appendChild(row)); // Reinsert sorted rows
    });
    new Tablesort(document.getElementById('leaveTable'));
    
    document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#leaveTable tbody tr");

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = ""; // Show row if it matches
        } else {
            row.style.display = "none"; // Hide row if it doesn’t match
        }
    });
});
</script>
    
<script>
  let currentStep = 0;
  const steps = document.querySelectorAll('.step');
  const submitBtn = document.getElementById('submitBtn');
function showStep(step) {
  steps.forEach((s, index) => {
    s.classList.toggle('active', index === step);
  });

  const backBtn = document.getElementById('backBtn');
  const nextBtn = document.getElementById('nextBtn');
  const navButtons = document.querySelector('.nav-buttons');

  if (step === 0) {
    backBtn.style.display = 'none';
    navButtons.style.justifyContent = 'flex-end';
  } else {
    backBtn.style.display = 'inline-block';
    navButtons.style.justifyContent = 'space-between';
  }

  // Show "Save" button on last step, hide "Next"
  if (step === steps.length - 1) {
    submitBtn.style.display = 'inline-block';
    nextBtn.style.display = 'none';
  } else {
    submitBtn.style.display = 'none';
    nextBtn.style.display = 'inline-block';
  }
}


  function nextStep() {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  }

  function prevStep() {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  }

  function openLeaveModal() {
    document.getElementById('leaveModal').style.display = 'block';
    currentStep = 0;
    showStep(currentStep);
  }

  function closeLeaveModal() {
    document.getElementById('leaveModal').style.display = 'none';
  }


  function closeAlert(id) {
  document.getElementById(id).style.display = 'none';
}
 document.querySelectorAll('.leave-input').forEach(function(input) {
    input.addEventListener('blur', function() {
      let value = parseFloat(this.value);
      if (!isNaN(value)) {
        this.value = value.toFixed(3); // Formats the number to 3 decimal places
      }
    });
  });

// generate
 function generateModal() {
    document.getElementById('generateModal').style.display = 'block';
  }

  function closegenerateModal() {
    document.getElementById('generateModal').style.display = 'none';
  }


</script>
<script>
   document.getElementById('monthly_salary').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9.]/g, ''); // Allow digits and one dot
  });
</script>
<script>
function closePopup(id) {
  const popup = document.getElementById(id);
  if (popup) popup.style.display = 'none';
}
</script>
<script>
  document.querySelector('#leaveModal form').addEventListener('keydown', function (e) {
    const activeStep = document.querySelector('.step.active');
    const isTextInput = ['input', 'select', 'textarea'].includes(e.target.tagName.toLowerCase());

    if (e.key === 'Enter' && isTextInput) {
      const submitBtn = document.getElementById('submitBtn');

      // Only allow Enter to submit on the last step
      if (submitBtn.style.display !== 'inline-block') {
        e.preventDefault();
        nextStep(); // Optional: auto-go to next step if not last
      }
    }
  });



</script>


<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-analytics.js";
  import { getAuth, EmailAuthProvider, reauthenticateWithCredential } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-auth.js";

  (async () => {
    // Initialize Firebase app
    const firebaseConfig = await fetch('/json/waterdistrictweb.json').then(r => r.json());
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
    const auth = getAuth(app);

    // NOTE: Don't try to sign in with a token here!
    // Your backend already authenticated user.
    // You can optionally check if user is logged in, but signInWithCustomToken() is NOT needed.

    // Password confirmed delete function
   window.confirmDeleteWithPassword = async function(itemId) {
  const { value: password } = await Swal.fire({
    title: 'Confirm Deletion',
    input: 'password',
    inputLabel: 'Enter your password to delete',
    inputPlaceholder: 'Your password',
    inputAttributes: {
      autocapitalize: 'off',
      autocorrect: 'off',
    },
    showCancelButton: true,
  });

  if (!password) return;

  try {
    // Send delete request to backend with password
    const response = await fetch('/delete-with-password', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ item_id: itemId, password }),
    });

    if (!response.ok) {
      const err = await response.json();
      throw new Error(err.message || 'Server failed to delete item');
    }

    Swal.fire('Deleted!', 'The item has been deleted.', 'success').then(() => location.reload());
  } catch (error) {
    Swal.fire('Error', error.message, 'error');
  }
};

  })();
</script>


<script>
  document.querySelector('.open-password-popup').addEventListener('click', function () {
    document.getElementById('passwordPopup').style.display = 'flex';
  });

  document.querySelector('.close-popup').addEventListener('click', function () {
    document.getElementById('passwordPopup').style.display = 'none';
  });

  // Optional: Close when clicking outside the popup
  window.addEventListener('click', function (e) {
    const popup = document.getElementById('passwordPopup');
    if (e.target === popup) {
      popup.style.display = 'none';
    }
  });
</script>


@endsection