<?php

require("class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();
$mail->Host = "";  /*SMTP server*/

$mail->SMTPAuth = true;
//$mail->SMTPSecure = "ssl";
$mail->Port = 587;
$mail->Username = "";  /*Username*/
$mail->Password = "";    /**Password**/

$mail->From = "";    /*From address required*/
$mail->FromName = "";
$mail->AddAddress("");
$mail->AddReplyTo("");

$mail->IsHTML(true);

$mail->Subject = "New Enquiry from Website";
$mail->Body = "<h1 style='text-align:center;'>New $package_name Enquiry.</h1>
			<table class='table table-bordered'>
				<tr>
					<th style='text-align:left;'>Name </th>
					<td>$name</td>
				</tr>
				<tr>
					<th style='text-align:left;'>Email </th>
					<td>$email</td>
				</tr>
				<tr>
					<th style='text-align:left;'>Contact No </th>
					<td>$mobile</td>
				</tr>
				<tr>
					<th style='text-align:left;'>Current Location</th>
					<td>$location</td>
				</tr>
				<tr>
					<th style='text-align:left;'>Travel Date</th>
					<td>$date</td>
				</tr>
				<tr>
					<th style='text-align:left;'>No of Person</th>
					<td>$person</td>
				</tr>
				<tr>
					<th style='text-align:left;'>Any Requirment</th>
					<td>$requirment</td>
				</tr>
				<tr>
					<th style='text-align:left;'>Enquiry URL</th>
					<td>$url</td>
				</tr>
				<tr>
					<th style='text-align:left;'>User IP</th>
					<td><a href='http://whatismyipaddress.com/ip/$ip'>$ip</a></td>
				</tr>
			</table><br /><br /><br />SPAM protected by <a href='http://www.itssoftworld.com' style='text-decoration:none; color:#0000FF;'>ITS Soft World</a>
		";

//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{ ?>
	<script type="text/javascript">
		alert("Thank your for choosing us.");
		
	</script>
	<?php
exit;
} else { ?>

	<script type="text/javascript">
		alert("Thank your for choosing us.");
		
	</script>
<?php
}

?>