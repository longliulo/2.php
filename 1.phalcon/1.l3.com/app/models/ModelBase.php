<?php
namespace MyApp\Model;
use Phalcon\Mvc\Model;

class ModelBase extends Model {

    public function findById($id) {
        return self::findFirst(array("id = :id: AND deleted = 0", "bind" => array("id" => $id)));
    }

    public function findAll() {
        return self::find(array("deleted = 0", "order" => "updated_at DESC"));
    }

    public function updateFieldDelete($id, $user_id) {
        $data = $this -> findById($id);
        if ($data == false) {
            return false;
        }
        $data -> setParamsForDelete($user_id);
        return $data -> update();
    }

    public function deleteById($id) {
        $data = $this -> findById($id);
        if ($data == false) {
            return false;
        }
        $data -> deleted = DELETED;
        return $data -> save();
    }

    public function setParamsForNew($user_id) {
        $this -> deleted = NOT_DELETED;
        $this -> created_at = date("Y-m-d H:i:s");
        $this -> created_by = $user_id;
        $this -> updated_at = date("Y-m-d H:i:s");
        $this -> updated_by = $user_id;
    }

    public function setParamsForUpdate($user_id) {
        $this -> updated_at = date("Y-m-d H:i:s");
        $this -> updated_by = $user_id;
    }

    public function setParamsForDelete($user_id) {
        $this -> deleted = DELETED;
        $this -> setParamsForUpdate($user_id);
    }

    public function findAllOrderById() {
        return self::find(array("deleted = 0", "order"  => "id asc"));
    }

    public function findByLimit($limit, $offset = 0){
        return self::find(array("deleted = 0",
                            "limit"  => $limit,
                            "offset" => $offset,
                            "order"  => "updated_at DESC"
                           ));
    }
}
