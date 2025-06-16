@extends('layout.layout')

@section('title', 'Employee-Account')
@section('header_title', "EMPLOYEE'S ACCOUNT")
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/17119/tablesort.min.js"></script>

<div class="search_div" style="display: flex; align-items:center; justify-content:space-between; margin: 0 10px;">
    <h1>Status</h1>
    
    <span class="spanless" style="display: flex; align-items: center; gap: 10px; margin-top: 25px;">
        <label for="sortType">Sort:</label>
        <select id="sortType" name="type" required>
            <option value="" disabled selected>Select Option</option>
            <option value="name">Sort by Id</option>
            <option value="leaveType">Sort Name</option>
        </select>

        <!-- Search Input -->
        <input type="text" id="searchInput" placeholder="Search..." >
    </span>
</div>
<div>
  
</div>
<div class="scroll" style="max-height: 520px; overflow-y: auto; border: 1px solid #ccc; margin-top:20px; border-radius:5px;">
    <table id="leaveTable">
  <thead>
    <tr>
      <th style="text-align: center;">Profile</th>
      <th style="text-align: center;">Employee ID</th>
      <th style="text-align: center;">Record</th>
      <th>Name</th>
      <th>Position</th>
      <th>Account Status</th>
      <th style="text-align: center;"><button onclick="openLeaveModal()" class="btn5">Monthly Record</button></th>
    </tr>
  </thead>
  <tbody>
  @forelse  ($employees as $employee)
    <tr>
     <td style="text-align: center;"><img src="{{ asset($employee->profile_picture ?? 'logo/logo.png') }}" alt="" style="
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;"></td>

      <td style="text-align: center;"> {{ $employee->employee_id }} </td>
       <td style="text-align: center;">
      <a class="btn5" href="{{ route('Admin-Input-page', $employee->employee_id) }}">View</a>
      </td>
      <td>{{ ucfirst(strtolower($employee->fname)) }} {{ $employee->mname ? ucfirst(strtolower($employee->mname)) . '.' : '' }} {{ ucfirst(strtolower($employee->lname)) }} </td>
      <td>{{ $employee->position }} </td>

      <!-- <td>
      @if ($employee->account_status != 'Pending' )
      <a class="btn4" href="/Admin-Employee-Attendance" >View</a>
      @endif
      @if ($employee->account_status == 'Pending' )
            ---------
      @endif
    </td>
      <td>
      @if ($employee->account_status != 'Pending' )
      <a class="btn4" href="/Admin-Employee-Salary" >View</a>
      @endif

      @if ($employee->account_status == 'Pending' )
            ---------
      @endif -->
 

    </td>
      @if ($employee->account_status == 'Pending')
          <td><span class="pending-dot"></span>{{ $employee->account_status }}</td>
      @endif
      @if ($employee->account_status == 'Approved')
          <td><span class="green-dot"></span>{{ $employee->account_status }}</td>
      @endif
      @if ($employee->account_status == 'Disabled')
          <td><span class="red-dot"></span>{{ $employee->account_status }}</td>
      @endif
      <td style="text-align: center;">
      <button popovertarget="myPopover-{{ $employee->id }}" class="btn5">Update</button>
      </td>

      <!-- <button class="btn1" style="font-size: 11px;" onclick="confirmAction()"><i class='bx bxs-check-circle' style="color: #28a745; font-size:1.3rem; text-align:center;display:flex; flex-direction:row; justify-content:center; align-items:center;text-align:center;"></i>Approve</button>
      <button class="btn1" style="font-size: 11px;"><i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.3rem;display:flex; flex-direction:row; justify-content:center; align-items:center;text-align:center;"></i>Disable</button> -->
    </tr>



    <div class="myPopover" id="myPopover-{{ $employee->id }}" popover style="border: 1px solid #333;">
         <a href="{{ url('/employee/edit') }}?id={{ $employee->id }}&employee_id={{ $employee->employee_id }}&position={{ urlencode($employee->position) }}&monthly_salary={{ $employee->monthly_salary }}" class="btn3">
            <i class='bx bx-edit'></i>
        </a>
          <h3>Details</h3><br>
          <div class="popover-content">
            <div class="row"><span class="label">Employee ID:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $employee->employee_id }}</span></div>
            <div class="row"><span class="label">Email Address:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $employee->email }}</span></div>
            <div class="row"><span class="label">Name:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ ucfirst(strtolower($employee->fname)) }} {{ $employee->mname ? ucfirst(strtolower($employee->mname)) . '.' : '' }} {{ ucfirst(strtolower($employee->lname)) }} </span></div>
            <div class="row"><span class="label">Position:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $employee->position }}</span></div>
             <div class="row"><span class="label">Monthly Salary:</span></div>
            <div class="row"> <span style="padding-left: 2em;">₱{{ $employee->monthly_salary }}</span></div>
            <div class="row"><span class="label">Account Status:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $employee->account_status }}</span></div>
          </div>

          @if ($employee->account_status == 'Pending')
          <div style="display:flex; align-items:center; justify-content:space-evenly;">
            <!-- <i class='bx bxs-check-circle' style="color: #28a745; font-size:1.7rem;"></i>  -->
             <!-- <i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.7rem;"></i> -->
          <button  class="btn1" onclick="confirmAction('{{ $employee->id }}', 'myPopover-{{ $employee->id }}')"
          style="
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;"
          >Approve Account</button>
          <button  class="btn1"  onclick="decline('{{ $employee->id }}', 'myPopover-{{ $employee->id }}')"
          style="
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;"
          >Disable</button>
          </div>
          @endif
          @if ($employee->account_status == 'Disabled')
           <div style="display:flex; align-items:center; justify-content:space-evenly;">
            <!-- <i class='bx bxs-check-circle' style="color: #28a745; font-size:1.7rem;"></i>  -->
             <!-- <i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.7rem;"></i> -->
          <button  class="btn1" onclick="confirmAction('{{ $employee->id }}', 'myPopover-{{ $employee->id }}')"
          style="
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;"
          >Activate Account</button>
          </div>
           @endif
           
           @if ($employee->account_status == 'Approved')
           <div style="display:flex; align-items:center; justify-content:space-evenly;">
            <!-- <i class='bx bxs-check-circle' style="color: #28a745; font-size:1.7rem;"></i>  -->
             <!-- <i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.7rem;"></i> -->
             <button  class="btn1"  onclick="decline('{{ $employee->id }}', 'myPopover-{{ $employee->id }}')"
          style="
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;"
          >Disable Account</button>
          </div>
           @endif
          <button popovertarget="myPopover-{{ $employee->id }}" class="btn2"
          style="
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;">X</button>
           </div>
          @empty
          <tr>
              <td colspan="7" style="text-align: center;">No Employee's found.</td>
          </tr>
      @endforelse
  </tbody>

