<?php

namespace db;

use PDO;
use db\DataSource;
use model\GamaModel;

class GameQuery
{
    /**
     * $resultCodeにより、BETの分配を行うメソッド
     * 分配のルール
     * $resultCode:[1]  プレイヤーのBET * 3 をCREDITに追加し BETを0でUPDATE
     * $resultCode:[2]  プレイヤーのBET を CREDIT に追加し BETを0でUPDATE
     * $resultCode:[3]  プレイヤーのBETを0でUPDATE
     * $resultCode:[4]  プレイヤーのBET / 2 をCREDITに追加し BETを0でUPDATE
     * $resultCode:[99] 例外終了のためrollback
     * @param int $resultCode:[1]プレイヤー勝利 [2]引き分け [3]ディーラー勝利 [4]サレンダーによるディーラーの勝利 [99]例外終了
     * @return $result:更新結果
     */
    public function updataBetAndCredit($id, $resultCode)
    {
        try {
            $db = new DataSource;
            $db->openConnection();
            $db->begin();
    
            # UPDDATE文
            $sql = "UPDATE t_player ";
            $sql .= "SET ";
            $sql .= "status = 0, ";
            
            if($resultCode === 1) {
                $sql .= "credit = credit + bet * 3, ";
            } else if($resultCode === 2) {
                $sql .= "credit = credit + bet, ";
            } else if($resultCode === 3) {
                $sql .= "credit = credit + bet * 0, ";
            } else if($resultCode === 4) {
                $sql .= "credit = credit + bet / 2, ";
            } else {
    
            }

            $sql .= "bet = 0 ";
            $sql .= "WHERE id = :id;";
    
            $db->update($sql, [':id' => $id], 'cls', 'model\CardModel');
            $db->commit();
            $db->closeConnection();
    
            return true;

        } catch(\PDOException $e) {
            echo $e->getMessage();
            $db->rollback();
            return false;
        }
    }
}