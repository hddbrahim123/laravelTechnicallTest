<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['Title' , 'subtitle' , 'summary' , 'keywords' , 'user_id'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function file(){
        return $this->hasOne(File::class);
    }
}
