<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('UsersTableSeeder');
	}

}

class UsersTableSeeder extends Seeder {
	public function run(){
		$user = new User;
		$user->username = 'admin';
		$user->password = Hash::make('adminadmin');
		$user->save();
	}
}
