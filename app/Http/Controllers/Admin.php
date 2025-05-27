<?php

namespace App\Http\Controllers;

use App\Models\Application_leave;
use App\Models\Leave;
use App\Models\Employee_Account;
use App\Models\Employee_attendance;
use App\Models\Salary;
use App\Models\Employee_salary;
use App\Models\Working_hour;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use App\Helpers\FirebaseHelper;
use App\Models\Daily_earned;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Hash;

class Admin extends Controller
{

  public function samples()
{
    $leaves = Leave::all();
    return view('sample', compact('leaves'));
}

public function Input($id) {
     
    $employee = Leave::where('employee_id', $id)->get();

    $Account = Employee_Account::where('employee_id', $id)->first();

    $employee_id_new = $id;

    $name = ucfirst($Account->fname) . ' ' . ucfirst($Account->lname);

    return view('adminpage.admin_data', compact('employee','name','employee_id_new'));
}

public function deleteWithPassword(Request $request)
{
    $request->validate([
        'item_id' => 'required|exists:leaves,id',
    ]);

    Leave::findOrFail($request->item_id)->delete();

    return response()->json(['success' => true]);
}


public function leave_store(Request $request)
{
    $check = $request->validate([
        'employee_id' => 'nullable|string',
        'monthly_salary' => 'required|string',
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2000',
        'date' => 'nullable|string',

        'vl' => 'nullable|numeric',
        'sl' => 'nullable|numeric',
        'fl' => 'nullable|numeric',
        'spl' => 'nullable|numeric',
        'other' => 'nullable|numeric',

        'day_A_T'=> 'nullable|numeric',
        'hour_A_T'=> 'nullable|numeric',
        'minutes_A_T'=> 'nullable|numeric',
        'times_A_T'=> 'nullable|numeric',

        'day_Under'=> 'nullable|numeric',
        'hour_Under'=> 'nullable|numeric',
        'minutes_Under'=> 'nullable|numeric',
        'times_Under'=> 'nullable|numeric',

        'vl_earned' => 'nullable|numeric',
        'vl_absences_withpay' => 'nullable|numeric',
        'vl_absences_withoutpay' => 'nullable|numeric',

        'sl_earned' => 'nullable|numeric',
        'sl_absences_withpay' => 'nullable|numeric',
        'sl_absences_withoutpay' => 'nullable|numeric',
        ], [
        'monthly_salary.required' => 'Please enter the monthly salary.',
        'month.required' => 'Please select a month.',
        'month.integer' => 'Month must be a valid number.',
        'month.min' => 'Month must be between 1 and 12.',
        'month.max' => 'Month must be between 1 and 12.',
        'year.required' => 'Please enter the year.',
        'year.integer' => 'Year must be a valid number.',
        'year.min' => 'Year must be after 1999.',
    ]);
    $day_A_T = $request->input('day_A_T', 0);
    $hour_A_T = $request->input('hour_A_T', 0);
    $minutes_A_T = $request->input('minutes_A_T', 0);

    $day_Under = $request->input('day_Under', 0);
    $hour_Under = $request->input('hour_Under', 0);
    $minutes_Under = $request->input('minutes_Under', 0);

    
    $Vl_totalMinutes = ($day_A_T * 480) + ($hour_A_T * 60) + $minutes_A_T;
    $SL_totalMinutes = ($day_Under * 480) + ($hour_Under * 60) + $minutes_Under;
    
// Function to get total equivalent day for total minutes, split in chunks max 60 mins each
        function getEquivalentDayFromMinutes($totalMinutes) {
            $totalEquivalentDay = 0;
            while ($totalMinutes > 0) {
                $chunk = min(60, $totalMinutes);
                $equivalent = DB::table('working_hour')->where('minutes', $chunk)->value('equivalent_day');

                // fallback if not found in DB
                if (!$equivalent) {
                    // assume linear fallback: 1 day = 480 mins
                    $equivalent = $chunk / 480;
                }

                $totalEquivalentDay += floatval($equivalent);
                $totalMinutes -= $chunk;
            }
            return $totalEquivalentDay;
        }

        $totalminVl = getEquivalentDayFromMinutes($Vl_totalMinutes);
        $totalminSl = getEquivalentDayFromMinutes($SL_totalMinutes);


    

    $vl_values = $totalminVl; 
    $sl_values = $totalminSl;
  
    $vl_earned_data =  floatval($request->vl_earned) - $vl_values;
    $sl_earned_data = floatval($request->sl_earned) - $sl_values;

    $existing = Leave::where('month', $request->month)
                    ->where('employee_id', $request->employee_id)
                    ->where('year', $request->year)
                    ->first();

    if ($existing) {
        return redirect()->back()->withErrors(['duplicate' => 'A leave record for this month and year already exists.']);
    }

    $prevMonth = $request->month - 1;
    $prevYear = $request->year;

    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear -= 1;
    }

