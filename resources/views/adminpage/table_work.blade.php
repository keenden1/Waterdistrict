@extends('layout.layout')

@section('title', 'Working-Hour-Conversion')
@section('header_title', "Work Hour")
@section('content')

<div id="section">
  
  <table>
    <caption id="editable-caption" contenteditable="true">Conversion of Working Hours/Minutes</caption>
     <thead>
    <tr>
      <button onclick="saveCaption()" class="button-container">💾 Save Caption</button>
      <button onclick="resetCaption()" class="button-container">↩ Reset</button>
    </tr>
  </thead>
    <thead>
  <tr>
    <th style="text-align: center;">
      <button href="" popovertarget="myPopover" class="btn-add-entry" onclick="document.getElementById('addPopover').style.display='block'">
        <i class='bx bx-plus'>ADD</i>
      </button>
      <div class="popover" id="addPopover">
        <h4>Add Working Minutes</h4>
      <div class="popover-content">
        <form action="{{ route('Admin-Work-Add')}}" method="POST">
          @csrf
          <label>Minutes:</label>
          <input type="number" name="minutes" required>
          
          <label>Equivalent Day:</label>
          <input type="text" name="equivalent_day" required>

       
         
          <div class="popover-actions">
            <button type="submit">Add</button>
            <button type="button" onclick="document.getElementById('addPopover').style.display='none'">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    </th>
    <th>Minutes</th>
    <th>EQUIV. DAY</th>
    <th>Minutes</th>
    <th>EQUIV. DAY</th>
    <th style="text-align: center;">Actions</th> {{-- New column header --}}
  </tr>
</thead>

    <tbody>
   @php
  $leftColumn = $work->slice(0, 30)->values();
  $rightColumn = $work->slice(30, 30)->values();
@endphp
@for ($i = 0; $i < 30; $i++)
  <tr>
    {{-- Left Column: 1–30 --}}
    <td>
      @if(isset($leftColumn[$i]))
        <button class="btn-add-entry" onclick="document.getElementById('editPopover{{ $leftColumn[$i]->id }}').style.display='block'">
      <i class='bx bxs-edit-alt'></i>
    </button>

    <!-- Popover -->
    <div class="popover" id="editPopover{{ $leftColumn[$i]->id }}">
      <div class="popover-content">
            <h4>Update Working Minutes</h4>
        <form action="{{ route('Admin-Work-Update', $leftColumn[$i]->id) }}" method="POST">
          @csrf
          @method('PUT')
          <label>Minutes:</label>
          <input type="number" name="minutes" value="{{ $leftColumn[$i]->minutes }}" required>
          
          <label>Equivalent Day:</label>
          <input type="text" name="equivalent_day" value="{{ $leftColumn[$i]->equivalent_day }}" required>

          <div class="popover-actions">
            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('editPopover{{ $leftColumn[$i]->id }}').style.display='none'">Cancel</button>
          </div>
        </form>
      </div>
    </div>
        <form action="{{ route('Admin-Work-Delete', $leftColumn[$i]->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Are you sure you want to delete this?')" style="border: none; background: none; cursor: pointer;">
            <i class='bx bxs-trash-alt' style="color: red;"></i>
          </button>
        </form>
      @endif
    </td>
    <td>
      @if(isset($leftColumn[$i]))
        <strong>{{ $leftColumn[$i]->minutes }}</strong>
      @endif
    </td>
    <td>
      @if(isset($leftColumn[$i]))
        {{ $leftColumn[$i]->equivalent_day }}
      @endif
    </td>

    {{-- Right Column: 31–60 --}}
    <td>
      @if(isset($rightColumn[$i]))
        <strong>{{ $rightColumn[$i]->minutes }}</strong>
      @endif
    </td>
    <td>
      @if(isset($rightColumn[$i]))
        {{ $rightColumn[$i]->equivalent_day }}
      @endif
    </td>
    <td style="text-align: center;">
      @if(isset($rightColumn[$i]))
        <button class="btn-add-entry" onclick="document.getElementById('editPopoverleft{{ $rightColumn[$i]->id }}').style.display='block'">
      <i class='bx bxs-edit-alt'></i>
    </button>

    <!-- Popover -->
    <div class="popover" id="editPopoverleft{{ $rightColumn[$i]->id }}">
      <div class="popover-content">
          <h4>Update Working Minutes</h4>
        <form action="{{ route('Admin-Work-Update', $rightColumn[$i]->id) }}" method="POST">
          @csrf
          @method('PUT')
          <label>Minutes:</label>
          <input type="number" name="minutes" value="{{ $rightColumn[$i]->minutes }}" required>
          
          <label>Equivalent Day:</label>
          <input type="text" name="equivalent_day" value="{{ $rightColumn[$i]->equivalent_day }}" required>

          <div class="popover-actions">
            <button type="submit">Update</button>
            <button type="button" onclick="document.getElementById('editPopoverleft{{ $rightColumn[$i]->id }}').style.display='none'">Cancel</button>
          </div>
        </form>
      </div>
    </div>
        <form action="{{ route('Admin-Salary-Delete', $rightColumn[$i]->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Are you sure you want to delete this?')" style="border: none; background: none; cursor: pointer;">
            <i class='bx bxs-trash-alt' style="color: red;"></i>
          </button>
        </form>
      @endif
    </td>
  </tr>
