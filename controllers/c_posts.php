<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Delma
 * Date: 11/5/13
 * Time: 6:50 AM
 * To change this template use File | Settings | File Templates.
 */
class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            Router::redirect('/users/login');
        }
    }

    public function add($error = NULL) {

        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = "New Post";

        #Pass in any error information
        $this->template->content->error = $error;

        # Render template
        echo $this->template;

    }

    public function p_add() {

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Have user try again if their post content was empty.
        if (strlen($_POST['content'])<1) {
            Router::redirect('/posts/add/error');
        }


        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Send user to their list of personal posts
        Router::redirect('/users/profile');


    }
    public function edit_post($post_id = NULL) {

        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = $this->user->first_name." - Edit Post";

        # Find the original post
        $q = "SELECT posts.content
                FROM posts
                WHERE post_id = ".$post_id;

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

    public function delete_post($post_id = NULL){

        # Configure where condition so that post_id is matched
        $where_condition = "WHERE posts.post_id = ".$post_id;

        # Delete desired entry from the posts table
        DB::instance(DB_NAME)->delete('posts', $where_condition);

        # Reroute user back to his profile page

        Router::redirect('/users/profile');
    } # End of Method

    public function index() {

        # Set up the View
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = "Posts";

        # Build the query
        $q = "SELECT
            posts .* ,
            users.first_name,
            users.last_name
        FROM posts
        INNER JOIN users
            ON posts.user_id = users.user_id";

        # Run the query
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;

    }
    public function following() {

        # Set up the View
        $this->template->content = View::instance('v_posts_index');
        $this->template->title   = "All Posts";

        # Query
        $q = 'SELECT
            posts.content,
            posts.created,
            posts.user_id AS post_user_id,
            users_users.user_id AS follower_id,
            users.first_name,
            users.last_name
        FROM posts
        INNER JOIN users_users
            ON posts.user_id = users_users.user_id_followed
        INNER JOIN users
            ON posts.user_id = users.user_id
        WHERE users_users.user_id = '.$this->user->user_id;

        # Run the query, store the results in the variable $posts
        $posts = DB::instance(DB_NAME)->select_rows($q);

        # Pass data to the View
        $this->template->content->posts = $posts;

        # Render the View
        echo $this->template;

    }
    public function users() {

        # Set up the View
        $this->template->content = View::instance("v_posts_users");
        $this->template->title   = "Users";

        # Build the query to get all the users
        $q = "SELECT *
        FROM users";

        # Execute the query to get all the users.
        # Store the result array in the variable $users
        $users = DB::instance(DB_NAME)->select_rows($q);

        # Build the query to figure out what connections does this user already have?
        # I.e. who are they following
        $q = "SELECT *
        FROM users_users
        WHERE user_id = ".$this->user->user_id;

        # Execute this query with the select_array method
        # select_array will return our results in an array and use the "users_id_followed" field as the index.
        # This will come in handy when we get to the view
        # Store our results (an array) in the variable $connections
        $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

        # Pass data (users and connections) to the view
        $this->template->content->users       = $users;
        $this->template->content->connections = $connections;

        # Render the view
        echo $this->template;
    }
    public function follow($user_id_followed) {

        # Prepare the data array to be inserted
        $data = Array(
            "created" => Time::now(),
            "user_id" => $this->user->user_id,
            "user_id_followed" => $user_id_followed
        );

        # Do the insert
        DB::instance(DB_NAME)->insert('users_users', $data);

        # Send them back
        Router::redirect("/posts/users");

    }

    public function unfollow($user_id_followed) {

        # Delete this connection
        $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
        DB::instance(DB_NAME)->delete('users_users', $where_condition);

        # Send them back
        Router::redirect("/posts/users");

    }

}