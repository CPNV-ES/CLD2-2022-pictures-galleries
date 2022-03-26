<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path',
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
