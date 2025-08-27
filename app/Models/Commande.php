<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
use HasFactory;

protected $fillable = ['photo_id', 'quantite', 'prix_total'];

public function photo()
{
return $this->belongsTo(Photo::class);
}
}