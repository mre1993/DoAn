<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;



class Export implements FromCollection
{
    public function __construct()
    {        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices->all();
    }

}
