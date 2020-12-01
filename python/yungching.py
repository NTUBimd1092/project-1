import requests
from bs4 import BeautifulSoup
import re
import json
from re import sub
import pymysql
#db = pymysql.connect("us-cdbr-east-02.cleardb.com","b5647ade0475c5","40d209f8","heroku_56d2d16ef2b2e35")
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

count=1
while count<=10:
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
            address=a[0].string#地址
            c=house.find(class_='price')
            price=c.find('span').string#金額
            money = int(sub(r'[^\d.]', '', price))#轉換資料型態
            house_type=a[2].string[3:]#型態
            if house_type!="":
                house_type=a[2].string[3:]
            else:
                house_type='無'
            if a[1].string !="":
                meters_start=str(a[1].string).find('坪數:')
                meters_end=str(a[1].string).find('坪<')
                meters=a[1].string[meters_start+4:meters_end]#坪數
            else:
                meters=0
            floors=a[3].string[3:]#樓情
            pattern=a[4].string[3:]#房型
            
            result.append({
            'images':images,
            'name':name,
            'Link':'http://rent.yungching.com.tw/'+Link,
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
            checker=f"""SELECT COUNT(*) FROM page_data WHERE `Link`='{data['Link']}'"""
            Ccursor.execute(checker)
            count=Ccursor.fetchone()
            try:
                if count[0]==0:
                    sqlinsert = ("INSERT INTO page_data(WebName,images,adress,house,Link,money,house_type,pattern,square_meters,floor)" "VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)")
                    val = ['永慶房屋',data['images'],data['address'],data['name'],data['Link'],data['money'],data['house_type'],data['pattern'],float(data['meters']),data['floor']]
                    cursor.execute(sqlinsert,val)
                    sqlinsert_moneychange = ("INSERT INTO money_change(Link,money)" "VALUES(%s,%s)")
                    change = [data['Link'],data['money']]
                    cursor.execute(sqlinsert_moneychange,change)
                    select_moneychange=f"""SELECT `money` FROM `money_change` WHERE `Link`='{data['Link']}' LIMIT 0 , 1"""
                    Moneychange.execute(select_moneychange)
                    Money=Moneychange.fetchone()
                    if Money[0]!=data['money']:
                        sqlinsert_moneychange = ("INSERT INTO money_change(Link,money)" "VALUES(%s,%s)")
                        change = [data['Link'],data['money']]
                        cursor.execute(sqlinsert_moneychange,change)
                        import PyEmail
                        PyEmail.Email(data['Link'])
                        print("價格有異動！")
                    db.commit()
                    print('完成！')
                else:
                    sqlUpdate=(f"UPDATE page_data SET Images=%s,adress=%s,house=%s,money=%s,house_type=%s,pattern=%s,square_meters=%s,floor=%s WHERE Link =%s")
                    val=[data['images'],data['address'],data['name'],data['money'],data['house_type'],data['pattern'],float(data['meters']),data['floor'],data['Link']]
                    cursor.execute(sqlUpdate,val)
                    db.commit()
                    print('已更新！')
            except:
                print('寫入失敗')
        print(f'Total: {len(result)}')
        
    if __name__ == '__main__':
        url = 'http://rent.yungching.com.tw/Ashx/ShowList.ashx'

        params = {'VID': '1250'}

        text = f'''County=%E5%8F%B0%E5%8C%97%E5%B8%82&District=&Rooms=&PriceMin=&PriceMax=&AreaNeeds=&Purpose=&CaseType=&BuildAge=&CaseFloor=&DirFace=&ParkingSpace=&KeyWord=&Group=&ListMode=PhotosAndWords&PageCount=40&CurrentPage={count}&CurrentRange=1&Sequence=&SearchMode=1&BuildNo=&BuildingID=&RoadName=&MainShopID='''

        headers = '''
        Accept: */*
        Accept-Encoding: gzip, deflate
        Accept-Language: zh-TW,zh;q=0.9,zh-CN;q=0.8
        Connection: keep-alive
        Content-Type: application/x-www-form-urlencoded; charset=UTF-8
        Cookie: _gcl_au=1.1.949641578.1588681777; TRID_G=f8679cc4-0af9-4026-933d-0543a066503f; _ga=GA1.4.610099363.1588681794; __lt__cid=ce6a6036-bff1-4739-937e-7e2309044b27; __auc=d2190fc71721be0c67be5fb89bc; _gcl_aw=GCL.1589616696.Cj0KCQjwnv71BRCOARIsAIkxW9EJNCGaqlZLWTLJv5NhZS5WsOl8WydYRC720UwKcC-rMBMe3pjCKaoaAqIgEALw_wcB; __dmwsc=20170500d06ks0000u0000,br2fevvzrysv4hx1rwaqxmx5,dm00245; SEID_G=dd953113-bb1a-4537-badd-686723742a67; TS013996a5=01aebff414233388730273f13debc88808011b7fb3e2f82e3778ece6d1038a74447fe02e5f4109d7b9e841e8dca0897554c45da38609894a0727a3fdbe73a457f0e56f548f; ASP.NET_SessionId=gbkrq5o0mbwiod4tnezoqxon; OvertureRecord=OR=dWhxdzF8eHFqZmtscWoxZnJwMXd6Mg==&OQ=&WTMC_ID=; ez2o_UNID=1590161083425425; isMember=N; WMX_Channel=,10,; _gid=GA1.4.1127926449.1590161084; __ltmwga=utmcsr=(direct)|utmcmd=(none); _pk_id.20.e415=fbb3bd40b923d897.1588681794.3.1590164735.1590164732.; TS018a342d=01aebff414dc76cdb364e12829b5c5cfc96c3412c0391e748bf5b7f70bf6f03318b676655a2f160636d8b216d6045dcecc487dc2a6c36450ac7a31e5c4ef3311f91bd7f2836c5d737f1b7a4fe09ff1fe9728efeca2
        Host: rent.yungching.com.tw
        Origin: http://rent.yungching.com.tw
        Referer: http://rent.yungching.com.tw/
        User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36
        X-Requested-With: XMLHttpRequest
        '''
        main(url, params, text, headers)
        print((f'=================第{count}頁=================='))
        count+=1
db.close()