</table>

<div id="leaveModal" class="leaveForm-modal" style="display: none;">
  <div class="leaveForm-modal-content">
    <span class="leaveForm-close" onclick="closeLeaveModal()">&times;</span>
    <h2 class="leaveForm-title">Monthly Record</h2>

    {{-- Initial Selection Form --}}
    <form id="initialLeaveForm" class="leaveForm-form">
      @csrf
      <div class="leaveForm-section">
        <h4>Employee Selection</h4>
        <label><input type="radio" name="employee_mode" value="multiple" onchange="toggleEmployeeSelection()"> Multiple</label>
        <label><input type="radio" name="employee_mode" value="all" onchange="toggleEmployeeSelection()"> All</label>

        <div id="employeeList" style="display: block; margin-top: 10px;">
          @foreach ($employees as $employee)
            @php
              $fullName = ucfirst(strtolower($employee->fname)) . ' ' .
                          ($employee->mname ? ucfirst(strtolower($employee->mname)) . '.' : '') .
                          ucfirst(strtolower($employee->lname));
            @endphp
            <label>
              <input type="checkbox" name="employee_ids[]" value="{{ $employee->employee_id }}" data-name="{{ $fullName }}" data-salary="{{ $employee->monthly_salary }}">
              {{ $fullName }}
            </label><br>
          @endforeach
        </div>

        <div id="globalPeriodSection" style="margin-top: 10px;">
          <h4>Period Selection</h4>
          <label class="leaveForm-label">Month</label>
          <select id="globalMonth" class="leaveForm-select" required>
            <option value="" disabled selected>Select..</option>
            @for ($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
            @endfor
          </select>

          <label class="leaveForm-label">Year</label>
          <select id="globalYear" class="leaveForm-select" required>
            <option value="" disabled selected>Select..</option>
          @for ($y = now()->year; $y >= 2010; $y--)
            <option value="{{ $y }}">{{ $y }}</option>
          @endfor
          </select>
        </div>
      </div>

      <div class="leaveForm-buttons">
        <button type="button" onclick="startEmployeeFormFlow()" class="leaveForm-button">Proceed</button>
      </div>
    </form>

    {{-- Multi-Employee Editable Form --}}
    <form id="multiLeaveForm" method="POST" action="{{ route('leaves.store.multiple') }}" style="display:none;">
      @csrf
      <div id="multiEmployeeFormContainer"></div>
    </form>
  </div>
</div>

@if ($errors->any())
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Error',
      html: `{!! implode('<br>', $errors->all()) !!}`
    });
  </script>
