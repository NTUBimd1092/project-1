import requests
from bs4 import BeautifulSoup
import re
import json
from re import sub

def str2obj(s, s1=';', s2='='):
    li = s.split(s1)
    res = {}

    for kv in li:
        li2 = kv.split(s2)
        if len(li2) > 1:
            res[li2[0].lstrip()] = li2[1]

    return res



def main(url, params='', data='', headers=''):
    headers = str2obj(headers, '\n', ': ')

    json_data = requests.post(url, params=params, data=text, headers=headers)
    json_data.encoding = 'utf-8'
    print(json_data.text)

    # soup = BeautifulSoup(json_data.text, 'html.parser')
    # result= list() 
    # for house in soup.find_all(class_='house_block'):
    #     images=house.select_one('img')['src']
    #     s=house.find_all('a')
    #     name=s[0]['title']
    #     Link=s[1]['href']
    #     a=house.find_all('li')
    #     address=a[0].string
    #     c=house.find(class_='price')
    #     price=c.find('span').string
    #     money = int(sub(r'[^\d.]', '', price))#轉換資料型態
    #     house_type=a[2].string[3:]
    #     meters=a[1].string[3:-1]
    #     floors=a[3].string[3:]
    #     pattern=a[4].string[3:]

        
    # result.append({
    #     'images':images,
    #     'name':name,
    #     'Link':Link,
    #     'address':address,
    #     'money':money,
    #     'house_type':house_type,
    #     'meters':meters,
    #     'floor':floors,
    #     'pattern':pattern
        
    #     })
    # for i, data in enumerate(result):
    #     print(f'#{i}: ')
    #     print(data['images'])
    #     print(data['name'])
    #     print(data['Link'])
    #     print(data['address'])
    #     print(data['money'])
    #     print(data['house_type'])
    #     print(data['meters'])
    #     print(data['floor'])
    #     print(data['pattern'])
    #     print()
    # print(f'Total: {len(result)}')


if __name__ == '__main__':
    url = 'https://rent.housefun.com.tw/?utm_source=yc&utm_medium=banner&utm_term=20121225&utm_content=rent_yc200x200_20121225&utm_campaign=normal_rent'

    params = {'VID': '125.0'}

    text = 'County=%E5%8F%B0%E5%8C%97%E5%B8%82&District=&Rooms=&PriceMin=&PriceMax=&AreaNeeds=&Purpose=&CaseType=&BuildAge=&CaseFloor=&DirFace=&ParkingSpace=&KeyWord=&Group=&ListMode=PhotosAndWords&PageCount=40&CurrentPage=1&CurrentRange=1&Sequence=&SearchMode=1&BuildNo=&BuildingID=&RoadName=&MainShopID='

    headers = '''
    Accept: application/json, text/javascript, */*; q=0.01
    Accept-Encoding: gzip, deflate, br
    Accept-Language: zh-TW,zh;q=0.9,zh-CN;q=0.8
    Connection: keep-alive
    Content-Length: 1579
    Content-Type: application/x-www-form-urlencoded; charset=UTF-8
    Cookie: TRID_G=1b35b19d-0eac-4431-a651-71895d637a43; _gcl_au=1.1.2004605135.1589886487; _ga=GA1.1.205722552.1589886487; __lt__cid=9ca9b043-7ca8-448a-9a1b-0301a078dbfd; _ga=GA1.4.205722552.1589886487; ASP.NET_SessionId=hqdwmupzv2povas3thmqzifv; SEID_G=84a19eae-c1f7-4fb0-8ae6-8459a4f2d0f7; _gid=GA1.4.969615984.1590158130; __ltm_https_flag=true; userid=aaf1f8af-6ff6-4b97-82aa-3fffdf714123; TS01311cb4=01aebff41437d836bbfbee7a5e9fa6f7f9d17b2da9e28c87fc7626ac7803445ce0f9393a73633eae8cba795f2b046d11a3da9947871453de9c0c5975051406f62be9c17aaa; utmMedium=banner; utmUrl=http%3a%2f%2frent.yungching.com.tw%2f; wmRefUrl=http%3a%2f%2frent.yungching.com.tw%2f; utmSource=yc; utmContent=rent_yc200x200_20121225; TS012304eb=01aebff4141f3c204b3d1460627f4152d7fa78c5659d68b60b9c38ce32c43cbb6c6f103161ae1a6ea72694686d0c1dc26487544c8e577dfc40ab122b845804e401b9b04dec889c5a549745688d1c67a6c82f5daeac896181105672d3f1e6ad4821a36f2e2ec77698ed050ad9dbec6edbd0dea2e3d3efc92b7b1d60c3a01cdcb0a85765ba98b12b6df0bf625283c3dc31cd5e0f513a; __lt__sid=20a2f515-2f8e18a4; _dc_gtm_UA-22823074-7=1; _dc_gtm_UA-34471860-1=1; __ltmwga=utmcsr=yc|utmccn=normal_rent|utmcmd=banner|utmctr=20121225|utmcct=rent_yc200x200_20121225; _ga_SVV6GP063K=GS1.1.1590164792.4.1.1590164809.0; _pk_id.22.4751=538b3bd5b88849ac.1589886487.0.1590164810..
    Host: rent.housefun.com.tw
    Origin: https://rent.housefun.com.tw
    Referer: https://rent.housefun.com.tw/?utm_source=yc&utm_medium=banner&utm_term=20121225&utm_content=rent_yc200x200_20121225&utm_campaign=normal_rent
    Sec-Fetch-Dest: empty
    Sec-Fetch-Mode: cors
    Sec-Fetch-Site: same-origin
    User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36
    X-Requested-With: XMLHttpRequest
    '''
    main(url, params, text, headers)

