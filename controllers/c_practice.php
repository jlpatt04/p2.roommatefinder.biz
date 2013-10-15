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
	# Our SQL command
	$q = "INSERT INTO users SET 
    first_name = 'Sam', 
    last_name = 'Seaborn',
    email = 'seaborn@whitehouse.gov'";

	# Run the command
	echo DB::instance(DB_NAME)->query($q);
	
	}
}