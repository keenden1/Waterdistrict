@extends('layout.layout')

@section('title', 'Terminal-Leave-Form')
@section('header_title', "TERMINAL LEAVE")
@section('content')
<div id="section">
  <div class="image-side">
  
  <img src="{{ asset('logo/logo.png') }}" alt="Villasis Water District" class="image-side-img">
  <h2>TERMINAL LEAVE FORM</h2>
  </div>
  <div class="container" id="container">
    <form action="{{ route('Admin-Terminal-Leave-Generate-page') }}" method="POST">
      @csrf
      <div class="step step-1 active">
      <div class="form-group">
      <label for="month">Select Month</label>
        <select id="month" name="month" required>
            <option value="" disabled selected>Select..</option>
            <?php
                for ($i = 1; $i <= 12; $i++) {
                    $monthName = date('F', mktime(0, 0, 0, $i, 1)); 
                    echo "<option value=\"$i\">$monthName</option>\n";
                }
            ?>
        </select>
        </div>
        <div class="form-group">
      <label for="year">Select Year</label>
          <select id="year" name="year" required>
            <option value="" disabled selected>Select..</option>
            <?php
                $currentYear = date('Y'); // Get the current year
                for ($i = 2000; $i <= $currentYear; $i++) {
                    echo "<option value=\"$i\">$i</option>\n";
                }
            ?>
          </select>
        </div>
        <div class="center_button">
        <button class="submit-btn">Generate</button>
        </div>
      </div>


      </div>

    </form>
  </div>
</div>
</div>
<style>
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
    .center_button{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #section {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 500px;
}
section{
  display: flex;
  align-items: center;
  justify-content: center;

}
.container {
  width: 100%;
  padding: 20px;
  box-shadow: 0px 0px 20px #00000020;
  border-radius: 8px;
  background-color: white;
}
.step {
  display: none;
}
.step.active {
  display: block;
}
.form-group {
  width: 100%;
  margin-top: 20px;
}
.form-group input {
  width: 100%;
  border: 1.5px solid rgba(128, 128, 128, 0.418);
  padding: 5px;
  font-size: 18px;
  margin-top: 5px;
  border-radius: 4px;
}


.submit-btn {
  float: left;
  margin-top: 20px;
  padding: 10px 30px;
  border: none;
  outline: none;
  background-color: #016a70;
  font-family: "Montserrat";
  font-size: 18px;
  cursor: pointer;
  color:white;
  transition: background-color 0.3s ease, transform 0.2s ease;
}
.submit-btn:hover {
  /* background-color: rgb(151, 231, 255); */
  transform: scale(1.05); /* Slight zoom effect */
    background-color: #018c94;
}
.submit-btn:active {
            background-color:rgb(1, 122, 129);
            transform: scale(0.98);
            }
.image-side-img {
        width: 30%;
        max-width: 95px; 
}
.image-side{
    margin-top: 60px;
  display: flex;
  justify-content: space-evenly;
  width: 100%;
}
/* Styling the select dropdown */
.form-group select {
  width: 100%;
  border: 1.5px solid rgba(128, 128, 128, 0.418);
  padding: 5px;
  font-size: 18px;
  margin-top: 5px;
  border-radius: 4px;
  background-color: white;
  cursor: pointer;
  padding-right: 10px;
}

.form-group select:focus {
  border-color: #007bff;  /* Highlight border on focus */
}

.form-group select option {
  font-size: 16px;
  padding: 5px;
}
/* Style the error messages */
.error-message {
  color: red;
  font-size: 14px;
  margin-top: 5px;
}

/* Highlight input fields with errors */
.error {
  border-color: red;
}

/* Optional: Style the 'next' and 'previous' buttons when an error occurs */
button.next-btn:disabled {
  background-color: #ddd;
  cursor: not-allowed;
}
h2{
  font-weight: 800;
}
  @media (max-width: 850px) {
    .header{
    font-size: 15px;
  }
  .container{
    margin: 20px;
  }
  .image-side{
    margin-top: 20px;
}
}
</style>


@endsection