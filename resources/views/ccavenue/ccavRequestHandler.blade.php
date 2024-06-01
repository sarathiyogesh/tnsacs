<html>
<head>
<title> Iframe</title>
</head>
<body>
<center>
@include('ccavenue/Crypto')
<?php 

	error_reporting(0);

	$working_key = '7EBE327186261E1015EB0D796AE1375D';//Shared by CCAVENUES
	$access_code = 'AVHM02FI83AF84MHFA';//Shared by CCAVENUES
	$merchant_data = '';
	
	foreach ($parameters as $key => $value){
		$merchant_data .= $key.'='.$value.'&';
	}
	
	$encrypted_data = encryptccavenuerequesthandler($merchant_data, $working_key); // Method for encrypting the data.

	$production_url='https://secure.ccavenue.ae/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;
?>
<iframe src="<?php echo $production_url?>" id="paymentFrame" width="482" height="450" frameborder="0" scrolling="No" ></iframe>

<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
    	$(document).ready(function(){
    		 window.addEventListener('message', function(e) {
		    	 $("#paymentFrame").css("height",e.data['newHeight']+'px'); 	 
		 	 }, false);
	 	 	
		});
</script>
</center>
</body>
</html>

