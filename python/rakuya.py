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

    for house in soup.select('.obj-item'):
        house_mask=[]
        for a in house.select('a'):
            house_mask.append(a)
        house_url=house.select_one('a')['href']
        house_address=house.find(class_="obj-address").string
        house_info1=house.find_all('span')
        house_info2=[]
        for x in house_info1:
            house_info2.append(str(x.string))
        result.append({
            'image':str(house_mask[0]['style'][22:-2]),
            'Link': house_url,
            'house_name':house_mask[1].string,
            'address': house_address,
            'house_money':house_info2[3][:-1],
            'house_type':house_info2[4],
            'floor':house_info2[7],
            'square_meters':house_info2[6][:-1],
            'pattern':house_info2[5]
        })
    for i, data in enumerate(result):
        print(f'#{i}: ')
        print('圖片：'+data['image'])
        print('網址：'+data['Link'])
        print('房名：'+data['house_name'])
        print('地址：'+data['address'])
        print('價格：'+data['house_money'])
        print('類型：'+data['house_type'])
        print('樓層：'+data['floor'])
        print('坪數：'+data['square_meters'])
        print('房型：'+data['pattern'])
        print()
  
        sqlinsert = ("INSERT INTO page_data(WebName,images,Link,house,adress,money,house_type,floor,square_meters,pattern)" "VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)")
        val = ['樂屋網',data['image'],data['Link'],data['house_name'],data['address'],data['house_money'],data['house_type'],data['floor'],data['square_meters'],data['pattern']]
        cursor.execute(sqlinsert,val)
        db.commit()
    print(f'Total: {len(result)}')
    # return soup.find(class_="pages").string[5:-1]總頁數


count=1#頁數
while count<=2:
    pageURL="https://www.rakuya.com.tw/search/rent_search/index?display=list&con=&tab=def&sort=11&ds=&page="+str(count)+".html"
    print(f'=================第{count}頁==================')
    print(pageURL)
    pageURL=getData(pageURL)
    count+=1
db.close()