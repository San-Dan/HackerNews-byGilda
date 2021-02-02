<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

$statement = $database->prepare('SELECT COUNT(upvotes.post_id) as votes, posts.id, posts.title, posts.url, posts.description, posts.published, posts.user_id, users.name
FROM upvotes
INNER JOIN posts
ON upvotes.post_id = posts.id
INNER JOIN users
ON posts.user_id = users.id
GROUP BY upvotes.post_id
ORDER BY votes DESC');
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<article class="content-post">
<?php if (isset($_SESSION['user'])) : ?>
        <h2>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h2>
    <?php endif; ?>

<button class="new-btn"><a href="/">New</a></button>
        <button class="upvoted-btn active">Most upvoted</button>


<ol>
    <?php foreach ($posts as $post) : ?>
        <?php if (isset($_SESSION['user'])) {
            $post_id = $post['id'];
            $user_id = $_SESSION['user']['id'];

            $statement = $database->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
            $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();
            $upvote = $statement->fetch();
        }
    ?>

<li>
<?php if (isset($_SESSION['user'])) : ?>
<button data-url="<?= $post['id']; ?>" class="upvote-btn
<?php if (isset($_SESSION['user'])) : ?>
<?php if ($upvote !== false) : ?>
upvote-btn-darker
<?php endif; ?>
<?php endif; ?>">
        
</button>
<?php endif; ?>
    <a href="<?= $post['url']; ?>" class="list-item-title">
    <?= $post['title']; ?>
    </a>
    </li>

<div class="subtext">
<p>
<?= convertTime(strtotime($post['published'])); ?> ago.

</p>
<p> <?= $post['name']; ?> </p>

<?php $upvotes = countUpvotes($database, $post['id']); ?>
<?php $numberOfComments = countComments($database, $post['id']); ?>

<div>
    <?php if ($upvotes == 1) : ?>
    <span class="number-of-votes" data-url="<?= $post['id']; ?>">
    <?= $upvotes; ?> vote
    </span>
    <?php else : ?>
    <span class="number-of-votes" data-url="<?= $post['id']; ?>">
    <?= $upvotes; ?> votes 
    </span>
    <?php endif; ?>
    
</div>
</div>

    <?php endforeach; ?>
 </ol>



</article>
        


<?php require __DIR__ . '/views/footer.php'; ?>