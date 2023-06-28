<?php /** @var String $title */ ?>
<?php /** @var Array $new */ ?>

<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/news/update/<?= $new['id'] ?>" method="post">
    <?= csrf_field() ?>

    <label for="title">Title:</label>
    <input type="input" name="title" value="<?= $new['title'] ?>">
    <br>

    <label for="body">Text:</label><br>
    <textarea name="body" cols="45" rows="4"><?= $new['body'] ?></textarea>
    <br>

    <input type="submit" name="submit" value="Save changes">
</form>
