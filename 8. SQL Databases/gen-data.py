#!/usr/bin/env python3
import mysql.connector
import string
import random
from datetime import datetime, timedelta


def str_generator(size=6, chars=string.ascii_uppercase + string.digits):
    return "".join(random.choice(chars) for _ in range(size))


mydb = mysql.connector.connect(
    host="localhost", user="user", password="password", database="db"
)

mycursor = mydb.cursor()

for id in range(100):
    sql = "INSERT INTO users (userName, password, realName, birthDate) VALUES (%s, %s, %s, %s)"
    data = []
    for _ in range (50_000):
        date = datetime.today() - timedelta(days=random.randint(1, 360))
        formatted_date = date.strftime("%Y-%m-%d %H:%M:%S")
        data.append( (str_generator(), str_generator(), str_generator(), formatted_date) )

    print(f"{id * 50_000} record generated")
    mycursor.executemany(sql, data)
    mydb.commit()

print(mycursor.rowcount, "record inserted.")
