<?php
class Usuario
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Método para cadastrar um usuário ou administrador
    public function cadastrar($nome, $email, $senha, $idNivelUsuario, $cpf = null, $telefone = null, $cep = null, $logradouro = null, $complemento = null, $numero = null, $bairro = null, $cidade = null)
    {
        try {
            $sql = "INSERT INTO usuario (nome, email, senha, idNivelUsuario, cpf, telefone, cep, logradouro, complemento, numero, bairro, cidade) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $this->conn->error);
            }

            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

            // Verificar campos opcionais (administrador pode não fornecer esses campos)
            $cpf = !empty($cpf) ? $cpf : null;
            $telefone = !empty($telefone) ? $telefone : null;
            $cep = !empty($cep) ? $cep : null;
            $logradouro = !empty($logradouro) ? $logradouro : null;
            $complemento = !empty($complemento) ? $complemento : null;
            $numero = !empty($numero) ? $numero : null;
            $bairro = !empty($bairro) ? $bairro : null;
            $cidade = !empty($cidade) ? $cidade : null;

            // Bind dos parâmetros (MySQLi usa bind_param com tipos de dados)
            $stmt->bind_param(
                'sssiiisssiss',
                $nome,
                $email,
                $senhaHash,
                $idNivelUsuario,
                $cpf,
                $telefone,
                $cep,
                $logradouro,
                $complemento,
                $numero,
                $bairro,
                $cidade
            );

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar consulta: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    }
}
