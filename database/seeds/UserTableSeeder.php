<?php

use Illuminate\Database\Seeder;


// composer require laracasts/testdummy

use Laracasts\TestDummy\Factory as TestDummy;

use App\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
      DB:table('users')->delete();
      User::create(array(
        'name' => 'test',
        'email' => 'test@test.test',
        'password' => Hash::make('test')
      ));

        // TestDummy::times(20)->create('App\Post');
    }
}
