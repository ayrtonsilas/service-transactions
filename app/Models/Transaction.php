<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $fillable = ['payer', 'payee', 'value'];
    
    public function payer(){
        return $this->hasOne(User::class, 'id', 'payer')->first();
    }

    public function payee(){
        return $this->hasOne(User::class, 'id', 'payee')->first();
    }
}
