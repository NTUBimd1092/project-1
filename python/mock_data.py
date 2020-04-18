import requests
from bs4 import BeautifulSoup
url='https://www.sinyi.com.tw/rent/list/1.html'
allpage= BeautifulSoup(url.text,'html.parser')
allpage.select('.page')
final=allpage.find("li",class_="page")