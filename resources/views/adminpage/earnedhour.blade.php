@extends('layout.layout')

@section('title', 'Working-Table')
@section('header_title', "WORKING TABLE")
@section('content')



<div class="infobox-section">
    <h1>Conversion of Working Hours</h1>
    <p>Manage the website content with ease, allows you to easily add, update, view, and remove information.</p>
    <div class="infobox-container">
      <div class="infobox" style="background-color: #e7edff;">
        <div class="icon">💸</div>
        <h2>Salary Grade</h2>
        <p>Second Tranche Monthly Salary Schedule For Civilian Personnel of The National Government (in Pesos)</p>
        <a href="" class="learn-more">View &rsaquo;</a>
      </div>
      <div class="infobox" style="background-color: #fff1e7;">
        <div class="icon">⌛</div>
        <h2>Working Hours</h2>
        <p>Conversion of Working Hours/Minutes into Fractions of a day. This conversion is helpful in calculating time worked for payroll or project tracking.</p>
        <a href="{{ url('/Admin-Work') }}" class="learn-more">View &rsaquo;</a>
      </div>
    </div>
</div>


<style>
    body {
  line-height: 1.6;
}

.infobox-section {
  text-align: center;
  padding: 10px 20px 40px 20px;
}

.infobox-section h1 {
  font-size: 2rem;
  color: #1a1a40;
  margin-bottom: 10px;
}

.infobox-section p {
  font-size: 1rem;
  color: #6b6b82;
  margin-bottom: 30px;
}

.infobox-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  padding: 0 20px;
}

.infobox {
  border-radius: 10px;
  padding: 20px;
  text-align: left;
  transition: transform 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.infobox:hover {
  transform: translateY(-10px);
}

.infobox .icon {
  font-size: 2rem;
  margin-bottom: 15px;
}

.infobox h2 {
  font-size: 1.5rem;
  color: #1a1a40;
  margin-bottom: 10px;
}

.infobox p {
  font-size: 1rem;
  color: #6b6b82;
  margin-bottom: 20px;
}

.infobox .learn-more {
  font-size: 1rem;
  color: #3b50e0;
  text-decoration: none;
}

.infobox .learn-more:hover {
  text-decoration: underline;
}

</style>
    

    
@endsection