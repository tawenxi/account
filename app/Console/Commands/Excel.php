<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Excel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:excel {excel?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::allFiles('public/excel');

    $files = collect($files)->filter(function($val){
        return strstr($val,'.xl') AND !strstr($val, '~$');
    });

    foreach ($files as $file) {

         $this->info($file);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

        $count = $spreadsheet->getSheetCount();

        $currentIndex = 0;

        do {
                
                $worksheet = $spreadsheet->getSheet($currentIndex);
                $this->line($worksheet->getCodeName());
                // Get the highest row number and column letter referenced in the worksheet
                $highestRow = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
                // Increment the highest column letter
                $highestColumn++;


                for ($row = 1; $row <= $highestRow; ++$row) {

                    for ($col = 'A'; $col != $highestColumn; ++$col) {

                             $cell_value = $worksheet->getCell($col . $row)
                                 ->getValue(); //.

                             if (strstr($cell_value, $this->argument('excel'))) {
                                $this->error('finded');
                             }
                    }

                }


                
                $currentIndex++;

        } while ($currentIndex < $count);
    }
}
}
