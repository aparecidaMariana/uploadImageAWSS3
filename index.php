<?php

	use Aws\S3\Exception\S3Exception;

	if(isset($_FILES['fileToUpload'])){
		$file_name = $_FILES['fileToUpload']['name'];
		$temp_file_location = $_FILES['fileToUpload']['tmp_name'];

		require 'vendor/autoload.php';

		try {

			$s3 = new Aws\S3\S3Client([
				'region'  => 'us-east-1',
				'version' => 'latest',
				'credentials' => [
					'key'    => "",
					'secret' => "",
				]
			]);

			$result = $s3->putObject([
				'Bucket' => '',
				'Key'    => $file_name,
				'SourceFile' => $temp_file_location
			]);
			// var_dump($result);
			die;

		} catch (Exception $e) {
			// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
			// return a json object.
			die("Error: " . $e->getMessage());
		}

		//Criando diretório
		$bucketName = '';
		$keyName = 'wpUpload/' . date('Y') . '/' . date('m') . '/'. basename($_FILES["fileToUpload"]['name']);
		$pathInS3 = 'https://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;
		// Add it to S3
		try {
			// Uploaded:
			$file = $_FILES["fileToUpload"]['tmp_name'];
			$s3->putObject(
				array(
					'Bucket'=>$bucketName,
					'Key' =>  $keyName,
					'SourceFile' => $file,
					'StorageClass' => 'REDUCED_REDUNDANCY'
				)
			);
		} catch (S3Exception $e) {
			die('Error:' . $e->getMessage());
		} catch (Exception $e) {
			die('Error:' . $e->getMessage());
		}
		echo '<script>alert("Imagem enviada para o diretório: AWS - S3");</script>';



	}
?>


<!doctype html>
<html lang="en">
  	<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>

    	<style>
      		.bd-placeholder-img {
        		font-size: 1.125rem;
        		text-anchor: middle;
        		-webkit-user-select: none;
       			-moz-user-select: none;
        		-ms-user-select: none;
        		user-select: none;
     		}

      		@media (min-width: 768px) {
        		.bd-placeholder-img-lg {
          			font-size: 3.5rem;
       			}
      		}
			/* Custom page CSS
			-------------------------------------------------- */
			/* Not required for template or sticky footer method. */

			main > .container {
			  padding: 60px 15px 0;
			}

			.footer {
			  background-color: #f5f5f5;
			}

			.footer > .container {
			  padding-right: 15px;
			  padding-left: 15px;
			}

			code {
			  font-size: 80%;
			}
    	</style>
  	</head>
  	<body class="d-flex flex-column h-100">
    	<header>
		  	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		    	<a class="navbar-brand" href="#">UploadS3</a>
			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>

		  	</nav>
		</header>
		<!-- Begin page content -->
		<main role="main" class="flex-shrink-0">
		  <div class="container">
		    <h1 class="mt-5">Upload de Imagem na AWS S3</h1>
		    <p>Criação de diretório no bucket com upload de imagem na Amazon - S3 com PHP</p>
		    <p class="lead">
		    	<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
					<input type="file" name="fileToUpload" id="fileToUpload" />
					<input type="submit" value="Upload Image" name="submit"/>
				</form>
			</p>
		  </div>
		</main>

<!--		<footer class="footer mt-auto py-3">-->
<!--		  <div class="container">-->
<!--		    <span class="text-muted">Mariana Gomes 2019</span>-->
<!--		  </div>-->
<!--		</footer>-->


	    <!-- Optional JavaScript -->
	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  	</body>
</html>



