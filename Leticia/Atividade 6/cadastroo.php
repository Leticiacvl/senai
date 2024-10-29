<?php
$mensagem = "";
$classeMensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "LeticiaSenai07", "form_db");

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $nome = $conn->real_escape_string($_POST['nome']);
    $sobrenome = $conn->real_escape_string($_POST['sobrenome']);
    $empresa = $conn->real_escape_string($_POST['empresa']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $ddd = $conn->real_escape_string($_POST['ddd']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $iniciante = $conn->real_escape_string($_POST['iniciante']);

    $email_check_query = "SELECT * FROM usuarios WHERE email='$email' LIMIT 1";
    $result = $conn->query($email_check_query);

    if ($result->num_rows > 0) {
        $mensagem = "Erro: Este email já está cadastrado.";
        $classeMensagem = "erro";
    } else {
        $sql = "INSERT INTO usuarios (nome, sobrenome, empresa, email, telefone, ddd, sexo, iniciante) 
                VALUES ('$nome', '$sobrenome', '$empresa', '$email', '$telefone', '$ddd', '$sexo', '$iniciante')";

        if ($conn->query($sql) === TRUE) {
            $mensagem = "Registro inserido com sucesso!";
            $classeMensagem = "sucesso";
        } else {
            $mensagem = "Erro ao inserir registro: " . $conn->error;
            $classeMensagem = "erro";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Moderno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('foto.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: rgba(187, 187, 187, 0.8);
            padding: 60px;
            border-radius: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        select {
            font-weight: bold;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #000000;
            border-radius: 5px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .radio-group {
            margin: 10px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #00a99d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #007b70;
        }

        .mensagem {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form method="POST" action="">
            <h2>Cadastre-se</h2>
            
            <?php if ($mensagem): ?>
                <div class="mensagem <?php echo $classeMensagem; ?>">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>
                
            <div class="input-group">
                <label for="nome">Nome e Sobrenome</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
                <input type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required>
            </div>

            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="empresa" placeholder="Empresa" autocomplete="organization">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <div class="input-group">
                <label for="ddd">DDD</label>
                <input type="text" id="ddd" name="ddd" maxlength="2" placeholder="DDD" class="small-input" required>
            </div>

            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" maxlength="15" placeholder="Telefone" required oninput="mascaraTelefone(this)">

            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo" required>
                <option disabled selected>--Selecione a Opção--</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>

            <label>Você é iniciante?</label>
            <div class="radio-group">
                <label><input type="radio" name="iniciante" value="sim" required> Sim</label>
                <label><input type="radio" name="iniciante" value="nao" required> Não</label>
            </div>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>