<?php require_once __DIR__ . '/_header.php'; ?>

<?php
if (!empty($this->message)) {
    echo '<h3>' . $this->message . '</h3><br>';
    exit();
}
?>

<table>
    <?php
    if ($expenses) {
        foreach ($expenses as $e) {
            echo '<tr>';
            echo '<td style="font-weight:bold;">' . $e[0] . '</td>';
            echo '<td>' . $e[1] . '</td>';
            echo '<td>' . $e[2] . ' € </td>';
            echo '</tr>';
        }
    }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>