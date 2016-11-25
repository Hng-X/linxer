<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http;

class BaseModel extends Model {
	use SoftDeletes;

	//add a date column
	//protected $dates = ['deleted_at'];


    public function selectQuery($sql_stmt) {
        return DB::select($sql_stmt);
    }

    public function sqlStatement($sql_stmt) {
        return DB::statement($sql_stmt);
    }
}
