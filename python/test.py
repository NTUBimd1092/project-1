import requests
from bs4 import BeautifulSoup
url="https://www.accenture.cn/cn-zh/insights/technology/technology-trends-2020"
res= requests.get(url)
soup=BeautifulSoup(res.text,'html.parser')
result= set()
for link in soup.select('.download-report'):
    result.add(link.select_one('a')['href'])
result = list(result)
print(result)