<?php

require_once __DIR__ . '/../model/userService.class.php';

class UsersController
{
    public $message = "";
    function index()
    {
        $us = new UserService();
        $users = $us->getOverview();

        if (!$users)
            $this->message = "There is no data about users balaces.";

        require_once __DIR__ . '/../view/home.php';
    }

    function history()
    {
        if (isset($_GET['id_user'])) {
            $id_user = $_GET['id_user'];
            $us = new UserService();
            $username = $us->getUsername($id_user);
            if (!$username) {
                $this->message = "There is no user with id = " . $id_user;
            } else {
                $transactions = $us->getOverviewUser($id_user);
                if (!$transactions) {
                    $this->message = "User " . $username . "has no transactions";
                }
            }
        } else {
            $this->message = "Needed id in URL for user.";
        }
        require_once __DIR__ . '/../view/overview_user.php';
    }

    function expenses()
    {
        $us = new UserService();
        $expenses = $us->getAllExpenses();
        if (!$expenses) {
            $this->message = "There is no expenses.";
        }
        require_once __DIR__ . '/../view/expenses.php';
    }

    function newExpense()
    {
        $us = new UserService();
        $users = $us->getOverview();
        $ids_participants = [];
        $ids_participants[] = $_SESSION['user']->id; // osigurava da je trenutni korisnik dio racuna i ako se ne oznaci

        if (!empty($_POST['dsc']) and !empty($_POST['cost'])) {
            foreach ($users as $u) {
                if ($u->id === $_SESSION['user']->id)
                    continue;
                $name = 'id_p' . $u->id;
                if (isset($_POST[$name]) and $_POST[$name] === (string)$u->id)
                    $ids_participants[] = $u->id;
            }

            $expense_inserted = $us->insertNewExpense($_POST['dsc'], (int)$_POST['cost'], $ids_participants);
            if ($expense_inserted) {
                $expenses = $us->getAllExpenses();
                header('Location: balance.php?rt=users/expenses');
            } else {
                $this->message = "The input of form didn't succeed. Try again. ";
                require_once __DIR__ . '/../view/newExpense_form.php';
            }
        } else {
            require_once __DIR__ . '/../view/newExpense_form.php';
        }
    }

    function settleUp()
    {
        $us = new UserService();
        $users = $us->getOverview();
        $array_balances = [];
        $balances = [];
        if ($users) {
            foreach ($users as $u) {
                $balance = $u->total_paid - $u->total_debt;
                $balances[] = [$balance];
                $array_balances[] = [$u->username, $balance];
            }
            array_multisort($balances, SORT_ASC, $array_balances);
        } else {
            $this->message = 'There is no users.';
        }
        require_once __DIR__ . '/../view/settleUp.php';
    }
}
