def sendEmail(mail,Link):
    import smtplib
    from email.mime.text import MIMEText
    mime=MIMEText(f"[作伙]價格異動通知！\n您好! 您所關注的房屋資訊價格有異動囉! \n快來看看吧! {Link}", "plain", "utf-8") #撰寫內文內容，以及指定格式為plain，語言為中文
    mime["Subject"]="作伙zuohuo" #撰寫郵件標題
    mime["From"]="作伙zuohuo" #撰寫你的暱稱或是信箱
    # mime["To"]="j0989920076@gmail.com" #撰寫你要寄的人
    # mime["Cc"]="j0989920076@gmail.com, j098920076@gmail.com" #副本收件人
    msg=mime.as_string() #將msg將text轉成str
    smtp=smtplib.SMTP("smtp.gmail.com", 587)  #googl的ping
    smtp.ehlo() #申請身分
    smtp.starttls() #加密文件，避免私密信息被截取
    smtp.login("10836016@ntub.edu.tw", "wjwdpqozpyphrjnh") 
    from_addr="10836016@ntub.edu.tw"
    to_addr=[mail]
    status=smtp.sendmail(from_addr, to_addr, msg)
    # if status=={}:
    #     print("郵件傳送成功!")
    # else:
    #     print("郵件傳送失敗!")
    smtp.quit()

def Email(Link):
    import pymysql
    db = pymysql.connect("localhost","root","xu.61i6u;6","heroku_56d2d16ef2b2e35")
    Qcursor=db.cursor()
    select_sql = f"""SELECT us.account,sb.Link FROM `subscription` sb left join `user` us on sb.userid=us.id
    where sb.Link='{Link}'"""
    Qcursor.execute(select_sql)
    while 1:
        arr=Qcursor.fetchone()
        if not arr:
            break   
        sendEmail(arr[0],Link)

# myLink="https://rent.591.com.tw/rent-detail-10078461.html"
# Email(myLink)