        $previousLeave = Leave::where('month', $prevMonth)
                          ->where('year', $prevYear)
                          ->first();
        
        $currentvl = $request->vl  ?? 0;
        $currentsl = $request->sl  ?? 0;
        $vl_earned = $vl_earned_data - $currentvl ?? 0;
        $sl_earned = $sl_earned_data - $currentsl ?? 0;
       
        $prev_vl_balance = $previousLeave?->vl_balance ?? 0;
        $prev_sl_balance = $previousLeave?->sl_balance ?? 0;

        $checkvl = $prev_vl_balance - $currentvl;
        $checksl = $prev_sl_balance - $currentsl;

         $leaveCount = Leave::where('employee_id', $request->employee_id)->count();
        if ($leaveCount >= 5) {
            if($checkvl  <= 5){
               
                 return back()->withErrors([
                    'Balance' => "VL exceeds available balance. You must keep at least 5.000 ."
                ])->withInput();
            }
            if($checksl <= 5){
                 return back()->withErrors([
                    'Balance' => "SL exceeds available balance. You must keep at least 5.000 ."
                ])->withInput();
            }

        }

        $vl_balance = $vl_earned + $prev_vl_balance;
        $sl_balance = $sl_earned + $prev_sl_balance;
        $total_leave_earned = $vl_balance + $sl_balance;

        

       $data = $request->only([
        'employee_id',
        'month','year','date',
        'vl','sl','fl','spl','other',
        
        'day_A_T', 'hour_A_T','minutes_A_T','times_A_T',
        'day_Under', 'hour_Under','minutes_Under','times_Under',
         ]);


        $data['vl_earned'] = $vl_earned_data;
        $data['sl_earned'] = $sl_earned_data;
        $data['vl_balance'] = $vl_balance;
        $data['sl_balance'] = $sl_balance;
        $data['total_leave_earned'] = $total_leave_earned;
        

    Leave::create($data);

    return redirect()->back()->with('success', 'Leave record added successfully.');
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



