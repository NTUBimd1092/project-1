#KEARNEY
import urllib.request as req
url="https://www.kearney.com/"
request=req.Request(url, headers={
    "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36"
})
with req.urlopen(url) as response:
    data=response.read().decode("utf-8")
print(data)