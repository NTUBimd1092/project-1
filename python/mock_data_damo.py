import requests
from bs4 import BeautifulSoup
import pymysql
db = pymysql.connect("localhost","root","1234","crawler")
cursor = db.cursor()

url = 'https://www.sinyi.com.tw/rent/list/1.html'

resources = requests.get(url)
soup = BeautifulSoup(resources.text, 'html.parser')

result= list()

for house in soup.select('.search_result_item'):
    house_name = house.find("span", class_="item_title").string
    address = house.find(class_="num num-text").string
    url = f'''https://www.sinyi.com.tw/rent/{house.select_one('a')['href']}'''
    house_money = house.find("span", class_="num").string
    result.append({
        'house_name': house_name,
        'address': address,
        'url': url,
        'house_money':house_money
    })

for i, data in enumerate(result):
    print(f'#{i}: ')
    print(data['house_name'])
    print(data['address'])
    print(data['url'])
    print(data['house_money'])
    print()
    sqlinsert = ("INSERT INTO page_data(WebName,adress,house,Link,money)" "VALUES(%s,%s,%s,%s,%s)")
    val = ['信義房屋',data['address'],data['house_name'],data['url'],data['house_money']]
    cursor.execute(sqlinsert,val)
    db.commit()
print(f'Total: {len(result)}')
