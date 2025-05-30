@extends('layout.layout')

@section('title', 'Summary-Of-Absences')
@section('header_title', "SUMMARY OF ABSENCES")
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="search_div" style="display: flex; align-items:center; justify-content:space-between; margin: 0 10px; ">
    <span style="display: flex; justify-content:start;"> <h2>&nbsp;Tardiness and Undertime</h2><h2>&nbsp;as of {{$lastDay}}</h2></span>
     <a href="#" id="print-report-link">
      <button class="btn2" type="button">Print Report</button>
    </a>
    </div>
</div>

<div style="max-height: 620px; overflow-y: auto; border: 1px solid #ccc; margin-top:5px;margin-bottom:10px; border-radius:5px;">
<table id="leaveTable" border="1" style="border-collapse: collapse; width: 100%; text-align: center; border-radius:5px;">
  <thead>
    <tr><td rowspan="2">No.</td>
        <td colspan="3">Employee Name</td>
        <td colspan="4">Absence/Tardiness</td>
        <td colspan="4">Undertime</td>
        <td colspan="5">Total</td>
    </tr>
    <tr>
       <td>last Name</td>
       <td>First Name</td>
       <td>Last Name</td>
       <td>Day</td>
       <td>Hour</td>
       <td>Minutes</td>
       <td>Times</td>
       <td>Day</td>
       <td>Hour</td>
       <td>Minutes</td>
       <td>Times</td>
       <td>Day</td>
       <td>Hour</td>
       <td>Minutes</td>
       <td>Times</td>
       <td style="padding: 10px 0;">Conversion <br>(Equivalent Day)</td>
    </tr>
   
  </thead>
  <tbody>
     @forelse ($leaves as $leave)
    <tr>
         <td>{{ $loop->iteration }}</td>
        <td>{{ $leave->lname ?? ''}}</td>
        <td>{{ $leave->fname ?? ''}}</td>
        <td>{{ $leave->mname ?? ''}}</td>
        <td>{{ $leave->day_A_T ?? '0'}}</td>
        <td>{{ $leave->hour_A_T ?? '0'}}</td>
        <td>{{ $leave->minutes_A_T ?? '0'}}</td>
        <td>{{ $leave->times_A_T ?? '0'}}</td>
        <td>{{ $leave->day_Under ?? '0'}}</td>
        <td>{{ $leave->hour_Under ?? '0'}}</td>
        <td>{{ $leave->minutes_Under ?? '0'}}</td>
        <td>{{ $leave->times_Under ?? '0'}}</td>
        <td>{{ ($leave->day_A_T ?? 0) + ($leave->day_Under ?? 0) }}</td>
        <td>{{ ($leave->hour_A_T ?? 0) + ($leave->hour_Under ?? 0) }}</td>
        <td>{{ ($leave->minutes_A_T ?? 0) + ($leave->minutes_Under ?? 0) }}</td>
        <td>{{ ($leave->times_A_T ?? 0) + ($leave->times_Under ?? 0) }}</td>
      
        <td>{{ $leave->total_conversion ?? ''}}</td>
    </tr>
    @empty
    <tr>
      <td colspan="17" style="text-align: center; height:300px; font-size:32px;">No Record Found</td>
    </tr>
  @endforelse
 @if ($leaves->count() > 0)
    <tr>
        <td colspan="4" style="text-align: center;"><strong>TOTAL</strong></td>
        <td>{{ $sum_day ?? '0' }}</td>
        <td>{{ $sum_hour ?? '0' }}</td>
        <td>{{ $sum_minutes ?? '0' }}</td>
        <td>{{ $sum_times ?? '0' }}</td>
        <td>{{ $sum_day_1 ?? '0' }}</td>
        <td>{{ $sum_hour_1 ?? '0' }}</td>
        <td>{{ $sum_minutes_1 ?? '0' }}</td>
        <td>{{ $sum_times_1 ?? '0' }}</td>
        <td>{{ ($sum_day ?? 0) + ($sum_day_1 ?? 0) }}</td>
        <td>{{ ($sum_hour ?? 0) + ($sum_hour_1 ?? 0) }}</td>
        <td>{{ ($sum_minutes ?? 0) + ($sum_minutes_1 ?? 0) }}</td>
        <td>{{ ($sum_times ?? 0) + ($sum_times_1 ?? 0) }}</td>
        <td></td>
    </tr>
@endif
  </tbody>

</table>



</div>
<style>
    /* active_click */
/*Active links*/
.nav__list a:nth-child(7) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(7)::before {
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
      background-color: rgba(0, 0, 0, 0.15);
      font-weight: bold;
  }
  th, td {
      padding: 15px;
      text-align: center;
      font-size: 13px;
      white-space: nowrap; /* Prevent text from wrapping */
      text-overflow: ellipsis; /* Show "..." when text is too long */
      max-width: 145px;
      overflow: hidden;
      
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
.btn2{
    align-items: end;
}
@media screen and (min-width: 768px) {
    #myPopover{
        margin-top: 20px;
  }
  .search_div{
    margin-top: -30px !important;
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
    text-align: center;
   .btn2{
    width: 100%;
   }
  }
  .search_div,.search_div span{
    margin: 0 !important;
    display: flex;

    padding: 0 !important;
    flex-direction: column; 
  }

  .search_div h2{
    margin: 0!important;
  }
  .card p{
    font-size: 11px;
  }
  #header{
    font-size: medium;
  }
  }
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

</script>

    <script>
  document.getElementById('print-report-link').addEventListener('click', function(e) {
    e.preventDefault();

    const month =  '{{ $monthsreq }}'
    const year = '{{ $year }}';

    if (!month || !year) {
      alert('Please select both month and year.');
      return;
    }

    const url = `/export-late-template/${month}/${year}`;
    window.open(url, '_blank'); // open in new tab
  });
</script>
@endsection