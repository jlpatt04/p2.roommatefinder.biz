<form method='POST' action='/users/p_signup'>

    First Name<br>
    <input type='text' name='first_name'>
    <br><br>

    Last Name<br>
    <input type='text' name='last_name'>
    <br><br>

    Email<br>
    <input type='text' name='email'>
    <br><br>

    <?php if(isset($error) && $error == 'emailResult'): ?>
        <div class='error'>
            *We already have a user registered with that email. Please sign in or use a different email.
        </div>
        <br>
    <?php endif; ?>

    Password<br>
    <input type='password' name='password'>
    <br><br>

    <input type='submit' value = 'Sign up'>

</form>

<?php if(isset($error) && $error == 'blank-field'): ?>
        <div class='error'>
            *All fields must be filled out.
        </div>
        <br>
    <?php endif; ?>

