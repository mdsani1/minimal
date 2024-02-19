<?php

namespace App\Exports;

use App\Models\Interior;
use Maatwebsite\Excel\Concerns\FromCollection;

class InteriorsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Interior::all();
    }
}
