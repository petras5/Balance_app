<?php

// Datoteku treba preimenovati u db.class.php

class DB
{
    private static $db = null;

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function getConnection()
    {
        if (DB::$db === null) {
            try {
                // Unesi ispravni HOSTNAME, DATABASE, USERNAME i PASSWORD
                DB::$db = new PDO('URL', 'username', 'password');
                DB::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit('PDO Error: ' . $e->getMessage());
            }
        }
        return DB::$db;
    }
}
