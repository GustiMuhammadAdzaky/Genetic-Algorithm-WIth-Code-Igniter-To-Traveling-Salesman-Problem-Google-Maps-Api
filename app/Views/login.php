<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <?php if (session()->getFlashdata('message')) : ?>
        <div><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>