<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

/*
-------------------------------------------------------------------
数据库操作方法
*/
class sql {
	var $db;
	var $dumpcharset;
	var $complete;
	function __construct(){
		$this->db = & DB::object();
		$this->dumpcharset = CHARSET;
		$this->complete = true;
	}
			function list_table($tablepre=''){ //列出所有表
					global $_G;
					
					if(empty($tablepre)){
						$db_info = include INC_PATH.'/config/db.config.php';
						$tablepre = $db_info['tablepre']; 
					}
					$table = DB::fetch_all("SHOW TABLES");
					foreach($table as $k=>$v){
						if(is_array($v)){
							foreach($v as $kk=>$vv){
								if(cutstr($vv,strlen($tablepre),'') ==$tablepre){
									$arr[] = $vv;
								}
							}
						}
					}
					return $arr;
					
			}
			
			
			
			function sqldumptablestruct($table) { //备分所有表
				global $_G;	
				$createtable = DB::query("SHOW CREATE TABLE $table", 'SILENT');
				if(!DB::error()) {
					$tabledump = "DROP TABLE IF EXISTS $table;\n";
				} else {
					return '';
				}
			
				$create = $this->db->fetch_row($createtable);
			
				if(strpos($table, '.') !== FALSE) {
					$tablename = substr($table, strpos($table, '.') + 1);
					$create[1] = str_replace("CREATE TABLE $tablename", 'CREATE TABLE '.$table, $create[1]);
				}
				$tabledump .= $create[1];
			
				$tablestatus = DB::fetch_first("SHOW TABLE STATUS LIKE '$table'");
				$tabledump .= ($tablestatus['Auto_increment'] ? " AUTO_INCREMENT=$tablestatus[Auto_increment]" : '').";\n\n";
			
				return $tabledump;
			}
			
