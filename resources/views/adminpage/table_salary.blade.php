@extends('layout.layout')

@section('title', 'Salary-Grade')
@section('header_title', "SALARY")
@section('content')

<div id="section">
<div id="myPopover" popover>
  <h1 style="text-align: center;">ADD SALARY</h1>
  <form action="{{ route('Admin-Salary-Add-page') }}" method="POST">
    @csrf
    <label for="salary_grade">Salary Grade</label>
    <input type="number" id="salary_grade" name="salary_grade" required placeholder="Grade...">

    @for ($i = 1; $i <= 8; $i++)
        <label for="step_{{ $i }}">Step {{ $i }}</label>
        <input type="number" id="step_{{ $i }}" name="step_{{ $i }}" placeholder="123...">
    @endfor

    <input type="submit" value="Submit">
</form>


<button popovertarget="myPopover" class="btn1"
          style="
            padding: 5px 10px;
            background-color: #f44336 ;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;
            transition: background-color 0.3s ease;"
            onmouseover="this.style.backgroundColor='#ff5c5c'; this.style.transform='scale(1.1)'" 
            onmouseout="this.style.backgroundColor='#f44336'; this.style.transform='scale(1)'"
            >X</button>
</div>
<table>
 <caption id="editable-caption" contenteditable="true">
    Second Tranche Monthly Salary Schedule for Civilian Personnel of the National Government Effective (Date) (in Pesos)
  </caption>
  <thead>
    <tr>
      <button onclick="saveCaption()" class="button-container">💾 Save Caption</button>
      <button onclick="resetCaption()" class="button-container">↩ Reset</button>
    </tr>
  </thead>
	<thead>
      <tr>
        <th style="text-align: center;vertical-align: middle;"><button href="" popovertarget="myPopover" class="btn2"><i class='bx bx-plus'>ADD</i></button></th>
        <th>Salary Grade</th>
        <th>Step 1</th>
        <th>Step 2</th>
        <th>Step 3</th>
        <th>Step 4</th>
        <th>Step 5</th>
        <th>Step 6</th>
        <th>Step 7</th>
        <th>Step 8</th>
      </tr>
  </thead>
  <tbody>
        @if($salary->isEmpty())
                    <tr>
                        <td colspan="9" style="text-align: center;">No Salary Found</td>
                    </tr>
                    @else
        @foreach($salary as $salaries)
      <tr>
        <td>
       <button type="button" class="btn-edit-salary"
  data-salary-id="{{ $salaries->id }}" 
  data-grade="{{ $salaries->salary_grade }}"
  data-step1="{{ $salaries->step_1 }}"
  data-step2="{{ $salaries->step_2 }}"
  data-step3="{{ $salaries->step_3 }}"
  data-step4="{{ $salaries->step_4 }}"
  data-step5="{{ $salaries->step_5 }}"
  data-step6="{{ $salaries->step_6 }}"
  data-step7="{{ $salaries->step_7 }}"
  data-step8="{{ $salaries->step_8 }}">
  <i class='bx bxs-edit-alt'></i>
</button>

         <form action="{{ route('Admin-Salary-Delete', $salaries->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this?')" style="border: none; background: none; cursor: pointer;">
                        <i class='bx bxs-trash-alt' style="color: red;"></i>
                    </button>
                </form>
        
        
        </td>
        <td><strong>{{ $salaries->salary_grade }}</strong></td>
        <td>
          @if($salaries->step_1 !== null)
              {{ number_format($salaries->step_1) }}
          @endif
        </td>
        <td>
          @if($salaries->step_2 !== null)
              {{ number_format($salaries->step_2) }}
          @endif
        </td>
        <td>
          @if($salaries->step_3 !== null)
              {{ number_format($salaries->step_3) }}
          @endif
        </td>
        <td>
          @if($salaries->step_4 !== null)
              {{ number_format($salaries->step_4) }}
          @endif
        </td>
        <td>
          @if($salaries->step_5 !== null)
              {{ number_format($salaries->step_5) }}
          @endif
        </td>
        <td>
          @if($salaries->step_6 !== null)
              {{ number_format($salaries->step_6) }}
          @endif
        </td>
        <td>
          @if($salaries->step_7 !== null)
              {{ number_format($salaries->step_7) }}
          @endif
        </td>
        <td>
          @if($salaries->step_8 !== null)
              {{ number_format($salaries->step_8) }}
          @endif
        </td>

      </tr>
      @endforeach
      @endif
  </tbody>
  
