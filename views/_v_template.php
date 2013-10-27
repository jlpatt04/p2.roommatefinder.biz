<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
	<link href="/css/images/main.css" rel="stylesheet" typ="text/css">
	
</head>

<body>	



        <!-- Menu for users who are logged in -->
        <?php if($user): ?>

				
<div id='cssmenu'>
<ul>
   <li class='active'><a href='/'><span>Home</span></a></li>
   <li><a href='/users/profile'><span>Profile</span></a></li>
   <li><a href='/posts/users'><span>View Users</span></a></li>
  <li><a href='/posts/index'><span>View Posts</span></a></li>
   <li><a href='/posts/add'><span>Post</span></a></li>
   <li class='last'><a href='/users/logout'><span>Logout</span></a></li>
</ul>
</div>
           
    

        <!-- Menu options for users who are not logged in -->
        <?php else: ?>

            <div id='cssmenu'>
<ul>
   <li class='active'><a href='/'><span>Home</span></a></li>
   <li><a href='/users/signup'><span>Sign Up</span></a></li>
   <li class='last'><a href='/users/login'><span>Login</span></a></li>
</ul>
</div>

        <?php endif; ?>

    </div>

    <br>
    <br>

    <?php if(isset($content)) echo $content; ?>
    
</body>
</html>