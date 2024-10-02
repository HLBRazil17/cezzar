import mysql.connector

conn = mysql.connector.connect(user='root', password='etec2024', host='localhost:3306', database='gerenciadorsenhas')
cursor = conn.cursor()
cursor.execute("SELECT * FROM tabela")
data = cursor.fetchall()
print(data)
