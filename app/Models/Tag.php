<?php
namespace App\Models;

class Tag extends BaseModel {

    protected $table = 'tags';

    public function links()
    {
      return $this->belongsToMany(Link::class);
    }

}
