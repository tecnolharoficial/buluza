<?php
    //Json
    header('Content-Type: application/json');
    //-----------------------------------------------------------------------------------
    
	//Incluir arquivo bdd.php
	include_once('includes/bdd.php');
	//-----------------------------------------------------------------------------------

	//Entrar
	if(isset($_POST['entrar'])) {
		$entselect = "SELECT * from anunciantes WHERE email = :email";
        try {
            $entresult = $bdd->prepare($entselect);
            $entresult->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    $entsenha = $entexb['senha'];
                }
                if(password_verify($_POST['senha'], $entsenha)) {
                    if(empty($_POST['lembre_de_mim'])) {
                        $_SESSION['email'.PATH] = $_POST['email'];
                        $_SESSION['senha'.PATH] = $entsenha;
                    }
                    else {
                        setcookie('email'.PATH, $_POST['email'], 2147483647, PATH);
                        setcookie('senha'.PATH, $entsenha, 2147483647, PATH);
                    }
                    echo json_encode(array('', 'Tudo certo! Estamos entrando..', PATH.'meus-anuncios/', ''));
                }
                else {
                    echo json_encode(['erro' => 'Oops! A senha digitada não confere.']);
                }
            }
            else {
                echo json_encode(['erro' => 'Oops! O e-mail digitado não foi encontrado.']);
            }
        }
        catch(PDOException $error) {
            echo $error;
        }
	}
	//-----------------------------------------------------------------------------------

	//Criar conta
	if(isset($_POST['criar_conta'])) {
		$entselect = "SELECT * from anunciantes WHERE email = :email";
        try {
            $entresult = $bdd->prepare($entselect);
            $entresult->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar == 0) {
                if($_POST['senha'] == $_POST['confirme_sua_senha']) {
                    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
					$cadinsert = "INSERT into anunciantes (email, senha, data_de_criacao) VALUES (:email, :senha, :data_de_criacao)";
			        try {
			            $cadresult = $bdd->prepare($cadinsert);
			            $cadresult->bindParam(':email' , strip_tags($_POST['email']), PDO::PARAM_STR);
			            $cadresult->bindParam(':senha' , $senha, PDO::PARAM_STR);
			            $cadresult->bindParam(':data_de_criacao' , date('Y-m-d H:i:s'), PDO::PARAM_STR);
			            $cadresult->execute();
			            $cadcontar = $cadresult->rowCount();
			            if($cadcontar > 0) {
			            	$_SESSION['email'.PATH] = $_POST['email'];
                            $_SESSION['senha'.PATH] = $senha;
			                echo json_encode(array('', 'Tudo certo! foi cadastrado com sucesso.', PATH.'meus-anuncios/', ''));
			            }
			        }
			        catch(PDOException $e) {
			            echo $e;
			        }
			    }
			    else {
			    	echo json_encode(['erro' => 'Oops! Senhas não conferem.']);
			    }
			}
			else {
				echo json_encode(['erro' => 'Oops! Esse e-mail já está cadastrado.']);
			}
		}
		catch(PDOException $e) {
            echo $e;
        }
	}
	//-----------------------------------------------------------------------------------

	//Públicar anúncio
	if(isset($_POST['publicar_anuncio'])) {
		if(!empty($_POST['servicos'])) {
			$_POST['servicos'] = implode(',', $_POST['servicos']);
		}
		if(!empty($_POST['servicos_para'])) {
			$_POST['servicos_para'] = implode(',', $_POST['servicos_para']);
		}
		if(!empty($_POST['locais_de_atendimento'])) {
			$_POST['locais_de_atendimento'] = implode(',', $_POST['locais_de_atendimento']);
		}
		$cadinsert = "INSERT into anuncios (id_categoria, estado, cidade, cep, endereco, bairro, idade, titulo, sobre, id_nacionalidade, id_etnia, id_seio, id_cabelo, id_tipo_de_corpo, ids_servicos, ids_servicos_para, ids_locais_de_atendimento, email, telefone, whatsapp, id_anunciante, data_de_criacao) VALUES (:id_categoria, :estado, :cidade, :cep, :endereco, :bairro, :idade, :titulo, :sobre, :id_nacionalidade, :id_etnia, :id_seio, :id_cabelo, :id_tipo_de_corpo, :ids_servicos, :ids_servicos_para, :ids_locais_de_atendimento, :email, :telefone, :whatsapp, :id_anunciante, :data_de_criacao)";
        try {
            $cadresult = $bdd->prepare($cadinsert);
            $cadresult->bindParam(':id_categoria' , strip_tags($_POST['categoria']), PDO::PARAM_STR);
            $cadresult->bindParam(':estado' , strip_tags($_POST['estado']), PDO::PARAM_STR);
            $cadresult->bindParam(':cidade' , strip_tags($_POST['cidade']), PDO::PARAM_STR);
            $cadresult->bindParam(':cep' , strip_tags($_POST['cep']), PDO::PARAM_STR);
            $cadresult->bindParam(':endereco' , strip_tags($_POST['endereco']), PDO::PARAM_STR);
            $cadresult->bindParam(':bairro' , strip_tags($_POST['bairro']), PDO::PARAM_STR);
            $cadresult->bindParam(':idade' , strip_tags($_POST['idade']), PDO::PARAM_STR);
            $cadresult->bindParam(':titulo' , strip_tags($_POST['titulo']), PDO::PARAM_STR);
            $cadresult->bindParam(':sobre' , strip_tags($_POST['sobre']), PDO::PARAM_STR);
            $cadresult->bindParam(':id_nacionalidade' , strip_tags($_POST['nacionalidade']), PDO::PARAM_STR);
            $cadresult->bindParam(':id_etnia' , strip_tags($_POST['etnia']), PDO::PARAM_STR);
            $cadresult->bindParam(':id_seio' , strip_tags($_POST['seio']), PDO::PARAM_STR);
            $cadresult->bindParam(':id_cabelo' , strip_tags($_POST['cabelo']), PDO::PARAM_STR);
            $cadresult->bindParam(':id_tipo_de_corpo' , strip_tags($_POST['tipo_de_corpo']), PDO::PARAM_STR);
            $cadresult->bindParam(':ids_servicos' , $_POST['servicos'], PDO::PARAM_STR);
            $cadresult->bindParam(':ids_servicos_para' , $_POST['servicos_para'], PDO::PARAM_STR);
            $cadresult->bindParam(':ids_locais_de_atendimento' , $_POST['locais_de_atendimento'], PDO::PARAM_STR);
            $cadresult->bindParam(':email' , strip_tags($_POST['email']), PDO::PARAM_STR);
            $cadresult->bindParam(':telefone' , strip_tags($_POST['telefone']), PDO::PARAM_STR);
            $cadresult->bindParam(':whatsapp' , strip_tags($_POST['whatsapp']), PDO::PARAM_STR);
            $cadresult->bindParam(':id_anunciante' , $usuario_logado_id, PDO::PARAM_STR);
            $cadresult->bindParam(':data_de_criacao' , date('Y-m-d H:i:s'), PDO::PARAM_STR);
            $cadresult->execute();
            $cadcontar = $cadresult->rowCount();
            if($cadcontar > 0) {
            	$lastInsertId = $bdd->lastInsertId();
            	$fileNames = json_decode($_POST['fileNames']);
            	if(isset($_FILES['file']) && is_array($_FILES['file']['name'])) {
			        $total_files = count($_FILES['file']['name']);
			        for($i = 0; $i < $total_files; $i++) {
			            $file_name = $_FILES['file']['name'][$i];
			            $file_tmp = $_FILES['file']['tmp_name'][$i];
			            $file_error = $_FILES['file']['error'][$i];
			            if($file_error === 0) {
			                $extensao = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
			                if(in_array($extensao, ['jpg', 'jpeg', 'png'])) {
			                    $novoNome = md5(microtime()).'.'.$extensao;
			                    $destino = ROOT.'assets/img/anuncios/'.$novoNome;
			                    if(move_uploaded_file($file_tmp, $destino)) {
			                    	$cadinsert = "INSERT into anuncio_galeria (img, posicao, id_anuncio, data_de_criacao) VALUES (:img, :posicao, :id_anuncio, :data_de_criacao)";
							        try {
							            $cadresult = $bdd->prepare($cadinsert);
							            $cadresult->bindParam(':img' , $novoNome, PDO::PARAM_STR);
							            $cadresult->bindParam(':posicao' , $i, PDO::PARAM_STR);
							            $cadresult->bindParam(':id_anuncio' , $lastInsertId, PDO::PARAM_STR);
							            $cadresult->bindParam(':data_de_criacao' , date('Y-m-d H:i:s'), PDO::PARAM_STR);
							            $cadresult->execute();
							        }
							        catch(PDOException $e) {
							            echo $e;
							        }
			                    }
			                }
			            }
			        }
			    }
			    $posicao = 0;
		        foreach($fileNames as $fileName) {
		        	$atlifsedit = $bdd->prepare("UPDATE anuncio_galeria set posicao = ? WHERE img = ?");
			        $atlifsedit->execute(array($posicao, $fileName));
			        $atlifsedit->execute();
			        $posicao++;
		        }
                echo json_encode(array('', 'Tudo certo! foi públicado com sucesso.', PATH.'meus-anuncios/', ''));
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
	}
	//-----------------------------------------------------------------------------------

	//Atualizar anúncio
	if(isset($_POST['atualizar_anuncio'])) {
		$fileNames = json_decode($_POST['fileNames']);
		if(isset($_FILES['file']) && is_array($_FILES['file']['name'])) {
	        $total_files = count($_FILES['file']['name']);
	        for($i = 0; $i < $total_files; $i++) {
	            $file_name = $_FILES['file']['name'][$i];
	            $file_tmp = $_FILES['file']['tmp_name'][$i];
	            $file_error = $_FILES['file']['error'][$i];
	            if($file_error === 0) {
	                $extensao = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	                if(in_array($extensao, ['jpg', 'jpeg', 'png'])) {
	                    $novoNome = md5(microtime()).'.'.$extensao;
	                    $destino = ROOT.'assets/img/anuncios/'.$novoNome;
	                    if(move_uploaded_file($file_tmp, $destino)) {
	                    	$cadinsert = "INSERT into anuncio_galeria (img, posicao, id_anuncio, data_de_criacao) VALUES (:img, :posicao, :id_anuncio, :data_de_criacao)";
					        try {
					            $cadresult = $bdd->prepare($cadinsert);
					            $cadresult->bindParam(':img' , $novoNome, PDO::PARAM_STR);
					            $cadresult->bindParam(':posicao' , $i, PDO::PARAM_STR);
					            $cadresult->bindParam(':id_anuncio' , $_POST['atualizar_anuncio'], PDO::PARAM_STR);
					            $cadresult->bindParam(':data_de_criacao' , date('Y-m-d H:i:s'), PDO::PARAM_STR);
					            if($cadresult->execute()) {
					            	$fileNames[] = $novoNome;
					            }
					        }
					        catch(PDOException $e) {
					            echo $e;
					        }
	                    }
	                }
	            }
	        }
	    }
	    $omsselect = "SELECT * from anuncio_galeria WHERE id_anuncio = :id_anuncio";
        try {
            $omsresult = $bdd->prepare($omsselect);
            $omsresult->bindParam(':id_anuncio' , $_POST['atualizar_anuncio'], PDO::PARAM_STR);
            $omsresult->execute();
            $omscontar = $omsresult->rowCount();
            if($omscontar > 0) {
                while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
                	if(!in_array($omsmost->img, $fileNames)) {
                		unlink(ROOT.'assets/img/anuncios/'.$omsmost->img);
	                	$vercodeeas = $bdd->prepare('DELETE FROM anuncio_galeria WHERE id = :id');
				        $vercodeeas->bindParam(':id' , $omsmost->id, PDO::PARAM_STR);
				        $vercodeeas->execute();
                	}
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
        $posicao = 0;
        foreach($fileNames as $fileName) {
        	$atlifsedit = $bdd->prepare("UPDATE anuncio_galeria set posicao = ? WHERE img = ?");
	        $atlifsedit->execute(array($posicao, $fileName));
	        $atlifsedit->execute();
	        $posicao++;
        }
		if(!empty($_POST['servicos'])) {
			$_POST['servicos'] = implode(',', $_POST['servicos']);
		}
		if(!empty($_POST['servicos_para'])) {
			$_POST['servicos_para'] = implode(',', $_POST['servicos_para']);
		}
		if(!empty($_POST['locais_de_atendimento'])) {
			$_POST['locais_de_atendimento'] = implode(',', $_POST['locais_de_atendimento']);
		}
	    $atlifsedit = $bdd->prepare("UPDATE anuncios set id_categoria = ?, estado = ?, cidade = ?, cep = ?, endereco = ?, bairro = ?, idade = ?, titulo = ?, sobre = ?, id_nacionalidade = ?, id_etnia = ?, id_seio = ?, id_cabelo = ?, id_tipo_de_corpo = ?, ids_servicos = ?, ids_servicos_para = ?, ids_locais_de_atendimento = ?, email = ?, telefone = ?, whatsapp = ? WHERE id = ? AND id_anunciante = ?");
        $atlifsedit->execute(array(strip_tags($_POST['categoria']), strip_tags($_POST['estado']), strip_tags($_POST['cidade']), strip_tags($_POST['cep']), strip_tags($_POST['endereco']), strip_tags($_POST['bairro']), strip_tags($_POST['idade']), strip_tags($_POST['titulo']), strip_tags($_POST['sobre']), strip_tags($_POST['nacionalidade']), strip_tags($_POST['etnia']), strip_tags($_POST['seio']), strip_tags($_POST['cabelo']), strip_tags($_POST['tipo_de_corpo']), $_POST['servicos'], $_POST['servicos_para'], $_POST['locais_de_atendimento'], strip_tags($_POST['email']), strip_tags($_POST['telefone']), strip_tags($_POST['whatsapp']), $_POST['atualizar_anuncio'], $usuario_logado_id));
        if($atlifsedit->execute()) {
            echo json_encode(array('', 'Tudo certo! Atualizado com sucesso.', '', ''));
        }
	}
	//-----------------------------------------------------------------------------------

	//Remover anúncio
	if(isset($_POST['remover_anuncio'])) {
		$omsselect = "SELECT * from anuncio_galeria WHERE id_anuncio = :id_anuncio";
        try {
            $omsresult = $bdd->prepare($omsselect);
            $omsresult->bindParam(':id_anuncio' , $_POST['remover_anuncio'], PDO::PARAM_STR);
            $omsresult->execute();
            $omscontar = $omsresult->rowCount();
            if($omscontar > 0) {
                while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
                	unlink(ROOT.'assets/img/anuncios/'.$omsmost->img);
                	$vercodeeas = $bdd->prepare('DELETE FROM anuncio_galeria WHERE id = :id');
			        $vercodeeas->bindParam(':id' , $omsmost->id, PDO::PARAM_STR);
			        $vercodeeas->execute();
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
		$vercodeeas = $bdd->prepare('DELETE FROM anuncios WHERE id = :id AND id_anunciante = :id_anunciante');
        $vercodeeas->bindParam(':id' , $_POST['remover_anuncio'], PDO::PARAM_STR);
        $vercodeeas->bindParam(':id_anunciante' , $usuario_logado_id, PDO::PARAM_STR);
        if($vercodeeas->execute()) {
            echo json_encode(array('', '', '', ''));
        }
	}
	//-----------------------------------------------------------------------------------
?>