<article class="content">
<?php foreach($posts as $post): ?>
    <section class="message_box">
        <?php if($post['user_id']==$user->user_id):?>
                  <?php if($post['first_name']): ?>
                        <h3 align="center" class="post_header"><?=$user->first_name?> <?=$user->last_name?></h3>
                    <?php endif; ?>
                        <p class="post_message"><?=$post['content']?></p>
                        <p class="post_footer">
                            <a href='/posts/edit_post/<?=$post['post_id']?>'><img src="/images/edit_post.png" alt="EDIT POST" width="30" height="30"></a>
                            <a href='/posts/delete_post/<?=$post['post_id']?>'><img src="/images/delete_post.jpg" width="30" height="30" alt="DELETE POST"/></a>
                        </p>


        <?php else: ?>

                    <?php if($post['first_name']): ?>
                        <h3 align="center" class="post_header"><?=$post['first_name']?> <?=$post['last_name']?>:</h3>
                    <?php endif; ?>
            <p class="post_message"><?=$post['content']?></p>
        <?php endif; ?>


        <p class="post_footer">
            <time datetime="<?=Time::display($post['created'],'m/d/y g:i A')?>" >
                <?=Time::display($post['created'], 'm/d/y g:i A')?>
            </time>
    </section>
<?php endforeach; ?>
</article>