# PHP的檔案處理

除了一般的文字輸入，我們也常會透過上傳檔案的方式來提供使用者和網站的互動，PHP本身有豐富的檔案相關應用，最普遍的是利用表單來提供上傳的功能，然後再對上傳的檔案進行處理及應用。

## 表單檔案上傳

最基本的應用是建立一個表單來提供上傳的功能，在HTML的表單中，有提供了一個file的類別來專門處理二進位檔案，由於是二進位檔案，因此需要特別處理才能在網路中傳輸，所以我們要在表單中加入enctype的屬性，並指明要編碼的種類：

```html
<!--其中的multipart/form-data
    就是指明採用二進位的方式直接傳送表單的欄位內容-->
<form action="file.php" method="post" enctype="multipart/form-data">
  檔案：<input type="file" name="img" ><br>
  檔案說明：<input type="text" name="imgdesc"><br>
  <input type="submit" value="上傳">
</form>
```
按下上傳後，針對二進位的資料內容，會先被放到伺服器中的暫存目錄中存放，然後檔案的相關資訊會被收集起來存放在$_FILES['表單欄位名稱']中，然後file.php會收到$_FILES及$_POST或$_GET的資料，接下來就看程式碼的部份要怎麼處理這些資料了。

容易被忽略的地方在於，上傳的動作和表單的資料是兩件不同的事，即使php端的程式有錯而沒有收到$_FILES或$_POST的資料，但上傳的動作可能還是正常完成，檔案已經被放到暫存區了。

或是刪除了伺服器上的檔案，但是忘了去同步處理$_FILES或是資料表中的紀錄，這樣也會造成資訊不同步的狀況。

## 檔案的管理

前面提到檔案上傳後會先放在暫存區中，並且會由伺服器給予一組亂碼的檔名，而檔案的相關資訊則會存在PHP的全域變數$_FILES中。

而檔案的管理就是根據$_FILES中提供的資訊，來決定我們要對檔案做什麼樣的處理，其中$_FILES提供了以下的資訊：
```php
- $_FILES['field_name']['name'] => 上傳檔案的原始名稱
- $_FILES['field_name']['type'] => 上傳檔案的檔案類型
- $_FILES['field_name']['size'] => 上傳的檔案原始大小
- $_FILES['field_name']['tmp_name'] => 上傳檔案後的暫存資料夾位置
- $_FILES['field_name']['error'] => 顯示錯誤代碼
```
### 錯誤代碼(err code):

|code|status|descrption|
|---|----|----|
|0|UPLOAD_ERR_OK|上傳正常，且完成上傳|
|1|UPLOAD_ERR_INI_SIZE|上傳失敗，檔案size超過php.ini裡所設定的可上傳(upload_max_filesize)大小|
|2|UPLOAD_ERR_FORM_SIZE|上傳失敗，檔案size超過php.ini裡所設定的可接受檔案(MAX_FILE)SIZE)大小|
|3|UPLOAD_ERR_PARTIAL|上傳失敗，僅有部份檔案上傳完成|
|5|UPLOAD_ERR_NO_FILE|上傳失敗，因為沒有檔案上傳|
|6|UPLOAD_ERR_NO_TMP_DIR|上傳失敗，因為找不到tmp資料夾|
|7|UPLOAD_ERR_CANT_WRITE|要將檔案寫入磁碟時失敗|
|8|UPLOAD_ERR_EXTENSION|某些擴充模組影響了上傳功能造成上傳失敗|

通常我們會先建立一些相關的目錄來存放這些檔案，在判斷檔案上傳成功並且已經存放在暫存目錄後，我們會把檔案搬移到指定的目錄下方便日後的控管。

在搬移檔案前，我們也會先決定檔案的檔名是要使用上傳時的原檔名，還是由程式來決定一個新檔名：
```php
if(!empty($_FILES['file']['tmp_name'])){
    $filename=md5(time())  //利用時間及md5編碼來產生一個檔名
    switch($_FILES['file']['type']){
        case "image/jpeg":
            $subname=".jpg";
        break;
        case "image/png":
            $subname=".png";
        break;
        case "image/gif":
            $subname=".gif";
        break;
    }

    //利用move_upload_file函式將檔案搬移到指定目錄下，並指定檔名
    move_upload_file($_FILES['file']['tmp_name'] , "./img/" . $filename . $subname);
}
```
進一步的可以把檔案的資訊寫入資料庫來進行管理。

---

## 檔案的判斷

在進行對檔案的進一步處理時，我們需要先對檔案的狀況進行判斷，以確認要處理的資源符合需要：

|函式|功能|回傳值|
|---|---|---|
|is_dir()|判斷是否為目錄|true/false|
|is_file()|判斷是否為檔案|true/false|
|is_executable()|判斷是否為可執行檔案|true/false|
|is_readable()|判斷檔案權限是否為可讀|true/false|
|is_writeable()|判斷檔案權是否為可寫入|true/false|

---

## 文字檔案處理

如果上傳的是純文字的檔案，並且打算將檔案內容匯入資料庫或另作處理時，需要透過一些檔案專用的指令來取得內容並加以處理：

|函式|功能|回傳值|
|---|---|---|
|fopen()|開啟一個檔案|資源|
|feof()|判斷檔案結尾|true/false|
|fwrite()|寫入內容|int|
|fclose()|關閉檔案|true/false|
|fgetc()|取得一個字元內容|string|
|fgets()|取得一行內容|string|
|fgetcsv()|取得csv檔案一行內容|array|
|file()|讀入整個檔案，並以行為單位存入陣列|array|
|fread()|以二進位方式讀入檔案字元|string|
|filesize()|取得檔案大小|int|

---

## 圖形檔案處理

如果上傳的是網頁用的圖形類檔案，則可以進行額外的圖形處理，比如製作縮圖，加邊框等等：

|函式|功能|回傳值|
|---|---|---|
|imagecreatefrompng()|從圖片檔產生新的圖片資源|resource|
|imagecreatefromjpeg()|從圖片檔產生新的圖片資源|resource|
|imagecreatefromgif()|從圖片檔產生新的圖片資源|resource|
|imagecreatetruecolor()|建立一個全彩的圖片資源|resource|
|imagecopyresampled()|複製並重新取樣圖片，可調整大小(縮放)|true/false|
|imagejpeg()|輸出jpge檔|true/false|
|imagepng()|輸出png檔|true/false|
|imagegif()|輸出gif檔|true/false|
|imagedestroy()|刪除一個圖形資源|true/false|
|imagettfbbox()|計算truetype字形的寬高|array|
|imagettftext()|在圖片中寫入truetype字元|array|
|imagefill()|填入顏色|true/false|
|imagecolorallocate()|定義一個顏色|int|
|imagesetpixel()|畫一個點|true/false|
|imageline()|畫一條線|true/false|
