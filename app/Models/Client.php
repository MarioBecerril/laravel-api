<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


   /**
     *
     * Model Client {
     * id: number;
     * name: string;
     * username: string;
     * email: string;
     * website: string;
     * salary: number;
     * phone: string;
     * createdAt: Date;
     * updatedAt: Date;
     * }
     **/
class Client extends Model
{
    use HasFactory;

    protected $table = 'client';

    protected $fillable = [
        'name',
        'username',
        'email',
        'website',
        'salary',
        'phone'
    ];
}
