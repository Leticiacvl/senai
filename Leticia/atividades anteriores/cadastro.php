<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    // Pegando os dados do form
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    
    

    // Inserindo os dados na tabela caso o cpf for válido
    $result = mysqli_query($conexao, "INSERT INTO usuarios (nome, email, senha, telefone, cpf) VALUES ('$nome', '$email', '$senha','$telefone', '$cpf')");    
}
?>


<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro</title>
    <link rel="stylesheet" href="cadastro.css">
    <script>
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

            if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
                return false; // CPF inválido
            }

            let soma = 0;
            let resto;

            for (let i = 1; i <= 9; i++) {
                soma += parseInt(cpf.charAt(i - 1)) * (11 - i);
            }

            resto = (soma * 10) % 11;
            if (resto === 10 || resto === 11) {
                resto = 0;
            }
            if (resto !== parseInt(cpf.charAt(9))) {
                return false; // CPF inválido
            }

            soma = 0;
            for (let i = 1; i <= 10; i++) {
                soma += parseInt(cpf.charAt(i - 1)) * (12 - i);
            }

            resto = (soma * 10) % 11;
            if (resto === 10 || resto === 11) {
                resto = 0;
            }
            if (resto !== parseInt(cpf.charAt(10))) {
                return false; // CPF inválido
            }

            return true; // CPF válido
        }

        function validarFormulario(event) {
            const cpfInput = document.getElementById('cpf').value;

            if (!validarCPF(cpfInput)) {
                event.preventDefault(); // Impede o envio do formulário
                alert('CPF inválido! Por favor, verifique o número digitado.');
            } else {
                // Mensagem de sucesso
                event.preventDefault(); // Impede o envio real para fins de demonstração
                alert('Cadastro concluído com sucesso!');
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Cadastro</h1>
        <form action="cadastro.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar-senha">Confirmar Senha:</label>
                <input type="password" id="confirmar-senha" name="confirmar-senha" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" maxlength="14" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" maxlength="15" required>
            </div>
            <button type="submit" name="submit">Cadastrar</button>
        </form>
        <a href="exercicioclass.html" class="back-button">Voltar</a>
    </div>
</body>

</html>