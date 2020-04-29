import requests
from bs4 import BeautifulSoup
url="https://www.rakuya.com.tw/search/rent_search/index?display=list&con=&tab=def&sort=11&ds=&page=1"
resources = requests.get(url)
soup = BeautifulSoup(resources.text, 'html.parser')

result= list()

for house in soup.select('.obj-info'):
    house_name=house.find('a').string
    house_address=house.find(class_="obj-address").string
    house_url=house.select_one('a')['href']
    house_money=house.find('span').string[:-1]
    house_info1=house.find_all('span')
    house_info2=[]
    for x in house_info1:
        house_info2.append(str(x.string))
    result.append({
        'Link': house_url,
        'house_name':house_name,
        'address': house_address,
        'house_money':house_money,
        'house_type':house_info2[1],
        'floor':house_info2[4],
        'square_meters':house_info2[3][:-1],
        'pattern':house_info2[2],
    })

for i, data in enumerate(result):
    print(f'#{i}: ')
    print(data['Link'])
    print(data['house_name'])
    print(data['address'])
    print(data['house_money'])
    print(data['house_type'])
    print(data['floor'])
    print(data['square_meters'])
    print(data['pattern'])
    print()
print(f'Total: {len(result)}')
print(soup.find(class_="pages").string[5:-1])