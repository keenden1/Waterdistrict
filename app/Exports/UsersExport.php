<?php
namespace App\Exports;

use App\Models\Application_leave;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Events\AfterSheet;
class UsersExport implements WithEvents, WithMapping, ShouldAutoSize
{
    public function map($application): array
    {
        // Map the data from the Application_leave model to specific columns
        return [
            $application->officer_department,
            $application->fullname, 
            $application->email, 
            $application->salary_grade, 
            $application->step_grade, 
            $application->date_filing,
            $application->position,
            $application->salary,
            $application->a_availed,
            $application->a_availed_others,
            $application->b_details,
            $application->b_details_specify,
            $application->c_working_days,
            $application->c_inclusive_dates,
            $application->d_commutation,
            $application->seven_a_certification,
            $application->seven_b_recommendation,
            $application->seven_c_approved,
            $application->seven_d_disapproved,
            $application->reason,
            $application->status,
        ];
    }

    public function registerEvents(): array
    {
        return [
            // This will run when the export file is being created
            AfterSheet::class => function (AfterSheet $event) {
                // Apply styles or manipulations to the sheet here if needed
            }
        ];
    }

    public function collection()
    {
        // Retrieve the data for export
        return Application_leave::all();
    }

    public function heading(): array
    {
        return [
            'Fullname',
            'Email',
            'Salary Grade',
            'Step Grade',
            'Position',
            'Date Filing',
            'Reason',
        ];
    }

    public function exportWithTemplate()
    {
        // Load the template Excel file
        $templatePath = public_path('template/example.xlsx');
        $spreadsheet = IOFactory::load($templatePath);  // Load the Excel template

        $sheet1 = $spreadsheet->getSheet(0); 
        $sheet = $spreadsheet->getSheet(1); 
        $users = $this->collection();

      
        foreach ($users as $user) {
            $sheet->setCellValue("A1", $user->officer_department);
            $sheet->setCellValue("B2", $user->fullname);
            $sheet->setCellValue("A2", $user->step_grade . '' . $user->salary_grade);
          
        }

        // Save the updated Excel file
        $newFilePath = public_path('sample.xlsx');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);

        // Return the file for download
        return response()->download($newFilePath);
    }
}
