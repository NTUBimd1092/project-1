#Accenture
import urllib.request as req
url="https://www.accenture.com/us-en/insights/into-the-new"
request=req.Request(url, headers={
    "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36"
})
with req.urlopen(url) as response:
    data=response.read().decode("utf-8")
import bs4
root=bs4.BeautifulSoup(data,"html.parser")
print(root.title.string)
#連線資料庫
import pymysql
db = pymysql.connect("localhost","root","1234","crawler" )
cursor = db.cursor()
cursor.execute("SELECT VERSION()")
data = cursor.fetchone()
#插入資料
sqlinsert = """INSERT INTO page_data(pdf,content,page_name,sort)
         VALUES ('檔名','內容','網站名稱','分類')"""
try:
   # 執行sql語句
   cursor.execute(sqlinsert)
   # 提交到資料庫執行
   db.commit()
   print('成功')
except:
   # 如果發生錯誤則回滾
   db.rollback()
   print('失敗')
db.close()

