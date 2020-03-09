#思科智慧
import urllib.request as req
url="https://www.cisco.com/c/zh_tw/solutions/internet-of-things/smartcity.html?CONTENT=default&CCID=cc001285&DTID=odicdc000612&POSITION=Wide+Tile&CREATIVE=smart+city&COUNTRY_SITE=TW&REFERRING_SITE=CISCO.COM+HOMEPAGE"
request=req.Request(url, headers={
    "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36"
})
with req.urlopen(url) as response:
    data=response.read().decode("utf-8")
print(data)

