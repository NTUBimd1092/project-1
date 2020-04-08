#網站Accenture
import urllib.request as req
url="https://www.mckinsey.com/featured-insights"
request=req.Request(url, headers={
    "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36"
})
with req.urlopen(url) as response:
    data=response.read().decode("utf-8")
import bs4
root=bs4.BeautifulSoup(data,"html.parser")#網站原始碼 
#連線資料庫
import pymysql
db = pymysql.connect("localhost","root","1234","crawler" )
cursor = db.cursor()
cursor.execute("SELECT VERSION()")
data = cursor.fetchone()
import requests,os
from urllib.request import urlopen
#抓取網頁資料
#抓url
source=root.find_all("div")
print(source)
"""             
#抓摘要
X=root.find_all("li",class_="summary-item rte-inline")
for i in X:
    if i !=None:
        summary=i.string
pdf=''  #檔案連結
content=summary #摘要
page_name=str(root.title.string[-9::1])    #網站名稱
sort='' #分類
#插入資料
sqlinsert = ("INSERT INTO page_data(pdf,content,page_name,sort)" "VALUES(%s,%s,%s,%s)")
data_inster = (pdf,content,page_name,sort)
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
"""