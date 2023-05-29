<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['category_id','brand_id','name','originalPrice','sellingPrice','prSection','colour','qty','size','image','description','popular','featured','status'];
}
