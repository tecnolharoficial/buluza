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
					<h3 class="fw-bold m-0">Encontros quentes na sua cidade</h3>
					<span>Anúncios de acompanhantes, transex e massagens na sua cidade</span>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
<?php
			$omsselect = "SELECT * from categorias";
            try {
                $omsresult = $bdd->prepare($omsselect);
                $omsresult->execute();
                $omscontar = $omsresult->rowCount();
                if($omscontar > 0) {
                    while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
?>
						<div class="col-md-4 mb-4">
							<a href="<?php echo PATH.'anuncios/?categoria='.$omsmost->id; ?>">
								<div class="card text-center">
									<div class="card-img">
										<img src="<?php echo $omsmost->img; ?>" class="card-img-top">
										<h4><i class="fa-solid fa-venus"></i> <?php echo $omsmost->nome; ?></h4>
									</div>
									<div class="card-body">
										<p class="card-text"><?php echo $omsmost->descricao; ?></p>
									</div>
								</div>
							</a>
						</div>
<?php
					}
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