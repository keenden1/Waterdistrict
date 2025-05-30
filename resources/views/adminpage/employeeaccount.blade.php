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
      <th>Action</th>
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
      <td>
      <button popovertarget="myPopover-{{ $employee->id }}" class="btn5">Update</button>
      </td>

      <!-- <button class="btn1" style="font-size: 11px;" onclick="confirmAction()"><i class='bx bxs-check-circle' style="color: #28a745; font-size:1.3rem; text-align:center;display:flex; flex-direction:row; justify-content:center; align-items:center;text-align:center;"></i>Approve</button>
      <button class="btn1" style="font-size: 11px;"><i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.3rem;display:flex; flex-direction:row; justify-content:center; align-items:center;text-align:center;"></i>Disable</button> -->
    </tr>



    <div class="myPopover" id="myPopover-{{ $employee->id }}" popover style="border: 1px solid #333;">
          <h3>Details</h3><br>
          <div class="popover-content">
            <div class="row"><span class="label">Employee ID:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $employee->employee_id }}</span></div>
            <div class="row"><span class="label">Email Address:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $employee->email }}</span></div>
            <div class="row"><span class="label">Name:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ ucfirst(strtolower($employee->fname)) }} {{ $employee->mname ? ucfirst(strtolower($employee->mname)) . '.' : '' }} {{ ucfirst(strtolower($employee->lname)) }} </span></div>
            
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

</div>
<style>
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

    
@endsection