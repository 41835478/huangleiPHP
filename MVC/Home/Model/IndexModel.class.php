<?php

class IndexModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        echo 'IndexModel中的index方法';
    }

}
