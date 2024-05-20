<?php require_once __DIR__ . '/_header.php'; ?>

<?php
if (!empty($this->message)) {
    echo '<h3>' . $this->message . '</h3><br>';
    exit();
}
?>

<table>
    <?php
    if ($users) {
        foreach ($users as $u) {
            echo '<tr>';
            echo '<td><a href="balance.php?rt=users/history&id_user=' . $u->id . '">' . $u->username . '</a></td>';
            $balance = $u->total_paid - $u->total_debt;
            echo '<td>' . $balance . ' € </td>';
            echo '</tr>';
        }
    }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>