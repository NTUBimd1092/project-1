import requests
from bs4 import BeautifulSoup
import pymysql
from re import sub
db = pymysql.connect("localhost","root","1234","crawler")
cursor = db.cursor()

def getData(url):
    resources = requests.get(url)
    soup = BeautifulSoup(resources.text, 'html.parser')

    result= list()

    for house in soup.find_all('ul',class_='listInfo'):
        images=house.select_one('img')['data-original']
        Link=f'''https:{house.select_one('a')['href']}'''
        house_name=house.select_one('a').string
        adress=str(house.find('em').string)
        money=str(house.select_one('.price')('i'))[4:-5]
        money1=int(sub(r'[^\d.]', '',money))
        
        house_info=str(house.select_one('.lightBox')).replace(" ","")

        house_type_start=house_info.find('>')#第幾個字開始
        house_type_end=house_info.find('<i>')#結束
        house_type=house_info[house_type_start+2:house_type_end-1]

        floor_start=house_info.find('樓層：')#第幾個字開始
        floor_end=house_info.find('</p')#結束
        floor=house_info[floor_start+3:floor_end]
        
        if house_info.find('衛') ==-1:#第幾個字開始
            meters_start=house_info.find('</i>')+4
        else:
            meters_start=house_info.find('衛')+13
        meters_end=house_info.find('坪')#結束
        if len(house_info[meters_start:meters_end])<5:
            meters=house_info[meters_start:meters_end]
        else:
            meters=' '  
        
        pattern_start=house_info.find('</i>')#第幾個字開始
        pattern_end=house_info.find("衛")#結束
        pattern=house_info[pattern_start+4:pattern_end+1]

        result.append({
            'image':images,
            'Link':Link,
            'house_name':house_name,
            'address':adress,
            'house_money':money1,
            'house_type':house_type,
            'floor':floor,
            'square_meters':meters,
            'pattern':pattern
        })
        if str(house.select_one('.lightBox')).replace(" ","")=='停車場':
            continue 
        for i, data in enumerate(result):
            print(f'#{i}: ')
            print('圖片：'+data['image'])
            print('網址：'+data['Link'])
            print('房名：'+data['house_name'])
            print('地址：'+data['address'])
            print(data['house_money'])
            print('類型：'+data['house_type'])
            print('樓層：'+data['floor'])
            print(data['square_meters'])
            print('房型：'+data['pattern'])
            print()
        # sqlinsert = ("INSERT INTO page_data(WebName,images,Link,house,adress,money,house_type,floor,square_meters,pattern)" "VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)")
        # val = ['591房屋',data['image'],data['Link'],data['house_name'],data['address'],data['house_money'],data['house_type'],data['floor'],data['square_meters'],data['pattern']]
        # cursor.execute(sqlinsert,val)
        # sqlinsert_moneychange = ("INSERT INTO money_change(Link,money)" "VALUES(%s,%s)")
        # change = [data['Link'],data['house_money']]
        # cursor.execute(sqlinsert_moneychange,change)
        # db.commit()
    print(f'Total: {len(result)}')

count=1#頁數
while count<=1:
    pageURL="https://rent.591.com.tw/?kind=0&region="+str(count)
    print(f'=================第{count}頁==================')
    print(pageURL)
    pageURL=getData(pageURL)
    count+=1
db.close()

