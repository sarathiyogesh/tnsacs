<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class Customfieldsection extends Model 
{
	protected $table = 'custom_fields_section';

	public static function section_name($section_id){
		$record = Customfieldsection::find($section_id);
		if($record){
			return $record->section_name;
		}
		return '';
	}

}