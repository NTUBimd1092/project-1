def sendEmail(mail, Link):
    import smtplib
    from email.mime.text import MIMEText
    # 撰寫內文內容，以及指定格式為plain，語言為中文
    mime = MIMEText(
        f"[作伙]價格異動通知！\n您好! 您所關注的房屋資訊價格有異動囉! \n快來看看吧! {Link}", "plain", "utf-8")
    mime["Subject"] = "作伙zuohuo"  # 撰寫郵件標題
    mime["From"] = "作伙zuohuo"  # 撰寫你的暱稱或是信箱
    msg = mime.as_string()  # 將msg將text轉成str
    smtp = smtplib.SMTP("smtp.gmail.com", 587)  # googl的ping
    smtp.ehlo()  # 申請身分
    smtp.starttls()  # 加密文件，避免私密信息被截取
    # smtp.login("10836016@ntub.edu.tw", "wjwdpqozpyphrjnh")
    smtp.login("zuohuo109202@gmail.com", "xu.61i6u;6")
    # from_addr="10836016@ntub.edu.tw"
    from_addr = ["zuohuo109202@gmail.com"]
    to_addr = [mail]
    status = smtp.sendmail(from_addr, to_addr, msg)
    smtp.quit()


def Email(Link):
    import pymysql
    # db = pymysql.connect("us-cdbr-east-02.cleardb.com","badaadfc741319","fd67aae8","heroku_64a98996a6e263e", charset='utf8')
    db = pymysql.connect("localhost", "root", "xu.61i6u;6",
                         "heroku_56d2d16ef2b2e35")
    Qcursor = db.cursor()
    select_sql = f"""SELECT us.account,sb.Link FROM `subscription` sb left join `user` us on sb.userid=us.id
    where sb.Link='{Link}'"""
    Qcursor.execute(select_sql)
    print("寄信中...")
    while 1:
        arr = Qcursor.fetchone()
        if not arr:
            print("寄信完成!")
            break
        import re
        rule = '^[a-z0-9]+[\._]?[a-z0-9]+[@]\w+[.]\w{2,3}$'
        if(re.search(rule,arr[0])):  
            sendEmail(arr[0], Link)

myLink = "https://rent.591.com.tw/rent-detail-10078461.html"
Email(myLink)
