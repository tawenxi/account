<?php

namespace App\Console\Commands;

use App\Model\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Excel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'se {excel?}';

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
    	$this->line('========================================================================');
    	 $myFile = File::where('url', 'like', '%'.substr($file,13).'%')->first();
    	 if ($myFile) {
    	 	
    	 	$myZb = $myFile->zb;
    	 	$this->error($myZb->ZY.'****'.div($myZb->JE).'****'.$myZb->ZBID);
    	 }
    	 
         $this->info($file);


        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

        $count = $spreadsheet->getSheetCount();

        $currentIndex = 0;

        do {
                $worksheet = $spreadsheet->getSheet($currentIndex);
                $this->line($worksheet->getCodeName());
                

				foreach ($worksheet->getRowIterator() as $row) {
				    
				    $cellIterator = $row->getCellIterator();
				    $cellIterator->setIterateOnlyExistingCells(FALSE); 
				    // This loops through all cells,
				    //    even if a cell value is not set.
				    // By default, only cells that have a value
				    //    set will be iterated.

				    foreach ($cellIterator as $cell) {			          
				             if (strstr($cell->getValue(), $this->argument('excel'))) {
                                $this->error('finded'.'==========>'.$cell->getValue());

                             }
				    }
				}
                $currentIndex++;
        } while ($currentIndex < $count);
    }
}
}
