@extends('layout.layout')

@section('title', 'Dashboard')
@section('header_title', 'DASHBOARD') 
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/17119/tablesort.min.js"></script>
<div class="card-container">
        <a href="{{ url('/Admin-Application-Leave') }}" class="card" id="card-1">
                <i class='bx bx-grid-alt icon'></i>
                <div class="card-content">
                <p class="label">Application for Leave</p>
                <h2>{{$countleave}}</h2>
            </div>
        </a>
        <a href="{{ url('/Admin-Terminal-Leave') }}" class="card" id="card-2">
                <i class="bx bx-terminal icon"></i>
                <div class="card-content">
                <p class="label">Terminal Leave</p>
                <h2>7</h2>
            </div>
        </a>
        <a href="{{ url('/Admin-Employee-Account') }}" class="card" id="card-3">
                <i class="bx bxs-user-account icon"></i> 
                <div class="card-content">
                <p class="label">Employee Account</p>
                <h2>{{$countemployee}}</h2>
            </div>
        </a>
        <a href="{{ url('/Admin-Summary') }}" class="card" id="card-4">
                <i class="bx bx-note icon"></i>
                <div class="card-content">
                <p class="label">Summary</p>
                <h2>7</h2>
            </div>
        </a>
    </div>
    <div class="search_div" style="display: flex; align-items:center; justify-content:space-between; margin: 0 10px;">
    <h1>PENDING REQUEST </h1>
    
    <span class="spanless" style="display: flex; align-items: center; gap: 10px; margin-top: 25px;">
        <label for="sortType">Sort:</label>
        <select id="sortType" name="type" required>
            <option value="" disabled selected>Select</option>
            <option value="name">Sort by Leave Type</option>
            <option value="date">Sort by Status</option>
            <option value="leaveType">Sort Date</option>
        </select>

        <!-- Search Input -->
        <input type="text" id="searchInput" placeholder="Search...">
    </span>
</div>
@if (session('success'))
    <div id="popup-message" class="popup-message">
        <span class="popup-close" onclick="closePopup()">&times;</span>
        {{ session('success') }}
    </div>
@endif


    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc; margin-top:20px; margin-bottom:100px; border-radius:5px;">
    <table id="leaveTable">
  <thead>
    <tr>
      <th>Name</th>
      <th>Applied Leave</th>
      <th>Date</th>
      <th>Status</th>
      <th>Details</th>
    </tr>
  </thead>
  <tbody>
  @forelse($leave as $item)
    <tr>
      <td>{{ $item->fullname }}</td>
      <td>
      @if($item->a_availed !== 'Others:')
          {{ $item->a_availed }}
          @else
          {{ $item->a_availed_others }}
       @endif
      </td>
      <td>{{ \Carbon\Carbon::parse($item->date_filing)->format('d, M Y') }}</td>
      @if ($item->status == 'Pending')
          <td><span class="pending-dot"></span>{{ $item->status }}</td>
      @endif
      @if ($item->status == 'Approved')
          <td><span class="pending-dot"></span>{{ $item->status }}</td>
      @endif
      @if ($item->status == 'Declined')
          <td><span class="pending-dot"></span>{{ $item->status }}</td>
      @endif
      <td><a href="{{ url('/Admin-Application-Leave') }}" ><button class="btn5">View</button></a></td>
    </tr>
    @empty
            <tr>
                <td colspan="5" style="text-align: center;">No Pending Application.</td>
            </tr>
    @endforelse

  </tbody>

</table>

</div>
    <style>
.popup-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #4CAF50;
    color: white;
    padding: 20px 40px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
    z-index: 9999;
    text-align: center;
    position: fixed;
}

.popup-close {
    position: absolute;
    top: 8px;
    right: 12px;
    font-size: 24px;
    cursor: pointer;
}
.popup-message.hide {
    opacity: 0;
    pointer-events: none;
}



/*Active links*/
.nav__list a.active {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a.active::before {
  content: "";
  position: absolute;
  left: 0;
  width: 5px;
  height: 42px;
  background-color: #cf222f;
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
.card:hover {
    transform: scale(1.05);
}
.card-container {
    display: flex;
    flex-wrap: wrap; /* Ensures wrapping on smaller screens */
    justify-content: center;
    gap: 10px;
    max-width: 100%; /* Prevents container from overflowing */
}

.card {
    width: calc(25% - 10px); /* 4 cards per row */
    text-decoration: none;
    color: white;
    padding: 20px 40px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s;
}

/* Responsive: 2 cards per row when screen width <= 700px */
@media (max-width: 700px) {
    .card {
        width: calc(50% - 10px); /* 2 cards per row */
    }
}
#card-1{
  background-color: #97a5a2; 
}
#card-2{
  background-color: #394384; 
}
#card-3{
  background-color: #6b705c; 
}
#card-4{
  background-color: #97a5a2; 
}
.icon {
            font-size: 50px;
            border: 2px solid white;
            padding: 10px;
            border-radius: 8px;
            color: white;
            margin-right: 15px; /* Creates space between icon and text */
        }

        /* Text content */
        .card-content {
            display: flex;
            flex-direction: column; /* Stacks text */
            color: white;
        }

        .card-content p {
            margin: 0;
            font-size: 14px;
        }

        .card-content h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
           margin-left: 25px;
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
      max-width: 140px;
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
        background-color: #dc3545; /* Adjust gray color */
        border-radius: 50%; /* Makes it a perfect circle */
        display: inline-block; /* Ensures it behaves like a dot */
        margin-right: 10px;
        }
/* button {
    padding: 6px 10px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    background-color: #1E3A8A; 
    color: white;
    cursor: pointer;
    transition: background 0.3s ease-in-out, transform 0.2s ease;
}

button:hover {
    background-color: #142c6e; 
    transform: scale(1.05);
}

button:active {
    background-color: #0f1e4f;
    transform: scale(0.98);
} */
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
    </style>
    <script>
function confirmAction() {
  Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, proceed!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Confirmed!", "Your action has been executed.", "success");
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
    function closePopup() {
        const popup = document.getElementById('popup-message');
        if (popup) {
            popup.classList.add('hide');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            closePopup();
        }, 4000);
    });
</script>


@endsection