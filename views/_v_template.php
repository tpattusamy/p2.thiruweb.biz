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
<div class="container">
    <header><a href="#"><img src="/images/sneakpeek1_r1_c1.gif" width="962" height="169" alt=""/></a></header>
    <div class="sidebar1">
        <nav>
            <?php if($user): ?>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/users/profile">Profile</a></li>
                <li><a href="/posts/add">New Post</a></li>
                <li><a href="/posts/index">All Posts</a></li>
                <li><a href="/posts/following">Friend's Posts</a></li>
                <li><a href="/posts/users">All users</a></li>
                <li><a href="/users/logout">Log Out</a></li>
            </ul>
            <?php else: ?>
            <ul>
                <li><a href='/'>Home</a></li>
                <li><a href='/users/signup'>Sign up</a></li>
                <li><a href='/users/login'>Log in</a></li>
            </ul>
            <?php endif; ?>
        </nav>
    </div>
    <article class="content">


	  <?php if(isset($content)) echo $content; ?>

	  <?php if(isset($client_files_body)) echo $client_files_body; ?>
    </article>



</div>

</body>
</html>