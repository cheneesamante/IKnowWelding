<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTableSeeder extends Seeder 
{
    public function run() 
    {
        Model::unguard();
        DB::table('users')->delete();
        User::create(array(
            'name' => 'Chenee',
            'username' => 'cheneesam',
            'email' => 'asamante.tspi@gmail.com',
            'password' => Hash::make('admin++'))
             );
       
        User::create(array(
            'name' => 'Mich',
            'username' => 'michfacto',
            'email' => 'mfacto.tspi@gmail.com',
            'password' => Hash::make('admin++'))
        );
    }
}

