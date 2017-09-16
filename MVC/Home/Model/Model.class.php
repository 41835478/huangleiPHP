<?php
/**
 * Class Model : Model基类
 * 		生成一个pdo对象，用变量$conn存储PDO对象，供子类调用
 */
class Model{
    
	protected $conn;
    
	protected function __construct() {
		$this->conn = new PDO('mysql:host=localhost;dbname=mall', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'));
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

    
}
