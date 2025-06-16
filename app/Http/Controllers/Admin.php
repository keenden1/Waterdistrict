<?php

namespace App\Http\Controllers;

use App\Models\Application_leave;
use App\Models\Leave;
use App\Models\Employee_Account;
use App\Models\Employee_attendance;
use App\Models\TerminalLeaveRecord;
use App\Models\Salary;
use App\Models\Employee_salary;
use App\Models\Working_hour;
use Illuminate\Http\Request;
use ZipArchive;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\RichText\Run;
use DateTime;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\Auth\UserNotFound;

class Admin extends Controller
{
   
  public function samples()
{
    $leaves = Leave::all();
    return view('sample', compact('leaves'));
}

public function Input($id) {
     
    $employee = Leave::where('employee_id', $id)
       ->orderBy('year', 'desc')
       ->orderByRaw('CAST(month AS UNSIGNED) ASC')
       ->get();

    $Account = Employee_Account::where('employee_id', $id)->first();

    $employee_id_new = $id;

    $name = ucfirst($Account->fname) . ' ' . ucfirst($Account->lname);

    return view('adminpage.admin_data', compact('employee','name','employee_id_new'));
}

public function leave_store(Request $request)
{
    $request->validate([
        'employee_id' => 'nullable|string',
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2000',
        'date' => 'nullable|string',
        'monthly_salary' => 'required',

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

    function getEquivalentDayFromMinutes($totalMinutes) {
        $totalEquivalentDay = 0;
        while ($totalMinutes > 0) {
            $chunk = min(60, $totalMinutes);
            $equivalent = DB::table('working_hour')->where('minutes', $chunk)->value('equivalent_day');

            if (!$equivalent) {
                $equivalent = $chunk / 480;
            }

            $totalEquivalentDay += floatval($equivalent);
            $totalMinutes -= $chunk;
        }
        return $totalEquivalentDay;
    }

    $totalminVl = getEquivalentDayFromMinutes($Vl_totalMinutes);
    $totalminSl = getEquivalentDayFromMinutes($SL_totalMinutes);
 

    $total_conversion = $totalminVl + $totalminSl;

    // Already subtracting absences from earned leave here
    $vl_earned_data = floatval($request->vl_earned) - $totalminVl;
    $sl_earned_data = floatval($request->sl_earned) - $totalminSl;

    $existing = Leave::where('month', $request->month)
                    ->where('employee_id', $request->employee_id)
                    ->where('year', $request->year)
                    ->where('date', $request->date)
                    ->first();

    if ($existing) {
        return redirect()->back()->withErrors(['duplicate' => 'A leave record for this month and year already exists.']);
    }

     $samemonth = Leave::where('month', $request->month)
                    ->where('employee_id', $request->employee_id)
                    ->where('year', $request->year)
                    ->first();

    if($samemonth){
        $prevMonth = $request->month;
        $vl_earned_data = 0;
        $sl_earned_data = 0;
    }else{
         $prevMonth = $request->month - 1;
    }



    $prevYear = $request->year;

    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear -= 1;
    }

   $previousLeave = Leave::where('month', $prevMonth)
                      ->where('year', $prevYear)
                      ->where('employee_id', $request->employee_id)
                      ->orderBy('created_at', 'desc') // or 'updated_at'
                      ->first();
    

    $prev_vl_balance = $previousLeave?->vl_balance ?? 0;
    $prev_sl_balance = $previousLeave?->sl_balance ?? 0;
    
    $currentvl = $request->vl ?? 0 + $request->fl ?? 0;
    $currentsl = $request->sl ?? 0;

    // Corrected: remove double subtraction
    $vl_earned = $vl_earned_data;
    $sl_earned = $sl_earned_data;

    $checkvl = $prev_vl_balance - $currentvl;
    $checksl = $prev_sl_balance - $currentsl;
      
    $leaveCount = Leave::where('employee_id', $request->employee_id)->count();
    if ($leaveCount >= 5) {
        if ($checkvl <= 5) {
            return back()->withErrors([
                'Balance' => "VL exceeds available balance. You must keep at least 5.000."
            ])->withInput();
        }
        if ($checksl <= 5) {
            return back()->withErrors([
                'Balance' => "SL exceeds available balance. You must keep at least 5.000."
            ])->withInput();
        }
    }

    // Final balance computation
    $vl_balance = $vl_earned + $checkvl;
    $sl_balance = $sl_earned + $checksl;
    $total_leave_earned = $vl_balance + $sl_balance;

    $data = $request->only([
        'employee_id', 'month', 'year', 'date',
        'vl', 'sl', 'fl', 'spl', 'other',
        'day_A_T', 'hour_A_T', 'minutes_A_T', 'times_A_T',
        'day_Under', 'hour_Under', 'minutes_Under', 'times_Under','monthly_salary',
    ]);

    $data['vl_earned'] = $vl_earned_data;
    $data['sl_earned'] = $sl_earned_data;
    $data['vl_balance'] = $vl_balance;
    $data['sl_balance'] = $sl_balance;
    $data['total_leave_earned'] = $total_leave_earned;
    $data['total_conversion'] = $total_conversion;
    
    $Name = Employee_Account::where('employee_id', $request->employee_id)->first();

    $data['fname'] = $Name->fname;
    $data['mname'] = $Name->mname;
    $data['lname'] = $Name->lname;

    $total_benifits = ($request->monthly_salary ?? 0) * 0.0481927 * ($total_leave_earned ?? 0);
    $data['constant_factor'] = 0.0481927;
    $data['total_benifits'] = $total_benifits;


    Leave::create($data);

    return redirect()->back()->with('success', 'Leave record added successfully.');
}
public function leave_store_multiple(Request $request)
{
    $count = count($request->employee_id);
    $errors = [];

    for ($i = 0; $i < $count; $i++) {
        $entry = [
            'employee_id' => $request->employee_id[$i],
            'month' => $request->month[$i],
            'year' => $request->year[$i],
            'date' => $request->date[$i] ?? null,
            'monthly_salary' => $request->monthly_salary[$i] ?? 0,

            'vl' => $request->vl[$i] ?? 0,
            'sl' => $request->sl[$i] ?? 0,
            'fl' => $request->fl[$i] ?? 0,
            'spl' => $request->spl[$i] ?? 0,
            'other' => $request->other[$i] ?? 0,

            'vl_earned' => $request->vl_earned[$i] ?? 0,
            'sl_earned' => $request->sl_earned[$i] ?? 0,
        ];

        $result = $this->processSingleLeaveEntry(new Request($entry));
        if ($result !== true) {
            $errors[] = $result;
        }
    }

    if (!empty($errors)) {
        return redirect()->back()->withErrors($errors)->withInput();
    }

    return redirect()->back()->with('success', 'Leave record(s) added successfully.');
}


// Helper to normalize input arrays
private function normalizeBatchEntries(Request $request)
{
    $entries = [];
    $count = count($request->employee_id);

    for ($i = 0; $i < $count; $i++) {
        $entries[] = [
            'employee_id' => $request->employee_id[$i],
            'month' => $request->month[$i],
            'year' => $request->year[$i],
            'date' => $request->date[$i],
            'monthly_salary' => $request->monthly_salary[$i],

            'vl' => $request->vl[$i],
            'sl' => $request->sl[$i],
            'fl' => $request->fl[$i],
            'spl' => $request->spl[$i],
            'other' => $request->other[$i],

            'day_A_T' => $request->day_A_T[$i],
            'hour_A_T' => $request->hour_A_T[$i],
            'minutes_A_T' => $request->minutes_A_T[$i],
            'times_A_T' => $request->times_A_T[$i],

            'day_Under' => $request->day_Under[$i],
            'hour_Under' => $request->hour_Under[$i],
            'minutes_Under' => $request->minutes_Under[$i],
            'times_Under' => $request->times_Under[$i],

            'vl_earned' => $request->vl_earned[$i],
            'vl_absences_withpay' => $request->vl_absences_withpay[$i],
            'vl_absences_withoutpay' => $request->vl_absences_withoutpay[$i],

            'sl_earned' => $request->sl_earned[$i],
            'sl_absences_withpay' => $request->sl_absences_withpay[$i],
            'sl_absences_withoutpay' => $request->sl_absences_withoutpay[$i],
        ];
    }

    return $entries;
}

 function getEquivalentDayFromMinutes($totalMinutes) {
        $totalEquivalentDay = 0;
        while ($totalMinutes > 0) {
            $chunk = min(60, $totalMinutes);
            $equivalent = DB::table('working_hour')->where('minutes', $chunk)->value('equivalent_day');

            if (!$equivalent) {
                $equivalent = $chunk / 480;
            }

            $totalEquivalentDay += floatval($equivalent);
            $totalMinutes -= $chunk;
        }
        return $totalEquivalentDay;
    }

private function processSingleLeaveEntry(Request $request)
{
    $request->validate([
        'employee_id' => 'required|string',
        'month' => 'required|integer|min:1|max:12',
        'year' => 'required|integer|min:2000',
        'date' => 'nullable|string',
        'monthly_salary' => 'required|numeric',

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
    ]);

    $day_A_T = $request->input('day_A_T', 0);
    $hour_A_T = $request->input('hour_A_T', 0);
    $minutes_A_T = $request->input('minutes_A_T', 0);

    $day_Under = $request->input('day_Under', 0);
    $hour_Under = $request->input('hour_Under', 0);
    $minutes_Under = $request->input('minutes_Under', 0);

    $Vl_totalMinutes = ($day_A_T * 480) + ($hour_A_T * 60) + $minutes_A_T;
    $SL_totalMinutes = ($day_Under * 480) + ($hour_Under * 60) + $minutes_Under;

    
   

    $totalminVl = $this->getEquivalentDayFromMinutes($Vl_totalMinutes);
    $totalminSl = $this->getEquivalentDayFromMinutes($SL_totalMinutes);

    $vl_earned_data = floatval($request->vl_earned) - $totalminVl;
    $sl_earned_data = floatval($request->sl_earned) - $totalminSl;

    $existing = Leave::where('month', $request->month)
                    ->where('employee_id', $request->employee_id)
                    ->where('year', $request->year)
                    ->where('date', $request->date)
                    ->first();

    if ($existing) {
        return "Duplicate leave for employee {$request->employee_id} in {$request->month}/{$request->year}.";
    }

    $samemonth = Leave::where('month', $request->month)
                    ->where('employee_id', $request->employee_id)
                    ->where('year', $request->year)
                    ->first();

    if ($samemonth) {
        $vl_earned_data = 0;
        $sl_earned_data = 0;
    }

    $prevMonth = $request->month - 1;
    $prevYear = $request->year;

    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear -= 1;
    }

    $previousLeave = Leave::where('month', $prevMonth)
                        ->where('year', $prevYear)
                        ->where('employee_id', $request->employee_id)
                        ->latest()
                        ->first();

    $prev_vl_balance = $previousLeave?->vl_balance ?? 0;
    $prev_sl_balance = $previousLeave?->sl_balance ?? 0;

    $currentvl = $request->vl ?? 0 + $request->fl ?? 0;
    $currentsl = $request->sl ?? 0;

    $checkvl = $prev_vl_balance - $currentvl;
    $checksl = $prev_sl_balance - $currentsl;

    $leaveCount = Leave::where('employee_id', $request->employee_id)->count();
    if ($leaveCount >= 5) {
        if ($checkvl <= 5) {
            return "VL exceeds available balance for employee {$request->employee_id}. You must keep at least 5.";
        }
        if ($checksl <= 5) {
            return "SL exceeds available balance for employee {$request->employee_id}. You must keep at least 5.";
        }
    }

    $vl_balance = $vl_earned_data + $checkvl;
    $sl_balance = $sl_earned_data + $checksl;
    $total_leave_earned = $vl_balance + $sl_balance;

    $data = $request->only([
        'employee_id', 'month', 'year', 'date',
        'vl', 'sl', 'fl', 'spl', 'other',
        'day_A_T', 'hour_A_T', 'minutes_A_T', 'times_A_T',
        'day_Under', 'hour_Under', 'minutes_Under', 'times_Under',
        'monthly_salary',
    ]);

    $data['vl_earned'] = $vl_earned_data;
    $data['sl_earned'] = $sl_earned_data;
    $data['vl_balance'] = $vl_balance;
    $data['sl_balance'] = $sl_balance;
    $data['total_leave_earned'] = $total_leave_earned;
    $data['total_conversion'] = $totalminVl + $totalminSl;

    $Name = Employee_Account::where('employee_id', $request->employee_id)->first();
    $data['fname'] = $Name->fname;
    $data['mname'] = $Name->mname;
    $data['lname'] = $Name->lname;

    $data['constant_factor'] = 0.0481927;
    $data['total_benifits'] = ($request->monthly_salary ?? 0) * 0.0481927 * ($total_leave_earned ?? 0);

    Leave::create($data);

    return true;
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



    public function print_leave_credit_card($id, $year)
    {

    $items = Leave::where('employee_id', $id)
              ->where('year', $year)
              ->get();
 
    
    $templatePath = public_path('template/leavecreditcard.xlsx');
    $spreadsheet = IOFactory::load($templatePath);
    $sheet = $spreadsheet->getActiveSheet();
    


    $name = Employee_Account::where('employee_id', $id)->first();
    $fullname = "{$name->lname}, {$name->fname} {$name->mname}";

    $sheet->setCellValue("B12", $fullname);
    $sheet->setCellValue("A18", $year);


    $previousYear = $year - 1;

    $decemberLeave = Leave::where('employee_id', $id)
        ->where('year', $previousYear)
        ->where('month', 12)
        ->first();

    $previousDecemberVlBalance = $decemberLeave ? $decemberLeave->vl_balance : 0;

    $previousDecemberSlBalance = $decemberLeave ? $decemberLeave->sl_balance : 0;
    // Then set it into K17
    $sheet->setCellValue('K17', $previousDecemberVlBalance);
    $sheet->setCellValue('O17', $previousDecemberSlBalance);



    $startRow = 19;
    $previousMonth = null;
    foreach ($items as $i => $item) {
    $row = $startRow + $i;

    // After the first item, insert a new row before writing
    if ($i > 0) {
        $sheet->insertNewRowBefore($row);
    }

    $currentMonth  = \DateTime::createFromFormat('!m', $item['month'])->format('F');
    $sheet->mergeCells("A{$row}:B{$row}");
      if ($currentMonth === $previousMonth) {
        // Duplicate month, so set blank for merged cell A:B
        $sheet->setCellValue("A{$row}", '');
    } else {
        // New month, set month name
        $sheet->setCellValue("A{$row}", $currentMonth);
        $previousMonth = $currentMonth;
    }
    $sheet->setCellValue("c$row", $item['date']);
    $sheet->setCellValue("D$row", $item['vl']);
    $sheet->setCellValue("E$row", $item['fl']);
    $sheet->setCellValue("F$row", $item['sl']);
    $sheet->setCellValue("G$row", $item['spl']);
    $sheet->setCellValue("H$row", $item['other']);

    $sheet->setCellValue("I$row", $item['vl_earned']);
    $sheet->setCellValue("J$row", $item['vl_absences_withpay']);

    $sheet->setCellValue("K$row", $item['vl_balance']);
    $sheet->setCellValue("L$row", $item['vl_absences_withoutpay']);

    $sheet->setCellValue("M$row", $item['sl_earned']);
    $sheet->setCellValue("N$row", $item['sl_absences_withpay']);

    $sheet->setCellValue("O$row", $item['sl_balance']);
    $sheet->setCellValue("P$row", $item['sl_absences_withoutpay']);

    $sheet->setCellValue("Q$row", $item['total_leave_earned']);
}
    $lastRow = $row + 1; 

    $totalVL = $items->sum('vl');
    $totalFL = $items->sum('fl');
    $totalSL = $items->sum('sl');
    $totalSPL = $items->sum('spl');
    $totalOTHER = $items->sum('other');

    $totalvl_earned = $items->sum('vl_earned');
    $totalsl_earned= $items->sum('sl_earned');

    $lastItem = $items->sortBy('month')->last();
    $totalvl_balance = $lastItem ? $lastItem->vl_balance : 0;
    $totalsl_balance = $lastItem ? $lastItem->sl_balance : 0;
    $total_leave_earned = $lastItem ? $lastItem->total_leave_earned : 0;

    

    $sheet->setCellValue("D{$lastRow}", $totalVL);
    $sheet->setCellValue("E{$lastRow}", $totalFL);
    $sheet->setCellValue("F{$lastRow}", $totalSL);
    $sheet->setCellValue("G{$lastRow}", $totalSPL);
    $sheet->setCellValue("H{$lastRow}", $totalOTHER);

    $sheet->setCellValue("I{$lastRow}", $totalvl_earned);
    $sheet->setCellValue("K{$lastRow}", $totalvl_balance);

    $sheet->setCellValue("M{$lastRow}", $totalsl_earned);
    $sheet->setCellValue("O{$lastRow}", $totalsl_balance);

    $sheet->setCellValue("Q{$lastRow}", $total_leave_earned);
    
        // Save to temp file
        $excelname = 'Leave_Benefits_' . now()->format('Ymd_His') . '.xlsx';
        $newFilePath = public_path('template/sample.xlsx');
    
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
    
        return response()->download($newFilePath, $excelname)->deleteFileAfterSend(true);
        }
   
 private function embedInUnderscores($word, $totalLength = 20)
    {
        $wordLength = strlen($word);
        $remaining = max($totalLength - $wordLength, 0);
        $left = intdiv($remaining, 2);
        $right = $remaining - $left;
        return str_repeat('_', $left) . $word . str_repeat('_', $right);
    }




public function exportUsers($id)
{
    $application = Application_leave::find($id);
    $account = Employee_Account::where('email', $application->email)->first();
    $lastLeave = Leave::where('employee_id', $account->employee_id)
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->first();

    $vlBalance = $lastLeave ? $lastLeave->vl_balance: 0;
    $slBalance = $lastLeave ? $lastLeave->sl_balance: 0;
   
    

    $fullname = ucfirst(strtolower($account->lname)) . ', ' . ucfirst(strtolower($account->fname));
    if (!empty($account->mname)) {
        $fullname .= ' ' . strtoupper(substr($account->mname, 0, 1)) . '.';
    }

    // Load template
    $templatePath = public_path('template/example.xlsx');
    $spreadsheet = IOFactory::load($templatePath);
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->getStyle('D56')
    ->getNumberFormat()
    ->setFormatCode('0.000');

     $sheet->getStyle('E56')
    ->getNumberFormat()
    ->setFormatCode('0.000');

    $sheet->setCellValue('D56', number_format($vlBalance, 3, '.', ''));
    $sheet->setCellValue('E56', number_format($slBalance, 3, '.', ''));
   
    // Set cell values (adjust cell references to match your template)
    $sheet->setCellValue('B5', $application->officer_department);
    $sheet->setCellValue('E5', $fullname);

      

    $position = $application->position;
    $salary = 'SG' . $application->salary_grade . '-' . $application->step_grade;

    $formattedPosition = $this->embedInUnderscores($position);
    $formattedSalary = $this->embedInUnderscores($salary);

    // Combine into one string as a form line
    $line = "4.   POSITION  $formattedPosition     5.  SALARY  $formattedSalary";

    $sheet->setCellValue('E6', $line);
    
    $date_filing = $application->date_filing;
    $formatteddate_filing = $this->embedInUnderscores($date_filing);
    $line1 = "3.   DATE OF FILING  $formatteddate_filing";

    $sheet->setCellValue('A6', $line1);
   

    // Checkboxes (✔ for selected leave type)
    $leaveCells = [
        'Vacation Leave' => 'B11',
        'Mandatory/Forced Leave' => 'B13',
        'Sick Leave' => 'B15',
        'Maternity Leave' => 'B17',
        'Paternity Leave' => 'B19',
        'Special Privilage Leave' => 'B21',
        'Solo Parent Leave' => 'B23',
        'Study Leave' => 'B25',
        '10-Day VAWC Leave' => 'B27',
        'Rehabilitation Leave' => 'B29',
        'Special Benifits for Women' => 'B31',
        'Special Emergency' => 'B33',
        'Adoption Leave' => 'B35',
    ];

    foreach ($leaveCells as $type => $cell) {
        $sheet->setCellValue($cell, $application->a_availed == $type ? '✔' : '');
    }
$leaveCell1 = [
    'Within Philippines' => ['check' => 'H13', 'label' => 'I13'],
    'Abroad' => ['check' => 'H15', 'label' => 'I15'],
    'In Hospital(Specify Illness)' => ['check' => 'H19', 'label' => 'I19'],
    'Out Patient(Specify Illness)' => ['check' => 'H21', 'label' => 'I21'],
];

foreach ($leaveCell1 as $type => $cells) {
    $isSelected = ($application->b_details == $type);

    // Set checkmark only for the selected type
    $sheet->setCellValue($cells['check'], $isSelected ? '✔' : '');

    // Build the label
    if ($isSelected && !empty(trim($application->b_details_specify))) {
        $fullText = $type . ': _____' . trim($application->b_details_specify) . '_____';
    } else {
        $fullText = $type . ': ______________________';
    }

    // Set the label cell
    $sheet->setCellValue($cells['label'], $fullText);
}

 

    $start = new DateTime($application->startDate);
    $end = new DateTime($application->endDate);

    $days = 0;
    while ($start <= $end) {
        // 1 = Monday, 7 = Sunday
        if ($start->format('N') < 6) {
            $days++;
        }
        $start->modify('+1 day');
    }

    // Save to Excel
    $sheet->setCellValue('C45', $days . ' day/s');

   if ($application->a_availed === 'Vacation Leave' || $application->a_availed === 'Mandatory/Forced Leave') {
            $less_vl_used = $days;
            $less_vsl_used = '-';
        } elseif ($application->a_availed === 'Sick Leave') {
            $less_vl_used = '-';
            $less_vsl_used = $days;
        } else {
            $less_vl_used = '-';
            $less_vsl_used = '-';
        }


    $sheet->setCellValue('D57', $less_vl_used );
    $sheet->setCellValue('E57', $less_vsl_used );


    $sheet->setCellValue('C48', $application->c_inclusive_dates);

    $datelastmonth = \Carbon\Carbon::now()->subMonth()->endOfMonth()->format('d F, Y');
    $sheet->setCellValue('C53', 'As of '. $datelastmonth);

    // Others
    if ($application->a_availed == 'Others:') {
        $sheet->setCellValue('B41', $application->a_availed_others); 
    }

    $sheet->setCellValue('H39', $application->b_other_purpose_detail == 'Monetization of Leave Credits' ? '✔' : '');
    $sheet->setCellValue('H41', $application->b_other_purpose_detail == 'Terminal Leave' ? '✔' : '');
    if($application->a_availed == 'Others:'){
      $sheet->setCellValue('B41', $application->b_other_purpose_detail );
    }

    $sheet->setCellValue('H33', $application->b_details == 'Completion of Masters Degree' ? '✔' : '');
    $sheet->setCellValue('H35', $application->b_details == 'BAR/Board Examination Review' ? '✔' : '');
    
    $sheet->setCellValue('H53', $application->status == 'Approved' ? '✔' : '');
    $sheet->setCellValue('H55', $application->status == 'Declined' ? '✔' : '');

    $reason =  $application->reason ?? '';

        if (strlen($reason) > 50) {
            $sheet->setCellValue('I56', substr($reason, 0, 50)); // First 50 chars
            $sheet->setCellValue('I57', substr($reason, 50));     // Rest
        } else {
            $sheet->setCellValue('I56', $reason);
            $sheet->setCellValue('I57', ''); // Clear extra line if previously filled
        }


    
    

    $sheet->setCellValue('I29', $application->a_availed == 'Special Benifits for Women' ? '_____'.$application->b_details_specify.'_____' : '');
    // Commutation Requested
    $sheet->setCellValue('H45', $application->d_commutation == 'Requested' ? '✔' : '');
    $sheet->setCellValue('H47', $application->d_commutation == 'Not Requested' ? '✔' : '');

 // Insert signature image if available
if ($account->e_signature && file_exists(public_path($account->e_signature))) {
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Signature');
    $drawing->setDescription('Employee Signature');
    $drawing->setPath(public_path($account->e_signature));
    $drawing->setHeight(80); // You can adjust this if needed
    $drawing->setCoordinates('I47');

    // Get column I width in pixels
    $colWidth = $sheet->getColumnDimension('I')->getWidth(); // default ~8.43 units
    $mergedWidthPx = $colWidth * 7.5; // approx conversion to pixels

    // Get actual image width
    $imageWidthPx = $drawing->getWidth();

    // Calculate horizontal offset to center image with 4px side margin
    $offsetX = (($mergedWidthPx - 8) - $imageWidthPx) / 2 + 4; // subtract 8px margin, add 4px padding
    if ($offsetX < 0) $offsetX = 0;

    // Get row height (row 47)
    $rowHeightPts = $sheet->getRowDimension(47)->getRowHeight();
    if (!$rowHeightPts) {
        $rowHeightPts = 15; // fallback default height
    }

    // Convert row height to pixels (1pt ≈ 1.33px)
    $rowHeightPx = $rowHeightPts * 1.33;
    $imageHeightPx = $drawing->getHeight();

    // Calculate vertical offset to center the image
    $offsetY = (($rowHeightPx - 8) - $imageHeightPx) / 2 + 4;
    if ($offsetY < 0) $offsetY = 0;

    $drawing->setOffsetX($offsetX);
    $drawing->setOffsetY($offsetY);

    // Attach image to the worksheet
    $drawing->setWorksheet($sheet);
}



    // Save and download
    $excelname = 'Save_' . now()->format('Ymd_His') . '.xlsx';
    $savePath = public_path('savefile/' . $excelname);

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($savePath);

    return response()->download($savePath)->deleteFileAfterSend(true);
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


public function deleteWithPassword(Request $request)
{
    $request->validate([
        'item_id' => 'required|exists:leaves,id',
        'password' => 'required|string',
    ]);

    // Get email from session (set in Admin_Login)
    $email = Session::get('user_email');

    if (!$email) {
        return response()->json(['message' => 'User session not found. Please log in again. '], 401);
    }

    $user = Employee_Account::where('email', $email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid password'], 401);
    }

    Leave::findOrFail($request->item_id)->delete();

    return response()->json(['success' => true]);
}


  public function Admin_Login(Request $request)
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
            'idToken' => $signInResult->idToken(),  // This is NOT a custom token!
        ]);
        Session::put('user_email', $request->email);
        Session::put('firebase_token', $signInResult->idToken()); // Store ID token

