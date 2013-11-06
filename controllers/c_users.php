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
        # Pass data to the view
        $this->template->content->error = $error;
        # Render template
        echo $this->template;

    }

    public function p_signup() {

        ## if the email has already been created, then alert the person signing up
        $email = $_POST['email'];
        $q = "SELECT user_id FROM users WHERE email = '".$email."'";
        $user_id = DB::instance(DB_NAME)->select_field($q);

        # Error code 2 indicates that user already exists
        if(isset($user_id)){
            Router::redirect('/users/signup/1');
        }

        # More data we want stored with the user
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Encrypt the password
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert("users", $_POST);

        # For now, just confirm they've signed up -
        # You should eventually make a proper View for this
        Router::redirect("/users/login/");

    }
    public function login($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";

        # Pass data to the view
        $this->template->content->error = $error;
        # Render template
        echo $this->template;

    }
    public function p_login() {

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        $q = "SELECT token
        FROM users
        WHERE email = '".$_POST['email']."'";


        $token1 = DB::instance(DB_NAME)->select_field($q);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token
        FROM users
        WHERE  password = '".$_POST['password']."'";

        $token2 = DB::instance(DB_NAME)->select_field($q);

        //echo "Token1=$token1";
        //echo "Token2=$token2";

        # If we didn't find a matching token in the database, it means login failed
        if($token1 and $token2){
            /*
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token1, strtotime('+2 weeks'), '/');

            # Send them to the main page - or whever you want them to go
            Router::redirect("/");
        } elseif(!$token1)
        {
            Router::redirect("/users/login/1");
        }
        else{
            Router::redirect("/users/login/2");
        }

    }

    public function edit_profile($user_id = NULL) {

        # Setup view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title   = $this->user->first_name." - Edit Profile";

        # Find the original post
        $q = "SELECT *
                FROM users
                WHERE user_id = '.$user_id'";

        # Select original post from the database
        $post = DB::instance(DB_NAME)->select_field($q);

        #Pass the post content to the view
        $this->template->content->post = $post;

        #Pass in post_id information
        $this->template->content->post_id = $post_id;

        # Render template
        echo $this->template;

    } # End of Method
    public function p_edit($post_id = NULL) {

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp to update when the field was modified
        $_POST['modified'] = Time::now();

        # Generation the where condition, where the post_id matches
        $where_condition = "WHERE posts.post_id = ".$post_id;

        # Edit the entry in the database
        DB::instance(DB_NAME)->update_row('posts', $_POST, $where_condition);

        # Send user to their list of personal posts
        Router::redirect('/users/profile');

    } # End of Method

    public function profile($error = NULL) {

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            Router::redirect('/users/login');
        }

        # Setup view
        $this->template->content = View::instance('v_users_profile');

        #Include user information
        $this->template->title   = $this->user->first_name." ".$this->user->last_name;
        $this->template->error = $error;

        //Following block is specific to importing the user's own posts to profile page

        # Build the query (same query as posts/personal/)
        $q = "SELECT posts.*
                    FROM posts
                    WHERE user_id = ".$this->user->user_id.
            " ORDER BY modified DESC";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        // END IMPORT BLOCK

        # Render template
        echo $this->template;

    } # End of Method
    public function logout() {

        # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");

    }

} # end of the class