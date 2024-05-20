<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link rel="stylesheet" href="./view/balance.css">
</head>

<body>
    <div class="header">
        <div class="title">
            <h1>Balance</h1>
            <h2>Hello, <?php echo htmlentities($_SESSION['user']->username); ?></h2>
        </div>
        <ul>
            <li><a class="active" href="balance.php?rt=users/index">Overview(<?php echo htmlentities($username); ?>)</a></li>
            <li><a href="balance.php?rt=users/expenses">Expenses</a></li>
            <li><a href="balance.php?rt=users/newExpense">New expense</a></li>
            <li><a href="balance.php?rt=users/settleUp">Settle up!</a></li>
            <li><a href="balance.php?rt=login/logout">Logout</a></li>
        </ul>
    </div>
    <?php
    if (!empty($this->message)) {
        echo '<h3>' . $this->message . '. </h3><br>';
        exit();
    }
    ?>
</body>

</html>

<table>
    <?php
    $total = 0;
    if ($transactions) {
        foreach ($transactions as $t) {
            echo '<tr>';
            echo '<td>' . $t[0] . '</td>';
            echo '<td>' . $t[1] . ' € </td>';
            $total += $t[1];
            echo '</tr>';
        }
        echo '<tr class="total">';
        echo '<td class="total">Total</td>';
        echo '<td class="total">' . $total . ' € </td>';
        echo '</tr>';
    }
    ?>
</table>
<?php require_once __DIR__ . '/_footer.php'; ?>