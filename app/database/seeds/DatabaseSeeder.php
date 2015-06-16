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
		// admin
		// $user = new User;
		// $user->username = 'admin';
		// $user->password = Hash::make('adminadmin');
		// $user->save();
		
		// Journalism Team
		// $user = new User;
		// $user->username = 'JournalismTeam';
		// $user->password = Hash::make('CommunicationArts');
		// $user->save();

		//guest
		//$user = new User;
		//$user->username = 'guest';
		//$user->password = Hash::make('guestuser');
		//$user->save();

		//test
		$user = new User;
		$user->username = 'user1';
		$user->password = Hash::make('password');
		$user->save();

	}
}