    public function xl()
    {
        $employees = [
            [
                'name' => 'Alice Smith',
                'salary' => 30000,
                'vl' => 2,
                'sl' => 1,
            ],
            [
                'name' => 'John Doe',
                'salary' => 35000,
                'vl' => 3,
                'sl' => 2,
            ],
        ];
    
        // Monthly values for column K
        $monthsData = [
            'jan' => 123123,
            'feb' => 123123,
            'mar' => 123123,
            'apr' => 123123,
            'may' => 123123,
            'june' => 123123,
            'july' => 123123,
            'aug' => 123123,
            'sep' => 123123,
            'oct' => 123123,
            'nov' => 123123,
            'dec' => 123123,
        ];
        $lastmonthdec = 123123;

    
        $templatePath = public_path('template/leavecreditcard.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
    
        $startRow = 17;
        $constantFactor = 0.0481927;
        $totalBenefit = 0;
    
        foreach ($employees as $i => $employee) {
            $row = $startRow + $i;
    
            $sheet->setCellValue("A$row", $i + 1);
            $sheet->setCellValue("B$row", $employee['name']);
            $sheet->setCellValue("C$row", $employee['salary']);
            $sheet->setCellValue("D$row", $employee['vl']);
            $sheet->setCellValue("E$row", $employee['sl']);
    
            $totalLeave = $employee['vl'] + $employee['sl'];
            $sheet->setCellValue("F$row", $totalLeave);
            $sheet->setCellValue("G$row", $constantFactor);
    
            $benefit = $employee['salary'] * $totalLeave * $constantFactor;
            $totalBenefit += $benefit;
    
            $sheet->setCellValue("H$row",  number_format($benefit, 2));
        }

         $sheet->setCellValue("K16", $lastmonthdec);
        // Set K17-K28 with monthly data
        $monthRows = [
            'jan' => 17, 'feb' => 18, 'mar' => 19, 'apr' => 20,
            'may' => 21, 'june' => 22, 'july' => 23, 'aug' => 24,
            'sep' => 25, 'oct' => 26, 'nov' => 27, 'dec' => 28,
        ];
    
        foreach ($monthsData as $key => $value) {
            $row = $monthRows[$key];
            $sheet->setCellValue("K$row", $value);
        }
    
        // -- TOTAL LEAVE BENEFIT PAYABLE TO DATE --
        $sheet->setCellValue("H24", number_format($totalBenefit, 2));
    
        // -- CURRENT MONTH: APRIL --
        $currentMonth = 'apr';
        $currentMonthRow = $monthRows[$currentMonth] ?? 20;
    
        // -- NEXT MONTH (MAY) for Balance Previous --
        $nextMonthKey = array_search($currentMonth, array_keys($monthRows)) + 1;
        $nextMonthRow = $nextMonthKey ? array_values($monthRows)[$nextMonthKey] : 21;
    
        $balancePreviousMonth = $sheet->getCell("K$nextMonthRow")->getValue();
        $sheet->setCellValue("H25", number_format($balancePreviousMonth, 2));
    
        // -- TOTAL PAYABLE CURRENT MONTH (H26) --
        $totalPayableCurrentMonth = $totalBenefit - $balancePreviousMonth;
        $sheet->setCellValue("H26", number_format($totalPayableCurrentMonth, 2));
    
        // Save to temp file
        $excelname = 'Leave_Benefits_' . now()->format('Ymd_His') . '.xlsx';
        $newFilePath = public_path('template/sample.xlsx');
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
    
        return response()->download($newFilePath, $excelname)->deleteFileAfterSend(true);
        }
   

    public function exportUsers($id)
    {
        $application = Application_leave::find($id);
        $leave1 = ($application->a_availed == 'Vacation Leave') ? '✔' : '';
        $leave2 = ($application->a_availed == 'Mandatory/Forced Leave') ?  '✔' : '';
        $leave3 = ($application->a_availed == 'Sick Leave') ? '✔' : '';
        $leave4 = ($application->a_availed == 'Maternity Leave') ? '✔' : '';
        $leave5 = ($application->a_availed == 'Paternity Leave') ? '✔' : '';
        $leave6 = ($application->a_availed == 'Special Privilage Leave') ? '✔' : '';
        $leave7 = ($application->a_availed == 'Solo Parent Leave') ? '✔' : '';
        $leave8 = ($application->a_availed == 'Study Leave') ? '✔' : '';
        $leave9 = ($application->a_availed == '10-Day VAWC Leave') ? '✔' : '';
        $leave10 = ($application->a_availed == 'Rehabilitation Leave') ? '✔' : '';
        $leave11 = ($application->a_availed == 'Special Leave Benifits for Woman') ? '✔' : '';
        $leave12 = ($application->a_availed == 'Special Emergency') ? '✔' : '';
        $leave13 = ($application->a_availed == 'Adoption Leave') ? '✔' : '';
        $others =  ($application->a_availed == 'Others:') ? $application->a_availed_others : '';
        
        $ph = ($application->b_details == 'Within Philippines') ? '✔' : '';
        $ph_details = ($application->b_details == 'Within Philippines') ? $application->b_details_specify : '';

        $us = ($application->b_details == 'Abroad') ? '✔' : '';
        $us_details = ($application->b_details == 'Abroad') ? $application->b_details_specify : '';

        $hospital = ($application->b_details == ' In Hospital(Specify Illness)') ? '✔' : '';
        $hospital_details = ($application->b_details == 'In Hospital(Specify Illness)') ? $application->b_details_specify : '';
       
        $outpatient = ($application->b_details == 'Out Patient') ? '✔' : '';
        $outpatient_details = ($application->b_details == 'Out Patient') ? $application->b_details_specify : '';
       

        $woman_details = ($application->b_details == 'Special Benifits for Women(Specify Illness)') ? $application->b_details_specify : '';
        
        $degree = ($application->b_details == 'Completion of Masters Degree') ? '✔' : '';
        $bar = ($application->b_details == 'BAR/BOARD Examination Review') ? '✔' : '';

        $monetization = ($application->b_details == 'Monetization of Leave Credits') ? '✔' : '';
        $terminal = ($application->b_details == 'Terminal Leave') ? '✔' : '';
        
        $not = ($application->d_commutation == 'Not Requested') ? '✔' : '';
        $requested = ($application->d_commutation == 'Requested') ? '✔' : '';
       
        
        
        $templatePath = public_path('template/example.xlsx');
        $newFilePath = public_path('template/sample.xlsx');

        $account = Employee_Account::where('email', $application->email)->first();
        $fullname = ucfirst(strtolower($account->lname)) . ', ' . ucfirst(strtolower($account->fname));

        if (!empty($account->mname)) {
            $fullname .= ' ' . strtoupper(substr($account->mname, 0, 1)) . '.';
        }
        

        copy($templatePath, $newFilePath);
    
        // Step 2: Open the Excel file (as a zip)
        $zip = new ZipArchive;
        if ($zip->open($newFilePath) === true) {
    
            // Step 3: Read and modify sharedStrings.xml
            $sharedStrings = $zip->getFromName('xl/sharedStrings.xml');
    
            if ($sharedStrings !== false) {
                $sharedStrings = str_replace('{{OFFICER_DEPARTMENT}}', $application->officer_department, $sharedStrings);
                $sharedStrings = str_replace('{{FULLNAME}}', $fullname, $sharedStrings);
                $sharedStrings = str_replace('{{EMAIL}}',  $application->email, $sharedStrings);
                $sharedStrings = str_replace('{{SALARY}}',  'SG'.$application-> salary_grade.'-'. $application->step_grade , $sharedStrings);
                $sharedStrings = str_replace('{{POSITION}}',  $application->position , $sharedStrings);
                $sharedStrings = str_replace('{{DATE_FILING}}',  $application->date_filing , $sharedStrings);
                $sharedStrings = str_replace('{{leave1}}', $leave1, $sharedStrings);
                $sharedStrings = str_replace('{{leave2}}', $leave2, $sharedStrings);
                $sharedStrings = str_replace('{{leave3}}', $leave3, $sharedStrings);
                $sharedStrings = str_replace('{{leave4}}', $leave4, $sharedStrings);
                $sharedStrings = str_replace('{{leave5}}', $leave5, $sharedStrings);
                $sharedStrings = str_replace('{{leave6}}', $leave6, $sharedStrings);
                $sharedStrings = str_replace('{{leave7}}', $leave7, $sharedStrings);
                $sharedStrings = str_replace('{{leave8}}', $leave8, $sharedStrings);
                $sharedStrings = str_replace('{{leave9}}', $leave9, $sharedStrings);
                $sharedStrings = str_replace('{{leave10}}', $leave10, $sharedStrings);
                $sharedStrings = str_replace('{{leave11}}', $leave11, $sharedStrings);
                $sharedStrings = str_replace('{{leave12}}', $leave12, $sharedStrings);
                $sharedStrings = str_replace('{{leave13}}', $leave13, $sharedStrings);
                $sharedStrings = str_replace('{{OTHERS}}',   $others , $sharedStrings);
                $sharedStrings = str_replace('{{WORKINGDAYS}}',  $application->c_working_days .' Day/s' , $sharedStrings);
                $sharedStrings = str_replace('{{INCLUSIVEDAYS}}',  $application->c_inclusive_dates , $sharedStrings);

                $sharedStrings = str_replace('{{PH}}', $ph, $sharedStrings);
                $sharedStrings = str_replace('{{PH_DETAIL}}',   $ph_details , $sharedStrings);
                $sharedStrings = str_replace('{{US}}', $us , $sharedStrings);
                $sharedStrings = str_replace('{{US_DETAIL}}',   $us_details  , $sharedStrings);
                $sharedStrings = str_replace('{{HOSPITAL}}', $hospital , $sharedStrings);
                $sharedStrings = str_replace('{{HOSPITAL_DETAIL}}',   $hospital_details  , $sharedStrings);
                $sharedStrings = str_replace('{{OUTPATIENT}}', $outpatient , $sharedStrings);
                $sharedStrings = str_replace('{{OUTPATIENT_DETAIL}}',   $outpatient_details  , $sharedStrings);
          
                $sharedStrings = str_replace('{{WOMAN_DETAIL}}',   $woman_details  , $sharedStrings);
                $sharedStrings = str_replace('{{DEGREE}}', $degree , $sharedStrings);
                $sharedStrings = str_replace('{{BAR}}',   $bar  , $sharedStrings);

                $sharedStrings = str_replace('{{MONETIZATION}}', $monetization , $sharedStrings);
                $sharedStrings = str_replace('{{TERMINAL}}',   $terminal  , $sharedStrings);
                $sharedStrings = str_replace('{{NOT}}', $not , $sharedStrings);
                $sharedStrings = str_replace('{{REQUESTED}}',   $requested  , $sharedStrings);
                
                $sharedStrings = str_replace('{{REASON}}',   $application->reason  , $sharedStrings);
                // Step 4: Save back the modified sharedStrings
                $zip->addFromString('xl/sharedStrings.xml', $sharedStrings);
            }
    
            // Step 5: Close the zip
            $zip->close();
            $excelname = 'Save_' . now()->format('Ymd_His') . '.xlsx';
            $newFilePaths = public_path('savefile/' . $excelname . '.xlsx');
           
            return response()->download($newFilePath, $excelname)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to open template'], 500);
        }
    }
    

    public function updateStatusapprove(Request $request, $id)
        {
            $application = Application_leave::findOrFail($id);
            $application->status = $request->status;
            $application->save();

            return response()->json(['success' => true]);
        }
        public function updateStatusactivate(Request $request, $id)
        {
            $application = Employee_Account::findOrFail($id);
            $application->account_status = $request->status;
            $application->save();

            return response()->json(['success' => true]);
        }
    public function updateStatusdecline(Request $request, $id)
        {
            $application = Application_leave::findOrFail($id);
            $application->status = $request->status;
            $application->reason = $request->reason;
            $application->save();
        
            return response()->json(['success' => true]);
        }
        public function updateStatusdisable(Request $request, $id)
        {
            $application = Employee_Account::findOrFail($id);
            $application->account_status = $request->status;
            $application->save();

            return response()->json(['success' => true]);
        }
        

        function Admin(){
           $count = Employee_Account::where('role', 'admin')->count();
        return view('adminlogin.admin_login', compact('count'));
    }

    //   $user = Employee_Account::where('email', $email)->first();

    //             if ($user && $user->role === 'admin') {
    //                    return redirect('/Admin-Dashboard');
    //             } 
   function Admin_Login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $user = Employee_Account::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    if ($user->role === 'user') {
        return back()->with('error', 'Admin Only!');
    }

    try {
        $firebaseAuth = app('firebase.auth');
        $signInResult = $firebaseAuth->signInWithEmailAndPassword($request->email, $request->password);
        
        Session::put('user', [
            'email' => $request->email,
            'idToken' => $signInResult->idToken(),
        ]);
        Session::put('user_email', $request->email);

        // Use already-loaded $user instead of re-querying
        $fullname = ucfirst($user->fname) . ' ' . ucfirst($user->lname);
        $formname = ucfirst($user->lname) . ', ' . ucfirst($user->fname) . ' ' . ucfirst($user->mname);

        Session::put('fullname', $fullname);
        Session::put('formname', $formname);
        Session::put('employee_id', $user->employee_id);
        Session::put('position', $user->position);

        return redirect('/Admin-Dashboard')->with('success', 'Login Successful!');
    } catch (FailedToSignIn $e) {
        Log::error('Sign-in failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Invalid email or password.')->withInput();
    } catch (InvalidArgumentException $e) {
        Log::error('Invalid email address: ' . $e->getMessage());
        return redirect()->back()->with('error', 'The email address provided is invalid.')->withInput();
    }
}

  
    function Admin_Register_Pages(){
    $count = Employee_Account::where('role', 'admin')->count();
    if ($count == 1) {
        return redirect('/Admin');  // Redirect if admin exists
    }
     return view('adminlogin.admin_register');
    }

