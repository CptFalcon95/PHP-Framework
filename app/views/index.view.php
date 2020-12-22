<?php require('partials/head.php'); ?>

<h1>Submit your name</h1>

<form action="/users" method="post">
    <input type="text" name="name">
    <button type="submit">Submit</button>
</form>

<?php require('partials/footer.php'); ?>