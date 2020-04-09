import requests
from bs4 import BeautifulSoup
def getData(url):
    res= requests.get(url)
    soup=BeautifulSoup(res.text,'html.parser')#原始碼
    adress=soup.find_all(class_="num num-text")#地址
    print("地址============================")
    for adres in adress:
        if soup.find(class_="num num-text") !=None:
            print(adres.string)
    print("房屋名稱============================")
    house=soup.find_all("span", class_="item_title")#房屋名稱
    for name in house:
        if soup.find("span", class_="item_title")!=None:
            print(name.string)       
    print("房屋網址============================")
    result= set()#房屋網址
    for link in soup.select('.search_result_item'):
        result.add('https://www.sinyi.com.tw/rent/'+link.select_one('a')['href'])      
    result = list(result)
    for i ,result in enumerate(result):
        print(result)
        
count=1
while count<=2:
    pageURL="https://www.sinyi.com.tw/rent/list/"+str(count)+".html"
    print("==========================================")
    print(pageURL)
    pageURL=getData(pageURL)
    count+=1
