<?php

namespace db;

use PDO;

class DataSource
{

    private $connection = null;

    public function openConnection($user = 'root', $password = 'just1nnext', $host = '172.10.0.3', $port = '3306', $dbName = 'jin')
    {
        $dsn = "mysql:host={$host}; port={$port}; dbname={$dbName}";
        $this->connection = new PDO($dsn, $user, $password);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function closeConnection()
    {
        $this->connection = null;
    }

    private function executeSql($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * select文を実行する
     * $typeでクラスで返却するか連想配列で返却するか指定する
     * $classでmodel内のclassを指定し、modelの形式で返却する
     * @param string $sql 実行したいSQLのクエリを記載する
     * @param array $params SQL実行時、バインドするパラメータを配列形式で指定する
     * @param string $type 'cls'を引数にすることで、オブジェクト形式で返却する
     * @param string $class　modelのパスを指定し、modelの形式でオブジェクトを返却できるようにする
     * @return void
     */
    public function select($sql = "", $params = [], $type = "", $class = "")
    {
        $stmt = $this->executeSql($sql, $params);
        if ($type === 'cls') {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $class);
        } else {
            return $stmt->fetchAll();
        }
    }

    //insert,update,deleteは1つにまとめる

    public function insert($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
    }


    public function delete($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
    }


    public function update($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
    }


    /**
     * トランザクション処理
     * update処理の際は必ず記載する
     */

    //try内のupdate文の前に記載
    public function begin()
    {
        $this->connection->beginTransaction();
    }

    //try内のupdate文の後に記載
    public function commit()
    {
        $this->connection->commit();
    }

    //catch内に記載
    public function rollback()
    {
        $this->connection->rollBack();
    }
}
