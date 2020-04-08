import requests
from bs4 import BeautifulSoup
url="https://www.sinyi.com.tw/rent/"
res= requests.get(url)
soup=BeautifulSoup(res.text,'html.parser')
result= set()
for link in soup.select('.search_result_item'):
    result.add('https://www.sinyi.com.tw/rent/'+link.select_one('a')['href'])
result = list(result)
for i ,result in enumerate(result):
    print(i,'-->',result) 

