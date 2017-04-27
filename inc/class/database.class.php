<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
/**
 * Database SQL操作类
 */

class Database {
	const CHARSET_UTF8 = 'utf8';
	const CHARSET_GBK = 'GBK';
	protected $pdo = null;
	protected $host = '';
	protected $port = 3306;
	protected $username = '';
	protected $password = '';
	protected $database = '';
	protected $persistent = false;
	public $debug = true;
	public $currentSql;
	/**
	 * 所有运行过的SQL语句
	 * @var array
	 */
	protected $sqls = array();
	protected $queryResult = null;
	protected $affectedRowsCount = 0;
	protected $charset;
	/**
	 * 数据库类型，例如mysql,mssql，默认为mysql
	 * @var string
	 */
	protected $dbType = 'mysql';
	protected $errorMsg = null;	
	private static $selfRef = null;	
	public function __construct($host, $username, $password, $database, $port) {

		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->port = $port;
		$this->debug = DEBUG;

		
	}	
	public function connection(){
		if(is_null($this->pdo)){
			//连接数据库,正确或错误,判断不出来			
			$this->pdo = new PDO( $this->dsn(), $this->username, $this->password);
			$this->setDebug();
			if($this->errorInfo()){
				system_error('system',$this->errorInfo());
				return false;
			}
			
		}
		return true;
	}
	public function setBufferedQuery($buffered = false) {
		if($this->dbType == 'mysql'){
			$this->pdo->setAttribute(PDO::NULL_TO_STRING,$buffered);
		}
	}
	protected function dsn(){
		return 'jdbc:mysql://' . $this->host . ':' . $this->port . '/' . $this->database . '?characterEncoding='.self::CHARSET_UTF8;
	}
	public function setCharset($charset){
		$charset = str_replace('-', '', $charset);
		$this->charset = $charset;
		if($this->dbType == 'mysql'){
			if($charset != ''){
				if($this->pdo instanceof PDO){
					$this->execute("SET NAMES ".$charset);
				}
			}
		}
	}
	public function setDebug(){
			global $_G;
			if($this->pdo instanceof PDO){			
			//如果开启调试模式，则将PDO调整为用异常提示错误
			if($this->debug){				
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}else{
			//否则不直接输出错误,可以使用errorInfo()方法获取错误消息
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
			}
		}
	}
	
	/**
	 * 插入数据
	 * 
	 * @param string $table 表名称
	 * @param array $data 插入的数据 array(字段名=>值,字段名=>值)
	 * @return boolean|integer true为成功，integer为影响的记录数
	 */
	public function insert($table,$data){
		$fields = array(); 
		$values = array();
		foreach($data as $key => $val){
			if (is_string($key)){
				$fields[] = $this->fieldQuote($key);
			}
			$values[] = $this->q($val);
		}
		if ($fields){
			$insertSql = "INSERT INTO `".$table."` (".implode(',',$fields).") VALUES(".implode(',',$values).")";
		}else{
			$insertSql = "INSERT INTO `".$table."` VALUES(".implode(',',$values).")";
		}
		
		try{
			$res =  $this->execute($insertSql);
		}catch (PDOException $e){
			system_error('db');
			return false;
		}
			
			
		return $res;
	}
	
	/**
	 * 更新数据
	 * 
	 * @param string $table 表名称
	 * @param array $data 插入的数据 array(字段名=>值,字段名=>值)
	 * @param string $where 条件子句（不包含关键字 WHERE）
	 * @return boolean|integer true为成功，integer为影响的记录数
	 */
	public function update($table,  $data, $where){
		$sets = array();
		foreach($data as $key => $val){
			$sets[] = $this->fieldQuote($key)."=".$this->q($val);
		}
		$updateSql = "UPDATE `".$table."` SET ".implode(",",$sets)." WHERE ".$where;
		
		return $this->execute($updateSql);
	}
	
	/**
	 * 删除数据
	 * 
	 * @param string $table 表名称
	 * @param string $where 条件子句（不包含关键字 WHERE）
	 * @return boolean|integer true为成功，integer为影响的记录数
	 */
	public function delete($table, $where){
		$deleteSql = "DELETE FROM `".$table."` WHERE ".$where;
		//if ($this->debug) echo $deleteSql;
		return $this->execute($deleteSql);
	}
	
	/**
	 * 转义字符串并加上单引号
	 * @param string $string
	 * @return string
	 */
	public function q($string){
		
		if (is_array($string)){
			$string = json_encode($string);
		}
		if (is_object($string)){
			if (get_class($string) == 'MySQLCode'){
				return $string->get();
			}
		}
		return $this->pdo->quote($string);
	}
	
