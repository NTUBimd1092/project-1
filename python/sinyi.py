import requests
from bs4 import BeautifulSoup
import pymysql
from re import sub
db = pymysql.connect("localhost","root","1234","crawler")
cursor = db.cursor()
Ccursor=db.cursor()

def getData(url):
    requests.packages.urllib3.disable_warnings()
    resources = requests.get(url,verify=False)
    soup = BeautifulSoup(resources.text, 'html.parser')

    result= list()

    for house in soup.select('.search_result_item'):
        house_image = house.select_one('img')['src']
        house_name = house.find("span", class_="item_title").string
        address = house.find(class_="num num-text").string
        url = f'''https://www.sinyi.com.tw/rent/{house.select_one('a')['href']}'''
        price_tag = house.find("div", class_="price_new")
        price = price_tag.find("span", class_="num").string
        money = int(sub(r'[^\d.]', '', price))#轉換資料型態
        house_info=house.find("div",class_="detail_line2")
        house_info2=house_info.find_all('span',class_="num")
        house_info3=[]
        for x in house_info2:
            house_info3.append(str(x.string))
        if house_info3[0]=='土地':
            continue
        result.append({
            'images': house_image,
            'house_name': house_name,
            'address': address,
            'url': url,
            'house_money':money,
            'house_type':house_info3[0],
            'pattern':house_info3[2]+'房'+house_info3[3]+'廳'+house_info3[4]+'衛'+house_info3[5]+'室',
            'square_meters':float(house_info3[1]),
            'floor':house_info3[6]
        })

    for i, data in enumerate(result):
        print(f'#{i}: ')
        print(data['images'])
        print(data['house_name'])
        print(data['address'])
        print(data['url'])
        print(data['house_money'])
        print(data['house_type'])
        print(data['pattern'])
        print(data['square_meters'])
        print(data['floor'])
        print()
        checker=f"""SELECT COUNT(*) FROM page_data WHERE `Link`='{data['url']}'"""
        Ccursor.execute(checker)
        count=Ccursor.fetchone()
        if count[0]==0:
            sqlinsert = ("INSERT INTO page_data(WebName,images,adress,house,Link,money,house_type,pattern,square_meters,floor)" "VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)")
            val = ['信義房屋',data['images'],data['address'],data['house_name'],data['url'],data['house_money'],data['house_type'],data['pattern'],data['square_meters'],data['floor']]
            cursor.execute(sqlinsert,val)
            sqlinsert_moneychange = ("INSERT INTO money_change(Link,money)" "VALUES(%s,%s)")
            change = [data['url'],data['house_money']]
            cursor.execute(sqlinsert_moneychange,change)
            db.commit()
        else:
            print('已重複')
    print(f'Total: {len(result)}')

count=1#頁數156
while count<=3:
    pageURL="https://www.sinyi.com.tw/rent/list/"+str(count)+".html"
    print(f'=================第{count}頁==================')
    print(pageURL)
    pageURL=getData(pageURL)
    count+=1
db.close()