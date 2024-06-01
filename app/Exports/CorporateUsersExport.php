<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class CorporateUsersExport implements FromView
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

            $records = DB::table('users as u');

            if($search != ''){
                $records = $records->where(function ($query) use ($search) {
                              $query->where('u.name', 'LIKE', '%'.$search.'%')
                              ->orWhere('u.email', 'LIKE', '%'.$search.'%');
                              });
            }
           
            $records = $records->leftJoin('corporates as c', 'u.ca_org_id', '=', 'c.id')
                ->where('u.ca_status', 1)
                ->whereDate('u.ca_expiry', '>=', Date('Y-m-d'))
                ->select('u.name', 'u.ca_email', 'u.ca_expiry', 'u.ca_status', 'c.name as org_name', 'c.domain', 'c.status as org_status', 'c.expiry as org_expiry', 'u.email')->orderBy('u.id','DESC')
                ->get();
            
        return view('excel.corporateusers', [
            'records' => $records
        ]);
    }
}