        // Store user info in session
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
        $data['password'] = Hash::make($request->password); 
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
    
public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:6|confirmed',
    ]);

    $email = Session::get('user_email');

    $user = Employee_Account::where('email', $email)->first();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Current password is incorrect.');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password changed successfully.');
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
        $leave = Application_leave::where('status', 'Pending')
             ->orderBy('date_filing', 'desc')
             ->get();
        return view('adminpage.newimprovedashboard', compact('leave','countleave','countemployee'));
    }
    function Admin_Application_Leave(){
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
        $leave = Application_leave::orderBy('created_at', 'desc')->get();
        return view('adminpage.applicationleave', compact('leave'));
    }
  function Admin_Employee_Account() {
    $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
    $employees = Employee_Account::where('role', 'user')->get();
    return view('adminpage.employeeaccount', compact('employees'));
}

    function Admin_Leave_Credit_Card(){
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
     $employees = Employee_Account::where('account_status', '!=', 'Pending')
    ->where('role', 'user')
    ->get();

        return view('adminpage.formleavecredit', compact('employees'));
    }

function Admin_Leave_Credit_Card_Generate(Request $request){
    $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
    $request->validate([
        'employee' => 'required',
        'year' => 'required|numeric',
    ]);

    $email = $request->employee;
    $year = $request->year;

    $employee = Employee_Account::where('email', $email)->first();

    // Get current year leaves
    $leaves = Leave::where('employee_id', $employee->employee_id)
                   ->where('year', $year)
                   ->orderByRaw('CAST(month AS UNSIGNED)')
                   ->get();
   $months = $leaves->pluck('month'); // returns a collection of months

   


    // Determine the previous month and year
    $firstLeave = $leaves->first();
    if ($firstLeave) {
        $prevMonth = $firstLeave->month - 1;
        $prevYear = $year;
        if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear = $year - 1;
        }

        // Get previous leave record
        $previousLeave = Leave::where('employee_id', $employee->employee_id)
                              ->where('month', $prevMonth)
                              ->where('year', $prevYear)
                              ->latest('id') // just in case there are duplicates
                              ->first();

        $vl_oldbalance = $previousLeave->vl_balance ?? 0;
        $sl_oldbalance = $previousLeave->sl_balance ?? 0;
        $total_oldbalance = $previousLeave->total_leave_earned ?? 0;
    } else{
        $vl_oldbalance = 0;
        $sl_oldbalance = 0;
        $total_oldbalance = 0;
    }
    $name = $employee->fname . ' ' . 
            ($employee->mname ? strtoupper(substr($employee->mname, 0, 1)) . '. ' : '') . 
            $employee->lname;


      $totalsum_leave = Leave::where('year', $year)
            ->where('employee_id', $employee->employee_id)
            ->get();
     

        $total_sum_VL = $totalsum_leave->sum(function ($leave) {
            return $leave->vl?? 0;
        });
         $total_sum_FL = $totalsum_leave->sum(function ($leave) {
            return $leave->fl?? 0;
        });
         $total_sum_SL = $totalsum_leave->sum(function ($leave) {
            return $leave->sl?? 0;
        });
         $total_sum_SPL = $totalsum_leave->sum(function ($leave) {
            return $leave->spl?? 0;
        });
        $total_sum_OTHER = $totalsum_leave->sum(function ($leave) {
            return $leave->other?? 0;
        });
        // VL

           $total_sum_VL_EARNED = number_format(
            $totalsum_leave->sum(function ($leave) {
                return $leave->vl_earned ?? 0;
            }),
            3
        );






         $total_sum_VL_WITHPAY = $totalsum_leave->sum(function ($leave) {
            return $leave->vl_absences_withpay?? 0;
        });
 
         $total_sum_VL_WITHOUTPAY = $totalsum_leave->sum(function ($leave) {
            return $leave->vl_absences_withoutpay?? 0;
        });
        // SL
      
         $total_sum_SL_EARNED = number_format(
            $totalsum_leave->sum(function ($leave) {
                return $leave->sl_earned ?? 0;
            }),
            3
        );
         $total_sum_SL_WITHPAY = $totalsum_leave->sum(function ($leave) {
            return $leave->sl_absences_withpay?? 0;
        });

         $total_sum_SL_WITHOUTPAY = $totalsum_leave->sum(function ($leave) {
            return $leave->sl_absences_withoutpay ?? 0;
        });
        
       $last = Leave::where('employee_id', $employee->employee_id)
                    ->where('year', $year)
                    ->whereNotNull('total_leave_earned')
                    ->orderByRaw('CAST(month AS UNSIGNED) DESC')
                    ->first();
       $total_sum_VL_BALANCE = $last ? $last->vl_balance : 0; 
       $total_sum_SL_BALANCE = $last ? $last->sl_balance : 0; 
       $total_sum_total_leave_earned = $last ? $last->total_leave_earned : 0;
        
       $id = $employee->employee_id;
 
    return view('adminpage.leave_credit_card', compact('employee', 'year', 'leaves', 'id',
    'vl_oldbalance','sl_oldbalance','total_oldbalance','name',
    'total_sum_VL', 'total_sum_FL','total_sum_SL','total_sum_SPL','total_sum_OTHER',
    'total_sum_VL_EARNED','total_sum_VL_WITHPAY','total_sum_VL_BALANCE','total_sum_VL_WITHOUTPAY',
    'total_sum_SL_EARNED','total_sum_SL_WITHPAY','total_sum_SL_BALANCE','total_sum_SL_WITHOUTPAY',
    'total_sum_total_leave_earned',

    ));
}

    function Admin_Summary(){
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
        return view('adminpage.formsummary');
    }

      public function export_late_WithTemplate($month, $year)
    {
    $monthreq = $month;

    $filePath = public_path('template/late_template.xlsx');
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();

    $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    $dateFormatted = date('d F Y', strtotime("$year-$month-01 +1 month -1 day"));

    // Inject header date
    $sheet->setCellValue('A12', 'as of ' . $dateFormatted);

   
    $borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
        ],
        ];

        $borderStyle_1 = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,  
            ],
        ];

  $startRow = 17;

 $late = Leave::where('year', $year)
        ->where('month', $monthreq)
        ->get();

