<?php 
namespace App\Services\Common;

class SqlCommon {
    public static function INSERT($table, $data)
    {
        $sql = "INSERT INTO $table (Id, ";
        $sql .= implode(", ", array_keys($data)) . ") VALUES (UUID(), ";
        $sql .= "'" . implode("', '", array_values($data)) . "')";
        return $sql;
    }

    public static function UPDATE($table, $data, $id) {
        $sql = "UPDATE $table SET ";
        $sql .= implode(" = ?, ", array_keys($data)) . " = ? ";
        $sql .= "WHERE id = $id";
        return $sql;
    }
    public static function DELETE($table, $id) {
        $sql = "DELETE FROM $table WHERE id = $id";
        return $sql;
    }
    public static function SELECT($table) {
        $sql = "SELECT * FROM $table";
        return $sql;
    }
    public static function SELECT_CONDITION($table, $condition) {
        $sql = "SELECT * FROM $table";
        $sql .= "$condition";
        return $sql;
    }
}