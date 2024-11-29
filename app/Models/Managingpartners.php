<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Managingpartners extends Model
{
    use HasFactory;

    // You can specify the table name if it's not the plural of the model name
    // protected $table = 'managing_partners';
    protected $table = 'managing_partners';

    // Define the fillable properties to protect mass-assignment vulnerabilities
    protected $fillable = ['name', 'description', 'heading', 'image'];
    
}
