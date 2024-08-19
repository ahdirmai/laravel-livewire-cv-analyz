<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cv extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
