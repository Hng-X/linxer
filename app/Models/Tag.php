<?php
//@quadri
namespace App\Models;

class Tag extends BaseModel {

    protected $table = 'tags';

    public function user()
    {
      return $this->belongsTo(Link::class);
    }

}