	/**
	 * 处理字段名
	 * @param string $field
	 * @return string
	 */
	protected function fieldQuote($field){
		switch ($this->dbType){
			case 'mysql':
				$field = '`'.$field.'`';
				break;
			case 'mssql':
				$field = '['.$field.']';
				break;
		}
		return $field;
	}
	
	/**
	 * 执行查询的SQL语句
	 * @param string $sql SQL语句
	 * @return boolean true为运行成功,false为运行失败
	 */
	public function query($sql){
		
		return $this->runSql($sql,true);
	}
	
	/**
	 * 执行更新的SQL语句
	 * @param string $sql SQL语句
	 * @return boolean|integer false为运行失败,integer为SQL语句影响的记录数
	 */
	public function execute($sql){
		return $this->runSql($sql,false);
	}
	public function exec($sql){
		return $this->runSql($sql,false);
	}
	/**
	 * 运行SQL语句
	 * 
	 * @param string $sql SQL语句
	 * @param boolean $query true为查询,false为UPDATE/DELETE等更新
	 * @return boolean|integer false为运行失败,integer为SQL语句影响的记录数
	 */
	protected function runSql($sql, $query){

		if(defined('ERROR')) return false;
		$this->currentSql = $sql;
		$ret = false;
		if($this->debug){
			$this->sqls[] = $sql;
		}
		//$sql = $this->sqlMark().$sql;
		$this->free_result();		
		if($query){
			try{
				$this->queryResult = $this->pdo->prepare($sql);
			}catch (PDOException $e){
				system_error('db');
				return false;
			}
			if($this->queryResult){
				$ret = $this->queryResult->execute();
				if($ret === false){
					 system_error('db');
					 return false;
				}
			}else{
				 system_error('db');
				 return false;
			}
			
		}else{
			try{
				$this->affectedRowsCount = $this->pdo->exec($sql);			
			}catch(PDOException $e){			
				if(defined('API')){
					$message = $this->errorInfo();
					if(strpos($message,'Duplicate entry') !== false){
						return false;
					}
				}						
				 system_error('db');
				 return false;
				
			}
			$ret = $this->affectedRowsCount;
		}
		
		return $ret;
	}
	
	/**
	 * 获取一条记录
	 * @param integer $type 返回值类型，可选为MYSQL_ASSOC|MYSQL_NUM|MYSQL_BOTH|MSSQL_ASSOC|MSSQL_NUM|MSSQL_BOTH
	 * @return array
	 */
	public function fetchRow($type = MYSQL_ASSOC){
		if(!$this->queryResult) return false;
		return $this->queryResult->fetch($this->mapType($type));
	}
	public function fetch($type = MYSQL_ASSOC){
		if(!$this->queryResult) return false;
		return $this->queryResult->fetch($this->mapType($type));
	}
	
	/**
	 * 将MYSQL函数的返回值类型转换为PDO的返回值类型
	 * @param integer $type
	 * @return integer
	 */
	protected function mapType($type){
		switch ($type){
			case MYSQL_ASSOC://包括MSSQL_ASSOC
				$pdoType = PDO::FETCH_ASSOC;
				break;
			case MYSQL_NUM://包括MSSQL_NUM
				$pdoType = PDO::FETCH_NUM;
				break;
			case MYSQL_BOTH://包括MSSQL_BOTH
				$pdoType = PDO::FETCH_BOTH;
				break;
			default:
				$pdoType = PDO::FETCH_ASSOC;
		}
		return $pdoType;
	}
	
	public function getAllex($sql, $convertInt){
		return $this->getAll($sql, '', MYSQL_ASSOC, $convertInt);
	}
	
	/**
	 * 获取整个数据集
	 * @param string $sql SQL语句
	 * @param integer $primaryKey 如果有指定$primaryKey的值，则使用该字段的值做为数组的一维的键值
	 * @param integer $type 返回值类型，可选为MYSQL_ASSOC|MYSQL_NUM|MYSQL_BOTH|MSSQL_ASSOC|MSSQL_NUM|MSSQL_BOTH
	 * @param string $convertInt 表名称，如果不为空，则根据表结构转换相关的整型，否则不处理
	 * @return array 二维数组
	 */
	public function getAll($sql, $primaryKey = '', $type = MYSQL_ASSOC, $convertInt = '', $isKV = false){
		$this->query($sql);		
		if($this->errorInfo()){
			system_error('system',$this->errorInfo());
			 return false;
		}
		
		if($primaryKey == ''){
			$return = $this->queryResult->fetchAll($this->mapType($type));
			return $return;
		} 
		$return = array();
		while($row = $this->fetchRow($type)){
			if ($convertInt){
				foreach ($row as $k => &$v){
					if($v=='null') $v='';
					if (strpos($fieldList[$k]['Type'],'int(') !== false){
						$v = intval($v);
					}
				}
			}

			if ($isKV){
				@$return[$row[$primaryKey]] = $row[0];
			}else{
				@$return[$row[$primaryKey]] = $row;
			}
		}
		return $return;
	}
	