    function registerAdmin(Request $request){

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
        $data['account_status'] = "Approved";
        $data['role'] = "admin";
        Employee_Account::create($data);

        // $verificationLink = $firebase->getEmailVerificationLink($createdUser->email);
        // $displayName = $request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname;
   
        // Mail::to($request->email)->send(new VerificationEmail($verificationLink, $displayName));

   
        FirebaseHelper::saveUser($createdUser->uid, $request->name, $request->email, $role, $status);

        return redirect('/Admin')->with('success', 'Admin Registered Successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
    }
    
    public function LogoutAdmin()
{
    try {
        // Forget the user session
        Session::forget('user');
        
        // Optionally, destroy the entire session
        Session::flush();
        
        return redirect('/Admin')->with('success', 'Logout Successful!');
    } catch (Exception $e) {
        Log::error('Logout failed: ' . $e->getMessage());
        return redirect('/')->with('error', 'Something went wrong while logging out.');
    }
}
    function Admin_Dashboard(){
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
        $countleave = Application_leave::count();
        $countemployee  = Employee_Account::where('role', 'user')->count();
        $leave = Application_leave::where('status', 'Pending')->get();
        return view('adminpage.newimprovedashboard', compact('leave','countleave','countemployee'));
    }
    function Admin_Application_Leave(){
        $leave = Application_leave::orderBy('created_at', 'asc')->get();
        return view('adminpage.applicationleave', compact('leave'));
    }
  function Admin_Employee_Account() {
    $employees = Employee_Account::where('role', 'user')->get();
    return view('adminpage.employeeaccount', compact('employees'));
}

    function Admin_Leave_Credit_Card(){
        $employees = Employee_Account::where('account_status', '!=', 'pending')->get();
        return view('adminpage.formleavecredit', compact('employees'));
    }
    function Admin_Leave_Credit_Card_Generate(Request $request){
        $request->validate([
            'employee' => 'required',
            'year' => 'required|numeric',
        ]);
        $email = $request->employee;
        $year = $request->year;
        $employee = Employee_Account::where('email', $email)->first();
      
        return view('adminpage.leave_credit_card');
    }
    public function saAdmin_Leave_Credit_Card_Generate(Request $request)
    {
        $request->validate([
            'employee' => 'required',
            'year' => 'required|numeric',
        ]);
    
        $email = $request->employee;
        $year = $request->year;
    
        $employee = Employee_Account::where('email', $email)->first();
    
        if (!$employee) {
            return back()->with('error', 'Employee not found.');
        }
    
        $vl_balance = 0;
        $sl_balance = 0;
        $monthly_data = [];
    
        for ($month = 1; $month <= 12; $month++) {
            // Earned this month
            $vl_earned = 1.25;
            $sl_earned = 1.25;
    
            // Get leave taken this month
            $leaves_taken = DB::table('leaves')
                ->where('employee_id', $employee->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->select('leave_type', DB::raw('SUM(days_used) as total_used'))
                ->groupBy('leave_type')
                ->pluck('total_used', 'leave_type')
                ->toArray();
    
            $vl_used = $leaves_taken['VL'] ?? 0;
            $sl_used = $leaves_taken['SL'] ?? 0;
    
            // Compute balances
            $vl_balance += ($vl_earned - $vl_used);
            $sl_balance += ($sl_earned - $sl_used);
    
            $monthly_data[] = [
                'month' => date('F', mktime(0, 0, 0, $month, 10)),
                'vl_earned' => $vl_earned,
                'vl_used' => $vl_used,
                'vl_balance' => round($vl_balance, 3),
                'sl_earned' => $sl_earned,
                'sl_used' => $sl_used,
                'sl_balance' => round($sl_balance, 3),
                'total_earned' => round(($month * ($vl_earned + $sl_earned)), 3),
            ];
        }
    
        return view('adminpage.leave_credit_card', [
            'employee' => $employee,
            'year' => $year,
            'monthly_data' => $monthly_data,
        ]);
    }
    


    function Admin_Summary(){
        return view('adminpage.formsummary');
    }
    public function Admin_Summary_Generate(Request $request){

        $request->validate([
            'month' => 'required|integer',
            'year' => 'required|numeric',
        ]);
    
        return view('adminpage.summary');
    }

 
   

    public function Admin_Employee_salary(){
        // Fetch and group the data by 'year'
        $data = Employee_salary::orderBy('year', 'desc')
            ->get()
            ->groupBy('year'); // No need for 'compact' here
    
        // Return the view with the 'data' variable
        return view('adminpage.employee_salary', compact('data'));
    }
    public function update(Request $request)
{
    $request->validate([
        'salary_grade' => 'required|integer',
        'step_1' => 'nullable|numeric',
        'step_2' => 'nullable|numeric',
        'step_3' => 'nullable|numeric',
        'step_4' => 'nullable|numeric',
        'step_5' => 'nullable|numeric',
        'step_6' => 'nullable|numeric',
        'step_7' => 'nullable|numeric',
        'step_8' => 'nullable|numeric',
    ]);

    $salary = Salary::findOrFail($request->id);
    $salary->update($request->only([
        'salary_grade', 'step_1', 'step_2', 'step_3',
        'step_4', 'step_5', 'step_6', 'step_7', 'step_8',
    ]));

    return redirect()->back()->with('success', 'Salary updated successfully!');
}



    
    function Admin_Terminal_Leave(){
        return view('adminpage.formterminal');
    }
    public function Admin_Terminal_Leave_Generate(Request $request)
    {
        $month = $request->input('month'); // This is a number, e.g., 1 for January, 12 for December
        $year = $request->input('year');   // e.g., "2025"
        
        // Ensure you're passing the numeric month to the date format (e.g., 1 for January)
        $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT); // Ensure two-digit format (e.g., 01, 12)
        
        // Get the last day of the month using the provided year and month
        $date = date('d F Y', strtotime("$year-$monthNumber-01 +1 month -1 day"));
     
        
        // Proceed with your leave query
        $leave = Leave::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
        
        return view('adminpage.terminal', compact('leave', 'date'));
    }
    



    function Admin_Control_Panel(){
        return view('adminpage.control_panel');
    }
    function Salary(){
    $salary = Salary::orderBy('salary_grade', 'asc')->get();
    return view('adminpage.table_salary', compact('salary'));
    }

    public function Salary_Add(Request $request)
{
    $request->validate([
        'salary_grade' => 'required|integer',
        'step_1' => 'nullable|numeric',
        'step_2' => 'nullable|numeric',
        'step_3' => 'nullable|numeric',
        'step_4' => 'nullable|numeric',
        'step_5' => 'nullable|numeric',
        'step_6' => 'nullable|numeric',
        'step_7' => 'nullable|numeric',
        'step_8' => 'nullable|numeric',
    ]);

    // Save data to database (Example)
    Salary::create($request->all());

    return redirect()->back()->with('success', 'Salary added successfully.');
}
public function Salary_Delete($id)
{
    $salary = Salary::find($id);

    if (!$salary) {
        return redirect()->back()->with('error', 'Salary not found.');
    }

    $salary->delete();

    return redirect()->back()->with('success', 'Salary deleted successfully.');
}
public function Salary_Update(Request $request, $id)
{
    $request->validate([
        'salary_grade' => 'required|numeric',
        'step_1' => 'required|numeric',
        'step_2' => 'nullable|numeric',
        'step_3' => 'nullable|numeric',
        'step_4' => 'nullable|numeric',
        'step_5' => 'nullable|numeric',
        'step_6' => 'nullable|numeric',
        'step_7' => 'nullable|numeric',
        'step_8' => 'nullable|numeric',
    ]);

    Salary::where('id', $id)->update($request->except(['_token', '_method']));

    return redirect()->route('Admin-Salary-Add-page')->with('success', 'Salary updated successfully.');
}

function Work(){
    $work = Working_hour::orderBy('minutes', 'asc')->get();
    return view('adminpage.table_work', compact('work'));
    }

public function Work_Add(Request $request)
{
    $request->validate([
        'minutes' => 'required|numeric|min:0',
        'equivalent_day' => 'required|string|max:255',
    ]);
    
    if($request -> minutes >= 61){
        return redirect()->back()->with('error', 'Exceeded minutes.');
    }

    // Create a new record in the working_hours table
    $test = Working_hour::create([
        'minutes' => $request->minutes,
        'equivalent_day' => $request->equivalent_day,
    ]);
  dd($test);
    return redirect()->back()->with('success', 'Updated successfully!');
}


    public function Work_Delete($id)
{
    $work = Working_hour::find($id);

    if (!$work) {
        return redirect()->back()->with('error', 'Salary not found.');
    }

    $work->delete();

    return redirect()->back()->with('success', 'Salary deleted successfully.');
}



public function Work_update(Request $request, $id)
{
    $salary = Working_hour::findOrFail($id);
    $salary->minutes = $request->minutes;
    $salary->equivalent_day = $request->equivalent_day;
    $salary->save();

    return redirect()->back()->with('success', 'Updated successfully!');
}

function Rate(){
    $work = Daily_earned::orderBy('days', 'asc')->get();
    return view('adminpage.earnedhour', compact('work'));
    }
}