@extends('layout.layout')

@section('title', 'Application-For-Leave')
@section('header_title', "VILLASIS WATER DISTRICT")
@section('content')

<style>
    .edit-form-container {
        max-width: 500px;
        margin: 30px auto;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .edit-form-container h2 {
        text-align: center;
        margin-bottom: 25px;
 
    }

    .edit-form-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .edit-form-container input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    .edit-form-container button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .edit-form-container button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

<div class="edit-form-container">
    <h2>Edit Employee Details</h2>

    <form action="{{ route('employee.update', $id) }}" method="POST">
        @csrf
        @method('PUT')
         <input type="hidden" name="id" value="{{ $id }}">
        <label for="employee_id">Employee ID:</label>
        <input type="text" name="employee_id" value="{{ $employeeId }}">

        <label for="position">Position:</label>
        <input type="text" name="position" value="{{ $position }}">

        <label for="monthly_salary">Monthly Salary:</label>
        <input type="text" name="monthly_salary" value="{{ $monthlySalary }}">

        <button type="submit">Update</button>
    </form>
</div>

@endsection
