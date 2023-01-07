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
								value="<?php echo ($_GET['consulta']) ?? '' ?>"
								placeholder="00000-000"
								/>
							</div>
							<div class="form-group text-center">
								<button type="submit" class="btn btn-primary">Consutlar</button>
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
							<th>CEP</th>
							<th>Logradouro</th>
							<th>Complemento</th>
							<th>Bairro</th>
							<th>Cidade</th>
							<th>Estado</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php

							if ($_GET) {

								foreach ($_GET as $key => $value) {

									if (empty($value)) {

										echo "<td class='text-center text-warning' colspan='6'>O campo CEP está vazio</td>";

									} elseif (strlen($value) >= 8 || strlen($value) <= 9) {

										$char_separator = (strlen($value) == 9) ? 
															substr($value,5, -3) : '';

										$value = str_replace($char_separator, '', $value);

										if (preg_match("/^[0-9]*$/", $value)) {

											$return = json_decode(file_get_contents("https://viacep.com.br/ws/{$value}/json/"), true);

											if (!isset($return['erro'])) {

												echo "<td>{$return['cep']}</td>";
												echo "<td>{$return['logradouro']}</td>";
												echo "<td>{$return['complemento']}</td>";
												echo "<td>{$return['bairro']}</td>";
												echo "<td>{$return['localidade']}</td>";
												echo "<td>{$return['uf']}</td>";

											} else {

												echo "<td class='text-center text-warning' colspan='6'>CEP não encontrado!</td>";

											}

										} else {

											echo "<td class='text-center text-danger' colspan='6'>O valor <span class='text-white'>{$value}</span> não é um CEP válido!</td>";
										}

									} else {

										echo "<td class='text-center text-warning' colspan='6'>CEP inválido, quantidade máxima aceita de numeros é 8</td>";
									}

								}

							} else {

								echo "<td class='text-center' colspan='6'>Não existem dados para serem exibidos</td>";
							}
							?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row shadow border border-info">
			<div class="col">
				<h3 class="text-warning text-center my-2">Lista de normalizações e correções</h3>
				<ol class="nav flex-column text-info">
					<li class="nav-item">Envio de consulta VAZIO</li>
					<li class="nav-item">CEP com menos de 8 caracteres ou mais de 9</li>
					<li class="nav-item">Caractere separador diferente de '-' correção dinâmica</li>
					<li class="nav-item">Somente números</li>
					<li class="nav-item">CEP não encontrado</li>
					<li class="nav-item">CEP inválido</li>
				</ol>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>