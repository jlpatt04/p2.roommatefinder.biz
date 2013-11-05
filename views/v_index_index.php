
<!DOCTYPE html>
<html>
<head>
<h1>Welcome to <?php echo APP_NAME;?><?php if($user) echo ', '.$user->first_name; ?></h1>
</head>

<body>
<?php if($user): ?>
<img src="/css/chatting.jpg" alt="People Chatting" width="400px" height="300px">
<p> What are you going to chat about today? </p>

<?php else: ?>
<p> Please login or signup to use Chitty Chat so you start chatting about the things that matter most in your life :) </p>
<h3><a href="/users/login">Login</a></h3>
<h3><a href="/users/signup">Signup</a></h3>

<?php endif; ?>

</body>
</html>





