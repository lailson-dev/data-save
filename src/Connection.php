<?php

namespace AcarajeTech\OnSave;

use PDO;
use PDOException;

class Connection
{
    private static $instance;
    private static $error;

    public static function getInstance(): ?PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(DRIVER.':host='.DBHOST.';dbname='.DBNAME.';port='.DBPORT.';charset='.DBCHARSET, DBUSER, DBPASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $exception) {
                self::$error = $exception;
                return null;
            }
        }

        return self::$instance;
    }

    public static function getError()
    {
        return self::$error;
    }

}