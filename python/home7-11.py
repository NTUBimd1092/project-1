import requests
from bs4 import BeautifulSoup
url="http://www.home7-11.com.tw/lsearch.asp"#好宅網
resources = requests.get(url)
soup = BeautifulSoup(resources.text, 'html.parser')

result= list()
print(soup.select('.list'))

for house in soup.select('.list-h'):
    result.append({
        'image':'',
        'Link': '',
        'house_name':'',
        'address': '',
        'house_money':'',
        'house_type':'',
        'floor':'',
        'square_meters':'',
        'pattern':''
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
print(f'Total: {len(result)}')

