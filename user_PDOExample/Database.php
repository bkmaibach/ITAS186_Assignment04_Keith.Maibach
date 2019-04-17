<?php
// Database.php

class Database {

       /** @var PDO connection object */
    private static $connection;

    /** Constructor */
    private function __construct() {}  // Prevent instantiation

    /**
     * Open a connection to the database.
     *
     * @return PDO connection object
     */
    public static function connectSimple() {
        try {
            return new PDO("mysql:host=localhost;dbname=user",
                "root", "");
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * A better connection method using a Singleton:
     * Ensures that only one connection can exist at a
     * time, to save server memory & resources.
     *
     * Not a good solution for threaded applications.
     *
     * @return PDO connection object
     */
    public static function connect() {

        if (!self::$connection) {
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=user",
                    "root", "");
                // this is important to have the DB show errors!!
                //
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                exit();
            }
        }
        return self::$connection;
    }

}