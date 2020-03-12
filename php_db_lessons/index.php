<?php
define('DB_DATABASE', 'dotinstall_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'vader60');
define('PDO_DSN', 'mysql:host=localhost;dbname='. DB_DATABASE);

class User
{
    // public $id;
    // public $name;
    // public $score;
    public function show()
    {
        echo "$this->name ($this->score)";
    }
}

try {
    //code...
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //insert
    //bindValue
    //bindParam
    /**
     * exec() 結果を返さない、安全なSQL
     * query() 結果を返す、安全なSQL、何回も実行されないSQL
     * prepare() 結果を返す、安全対策が必要、複数回実行されるSQL
     */
    // $stmt =  $db->query('select * from users;');

    // $stmt = $db->prepare("insert into users (name,score) values (?,?)");
    // $stmt->execute(["kameda",44]);
    // $stmt = $db->prepare("insert into users (name,score) values (:name,:score)");
    // $stmt->execute([":name"=>"fkoji","score"=>80]);
    // $name = 'kameda';
    // $stmt->bindValue(1, $name, PDO::PARAM_STR);
    // $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    // $score = 23;
    // $stmt->bindValue(2, $score, PDO::PARAM_INT);
    // $stmt->execute();
    // // $score = 44;
    // $stmt->bindValue(2, $score, PDO::PARAM_INT);
    // $stmt->execute();
    // $stmt->bindParam(2, $score, PDO::PARAM_INT);
    // $score = 52;
    // $stmt->execute();
    // $score = 42;
    // $stmt->execute();
    // echo "inserted:" . $db->lastInsertId();

    //select
    //PDO::FETCH_CLASS
    // $stmt = $db->prepare("select * from users");
    // $stmt->execute();
    // $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');//keyと名前を返す。
    // foreach ($users as $user) {
    //     # code...
    //     $user->show();
    // }

    //update
    // $stmt = $db->prepare("update users set score = :score where name = :name");
    // $stmt->execute([
    //     ':score' => 100,
    //     ':name' => 'kameda',
    // ]);
    // echo "row updated:" . $stmt->rowCount();

    //delete
    // $stmt = $db->prepare("delete from users where name = :name");
    // $stmt->execute([
    //     ':name' => 'fkoji'
    // ]);
    // echo "row deleted:" . $stmt->rowCount();

    // $stmt->rowCount() . "records found.";

    //transaction
    $db->beginTransaction();
    $db->exec("update users set score = score - 10 where name = 'kameda'");
    $db->exec("update users set score = score + 10 where name = 'fkoji'");

    $db->commit();
    //disconnect
    $db = null;
} catch (PDOexception $e) {
    $db->rollback();
    //throw $th;
    echo $e->getMessage();
    exit;
}
?>
