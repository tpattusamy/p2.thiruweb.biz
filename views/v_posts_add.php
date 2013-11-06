<!-- Error handling if a user tried to submit an empty post -->
<?php if(isset($error)): ?>
    <div class='error' align = "center">
        Cannot submit empty post! Please try again.
        <br><br>
    </div>
<?php endif; ?>

<?php if(isset($post_id)): ?>
<form method='POST' action='/posts/p_edit/<?=$post_id?>'>
    <?php else: ?>
    <form method='POST' action='/posts/p_add'>
<?php endif; ?>


    <label for='content'>Add/Edit Post:</label><br>
    <textarea name='content'  id='content' placeholder="Speak from Heart!"><?php if(isset($post_id)): ?><?=$post?><?php endif; ?></textarea>

    <br><br>
    <input type='submit' value='Post'>

</form> 