<?php

class practice_controller extends base_controller {
	public function test1() {
		require(APP_PATH.'/libraries/Image.php');
		
		$imageObj= new Image('http://placekitten.com/1000/1000');	
		 
		$imageObj->resize(200,200);
		
		$imageObj->display();
	}	


	public function test2() {
	
	#Static
	echo Time::now();
	}
	
	public function test3() {
/*	# INSERT
	$q = "INSERT INTO users
	SET first_name = 'Albert', 
    last_name = 'Einstein',
    email = 'albert.einstein@gmail.com'";
    
    echo $q;
    
    # Run the command
	echo DB::instance(DB_NAME)->query($q);
------------------------
	#UPDATE
	$q = 'UPDATE users
	SET email = "albert@aol.com"
	WHERE first_name = "Albert"';
	
	# Run the command
	echo DB::instance(DB_NAME)->query($q);
------------------------
*/
	# INSERT METHOD
	$new_user= Array (
		'first_name' => 'Colette',
		'last_name' => 'Hyatt',
		'email'=> 'colette@gmail.com',
		);
		
	# Run the command
	echo DB::instance(DB_NAME)->insert('users',$new_user);
	}
}