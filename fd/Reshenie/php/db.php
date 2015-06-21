<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 20.06.2015
 * Time: 19:23
 */

class MyDb{

    protected $_dbName = 'notes.db';
    protected $_connection;

    public function __construct(){
        $this -> _connection = new PDO('sqlite:db/' . $this -> _dbName);

        $this -> _connection -> exec("CREATE TABLE IF NOT EXISTS notes(
					id INTEGER PRIMARY KEY,
                    text TEXT NOT NULL
					)");
    }

    public function saveNote($data){
        $text = $this -> _connection -> quote(htmlentities($data['text']));
        if($data['id']){
            $id = $this -> _connection -> quote($data['id']);
            $sql = "UPDATE notes SET text = $text WHERE id = $id";
            $result = $this->_connection->exec($sql);
        }else {
            $sql = "INSERT INTO notes(text) VALUES($text)";
            $result = $this->_connection->exec($sql);
        }
    }

    public function getNotes($id = false){
        $where = '';
        if($id){
            $id = $this -> _connection -> quote($id);
            $where = "WHERE id = $id";
        }
        $sql = "SELECT * FROM notes ". $where ."ORDER BY id DESC";
        $result = $this->_connection ->query($sql, PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteNote($id){
        $id = $this -> _connection -> quote($id);
        $sql = "DELETE FROM notes WHERE id = $id";
        $result = $this->_connection->exec($sql);
    }
}