// Loop to insert all leave rows
foreach ($late as $index => $item) {
    $row = $startRow + $index;

    $sheet->insertNewRowBefore($row);
    $sheet->setCellValue("A$row", $index + 1);          
    $sheet->setCellValue("B$row", ucfirst($item->lname));
    $sheet->setCellValue("C$row", ucfirst($item->fname)); 
    $sheet->setCellValue("D$row", ucfirst($item->lname));    
    $sheet->setCellValue("E$row", $item->day_A_T ?? 0);    
    $sheet->setCellValue("F$row", $item->hour_A_T ?? 0);       
    $sheet->setCellValue("G$row", $item->minutes_A_T ?? 0);  
    $sheet->setCellValue("H$row", $item->times_A_T ?? 0);
    $sheet->setCellValue("I$row", $item->day_Under ?? 0);
    $sheet->setCellValue("J$row", $item->hour_Under ?? 0);
    $sheet->setCellValue("K$row", $item->minutes_Under ?? 0);
    $sheet->setCellValue("L$row", $item->times_Under ?? 0);
    $sheet->setCellValue("M$row", ($item->day_A_T ?? 0)+($item->day_Under ?? 0)); 
    $sheet->setCellValue("N$row", ($item->hour_A_T ?? 0)+($item->hour_Under ?? 0)); 
    $sheet->setCellValue("O$row", ($item->minutes_A_T ?? 0)+($item->minutes_Under ?? 0)); 
    $sheet->setCellValue("P$row", ($item->times_A_T ?? 0)+($item->times_Under ?? 0)); 
    $sheet->setCellValue("Q$row", $item->total_conversion ?? '');

}
    $insertedCount = count($late);
    $endRow = $startRow + $insertedCount;

    $sumDayAT = $late->sum(function ($item) {
    return $item->day_A_T ?? 0;
});
    $sumHourAT = $late->sum(function ($item) {
    return $item->hour_A_T ?? 0;
});
    $sumMinutesAT = $late->sum(function ($item) {
    return $item->minutes_A_T ?? 0;
});
    $sumTimesAT = $late->sum(function ($item) {
    return $item->times_A_T ?? 0;
});

    $sumDayUder = $late->sum(function ($item) {
    return $item->day_Under?? 0;
});
    $sumHourUder = $late->sum(function ($item) {
    return $item->hour_Under ?? 0;
});
    $sumMinutesUder = $late->sum(function ($item) {
    return $item->minutes_Under ?? 0;
});
    $sumTimesUder = $late->sum(function ($item) {
    return $item->times_Under ?? 0;
});

    $sheet->setCellValue("E" . $endRow, $sumDayAT);
    $sheet->setCellValue("f" . $endRow, $sumHourAT);
    $sheet->setCellValue("G" . $endRow, $sumMinutesAT);
    $sheet->setCellValue("H" . $endRow, $sumTimesAT);

    $sheet->setCellValue("I" . $endRow, $sumDayUder);
    $sheet->setCellValue("J" . $endRow, $sumHourUder);
    $sheet->setCellValue("K" . $endRow, $sumMinutesUder);
    $sheet->setCellValue("L" . $endRow, $sumTimesUder);

    $sheet->setCellValue("M" . $endRow, ($sumDayAT ?? 0) +  ($sumHourUder ?? 0) );
    $sheet->setCellValue("N" . $endRow, ($sumHourAT ?? 0) +  ($sumHourUder ?? 0) );
    $sheet->setCellValue("O" . $endRow, ($sumMinutesAT ?? 0) +  ($sumMinutesUder ?? 0) );
    $sheet->setCellValue("P" . $endRow, ($sumTimesAT ?? 0) +  ($sumTimesUder ?? 0) );



    $writer = new Xlsx($spreadsheet);
    $filename = "Summary_of_Absences_{$year}_{$month}.xlsx";

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename);
}

    
    public function Admin_Summary_Generate(Request $request){

        $request->validate([
            'month' => 'required|integer',
            'year' => 'required|numeric',
        ]);
    
          $month = $request->month;
          $year = $request->year;

          $monthsreq =$request->month;

    // Get current year leaves
     $leaves = Leave::where('year', $year)
                   ->where('month' , $month)
                   ->get();

      $sum_day = $leaves->sum(function ($leave) {
            return $leave->day_A_T ?? 0;
        });
    
      $sum_hour = $leaves->sum(function ($leave) {
            return $leave-> hour_A_T ?? 0;
        });
      $sum_minutes = $leaves->sum(function ($leave) {
            return $leave-> minutes_A_T ?? 0;
        });
      $sum_times = $leaves->sum(function ($leave) {
            return $leave-> times_A_T ?? 0;
        });

        
      $sum_day_1 = $leaves->sum(function ($leave) {
            return $leave-> day_Under ?? 0;
        });
    
      $sum_hour_1 = $leaves->sum(function ($leave) {
            return $leave-> hour_Under ?? 0;
        });
      $sum_minutes_1 = $leaves->sum(function ($leave) {
            return $leave->	minutes_Under ?? 0;
        });
      $sum_times_1 = $leaves->sum(function ($leave) {
            return $leave->times_Under ?? 0;
        });

    $month = $request->month;
    $year = $request->year;
  
    $date = Carbon::create($year, $month, 1);
    $lastDay = $date->endOfMonth()->format('d F Y');

        return view('adminpage.summary',compact('lastDay','leaves',
        'sum_day','sum_hour','sum_minutes','sum_times',
         'sum_day_1','sum_hour_1','sum_minutes_1','sum_times_1',
         'monthsreq','year'
    ));
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
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
        return view('adminpage.formterminal');
    }

     
    public function Admin_Terminal_Leave_Generate(Request $request){

    $monthsreq = $request-> input('month');
 
    $month = str_pad($request->input('month'), 2, '0', STR_PAD_LEFT);
    $year = $request->input('year');
    $date = date('d F Y', strtotime("$year-$month-01 +1 month -1 day"));
   
    $constantFactor = 0.0481927;

    $leaves = Leave::where('year', $year)
        ->where('month', $monthsreq)
        ->get()
        ->map(function ($item) use ($constantFactor) {
            $item->total = ($item->vl_balance ?? 0) + ($item->sl_balance ?? 0);
            $item->constant_factor = $constantFactor;
            $item->grand_total = round($item->total * $constantFactor * $item->monthly_salary, 2);
            return $item;
        });
      

    $total_leave_benefit = $leaves->sum('grand_total');

    $previous_balance = Leave::where('year', $year)
        ->where('month', '<', $monthsreq)
        ->sum('total_benifits');
    
    $formatted_payable = $total_leave_benefit - $previous_balance;

    $current_month_payable = $formatted_payable < 0 
        ? '(' . number_format(abs($formatted_payable), 2) . ')' 
        : number_format($formatted_payable, 2);
    
    
  
    return view('adminpage.terminal', compact(
        'leaves', 'date', 'total_leave_benefit', 'previous_balance', 'current_month_payable','monthsreq','year',
    ));
}

    public function exportWithTemplate($month, $year)
{
    $monthreq = $month;

    $filePath = public_path('template/terminal_template.xlsx');
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();

    $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    $dateFormatted = date('d F Y', strtotime("$year-$month-01 +1 month -1 day"));

    // Inject header date
    $sheet->setCellValue('A12', 'as of ' . $dateFormatted);

     $constantFactor = 0.0481927;
    $leaves = Leave::where('year', $year)
        ->where('month', $monthreq)
        ->get()
        ->map(function ($item) use ($constantFactor) {
            $item->total = ($item->vl_balance ?? 0) + ($item->sl_balance ?? 0);
            $item->constant_factor = $constantFactor;
            $item->grand_total = round($item->total * $constantFactor * $item->monthly_salary, 2);
            return $item;
        });
    $total_leave_benefit = $leaves->sum('grand_total');
   
    $borderStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
        ],
        ];

        $borderStyle_1 = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,  
            ],
        ];
  $startRow = 17;

