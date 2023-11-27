<?php
	//Incluir arquivo configs.php
	include_once('configs.php');
	//-----------------------------------------------------------------------------------

    //Inicia o ob start, session start..
    ob_start();
    session_start();
    setlocale( LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'Portuguese_Brazil');
    date_default_timezone_set('America/Sao_Paulo');
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    //-----------------------------------------------------------------------------------

    //Conexão com o banco principal
    try {
        $bdd = new PDO('mysql:host='.HOST.';dbname=look9131_gatadaarea;charset=utf8', 'look9131_gatadaarea', 'xX40028922');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $error) {
        echo 'Error: ' . $error -> getMessage();
    }
    //-----------------------------------------------------------------------------------

    //Criar variável para o usuário logado
    if(isset($_SESSION['email'.PATH]) OR isset($_COOKIE['email'.PATH]) AND isset($_SESSION['senha'.PATH]) OR isset($_COOKIE['senha'.PATH])) {
        if(isset($_SESSION['email'.PATH])) {
            $usuario_logado = '';
            $usuario_logado_email = $_SESSION['email'.PATH];
            $usuario_logado_senha = $_SESSION['senha'.PATH];
        }
        else {
            $usuario_logado = '';
            $usuario_logado_email = $_COOKIE['email'.PATH];
            $usuario_logado_senha = $_COOKIE['senha'.PATH];
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar informações do usuário logado
    if(isset($usuario_logado)) {
        $entselect = "SELECT * from anunciantes WHERE email = :email AND senha = :senha";
        try {
            $entresult = $bdd->prepare($entselect);
            $entresult->bindParam(':email', $usuario_logado_email, PDO::PARAM_STR);
            $entresult->bindParam(':senha', $usuario_logado_senha, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    $usuario_logado_id = $entexb['id'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Função para verificar se contem uma imagem
    function contem_imagem($nome, $pasta) {
        if($nome == NULL) {
            return PATH.'assets/img/geral/no-photo.png';
        }
        else {
            return PATH.'assets/img/'.$pasta.'/'.$nome;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome da categoria
    function nome_categoria($id_categoria) {
        $entselect = "SELECT * from categorias WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_categoria, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome da nacionalidade
    function nome_nacionalidade($id_nacionalidade) {
        $entselect = "SELECT * from nacionalidades WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_nacionalidade, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome do seio
    function nome_seio($id_seio) {
        $entselect = "SELECT * from seios WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_seio, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome do cabelo
    function nome_cabelo($id_cabelo) {
        $entselect = "SELECT * from cabelos WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_cabelo, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome do tipo de corpo
    function nome_tipo_de_corpo($id_tipo_de_corpo) {
        $entselect = "SELECT * from tipos_de_corpo WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_tipo_de_corpo, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome do serviço
    function nome_servico($id_servico) {
        $entselect = "SELECT * from servicos WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_servico, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome do serviço para
    function nome_servico_para($id_servico_para) {
        $entselect = "SELECT * from servicos_para WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_servico_para, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Puxar o nome do local de atendimento
    function nome_local_de_atendimento($id_local_de_atendimento) {
        $entselect = "SELECT * from locais_de_atendimento WHERE id = :id";
        try {
            $entresult = $GLOBALS['bdd']->prepare($entselect);
            $entresult->bindParam(':id', $id_local_de_atendimento, PDO::PARAM_STR);
            $entresult->execute();
            $entcontar = $entresult->rowCount();
            if($entcontar > 0) {
                $entloop = $entresult->fetchAll();
                foreach($entloop as $entexb) {
                    return $entexb['nome'];
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    //-----------------------------------------------------------------------------------

    //Deixar somente o número
    function somente_numero($numero) {
        $soNumeros = preg_replace("/\D/","", $numero);
        return $soNumeros;
    }
    //-----------------------------------------------------------------------------------

    //Sair da conta
    if(isset($_GET['sair'])) {
        foreach($_COOKIE as $name => $value) {
            setcookie($name, '', -1, PATH);
        }
        session_destroy();
        header('Location: '.PATH.'entrar/');
    }
    //-----------------------------------------------------------------------------------

    //Controle de acessos dos arquivos da raiz
    if(strstr(basename($_SERVER['PHP_SELF'],'.php'), 'criar-conta')) {
        if(isset($usuario_logado)) {
            header('Location: '.PATH);
        }
    }
    if(strstr(basename($_SERVER['PHP_SELF'],'.php'), 'entrar')) {
        if(isset($usuario_logado)) {
            header('Location: '.PATH);
        }
    }
    if(strstr(basename($_SERVER['PHP_SELF'],'.php'), 'meus-anuncios')) {
        if(!isset($usuario_logado)) {
            header('Location: '.PATH.'entrar/');
        }
    }
    if(strstr(basename($_SERVER['PHP_SELF'],'.php'), 'publicar-anuncio')) {
        if(!isset($usuario_logado)) {
            header('Location: '.PATH.'entrar/');
        }
    }
    //-----------------------------------------------------------------------------------

    //Head
    function head() {
?>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Gata da Área</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-proxima-nova@1.0.1/style.min.css">
            <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
            <link rel="icon" type="image/png" href="<?php echo PATH.'assets/img/geral/favicon.png'; ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo PATH.'assets/css/style.css?2'; ?>">
        </head>
<?php
    }
    //-----------------------------------------------------------------------------------

    //Header
    function headerr() {
?>
        <header>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?php echo PATH; ?>">
                        <img src="<?php echo PATH.'assets/img/geral/logo.png'; ?>">
                    </a>
                    <div class="d-lg-flex d-none w-100">
                        <input type="text" placeholder="Clique aqui para abrir a Pesquisa" data-bs-toggle="modal" data-bs-target="#filtros" readonly>
                    </div>
                    <nav>
                        <ul>
                            <li><a class="d-lg-none" data-bs-toggle="modal" data-bs-target="#filtros"><i class="fa-solid fa-magnifying-glass"></i></a></li>
                            <li><a href="<?php echo PATH.'meus-anuncios/'; ?>"><i class="fa-solid fa-user"></i></a></li>
                            <li><a href="<?php echo PATH.'publicar-anuncio/'; ?>" class="btn"><i class="fa-solid fa-circle-plus"></i> <span class="d-none d-lg-inline-block">Públicar Anúncio</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
<?php
    }
    //-----------------------------------------------------------------------------------

    //Footer
    function footer($initialImageURLs = '', $id_categoria = '', $termo = '') {
?>
        <div class="modal fade" id="filtros">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form method="GET" action="<?php echo PATH.'anuncios/'; ?>">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</h5>
                            <button type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg mb-lg-0 mb-3">
                                        <select class="form-select" name="categoria">
                                            <option value <?php if(empty($id_categoria)) { echo 'selected'; } ?> disabled>Selecione uma opção</option>
<?php
                                            $omsselect = "SELECT * from categorias";
                                            try {
                                                $omsresult = $GLOBALS['bdd']->prepare($omsselect);
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
                                    <div class="col-lg">
                                        <input type="text" class="form-control" name="termo" placeholder="Pesquise por algum termo.." <?php if(!empty($termo)) { echo 'value="'.$termo.'"'; } ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg mb-lg-0 mb-3">
                                        <select class="form-select" name="estado_2">
                                            <option value selected disabled>Pesquise por estado</option>
                                        </select>
                                    </div>
                                    <div class="col-lg">
                                        <select class="form-select" name="cidade_2">
                                            <option value selected disabled>Pesquise por cidade</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="pesquisar">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn w-100"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr class="mt-5 mb-5">
        <footer>
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-4">
                        <strong class="d-block mb-2">Insitucional</strong>
                        <ul>
                            <li><a href="<?php echo PATH.'quem-somos/'; ?>">Quem somos</a></li>
                            <li><a href="<?php echo PATH.'termos-e-condicoes/'; ?>">Termos e Condições</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <strong class="d-block mb-2">Categorias</strong>
                        <ul>
<?php
                            $omsselect = "SELECT * from categorias";
                            try {
                                $omsresult = $GLOBALS['bdd']->prepare($omsselect);
                                $omsresult->execute();
                                $omscontar = $omsresult->rowCount();
                                if($omscontar > 0) {
                                    while($omsmost = $omsresult->FETCH(PDO::FETCH_OBJ)) {
?>
                                        <li><a href="<?php echo PATH.'anuncios/'; ?>"><?php echo $omsmost->nome; ?></a></li>
<?php
                                    }
                                }
                            }
                            catch(PDOException $e) {
                                echo $e;
                            }
?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <strong class="d-block mb-2">Redes Sociais</strong>
                        <ul>
                            <li><a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
                            <li><a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                            <li><a href="#"><i class="fa-brands fa-tiktok"></i> Tiktok</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center m-0">Copyright © 2023 <a href="<?php echo PATH; ?>">Gata da Área</a>. Todos os direitos reservados.</p>
                    </div>
                </div>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script type="text/javascript" src="<?php echo PATH.'assets/js/custom.js'; ?>"></script>
        <script type="text/javascript">
            $.getJSON(PATH + 'assets/json/estados_cidades.json', (data) => {
                let items = [];
                let options = '<option selected value disabled>Selecione o estado</option>';
                for(val of data) {
                    if(val.nome == '<?php echo $_GET['estado_2']; ?>') {
                        options += '<option value="' + val.nome + '" selected>' + val.nome + '</option>';
                    }
                    else {
                        options += '<option value="' + val.nome + '">' + val.nome + '</option>';
                    }
                }
                $('select[name="estado_2"]').html(options);
                $('select[name="estado_2"]').change( () => {
                    let options_cidades = '<option selected value disabled>Selecione a cidade</option>';
                    let str = $('select[name="estado_2"]').val();
                    for(val of data) {
                        if(val.nome == str) {
                            for(val_city of val.cidades) {
                                if(val_city == '<?php echo $_GET['cidade_2']; ?>') {
                                    options_cidades += '<option value="' + val_city + '" selected>' + val_city + '</option>';
                                }
                                else {
                                    options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                }
                            }
                        }
                    }
                    $('select[name="cidade_2"]').html(options_cidades);
                }).change();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                FilePond.registerPlugin(FilePondPluginImagePreview);
                $('form[method="POST"]').each(function() {
                    const form = $(this);
                    const inputElement = form.find('input[type="file"]');
                    const pond = FilePond.create(inputElement[0], {
                        allowMultiple: true,
                        allowReorder: true,
                        acceptedFileTypes: ['image/*']
                    });
                    const initialImageURLs = [<?php echo $initialImageURLs; ?>];
                    async function preloadImages(imageURLs) {
                        for(const url of imageURLs) {
                            const file = await pond.addFile(url);
                        }
                    }
                    preloadImages(initialImageURLs);
                    form.data('pond', pond);
                });
                $('form[method="POST"]').on('submit', function(e) {
                    var this_form = $(this);
                    e.preventDefault();
                    var pond = this_form.data('pond');
                    if(pond) {
                        var fd = new FormData(this_form[0]);
                        pondFiles = pond.getFiles();
                        var fileNames = [];
                        var fileIndexMap = {};
                        for(var i = 0; i < pondFiles.length; i++) {
                            var file = pondFiles[i].file;
                            var fileName = file.name;
                            fileNames.push(fileName);
                            fileIndexMap[fileName] = i;
                            fd.append('file[]', file);
                        }
                        fileNames.sort(function(a, b) {
                            return fileIndexMap[a] - fileIndexMap[b];
                        });
                        fd.append('fileNames', JSON.stringify(fileNames));
                    }
                    $.ajax({
                        type: 'POST',
                        url: PATH + 'ajaxs/',
                        data: fd,
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('input[type="submit"]').attr('disabled', '');
                        },
                        success: function(data) {
                            $('.alert').remove();
                            if(data.erro == null) {
                                if(data[1] != '') {
                                    $(this_form).prepend('<div class="alert alert-success alert-dismissible fade show" role="alert"><span>'+ data[1] +'</span><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                                    setTimeout(() => {
                                        if(data[0] == '') {
                                            location.reload();
                                        }
                                        if(data[2] != '') {
                                            if(data[3] == '') {
                                                window.location.href = data[2];
                                            }
                                            else {
                                                window.open(data[2], '_blank');
                                            }
                                        }
                                    }, 1500);
                                }
                                else {
                                    if(data[0] == '') {
                                        location.reload();
                                    }
                                    if(data[2] != '') {
                                        if(data[3] == '') {
                                            window.location.href = data[2];
                                        }
                                        else {
                                            window.open(data[2], '_blank');
                                        }
                                    }
                                }
                            }
                            else {
                                $('input[type="submit"]').removeAttr('disabled');
                                $(this_form).prepend('<div class="alert alert-danger alert-dismissible fade show" role="alert"><span>'+ data.erro +'</span><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            }
                            $('html, body').animate({
                                scrollTop: $('.alert').offset().top - 120
                            }, 'slow');
                        }
                    });
                });
            });
        </script>
<?php
    }
    //-----------------------------------------------------------------------------------
?>
