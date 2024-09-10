import pyotp
import qrcode
import time
import sys
  

def main():
 nomeUsuario = "Helton"

 #print(pyotp.random_base32())
 chave_mestra="5JHSKDDJNBQEBCOUBF34MLFXGPWZVUCT"

 codigo = pyotp.TOTP(chave_mestra)
 agora = codigo.now()
 #Codigo atual do autenticador
 print(codigo.now())


 link = pyotp.TOTP(chave_mestra).provisioning_uri(name= nomeUsuario, issuer_name= "ProtectKey")
 print(link)

 img = qrcode.make(link)
 type(img)
 img.save("qrcode.png")

 # Verificar OTP, substituir a variavel "agora", pelo input do usuario. 

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