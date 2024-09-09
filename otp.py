import pyotp
import qrcode

nomeUsuario = "Helton"

#print(pyotp.random_base32())
chave_mestra="5JHSKDDJNBQEBCOUBF34MLFXGPWZVUCT"

codigo = pyotp.TOTP(chave_mestra)

#Codigo atual do autenticador
print(codigo.now())


link = pyotp.TOTP(chave_mestra).provisioning_uri(name= nomeUsuario, issuer_name= "ProtectKey")
print(link)

img = qrcode.make(link)
type(img)
img.save("qrcode.png")

tentativa=input()

