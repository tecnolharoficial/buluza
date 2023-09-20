<?php include_once('includes/bdd.php'); ?>
<!DOCTYPE html>
<html>
<?php head(); ?>
<body>
	<?php headerr(); ?>
	<div class="container">
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="text-center">
					<h3 class="fw-bold m-0">Meus anúncios</h3>
					<span>Deseja sair da conta? <a href="<?php echo PATH.'?sair'; ?>">Clique aqui</a></span>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
<?php
			$omsselect = "SELECT * from anuncios WHERE id_anunciante = :id_anunciante";
            try {
                $omsresult = $bdd->prepare($omsselect);
                $omsresult->bindParam(':id_anunciante', $usuario_logado_id, PDO::PARAM_STR);
                $omsresult->execute();
                $omscontar = $omsresult->rowCount();
                if($omscontar > 0) {
                    while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
                    	$entselect = "SELECT * from anuncio_galeria WHERE id_anuncio = :id_anuncio";
				        try {
				            $entresult = $bdd->prepare($entselect);
				            $entresult->bindParam(':id_anuncio', $omsmost->id, PDO::PARAM_STR);
				            $entresult->execute();
				            $entcontar = $entresult->rowCount();
				            if($entcontar > 0) {
				                $entloop = $entresult->fetchAll();
				                foreach($entloop as $entexb) {
				                    $img = $entexb['img'];
				                }
				            }
				        }
				        catch(PDOException $e) {
				            echo $e;
				        }
?>
						<div class="col-md-12 mb-4">
							<div class="card">
								<div class="btns-fly d-flex justify-content-between gap-2">
									<a href="<?php echo PATH.'editar-anuncio/?id='.$omsmost->id; ?>" class="btn whatsapp"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
									<form method="POST">
										<input type="hidden" name="remover_anuncio" value="<?php echo $omsmost->id; ?>">
										<button type="submit" class="btn"><i class="fa-solid fa-trash"></i> Remover</button>
									</form>
								</div>
								<div class="row g-0 align-items-center">
									<div class="col-md-4">
										<img src="<?php echo contem_imagem($img, 'anuncios'); ?>" class="img-fluid rounded-start">
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<h5 class="card-title"><a href="<?php echo PATH.'anuncio/?id='.$omsmost->id; ?>" style="color: inherit;"><?php echo $omsmost->titulo; ?></a></h5>
											<p class="card-text"><?php echo $omsmost->sobre; ?></p>
											<p class="card-text d-flex gap-2">
												<span class="badge"><?php echo $omsmost->idade; ?></span>
												<span class="badge"><?php echo nome_nacionalidade($omsmost->id_nacionalidade); ?></span>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
<?php
					}
				}
				else {
					echo '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert"><span>Oops! Você não tem nenhum anúncio publicado ainda.</span></div>';
				}
			}
			catch(PDOException $e) {
                echo $e;
            }
?>
		</div>
	</div>
	<?php footer(); ?>
</body>
</html>