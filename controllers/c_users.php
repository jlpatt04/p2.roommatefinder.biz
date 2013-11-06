    <?php
    class users_controller extends base_controller {

        public function __construct() {
            parent::__construct();
            
        } 

        public function index() {
            echo "This is the index page";
        }

        public function signup($error = NULL) {
            
            # Setup view
                $this->template->content = View::instance('v_users_signup');
                $this->template->title   = "Sign Up";

            #Pass data to the view
                $this->template->content->error = $error;

            # Render template
                echo $this->template;
        }
        
        public function p_signup() {

            # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);

            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $q = "SELECT email FROM users WHERE email = '".$_POST['email']."'" ;

            $emailResult = DB::instance(DB_NAME)->select_field($q);  

             if(isset($emailResult)) {

                 Router::redirect("/users/signup/emailResult");
             }

            else if(empty($first_name) || empty($last_name) || empty($email) || empty($password)) {

                Router::redirect("/users/signup/blank-field");
            }

            else {
            #More data we want stored with the user
                $_POST['created'] = Time::now();
                $_POST['modified'] = Time::now();
             
             #Encrypt the password
                $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
             
             #Create an encrypted token via their email address and a random string
                $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

            #Insert this user into the database
                $user_id = DB::instance(DB_NAME)->insert('users',$_POST);
                
           	#Setup view
            $this->template->content = View::instance("v_users_p_signup");
            $this->template->title = "Account Created";
        
            #Render template
           	echo $this->template;
           }
        }

        public function login($error = NULL) {

            #Setup view
            $this->template->content = View::instance("v_users_login");
            $this->template->title = "Login";
            	
            #Pass data to view
            $this->template->content->error = $error;
            
            #CSS file for Login
            $client_files_head = Array('/css/login.css');

        	#Pass the date to the view
            $this->template->client_files_head = Utils::load_client_files($client_files_head);
            
            #Render template
            echo $this->template;
            
            
            
        }
        
        public function p_login() {
            # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);

            # Hash submitted password so we can compare it against one in the db
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

            # Search the db for this email and password
            # Retrieve the token if it's available
             $q = "SELECT token 
                FROM users 
                WHERE email = '".$_POST['email']."' 
                AND password = '".$_POST['password']."'";

            $token = DB::instance(DB_NAME)->select_field($q);   

            # If we didn't get a token back, it means login failed
            if(!$token) {

            # Send them back to the login page
            Router::redirect("/users/login/error");

            # But if we did, login succeeded! 
            } else {

            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token, strtotime('+2 weeks'), '/');

            # Send them to the main page - or whever you want them to go
            Router::redirect("/");
        

            }

        }
        
        
        public function logout() {
            #Generate and save a new token for next login
            $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

            # Create the data array we'll use with the update method
            # In this case, we're only updating one field, so our array only has one entry
            $data = Array("token" => $new_token);

            #Do the update
            DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

            #Delete their token cookie by setting it to a date in the past - effectively logging them out
            setcookie("token", "", strtotime('-1 year'), '/');

            #Send them back to the main index.
            Router::redirect("/");
        }


        public function profile($user_name = NULL) {
        
        	# If user is blank, they're not logged in; redirect them to the login page
        	if(!$this->user) {
            Router::redirect('/users/login');
        	}
     
            #Build query to select user's image
            $q='SELECT
                users.image
            FROM users
            WHERE user_id = '.$this->user->user_id;

            #Run the Query
            $data = DB::instance(DB_NAME)->select_row($q);

            #Build query to get user's posts
            $q= 'SELECT 
                posts.content,
                posts.created
            FROM posts
            WHERE user_id = '.$this->user->user_id .'
            ORDER BY posts.created DESC';

            #Run the query
            $posts = DB::instance(DB_NAME)->select_rows($q);

            #Set up view
            $this ->template->content= View::instance('v_users_profile');
            $this->template->title = "Profile";

            #Pass the data to the view
            $this->template->content->user_name=$user_name;
            $this->template->content->posts = $posts;
            $this->template->content->data =$data;

            #Display the view
            echo $this->template;
        }


        public function upload() {

            # Setup view
            $this->template->content = View::instance('v_users_upload');
            $this->template->title   = "Profile";

            # Render template
            echo $this->template;

       }

       public function p_upload() {

            #Save image as a string and update row in the database
            $image = Upload::upload($_FILES, "/uploads/profile/", array("jpg", "JPG", "jpeg", "JPEG","gif", "GIF","png", "PNG"), $this->user->user_id);
            
            
            $imageFileName = dirname(__FILE__).'/../uploads/profile/'.$image;
            
            /*
            #The image class is not working when I upload it to the live server.
            $imageObj = new Image($imageFileName);
            $imageObj->resize(150,150, "crop");
            $imageObj->save_image($imageFileName); 
            */

            $data=array("image"=>$image);
            $dbInstance = DB::instance(DB_NAME);
            $rows = $dbInstance->update("users", $data, "WHERE user_id = ".$this->user->user_id);

            #Send them back to the main index.
            Router::redirect("/users/profile");
        
       } 



    } # end of the class