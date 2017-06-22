<!DOCTYPE html>
<html>
<body>

<form  method="GET" action="{{ 'submit' }}"  >
  出租方:<br>
  <input type="text" name="name1" value="Mickey">
  <br>
  承租方:<br>
  <input type="text" name="name2" value="Mouse">
  <br>
  Term 1:<br>
 <input type="text" name="term1" value="(一）甲方保证上述房屋：已依法取得房屋所有权证书或相关产权证明文件；权属明晰，无产权争议；不在建设拆迁公告范围内；能保证安全居住、使用；有关法律、法规未限制出租。 其它：已取得其他共有人书面同意；已经抵押权人同意；如系托管的房屋，已经托管的房屋所有权人委托出租。 如甲方上述保证不实，由此给乙方造成的损失，由甲方负责赔偿。">
 <br>
  Term 2:<br>
  <input type="text" name="term2" value="(二）甲方负责对房屋及其附属设施定期检查并承担正常的房屋维修费用。如因延期修缮致使乙方遭受损失，甲方负责赔偿。（本条双方另有约定的除外）。">
  <br>
  Term 2:<br>
  <input type="text" name="name3" value="(二）甲方负责对房屋及其附属设施定期检查并承担正常的房屋维修费用。如因延期修缮致使乙方遭受损失，甲方负责赔偿。（本条双方另有约定的除外）。">
  <br>

  <br><br>
  <input type="submit" value="Submit">
</form> 

<p>If you click the "Submit" button, the form-data will be sent to a PDFController</p>

</body>

</html>

