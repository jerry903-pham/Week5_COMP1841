<?php foreach($jokes as $joke): ?>
    <blockquote>
    <?=htmlspecialchars($joke['joketext'], ENT_QUOTES,'UTF-8')?>
    <small>Posted on: <?= htmlspecialchars($joke['jokedate'], ENT_QUOTES, 'UTF-8') ?></small><br>
    <?php if (!empty($joke['image'])): ?>
        <img src="../week4/images/<?= htmlspecialchars($joke['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Joke image" width="200">
    <?php endif; ?>
    
    <form action="deletejoke.php" method="post">
        <input type="hidden" name="id" value="<?=$joke['id']?>">
        <input type="submit" value="Delete">
    </form>
    </blockquote>
    <?php endforeach?>