<?php
//@quadri
namespace App\Models;

class Link extends BaseModel {

    protected $table = 'links';

    public function user()
    {
      return $this->belongsTo(Domain::class);
    }

}
