<?php
if(isset($_POST['project_submitted'])){
	$to = 'william@saltwaterco.com';
	$fromEmail = "dev10k@noreply.com"; 
	$fromName = "Developer 10k Challenge Submission"; 
	$subject = "Oooh, someone thinks they're good at stuff."; 
	$message = "A user has submitted their 10k challenge zip file.  This project is titled ".$_POST['project_name'].".  It is attached.";

	/* GET File Variables */ 
	$tmpName = $_FILES['file']['tmp_name']; 
	$fileType = $_FILES['file']['type']; 
	$fileName = $_FILES['file']['name']; 

	/* Start of headers */ 
	$headers = "From: $fromName"; 

	if (file($tmpName) && $fileType == "application/zip") { 
		if(filesize($tmpName) > "1000"){
			$error = "That file is too big.  This is the \"10k challenge\" numbnuts.";
		} else {
			/* Reading file ('rb' = read binary)*/
			$file = fopen($tmpName,'rb'); 
			$data = fread($file,filesize($tmpName)); 
			fclose($file); 
		
	
			/* a boundary string */
			$randomVal = md5(time()); 
			$mimeBoundary = "==Multipart_Boundary_x{$randomVal}x"; 
	
			/* Header for File Attachment */
			$headers .= "\nMIME-Version: 1.0\n"; 
			$headers .= "Content-Type: multipart/mixed;\n" ;
			$headers .= " boundary=\"{$mimeBoundary}\""; 
	
			/* Multipart Boundary above message */
			$message = "This is a multi-part message in MIME format.\n\n" . 
			"--{$mimeBoundary}\n" . 
			"Content-Type: text/plain; charset=\"iso-8859-1\"\n" . 
			"Content-Transfer-Encoding: 7bit\n\n" . 
			$message . "\n\n"; 
	
			/* Encoding file data */
			$data = chunk_split(base64_encode($data)); 
	
			/* Adding attchment-file to message*/
			$message .= "--{$mimeBoundary}\n" . 
			"Content-Type: {$fileType};\n" . 
			" name=\"{$fileName}\"\n" . 
			"Content-Transfer-Encoding: base64\n\n" . 
			$data . "\n\n" . 
			"--{$mimeBoundary}--\n";

			$flgchk = mail ("$to", "$subject", "$message", "$headers"); 
		}
	} 
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Developer 10k Challenge</title>
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
	<link rel="stylesheet" href="/assets/css/style.css" type="text/css" media="all" title="" charset="utf-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/assets/js/site.js" type="text/javascript" charset="utf-8"></script>
	
</head>
<body>
	<header>
		
	</header>
	<div id="wrapper">
		
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
			<input type="text" name="project_name" placeholder="Project Name" id="project_name">
			<div class="file-upload-wrapper">
				<input type="file" name="file" value="" id="file-upload">
				<div id="file-input-overlay">Upload Project</div>
			</div>
			<input type="hidden" name="project_submitted" value="true">
			<input type="submit" name="sub" value="Submit" id="sub">
		</form>
		
	</div>
	
</body>
</html>