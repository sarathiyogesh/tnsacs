<?php 
namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;


class Sitelog extends Model {
	protected $table = 'site_logs';

	public static function savelog($module,$module_type,$log_type,$log_msg,$table_id=0){
    try{
      if(Auth::check()){
        $created_by = Auth::id();
      }else{
        $created_by = 0;
      }
      $insert = new Sitelog();
      $insert->module = $module;
      $insert->module_type = $module_type;
      $insert->log_type = $log_type;
      $insert->log_message = $log_msg;
      $insert->created_by = $created_by;
      $insert->table_id = $table_id;
      $insert->save();
      return true;
    }catch(\Exception $e) {
      return false;
    }
  }


}
