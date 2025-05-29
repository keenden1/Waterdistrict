@extends('layout.layout')

@section('title', 'Application-For-Leave')
@section('header_title', "APPLICATION FOR LEAVE")
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
<div style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc; margin-top:20px; margin-bottom:100px; border-radius:5px;">
    <table id="leaveTable">
  <thead>
    <tr>
      <th>Status</th>
      <th>Date Filing</th>
      <th>Name</th>
      <th>Commutation</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <!-- <tr>

      <td>
      <button  class="btn1" onclick="confirmAction()"><i class='bx bxs-check-circle' style="color: #28a745; font-size:1.7rem;"></i></button>
      <button  class="btn1"><i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.7rem;"></i></button>
      </td>
    </tr> -->
    @forelse  ($leave as $application)
    <tr>
      @if ($application->status == 'Pending')
          <td><span class="pending-dot"></span>{{ $application->status }}</td>
      @endif
      @if ($application->status == 'Approved')
          <td><span class="green-dot"></span>{{ $application->status }}</td>
      @endif
      @if ($application->status == 'Declined')
          <td><span class="red-dot"></span>{{ $application->status }}</td>
      @endif
      <td>{{ \Carbon\Carbon::parse($application->date_filing)->format('d, M Y') }}</td>
      <td>{{ $application->fullname}}</td>
      <td>{{ $application->d_commutation}}</td>
      <td>
      <button popovertarget="myPopover-{{ $application->id }}" class="btn1"  
      style="
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
           ">View</button>
    </td>


    <div class="myPopover" id="myPopover-{{ $application->id }}" popover style="border: 1px solid #333;">
          <h3>Details</h3><br>
          <div class="popover-content">
            <div class="row"><span class="label">Date Filing:</span></div>
            <div class="row">&Tab;<span style="padding-left: 2em;">{{ \Carbon\Carbon::parse($application->date_filing)->format('F d, Y') }} </span></div>
            <div class="row">&Tab;<span class="label">Status:</span></div>
            <div class="row"><span style="padding-left: 2em;">{{ $application->status }}</span></div>
            
            @if($application->reason)
            <div class="row"><span class="label">Details of Disapproval:</span></div>
              <div class="row">
                  <span style="padding-left: 2em;">{{ $application->reason }}</span>
              </div>
            @endif

            <div class="row"><span class="label">Office/Dept.:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->officer_department }}</span></div>
            <div class="row"><span class="label">Name:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->fullname }}</span></div>
            <div class="row"><span class="label">Position:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->position }}</span></div>





            <div class="row"><span class="label">Leave Availed:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->a_availed }}</span></div>
            @if($application->a_availed_others)
              <div class="row">
                  <span style="padding-left: 2em;">{{ $application->a_availed_others }}</span>
              </div>
            @endif

            <div class="row"><span class="label">Details of Leave:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->b_details }}</span></div>

           
            @if($application->b_details_specify)
            <div class="row"><span class="label">Specify:</span></div>
              <div class="row">
                  <span style="padding-left: 2em;">{{ $application->b_details_specify }}</span>
              </div>
            @endif
            <div class="row"><span class="label">Working Days Applied:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->c_working_days }}</span></div>
            <div class="row"><span class="label">Inclusive Dates:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->c_inclusive_dates }}</span></div>
            <div class="row"><span class="label">Commutation:</span></div>
            <div class="row"> <span style="padding-left: 2em;">{{ $application->d_commutation }}</span></div>
          </div>

          @if ($application->status == 'Pending')
          <div style="display:flex; align-items:center; justify-content:space-evenly;">
            <!-- <i class='bx bxs-check-circle' style="color: #28a745; font-size:1.7rem;"></i>  -->
             <!-- <i class='bx bxs-x-circle' style="color: #dc3545; font-size:1.7rem;"></i> -->
          <button  class="btn1" onclick="confirmAction('{{ $application->id }}', 'myPopover-{{ $application->id }}')"
          style="
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;"
          >Approve</button>
          <button  class="btn1"  onclick="decline('{{ $application->id }}', 'myPopover-{{ $application->id }}')"
          style="
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;"
          >Decline</button>
          </div>
         
       
          @endif
          <button popovertarget="myPopover-{{ $application->id }}" class="btn2"
          style="
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;">X</button>

            @if($application->status == "Approved" || $application->status == "Declined")
            <a  href="{{ url('/export-users/' . $application->id) }}" target="_blank"
            style="
            position: absolute; 
            top:25px; right:60px; 
            ">
              <i class='bx bx-download' style="font-size: 32px; text-decoration:none; color:#007bff;"></i></a>
            @endif

           </div>

    </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align: center;">No leave applications found.</td>
        </tr>
    @endforelse
  </tbody>

</table>

</div>

<style>
.swal2-container {
  z-index: 9999 !important;
}
body .swal2-container {
  z-index: 9999 !important;
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
    /* active_click */
/*Active links*/
.nav__list a:nth-child(3) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(3)::before {
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
    .btn2 {
      position: absolute;
      top: 5px;
      right: 20px;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
    }
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
        background-color: #dc3545; /* Adjust gray color */
        border-radius: 50%; /* Makes it a perfect circle */
        display: inline-block; /* Ensures it behaves like a dot */
        margin-right: 10px;
        }
</style>
<script>
function confirmAction(applicationId, popoverId) {
  const popover = document.getElementById(popoverId);
  popover.hidePopover();

  Swal.fire({
    title: "Approve Application",
    text: "Please confirm your approval of this application.",
    icon: "success",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Submit"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/update-status-approve/${applicationId}`, {
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
  popover.hidePopover(); // Close the popover

  Swal.fire({
    title: "Disapprove Due to:",
    icon: "warning",
    input: "textarea",
    inputPlaceholder: "Type your reason...",
    inputAttributes: {
      'aria-label': 'Type your reason here'
    },
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Submit",
    didOpen: () => {
      const confirmBtn = Swal.getConfirmButton();
      const textarea = Swal.getInput();

      confirmBtn.disabled = true;

      textarea.addEventListener("input", () => {
        confirmBtn.disabled = !textarea.value.trim();
      });
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const reason = result.value;

      // Send to server
      fetch(`/update-status-decline/${applicationId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          status: 'Declined',
          reason: reason // send the reason as well
        })
      })
      .then(response => response.json())
      .then(data => {
        Swal.fire("Declined!", "The application was declined with your reason.", "success")
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