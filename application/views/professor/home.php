<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http_equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" type="text/css" />

	<title>Home - Sistema Estágio</title>
</head>

<body>
	<div class="container">
		<div class="form">
			<form action="#">
				<div class="form-header">
					<div class="title">
						<h1>Bem vindo ao Sistema de Estágio</h1>
					</div>
					<div class="input-group">
						<div class="inputBox">
							<label for="RA" class="labelInput">RA Aluno</label>
							<input type="text" name="RA" id="RA" class="inputUser" maxlength="10" required placeholder="Digite o RA do aluno">
						</div>

						<div class="inputBox">
							<label for="id_curso" class="labelInput">ID curso</label>
							<input type="text" name="id_curso" id="id_curso" class="inputUser" required placeholder="Digite seu endereço">
						</div>

						<div class="inputBox">
							<label for="nome" class="labelInput">Nome Aluno</label>
							<input type="text" name="nome" id="nome" class="inputUser" required placeholder="Digite o nome do aluno">
						</div>

						<div class="inputBox">
							<label for="estatus" class="labelInput">Estatus</label>
							<input type="text" name="estatus" id="estatus" class="inputUser" required>
						</div>


						<!-- MÉTODOS PARA ALUNO -->

						<div class="inputBox">
							<label for="" class="labelInput">Métodos</label>
							<select name="metodos" id="metodos">
								<option value="inserir">Inserir</option>
								<option value="consultar">Consultar</option>
								<option value="alterar">Alterar</option>
								<option value="apagar">Apagar</option>
								<option value="ativar">Ativar</option>
							</select>
						</div>

						<div class="continue-button">
							<button type="button" id="insertBtn" class="btn btn-success btn-block">
								Continuar
							</button>
						</div>
					</div>
				</div>
				<!--------------------------------------------------------------- CSS ---------------------------------------------------------------->
				<style>
					@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

					* {
						margin: 0;
						padding: 0;
						box-sizing: border-box;
						font-family: 'Poppins', sans-serif;
					}

					body {
						width: 100%;
						height: 100vh;
						display: flex;
						justify-content: center;
						align-items: center;
						background: #007bff;
					}

					.container {
						width: 80%;
						height: 68vh;
						display: flex;
						margin-left: 40rem;
						margin-top: 5rem;
					}

					.form {
						width: 50%;
						display: flex;
						justify-content: center;
						align-items: center;
						flex-direction: column;
						background-color: #fff;
						padding: 3rem;
					}

					.form-header {
						margin-bottom: 3rem;
						display: flex;
						justify-content: space-between;
					}

					.login-button {
						display: flex;
						align-items: center;
					}


					.continue-button {
						display: flex;
						align-items: center;
					}

					.continue-button button {
						position: absolute;
						border: none;
						background-color: #28a745;
						padding: 0.9rem 1rem;
						border-radius: 5px;
						cursor: pointer;
						margin-top: 30rem;
						margin-left: -34rem;
						width: 27.5%;
					}

					.continue-button button a {
						text-decoration: none;
						font-weight: 500;
						color: #fff;
					}

					.continue-button button:hover {
						background-color: #baa9fc;
					}

					.form-header h1 {
						position: absolute;
						margin-top: -6rem;
					}

					.form-header h1::after {
						content: '';
						display: block;
						width: 5rem;
						height: 0.3rem;
						background-color: #28a745;
						margin: 0 auto;
						position: absolute;
						border-radius: 10px;
					}


					/* CSS INPUT BOX*/

					.input-group {
						display: flex;
						flex-wrap: wrap;
						justify-content: space-between;
						padding: 1rem 0;
					}

					.inputBox {
						display: flex;
						flex-direction: column;
						margin-bottom: 1.1rem;
					}

					.inputBox input {
						margin: 0.6rem 0;
						padding: 0.8rem 1.2rem;
						border: none;
						border-radius: 10px;
						box-shadow: 1px 1px 6px #0000001c;
					}

					.inputBox input:hover {
						background-color: #eeeeee75;
					}

					.inputBox input:focus-visible {
						outline: 1px solid #baa9fc;
					}

					.inputBox label {
						font-size: 0.75rem;
						font-weight: 600;
						color: #000000c0;
					}

					/* CSS MÉTODOS */
				</style>

				<!------------------------------------------------------------------- SCRIPT --------------------------------------------------------->

				<script src="<?php echo base_url("assets/js/jquery-3.6.0.min.js"); ?>" type="text/javascript"></script>
				<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>" type="text/javascript"></script>
				<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

				<script type="text/javascript" charset="utf-8">
					var base_url = "<?= base_url(); ?>"
					$(document).ready(function() {
						$('#insertBtn').on('click', async function(e) {
							e.preventDefault();

							var select = document.getElementById("metodos");

							if (select.value === "inserir") {
								const config = {
									method: "post",
									headers: {
										'Accept': 'application/json',
										'Content-Type': 'application/json'
									},
									body: JSON.stringify({
										ra: $('#loginTxt').val(),
										idCurso: $('#senhaTxt').val(),
										nome: $('#nomeTxt').val(),
										estatus: $('#estatusTxt').val()
									})
								};

								const request = await fetch(base_url + 'aluno/inserirAluno', config);
								const response = await request.json();

								if (response.codigo == 1) {

									Swal.fire({
										title: 'Aluno cadastrado',
										text: '',
										icon: 'success',
									});
								} else {
									Swal.fire({
										title: 'Atenção!',
										text: response.codigo + ' - ' + response.msg,
										icon: 'error'
									});
								}
							}
						});
					});
				</script>
</body>

</html>
