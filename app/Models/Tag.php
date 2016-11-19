<?php
namespace App\Models;

class Tag extends BaseModel {

    protected $table = 'tags';

    public function link()
    {
      return $this->belongsTo(Link::class);
    }

}
