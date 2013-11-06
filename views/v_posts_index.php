<article class="content">
<?php foreach($posts as $post): ?>
        <?php if($post['user_id']==$user->user_id):?>
                  <?php if($post['first_name']): ?>
                        <h4><?=$post['first_name']?> <?=$post['last_name']?>:</h4>
                    <?php endif; ?>
                    <blockquote><?=$post['content']?></blockquote>
                    <br><br>
                    <a href = '/posts/edit_post/<?=$post['post_id']?>' >Edit Post</a>

                    <br><br>
                    <a href = '/posts/delete_post/<?=$post['post_id']?>' >Delete Post</i></a>
                </div>
            </div>

        <?php else: ?>

                    <?php if($post['first_name']): ?>
                        <h4><?=$post['first_name']?> <?=$post['last_name']?>:</h4>
                    <?php endif; ?>
                    <blockquote class = "other_user"><?=$post['content']?></blockquote>

        <?php endif; ?>


        <time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
            <?=Time::display($post['created'])?>
        </time>

<?php endforeach; ?>
</article>