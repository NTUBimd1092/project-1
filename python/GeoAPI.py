import requests
import urllib
import json
import time
import pymysql

def get_latitude_longtitude(address):
    # decode url
    address = urllib.parse.quote(address)
    url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + address+"&key=AIzaSyAzA3f6KHEpViCBcLFSWS3a2ywVr3fCIvY"
    while True:
        res = requests.get(url)
        js = json.loads(res.text)

        if js["status"] != "OVER_QUERY_LIMIT":
            time.sleep(1)
            break
    result = js["results"][0]["geometry"]["location"]
    lat = result["lat"]
    lng = result["lng"]

    return lat, lng

db = pymysql.connect("localhost","root","1234","crawler", charset='utf8')
Qcursor = db.cursor()
Icursor=db.cursor()
Ccursor=db.cursor()
print('開始定位!\n')
try:
    select_sql = """SELECT id,adress FROM `page_data` where `Is_Delete`='N'"""
    Qcursor.execute(select_sql)
    i=0
    while i<=20:
        arr=Qcursor.fetchone()
        print(f'編號：{arr[0]},地址：{arr[1]}')
        check_sql=f"""SELECT COUNT( `houseid` )AS A FROM `localtion`WHERE `houseid` = {arr[0]} """
        Ccursor.execute(check_sql)
        count=Ccursor.fetchone()
        if count[0]==0:    
            address=arr[1]
            lat, lng = get_latitude_longtitude(address)
            print(f'新增經緯度：{lat},{lng}\n====================================\n')
            try:
                sqlinsert = ("INSERT INTO localtion(houseid,lat,lng)" "VALUES(%s,%s,%s)")
                val = [arr[0],lat,lng]
                Icursor.execute(sqlinsert,val)
                db.commit()
            except:
                print('新增經位度失敗\n====================================\n')
        else:
            print('已定位\n====================================\n')
        time.sleep(1)
        i+=1
        if not arr:
            break
except:
    print("Select is failed")

db.close()

