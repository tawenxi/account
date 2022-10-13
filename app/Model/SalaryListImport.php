<?php

namespace App\Model;

class SalaryListImport extends \Maatwebsite\Excel\Files\ExcelFile
{
    protected $delimiter = ',';
    protected $enclosure = '"';
    protected $lineEnding = '\r\n';

    public function getFile()
    {
        $file = cache('excel');

        return storage_path("excel/$file.xls");
    }

    public function getFilters()
    {
        return [
            'chunk',
        ];
    }
}