// Loop to insert all leave rows
foreach ($leaves as $index => $item) {
    $row = $startRow + $index;

    $sheet->insertNewRowBefore($row);
    $sheet->setCellValue("A$row", $index + 1);          
    $sheet->setCellValue("B$row", ucfirst($item->lname).', '.ucfirst($item->fname).' '.ucfirst($item->fname));
    $sheet->setCellValue("C$row", $item->monthly_salary); 
    $sheet->setCellValue("D$row", $item->vl_balance);    
    $sheet->setCellValue("E$row", $item->sl_balance);    
    $sheet->setCellValue("F$row", $item->total_leave_earned);        

    $grand_total = $item->total_leave_earned * $constantFactor * $item->monthly_salary;
    $sheet->setCellValue("G$row", $constantFactor);
    $sheet->setCellValue("H$row", $grand_total);  

    $sheet->getStyle("A$row:H$row")->applyFromArray($borderStyle);
    $sheet->getStyle("C$row")->applyFromArray($borderStyle_1);
    $sheet->getStyle("H$row")->applyFromArray($borderStyle_1);

    // Format currency
    if ($index === 0) {
        $sheet->getStyle("C$row")->getNumberFormat()->setFormatCode('"Php   "#,##0.00');
        $sheet->getStyle("H$row")->getNumberFormat()->setFormatCode('"Php   "#,##0.00');
    } else {
        $sheet->getStyle("C$row")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("H$row")->getNumberFormat()->setFormatCode('#,##0.00');
    }
}

