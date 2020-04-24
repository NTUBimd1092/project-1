import requests
from bs4 import BeautifulSoup
url="https://www.sinyi.com.tw/rent/list/1.html"
resources = requests.get(url)
soup = BeautifulSoup(resources.text, 'html.parser')
result= list()
i=0
for house in soup.select('.search_result_item'):
    page=house.find("div",class_="detail_line2")
    Ineed=page.find_all("span",class_="num")
    string=[]
    i+=1
    for x in Ineed:
        string.append(str(x.string))
    print(f'#{i}:')
    print(string[0])
    print(string[1])
    print(string[2]+string[3])
    print(string[3])
    print(string[4])
    print(string[5])
    print(string[6])
    print(f'樓層:{x.string}')
    #print(Ineed.split(","))   