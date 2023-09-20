<?php
	include_once('includes/bdd.php');
	if(!empty($_GET['categoria'])) {
		$titulo = nome_categoria($_GET['categoria']);
        $id_categoria = 'AND id_categoria LIKE "%'.$_GET['categoria'].'%"';
    }
    else {
    	$titulo = 'Anúncios';
        $id_categoria = '';
    }
    if(!empty($_GET['termo'])) {
        $termo = 'AND titulo LIKE "%'.$_GET['termo'].'%" OR sobre LIKE "%'.$_GET['termo'].'%"';
    }
    else {
        $termo = '';
    }
    if(!empty($_GET['estado'])) {
        $estado = 'AND estado LIKE "%'.$_GET['estado'].'%"';
    }
    else {
        $estado = '';
    }
    if(!empty($_GET['cidade'])) {
        $cidade = 'AND cidade LIKE "%'.$_GET['cidade'].'%"';
    }
    else {
        $cidade = '';
    }
?>
<!DOCTYPE html>
<html>
<?php head(); ?>
<body>
	<?php headerr(); ?>
	<div class="container">
		<div class="row mb-5">
			<div class="col-md-12">
				<div class="text-center">
					<h3 class="fw-bold m-0"><?php echo $titulo; ?></h3>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
<?php
			$omsselect = "SELECT * from anuncios WHERE id > 0 $id_categoria $termo $estado $cidade";
            try {
                $omsresult = $bdd->prepare($omsselect);
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
							<a href="<?php echo PATH.'anuncio/?id='.$omsmost->id; ?>">
								<div class="card">
									<div class="row g-0 align-items-center">
										<div class="col-md-4">
											<img src="<?php echo contem_imagem($img, 'anuncios'); ?>" class="img-fluid rounded-start">
										</div>
										<div class="col-md-8">
											<div class="card-body">
												<h5 class="card-title"><?php echo $omsmost->titulo; ?></h5>
												<p class="card-text"><?php echo $omsmost->sobre; ?></p>
												<p class="card-text d-flex gap-2">
													<span class="badge"><?php echo $omsmost->idade; ?> Anos</span>
													<span class="badge"><?php echo nome_nacionalidade($omsmost->id_nacionalidade); ?></span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
<?php
					}
				}
				else {
					echo '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert"><span>Oops! Nenhum anúncio encontrado.</span></div>';
				}
			}
			catch(PDOException $e) {
                echo $e;
            }
?>
		</div>
	</div>
	<?php footer('', $_GET['categoria'], $_GET['termo']); ?>
</body>
</html>