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

    public static function UPDATE($table, $data, $id)
    {
        $sql = "UPDATE $table SET ";
        $setStatements = array();

        foreach ($data as $key => $value) {
            $setStatements[] = "$key = '$value'";
        }

        $sql .= implode(", ", $setStatements);
        $sql .= " WHERE Id = '$id'";

        return $sql;
    }


    public static function DELETE($table, $id) {
        $sql = "DELETE FROM $table WHERE Id = '$id'";
        return $sql;
    }
    public static function SELECT($table) {
        $sql = "SELECT * FROM $table";
        return $sql;
    }
    public static function SELECT_CONDITION($table, $condition) {
        $sql = "SELECT * FROM $table";
        $sql .= " $condition";
        return $sql;
    }
    // limit
    public static function SELECT_LIMIT($table, $offset, $pageSize) {
        $sql = "SELECT * FROM $table LIMIT $offset, $pageSize";
        return $sql;
    }
}