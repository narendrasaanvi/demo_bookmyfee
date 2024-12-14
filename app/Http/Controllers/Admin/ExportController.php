<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlayerRegistration;
use App\Models\TournamentRegistration;
use App\Models\Tournament;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function export(Request $request, $id)
    {
        // Fetch player registration data by id
        $players = TournamentRegistration::where('tournament_id', $id)->get();

        // Create a new PhpSpreadsheet object
        $spreadsheet = new Spreadsheet();

        // Add first sheet for player registration information
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Player Registration Information');

        // Add headers for player registration sheet
        $headers = [
            'ID', 'User ID', 'Tournament ID', 'FIDE ID', 'AICF ID', 'FIDE Rating',
            'State Membership ID', 'Player Name', 'Residential Address', 'Gender',
            'Father Name', 'State', 'DOB', 'District', 'Mobile 1', 'Taluk',
            'Mobile 2', 'Pin Code', 'Email', 'School/College Name', 'Online Chess ID',
            'Created At', 'Updated At', 'Status', 'Payment Status'
        ];
        $sheet->fromArray([$headers], null, 'A1');

        // Add player registration data
        $row = 2;
        foreach ($players as $playerlist) {
            $sheet->setCellValue('A'.$row, $playerlist->player->id);
            $sheet->setCellValue('B'.$row, $playerlist->player->user_id);
            $sheet->setCellValue('C'.$row, $playerlist->player->tournament_id);
            $sheet->setCellValue('D'.$row, $playerlist->player->fide_id);
            $sheet->setCellValue('E'.$row, $playerlist->player->aicf_id);
            $sheet->setCellValue('F'.$row, $playerlist->player->fide_rating);
            $sheet->setCellValue('G'.$row, $playerlist->player->state_membership_id);
            $sheet->setCellValue('H'.$row, $playerlist->player->player_name);
            $sheet->setCellValue('I'.$row, $playerlist->player->residential_address);
            $sheet->setCellValue('J'.$row, $playerlist->player->gender);
            $sheet->setCellValue('K'.$row, $playerlist->player->father_name);
            $sheet->setCellValue('L'.$row, $playerlist->player->state);
            $sheet->setCellValue('M'.$row, $playerlist->player->dob);
            $sheet->setCellValue('N'.$row, $playerlist->player->district);
            $sheet->setCellValue('O'.$row, $playerlist->player->mobile_1);
            $sheet->setCellValue('P'.$row, $playerlist->player->taluk);
            $sheet->setCellValue('Q'.$row, $playerlist->player->mobile_2);
            $sheet->setCellValue('R'.$row, $playerlist->player->pin_code);
            $sheet->setCellValue('S'.$row, $playerlist->player->email);
            $sheet->setCellValue('T'.$row, $playerlist->player->school_college_name);
            $sheet->setCellValue('U'.$row, $playerlist->player->online_chess_id);
            $sheet->setCellValue('V'.$row, $playerlist->player->created_at);
            $sheet->setCellValue('W'.$row, $playerlist->player->updated_at);
            $sheet->setCellValue('X'.$row, $playerlist->player->status);
            $sheet->setCellValue('Y'.$row, $playerlist->player->payment_status);
            $row++;
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'player_registration_export.xlsx';
        $writer->save($filename);

        // Download the file
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
