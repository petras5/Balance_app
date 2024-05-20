<?php
require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';

class UserService
{
    function verifyUser($username, $password)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_users WHERE username = :username');
        $st->execute(['username' => $username]);

        $row = $st->fetch();

        if ($row !== false) {
            $user = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email']);
            if (password_verify($password, $user->password_hash))
                return $user;
        }
        return false;
    }

    function getOverview()
    {
        $db = DB::getConnection();
        $st = $db->query('SELECT * FROM dz2_users');
        $users = [];

        while ($row = $st->fetch()) {
            $user = new User($row['id'], $row['username'], $row['password_hash'], $row['total_paid'], $row['total_debt'], $row['email']);
            $users[] = $user;
        }
        if (sizeof($users) === 0)
            return false;

        return $users;
    }

    function getUsername($id_user)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT username FROM dz2_users WHERE id = :id');
        $st->execute(['id' => $id_user]);
        $row = $st->fetch();
        if ($row !== false)
            return $row['username'];
        return false;
    }

    function getOverviewUser($id_user)
    {
        $transactions = [];
        $db = DB::getConnection();
        $st = $db->prepare('SELECT cost, description FROM dz2_expenses WHERE id_user = :id_user');
        $st->execute(['id_user' => $id_user]);

        while ($row = $st->fetch()) {
            $t = [$row['description'], +$row['cost']];
            $transactions[] = $t;
        }

        $st = $db->prepare('SELECT p.cost as cost, e.description as dsc FROM dz2_parts p JOIN dz2_expenses e ON p.id_expense = e.id WHERE p.id_user = :id_user');
        $st->execute(['id_user' => $id_user]);

        while ($row = $st->fetch()) {
            $t = [$row['dsc'], -$row['cost']];
            $transactions[] = $t;
        }

        if (sizeof($transactions) === 0)
            return false;

        return $transactions;
    }

    function getAllExpenses()
    {
        $expenses = [];
        $db = DB::getConnection();
        $st = $db->query('SELECT u.username as username, e.description as dsc, e.cost as cost FROM dz2_expenses e JOIN dz2_users u ON u.id = e.id_user ORDER BY e.date DESC');

        while ($row = $st->fetch()) {
            $expense = [$row['username'], $row['dsc'], $row['cost']];
            $expenses[] = $expense;
        }

        if (sizeof($expenses) === 0)
            return false;

        return $expenses;
    }

    function insertNewExpense($description, $cost, $ids_participants)
    {
        $db = DB::getConnection();
        $st = $db->prepare('INSERT INTO dz2_expenses (id_user, cost, description, date) VALUES (:id_user, :cost, :dsc, NOW())');
        if (!($st->execute(['id_user' => $_SESSION['user']->id, 'cost' => $cost, 'dsc' => $description])))
            return false;

        $id_expense = $db->lastInsertId();

        $numberOfParts = sizeof($ids_participants);
        if ($numberOfParts > 0) {
            $cost_part = $cost / $numberOfParts;

            $id_e = 0;
            $id_p = 0;
            $cost_p = 0;

            $st = $db->prepare('INSERT INTO dz2_parts (id_expense, id_user, cost) VALUES (:id_expense, :id_user, :cost_part)');
            $st->bindParam(':id_expense', $id_e);
            $st->bindParam(':id_user', $id_p);
            $st->bindParam(':cost_part', $cost_p);

            $id_e = $id_expense;
            $cost_p = $cost_part;

            for ($i = 0; $i < $numberOfParts; $i++) {
                $id_p = $ids_participants[$i];
                if (!$st->execute())
                    return false;
            }

            $st = $db->prepare('UPDATE dz2_users SET total_paid = total_paid + :cost WHERE id = :id');
            $st->bindParam(':cost', $cost);
            $st->bindParam(':id', $_SESSION['user']->id);

            if (!$st->execute())
                return false;

            foreach ($ids_participants as $i) {
                $st = $db->prepare('UPDATE dz2_users SET total_debt = total_debt + :cost WHERE id = :id');
                $st->bindParam(':cost', $cost_part);
                $st->bindParam(':id', $i);

                if (!$st->execute())
                    return false;
            }

            return true;
        }
        return false;
    }
}
