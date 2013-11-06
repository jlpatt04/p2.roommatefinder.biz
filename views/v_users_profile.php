<?php
 $imageFileName = $data["image"];
 $imageFileName = "/uploads/profile/".$imageFileName;
 echo "<img src='".$imageFileName."' width=\"150\" height=\"150\">"; ?>
 
 
<p><a href="/users/upload">Upload/Change Image</a></p>

<h1><?php echo $user->first_name?>'s Posts</h1>

<?php echo $posts->content?> 

<?php foreach($posts as $post): ?>


<article>

    <p><?php echo $post['content']?></p>

    <time datetime="<?php echo Time::display($post['created'],'Y-m-d G:i')?>">
        <?php echo Time::display($post['created'])?>
    </time>
	
</article>
<br/>

<?php endforeach; ?>