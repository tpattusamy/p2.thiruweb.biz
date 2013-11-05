<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="/css/peek_style.css" rel="stylesheet" type="text/css">
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>
<div id="wrap">
   <p><img src="/images/sneakpeek1_r1_c1.gif" width="1024" height="232"  alt=""/></p>

    <div id='menu'>


        <!-- Menu for users who are logged in -->
        <?php if($user): ?>

            <ul>
                <li>
                    <a href='/'>Home</a>
                </li>
                <li>
                    <a href='/users/profile'>Profile</a>
                </li>
                <li>
                    <a href='/posts/add'>New Post</a>
                </li>
                <li>
                    <a href='/posts/index'>All Posts</a>
                </li>
                <li>
                    <a href='/posts/following'>Friends' Posts</a>
                </li>
                <li>
                    <a href='/posts/users'>All Users</a>
                </li>
                <li>
                    <a href='/users/logout'>Logout</a>
                </li>
            </ul>

            <!-- Menu options for users who are not logged in -->
        <?php else: ?>
            <ul>
                <li>
                    <a href='/'>Home</a>
                </li>
                <li>
                    <a href='/users/signup'>Sign up</a>
                </li>
                <li>
                    <a href='/users/login'>Log in</a>
                </li>
            </ul>
        <?php endif; ?>

    </div>
	<p>
	  <?php if(isset($content)) echo $content; ?>
	  
	  <?php if(isset($client_files_body)) echo $client_files_body; ?>
</p>
</div>	
</body>
</html>