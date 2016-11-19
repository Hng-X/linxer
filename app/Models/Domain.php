<?php
//@quadri
namespace App\Models;

class Domain extends BaseModel {

    protected $table = 'domain';

    public function tags()
    {
      return $this->hasMany(Link::class);
    }

}
