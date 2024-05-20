<?php require_once __DIR__ . '/_header.php'; ?>

<?php
if (!empty($this->message)) {
    echo '<h3>' . $this->message . '</h3><br>';
    exit();
}
?>

<table>
    <form action="balance.php?rt=users/newExpense" method="post">
        <tr>
            <br>
            <label> Description </label>
            <input type="text" id="dsc" name="dsc"><br><br>
        </tr>
        <tr>
            <label> Cost in € </label>
            <input type="text" id="cost" name="cost"><br><br>
        </tr>
        <?php
        if ($users) {
            echo '<tr>';
            echo '<label> For </label>';
            echo '<br>';
            foreach ($users as $u) {
                echo '<input type="checkbox" name="id_p' . $u->id . '" value="' . $u->id . '">';
                echo '<label>' . $u->username . '</label><br>';
            }
            echo '</tr>';
        }
        ?>
        <button type="submit">Add new expense!</button>
    </form>
</table>
<?php require_once __DIR__ . '/_footer.php'; ?>