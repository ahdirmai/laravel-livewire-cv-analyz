<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GenerateHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // cv
    public function cv()
    {
        return $this->belongsTo(Cv::class, 'cv_id', 'id');
    }
}
