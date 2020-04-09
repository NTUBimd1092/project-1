import pymysql
db = pymysql.connect("localhost","root","1234","crawler" )
cursor = db.cursor()
cursor.execute("SELECT VERSION()")
data = cursor.fetchone()
#插入資料
sqlinsert = ("INSERT INTO page_data(Link,house,adress)" "VALUES(%s,%s,%s)")
data_inster = ('','','')
try:
   # 執行sql語句
   cursor.execute(sqlinsert, data_inster)
   # 提交到資料庫執行
   db.commit()
   print('成功')
except:
   # 如果發生錯誤則回滾
   db.rollback()
   print('失敗')

db.close()

