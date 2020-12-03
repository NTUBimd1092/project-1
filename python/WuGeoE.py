import requests
from bs4 import BeautifulSoup
import re
import json
from re import sub
import pymysql

# db = pymysql.connect("us-cdbr-east-02.cleardb.com","badaadfc741319","fd67aae8","heroku_64a98996a6e263e", charset='utf8')
db = pymysql.connect("localhost","root","xu.61i6u;6","heroku_56d2d16ef2b2e35")
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
                        import PyEmail
                        PyEmail.Email(Url)
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

        # headers=randomUA.getrandomUA()
        
        headers = '''        
        Accept: application/json, text/javascript, */*; q=0.01
        Accept-Encoding: gzip, deflate, br
        Accept-Language: zh-TW,zh;q=0.9,en-US;q=0.8,en;q=0.7
        Connection: keep-alive
        Cookie: urlJumpIp=1; urlJumpIpByTxt=%E5%8F%B0%E5%8C%97%E5%B8%82; _ga=GA1.4.111678988.1604393300; __auc=d8078dc51758d4af2d2a1082cbb; __utma=82835026.111678988.1604393300.1604393301.1604393301.1; __utmz=82835026.1604393301.1.1.utmcsr=localhost|utmccn=(referral)|utmcmd=referral|utmcct=/; T591_TOKEN=eni71mni33eb7260vkghtgeop5; _fbp=fb.2.1604393304173.1652886249; is_new_index=1; is_new_index_redirect=1; tw591__privacy_agree=0; new_rent_list_kind_test=0; webp=1; PHPSESSID=0mlr5v4l2b1rkrrmkp5et8amg7; user_index_role=1; user_browse_recent=a%3A1%3A%7Bi%3A0%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A8%3A%2210107984%22%3B%7D%7D; localTime=1; c10f3143a018a0513ebe1e8d27b5391c=1; _gid=GA1.3.1387178426.1606455061; _gat=1; _gid=GA1.4.1387178426.1606455061; _dc_gtm_UA-97423186-1=1; _gat_UA-97423186-1=1; XSRF-TOKEN=eyJpdiI6IjZmSE1UYUZzMzdLUTMyY013MU5UOUE9PSIsInZhbHVlIjoiVGpITk90TVwvbExKaEZmSUNUWkwzU0o1Q3lRdlwvOWNHMlNBNDJvZWRkb3lXbjZyd05jNjl2TU1UeVRmTlhXb2V2ZUg1NDBOUzUyblwvK1wvWXFxRVlKUU13PT0iLCJtYWMiOiJiNTlhMmFlNjQ0MTJiMTZjYjlmNTA2ZDFmMDI3YmY1N2FmN2M3M2FkYTBiMTJlYmQzNWQwZGIwYzg2NzZjNjdjIn0%3D; _ga=GA1.1.111678988.1604393300; _ga_ZDKGFY9EDM=GS1.1.1606455060.3.1.1606455063.0; 591_new_session=eyJpdiI6IkdWaEE4TVBMalpMWlNvUTJqekhhK2c9PSIsInZhbHVlIjoiME9DQVJuRjRTNWViTm1hdW8rRkJUUlQ4a28wR2R3UGcrVDJZNURRZ05XY25Dc2tvXC9yWWpEVWRHT0VERFMxbEdxdzduVGtrQzhtR2FZayt6TENwWkF3PT0iLCJtYWMiOiIxZTcxZDk1YjFjYzE5ZGQ4YThiNzkwMzY0NzkzNDlhMTkxMmRkOThmNzA1NmY0ZmY0ZmM1ZDNlNWE1MmY2MzdiIn0%3D
        Host: rent.591.com.tw
        Referer: https://rent.591.com.tw/?kind=0&region=1
        Sec-Fetch-Dest: empty
        Sec-Fetch-Mode: cors
        Sec-Fetch-Site: same-origin
        User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36
        X-CSRF-TOKEN: PB1R6WmPSYIpf6FcWbRDSssDvcBG0iQMVqU3z5ju
        X-Requested-With: XMLHttpRequest
        '''
        main(url, params, text, headers)
        Readpage+=1
        print(f'=========================Rowcount:{Rowcount}=========================')
        Rowcount+=30
db.close()        
