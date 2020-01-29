<?php
	require_once 'autoload.php';

	$genres = DB::getAllGenres();

	if ($_POST) {
		$movieToSave = new Movie($_POST['title'], $_POST['rating'], $_POST['awards'], $_POST['release_date']);

		$movieToSave->setLength($_POST['length']);
		$movieToSave->setGenreID($_POST['genre_id']);

		$saved = DB::saveMovie($movieToSave);
	}

	$pageTitle = 'Crear película';
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
									<label>Título:</label>
									<input type="text" class="form-control" placeholder="Ej: Star Wars" name="title">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Rating:</label>
									<input type="text" class="form-control" placeholder="Ej: 8.5" name="rating">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Premios:</label>
									<input type="text" class="form-control" placeholder="Ej: 5" name="awards">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Fecha de lanzamiento:</label>
									<input type="date" class="form-control" name="release_date" value="2019-01-25">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Duración:</label>
									<input type="text" class="form-control" placeholder="Ej: 120" name="length">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>Género:</label>
									<select class="form-control" name="genre_id">
										<option value="">Elegí un género</option>
										<?php foreach ($genres as $genre): ?>
											<option value="<?php echo $genre->getID() ?>"><?php echo $genre->getName() ?></option>
										<?php endforeach; ?>
									</select>
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
					<?php echo $saved ? '¡Película guarda con éxito!' : '¡No se pudo guardar la película!' ?>
				</div>
			<?php endif; ?>
		</div>
	</body>
</html>
