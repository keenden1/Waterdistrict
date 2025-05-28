@extends('layout.layoutuser')

@section('title', 'Application-HISTORY')
@section('header_title', "HISTORY")
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<div class="section">
<table>
  <thead>
    <tr>
      <th>Applied Leave</th>
      <th>Date Filing</th>
      <th>Status</th>
      <th>Details</th>
    </tr>
  </thead>
  <tbody>
  @forelse($history as $item)
    <tr>
      <td>{{ $item->a_availed }}  
        @if($item->a_availed_others)
        {{ $item->a_availed_others }} 
        @endif</td>
      <td>{{ \Carbon\Carbon::parse($item->date_filing)->format('d, M Y') }}</td>
      @if ($item->status == 'Pending')
          <td><span class="pending-dot"></span>{{ $item->status }}</td>
      @endif
      @if ($item->status == 'Approved')
          <td><span class="green-dot"></span>{{ $item->status }}</td>
      @endif
      @if ($item->status == 'Declined')
          <td><span class="red-dot"></span>{{ $item->status }}</td>
      @endif
      <td><button popovertarget="myPopover" class="btn1"><i class="fa-solid fa-circle-question" style="color: #333;"></i></button></td>
      <div id="myPopover" popover>
          <h3>Details</h3><br>
          <div class="popover-content">
          
             <div class="row"><span class="label">Date Filing:</span></div>
              <div class="row">
              <span>{{ \Carbon\Carbon::parse($item->date_filing)->format('d, M Y') }}</span>
              </div>


            <div class="row"><span class="label">Status:</span></div>
              <div class="row">
                  <span>{{ $item->status }} </span>
              </div>

              @if($item->reason)
            <div class="row"><span class="label">Details of Disapproval:</span></div>
              <div class="row">
                  <span>{{ $item->reason }}</span>
              </div>
            @endif


            
              <div class="row"><span class="label">Office/Dept.:</span></div>
              <div class="row">
                  <span>{{ $item->officer_department }} </span>
              </div>

             <div class="row"><span class="label">Name:</span></div>
              <div class="row">
                  <span>{{ $item->fullname }} </span>
              </div>

                <div class="row"><span class="label">Position:</span></div>
              <div class="row">
                  <span>{{ $item->position }} </span>
              </div>

            <div class="row"><span class="label">Leave Availed:</span></div>
            <div class="row"> <span>{{ $item->a_availed }}</span></div>

            @if($item->a_availed_others)
              <div class="row"><span class="label">Others:</span></div>
              <div class="row">
                  <span>{{ $item->a_availed_others }}</span>
              </div>
            @endif

            <div class="row"><span class="label">Details of Leave:</span></div>
            <div class="row"> <span>{{ $item->b_details }}</span></div>

           
            @if($item->b_details_specify)
            <div class="row"><span class="label">Specify:</span></div>
              <div class="row">
                  <span>{{ $item->b_details_specify }}</span>
              </div>
            @endif
            <div class="row"><span class="label">Working Days Applied:</span></div>
            <div class="row"> <span>{{ $item->c_working_days }}</span></div>
            <div class="row"><span class="label">Inclusive Dates:</span></div>
            <div class="row"> <span>{{ $item->c_inclusive_dates }}</span></div>
            <div class="row"><span class="label">Commutation:</span></div>
            <div class="row"> <span>{{ $item->d_commutation }}</span></div>

           
          </div>
          <button popovertarget="myPopover" class="btn1"
          style="
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;">Close</button>
        </div>
    </tr>
    @empty
            <tr>
                <td colspan="7" style="text-align: center;">No leave history found.</td>
            </tr>
        @endforelse

  </tbody>

</table>

</div>
<style>
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
      #myPopover {
      max-width: 700px;
      width: 90%;
      height: 500px;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #333;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      background: white;
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    #myPopover::-webkit-scrollbar {
    width: 5px;
    border-radius: 10px;
  }

#myPopover::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

#myPopover::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

#myPopover::-webkit-scrollbar-thumb:hover {
  background: #555;
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

    .section{
    width: 100%;
    min-width: 350px;
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
      max-width: 100px;
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

  /*table */
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
    border-radius: 2px;
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
.progress-bar {
    position: absolute;
    top: -23px;
    width: 100%;
    height: 6px;
    background-color: #137d14;
    border-radius: 10px;

}

.icon-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
}
.checkmark img{
  margin: 20px;
}

.submitted-text {
    color: #137d14;
    font-weight: bold;
    font-size: 22px;
    margin-top: -10px;
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
@media (min-width: 830px) {
    #myPopover{
        margin-top: 20px;
    }
}
</style>

@endsection
