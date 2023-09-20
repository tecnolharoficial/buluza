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
					<h3 class="fw-bold m-0">Criar conta</h3>
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
						<div class="mb-3">
							<label class="mb-2">Confirme a Senha</label>
							<input type="password" class="form-control" name="confirme_sua_senha" placeholder="Confirme sua senha..">
						</div>
						<input type="hidden" name="criar_conta">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn w-100">Criar conta <i class="fa-solid fa-circle-plus"></i></button>
                        </div>
					</form>
					<p class="mt-3">Já possuí uma conta? <a href="<?php echo PATH.'entrar/'; ?>">Clique para entrar</a></p>
				</div>
			</div>
		</div>
	</div>
	<?php footer(); ?>
</body>
</html>