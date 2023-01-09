<?php

$consulta = 'consulta';
$campos = ['CEP','Logradouro','Complemento','Bairro','Cidade','Estado'];

?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

	<title>Consulta CEP</title>
</head>
<body class="bg-dark">
	<div class="container">
		<div class="row justify-content-center my-3">
			<div class="col-6">
				<div class="card border border-white bg-transparent text-white">
					<div class="card-body">
						<form action="" class="form">
							<div class="form-group">
								<label for="consulta">Consultar CEP</label>
								<input 
								type="text" 
								name="consulta" 
								id="consulta" 
								class="form-control"
								value="<?php echo ($_GET[$consulta]) ?? '' ?>"
								placeholder="00000-000"
								required
								autofocus
								/>
							</div>
							<div class="form-group text-center">
								<button type="submit" class="btn btn-primary">Consultar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<table class="table table-striped table-dark text-white">
					<thead>
						<tr>
							<?php

								foreach ($campos as $chave => $valor) echo "<th>{$valor}</th>";

							?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php

							if ($_GET[$consulta]) {

								$cleaner_cep = preg_replace("/[^0-9]/i", '', trim($_GET[$consulta]));
								$cep = substr($cleaner_cep, 0,8);

								if (strlen($cep) == 8) {

									$url = "https://viacep.com.br/ws/{$cep}/json/";
									$return = json_decode(file_get_contents($url), true);

									if (!isset($return['erro'])) {

										foreach ($campos as $chave => $valor) {

											switch(strtolower($valor)) {
												case 'cidade':
												$valor = 'localidade';
												break;
												case 'estado':
												$valor = 'uf';
												break;
											}

											echo "<td>{$return[strtolower($valor)]}</td>";

										}

									} else {
										echo "<td colspan='6' class='text-warning text-center'>
														O CEP [{$cep}] não foi localizado!</td>";
									}
								} else {
									echo "<td colspan='6' class='text-warning text-center'>
									O CEP [{$_GET[$consulta]}] é inválido para consulta!</td>";
								}

							} else {
								echo "<td colspan='6' class='text-warning text-center'>
														Por favor preencha o CEP!</td>";
							}

							?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>