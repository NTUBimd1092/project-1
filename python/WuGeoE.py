import requests
from bs4 import BeautifulSoup
import re
import json
from re import sub
import pymysql
db = pymysql.connect("localhost","root","1234","crawler" )
cursor = db.cursor()
Ccursor=db.cursor()
Moneychange=db.cursor()
def str2obj(s, s1=';', s2='='):
    li = s.split(s1)
    res = {}

    for kv in li:
        li2 = kv.split(s2)
        if len(li2) > 1:
            res[li2[0].lstrip()] = li2[1]

    return res
Rowcount=0
Readpage=0
while Readpage<=1:
    def main(url, params='', data='', headers=''):
        headers = str2obj(headers, '\n', ': ')

        r = requests.get(url, params=params, data=text, headers=headers)
        data=json.loads(r.text)
        post=data["data"]["data"]
        i=0
        for DataRow in post:
            Url=f'https://rent.591.com.tw/rent-detail-{DataRow["id"]}.html'
            Images=f'{DataRow["cover"]}'
            Address=f'{DataRow["regionname"]}{DataRow["sectionname"]}{DataRow["street_name"]}{DataRow["alley_name"]}{DataRow["addr_number_name"]}'
            Name=f'{DataRow["address_img_title"]}'
            Money=int(sub(r'[^\d.]', '', str(DataRow["price"])))
            HouseType=f'{DataRow["kind_name"]}'
            Pattern=f'{DataRow["layout"]}'
            Meters=f'{DataRow["area"]}'
            Floor=f'{DataRow["floor"]}/{DataRow["allfloor"]}'

            checker=f"""SELECT COUNT(*) FROM page_data WHERE `Link`='{Url}'"""
            Ccursor.execute(checker)
            count=Ccursor.fetchone()
            try:
                if count[0]==0:
                    sqlinsert = ("INSERT INTO page_data(WebName,images,adress,house,Link,money,house_type,pattern,square_meters,floor)" "VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)")
                    val = ['591網',Images,Address,Name,Url,Money,HouseType,Pattern,Meters,Floor]
                    cursor.execute(sqlinsert,val)
                    sqlinsert_moneychange = ("INSERT INTO money_change(Link,money)" "VALUES(%s,%s)")
                    change = [Url,Money]
                    cursor.execute(sqlinsert_moneychange,change)
                    db.commit()
                    Msg='完成!'
                else:   
                    sqlUpdate=(f"UPDATE page_data SET Images=%s,adress=%s,house=%s,money=%s,house_type=%s,pattern=%s,square_meters=%s,floor=%s WHERE Link =%s")
                    val=[Images,Address,Name,Money,HouseType,Pattern,Meters,Floor,Url]
                    cursor.execute(sqlUpdate,val)
                    select_moneychange=f"""SELECT `money` FROM `money_change` WHERE `Link`='{Url}' LIMIT 0 , 1"""
                    Moneychange.execute(select_moneychange)
                    Moneyc=Moneychange.fetchone()
                    if Moneyc[0]!=Money:
                        sqlinsert_moneychange = ("INSERT INTO money_change(Link,money)" "VALUES(%s,%s)")
                        change = [Url,Money]
                        cursor.execute(sqlinsert_moneychange,change)
                        Msg+="價格有異動！"
                    db.commit()
                    Msg='已更新！'
            except:
                Msg='寫入失敗'
            
            print(f'#{i}')
            print(f'網址：{Url}')
            print(f'圖片：{DataRow["cover"]}')
            print(f'房名：{DataRow["address_img_title"]}')
            print(f'地址：{DataRow["regionname"]}{DataRow["sectionname"]}{DataRow["street_name"]}{DataRow["alley_name"]}{DataRow["addr_number_name"]}')
            print(f'型態：{DataRow["kind_name"]}')
            print(f'房型：{DataRow["layout"]}')
            print(f'樓層：{DataRow["floor"]}/{DataRow["allfloor"]}')
            print(f'坪數：{DataRow["area"]}')
            print(f'價格：{Money}')
            print(Msg)
            print()
            i+=1
        print(f'共{i}筆')
    if __name__ == '__main__':

        url = f"""https://rent.591.com.tw/home/search/rsList?is_new_list=1&type=1&kind=0&searchtype=1&region=1&rentprice=0&firstRow={Rowcount}"""
        
        text=""

        params={'is_new_list': '1','type': '1','kind': '0','searchtype': '1','region': '1'
        ,'rentprice': '0'
        ,'firstRow': Rowcount
        }

        headers = '''        
        Accept: application/json, text/javascript, */*; q=0.01
        Accept-Encoding: gzip, deflate, br
        Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7
        Connection: keep-alive
        Cookie: is_new_index=1; is_new_index_redirect=1; T591_TOKEN=c8s5odhcjdfe35h5pdg0f5tge2; _ga=GA1.3.1404095315.1598670258; _ga=GA1.4.1404095315.1598670258; _fbp=fb.2.1598670258798.1024156568; fcm_pc_token=caEafU25k4o%3AAPA91bE16sv6GodbCZWZPeI6aFCdo9QRK6rqbjZDnaoBuCHJae4wTAVKULlTbd-QdzwrOgGvCbWghTqd8aw-XIkAyOAIpVN30DV_ByGKV_2z39gt8FBqC2SCgVNPfhFGRknPDLitXslH; tw591__privacy_agree=1; user_index_role=1; __auc=439c342417449ceef33ce64cca7; urlJumpIp=1; urlJumpIpByTxt=%E5%8F%B0%E5%8C%97%E5%B8%82; webp=1; PHPSESSID=035a32b1ad4df2e67f88335b98451198; _gid=GA1.3.1531950116.1603130593; _gid=GA1.4.1531950116.1603130593; __utmc=82835026; __utmz=82835026.1603130658.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); c10f3143a018a0513ebe1e8d27b5391c=1; user_browse_recent=a%3A5%3A%7Bi%3A0%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229859557%22%3B%7Di%3A1%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%228015560%22%3B%7Di%3A2%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229726667%22%3B%7Di%3A3%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229411633%22%3B%7Di%3A4%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A7%3A%229660721%22%3B%7D%7D; localTime=2; __utma=82835026.1404095315.1598670258.1603130658.1603136335.2; new_rent_list_kind_test=0; _gat_UA-97423186-1=1; _gat=1; XSRF-TOKEN=eyJpdiI6InVsbzRYVjRac2FldGkyV0ZXUGxrVmc9PSIsInZhbHVlIjoiYjNQQkpENnQySjhtSmkyMERTUDVRcEdkTmI4cHBHcmNZN0thVnVhZjRUR2JtVzhVZGJsVURqSW9jMTNcL3J0YW1pRkE3eWsxWk1cLzZQVElZRTlXcE1JQT09IiwibWFjIjoiNmRkNjU1ZDIxZWIxNjI0MjkzNTM2Y2JjZTFjNTc2MmNmZTZjOTQ3OWUwYWRiNjRjNWNlODkxNDAzOTM5YThkNSJ9; 591_new_session=eyJpdiI6ImhXTTlkblpuM2llSnQzOTFyNjFaVkE9PSIsInZhbHVlIjoiWlpIQ2ppZVZ0c2lDa09XOXJKVEhrXC9wUUVHXC9DYzBnRzRYZVd1NTh0ZGRvSlwvbWxsMTBhTXhVVDBNVGl1XC8xYXJmSnpRS2dRY2tJU1dqMVVZVm9SaTVnPT0iLCJtYWMiOiI2ZjA2ZjhmMmZmMzM3ZjE0YmVjYmJiNzZjMDkyOWY5YTQ5YzQ1YTFhNGVmYzM2YTU4OTFjYmEwMjU0ZDFhMjJiIn0%3D
        Host: rent.591.com.tw
        Referer: https://rent.591.com.tw/?kind=0&region=1&rentprice=0
        Sec-Fetch-Dest: empty
        Sec-Fetch-Mode: cors
        Sec-Fetch-Site: same-origin
        User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36
        X-CSRF-TOKEN: hos91tyR5EEkRrK0KnKKPjBiCnmKR7nZ7shZ642g
        X-Requested-With: XMLHttpRequest
        '''
        main(url, params, text, headers)
        Readpage+=1
        print(f'=========================Rowcount:{Rowcount}=========================')
        Rowcount+=30
db.close()        
