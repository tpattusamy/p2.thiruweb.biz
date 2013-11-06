<?php foreach($users as $user): ?>

    <!-- Print this user's name -->
    <h3>
        <?=$user['first_name']?> <?=$user['last_name']?>
    </h3>
    <br>

    <!-- If there exists a connection with this user, show a unfollow link -->
    <div class="bold_text">
    <?php if(isset($connections[$user['user_id']])): ?>
        <a href='/posts/unfollow/<?=$user['user_id']?>'><img src="/images/unfollow.jpg" width="70" height="50" alt="Unfollow"/></a>

        <!-- Otherwise, show the follow link -->
    <?php else: ?>
        <a href='/posts/follow/<?=$user['user_id']?>'><img src="/images/twitter-follow.png" width="70" height="50" alt="Follow"/></a>
    <?php endif; ?>
    </div>

    <br><br>

<?php endforeach; ?>