<?php

require('conectar.php');
require('enviar.php');

// Inicializar variáveis para mensagens de erro e sucesso
$errorMessage = '';
$successMessage = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar os dados do formulário
    $userNome = $_POST['userNome'];
    $userEmail = $_POST['userEmail'];
    $userCpf = $_POST['userCpf'];
    $userTel = $_POST['userTel'];
    $userPassword = $_POST['userPassword'];

    // Validar os dados
    if (empty($userNome) || empty($userEmail) || empty($userPassword)) {
        $errorMessage = 'Nome, e-mail e senha são obrigatórios.';
    } else {
        // Validar e-mail
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'O e-mail fornecido é inválido.';
        } else {
            // Verificar se o e-mail já está registrado
            $sql = "SELECT userID FROM gerenciadorsenhas.users WHERE userEmail = ?";
            if ($stmt = $conn->prepare($sql)) { 
                $stmt->bind_param("s", $userEmail);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $errorMessage = 'O e-mail informado já está cadastrado.';
                    $stmt->close();
                } else {
                    // Criptografar a senha com MD5
                    $md5Password = md5($userPassword);

                    // Gerar um token de 6 dígitos
                    $userToken = generateToken($conn);

                    // Verificar se o CPF foi fornecido e se está registrado
                    if (!empty($userCpf)) {
                        $sql = "SELECT userID FROM gerenciadorsenhas.users WHERE userCpf = ?";
                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("s", $userCpf);
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                $errorMessage = 'O CPF informado já está cadastrado.';
                                $stmt->close();
                            } else {
                                // Verificar se o telefone foi fornecido e se está registrado
                                if (!empty($userTel)) {
                                    $sql = "SELECT userID FROM gerenciadorsenhas.users WHERE userTel = ?";
                                    if ($stmt = $conn->prepare($sql)) {
                                        $stmt->bind_param("s", $userTel);
                                        $stmt->execute();
                                        $stmt->store_result();

                                        if ($stmt->num_rows > 0) {
                                            $errorMessage = 'O telefone informado já está cadastrado.';
                                            $stmt->close();
                                        } else {
                                            // Inserir o usuário no banco de dados e enviar o e-mail
                                            $stmt->close();
                                            $conn->begin_transaction();
                                            try {
                                                $sql = "INSERT INTO gerenciadorsenhas.users (userNome, userEmail, userCpf, userTel, userPassword, userToken) VALUES (?, ?, ?, ?, ?, ?)";
                                                if ($stmt = $conn->prepare($sql)) {
                                                    $stmt->bind_param("ssssss", $userNome, $userEmail, $userCpf, $userTel, $md5Password, $userToken);
                                                    if ($stmt->execute()) {
                                                        // Enviar o token por e-mail
                                                        $emailError = sendEmail($userEmail, $userToken);
                                                        if ($emailError) {
                                                            $conn->rollback();
                                                            $errorMessage = $emailError;
                                                        } else {
                                                            $conn->commit();
                                                            $successMessage = 'Usuário registrado com sucesso! O token foi enviado para o seu e-mail.';
                                                        }
                                                    } else {
                                                        $conn->rollback();
                                                        $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                                                    }
                                                    $stmt->close();
                                                } else {
                                                    $conn->rollback();
                                                    $errorMessage = 'Não foi possível preparar a declaração SQL.';
                                                }
                                            } catch (Exception $e) {
                                                $conn->rollback();
                                                $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                                            }
                                        }
                                    } else {
                                        $errorMessage = 'Não foi possível preparar a declaração SQL para verificação de telefone.';
                                    }
                                } else {
                                    // Inserir o usuário sem telefone no banco de dados
                                    $sql = "INSERT INTO gerenciadorsenhas.users (userNome, userEmail, userCpf, userTel, userPassword, userToken) VALUES (?, ?, ?, NULL, ?, ?)";
                                    if ($stmt = $conn->prepare($sql)) {
                                        $stmt->bind_param("sssss", $userNome, $userEmail, $userCpf, $md5Password, $userToken);
                                        if ($stmt->execute()) {
                                            // Enviar o token por e-mail
                                            $emailError = sendEmail($userEmail, $userToken);
                                            if ($emailError) {
                                                $errorMessage = $emailError;
                                            } else {
                                                $successMessage = 'Usuário registrado com sucesso! O token foi enviado para o seu e-mail.';
                                            }
                                        } else {
                                            $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                                        }
                                        $stmt->close();
                                    } else {
                                        $errorMessage = 'Não foi possível preparar a declaração SQL.';
                                    }
                                }
                            }
                        } else {
                            $errorMessage = 'Não foi possível preparar a declaração SQL para verificação de CPF.';
                        }
                    } else {
                        // Verificar se o telefone foi fornecido e se está registrado
                        if (!empty($userTel)) {
                            $sql = "SELECT userID FROM gerenciadorsenhas.users WHERE userTel = ?";
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bind_param("s", $userTel);
                                $stmt->execute();
                                $stmt->store_result();

                                if ($stmt->num_rows > 0) {
                                    $errorMessage = 'O telefone informado já está cadastrado.';
                                    $stmt->close();
                                } else {
                                    // Inserir o usuário sem CPF no banco de dados
                                    $stmt->close();
                                    $conn->begin_transaction();
                                    try {
                                        $sql = "INSERT INTO gerenciadorsenhas.users (userNome, userEmail, userCpf, userTel, userPassword, userToken) VALUES (?, ?, NULL, ?, ?, ?)";
                                        if ($stmt = $conn->prepare($sql)) {
                                            $stmt->bind_param("sssss", $userNome, $userEmail, $userTel, $md5Password, $userToken);
                                            if ($stmt->execute()) {
                                                // Enviar o token por e-mail
                                                $emailError = sendEmail($userEmail, $userToken);
                                                if ($emailError) {
                                                    $conn->rollback();
                                                    $errorMessage = $emailError;
                                                } else {
                                                    $conn->commit();
                                                    $successMessage = 'Usuário registrado com sucesso! O token foi enviado para o seu e-mail.';
                                                }
                                            } else {
                                                $conn->rollback();
                                                $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                                            }
                                            $stmt->close();
                                        } else {
                                            $conn->rollback();
                                            $errorMessage = 'Não foi possível preparar a declaração SQL.';
                                        }
                                    } catch (Exception $e) {
                                        $conn->rollback();
                                        $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                                    }
                                }
                            } else {
                                $errorMessage = 'Não foi possível preparar a declaração SQL para verificação de telefone.';
                            }
                        } else {
                            // Inserir o usuário sem CPF e sem telefone no banco de dados
                            $conn->begin_transaction();
                            try {
                                $sql = "INSERT INTO gerenciadorsenhas.users (userNome, userEmail, userCpf, userTel, userPassword, userToken) VALUES (?, ?, NULL, NULL, ?, ?)";
                                if ($stmt = $conn->prepare($sql)) {
                                    $stmt->bind_param("ssss", $userNome, $userEmail, $md5Password, $userToken);
                                    if ($stmt->execute()) {
                                        // Enviar o token por e-mail
                                        $emailError = sendEmail($userEmail, $userToken);
                                        if ($emailError) {
                                            $conn->rollback();
                                            $errorMessage = $emailError;
                                        } else {
                                            $conn->commit();
                                            $successMessage = 'Usuário registrado com sucesso! O token foi enviado para o seu e-mail.';
                                        }
                                    } else {
                                        $conn->rollback();
                                        $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                                    }
                                    $stmt->close();
                                } else {
                                    $conn->rollback();
                                    $errorMessage = 'Não foi possível preparar a declaração SQL.';
                                }
                            } catch (Exception $e) {
                                $conn->rollback();
                                $errorMessage = 'Ocorreu um erro ao registrar o usuário. Por favor, tente novamente.';
                            }
                        }
                    }
                }
            }
        }
    }
}

?>  