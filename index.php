<?php
function conn($dbname = 'smartcities',$user = 'root',$pass = ''){
	$conn = new PDO("mysql:host=localhost;dbname=".$dbname, $user, $pass);
	return $conn;
}
function getNames($query){
	$arr = [];
	foreach ($query->fetchAll() as $value) {
		if($value['Field']!='id')
			$arr[] = "'".$value['Field']."'";
	}
	return implode(',', $arr);
}
function getTables($conn,$datatable){

	$query = $conn->query("show tables;");
	$tables = [];
	while($dd = $query->fetch()){
		$subq = $conn->query("SHOW COLUMNS FROM ".$dd[0]);

		$fp = fopen('out/'.ucfirst($dd[0]).'.php',"w");
		$cont = file_get_contents('modelo.php');

		$tokens = array(
		    'class_name' => ucfirst($dd[0]),
		    'table_name' => $dd[0],
		    'atts' => getNames($subq)
		);

		$pattern = '{{ %s }}';

		$map = array();
		foreach($tokens as $var => $value)
		{
		    $map[sprintf($pattern, $var)] = $value;
		}

		$output = strtr($cont, $map);
		fprintf($fp, $output);
		fclose($fp);
		$tables[] = ['name'=>$dd[0],'info'=>$subq->fetchAll()];
	}
	return $tables;


}
try{
	$c = conn();
}catch(Exception $e){
	print($e->getMessage());
}



$res = json_encode(getTables($c,'sisponto'));
printf('<script>
		var arr = %s;
		for(var i = 0;i<arr.length;i++){
			for(var j = 0;j<arr[i]["info"].length;j++){
				console.log(arr[i]["info"][j]["Field"]+"-"+arr[i]["info"][j]["Type"]);
			}
			
		}
		
	</script>
',$res);
