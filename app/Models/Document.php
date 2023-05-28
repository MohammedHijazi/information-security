<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'file_path','security_level'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }
}
