<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $prefixnames = ['Mr', 'Mrs', 'Ms'];
    public function run()
    {
        DB::table('users')->insert([
            'prefixname' => $this->prefixnames[rand(0,2)],
            'firstname' => Str::random(10),
            'middlename' => Str::random(10),
            'lastname' => Str::random(10),
            'suffixname' => Str::random(10),
            'username' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'type' => 'user'
        ]);
    }
}