	/**
	 * 获取第一行数据
	 * @param string $sql SQL语句
	 * @param integer $type 返回值类型，可选为MYSQL_ASSOC|MYSQL_NUM|MYSQL_BOTH|MSSQL_ASSOC|MSSQL_NUM|MSSQL_BOTH
	 * @return array 一维数组
	 */
	public function getOne($sql, $type = MYSQL_ASSOC){
		$this->query($sql);
		return $this->fetchRow($type);
	}
	
	/**
	 * 根据SQL语句获取指定字段的值
	 * @param string $sql SQL语句
	 * @param integer $offset 字段的数字索引
	 * @return string
	 */
	public function getValue($sql, $offset = 0){
		$this->query($sql);
		$row = $this->fetchRow(MYSQL_NUM);
		if(isset($row[$offset])){
			return $row[$offset];
		}
		return null;
	}
	
	/**
	 * 获取本次查询的字段数
	 * @return integer
	 */
	public function getNumFields(){
		if(defined('ERROR')) return false;
		return $this->queryResult->columnCount();
	}
	
	/**
	 * 获取插入字段的ID
	 * @return integer
	 */
	public function getInsertId(){
		if(defined('ERROR')) return false;
		if($this->dbType == 'mssql'){
			$this->query("SELECT LAST_INSERT_ID=@@IDENTITY");
			$row = $this->fetchRow();
			if(isset($row['LAST_INSERT_ID'])){
				return $row['LAST_INSERT_ID'];
			}
			return 0;
		}
		return intval($this->pdo->lastInsertId());
	}
	
	/**
	 * 获取受影响的行数
	 * @return integer
	 */
	public function getAffectedRows() {
		if(defined('ERROR')) return false;
		return $this->affectedRowsCount;
	}
	
	/**
	 * 释放数据集资源
	 * @return boolean
	 */
	public function free_result(){
		$this->queryResult = null;
		return true;
	}
	
	/**
	 * 获取数据库的版本号
	 * @return string
	 */
	public function version(){
		if(defined('ERROR')) return false;
		if($this->dbType == 'mssql'){
			$this->query("SELECT SERVERPROPERTY('productversion')");
			$result = $this->fetchRow(MYSQL_NUM);
			if (sizeof($result)) {
				return $result[0];
			}
			return null;
		}
		return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
	}
	
	/**
	 * 关闭数据库连接
	 * @return boolean
	 */
	public function close(){
		$this->pdo = null;
		return true;
	}
	
	/**
	 * 返回最后一次数据库操作错误的信息
	 * @return string
	 */
	public function errorInfo(){

		if($this->pdo){//如果连接成功
			$queryError = $this->pdo->errorInfo();
			$executeError = $this->pdo->errorInfo();
			if(isset($queryError[2])){
				return $queryError[2];
			}elseif(isset($executeError[2])){
				return $executeError[2];
			}
		}
		//没有连接成功，返回异常的信息
		return $this->errorMsg;
	}
	
	/**
	 * 克隆当前对象
	 * @return Db
	 */
	public function copy(){
		return clone $this;
	}
	
	/**
	 * 魔术方法，将实例副本的查询结果删除
	 */
	public function __clone(){
		$this->queryResult = null;
	}
	
	/**
	 * SQL语句标识
	 * @return string
	 */
	protected function sqlMark(){
		if(!isset($this->sqlMark)){
			$this->sqlMark = '/*'.substr($_SERVER['SCRIPT_NAME'],-20).'*/ ';
		}
		return $this->sqlMark;
	}
	
	/**
	 * 输出SQL语句
	 * @param boolean $out 输出或返回SQL语句,true为输出,false为返回
	 * @param boolean $all 是否输出所有sql语句,默认true只输出最后一句sql 
	 * @return string
	 */
	public function sqlOutput($out = true, $all = true){
		if($all){
			//$ret = implode("<br>",$this->sqls);
			$ret =$this->sqls;
		}else{
			$ret = $this->sqls[count($this->sqls)-1];
		}
		if ($out){
			debug($ret);
		}else{
			return $ret;
		}
	}
}

class MySQLCode {
	private $str = '';
	
	public function __construct($s){
		if (is_string($s)){
			$this->str = $s;
		}
	}
	
	public function get(){
		return $this->str;
	}
}