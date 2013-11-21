<?php
function db_connect(){
   $result = mysql_pconnect('localhost', 'dreamcatchers', 'Dr3amCa7ch');
   if (!$result)
      return false;
   if (!mysql_select_db('dreamcatchers'))
      return false;

   return $result;
}

function db_result_to_array($result) {
	$res_array = array ( );
	$count = 0;

	while(($row = @mysql_fetch_array($result)) == true){
		$res_array [$count] = $row;
		$count ++;
	}
	return $res_array;
}
?>
