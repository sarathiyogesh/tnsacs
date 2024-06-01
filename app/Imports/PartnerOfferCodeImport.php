<?php

namespace App\Imports;
use App\Models\Partneroffercode;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class PartnerOfferCodeImport implements ToCollection
    {
       public function collection(Collection $rows)
       {
       }
    }