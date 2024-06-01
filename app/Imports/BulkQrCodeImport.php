<?php

namespace App\Imports;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Bulkqrcode;
use Log;
use DB;

class BulkQrCodeImport implements ToModel, WithHeadingRow
{

	public function __construct($input, $expiry_date)
	{
	    $this->input = $input;
	    $this->expiry_date = $expiry_date;
	}

	public $count = 0;
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        try{
        	$input = $this->input;
        	$expiry_date = $this->expiry_date;
        	$qr_code = $row['qrcode'];
        	$check = Bulkqrcode::where('qr_code', $qr_code)->first();
			if(!$check && $qr_code){
				$insert = ['qr_code' => $qr_code, 'activity_id' => $input['activity_id'], 'item_id' => $input['item_id'], 'option_id' => $input['option_id'], 'status' => $input['status'], 'qr_status' => 'pending', 'expiry_date' => $expiry_date];
				Bulkqrcode::insert($insert);
				$this->count++;
			}

        }catch(\Exception $e){
        	Log::info($e->getMessage().'__'.$e->getLine());
        }
    }
}