</table>
<!-- Modal -->
<div id="salaryModal" class="salaryModal-modal" style="display: none;">
  <div class="salaryModal-modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Edit Salary</h2>
    <form id="editSalaryForm" method="POST" action="">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit-salary-id">

      <label>Salary Grade</label>
      <input type="number" name="salary_grade" id="edit-grade" required>

      <div class="step-fields">
        @for ($i = 1; $i <= 8; $i++)
        <div>
          <label>Step {{ $i }}</label>
          <input type="number" name="step_{{ $i }}" id="edit-step{{ $i }}">
        </div>
        @endfor
      </div>

      <button type="submit" class="submit-btn">Save</button>
    </form>
  </div>
</div>

@if (session('success'))
<div class="modal" id="successModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="progress-bar"></div>
        </div>
        <div class="modal-body">
            <div class="icon-container">
                <span class="checkmark"><img src="logo/check.png" alt=""></span>
            </div>
            <h2>SUCCESS</h2>
            <h3 class="submitted-text">{{ session('success') }}</h3>
            <button id="closeModal" class="ok-btn">OK</button>
        </div>
    </div>
</div>
@endif
</div>
<style>
  .btn-edit-salary {
  background-color: #007bff;  /* Bootstrap primary blue */
  border: none;
  color: white;
  padding: 6px 10px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-edit-salary:hover {
  background-color: #0056b3; /* Darker blue on hover */
}

.btn-edit-salary i {
  pointer-events: none; /* So icon clicks register on button */
  font-size: 18px;
}

  .salaryModal-modal {
  display: none;
  position: fixed;
  z-index: 10000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.6);

}

.salaryModal-modal-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 20px 30px;
  border-radius: 10px;
  width: 90%;
  max-width: 550px;
  position: relative;
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {opacity: 0; transform: scale(0.95);}
  to {opacity: 1; transform: scale(1);}
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 20px;
  font-size: 28px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
}

.modal-content h2 {
  margin-top: 0;
  margin-bottom: 15px;
}

.step-fields {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.step-fields div {
  flex: 1 1 30%;
  display: flex;
  flex-direction: column;
}

input[type="number"] {
  padding: 6px 10px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.submit-btn {
  margin-top: 20px;
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.submit-btn:hover {
  background-color: #45a049;
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
  .progress-bar {
    position: absolute;
    top: -23px;
    width: 100%;
    height: 6px;
    background-color: #137d14;
    border-radius: 10px;

}
@keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
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
    max-width: 400px;
    width: 90%;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.modal-header {
    position: relative;
}
.modal-body h3{
  padding: 10px 0 ;
}
      .btn1 {
      position: absolute;
      top: 0;
      right: 20px;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
    }

    i {
      font-size: 24px; /* Adjust size if needed */
    }

    #myPopover button:hover {
      background-color: #0056b3;
    }
    #myPopover {
    margin-top: 70px;
    max-height: 500px;
    border: 1px solid #333; /* 50% opacity for a more visible border */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow */
    overflow-y: auto;
    padding-bottom: 20px;
}
#myPopover::-webkit-scrollbar {
  width: 2px; /* Set the width of the scrollbar */
}

/* Style the scrollbar track */
#myPopover::-webkit-scrollbar-track {
  background: #f1f1f1; /* Light gray background */
}

/* Style the scrollbar thumb (the draggable part) */
#myPopover::-webkit-scrollbar-thumb {
  background: #888; /* Darker color for the thumb */
  border-radius: 10px;
}

