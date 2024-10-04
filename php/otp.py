import pyotp
import qrcode
import time
import os

def main():
    # Gerar uma chave mestra aleatória
    chave_mestra = pyotp.random_base32()
    print(f"Chave mestra gerada: {chave_mestra}")

    codigo = pyotp.TOTP(chave_mestra)
    agora = codigo.now()
    # Código atual do autenticador
    print(f"Código OTP atual: {agora}")

    link = codigo.provisioning_uri( issuer_name='ProtectKey')   
    print(f"URI de provisionamento: {link}")

    img = qrcode.make(link)
    img.save("./img/qrcode.png")

    # Verificar OTP, substitua a variável "agora", pelo input do usuário
    validade = codigo.verify(otp=agora, for_time=int(time.time()))

    # Formata a saída como texto delimitado
    resultado = f"{agora}|{link}|{'valid' if validade else 'invalid'}"
    print(resultado)

    if validade:
        print("Código OTP válido!")
    else:
        print("Código OTP inválido!")

if __name__ == "__main__":
    main()
