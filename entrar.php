<?php include_once('includes/bdd.php'); ?>
<!DOCTYPE html>
<html>
<?php head(); ?>
<body>
	<?php headerr(); ?>
	<div class="container">
		<div class="row mb-4">
			<div class="col-md-12">
				<div class="text-center">
					<h3 class="fw-bold m-0">Entrar</h3>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="page">
					<form method="POST">
						<div class="mb-3">
							<label class="mb-2">E-mail</label>
							<input type="email" class="form-control" name="email" placeholder="Digite seu e-mail..">
						</div>
						<div class="mb-3">
							<label class="mb-2">Senha</label>
							<input type="password" class="form-control" name="senha" placeholder="Digite sua senha..">
						</div>
						<input type="hidden" name="entrar">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn w-100">Entrar <i class="fa-solid fa-right-to-bracket"></i></button>
                        </div>
					</form>
					<p class="mt-3">Ainda não tem conta? <a href="<?php echo PATH.'criar-conta/'; ?>">Criar uma agora</a></p>
				</div>
			</div>
		</div>
	</div>
	<?php footer(); ?>
</body>
</html>