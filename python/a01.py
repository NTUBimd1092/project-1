import requests # 导入网页请求库
from bs4 import BeautifulSoup # 导入网页解析库
import re
import json

class Stack(object):

    def __init__(self):
        self.baseurl = 'https://stackoverflow.com' # 用于与抓取的url拼接
        self.starturl = 'https://stackoverflow.com/questions/tagged/python' # 初始url
    
    def start_requests(self, url): # 发起请求
        r = requests.get(url)
        return r.content

    def parse(self, text): # 解析网页
        soup = BeautifulSoup(text, 'html.parser')
        divs = soup.find_all('div', class_ = 'question-summary')
        for div in divs:

            # 一些中间变量
            gold = div.find('span', title = re.compile('gold'))
            silver = div.find('span', title = re.compile('silver'))
            bronze = div.find('span', title = re.compile('bronze'))
            tags = div.find('div', class_ = 'summary').find_all('div')[1].find_all('a')

            # 用生成器输出字典
            yield {
            # 这部分每一条都有代表性
            'title': div.h3.a.text,
            'url': self.baseurl + div.h3.a.get('href'),
            'answer': div.find('div', class_ = re.compile('status')).strong.text,
            'view': div.find('div', class_ = 'views ').text[: -7].strip(),
            'gold': gold.find('span', class_ = 'badgecount').text if gold else 0,
            'tagnames': [tag.text for tag in tags],

            # 下面的从知识的角度上讲都和上面一样
            'vote': div.find('span', class_ = 'vote-count-post ').strong.text,
            'time': div.find('div', class_ = 'user-action-time').span.get('title'),
            'duration': div.find('div', class_ = 'user-action-time').span.text,
            'username': div.find('div', class_ = 'user-details').a.text,
            'userurl': self.baseurl + div.find('div', class_ = 'user-gravatar32').a.get('href'),
            'reputation': div.find('span', class_ = 'reputation-score').text,
            'silver': silver.find('span', class_ = 'badgecount').text if silver else 0,
            'bronze': bronze.find('span', class_ = 'badgecount').text if bronze else 0,
            'tagurls': [self.baseurl + tag.get('href') for tag in tags]
            }

    # 启动爬虫
    def start(self):
        text = self.start_requests(self.starturl)
        items = self.parse(text)
        s = json.dumps(list(items), indent = 4, ensure_ascii=False)
        with open('stackoverflow.json', 'w', encoding = 'utf-8') as f:
            f.write(s)

stack = Stack()
stack.start()