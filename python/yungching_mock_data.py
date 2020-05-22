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
        Host: rent.yungching.com.tw
        User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:77.0) Gecko/20100101 Firefox/77.0
        Accept: */*
        Accept-Language: zh-TW,zh;q=0.8,en-US;q=0.5,en;q=0.3
        Accept-Encoding: gzip, deflate
        Content-Type: application/x-www-form-urlencoded; charset=UTF-8
        X-Requested-With: XMLHttpRequest
        Origin: http://rent.yungching.com.tw
        Connection: keep-alive
        Referer: http://rent.yungching.com.tw/
        Cookie: TRID_G=d3060fbf-30de-4d92-bf2a-cd4f51b193a5; _gcl_au=1.1.80411668.1588681600; __auc=e88ca31c171e4cd6b0c3276950d; _pk_id.20.e415=7bad8c09db4da47d.1588681600.2.1589610209.1589610207.; __lt__cid=8afd84ef-8d14-43a5-afec-d138d837d077; _ga=GA1.4.932627257.1588681601; ASP.NET_SessionId=deret2ao3q33hve3o2xxyjab; SEID_G=d79e8ec9-5ff7-42b6-9505-9dd9b5895089; OvertureRecord=OR=dWhxdzF8eHFqZmtscWoxZnJwMXd6Mg==&OQ=&WTMC_ID=; TS018a342d=01aebff4149825dd7ef5dd2634837449b9642cc8cf45be3f5c002e1c604a1c7443eb16102254f34338db7443e3216a5bde6201bf2d09454c026afdb97ceb072d8c0961bb9fe69adef3aad9bb9dc3a8275047afa132; TS013996a5=01aebff414ab6f91e2ea7bfc4eb04ef42d5616fe4448b97f2be85091cf3ac44c8e2361bb2120ab5da8f5ed177d3d9ba39b135280410663a2dad2e3598d0052f843b73f0879; ez2o_UNID=1589606523379379; isMember=N; WMX_Channel=,10,; __ltmwga=utmcsr=(direct)|utmcmd=(none); _gid=GA1.4.1806008659.1589606524; __asc=c57c15d41721c26d754e9c10cf2; __lt__sid=cbd65f9e-6d8870c0; _pk_ses.20.e415=*
        Cache-Control: max-age=0, no-cache
        Pragma: no-cache
    '''
    main(url, params, text, headers)

