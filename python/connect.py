import mysql.connector
import qrcode
import pyotp
import sys

# Obtendo os argumentos passados pelo PHP
arg1 = sys.argv[1]  # userID
arg2 = sys.argv[2]  # user_nome

# Variáveis do PHP
user_id = arg1
user_nome = arg2

# Conectar ao banco de dados
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="etec2024",
    database="gerenciadorsenhas"
)

# Criar um cursor
cursor = conn.cursor()

# Verificar se o campo 'twofactorSecret' já existe para o usuário
cursor.execute("SELECT twofactorSecret FROM users WHERE userID = %s", (user_id,))
result = cursor.fetchone()

# Se o 'twofactorSecret' for vazio ou None, gerar um novo
if result is None or not result[0]:
    # Gerar novo OTP secreto
    gerarOTP = pyotp.random_base32()
    
    # Atualizar o campo twofactorSecret no banco de dados
    cursor.execute("""
        UPDATE users 
        SET twofactorSecret = %s 
        WHERE userID = %s
    """, (gerarOTP, user_id))
    
    # Confirmar a alteração
    conn.commit()

    # Gerar o QR code para o pareamento do aplicativo
    totp = pyotp.TOTP(gerarOTP)
    otp_uri = totp.provisioning_uri(name=user_nome, issuer_name="Gerenciador de Senhas")
    
    # Criar o QR code
    qr = qrcode.make(otp_uri)
    
    # Salvar o QR code em um arquivo
    qr_file_path = f"qrcode_{user_id}.png"  # ajuste o caminho conforme necessário
    qr.save(qr_file_path)
    
    print(f"QR code gerado e salvo em: {qr_file_path}")
else:
    print("Usuário já possui um twofactorSecret.")

# Fechar a conexão
cursor.close()
conn.close()
