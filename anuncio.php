<?php
	include_once('includes/bdd.php');
	$entselect = "SELECT * from anuncios WHERE id = :id";
    try {
        $entresult = $bdd->prepare($entselect);
        $entresult->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
        $entresult->execute();
        $entcontar = $entresult->rowCount();
        if($entcontar > 0) {
            $entloop = $entresult->fetchAll();
            foreach($entloop as $entexb) {
                $id_categoria = $entexb['id_categoria'];
				$estado = $entexb['estado'];
				$cidade = $entexb['cidade'];
				$cep = $entexb['cep'];
				$endereco = $entexb['endereco'];
				$bairro = $entexb['bairro'];
				$idade = $entexb['idade'];
				$titulo = $entexb['titulo'];
				$sobre = $entexb['sobre'];
				$id_nacionalidade = $entexb['id_nacionalidade'];
				$id_etnia = $entexb['id_etnia'];
				$id_seio = $entexb['id_seio'];
				$id_cabelo = $entexb['id_cabelo'];
				$id_tipo_de_corpo = $entexb['id_tipo_de_corpo'];
				$ids_servicos = $entexb['ids_servicos'];
				$ids_servicos_para = $entexb['ids_servicos_para'];
				$ids_locais_de_atendimento = $entexb['ids_locais_de_atendimento'];
				$email = $entexb['email'];
				$telefone = $entexb['telefone'];
				$whatsapp = $entexb['whatsapp'];
            }
        }
        else {
        	header("Location: ".PATH);
        }
    }
    catch(PDOException $e) {
        echo $e;
    }
?>
<!DOCTYPE html>
<html>
<?php head(); ?>
<body>
	<?php headerr(); ?>
	<div class="container">
		<div class="row mb-4">
			<div class="col-md-12">
				<div class="text-center">
					<h3 class="fw-bold m-0"><?php echo $titulo; ?></h3>
				</div>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col-md-12">
				<div class="page">
					<div class="slider">
						<div class="slide">
<?php
							$omsselect = "SELECT * from anuncio_galeria WHERE id_anuncio = :id_anuncio ORDER BY posicao ASC";
				            try {
				                $omsresult = $bdd->prepare($omsselect);
				                $omsresult->bindParam(':id_anuncio', $_GET['id'], PDO::PARAM_STR);
				                $omsresult->execute();
				                $omscontar = $omsresult->rowCount();
				                if($omscontar > 0) {
				                    while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
?>
				            			<img src="<?php echo contem_imagem($omsmost->img, 'anuncios'); ?>">
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
<?php
					if($omscontar >= 3) {
?>
					    <div class="d-flex justify-content-between gap-2 mt-3">
					    	<button type="button" id="prev" class="btn-outline w-100"><i class="fa-solid fa-arrow-left"></i> Anterior</button>
					    	<button type="button" id="next" class="btn w-100">Próximo <i class="fa-solid fa-arrow-right"></i></button>
					    </div>
<?php
					}
?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 mb-4">
				<div class="page">
					<h3 class="fw-bold"><i class="fa-solid fa-face-smile-wink"></i> Sobre mim</h3>
					<p><?php echo nl2br($sobre); ?></p>
					<p>
						<span class="badge"><?php echo $idade; ?> Anos</span>
						<span class="badge"><?php echo nome_nacionalidade($id_nacionalidade); ?></span>
						<span class="badge"><?php echo nome_seio($id_seio); ?></span>
						<span class="badge"><?php echo nome_cabelo($id_cabelo); ?></span>
						<span class="badge"><?php echo nome_tipo_de_corpo($id_tipo_de_corpo); ?></span>
					</p>
				</div>
			</div>
			<div class="col-md-12 mb-4">
				<div class="page">
					<h3 class="fw-bold"><i class="fa-regular fa-heart"></i> Serviços</h3>
					<p>
<?php
						$ids_servicos = explode(',', $ids_servicos);
						foreach($ids_servicos as $id_servico) {
							echo '<span class="badge">'.nome_servico($id_servico).'</span>';
						}
?>
					</p>
				</div>
			</div>
			<div class="col-md-12 mb-4">
				<div class="page">
					<h3 class="fw-bold"><i class="fa-regular fa-user"></i> Serviços para</h3>
					<p>
<?php
						$ids_servicos_para = explode(',', $ids_servicos_para);
						foreach($ids_servicos_para as $id_servico_para) {
							echo '<span class="badge">'.nome_servico($id_servico_para).'</span>';
						}
?>
					</p>
				</div>
			</div>
			<div class="col-md-12">
				<div class="page">
					<h3 class="fw-bold"><i class="fa-regular fa-map"></i> Local de atendimento</h3>
					<p>
<?php
						$ids_locais_de_atendimento = explode(',', $ids_locais_de_atendimento);
						foreach($ids_locais_de_atendimento as $id_local_de_atendimento) {
							echo '<span class="badge">'.nome_local_de_atendimento($id_local_de_atendimento).'</span>';
						}
?>
					</p>
				</div>
			</div>
		</div>
		<hr class="mt-4 mb-4">
		<div class="row justify-content-center text-center">
			<div class="col-md-6">
				<h3 class="fw-bold">Entre em contato comigo</h3>
				<div class="d-flex justify-content-between gap-2">
					<a href="tel:+55<?php echo somente_numero($telefone); ?>" class="btn w-100" target="_Blank"><i class="fa-solid fa-phone"></i> Telefone</a>
<?php
					if($whatsapp == 'on') {
?>
						<a href="https://api.whatsapp.com/send?phone=55<?php echo somente_numero($telefone); ?>" class="btn whatsapp w-100" target="_Blank"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
<?php
					}
?>
				</div>
			</div>
		</div>
	</div>
	<?php footer(); ?>
</body>
</html>