			function sqldumptable($table, $startfrom = 0, $currsize = 0) { //备分当前表的所有数据
				global $_G, $startrow;
			
				$offset = 10000;
				$size = 1024;
				$tabledump = '';
				$tablefields = array();
			
				$query = DB::query("SHOW FULL COLUMNS FROM $table", 'SILENT');
					while($fieldrow = DB::fetch($query)) {
						$tablefields[] = $fieldrow;
					}
					$tabledumped = 0;
					$numrows = $offset;
					$firstfield = $tablefields[0];
						while($currsize + strlen($tabledump) + 500 < $size * 1000 && $numrows == $offset) {
							//$selectsql = "SELECT * FROM $table WHERE $firstfield[Field] > $startfrom ORDER BY $firstfield[Field] LIMIT $offset"; //主键大于0
							$selectsql = "SELECT * FROM $table ORDER BY $firstfield[Field] LIMIT $offset";
							$tabledumped = 1;
							$rows = DB::query($selectsql);
							$numfields = $this->db->num_fields($rows);
			
							$numrows = DB::num_rows($rows);
							
							while($row = $this->db->fetch_row($rows)) {
								$comma = $t = '';
								
								for($i = 0; $i < $numfields; $i++) {
									$t .=  '\''.mysql_escape_string($row[$i]).'\',';
									$comma = ',';
									
								}
								$t = trim($t,',');
								if(strlen($t) + $currsize + strlen($tabledump) + 500 < $size * 1000) {
									if($firstfield['Extra'] == 'auto_increment') {
										$startfrom = $row[0];
									} else {
										$startfrom++;
									}
									$tabledump .= "INSERT INTO $table VALUES ($t);\n";
								} else {
									$complete = FALSE;
									break 2;
								}
							}
						}
					$startrow = $startfrom;
					$tabledump .= "\n";
			
				return $tabledump;
			}
			
			
			function createtable($sql, $dbcharset) {
				$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
				$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
				return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
					(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=$dbcharset" : " TYPE=$type");
			}
			
			function fetchtablelist($tablepre = '') { //查找所有表
				global $db;
				$arr = explode('.', $tablepre);
				$dbname = $arr[1] ? $arr[0] : '';
				$tablepre = str_replace('_', '\_', $tablepre);
				$sqladd = $dbname ? " FROM $dbname LIKE '$arr[1]%'" : "LIKE '$tablepre%'";
				$tables = $table = array();
				$query = DB::query("SHOW TABLE STATUS $sqladd");
				while($table = DB::fetch($query)) {
					$table['Name'] = ($dbname ? "$dbname." : '').$table['Name'];
					$tables[] = $table;
				}
				return $tables;
			}
			
			
			
			function syntablestruct($sql, $version, $dbcharset) {
			
				if(strpos(trim(substr($sql, 0, 18)), 'CREATE TABLE') === FALSE) {
					return $sql;
				}
				$sqlversion = strpos($sql, 'ENGINE=') === FALSE ? FALSE : TRUE;
				if($sqlversion === $version) {
					return $sqlversion && $dbcharset ? preg_replace(array('/ character set \w+/i', '/ collate \w+/i', "/DEFAULT CHARSET=\w+/is"), array('', '', "DEFAULT CHARSET=$dbcharset"), $sql) : $sql;
				}
				if($version) {
					return preg_replace(array('/TYPE=HEAP/i', '/TYPE=(\w+)/is'), array("ENGINE=MEMORY DEFAULT CHARSET=$dbcharset", "ENGINE=\\1 DEFAULT CHARSET=$dbcharset"), $sql);
			
				} else {
					return preg_replace(array('/character set \w+/i', '/collate \w+/i', '/ENGINE=MEMORY/i', '/\s*DEFAULT CHARSET=\w+/is', '/\s*COLLATE=\w+/is', '/ENGINE=(\w+)(.*)/is'), array('', '', 'ENGINE=HEAP', '', '', 'TYPE=\\1\\2'), $sql);
				}
			}
			
			
			function splitsql($sql) {
				$sql = str_replace("\r", "\n", $sql);
				$ret = array();
				$num = 0;
				$queriesarray = explode(";\n", trim($sql));
				unset($sql);
				foreach($queriesarray as $query) {
					$queries = explode("\n", trim($query));
					foreach($queries as $query) {
						$ret[$num] .= $query[0] == "#" ? NULL : $query;
					}
					$num++;
				}
				return($ret);
			}
			
			function slowcheck($type1, $type2) {
				$t1 = explode(' ', $type1);$t1 = $t1[0];
				$t2 = explode(' ', $type2);$t2 = $t2[0];
				$arr = array($t1, $t2);
				sort($arr);
				if($arr == array('mediumtext', 'text')) {
					return TRUE;
				} elseif(substr($arr[0], 0, 4) == 'char' && substr($arr[1], 0, 7) == 'varchar') {
					return TRUE;
				}
				return FALSE;
			}
			
			
			
			function insert_sql($content){
				
				
				if(!$content) return false;
				$Charset = str_replace('-','',CHARSET);

				$detail=explode("\n",$content);
				$count=count($detail);
				for($j=0;$j<$count;$j++){
					$ck=substr($detail[$j],0,4);
					if( ereg("#",$ck)||ereg("--",$ck) ){
						continue;
					}
					$array[]=$detail[$j];
				}
				$read=implode("\n",$array); 
				$sql=str_replace("\r",'',$read);
				$detail=explode(";\n",$sql);
				$count=count($detail);
				$check=0;
				
				for($i=0;$i<$count;$i++){
					$sql=str_replace("\r",'',$detail[$i]);
					$sql=str_replace("\n",'',$sql);
					$sql=trim($sql);
					if($sql){
						if(strpos($sql,'CREATE TABLE') !== false){
						//if(eregi("CREATE TABLE",$sql)){
							if(strpos($sql,'ENGINE=') !== false){
								$mysqlV=mysql_get_server_info();
								$sql=preg_replace("/DEFAULT CHARSET=([a-z0-9]+)/is","",$sql);
								$sql=preg_replace("/TYPE=MyISAM/is","ENGINE=MyISAM",$sql);
								if($mysqlV>'4.1'){
									$sql=str_replace("ENGINE=MyISAM"," ENGINE=MyISAM DEFAULT CHARSET=$Charset ",$sql);
								}
							}
							$sql=preg_replace("/AUTO_INCREMENT=(\d+)/is","",$sql);
						}
						
						//$query=mysql_query($sql);
						
						$query= DB::query($sql);
						
						//if (!$query) json($sql);
						$check++;
					}	
				}
				
				return $check;
			}
			
			
			function insert_file($file,$org_pre='',$new_pre=''){				
				$readfiles=$this->read_file($file);
				if($org_pre && $new_pre && $org_pre != $new_pre){
					$readfiles = str_replace($org_pre,$new_pre,$readfiles);
				}				
				return $this->insert_sql($readfiles);
				
			}
			function read_file($filename,$method="rb"){
				if($handle=@fopen($filename,$method)){
					@flock($handle,LOCK_SH);
					$filedata=@fread($handle,@filesize($filename));
					@fclose($handle);
				}
				return $filedata;
			}

}
?>