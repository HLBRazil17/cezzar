import pyotp
import qrcode
import json
import connect

# SQL variaveis de inserção

masterKey = connect.cursor("SELECT twoFactorSecret FROM users WHERE userID = ? LIMIT 1")

# Informações do usuario
user = "Helton"
chave_mestra = ""

if not chave_mestra:

    # Gerar uma nova chave mestre se estiver vazia
    chave_mestra = pyotp.random_base32()
    print("Chave mestre gerada para o usuário:", chave_mestra)

print(chave_mestra)

# Variaveis necessarias para gerar o qrcode

codigo = pyotp.TOTP(chave_mestra)
agora = codigo.now()

