@extends('layout.layout')

@section('title', 'Leave-Credit-Card')
@section('header_title', "LEAVE CREDIT CARD")
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="search_div" style="display: flex; align-items:center; justify-content:space-between;">
    <span style="display: flex; justify-content: start;">
    <h2><span id="date-time"></span></h2>
    </span>
    <a href="{{ route('xl') }}"><button class="btn2" id="btn2">Generate Report</button></a>
    </div>
</div>
<div class="table-name" style="justify-content:space-between">
    <div class="div-name-header" style="display: flex; align-items:center; Justify-content: center; font-size:32px;">Name: <p style="text-transform: capitalize;text-decoration: underline; margin:0 0 0 20px; font-size:32px;">asdasdas</p></div>
    <div style="border:3px solid #333; display:flex;"> 
            <table class="table-card">
                <tbody>
                    <tr>
                        <td>Legend:</td>
                        <td>VL</td>
                        <td>Vacation leave </td>
                        <td>FL</td>
                        <td>Force Leave</td>
                        <td class="hide">A</td>
                        <td class="hide">Absent</td>
                        <td class="hide">EA</td>
                        <td class="hide">Excused Absence</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>SL</td>
                        <td>Sick Leave</td>
                        <td>SPL</td>
                        <td>Special Leave</td>
                        <td class="hide">HD</td>
                        <td class="hide">Half Day</td>
                        <td class="hide">MON</td>
                        <td class="hide">Monetization</td>
                    </tr>
                    <tr>
                        <td class="show"></td>
                        <td class="show">A</td>
                        <td class="show">Absent</td>
                        <td class="show">EA</td>
                        <td class="show">Excused Absence</td>
                    </tr>
                    <tr>
                        <td  class="show" ></td>
                        <td  class="show" >HD</td>
                        <td  class="show">Half Day</td>
                        <td  class="show">MON</td>
                        <td  class="show">Monetization</td>
                    </tr>
                </tbody>
            </table>
    </div>
</div>

<div style="max-height: 460px; overflow-y: auto; border: 1px solid #ccc; margin-top:5px;margin-bottom:10px; border-radius:5px;">
<table id="leaveTable" border="1" style="border-collapse: collapse; width: 100%; text-align: center; border-radius:5px; ">
  <thead>
    <tr>
      <th rowspan="3" style="text-align: center; vertical-align: middle;">PERDIOD</th>
      <th colspan="6" style="text-align: center; vertical-align: middle;">PARTICULAR</th>
      <th colspan="4" style="text-align: center; vertical-align: middle;">VACATION LEAVE</th>
      <th colspan="4" style="text-align: center; vertical-align: middle;">SICK LEAVE</th>
      <th rowspan="3" style="text-align: center; vertical-align: middle;">TOTAL LEAVE <br> CREDITS <br> EARNED</th>
      <th rowspan="3" style="text-align: center; vertical-align: middle;">DATE & ACTION <br> TAKEN ON <br>APPLICATION <br>FOR LEAVE</th>
    </tr>
    <tr>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">DATE</th>
      <th colspan="5" style="text-align: center; vertical-align: middle;">TYPE</th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">EARNED</th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">ABSENCES/ <br>UNDERTIME <br><span style="text-decoration:underline;">with pay </span></th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">BALANCE</th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">ABSENCES/ <br>UNDERTIME <br><span style="text-decoration:underline;">with pay </span></th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">EARNED</th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">ABSENCES/ <br>UNDERTIME <br><span style="text-decoration:underline;">with pay </span></th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">BALANCE</th>
      <th rowspan="2" style="text-align: center; vertical-align: middle;">ABSENCES/ <br>UNDERTIME <br><span style="text-decoration:underline;">with pay </span></th>
    </tr>
    <tr>
        <th style="text-align: center; vertical-align: middle;">VL</th>
        <th style="text-align: center; vertical-align: middle;">FL</th>
        <th style="text-align: center; vertical-align: middle;">SL</th>
        <th style="text-align: center; vertical-align: middle;">SPL</th>
        <th style="text-align: center; vertical-align: middle;">OTHER</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td colspan="7" style="text-align: center;"><strong>BALANCE BROUGHT FORWARD</strong> </td>
        <td></td>
        <td></td>
        <td style="text-align: center;"><strong>0.00</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: center;"><strong>0.00</strong></td>
        <td></td>
        <td style="text-align: center;"><strong>0.00</strong></td>
        <td></td>
    </tr>
    <tr>
        <td style="text-align: center;"><strong>2010</strong> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
      <td style="text-align: center;">January</td>
      <td style="text-align: center;">12</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr>
    <tr>
        <td style="text-align: center;"><strong>TOTAL</strong> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>



</div>
<style>
    /* active_click */
/*Active links*/
.nav__list a:nth-child(5) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(5)::before {
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
#leaveTable th,#leaveTable tr{
    font-size: 10px;
}

#leaveTable tbody tr{
    line-height: 2px !important;

}
@media screen and (min-width: 768px) {
    #myPopover{
        margin-top: 20px;
  }
 
  .search_div{
    margin-top: -30px;
  }
  .show{
        display: none;
    }
    .table-name{
       display: flex;
    }
    .table-card td{
        padding-top: 0!important;
        padding-bottom: 0!important;
    }
  }
  @media screen and (max-width: 768px) {
    #btn2{
    width: 150px;
    }
    .div-name-header{
        height:50px;
        font-size: 18px !important;
    }
     p{
        font-size: 18px !important;
    }
    .table-card td{
        font-size: 12px;
    }
    .table-card td{
        margin: 0;
        padding: 5px 10px;
    }
    .hide{
        display: none;
    }
   

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
   function updateDateTime() {
    const currentDate = new Date();
    
    // Format the date to "January 10, 2020"
    const optionsDate = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString('en-US', optionsDate);
    
    // Format the time to "10:00 AM"
    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };
    const formattedTime = currentDate.toLocaleTimeString('en-US', optionsTime);

    // Combine date and time
    const formattedDateTime = `${formattedDate} - ${formattedTime}`;
    
    document.getElementById("date-time").innerText = formattedDateTime;
  }

  // Update date and time when the page loads
  window.onload = updateDateTime;

  // Optionally, update the date and time every second
  setInterval(updateDateTime, 1000);
</script>

    
@endsection