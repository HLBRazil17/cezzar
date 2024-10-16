import mysql.connector

# Conectar ao banco de dados
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="etec2024",
    database="gerenciadorsenhas"
)

# Criar um cursor
cursor = conn.cursor()

# Definir o userID que deseja atualizar
user_id = 1

# Novos valores para 'codVerify' e 'twofactorSecret'
codVerify = "10"
twofactorSecret = "10"

# Executar a consulta para atualizar os valores de 'codVerify' e 'twofactorSecret'
cursor.execute("""
    UPDATE users 
    SET codVerify = ?, twofactorSecret = ?, 
    WHERE userID = ?,
"""())

# Confirmar as alterações
conn.commit()

# Verificar se a atualização foi bem-sucedida
cursor.execute("SELECT * FROM users WHERE userID = "(user_id))
user = cursor.fetchone()

# Exibir o resultado atualizado
if user:
    print("Usuário atualizado:", user)
else:
    print("Usuário não encontrado")

# Fechar a conexão
cursor.close()
conn.close()