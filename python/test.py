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
    # print(json_data)

    soup = BeautifulSoup(json_data.text, 'html.parser')
    result= list() 
    for house in soup.find_all(class_='house_block'):
        images=house.select_one('img')['src']
        s=house.find_all('a')
        name=s[0]['title']
        Link=s[1]['href']
        a=house.find_all('li')
        address=a[0].string
        c=house.find(class_='price')
        price=c.find('span').string
        money = int(sub(r'[^\d.]', '', price))#轉換資料型態
        house_type=a[2].string[3:]
        meters=a[1].string[3:-1]
        floors=a[3].string[3:]
        pattern=a[4].string[3:]

        
    result.append({
        'images':images,
        'name':name,
        'Link':Link,
        'address':address,
        'money':money,
        'house_type':house_type,
        'meters':meters,
        'floor':floors,
        'pattern':pattern
        
        })
    for i, data in enumerate(result):
        print(f'#{i}: ')
        print(data['images'])
        print(data['name'])
        print(data['Link'])
        print(data['address'])
        print(data['money'])
        print(data['house_type'])
        print(data['meters'])
        print(data['floor'])
        print(data['pattern'])
        print()
    print(f'Total: {len(result)}')


if __name__ == '__main__':
    url = 'http://rent.yungching.com.tw/Ashx/ShowList.ashx'

    params = {'VID': '1250'}

    text = 'County=%E5%8F%B0%E5%8C%97%E5%B8%82&District=&Rooms=&PriceMin=&PriceMax=&AreaNeeds=&Purpose=&CaseType=&BuildAge=&CaseFloor=&DirFace=&ParkingSpace=&KeyWord=&Group=&ListMode=PhotosAndWords&PageCount=40&CurrentPage=1&CurrentRange=1&Sequence=&SearchMode=1&BuildNo=&BuildingID=&RoadName=&MainShopID='

    headers = '''
    Accept: */*
    Accept-Encoding: gzip, deflate
    Accept-Language: zh-TW,zh;q=0.9,zh-CN;q=0.8
    Connection: keep-alive
    Content-Length: 293
    Content-Type: application/x-www-form-urlencoded; charset=UTF-8
    Cookie: _gcl_au=1.1.949641578.1588681777; TRID_G=f8679cc4-0af9-4026-933d-0543a066503f; _ga=GA1.4.610099363.1588681794; __lt__cid=ce6a6036-bff1-4739-937e-7e2309044b27; __auc=d2190fc71721be0c67be5fb89bc; _gcl_aw=GCL.1589616696.Cj0KCQjwnv71BRCOARIsAIkxW9EJNCGaqlZLWTLJv5NhZS5WsOl8WydYRC720UwKcC-rMBMe3pjCKaoaAqIgEALw_wcB; __dmwsc=20170500d06ks0000u0000,br2fevvzrysv4hx1rwaqxmx5,dm00245; SEID_G=dd953113-bb1a-4537-badd-686723742a67; TS013996a5=01aebff414233388730273f13debc88808011b7fb3e2f82e3778ece6d1038a74447fe02e5f4109d7b9e841e8dca0897554c45da38609894a0727a3fdbe73a457f0e56f548f; ASP.NET_SessionId=gbkrq5o0mbwiod4tnezoqxon; OvertureRecord=OR=dWhxdzF8eHFqZmtscWoxZnJwMXd6Mg==&OQ=&WTMC_ID=; ez2o_UNID=1590161083425425; isMember=N; WMX_Channel=,10,; _gid=GA1.4.1127926449.1590161084; __asc=1abfac651723cfc8dddbcbc6cf6; __lt__sid=4d123914-71104324; __ltmwga=utmcsr=(direct)|utmcmd=(none); _pk_ses.20.e415=*; TS018a342d=01aebff4143f7b4b2fa7fa84be4e15f1de0b85f494057b4e4adcaf5705aac3b6d66ea4494d5f0e3f827a8f69f9785288a73b533d46a99fe9a272d42e3b9456fe2709d3ca3e0f03004b1ef2a52b57d9a439534e034a; _dc_gtm_UA-35108030-1=1; _pk_id.20.e415=fbb3bd40b923d897.1588681794.2.1590162206.1590161086.
    Host: rent.yungching.com.tw
    Origin: http://rent.yungching.com.tw
    Referer: http://rent.yungching.com.tw/
    User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36
    X-Requested-With: XMLHttpRequest
    '''
    main(url, params, text, headers)

