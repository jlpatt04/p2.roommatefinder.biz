<?php foreach($posts as $post): ?>

<article>

    <h2><?php echo $post['first_name']?> <?php echo $post['last_name']?> posted:</h2>

    <p><?php echo $post['content']?></p>

    <time datetime="<?php echo Time::display($post['created'],'Y-m-d G:i')?>">
        <?php echo Time::display($post['created'])?>
    </time>

	<? if(isset($like[$post['post_id']])): ?>
	<a href='/posts/unlike/<?=$post['post_id']?>'>unLike</a>

	<? else: ?>
	<a href='/posts/like/<?=$post['post_id']?>'>Like</a>
	<? endif; ?>


</article>

<br/>

<?php endforeach; ?>