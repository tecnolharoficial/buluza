<?php
	include_once('includes/bdd.php');
	$entselect = "SELECT * from anuncios WHERE id = :id AND id_anunciante = :id_anunciante";
    try {
        $entresult = $bdd->prepare($entselect);
        $entresult->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
        $entresult->bindParam(':id_anunciante', $usuario_logado_id, PDO::PARAM_STR);
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
				$ids_servicos = explode(',', $entexb['ids_servicos']);
				$ids_servicos_para = explode(',', $entexb['ids_servicos_para']);
				$ids_locais_de_atendimento = explode(',', $entexb['ids_locais_de_atendimento']);
				$email = $entexb['email'];
				$telefone = $entexb['telefone'];
				$whatsapp = $entexb['whatsapp'];
            }
            $omsselect = "SELECT * from anuncio_galeria WHERE id_anuncio = :id_anuncio ORDER BY posicao DESC";
            try {
                $omsresult = $bdd->prepare($omsselect);
                $omsresult->bindParam(':id_anuncio', $_GET['id'], PDO::PARAM_STR);
                $omsresult->execute();
                $omscontar = $omsresult->rowCount();
                if($omscontar > 0) {
                	$initialImageURLs = array();
                    while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
                    	$initialImageURLs[] = PATH.'assets/img/anuncios/'.$omsmost->img;
                    }
                    $initialImageURLs = "'".implode("','", $initialImageURLs)."'";
                }
            }
            catch(PDOException $e) {
		        echo $e;
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
					<h3 class="fw-bold m-0">Editar: <?php echo $titulo; ?></h3>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="page">
					<form method="POST" enctype="multipart/form-data">
						<strong>Seu anúncio</strong>
						<hr>
						<div class="mb-3">
							<label class="mb-2">Categoria</label>
							<select class="form-select" name="categoria">
								<option value <?php if(empty($id_categoria)) { echo 'selected'; } ?> disabled>Selecione uma opção</option>
<?php
								$omsselect = "SELECT * from categorias";
					            try {
					                $omsresult = $bdd->prepare($omsselect);
					                $omsresult->execute();
					                $omscontar = $omsresult->rowCount();
					                if($omscontar > 0) {
					                    while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
					                    	if($id_categoria == $omsmost->id) {
					                    		echo '<option value="'.$omsmost->id.'" selected>'.$omsmost->nome.'</option>';
					                    	}
					                    	else {
					                    		echo '<option value="'.$omsmost->id.'">'.$omsmost->nome.'</option>';
					                    	}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
							</select>
						</div>
						<div class="mb-3">
                            <div class="row">
                                <div class="col-lg mb-lg-0 mb-3">
                                	<label class="mb-2">Estado</label>
                                    <select class="form-select" name="estado">
                                        <option value selected disabled>Selecione uma opção</option>
                                    </select>
                                </div>
                                <div class="col-lg">
                                	<label class="mb-2">Cidade</label>
                                    <select class="form-select" name="cidade">
                                        <option value selected disabled>Selecione uma opção</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
							<label class="mb-2">Código Postal</label>
							<input type="text" class="form-control cep" name="cep" placeholder="Digite seu cep.." <?php if(!empty($cep)) { echo 'value="'.$cep.'"'; } ?>>
						</div>
                        <div class="mb-3">
							<label class="mb-2">Endereço</label>
							<input type="text" class="form-control" name="endereco" placeholder="Digite seu endereço.." <?php if(!empty($endereco)) { echo 'value="'.$endereco.'"'; } ?>>
						</div>
						<div class="mb-3">
							<label class="mb-2">Bairro</label>
							<input type="text" class="form-control" name="bairro" placeholder="Digite seu bairro.." <?php if(!empty($bairro)) { echo 'value="'.$bairro.'"'; } ?>>
						</div>
						<hr>
						<strong>Seus dados</strong>
						<hr>
						<div class="mb-3">
							<label class="mb-2">Idade</label>
							<input type="text" class="form-control" name="idade" placeholder="Digite sua idade.." <?php if(!empty($idade)) { echo 'value="'.$idade.'"'; } ?>>
						</div>
						<div class="mb-3">
							<label class="mb-2">Título</label>
							<input type="text" class="form-control" name="titulo" placeholder="Digite seu título.." <?php if(!empty($titulo)) { echo 'value="'.$titulo.'"'; } ?>>
						</div>
						<div class="mb-3">
							<label class="mb-2">Sobre</label>
							<textarea class="form-control" name="sobre" placeholder="Use este espaço para descrever a si mesmo e seu corpo, falar de suas habilidades, do que gosta..." rows="4"><?php if(!empty($sobre)) { echo $sobre; } ?></textarea>
						</div>
						<hr>
						<strong>Sobre você</strong>
						<hr>
						<div class="mb-3">
							<label class="mb-2">Nacionalidade</label>
							<select class="form-select" name="nacionalidade">
								<option value <?php if(empty($id_nacionalidade)) { echo 'selected'; } ?> disabled>Selecione uma opção</option>
<?php
								$omsselect_2 = "SELECT * from nacionalidades";
					            try {
					                $omsresult_2 = $bdd->prepare($omsselect_2);
					                $omsresult_2->execute();
					                $omscontar_2 = $omsresult_2->rowCount();
					                if($omscontar_2 > 0) {
					                    while($omsmost_2 = $omsresult_2->FETCH(PDO::FETCH_OBJ)) {
					                    	if($id_categoria == $omsmost_2->id) {
					                    		echo '<option value="'.$omsmost_2->id.'" selected>'.$omsmost_2->nome.'</option>';
					                    	}
					                    	else {
					                    		echo '<option value="'.$omsmost_2->id.'">'.$omsmost_2->nome.'</option>';
					                    	}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
							</select>
						</div>
						<div class="mb-3">
							<label class="mb-2 d-block">Etnia</label>
<?php
								$omsselect_3 = "SELECT * from etnias";
					            try {
					                $omsresult_3 = $bdd->prepare($omsselect_3);
					                $omsresult_3->execute();
					                $omscontar_3 = $omsresult_3->rowCount();
					                if($omscontar_3 > 0) {
					                    while($omsmost_3 = $omsresult_3->FETCH(PDO::FETCH_OBJ)) {
					                    	if($id_etnia == $omsmost_3->id) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="etnia_'.$omsmost_3->id.'" name="etnia" value="'.$omsmost_3->id.'" checked>
													  	<label class="btn btn-outline" for="etnia_'.$omsmost_3->id.'">'.$omsmost_3->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="etnia_'.$omsmost_3->id.'" name="etnia" value="'.$omsmost_3->id.'">
													  	<label class="btn btn-outline" for="etnia_'.$omsmost_3->id.'">'.$omsmost_3->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<div class="mb-3">
							<label class="mb-2 d-block">Seios</label>
<?php
								$omsselect_4 = "SELECT * from seios";
					            try {
					                $omsresult_4 = $bdd->prepare($omsselect_4);
					                $omsresult_4->execute();
					                $omscontar_4 = $omsresult_4->rowCount();
					                if($omscontar_4 > 0) {
					                    while($omsmost_4 = $omsresult_4->FETCH(PDO::FETCH_OBJ)) {
					                    	if($id_seio == $omsmost_4->id) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="seio_'.$omsmost_4->id.'" name="seio" value="'.$omsmost_4->id.'" checked>
													  	<label class="btn btn-outline" for="seio_'.$omsmost_4->id.'">'.$omsmost_4->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="seio_'.$omsmost_4->id.'" name="seio" value="'.$omsmost_4->id.'">
													  	<label class="btn btn-outline" for="seio_'.$omsmost_4->id.'">'.$omsmost_4->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<div class="mb-3">
							<label class="mb-2 d-block">Cabelo</label>
<?php
								$omsselect_5 = "SELECT * from cabelos";
					            try {
					                $omsresult_5 = $bdd->prepare($omsselect_5);
					                $omsresult_5->execute();
					                $omscontar_5 = $omsresult_5->rowCount();
					                if($omscontar_5 > 0) {
					                    while($omsmost_5 = $omsresult_5->FETCH(PDO::FETCH_OBJ)) {
					                    	if($id_cabelo == $omsmost_5->id) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="cabelo_'.$omsmost_5->id.'" name="cabelo" value="'.$omsmost_5->id.'" checked>
													  	<label class="btn btn-outline" for="cabelo_'.$omsmost_5->id.'">'.$omsmost_5->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="cabelo_'.$omsmost_5->id.'" name="cabelo" value="'.$omsmost_5->id.'">
													  	<label class="btn btn-outline" for="cabelo_'.$omsmost_5->id.'">'.$omsmost_5->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<div class="mb-3">
							<label class="mb-2 d-block">Tipo de corpo</label>
<?php
								$omsselect_6 = "SELECT * from tipos_de_corpo";
					            try {
					                $omsresult_6 = $bdd->prepare($omsselect_6);
					                $omsresult_6->execute();
					                $omscontar_6 = $omsresult_6->rowCount();
					                if($omscontar_6 > 0) {
					                    while($omsmost_6 = $omsresult_6->FETCH(PDO::FETCH_OBJ)) {
					                    	if($id_tipo_de_corpo == $omsmost_6->id) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="tipo_de_corpo_'.$omsmost_6->id.'" name="tipo_de_corpo" value="'.$omsmost_6->id.'" checked>
													  	<label class="btn btn-outline" for="tipo_de_corpo_'.$omsmost_6->id.'">'.$omsmost_6->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="radio" class="btn-check" id="tipo_de_corpo_'.$omsmost_6->id.'" name="tipo_de_corpo" value="'.$omsmost_6->id.'">
													  	<label class="btn btn-outline" for="tipo_de_corpo_'.$omsmost_6->id.'">'.$omsmost_6->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<hr>
						<strong>Serviços</strong>
						<hr>
						<div class="mb-3">
							<label class="mb-2 d-block">Serviços</label>
<?php
								$omsselect_7 = "SELECT * from servicos";
					            try {
					                $omsresult_7 = $bdd->prepare($omsselect_7);
					                $omsresult_7->execute();
					                $omscontar_7 = $omsresult_7->rowCount();
					                if($omscontar_7 > 0) {
					                    while($omsmost_7 = $omsresult_7->FETCH(PDO::FETCH_OBJ)) {
					                    	if(in_array($omsmost_7->id, $ids_servicos)) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="checkbox" class="btn-check" id="servico_'.$omsmost_7->id.'" name="servicos[]" value="'.$omsmost_7->id.'" checked>
													  	<label class="btn btn-outline" for="servico_'.$omsmost_7->id.'">'.$omsmost_7->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="checkbox" class="btn-check" id="servico_'.$omsmost_7->id.'" name="servicos[]" value="'.$omsmost_7->id.'">
													  	<label class="btn btn-outline" for="servico_'.$omsmost_7->id.'">'.$omsmost_7->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<div class="mb-3">
							<label class="mb-2 d-block">Serviços para</label>
<?php
								$omsselect_8 = "SELECT * from servicos_para";
					            try {
					                $omsresult_8 = $bdd->prepare($omsselect_8);
					                $omsresult_8->execute();
					                $omscontar_8 = $omsresult_8->rowCount();
					                if($omscontar_8 > 0) {
					                    while($omsmost_8 = $omsresult_8->FETCH(PDO::FETCH_OBJ)) {
					                    	if(in_array($omsmost_8->id, $ids_servicos_para)) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="checkbox" class="btn-check" id="servico_para_'.$omsmost_8->id.'" name="servicos_para[]" value="'.$omsmost_8->id.'" checked>
													  	<label class="btn btn-outline" for="servico_para_'.$omsmost_8->id.'">'.$omsmost_8->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="checkbox" class="btn-check" id="servico_para_'.$omsmost_8->id.'" name="servicos_para[]" value="'.$omsmost_8->id.'">
													  	<label class="btn btn-outline" for="servico_para_'.$omsmost_8->id.'">'.$omsmost_8->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<div class="mb-3">
							<label class="mb-2 d-block">Local de atendimento</label>
<?php
								$omsselect_9 = "SELECT * from locais_de_atendimento";
					            try {
					                $omsresult_9 = $bdd->prepare($omsselect_9);
					                $omsresult_9->execute();
					                $omscontar_9 = $omsresult_9->rowCount();
					                if($omscontar_9 > 0) {
					                    while($omsmost_9 = $omsresult_9->FETCH(PDO::FETCH_OBJ)) {
					                    	if(in_array($omsmost_9->id, $ids_locais_de_atendimento)) {
					                    		echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="checkbox" class="btn-check" id="local_de_atendimento_'.$omsmost_9->id.'" name="locais_de_atendimento[]" value="'.$omsmost_9->id.'" checked>
													  	<label class="btn btn-outline" for="local_de_atendimento_'.$omsmost_9->id.'">'.$omsmost_9->nome.'</label>
													</div>';
					                    	}
					                    	else {
						                    	echo '
							                    	<div class="form-check form-check-inline">
													  	<input type="checkbox" class="btn-check" id="local_de_atendimento_'.$omsmost_9->id.'" name="locais_de_atendimento[]" value="'.$omsmost_9->id.'">
													  	<label class="btn btn-outline" for="local_de_atendimento_'.$omsmost_9->id.'">'.$omsmost_9->nome.'</label>
													</div>';
											}
					                    }
									}
								}
								catch(PDOException $e) {
					                echo $e;
					            }
?>
						</div>
						<hr>
						<strong>Seus contatos</strong>
						<hr>
						<div class="mb-3">
							<label class="mb-2">E-mail</label>
							<input type="email" class="form-control" name="email" placeholder="Digite seu e-mail.." <?php if(!empty($email)) { echo 'value="'.$email.'"'; } ?>>
						</div>
						<div class="mb-3">
							<label class="mb-2">Telefone</label>
							<input type="text" class="form-control sp_celphones" name="telefone" placeholder="Digite seu telefone.." <?php if(!empty($telefone)) { echo 'value="'.$telefone.'"'; } ?>>
						</div>
						<div class="mb-3">
							<label class="mb-2">Possuí WhatsApp?</label>
							<div class="form-check form-switch">
							  	<input class="form-check-input" type="checkbox" id="whatsapp" name="whatsapp" <?php if(!empty($whatsapp)) { echo 'checked'; } ?>>
							  	<label class="form-check-label" for="whatsapp">Não / Sim</label>
							</div>
						</div>
						<div class="mb-3">
							<label class="mb-2">Fotos</label>
							<input type="file" class="form-control" name="file[]" multiple>
						</div>
						<input type="hidden" name="atualizar_anuncio" value="<?php echo $_GET['id']; ?>">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn w-100">Salvar <i class="fa-solid fa-circle-plus"></i></button>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php footer($initialImageURLs); ?>
	<script type="text/javascript">
		$.getJSON(PATH + 'assets/json/estados_cidades.json', (data) => {
	        let items = [];
	        let options = '<option selected value disabled>Selecione o estado</option>';
	        for(val of data) {
	        	if(val.nome == '<?php echo $estado; ?>') {
	        		options += '<option value="' + val.nome + '" selected>' + val.nome + '</option>';
	        	}
	        	else {
	            	options += '<option value="' + val.nome + '">' + val.nome + '</option>';
	            }
	        }
	        $('select[name="estado"]').html(options);
	        $('select[name="estado"]').change( () => {
	        	let options_cidades = '<option selected value disabled>Selecione a cidade</option>';
	            let str = $('select[name="estado"]').val();
	            for(val of data) {
	                if(val.nome == str) {
	                    for(val_city of val.cidades) {
	                    	if(val_city == '<?php echo $cidade; ?>') {
	                        	options_cidades += '<option value="' + val_city + '" selected>' + val_city + '</option>';
	                        }
	                        else {
	                        	options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
	                        }
	                    }
	                }
	            }
	            $('select[name="cidade"]').html(options_cidades);
	        }).change();
	    });
	</script>
</body>
</html>