/* Change the thumb color on hover */
#myPopover::-webkit-scrollbar-thumb:hover {
  background: #555; /* Darker on hover */
}
/* Hide the spinner for number inputs in Webkit browsers (Chrome, Safari) */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.btn2 {
    background-color: #89CFF0; /* Soft Blue */
    color: white;
    border: none;
    padding: 5px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
  }

  .btn2:hover {
    background-color: #72B4E0; /* Slightly darker blue on hover */
  }

  .btn2:active {
    background-color: #5A9BCF; /* Even darker blue on click */
    transform: scale(0.98);
  }

  form{
    padding-top: 30px;
    max-width: 500px;
    margin: 20px;
    position: relative;
  }
  #radioButtons{
  margin: 5px 0 10px 0;
}

input[type=number], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #016a70;
  color: white;
  padding: 14px 20px;
  margin-top: 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #018c94;
}
table tr td:nth-child(1),table tr td:nth-child(2){
    text-align: center;
}
.section-section{
    display: flex;
    align-items: center;
    justify-content: center;
}
#section{
    max-height: 600px; 
    overflow-y: auto; 
    width: 100%;
}
table, th, td {
  border: solid 1px #000;
  padding: 10px;
  font-size: 18px;
}
thead{
    background: rgba(0, 0, 0, .1);
}
table {
    border-collapse:collapse;
    caption-side: top;
    width: 100%;
}

caption {
  font-size: 32px;
  font-weight: bold;
  padding-top: 5px;
  text-align: center;
}
@media screen and (max-width: 768px) {
   
    table, th, td {
        font-size: 11px;  
        
    }
    table{
        overflow: hidden;
    }
    th,td{
        white-space: nowrap; 
        text-overflow: ellipsis;
    }
}
 caption[contenteditable="true"]:focus {
      background-color: #fffbe6;
      border-color: #f0ad4e;
    }


    .button-container {
      padding: 6px 12px;
      margin-left: 5px;
      background-color: #007bff;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }

    .button-container:hover {
      background-color: #0056b3;
    }
</style>
<script>
    document.getElementById("closeModal").addEventListener("click", function() {
        document.getElementById("successModal").style.display = "none";
    });

    // Automatically close modal after 3 seconds
    setTimeout(() => {
        document.getElementById("successModal").style.display = "none";
    }, 3500);
</script>


<script>
// Open the modal and populate fields
function openSalaryModal(data) {
  document.getElementById('edit-salary-id').value = data.salaryId;
  document.getElementById('edit-grade').value = data.grade;

  for (let i = 1; i <= 8; i++) {
    document.getElementById(`edit-step${i}`).value = data[`step${i}`] ?? '';
  }

  // Set the form action URL dynamically with salary ID
  document.getElementById('editSalaryForm').action = `/Admin-Salary-Update/${data.salaryId}`;

  // Show the modal
  document.getElementById('salaryModal').style.display = 'block';
}

// Close the modal
function closeModal() {
  document.getElementById('salaryModal').style.display = 'none';
}

// Initialize event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
  // Attach click event to all edit buttons
  document.querySelectorAll('.btn-edit-salary').forEach(button => {
    button.addEventListener('click', function () {
      const data = this.dataset;
      openSalaryModal(data);
    });
  });

  // Attach click event to close button
  document.getElementById('closeModalBtn').addEventListener('click', closeModal);

  // Close modal if user clicks outside modal content

});

</script>
<script>
  const caption = document.getElementById("editable-caption");

  // Load caption from localStorage on page load
  window.onload = () => {
    const saved = localStorage.getItem("salaryTableCaption");
    if (saved) caption.textContent = saved;
  };

  function saveCaption() {
    const text = caption.textContent.trim();
    localStorage.setItem("salaryTableCaption", text);
    alert("Caption saved locally!");
  }

  function resetCaption() {
    localStorage.removeItem("salaryTableCaption");
    location.reload(); // reloads to show default
  }
</script>
@endsection