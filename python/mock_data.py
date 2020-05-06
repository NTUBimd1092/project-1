import requests
from bs4 import BeautifulSoup
url="https://www.sinyi.com.tw/rent/index.php"
resources = requests.get(url)
soup = BeautifulSoup(resources.text, 'html.parser')

result= list()

for house in soup.select('.search_result_item'):
    house_image = house.select_one('img')['src']
    house_name = house.find("span", class_="item_title").string
    address = house.find(class_="num num-text").string
    url = f'''https://www.sinyi.com.tw/rent/{house.select_one('a')['href']}'''
    price_tag = house.find("div", class_="price_new")
    price = price_tag.find("span", class_="num").string
    house_info=house.find("div",class_="detail_line2")
    house_info2=house_info.find_all('span',class_="num")
    house_info3=[]
    for x in house_info2:
        house_info3.append(str(x.string))
    result.append({
        'images': house_image,
        'house_name': house_name,
        'address': address,
        'url': url,
        'house_money':price,
        'house_type':house_info3[0],
        'pattern':house_info3[2]+house_info3[3]+house_info3[4]+house_info3[5],
        'square_meters':house_info3[1],
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
print(f'Total: {len(result)}')
