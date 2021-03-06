<?php

class IndexModel extends Model {

	public function getTaskList($page = 0, $itemPerPage = 3) {
        $from = $page * $itemPerPage;
        $order = isset($_SESSION['orderField']) && $_SESSION['orderField'] != '' ? 
            "ORDER BY `". $_SESSION['orderField'] ."` " . ($_SESSION['orderAD'] ? 'ASC' : 'DESC') :
            '';
        $sql = "SELECT * FROM `tasks` $order LIMIT $from, $itemPerPage;";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskCount() {
        $sql = "SELECT COUNT(*) FROM `tasks`;";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
    }

    public function getTaskById($id) {
        $sql = "SELECT * FROM `tasks` WHERE `t_id` = $id";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function setNewTask($userName, $email, $task) {
        $sql = "INSERT INTO `tasks` (`t_username`, `t_email`, `t_text`) VALUES (:userName, :email, :task);";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':task', $task, PDO::PARAM_STR);

        $responce['ok'] = true;
        $responce['msg'] = [];

        if (!$stmt->execute()) {
            $responce['ok'] = false;
            $responce['msg'][] = 'Ошибка добавления данных!';
        }

        return $responce;
    }

    public function updateTask($tid, $userName, $email, $task, $done) {
        $sql = "UPDATE `tasks` SET `t_username` = :userName, `t_email` = :email, `t_text` = :task, `t_done` = :done, `t_edited` = :edited WHERE (`t_id` = :tid);";

        $edited = (int)($this->getTaskById($tid)['t_text'] != $task);

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tid', $tid, PDO::PARAM_STR);
        $stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':task', $task, PDO::PARAM_STR);
        $stmt->bindValue(':done', $done, PDO::PARAM_INT);
        $stmt->bindValue(':edited', $edited, PDO::PARAM_INT);

        $responce['ok'] = true;
        $responce['msg'] = [];

        if (!$stmt->execute()) {
            $responce['ok'] = false;
            $responce['msg'][] = 'Ошибка обновления данных!';
        }

        return $responce;
    }

    public function findUser($userName, $password) {
        $sql = "SELECT COUNT(*) FROM users WHERE users.u_name = '".$userName."' AND users.u_pass = '".$password."';";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
    }
	
}