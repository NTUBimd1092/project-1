import pymysql
db = pymysql.connect("localhost","root","1234","crawler" )
cursor = db.cursor()
cursor.execute("SELECT VERSION()")
data = cursor.fetchone()
sqlinsert = ("INSERT INTO page_data(WebName,Link,house,adress,money)" "VALUES(%s,%s,%s,%s,%s)")
data_inster = ('網站名稱','連結網址','房屋名稱','地址','1000')
try:
   cursor.execute(sqlinsert, data_inster)
   db.commit()
   print('成功')
except:
   db.rollback()
   print('失敗')
db.close()