@endif

@if (session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: "{{ session('success') }}"
    });
  </script>
@endif

</div>
<style>

    .leaveForm-modal {
    display: block;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background: rgba(0, 0, 0, 0.4);
  }

  .leaveForm-modal-content {
  background: #fff;
  margin: 3% auto;
  padding: 20px;
  border-radius: 10px;
  width: 70%;      
  max-width: 700px;   
  max-height: 90vh;
  overflow-y: auto;
  font-family: Arial, sans-serif;
  font-size: 14px;    
}

  .leaveForm-title {
    text-align: center;
    margin-top: 0;
  }

  .leaveForm-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
  }

  .leaveForm-section {
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 10px;
  }

  .leaveForm-section h4 {
    margin-top: 0;
    color: #004080;
  }

  .leaveForm-label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
     font-size: 13px; 
  }

  .leaveForm-input,
  .leaveForm-select {
    width: 100%;
    font-size: 13px;    
    padding: 5px;  
    margin-top: 4px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .leaveForm-buttons {
    text-align: center;
    margin-top: 20px;
  }

  .leaveForm-button {
    padding: 10px 20px;
    background-color: #016a70;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

   .leaveForm-button:hover {
            background-color: #018c94;
          }
   .leaveForm-button:active {
            background-color:rgb(1, 122, 129);
            transform: scale(0.98);
            }
  .leaveForm-close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }
  .myPopover {
      position: relative;
      max-width: 700px;
      width: 90%;
      height: 500px;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background: white;
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1;
      padding-bottom: 20px;
    }
    .myPopover::-webkit-scrollbar {
    width: 5px;
    border-radius: 10px;
  }

.myPopover::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.myPopover::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

.myPopover::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.btn2 {
      position: absolute;
      top: 5px;
      right: 20px;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
    }
    .btn2:hover {
      transform: scale(1.1); /* Slight zoom effect */
    }
    .btn3 {
      position: absolute;
      top: 23px;
      right: 55px;
      background: none;
      border: none;
      padding: 0;
      color:black;
      cursor: pointer;
    }
    .btn3:hover {
      color: #007bff; /* Change to your preferred hover color */
      transform: scale(1.1); /* Slight zoom effect */
    }
    .btn3 i{
      font-size: 32px;
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
      padding: 15px;
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
  input,select{
    width: 90px;
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

#myPopover {
      min-width: 400px;
      border: none;
      height: 500px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      background: white;
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    /* Button styling */
    .btn1 {
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
    .popover-content {
      display: flex;
      flex-direction: column;
      gap: 10px;
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
        .btn4{
            padding: 8px 13px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
           .btn6{
            padding: 8px 13px;
            background-color:rgb(0, 255, 89);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
          .btn5 {
            background-color: #016a70;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.3s ease;
          }

          .btn5:hover {
            background-color: #018c94;
          }
          .btn5:active {
            background-color:rgb(1, 122, 129);
            transform: scale(0.98);
            }
            .btn7 {
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

  .btn7:hover {
    background-color: #72B4E0; /* Slightly darker blue on hover */
  }

  .btn7:active {
    background-color: #5A9BCF; /* Even darker blue on click */
    transform: scale(0.98);
  }
</style>
<script>
function confirmAction(applicationId, popoverId) {
  const popover = document.getElementById(popoverId);
  popover.hidePopover();

  Swal.fire({
    title: "Employee Status",
    text: "Are You Sure You Want to Activate this Employee?",
    icon: "success",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Activate"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/update-status-activate/${applicationId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: 'Approved' })
      })
      .then(response => response.json())
      .then(data => {
        Swal.fire("Confirmed!", "The application has been approved.", "success")
        .then(() => location.reload());
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error!", "Something went wrong.", "error");
      });
    }
  });
}
function decline(applicationId, popoverId) {
  const popover = document.getElementById(popoverId);
  popover.hidePopover();

  Swal.fire({
    title: "Employee Status",
    text: "Are You Sure You Want To Disable This Employee?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Disable"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/update-status-disable/${applicationId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: 'Disabled' })
      })
      .then(response => response.json())
      .then(data => {
        Swal.fire("Confirmed!", "The application has been approved.", "success")
        .then(() => location.reload());
      })
      .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error!", "Something went wrong.", "error");
      });
    }
  });
}

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
  let selectedEmployeeIds = [];
