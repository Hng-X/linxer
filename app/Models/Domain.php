<?php
//@quadri
namespace App\Models;

class Domain extends BaseModel {

    protected $table = 'domain';

    public function user()
    {
      return $this->hasMany(Link::class);
    }

}