@endfor


    </tbody>
  </table>

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

  
  @if (session('error'))
    <div class="modal" id="successModal">
      <div class="modal-content">
        <div class="modal-header">
          <div class="progress-bar"></div>
        </div>
        <div class="modal-body">
          <div class="icon-container">
            <span class="checkmark"><img src="logo/check.png" alt=""></span>
          </div>
          <h2>Error</h2>
          <h3 class="submitted-text">{{ session('error') }}</h3>
          <button id="closeModal" class="ok-btn">OK</button>
        </div>
      </div>
    </div>
  @endif
</div>

<style>
  .modal {
    display: flex;
    position: fixed;
    top: 50%;
    left: 50%;
    width: 100%;
    transform: translate(-50%, -50%);
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
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

  .modal-body h3 {
    padding: 10px 0;
  }

  i {
    font-size: 24px;
  }

  #myPopover button:hover {
    background-color: #0056b3;
  }

  #myPopover {
    margin-top: 70px;
    max-height: 500px;
    border: 1px solid #333;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    padding-bottom: 20px;
  }

  #myPopover::-webkit-scrollbar {
    width: 2px;
  }

  #myPopover::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  #myPopover::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
  }

  #myPopover::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  form {
    margin-top: -20px !important;
    max-width: 500px;
    margin: 20px;
    position: relative;
  }
 

  input[type=number],  input[type=text],select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
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

  table tr td:nth-child(1),
  table tr td:nth-child(2) {
    text-align: center;
  }

  #section {
    max-height: 600px;
    overflow-y: auto;
    width: 100%;
  }

  table, th, td {
    border: solid 1px #000;
    padding: 10px;
  }

  thead {
    background: rgba(0, 0, 0, .1);
  }

  table {
    border-collapse: collapse;
    caption-side: top;
    width: 100%;
  }

  caption {
    font-size: 16px;
    font-weight: bold;
    padding-top: 5px;
  }

  @media screen and (max-width: 768px) {
    table, th, td {
      font-size: 11px;
    }

    table {
      overflow: hidden;
    }

    th, td {
      white-space: nowrap;
      text-overflow: ellipsis;
    }
   
  }
  form{
    display: flex; flex-direction:column;
  }
  .popover {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: white;
  border: 2px solid #ccc;
  border-radius: 8px;
  padding: 20px;
  display: none;
  z-index: 9999;
  box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
  width: 90%;
  max-width: 400px;
 
}

.popover-content {
  display: flex;
  flex-direction: column;
  max-width: 100%;
  
}

.popover-content label {
  margin-top: 10px;
  font-weight: bold;
}

.popover-content input {
  padding: 8px;
  margin-top: 4px;
  border-radius: 5px;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.popover-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.popover-actions button {
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.popover-actions button[type="submit"] {
  background-color: #016a70;
  color: white;
}

.popover-actions button[type="button"] {
  background-color: #ccc;
}
  .btn-add-entry {
    background-color: #016a70;
    color: #fff;
    border: none;
    padding: 5px 8px;
    font-size: 14px;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.3s ease;
  }

  .btn-add-entry:hover {
    background-color: #018c94;
  }

  .btn-add-entry:active {
            background-color:rgb(1, 122, 129);
            transform: scale(0.98);
            }
            
caption {
  font-size: 32px;
  font-weight: bold;
  padding-top: 5px;
  text-align: center;
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
  document.addEventListener('DOMContentLoaded', function () {
    const closeBtn = document.getElementById('closeModal');
    const modal = document.getElementById('successModal');

    if (closeBtn && modal) {
      closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
      });
    }
  });
</script>
<script>
  const caption = document.getElementById("editable-caption");

  // Load caption from localStorage on page load
  window.onload = () => {
    const saved = localStorage.getItem("workTableCaption");
    if (saved) caption.textContent = saved;
  };

  function saveCaption() {
    const text = caption.textContent.trim();
    localStorage.setItem("workTableCaption", text);
    alert("Caption saved locally!");
  }

  function resetCaption() {
    localStorage.removeItem("workTableCaption");
    location.reload(); // reloads to show default
  }
</script>
@endsection
