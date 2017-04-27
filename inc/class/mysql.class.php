<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 


class mysql
{
	var $table;
	var $version = '';
	var $querynum = 0;
	var $slaveid = 0;
	var $drivertype='mysql';
	var $db;
	var $config = array();
	var $sqldebug = array();
	var $map = array();
	var $currentSql;
	var $debug = false;
	var $error_sql = '';

	function __construct($config) {
		$this->config = &$config[db];
		$this->debug = DEBUG;
	}

	function connect() {
		if(empty($this->config)) {
			$this->halt('config_db_not_found');
		}
		
		if(!function_exists('mysql_connect')){
			$this->halt('mysql_connect()不支持,请检查 mysql 模块是否正确加载');
		}

		$this->db = $this->_dbconnect(
			$this->config['dbhost'],
			$this->config['dbuser'],
			$this->config['dbpw'],
			$this->config['dbcharset'],
			$this->config['dbname'],
			$this->config['pconnect']
			);
		
	
	}

	function _dbconnect($dbhost, $dbuser, $dbpw, $dbcharset, $dbname, $pconnect) {

		if($pconnect) {
			$link =mysql_pconnect($dbhost, $dbuser, $dbpw, MYSQL_CLIENT_COMPRESS);
		} else {
			$link = mysql_connect($dbhost, $dbuser, $dbpw, 1, MYSQL_CLIENT_COMPRESS);
		}
		if(!$link) {
			$this->halt($this->error(), $this->errno());
		} else {
			$this->db = $link;
			
			if($this->version() > '4.1') {
				$dbcharset = $dbcharset ? $dbcharset : $this->config['dbcharset'];
				$serverset = $dbcharset ? 'character_set_connection='.$dbcharset.', character_set_results='.$dbcharset.', character_set_client=binary' : '';
				$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',').'sql_mode=\'\'') : '';
				$serverset && mysql_query("SET $serverset", $link);
			}
			$dbname && @mysql_select_db($dbname, $link);
			
			
		}
		return $link;
	}

	function table_name($tablename) {
		
		return $this->table.$tablename;
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->db);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));
	}

	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}
	
	
	public function query($sql, $silent = false, $unbuffered = false) {
		if($this->debug) {
			$starttime = microtime(true);
		}

		if('UNBUFFERED' === $silent) {
			$silent = false;
			$unbuffered = true;
		} elseif('SILENT' === $silent) {
			$silent = true;
			$unbuffered = false;
		}

		$func = $unbuffered ? 'mysql_unbuffered_query' : 'mysql_query';
		$this->currentSql = $sql;
		if($this->debug) {
			//$this->cursql = array($sql, number_format((microtime(true) - $starttime), 6), debug_backtrace(), $this->db);
			$this->sqldebug[] =$sql;
		}
		
		if(!($query = $func($sql, $this->db))) {
			
			if(in_array($this->errno(), array(2006, 2013)) && substr($silent, 0, 5) != 'RETRY') {
				$this->connect();

				return $this->query($sql, 'RETRY'.$silent);
			}
			
			if(!$silent) {
				$this->halt($this->error(), $sql);
			}
			
		}

		

		$this->querynum++;
		return $query;
	}

	function affected_rows() {
		
		return mysql_affected_rows($this->db);
	}

	function error() {
		return (($this->db) ? mysql_error($this->db) : mysql_error());
	}

	function errno() {
		return intval(($this->db) ? mysql_errno($this->db) : mysql_errno());
	}

	function result($query, $row = 0) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->db)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->db);
		}
		return $this->version;
	}

	function close() {
		return mysql_close($this->db);
	}

	
	function errorInfo(){
		return $this->error();
	}
	
	function sqlOutput($out = true, $all = true){
		if($all){
			$ret =$this->sqldebug;
		}else{
			$ret = $this->sqldebug[count($this->sqldebug)-1];
		}
		if ($out){
			dump($ret);
		}else{
			return $ret;
		}
	}
	
	function halt($message = '',$sql) {
		system_error('db',$message);
	}

}

?>