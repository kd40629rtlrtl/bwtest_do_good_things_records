function doGet(e) {
  Logger.log(e);
  var params = e.parameter;
  var timestamp = params.timestamp;//
  
  //var timestamp = e;  //配合 function test()
  Logger.log(timestamp);

  var Sheet = SpreadsheetApp.openById("1bjKz28t4W1cja-ENjLcpCKXONRdUEbJSYW5szS6OvJ8");

  var LastRow = Sheet.getLastRow();
  var LastColumn = Sheet.getLastColumn();
  
  var data = [];//用來存資料

  // 取得全部資料
  var listAll = Sheet.getSheetValues(1, 1, LastRow, LastColumn);

  //存標題
  data.push({dataload: listAll[0]})  //第1列是標題,序號由0開始，設定JSON格式{dataload: listAll[0]}

  //for(var i = 1; i < listAll.length; i++){ //第2列才是資料,序號由0開始
  for(var i = listAll.length-1; i >= 1; i--){ //第2列才是資料,序號由0開始
      const google_sheet_timestamp = new Date(listAll[i][0]).getTime();
      if(parseInt(google_sheet_timestamp,10)-parseInt(timestamp,10) > 1000){ //電子信箱在第2欄,序號由0開始
        console.log(google_sheet_timestamp);
        data.push({dataload: listAll[i]}); //寫入資料
      }
      else break;
  }
        
  //顯示資料
    Logger.log(data);
  //將資料存成JSON格式並回傳  
  return ContentService.createTextOutput(JSON.stringify(data)).setMimeType(ContentService.MimeType.JSON); 
  
}

function test() {
  doGet('trico109748007@gmail.com.tw');
}