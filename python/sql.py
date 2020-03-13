import pymysql
db = pymysql.connect("localhost","root","1234","crawler" )
cursor = db.cursor()
cursor.execute("SELECT VERSION()")
data = cursor.fetchone()
sql = "SELECT * FROM `menber` WHERE 1"
try:
   # 執行SQL語句
   cursor.execute(sql)
   # 獲取所有記錄列表
   results = cursor.fetchall()
   for row in results:
      fname = row[1]
       # 列印結果
      print (fname)
except:
   print ("Error: unable to fetch data")

sqlinsert = """INSERT INTO page_data(pdf,content)
         VALUES ('pyhon','python content insert test')"""
try:
   # 執行sql語句
   cursor.execute(sqlinsert)
   # 提交到資料庫執行
   db.commit()
except:
   # 如果發生錯誤則回滾
   db.rollback()
db.close()

