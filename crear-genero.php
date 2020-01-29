<?php
	require_once 'autoload.php';

	if ($_POST) {
		$genreToSave = new Genre($_POST['name'], $_POST['ranking'], $_POST['active']);

		$saved = DB::saveGenre($genreToSave);
	}

	$pageTitle = 'Crear género';
	require_once 'partials/head.php';
	require_once 'partials/navbar.php';
?>

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-10">
					<h2>Crear película</h2>
					<form method="post">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label>Nombre:</label>
									<input type="text" class="form-control" placeholder="Ej: Comedia" name="name">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Ranking:</label>
									<input type="text" class="form-control" placeholder="Ej: 10" name="ranking">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Activo:</label>
									<input type="text" class="form-control" placeholder="Ej: 1 ó 0" name="active">
								</div>
							</div>
							<div class="col-12 text-center">
								<button type="submit" class="btn btn-primary">GUARDAR</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php if (isset($saved)): ?>
				<div
					class="alert <?php echo $saved ? 'alert-success' : 'alert-danger'?>"
				>
					<?php echo $saved ? '¡Género guardado con éxito!' : '¡No se pudo guardar el género!' ?>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>
