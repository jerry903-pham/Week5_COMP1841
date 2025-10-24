<form action="" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="jokeid" value="<?= $joke['id'] ?>">

    <label for="joketext">Type your joke here:</label>
    <textarea id="joketext" name="joketext" rows="3" cols="40"><?= htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8') ?></textarea>

    <label for="authorid">Author:</label>
    <select name="authorid" id="authorid">
        <?php foreach ($authors as $author): ?>
            <option value="<?= $author['id'] ?>"
                <?php if ($author['id'] == $joke['authorid']): ?>
                    selected
                <?php endif; ?>
            >
                <?= htmlspecialchars($author['name'], ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if (!empty($joke['image'])): ?>
        <p>
            Current Image: 
            <img src="../week4/images/<?= htmlspecialchars($joke['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Current joke image" width="100"><br>
            
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($joke['image'], ENT_QUOTES, 'UTF-8') ?>">
            
            <input type="checkbox" name="remove_image" id="remove_image" value="yes">
            <label for="remove_image">Remove current image</label>
        </p>
    <?php else: ?>
        <input type="hidden" name="current_image" value="">
    <?php endif; ?>

    <label for="image">Upload a NEW image (Optional):</label>
    <input type="file" name="image" id="image">

    <input type="submit" name="submit" value="Edit Joke">

</form>