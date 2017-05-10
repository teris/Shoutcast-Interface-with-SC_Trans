<?php
if(isset($_POST['options'])):
	$request = "op=setoptions&";
	foreach($_POST as $key => $select):
		if($key != 'options'):
			if($_POST[$key] != NULL):
				$request .= $key."=".$select."&";
			endif;
		endif;
	endforeach;
	$returns = $between->load_xml($trans->getInfoTrans($request."seq=15"),'set_options.xml');
	
	echo "<hr><pre>";
		print_r($returns['response']);
	echo "</pre>";
endif;
?>

<form method="POST" action="">
<table border="1" cellpadding="2" cellspacing="3" class="display">
	<thead>
		<tr>
			<th style="width:35%;">Tag</th>
			<th>Option</th>
		</tr>
	</thead>
	<tbody>
	
	<?php
	$exit	=	$between->load_xml($trans->getInfoTrans("op=getoptions&seq=150"), 'get_optionen.xml');
	$i = 0;
	foreach($exit['response']['data']['options'] as $key => $value):
		
		($i % 2) ? $class = "odd" : $class = "even";
		(is_array($value)) ? $v_out = "" : $v_out = $value;
		echo "<tr class='".$class."'>\n";
		echo "<td>".$key."</td>"; 
		echo "<td> <input type='text' name='".$key."' placeholder='".$v_out."'></td>";
		echo "</tr>\n";
		
		$i++;
		
	endforeach;	
	?>
	</tbody>
</table>

<p><input type="submit" name="options" value="Speichern"> <input type="reset" value="Zurücksetzen"></p>
</form>