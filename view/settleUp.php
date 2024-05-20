<?php require_once __DIR__ . '/_header.php'; ?>

<?php
if (!empty($this->message)) {
    echo '<h3>' . $this->message . '</h3><br>';
    exit();
}
?>

<table>
    <?php
    while (sizeof($array_balances) > 0) {
        $length = sizeof($array_balances);
        $max = $array_balances[$length - 1][1];
        $min = $array_balances[0][1];

        if ($max <= - ($min)) {
            $gift = $max;
        } else {
            $gift = -$min;
        }
        $min += $gift;
        $max -= $gift;

        $array_balances[0][1] = $min;
        $array_balances[$length - 1][1] = $max;

        echo '<tr><td>(' . $array_balances[$length - 1][0] . ', ' . $array_balances[0][0] . ', ' . $gift . ' €)<td>'
            . '<td> ' . $array_balances[$length - 1][0] . ' needs to give ' . $array_balances[0][0] . ' ' . $gift . ' €. </tr>';
        if ($max === 0)
            array_pop($array_balances);
        if ($min === 0)
            array_shift($array_balances);
    }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>