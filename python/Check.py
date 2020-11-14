import requests
from bs4 import BeautifulSoup
import pymysql
from re import sub
import itertools

db = pymysql.connect("localhost","root","1234","crawler", charset='utf8')
cursor = db.cursor()
Dcursor=db.cursor()
select_sql = """SELECT id,Link,WebName FROM `page_data`"""

try:
    cursor.execute(select_sql)
    while 1:        
        arr=cursor.fetchone()
        print(f'編號：{arr[0]},網址：{arr[1]},平台：{arr[2]}')
        WebName=arr[2]
        if WebName=='信義房屋':
            try:
                requests.packages.urllib3.disable_warnings()
                resources = requests.get(arr[1],verify=False)
                soup = BeautifulSoup(resources.text, 'html.parser')
                if soup.select_one('h1').string=='很抱歉！本頁面已不在資料庫中':
                    delete_sql="""UPDATE `page_data` SET `Is_Delete`= %s WHERE `id`= %s"""
                    val=("Y", arr[0])
                    try:
                        Dcursor.execute(delete_sql,val)
                        db.commit()
                        print('已下架')
                    except:
                        print('Delete Update failed')
            except:
                print('Skip')
        if WebName == '永慶房屋':
            try:
                resources = requests.get(arr[1])
                soup = BeautifulSoup(resources.text, 'html.parser')
                if soup.find('div',id='maintain').string=='很抱歉，您要找的房子已經不存在！':
                    delete_sql="""UPDATE `page_data` SET `Is_Delete`= %s WHERE `id`= %s"""
                    val=("Y", arr[0])
                    try:
                        Dcursor.execute(delete_sql,val)
                        db.commit()
                        print('已下架')
                    except:
                        print('Delete Update failed')
            except:
                print('Skip')
        if WebName=='591網':
            try:
                resources = requests.get(arr[1])
                soup = BeautifulSoup(resources.text, 'html.parser')
                if soup.find("div",class_="title").string=='很抱歉，您查詢的物件不存在，可能已關閉或者被刪除。':
                    delete_sql="""UPDATE `page_data` SET `Is_Delete`= %s WHERE `id`= %s"""
                    val=("Y", arr[0])
                    try:
                        Dcursor.execute(delete_sql,val)
                        db.commit()
                        print('已下架')
                    except:
                        print('Delete Update failed')
            except:
                print('Skip')
        if not arr:
            break
except:
    print("Select is failed")

Dcursor.close()
cursor.close()
db.close()


