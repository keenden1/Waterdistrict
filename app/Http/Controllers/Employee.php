<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\FirebaseHelper;
use App\Models\Employee_Account;
use App\Models\Salary;
use App\Models\Application_leave;
use App\Mail\VerificationEmail;
use App\Models\Leave;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Carbon\Carbon;

class Employee extends Controller
{
      
function Check()
{
    $firebaseAuth = app('firebase.auth');
    
    $email = Session::get('user_email');
    if (!$email) {
        return redirect('/Login')->with('error', 'You need to log in first.');
    }
    $user = $firebaseAuth->getUserByEmail($email);
    // Check if email is verified
    if ($user->emailVerified) { 
            $check_status = Employee_Account::where('email', $email)->first();
            if ($check_status->account_status == 'approved') {
                return redirect('/Application-For-Leave');
            }   
        return view('emails.check');
    } else {
        return redirect('/Resend')->with('error', 'Please verify your email.');
    }
   

}
public function Profile_update(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:employee_account,email',
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    ]);

    $employee = Employee_Account::where('email', $request->email)->first();

    if ($employee) {
        // Delete old profile picture if it exists
        if ($employee->profile_picture && file_exists(public_path($employee->profile_picture))) {
            unlink(public_path($employee->profile_picture));
        }

        // Store the new uploaded image
        $file = $request->file('profile_picture');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('profile_photo'), $filename);

        // Update the profile picture path in the database
        $employee->profile_picture = 'profile_photo/' . $filename;
        $employee->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
    }

    return redirect()->back()->with('error', 'Employee not found.');
}

function Landingpage()
{
        $firebaseAuth = app('firebase.auth');

        
    
        $email = Session::get('user_email');

          $user = Employee_Account::where('email', $email)->first();

                if ($user && $user->role === 'admin') {
                       return redirect('/Admin-Dashboard');
                } 
        if (!$email) {
            return redirect('/Login')->with('error', 'You need to log in first.');
        }

        $check_status = Employee_Account::where('email', $email)->first();
        if ($check_status->account_status == 'pending') {
            return redirect('/Check');
        }

        // Fetch user details from Firebase
        $user = $firebaseAuth->getUserByEmail($email);
        // Check if email is verified
        if ($user->emailVerified) {
            return view('employee.homepage');
        } else {
            return redirect('/Resend')->with('error', 'Please verify your email.');
        }
}
    function Read(){
        $firebaseAuth = app('firebase.auth');
        // Get logged-in user's email from session
        $email = Session::get('user_email');
          $user = Employee_Account::where('email', $email)->first();

                if ($user && $user->role === 'admin') {
                       return redirect('/Admin-Dashboard');
                } 
        if (!$email) {
            return redirect('/Login')->with('error', 'You need to log in first.');
        }
        // Fetch user details from Firebase
        $user = $firebaseAuth->getUserByEmail($email);
        // Check if email is verified
        if ($user->emailVerified) {
            return view('employee.instruction');
        } else {
            return redirect('/Resend')->with('error', 'Please verify your email.');
        }
        
    }
    function Login(){
        $email = Session::get('user_email');
        $user = Employee_Account::where('email', $email)->first();

                if ($user && $user->role === 'admin') {
                       return redirect('/Admin-Dashboard');
                } 
        if ($email) {
            return redirect('/Landing-Page')->with('error', 'You need to log in first.');
        }
        return view('loginform.login');
    }

