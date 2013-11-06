

<div>
            <?php if(isset($user)): ?>
                <h3 align="center" class="post_header"><?=$user->first_name?> <?=$user->last_name?></h3>
            <?php endif; ?>

    <article class="content">
            <?php if(isset($posts)): ?>
                 <?php foreach($posts as $post): ?>
                        <section class="message_box">
                            <p class="post_message"><?=$post['content']?></p>
                            <p class="post_footer">
                                <a href='/posts/edit_post/<?=$post['post_id']?>'><img src="/images/edit_post.png" alt="EDIT POST" width="30" height="30"></a>
                                <a href='/posts/delete_post/<?=$post['post_id']?>'><img src="/images/delete_post.jpg" width="30" height="30" alt="DELETE POST"/></a>
                            </p>
                            <p class="post_footer">
                                <time datetime="<?=Time::display($post['created'],'m/d/y g:i A')?>" >
                                    <?=Time::display($post['created'], 'm/d/y g:i A')?>
                                </time>
                            </p>

                        </section>

                 <?php endforeach; ?>
            <?php endif; ?>
     </article>

</div>