let selectedEmployeeNames = [];

function openLeaveModal() {
  document.getElementById('leaveModal').style.display = 'block';
  document.getElementById('employeeList').style.display = 'none';
  document.getElementById('initialLeaveForm').style.display = 'block';
  document.getElementById('multiLeaveForm').style.display = 'none';
}

function closeLeaveModal() {
  document.getElementById('leaveModal').style.display = 'none';
}

function toggleEmployeeSelection() {
  const mode = document.querySelector('input[name="employee_mode"]:checked');
  if (!mode) return;
  document.getElementById('employeeList').style.display = mode.value === 'multiple' ? 'block' : 'none';
}

function showForm(index) {
  const forms = document.querySelectorAll(".employee-form");
  forms.forEach((form, i) => {
    form.style.display = i === index ? "block" : "none";
  });
}

function startEmployeeFormFlow() {
  const mode = document.querySelector('input[name="employee_mode"]:checked');
  if (!mode) {
    alert("Please select employee mode.");
    return;
  }

  const selectedMonth = document.getElementById('globalMonth').value;
  const selectedYear = document.getElementById('globalYear').value;

  if (!selectedMonth || !selectedYear) {
    alert("Please select both month and year.");
    return;
  }

  const selectedMode = mode.value;
  const allEmployees = Array.from(document.querySelectorAll('input[name="employee_ids[]"]'));

  if (selectedMode === 'multiple') {
    // Multiple Mode: get only checked employees for editing
    const checked = allEmployees.filter(cb => cb.checked);
    if (checked.length === 0) {
      alert("Please select at least one employee.");
      return;
    }
    selectedEmployeeIds = checked.map(cb => cb.value);
  } else {
    // All Mode: select all employees automatically
    selectedEmployeeIds = allEmployees.map(cb => cb.value);
  }

  const container = document.getElementById("multiEmployeeFormContainer");
  container.innerHTML = "";

  if (selectedMode === 'multiple') {
    // Create editable forms only for selected employees (step-by-step)
    selectedEmployeeIds.forEach((id, index) => {
      const cb = allEmployees.find(cb => cb.value === id);
      const name = cb.dataset.name;
      const salary = cb.dataset.salary || "";
      const monthText = new Date(0, selectedMonth - 1).toLocaleString('default', { month: 'long' });

      const div = document.createElement("div");
      div.className = "employee-form";
      div.style.display = index === 0 ? "block" : "none";
      div.dataset.index = index;

      div.innerHTML = `
        <input type="hidden" name="employee_id[]" value="${id}">
        <input type="hidden" name="month[]" value="${selectedMonth}">
        <input type="hidden" name="year[]" value="${selectedYear}">
        <h3 style="margin-bottom: 10px;">${name}</h3>
        <p><strong>Period:</strong> ${monthText}, ${selectedYear}</p>

        <div class="leaveForm-section">
          <h4>Record Details</h4>
          <label class="leaveForm-label">Date</label>
          <input type="text" name="date[]" placeholder="Date/Days e.g. 1-10 or 1,10" class="leaveForm-input">
          <label class="leaveForm-label">Monthly Salary</label>
          <input type="number" name="monthly_salary[]" placeholder="123.." class="leaveForm-input" value="${salary}">
        </div>

        <div class="leaveForm-section">
          <h4>Particular</h4>
          <input type="number" step="0.250" min="0" name="vl[]" placeholder="VL (Vacation Leave)" class="leaveForm-input">
          <input type="number" step="0.250" min="0" name="fl[]" placeholder="FL (Forced Leave)" class="leaveForm-input">
          <input type="number" step="0.250" min="0" name="sl[]" placeholder="SL (Sick Leave)" class="leaveForm-input">
          <input type="number" step="0.250" min="0" name="spl[]" placeholder="SPL (Special Leave)" class="leaveForm-input">
          <input type="number" step="0.250" min="0" name="other[]" placeholder="Other" class="leaveForm-input">
        </div>

        <div class="leaveForm-section">
          <h4>Vacation Leave</h4>
          <label>Earned</label>
          <input type="number" name="vl_earned[]" value="1.250" class="leaveForm-input">
          <label>With Pay</label>
          <input type="number" name="vl_absences_withpay[]" class="leaveForm-input">
          <label>Without Pay</label>
          <input type="number" name="vl_absences_withoutpay[]" class="leaveForm-input">
        </div>

        <div class="leaveForm-section">
          <h4>Sick Leave</h4>
          <label>Earned</label>
          <input type="number" name="sl_earned[]" value="1.250" class="leaveForm-input">
          <label>With Pay</label>
          <input type="number" name="sl_absences_withpay[]" class="leaveForm-input">
          <label>Without Pay</label>
          <input type="number" name="sl_absences_withoutpay[]" class="leaveForm-input">
        </div>

        <div class="leaveForm-section">
          <h4>Absences/Tardiness</h4>
          <label>Day</label>
          <input type="number" name="day_A_T[]" class="leaveForm-input">
          <label>Hour</label>
          <input type="number" name="hour_A_T[]" class="leaveForm-input">
          <label>Minutes</label>
          <input type="number" name="minutes_A_T[]" class="leaveForm-input">
          <label>Times</label>
          <input type="number" name="times_A_T[]" class="leaveForm-input">
        </div>

        <div class="leaveForm-section">
          <h4>Undertime</h4>
          <label>Day</label>
          <input type="number" name="day_Under[]" class="leaveForm-input">
          <label>Hour</label>
          <input type="number" name="hour_Under[]" class="leaveForm-input">
          <label>Minutes</label>
          <input type="number" name="minutes_Under[]" class="leaveForm-input">
          <label>Times</label>
          <input type="number" name="times_Under[]" class="leaveForm-input">
        </div>

        <div class="leaveForm-buttons" style="margin-top: 10px; text-align: center;">
          ${index > 0 ? `<button type="button" onclick="showForm(${index - 1})">Back</button>` : ""}
          ${index < selectedEmployeeIds.length - 1 ? `<button type="button" onclick="showForm(${index + 1})">Next</button>` : `<button type="submit">Submit All</button>`}
        </div>
      `;

      container.appendChild(div);
    });

    // Add hidden inputs for unselected employees with default values
    const unselectedEmployees = allEmployees.filter(cb => !selectedEmployeeIds.includes(cb.value));
    unselectedEmployees.forEach(cb => {
      const id = cb.value;
      const salary = cb.dataset.salary || "";
      const hiddenDiv = document.createElement("div");
      hiddenDiv.style.display = "none";
      hiddenDiv.innerHTML = `
        <input type="hidden" name="employee_id[]" value="${id}">
        <input type="hidden" name="month[]" value="${selectedMonth}">
        <input type="hidden" name="year[]" value="${selectedYear}">
        <input type="hidden" name="date[]" value="">
        <input type="hidden" name="monthly_salary[]" value="${salary}">
        <input type="hidden" name="vl[]" value="0">
        <input type="hidden" name="fl[]" value="0">
        <input type="hidden" name="sl[]" value="0">
        <input type="hidden" name="spl[]" value="0">
        <input type="hidden" name="other[]" value="0">
        <input type="hidden" name="vl_earned[]" value="1.250">
        <input type="hidden" name="vl_absences_withpay[]" value="0">
        <input type="hidden" name="vl_absences_withoutpay[]" value="0">
        <input type="hidden" name="sl_earned[]" value="1.250">
        <input type="hidden" name="sl_absences_withpay[]" value="0">
        <input type="hidden" name="sl_absences_withoutpay[]" value="0">
        <input type="hidden" name="day_A_T[]" value="0">
        <input type="hidden" name="hour_A_T[]" value="0">
        <input type="hidden" name="minutes_A_T[]" value="0">
        <input type="hidden" name="times_A_T[]" value="0">
        <input type="hidden" name="day_Under[]" value="0">
        <input type="hidden" name="hour_Under[]" value="0">
        <input type="hidden" name="minutes_Under[]" value="0">
        <input type="hidden" name="times_Under[]" value="0">
      `;
      container.appendChild(hiddenDiv);
    });

    // Show forms container and hide initial form
    document.getElementById("initialLeaveForm").style.display = "none";
    document.getElementById("multiLeaveForm").style.display = "block";

  } else {
     // All mode - no editing, prepare form with all employees default data and submit immediately
  const form = document.getElementById("multiLeaveForm");
  selectedEmployeeIds.forEach(id => {
    const cb = allEmployees.find(cb => cb.value === id);
    const salary = cb.dataset.salary || "";
    const hiddenDiv = document.createElement("div");
    hiddenDiv.style.display = "none";
    hiddenDiv.innerHTML = `
      <input type="hidden" name="employee_id[]" value="${id}">
      <input type="hidden" name="month[]" value="${selectedMonth}">
      <input type="hidden" name="year[]" value="${selectedYear}">
      <input type="hidden" name="date[]" value="">
      <input type="hidden" name="monthly_salary[]" value="${salary}">
      <input type="hidden" name="vl[]" value="0">
      <input type="hidden" name="fl[]" value="0">
      <input type="hidden" name="sl[]" value="0">
      <input type="hidden" name="spl[]" value="0">
      <input type="hidden" name="other[]" value="0">
      <input type="hidden" name="vl_earned[]" value="1.250">
      <input type="hidden" name="vl_absences_withpay[]" value="0">
      <input type="hidden" name="vl_absences_withoutpay[]" value="0">
      <input type="hidden" name="sl_earned[]" value="1.250">
      <input type="hidden" name="sl_absences_withpay[]" value="0">
      <input type="hidden" name="sl_absences_withoutpay[]" value="0">
      <input type="hidden" name="day_A_T[]" value="0">
      <input type="hidden" name="hour_A_T[]" value="0">
      <input type="hidden" name="minutes_A_T[]" value="0">
      <input type="hidden" name="times_A_T[]" value="0">
      <input type="hidden" name="day_Under[]" value="0">
      <input type="hidden" name="hour_Under[]" value="0">
      <input type="hidden" name="minutes_Under[]" value="0">
      <input type="hidden" name="times_Under[]" value="0">
    `;
    form.appendChild(hiddenDiv); // <-- Append to the actual form
  });

  document.getElementById("initialLeaveForm").style.display = "none";
  document.getElementById("multiLeaveForm").style.display = "block";

  setTimeout(() => {
    form.submit();
  }, 100);

  }
}

</script>

@endsection