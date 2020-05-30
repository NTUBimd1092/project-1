import requests
from bs4 import BeautifulSoup
import re
import json
from re import sub
import pymysql


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
    soup = BeautifulSoup(json_data.text, 'html.parser')

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
            meters=float(house_info[meters_start:meters_end])
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
        # for i, data in enumerate(result):
        #     print(f'#{i}: ')
        #     print('圖片：'+data['image'])
        #     print('網址：'+data['Link'])
        #     print('房名：'+data['house_name'])
        #     print('地址：'+data['address'])
        #     print(data['house_money'])
        #     print('類型：'+data['house_type'])
        #     print('樓層：'+data['floor'])
        #     print(data['square_meters'])
        #     print('房型：'+data['pattern'])
        #     print()
        #     print(f'Total: {len(result)}')

    
if __name__ == '__main__':
    url = 'https://rent.591.com.tw/'

    params = {'kind': '0','region':'1'}

    text = f'''kind=0&region=1'''

    headers = '''
    Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
    Accept-Encoding: gzip, deflate, br
    Accept-Language: zh-TW,zh;q=0.9,zh-CN;q=0.8
    Cache-Control: max-age=0
    Connection: keep-alive
    Cookie: T591_TOKEN=8aqrksj7pshvt1r73d2jdtk5m7; _ga=GA1.3.2137437365.1590139512; _ga=GA1.4.2137437365.1590139512; user_index_role=1; __auc=051ea1dc1723bb391a4d910513d; new_rent_list_kind_test=0; tw591__privacy_agree=1; is_new_index=1; is_new_index_redirect=1; last_search_type=1; webp=1; PHPSESSID=h4vc3co67ail6fsmfhunnpcoq0; c10f3143a018a0513ebe1e8d27b5391c=1; _gid=GA1.3.582231883.1590407657; _gid=GA1.4.582231883.1590407657; __utma=82835026.2137437365.1590139512.1590407717.1590407717.1; __utmc=82835026; __utmz=82835026.1590407717.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); user_sessionid=h4vc3co67ail6fsmfhunnpcoq0; DETAIL[1][9226051]=1; user_browse_recent=a%3A5%3A%7Bi%3A0%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229226051%22%3B%7Di%3A1%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229220646%22%3B%7Di%3A2%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229169055%22%3B%7Di%3A3%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229162780%22%3B%7Di%3A4%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229277619%22%3B%7D%7D; __asc=1e2abef51724c798c7e20714535; localTime=1; ba_cid=a%3A5%3A%7Bs%3A6%3A%22ba_cid%22%3Bs%3A32%3A%22b75317a98376759486828e8ba8a606b8%22%3Bs%3A7%3A%22page_ex%22%3Bs%3A92%3A%22https%3A%2F%2Fhelp.591.com.tw%2Fcontent%2F76%2F186%2Ftw%2F%25E9%259A%25B1%25E7%25A7%2581%25E6%25AC%258A%25E8%2581%25B2%25E6%2598%258E.html%22%3Bs%3A4%3A%22page%22%3Bs%3A48%3A%22https%3A%2F%2Frent.591.com.tw%2Frent-detail-9226051.html%22%3Bs%3A7%3A%22time_ex%22%3Bi%3A1590407865%3Bs%3A4%3A%22time%22%3Bi%3A1590420934%3B%7D; urlJumpIp=1; urlJumpIpByTxt=%E5%8F%B0%E5%8C%97%E5%B8%82; XSRF-TOKEN=eyJpdiI6Ik9CWm5ZcGlab2FMcXQ0UjBtUllsSFE9PSIsInZhbHVlIjoicytTWnVURzVzK1grNnlqNmNrTFo2NlhzZVdlc3hMbm1QMHFcL0M4YlNhSVhuRlQwZW5uSnQ3OXhyWVIwYkE5S2lPNFhcL1RZeW11OEw2VThkZGNIUkNudz09IiwibWFjIjoiNzUzOWJhYWNhODU0MDcwODIyYTRlYWYyMWRmNDY4NjY0YzFkYTQ2MjUzNjJjYzNmMDUzOGYwZGM4MjZiNDJlMSJ9; 591_new_session=eyJpdiI6InA0NGJTb1lkWDY0TWdHTkRqSTcwb2c9PSIsInZhbHVlIjoiZndXVjE0ZHhlTnpmaEFMbnZsRm1KbURvU0JZM3p6XC96cjIzWG9qeFZFNWZzK2toZUFSb2ZwKzRJenNBQkNXYW1ZZFN5MTFLUkw0MllCVENRMkdFeHV3PT0iLCJtYWMiOiIxMzZlMDBkYjg0N2E1YzMwZTdhYjY1MzMxYTdkZjlmMGZjMTVmZGU1N2U3ZGI4YTI0MzNjMDVkNWE3ODFkYTA5In0%3D
    Host: rent.591.com.tw
    Referer: https://rent.591.com.tw/?kind=0&region=1
    Sec-Fetch-Dest: document
    Sec-Fetch-Mode: navigate
    Sec-Fetch-Site: same-origin
    Sec-Fetch-User: ?1
    Upgrade-Insecure-Requests: 1
    User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36
    '''
    main(url, params, text, headers)
    print((f'=================第count頁=================='))


