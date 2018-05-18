<?php
function createUser(array $data)
{
    return \App\User::create([
        'name' => $data['name'],
        'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
    ]);
}