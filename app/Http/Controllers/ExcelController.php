<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\ExportQR;

class ExcelController extends Controller
{
    public function export($id)
    {
        // Retrieve the specific ExportQR record by ID.
        $qr = ExportQR::find($id);

        // Ensure the record exists
        if (!$qr) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Generate data for each number from no_awal to no_akhir
       
            $data[] = [
                'Link' => url('/detail-produsen-non')."/".$id,
            ];

        // Pass the data to the export class
        return Excel::download(new UsersExport($data), 'Data_QRCode.xlsx');
    }
}
