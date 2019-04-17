<?php
//ActiveRecord.php

interface ActiveRecord {

    public static function find($id);
    public static function findAll();
    public function save();
    public function delete();

}
