<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model{
    public $timestamps = false;
    protected $fillable = ['artist_id','artist', 'album_name', 'year'];
}
