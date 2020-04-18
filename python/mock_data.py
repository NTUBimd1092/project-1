import requests
from bs4 import BeautifulSoup
url='https://www.sinyi.com.tw/rent/list/1.html'
res= requests.get(url)
soup=BeautifulSoup(res.text,'html.parser')#原始碼
adress=soup.find_all(class_="num num-text")#地址
count=0
print("地址============================")
for adres in adress:
   if soup.find(class_="num num-text") !=None:
      print(adres.string)
      count+=1
print("房屋名稱============================")
house=soup.find_all("span", class_="item_title")#房屋名稱
for name in house:
   if soup.find("span", class_="item_title")!=None:
         print(name.string)
         count+=1   
print("房屋網址============================")
result= set()#房屋網址
for link in soup.select('.search_result_item'):
   result.add('https://www.sinyi.com.tw/rent/'+link.select_one('a')['href'])      
result = list(result)
for i ,result in enumerate(result):
      print(result)
      count+=1
print(count)

sqlinsert = ("INSERT INTO page_data(WebName,adress,house,Link,money)" "VALUES(%s,%s,%s,%s,%s)")
val = ['信義房屋',adres.string,name.string,result,'1000']

import pymysql
db = pymysql.connect("localhost","root","1234","crawler")
cursor = db.cursor()
try:
   cursor.execute(sqlinsert,val)
   db.commit()
   print('成功')
except:
   db.rollback()
   print('失敗')
db.close()