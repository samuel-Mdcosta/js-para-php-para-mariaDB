<?php
    // Permite requisições de qualquer origem
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    // Verifica se a requisição é do tipo OPTIONS e responde com os cabeçalhos apropriados
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    header('Content-Type: application/json');

    // Recebe os dados JSON enviados pelo fetch
    $input = json_decode(file_get_contents('php://input'), true);

    // Verifica se os dados foram recebidos corretamente
    if ($input === null) {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
        exit();
    }

    // Extrai os dados recebidos
    $nome = $input['nome'];
    $idade = $input['idade'];
    $serie = $input['serie'];

    // Função para enviar os dados ao banco de dados
    function envia_banco($nome, $idade, $serie){
        try{
            $conexao = new PDO('mysql:host=localhost;dbname=teste_fetch', 'root', '');
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Cria a tabela se não existir
            $query = '
                CREATE TABLE IF NOT EXISTS teste_fetch(
                    id INT NOT NULL AUTO_INCREMENT,
                    nome VARCHAR(50) NOT NULL,
                    idade INT NOT NULL,
                    serie VARCHAR(50) NOT NULL,
                    PRIMARY KEY (id)
                );
            ';
            $conexao->exec($query);

            $stmt = $conexao->prepare('INSERT INTO teste_fetch (nome, idade, serie) VALUES (:nome, :idade, :serie)');
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':idade', $idade);
            $stmt->bindParam(':serie', $serie);

            if($stmt->execute()){
                echo json_encode(['status' => 'success', 'message' => 'dados enviados para o banco']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir dados']);
            }
        }catch(PDOException $e){
            echo json_encode(['status' => 'error', 'message' => 'Erro: '.$e->getCode(). ' mensagem: '.$e->getMessage()]);
            exit();
        }
    }

    // Chama a função envia_banco com os dados recebidos
    envia_banco($nome, $idade, $serie);
?>