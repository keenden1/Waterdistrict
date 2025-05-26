<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Leave Modal</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 30px;
        border-radius: 10px;
        width: 400px;
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
.alert-box {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  margin: 15px;
  border: 1px solid #ccc;
  max-width: 400px;
  margin: 20px auto;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  position: relative;
}

.alert-box.success {
  border-color: rgb(0, 168, 84);
  background: #dfffe9;
  color: rgb(0, 80, 40);
}

.alert-box.error {
  border-color: rgb(221, 50, 50);
  background: #ffe4e4;
  color: rgb(130, 0, 0);
}

.alert-box button {
  margin-top: 10px;
  padding: 8px 16px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
table {
  border-collapse: collapse;
}
 th {
  background: #ccc;
}

th, td {
  border: 1px solid #ccc;
  padding: 8px;
}

tr:nth-child(even) {
  background: #efefef;
}

tr:hover {
  background: #d1d1d1;
}
  </style>
</head>
<body>

<button onclick="openLeaveModal()">Add Leave</button>

<button onclick="generateModal()">generate</button>
<!-- Success Message -->
@if(session('success'))
<div id="successMessage" class="alert-box success">
  <p>{{ session('success') }}</p>
  <button onclick="closeAlert('successMessage')">OK</button>
</div>
@endif

<!-- Error Messages -->
@if ($errors->any())
<div id="errorMessage" class="alert-box error">
  <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
  <div style="display: flex; align-items:center; justify-content:center;">
      <button onclick="closeAlert('errorMessage')">OK</button>
  </div>

</div>
@endif

<br><br><br>
<table class="my_table"  cellpadding="5" >
  <thead>
    <tr>
      <td>Monthly salary</td>
      <td>period</td>
      <td>month</td>
      <td>date</td>
      <td>Vl</td>
      <td>fl</td>
      <td>SL</td>
      <td>SPL</td>
      <td>OTHER</td>
      <td>VL Earned</td>
      <td>Absences</td>
      <td>balance</td>
       <td>Absences</td>
      <td>SL Earned</td>
      <td>Absences</td>
      <td>balance</td>
       <td>Absences</td>
      <td>Total</td>
      <td>date action</td>
    </tr>
  </thead>
  <tbody>
     @foreach ($leaves as $leave)
    <tr>
      <td>{{ $leave->monthly_salary }}</td>
      <td>{{ $leave->year }}</td>
      <td>{{ $leave->month }}</td>
      <td>{{ $leave->date }}</td>
      <td>{{ $leave->vl }}</td>
      <td>{{ $leave->fl }}</td>
      <td>{{ $leave->sl }}</td>
      <td>{{ $leave->spl }}</td>
      <td>{{ $leave->other }}</td>
      <td>{{ $leave->vl_earned }}</td>
      <td></td>
      <td>{{ $leave->vl_balance }}</td>
      <td></td>
      <td>{{ $leave->sl_earned }}</td>
      <td></td>
      <td>{{ $leave->sl_balance }}</td>
      <td></td>
      <td>{{ $leave->total_leave_earned }}</td>
      <td></td>
    </tr>
  @endforeach
  </tbody>
</table>
<!-- this -->

<div id="generateModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closegenerateModal()">&times;</span>
    <h2>Generate Payable</h2>
    <form action="{{ route('leaves.store') }}" method="POST">
      @csrf
         <input type="hidden" value="1" name="employee_id">
      <div class="step2">
         
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
                for ($i = 2000; $i <= $currentYear; $i++) {
                    echo "<option value=\"$i\">$i</option>\n";
                }
            ?>
          </select>
      </div>

 

      <div style="display: flex; align-items:center; justify-content:center">
        <button type="submit"  class="button_2">Generate</button>
      </div>
    </form>
  </div>
</div>

<!-- this -->

<div id="leaveModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeLeaveModal()">&times;</span>
    <h2>Add Leave Record</h2>
    <form action="{{ route('leaves.store') }}" method="POST">
      @csrf
         <input type="hidden" value="1" name="employee_id">
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
                for ($i = 2000; $i <= $currentYear; $i++) {
                    echo "<option value=\"$i\">$i</option>\n";
                }
            ?>
          </select>
        <label for="date">Date</label>
        <input type="text" name="date" placeholder="Date/Days e.g. 1-10 or 1,10" />
        <label for="monthly_salary">Monthly Salary</label>
        <input type="text" name="monthly_salary" id="monthly_salary" placeholder="123.."/>

        
      </div>

      <div class="step">
          <h4>Particular</h4>
        <input type="number" step="0.250" min="0" name="vl" placeholder="VL(Vacation Leave)" />
        <input type="number" step="0.250" min="0" name="sl" placeholder="SL(Sick Leave)" />
        <input type="number" step="0.250" min="0" name="fl" placeholder="fl(Forced Leave)" />
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

      <div class="nav-buttons">
        <button type="button" id="backBtn" onclick="prevStep()">Back</button>
        <button type="button" id="nextBtn" onclick="nextStep()">Next</button>
        <button type="submit" id="submitBtn" style="display:none;" class="button_2">Save</button>
      </div>
     
      
    </form>
  </div>
</div>

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
</body>
</html>