// ✅ Now calculate where to place totals (AFTER loop)
    $insertedCount = count($leaves);
    $endRow = $startRow + $insertedCount;

    // Compute balances
    $previous_balance = Leave::where('year', $year)
        ->where('month', '<', $monthreq)
        ->sum('total_benifits');

    $current_month_payable = $total_leave_benefit - $previous_balance;

    // Place total values after the last data row
    $sheet->setCellValue("H" . $endRow, $total_leave_benefit);
    $sheet->setCellValue("H" . ($endRow + 1), $previous_balance);
    $sheet->setCellValue("H" . ($endRow + 2), $current_month_payable);

    // Export
    $writer = new Xlsx($spreadsheet);
    $filename = "terminal_leave_{$year}_{$month}.xlsx";

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename);
}


    
// public function Admin_Terminal_Leave_Generate(Request $request)
// {
//     $request->validate([
//         'month' => 'required|integer',
//         'year' => 'required|integer',
//     ]);

//     $month = $request->month;
//     $year = $request->year;
//     $constantFactor = 0.0481927;

//     $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT); // Ensure two-digit format (e.g., 01, 12)
//     $date = date('d F Y', strtotime("$year-$monthNumber-01 +1 month -1 day"));

//     $employees = Employee_Account::all();
//     $results = [];

