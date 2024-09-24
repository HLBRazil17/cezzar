<?php
require('./php/gerenciador.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <style>
        /* Estilos para células editáveis */
        td[contenteditable="true"] {
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>Gerenciar Usuários</h1>
    </div>

    <!-- Exibir mensagens de sucesso e erro -->
    <?php if ($errorMessage): ?>
        <div style="color: red;">
            <?= htmlspecialchars($errorMessage ?? '', ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <div style="color: green;">
            <?= htmlspecialchars($successMessage ?? '', ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Formulário de pesquisa -->
    <form method="POST" action="">
        <input type="text" name="searchTerm" value="<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Pesquisar">
        <button type="submit" name="actionType" value="search">Pesquisar</button>
    </form>

    <!-- Tabela de usuários -->
    <table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Role</th>
                <th>Plano</th> 
                <th>Ação</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['userID'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userNome'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userEmail'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userCpf'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userTel'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userEstato'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['role'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['plano'] ?? 'Sem plano', ENT_QUOTES, 'UTF-8') ?></td> 
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="userID" value="<?= htmlspecialchars($user['userID'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" name="actionType" value="update">Atualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulário de verificação de código -->
    <?php if ($showCodeForm): ?>
        <div id="codeForm">
            <h2>Verifique o Código</h2>
            <form method="POST" action="">
                <input type="hidden" name="userID" value="<?= htmlspecialchars($userToEdit ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" required>
                <button type="submit" name="actionType" value="verifyCode">Verificar Código</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Formulário de edição de usuário -->
    <?php if ($showEditForm && $canEdit): ?>
        <div id="editForm">
            <h2>Editar Usuário</h2>
            <form method="POST" action="">
                <input type="hidden" name="userID" value="<?= htmlspecialchars($_POST['userID'] ?? ''); ?>">
                <label for="userNome">Nome:</label>
                <input type="text" id="userNome" name="userNome" value="<?= htmlspecialchars($userData['userNome'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                <br>
                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="userEmail" value="<?= htmlspecialchars($userData['userEmail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                <br>
                <label for="userCpf">CPF:</label>
                <input type="text" id="userCpf" name="userCpf" value="<?= htmlspecialchars($userData['userCpf'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <br>
                <label for="userTel">Telefone:</label>
                <input type="text" id="userTel" name="userTel" value="<?= htmlspecialchars($userData['userTel'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <br>
                <label for="userEstato">Status:</label>
                <select id="userEstato" name="userEstato">
                    <option value="Ativo" <?= ($userData['userEstato'] ?? '') === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="Inativo" <?= ($userData['userEstato'] ?? '') === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                </select>
                <br>
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="user" <?= ($userData['role'] ?? '') === 'user' ? 'selected' : '' ?>>user</option>
                    <option value="admin" <?= ($userData['role'] ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
                </select>
                <br>
                <label for="plano">Plano:</label>
                <select id="plano" name="plano">
                    <option value="básico" <?= ($userData['plano'] ?? '') === 'básico' ? 'selected' : '' ?>>básico</option>
                    <option value="pro" <?= ($userData['plano'] ?? '') === 'pro' ? 'selected' : '' ?>>pro</option>
                    <option value="premium" <?= ($userData['premium'] ?? '') === 'premium' ? 'selected' : '' ?>>premium</option> 
                </select>
                <br>
                <button type="submit" name="actionType" value="saveChanges">Salvar Alterações</button>
            </form>
        </div>
    <?php endif; ?>

    <script src="../Front/script2.js"></script>
</body>
</html>
