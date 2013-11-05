<div class="page_content">
<form method='POST' action='/users/p_login'>


    <span class="text_style">Email</span><br>
    <input type='text' name='email'>

    <br><br>

    <span class="text_style">Password</span><br>
    <input type='password' name='password'>

    <br><br>

    <input type='submit' class="button_signup" value='Log in'>
    <br><br>
    <p>
    <?php if(isset($error)): ?>
        <?php
        switch($error) {
            case 1:
                echo "<div class='error'>";
                echo "Login failed. Please double check your email";
                echo "</div>";
                break;
            case 2:
                echo "<div class='error'>";
                echo "Login failed. Please double check your password";
                echo "</div>";
                break;
            default:
                break;
        }
        ?>

    <?php endif; ?>
    </p>
</form>
</div>