//     foreach ($employees as $employee) {
//         $leave = Leave::where('employee_id', $employee->id)
//                       ->where('month', $month)
//                       ->where('year', $year)
//                       ->first();

//         if ($leave) {
//             $vl = $leave->vl_balance ?? 0;
//             $sl = $leave->sl_balance ?? 0;
//             $totalLeave = $vl + $sl;
//             $salary = $employee->salary ?? 0;
           
//             $terminalLeaveTotal = $salary * $totalLeave * $constantFactor;
           
//             // Save to terminal_leave table
//             TerminalLeaveRecord::updateOrCreate(
//                 [
//                     'employee_id' => $employee->id,
//                     'month' => $month,
//                     'year' => $year,
//                 ],
//                 [
//                     'vl' => $vl,
//                     'sl' => $sl,
//                     'total' => $totalLeave,
//                     'constant_factor' => $constantFactor,
//                     'grand_total' => $terminalLeaveTotal,
//                     'salary' => $salary,
//                 ]
//             );

//             $results[] = (object)[
//                 'name' => $employee->name,
//                 'salary' => $salary,
//                 'vl' => $vl,
//                 'sl' => $sl,
//                 'total' => $totalLeave,
//                 'constant_factor' => $constantFactor,
//                 'grand_total' => $terminalLeaveTotal,
//             ];
//         }
//     }
//     // Return to view
//     return view('adminpage.terminal', [
//         'leave' => $results, 'date' => $date
//     ]);
// }
    



    function Admin_Control_Panel(){
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
        return view('adminpage.control_panel');
    }
    function Salary(){
        $email = Session::get('user_email');

        if (!$email) {
            return redirect('/Admin')->with('error', 'You need to log in first.');
        }
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

   function Admin_Change_Password(){
     return view('adminlogin.admin_change');
   }

  public function Admin_Forgot_password_form(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = Employee_Account::where('email', $request->email)->first();
        
        if($email->role == 'user'){
            return redirect()->back()->with('error', 'An error occurred. Admin Only.');
        }
    
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

  public function edit(Request $request)
    {
        $id = $request->id; // capture employee DB ID
        $employeeId = $request->employee_id;
        $position = $request->position;
        $monthlySalary = $request->monthly_salary;

        return view('adminpage.edit', compact('id', 'employeeId', 'position', 'monthlySalary'));
    }

public function employee_update(Request $request)
{
    $dd =$request->validate([
        'id' => 'required|integer',
        'employee_id' => 'required',
        'position' => 'required',
        'monthly_salary' => 'required|numeric',
    ]);
  

    $employee = Employee_Account::find($request->id);


    if ($employee) {
        $employee->emp_id = $request->employee_id;
        $employee->position = $request->position;
        $employee->monthly_salary = $request->monthly_salary;
        $employee->save();

        return redirect('/Admin-Employee-Account')->with('success', 'Employee updated successfully.');
    }

    return redirect()->back()->with('error', 'Employee not found.');
}


}