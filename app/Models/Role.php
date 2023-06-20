<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = ['name'];

    /**
     * Get the user associated with the roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
    */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
