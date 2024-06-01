<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class Customfield extends Model 
{
	protected $table = 'custom_fields';

	public function scopePage($query,$page_id){
    	return $query->where('asset_master_id', $page_id);
    }

    public function scopeSection($query,$section_id){
    	return $query->where('custom_fields_section_id', $section_id);
    }

    public static function section_name($section_id){
		$record = Customfieldsection::find($section_id);
		if($record){
			return $record->section_name;
		}
		return '';
	}

}