//login-Register-Logout
  function LoginUser(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $user = Employee_Account::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    if ($user->role === 'admin') {
        return back()->with('error', 'User Only!');
    }

    try {
        $firebaseAuth = app('firebase.auth');
        $signInResult = $firebaseAuth->signInWithEmailAndPassword($request->email, $request->password);

        // Save user session
        Session::put('user', [
            'email' => $request->email,
            'idToken' => $signInResult->idToken(),
        ]);
        Session::put('user_email', $request->email);

        // Reuse $user info (avoid querying again)
        $fullname = ucfirst($user->fname) . ' ' . ucfirst($user->lname);
        $formname = ucfirst($user->lname) . ', ' . ucfirst($user->fname) . ' ' . ucfirst($user->mname);
        $employee_id = $user->employee_id;
        $position = $user->position;

        Session::put('fullname', $fullname);
        Session::put('formname', $formname);
        Session::put('employee_id', $employee_id);
        Session::put('position', $position);

        return redirect('/Landing-Page')->with('success', 'Login Successful!');
    } catch (FailedToSignIn $e) {
        Log::error('Sign-in failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    } catch (InvalidArgumentException $e) {
        Log::error('Invalid email address: ' . $e->getMessage());
        return redirect()->back()->with('error', 'The email address provided is invalid.')->withInput();
    }
}

    function Register(){
        return view('loginform.register');
    }
    function Forgot_password(){
        return view('emails.change');
    }
    public function Forgot_password_form(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);
    
        try {
            // Get the Firebase Auth instance
            $firebaseAuth = app('firebase.auth'); // This returns the instance of the Firebase Auth service.
    
            // Check if the email exists in Firebase Auth
            try {
                $user = $firebaseAuth->getUserByEmail($request->email); // This will throw an exception if user is not found
            } catch (UserNotFound $e) {
                // If the user is not found, return with an error message
                return redirect()->back()->with('error', 'Email is not registered.');
            }
    
            // Send the password reset email using Firebase
            $firebaseAuth->sendPasswordResetLink($request->email);
    
            // Return success message
            return redirect()->back()->with('success', 'Password reset email has been sent!');
        } catch (AuthException $e) {
            // Handle Firebase authentication errors (e.g., invalid email format)
            Log::error('Password reset failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Could not send password reset email. Please check the email address and try again.');
        } catch (Exception $e) {
            // Handle other unexpected errors
            Log::error('General error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred. Please try again later.');
        }
    }
    
   


    public function LogoutUser()
{
    try {
        // Forget the user session
        Session::forget('user');
        
        // Optionally, destroy the entire session
        Session::flush();
        
        return redirect('/Login')->with('success', 'Logout Successful!');
    } catch (Exception $e) {
        Log::error('Logout failed: ' . $e->getMessage());
        return redirect('/')->with('error', 'Something went wrong while logging out.');
    }
}
public function registerUser(Request $request)
{
    // Validate user input
    $validator = Validator::make($request->all(), [
        'fname' => 'required|string',
        'mname' => 'nullable',
        'lname' => 'required',
        'employee_id' => 'required',
        'email' => 'required|email',
        'position' => 'required',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $role = $request->role ?? 'user';
        $status = $request->status;

        // Create a Firebase user
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createAuth();

        $userProperties = [
            'email' => $request->email,
            'password' => $request->password,
            'displayName' => $request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname,
        ];

        $createdUser = $firebase->createUser($userProperties);

        // Save employee details to the database
        $data['employee_id'] = $request->employee_id;
        $data['email'] = $request->email;
        $data['fname'] = $request->fname;
        $data['mname'] = $request->mname;
        $data['lname'] = $request->lname;
        $data['position'] = $request->position; 
        $data['account_status'] = "pending";
        $data['role'] = "user";
        Employee_Account::create($data);

        // Generate the email verification link manually
        $verificationLink = $firebase->getEmailVerificationLink($createdUser->email);
        $displayName = $request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname;
        // Send the verification email using Laravel's Mail system
        Mail::to($request->email)->send(new VerificationEmail($verificationLink, $displayName));

        // Save user to Firebase Database (Assuming this method works as expected)
        FirebaseHelper::saveUser($createdUser->uid, $request->name, $request->email, $role, $status);

        return redirect('/Login')->with('success', 'User Registered Successfully! A verification email has been sent.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
}
public function resend(Request $request)
{
    // Ensure that the email exists in the session or request
    $email = Session::get('user_email');
    
    if (!$email) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

    // Check if the user is attempting to resend the email within 5 minutes
    $lastResendTime = Session::get('last_resend_time');
    
    if ($lastResendTime && now()->diffInMinutes($lastResendTime) < 5) {
        $remainingTime = 5 - now()->diffInMinutes($lastResendTime);
        return redirect()->back()->with('error', "Please wait $remainingTime more minutes before resending the verification email.");
    }

    // Get employee data from the database using the email
    $data = Employee_Account::where('email', $email)->first();
    
    if ($data) {
        // Create the full display name (this is where you add the $displayName)
        $displayName = $data->fname . ' ' . ($data->mname ? $data->mname . ' ' : '') . $data->lname;

        // Initialize Firebase with the credentials
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createAuth(); // Initialize Firebase Auth correctly

        try {
            // Get the Firebase user by email
            $user = $firebase->getUserByEmail($email);

            // Send the email verification link
            $verificationLink = $firebase->getEmailVerificationLink($email);

            // Send the verification email manually using Laravel's Mail system
            // Pass the $displayName if needed in the email content (optional)
            Mail::to($email)->send(new VerificationEmail($verificationLink, $displayName));

            // Save the timestamp of the last resend in the session
            Session::put('last_resend_time', now());

            // Return a success message
            return redirect()->back()->with('resent', 'A fresh verification link has been sent to your email address.');
        } catch (\Kreait\Firebase\Exception\AuthException $e) {
            // If any error occurs, such as user not found
            return redirect()->back()->with('error', 'Failed to resend the verification email. Please try again.');
        }
    } else {
        // If email is not found in the Employee_Account model
        return redirect('/Login')->with('error', 'No email address found in our records.');
    }
}




/***********************************************************************************************************/

public function application_leave_form(Request $request)
    {
        
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'salary_grade' => 'required|integer',
            'step_grade' => 'required|integer',
            'salary' => 'required|string', 
            'fullname' => 'required|string', 
            'commutation' => 'required|string', 
            'email' => 'required|string', 
            'type' => 'required|string',
            'Others_details' => 'nullable|string|max:255',
            'detail' => 'required|string',
            'specify_details' => 'nullable|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ], [
            'startDate.required' => 'The Start Date need to Fill-up!',
            'endDate.required' => 'The End Date need to Fill-up!',
        ]);

        $start = Carbon::parse($validated['startDate']);
        $end = Carbon::parse($validated['endDate']);
        $days = $start->diffInDays($end) + 1;

        $employee = Employee_Account::where('email', $validated['email'])->first();
        $position =  $employee->position;

        Application_leave::create([
            'officer_department' => $validated['department'],
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'date_filing' => now(),
            'salary_grade' => $validated['salary_grade'],
            'step_grade' => $validated['step_grade'],
            'salary' => $validated['salary'],
            'position' => $position,

            'a_availed' => $validated['type'],
            'a_availed_others' => $validated['Others_details'] ?? null,

            'b_details' => $validated['detail'] ?? null,
            'b_details_specify' => $validated['specify_details'] ?? null,
            'status' => 'Pending',
            'd_commutation' => $validated['commutation'] ?? null,
            'c_working_days' =>  $days,
            'c_inclusive_dates' => $validated['startDate'] .'/'. $validated['endDate'],
            'start_date' => $validated['startDate'],
            'end_date' => $validated['endDate'],
        ]);

        // $email = 'vincentmahipus.bsit.ucu@gmail.com';
        // $displayName = 'sample';
        // Mail::to($email)->send(new Notification_Message($displayName));

        // Return a success message or redirect the user
        return redirect()->back()->with('success', 'Leave Application Submitted Successfully');
    }

public function getSalary(Request $request)
{
    // Dynamically create the column name based on the step_grade
    $stepColumn = 'step_' . $request->step_grade;

    // Fetch the first salary record matching the salary_grade
    $salary = Salary::where('salary_grade', $request->salary_grade)->first();

    // Check if the salary exists and if the dynamic step column exists in the record
    if ($salary && isset($salary->$stepColumn)) {
        return response()->json(['salary' => $salary->$stepColumn]);
    }

    // If no salary or step column exists, return null
    return response()->json(['salary' => null]);
}

    function Leave()
    {
        
        $firebaseAuth = app('firebase.auth');
        // Get logged-in user's email from session
        $email = Session::get('user_email');
          $user = Employee_Account::where('email', $email)->first();

                if ($user && $user->role === 'admin') {
                       return redirect('/Admin-Dashboard');
                } 
        if (!$email) {
            return redirect('/Login')->with('error', 'You need to log in first.');
        }
        // Fetch user details from Firebase
        $user = $firebaseAuth->getUserByEmail($email);
        // Check if email is verified
        if ($user->emailVerified) {
            $check_status = Employee_Account::where('email', $email)->first();
                if ($check_status->account_status == 'pending') {
                    return redirect('/Check');
                } else{
                        return view('employee.application_for_leave');
                    }
        } else {
            return redirect('/Resend')->with('error', 'Please verify your email.');
        }

    }
    function History(){
        $firebaseAuth = app('firebase.auth');
        // Get logged-in user's email from session
        $email = Session::get('user_email');
          $user = Employee_Account::where('email', $email)->first();

                if ($user && $user->role === 'admin') {
                       return redirect('/Admin-Dashboard');
                } 
        if (!$email) {
            return redirect('/Login')->with('error', 'You need to log in first.');
        }
        // Fetch user details from Firebase
        $user = $firebaseAuth->getUserByEmail($email);
        // Check if email is verified
        if ($user->emailVerified) {
            $check_status = Employee_Account::where('email', $email)->first();
                if ($check_status->account_status == 'pending') {
                    return redirect('/Check');
                } else{

                $history = Application_leave::where('email', $email)->get();
                        return view('employee.history', compact('history'));
                    }
        } else {
            return redirect('/Resend')->with('error', 'Please verify your email.');
        }
    
    }
    function Profile(){
        $firebaseAuth = app('firebase.auth');
        // Get logged-in user's email from session
        $email = Session::get('user_email');
        $user = Employee_Account::where('email', $email)->first();

                if ($user && $user->role === 'admin') {
                       return redirect('/Admin-Dashboard');
                } 
        if (!$email) {
            return redirect('Login')->with('error', 'You need to log in first.');
        }
        // Fetch user details from Firebase
        $user = $firebaseAuth->getUserByEmail($email);
        // Check if email is verified
        if ($user->emailVerified) {
            $check_status = Employee_Account::where('email', $email)->first();
                if ($check_status->account_status == 'pending') {
                    return redirect('/Check');
                } else{
                    $employee = Employee_Account::where('email', $email)->first();
                    $balance  = Leave::where('employee_id', $employee->employee_id)
                    ->latest() // equivalent to orderBy('created_at', 'desc')
                    ->first();


                        return view('employee.profile',compact('employee','balance'));
                    }
        } else {
            return redirect('/Resend')->with('error', 'Please verify your email.');
        }
    }
    function Resend_Page(){
        $firebaseAuth = app('firebase.auth');
        $email = Session::get('user_email');
        if (!$email) {
            return redirect('Login')->with('error', 'You need to log in first.');
        }
        $user = $firebaseAuth->getUserByEmail($email);
        if ($user->emailVerified) {
            return redirect('/Landing-Page');
        }
        return view('emails.resend');
    }

    
}
