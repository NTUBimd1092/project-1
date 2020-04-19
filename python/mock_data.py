import requests
from bs4 import BeautifulSoup
url="https://www.sinyi.com.tw/rent/list/1.html"
resources = requests.get(url)
soup = BeautifulSoup(resources.text, 'html.parser')
result= list()

for house in soup.select('.search_result_item'):
    page=house.find(class_="page_dot")
    print(page)   