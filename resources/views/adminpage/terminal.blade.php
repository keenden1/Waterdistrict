@extends('layout.layout')

@section('title', 'Terminal-Leave')
@section('header_title', "TERMINAL LEAVE")
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="search_div" style="display: flex; align-items:center; justify-content:space-between; margin: 0 10px; ">
    <span style="display: flex; justify-content:start;"> <h2>&nbsp;Benefits Payable</h2><h2>&nbsp;as of {{$date}}</h2></span>
    <a href="#" id="print-report-link">
      <button class="btn2" type="button">Print Report</button>
    </a>

    </div>
</div>

<div style="max-height: 620px; overflow-y: auto; border: 1px solid #ccc; margin-top:5px;margin-bottom:10px; border-radius:5px;">
<table id="leaveTable" border="1" style="border-collapse: collapse; width: 100%; text-align: center; border-radius:5px;">
  <thead>
    <tr>
      <th rowspan="3" colspan="2" style="text-align: center; vertical-align: middle;">EMPLOYEE NAME</th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">MONTHLY SALARY <br> as of {{$date}}</th>
      <th colspan="3" style="text-align: center; vertical-align: middle;">EARNED LEAVES <br> as of {{$date}}</th>
      <th rowspan="3" style="text-align: center; vertical-align: middle;">CONSTANT FACTOR</th>
      <th rowspan="3" style="text-align: center; vertical-align: middle;">TOTAL</th>
    </tr>
    <tr>
      <th style="text-align: center; vertical-align: middle;">VL</th>
      <th style="text-align: center; vertical-align: middle;">SL</th>
      <th style="text-align: center; vertical-align: middle;">TOTAL</th>
    </tr>
  </thead>
  <tbody>
    @forelse($leaves as $index => $item)
    <tr>
        <td style="text-align: center;">{{ $index + 1 }}</td>
        <td>{{ ucwords($item->lname . ', ' . $item->fname . ' ' . $item->mname) }}</td>
        <td>Php {{ number_format($item->monthly_salary, 2) }}</td>
        <td style="text-align: center;">{{ $item->vl_balance ?? 0 }}</td>
        <td style="text-align: center;">{{ $item->sl_balance ?? 0 }}</td>
        <td style="text-align: center;">{{ $item->total ?? 0 }}</td>
        <td style="text-align: center;">{{ $item->constant_factor }}</td>
        <td>Php {{ number_format($item->grand_total, 2) }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="8" style="text-align: center;">No data available for the selected month and year.</td>
    </tr>
    @endforelse
</tbody>

@if($leaves->count() > 0)
<tfoot>
    <tr>
        <td colspan="7" style="text-align: right;"><strong>TOTAL LEAVE BENEFIT PAYABLE TO DATE</strong></td>
        <td>Php {{ number_format($total_leave_benefit, 2) }}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right;"><strong>BALANCE PREVIOUS MONTH</strong></td>
        <td>Php {{ number_format($previous_balance, 2) }}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right;"><strong>TOTAL PAYABLE CURRENT MONTH</strong></td>
        @php
    $current_month_payable = $total_leave_benefit - $previous_balance;
    $is_negative = $current_month_payable < 0;
    $formatted_payable = $is_negative 
        ? '(' . number_format(abs($current_month_payable), 2) . ')' 
        : number_format($current_month_payable, 2);
  @endphp

    <td @class(['red-text' => $is_negative])>
        Php {{ $formatted_payable }}
    </td>
    </tr>
</tfoot>
@endif

</table>



</div>
<style>
    /* active_click */
/*Active links*/
.nav__list a:nth-child(4) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(4)::before {
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
      text-align: left;
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
         .red-text {
    color: red;
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

    const url = `/export-terminal-template/${month}/${year}`;
    window.open(url, '_blank'); // open in new tab
  });
</script>

    
@endsection