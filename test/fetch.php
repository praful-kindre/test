<?php

//fetch.php

$api_url = "http://localhost/test/api/test_api.php?action=fetch_all";

$client = curl_init($api_url);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);

$result = json_decode($response);

$output = '';

if(count($result) > 0)
{
	$i = 1;

	foreach($result as $row)
	{
		$output .= '
		<tr>
			<td>'.$i.'</td>
			<td>'.ucwords($row->STUDENT_NAME).'</td>
			<td>'.$row->STUDENT_DOB.'</td>
			<td>'.$row->STUDENT_DOJ.'</td>
			<td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->STUDENT_NO .'">Edit</button></td>
			<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->STUDENT_NO .'">Delete</button></td>
		</tr>
		';
		$i++;
	}
}
else
{
	$output .= '
	<tr>
		<td colspan="4" align="center">No Data Found</td>
	</tr>
	';
}

echo $output;

?>
