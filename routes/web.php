<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee;
use App\Http\Controllers\Admin;


Route::get('/', [Employee::class,'Login'])->name('Login-Pages');

Route::get('/Landing-Page', [Employee::class,'Landingpage'])->name('Landing-Pages');

Route::get('/Login', [Employee::class,'Login'])->name('Login-Page');
Route::post('/Login', [Employee::class, 'LoginUser'])->name('Login-User');
Route::get('/Register', [Employee::class,'Register'])->name('Register-Page');
Route::post('/Register', [Employee::class, 'registerUser'])->name('Register-User');
Route::get('/Resend', [Employee::class,'Resend_Page'])->name('Resend-Page');
Route::post('/verify/resend', [Employee::class, 'resend'])->name('verification.resend');
Route::post('/logout', [Employee::class, 'LogoutUser'])->name('logout');
Route::get('/Read', [Employee::class,'Read'])->name('Read-Page');
Route::get('/Check', [Employee::class,'Check'])->name('Check-Page');
Route::get('/Disabled', [Employee::class,'Disabled'])->name('Disabled-Page');
Route::get('/forgotpassword',  [Employee::class,'Forgot_password'])->name('Forgotpassword-Page');
Route::post('/forgotpasswordform',  [Employee::class,'Forgot_password_form'])->name('Forgotpassword-Form-Page');

Route::get('/get-salary',[Employee::class,'getSalary'])->name('getSalary-Page');


//user
Route::get('/Application-For-Leave', [Employee::class,'Leave'])->name('Application-For-Leave-page');
Route::post('/Application-For-Leave-Form', [Employee::class,'application_leave_form'])->name('Application-For-Form-page');
Route::get('/Application-History', [Employee::class,'History'])->name('History-page');

Route::get('/Profile', [Employee::class,'Profile'])->name('Profile-page');
Route::put('/Profile-update', [Employee::class,'Profile_update'])->name('profile.update');
Route::put('/profile/e-signature', [Employee::class, 'updateESignature'])->name('profile.e_signature');




//admin
Route::get('/Admin', [Admin::class,'Admin'])->name('Admin-Login-Pages');
Route::get('/Admin-Register-Page', [Admin::class,'Admin_Register_Pages'])->name('Admin-Register-Pages');
Route::post('/logout-admin', [Admin::class, 'LogoutAdmin'])->name('logout-admin');
Route::post('/Admin-Login', [Admin::class, 'Admin_Login'])->name('Admin-Login');
Route::post('/Register-Admin', [Admin::class, 'registerAdmin'])->name('Register-Admin-Post');
Route::get('/Admin-Dashboard', [Admin::class,'Admin_Dashboard'])->name('Admin-Dashboard-page');

Route::post('/change-password', [Admin::class, 'changePassword'])->name('change-password');

Route::get('/Admin-Application-Leave', [Admin::class,'Admin_Application_Leave'])->name('Admin-Application-Leave-page');

Route::get('/Admin-Employee-Account', [Admin::class,'Admin_Employee_Account'])->name('Admin-Employee-Account-page');

Route::get('/Admin-Leave-Credit-Card', [Admin::class,'Admin_Leave_Credit_Card'])->name('Admin-Leave-Credit-Card-page');
Route::post('/Admin-Leave-Credit-Card-Generate', [Admin::class,'Admin_Leave_Credit_Card_Generate'])->name('Admin-Leave-Credit-Card-Generate-page');


Route::get('/Admin-Summary', [Admin::class,'Admin_Summary'])->name('Admin-Summary-page');
Route::post('/Admin-Summary-Generate', [Admin::class,'Admin_Summary_Generate'])->name('Admin-Summary-Generate-page');
Route::get('/export-late-template/{month}/{year}', [Admin::class, 'export_late_WithTemplate'])->name('export.late.template');



Route::get('/Admin-Terminal-Leave', [Admin::class,'Admin_Terminal_Leave'])->name('Admin-Terminal-Leave-Form-page');
Route::post('/Admin-Terminal-Leave-Generate', [Admin::class,'Admin_Terminal_Leave_Generate'])->name('Admin-Terminal-Leave-Generate-page');
Route::get('/export-terminal-template/{month}/{year}', [Admin::class, 'exportWithTemplate'])->name('terminal.leave.export.template');


Route::get('/Admin-Control-Panel', [Admin::class,'Admin_Control_Panel'])->name('Admin-Control-Panel-page');

Route::get('/Admin-Salary', [Admin::class,'Salary'])->name('Admin-Salary-page');
Route::post('/Admin-Salary-Add', [Admin::class,'Salary_Add'])->name('Admin-Salary-Add-page');




Route::delete('/Admin-Salary-Delete/{id}', [Admin::class, 'Salary_Delete'])->name('Admin-Salary-Delete');
Route::put('/Admin-Salary-Update/{id}', [Admin::class, 'update'])->name('Admin-Salary-Update');

Route::get('/Admin-Input/{id}', [Admin::class, 'Input'])->name('Admin-Input-page');
Route::post('/delete-with-password', [Admin::class, 'deleteWithPassword'])->name('delete.with.password');


Route::get('/Admin-Work', [Admin::class,'Work'])->name('Admin-Work-page');
Route::post('/Admin-Work-Add', [Admin::class, 'Work_Add'])->name('Admin-Work-Add');
Route::delete('/Admin-Work-Delete/{id}', [Admin::class, 'Work_Delete'])->name('Admin-Work-Delete');
Route::put('/Admin-Work-Update/{id}', [Admin::class, 'Work_update'])->name('Admin-Work-Update');

Route::get('/Admin-Rate', [Admin::class,'Rate'])->name('Admin-Rate-page');
Route::delete('/Admin-Rate-Delete/{id}', [Admin::class, 'Rate_Delete'])->name('Admin-Rate-Delete');
Route::put('/Admin-Rate-Update/{id}', [Admin::class, 'Rate_update'])->name('Admin-Rate-Update');


Route::post('/update-status-approve/{id}', [Admin::class, 'updateStatusapprove']);

Route::post('/update-status-decline/{id}', [Admin::class, 'updateStatusdecline']);

Route::post('/update-status-activate/{id}', [Admin::class, 'updateStatusactivate']);
Route::post('/update-status-disable/{id}', [Admin::class, 'updateStatusdisable']);

Route::get('/export-users/{id}', [Admin::class, 'exportUsers'])->name('sus');
Route::get('/print_leave_credit_card/{id}/{year}', [Admin::class, 'print_leave_credit_card'])->name('print_leave_credit_card');


Route::get('/samples', [Admin::class, 'samples'])->name('samples');

Route::post('/leaves/store', [Admin::class, 'leave_store'])->name('leaves.store');
Route::post('/leaves/store/multiple', [Admin::class, 'leave_store_multiple'])->name('leaves.store.multiple');


Route::get('/form', function () {
    return view('form/layout');
});
Route::get('/It', function () {
    return view('it/form');
});


