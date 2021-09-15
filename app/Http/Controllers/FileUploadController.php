<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Inventory\Helpers\ImportStock;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Inventory;
use App\Jobs\ImportCsvProcess;
use App\Jobs\ImportProcess;

class FileUploadController extends Controller
{
    public function show_import_form()
    {
        $pageTitle = 'Import Inventory';

        return view('upload', compact(['pageTitle']));
    }

    public function store()
    {
        if(request()->has('file')) {

            $data = file(request()->file);

            // Chunking file in 1000 bits
            $chunks = array_chunk($data, 1000);

            $header = [];

             //creating temp files from the chunks
            foreach($chunks as $key => $chunk) {
                // get all the temporarily stored files
                $name = "/tmp{$key}.csv";
                $path = resource_path('temp');
                file_put_contents($path . $name, $chunk);

            }

            //fetch all temp files and loop through data

            $files = glob("$path/*.csv");

            foreach($files as $key => $file) {

                $data = array_map('str_getcsv', file($file));
                if($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                foreach($data as $inv) {

                    $invdata = array_combine($header, $inv);
        
                    Inventory::create($invdata);
        
                }

                //ImportCsvProcess::dispatch($data, $header);

                //removing file, move to next
                unlink($file);
            }

            return 'Stored Successfully';

        }

    }

}
