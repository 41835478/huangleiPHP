<?php
class ListModel extends Model {


    public function __construct(){
        //调用父类获取$conn对象
        parent::__construct();
    }
    
    public function page(){
        $aa = $this->conn->query("insert into shop values('5','205')");

    }


}

