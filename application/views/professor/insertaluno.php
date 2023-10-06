<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http_equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/sweetalert2.min.css"); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>" type="text/css" />

	<title>Login - Sistema Estágio</title>
</head>

<body class="h-100 bg-primary">
	<div class="container-fluid d-flex aling-items-center justify-content-center">
		<div class="content bg-light">
			<h1 class="text-center">Inserir Aluno</h1>
			<form method="post">
				<div class="form-group mb-4">
					<label for="loginTxt" class="control-label">RA Aluno:</label>
					<input class="form-control bg-primary text-light" placeholder="Digite o RA do aluno" name="loginTxt" id="loginTxt" maxlength="15" />
				</div>
				<div class="form-group mb-4">
					<label for="senhaTxt" class="control-label">ID Curso:</label>
					<input class="form-control bg-primary text-light" placeholder="Digite o ID do curso" name="senhaTxt" id="senhaTxt" maxlength="20" />
				</div>
				<div class="form-group mb-4">
					<label for="nomeTxt" class="control-label">Nome do Aluno:</label>
					<input class="form-control bg-primary text-light" placeholder="Digite o nome do aluno" name="nomeTxt" id="nomeTxt" maxlength="20" />
				</div>
				<div class="form-group mb-4">
					<label for="estatusTxt" class="control-label">Estatus:</label>
					<input class="form-control bg-primary text-light" placeholder="Estatus aluno" name="estatusTxt" id="estatusTxt" maxlength="1" />
				</div>
				<div class="row m-0 p-0">
					<button type="button" id="insertBtn" class="btn btn-success btn-block">
						INSERIR
					</button>
				</div>
			</form>
		</div>
	</div>
</body>

<script src="<?php echo base_url("assets/js/jquery-3.6.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/sweetalert2.all.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
	var base_url = "<?= base_url(); ?>"
	$(document).ready(function() {
		$('#insertBtn').on('click', async function(e) {
			e.preventDefault();

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
					title	: 'Aluno cadastrado',
					text 	: '',
					icon 	: 'success',
				});
			} else {
				Swal.fire({
					title: 'Atenção!',
					text: response.codigo + ' - ' + response.msg,
					icon: 'error'
				}); 
			}
		});
	});
</script>
</body>

</html>
