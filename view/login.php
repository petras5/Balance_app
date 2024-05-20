<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="./view/login.css">
</head>

<body>
    <form action="balance.php?rt=login/index" method="post">
        <h2>BALANCE LOGIN</h2>
        <h3> <?php echo $this->message; ?></h3>
        <label>User Name</label>
        <input type="text" name="username" placeholder="User Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>
    </form>
</body>

</html>