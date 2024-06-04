<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Certificate;
use DB;

class CertificateExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $search = '';
            if(isset($_GET['search']) && $_GET['search'] != ''){
                $search = $_GET['search'];
            }
            $records = Certificate::orderBy('id', 'DESC');
            if($search){
                $records = $records->where('first_name', 'LIKE', '%'.$search.'%')->orWhere('last_name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->get();

        return view('modules.certificate-excel', [
            'records' => $records
        ]);
    }
}
