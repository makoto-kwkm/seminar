
<?php

if (is_uploaded_file($_FILES["csvfile"]["tmp_name"])) {
  $file_tmp_name = $_FILES["csvfile"]["tmp_name"];
  $file_name = $_FILES["csvfile"]["name"];
  //拡張子を判定
  if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
    echo  "CSVファイルのみ対応しています。";
  } else {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>チームワーキング</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="../common/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <form method="POST" action="insert_pocess.php">
    <div>CSVデータ</div>
      <table class="main">
        <tr>
          <th>番号</th><th>preAft</th><th>回答日</th>
          <th>名前</th><th>会社</th>
          <th>回答１</th><th>回答２</th><th>回答３</th>
          <th>回答４</th><th>回答５</th><th>回答６</th>
          <th>回答７</th><th>回答８</th><th>回答９</th>
        </tr>
<?php   
    //ファイルをdataディレクトリに移動
    if (move_uploaded_file($file_tmp_name, "../data/uploaded/" . $file_name)) {
      //後で削除できるように権限を644に
      chmod("../data/uploaded/" . $file_name, 0644);
//      echo $file_name . "をアップロードしました。";
      //ファイルを取得
      $file = file_get_contents('../data/uploaded/'.$file_name);
      //エンコード：sjis⇒utf-8
      $file = mb_convert_encoding($file,'UTF-8','sjis-win');
      $tmp = tmpfile();
      
      fwrite($tmp,$file);
      rewind($tmp);
      $row=0;
      //CSVファイルを１レコード毎に出力する
      while (($data = fgetcsv($tmp, 0, ",")) !== FALSE) {
        if($row>0){
          print "<tr>";
          foreach ($data as $value) {
            print "<td name=\"value[]\">$value</td>";
          }
          print "</tr>\n";
         }
         $row ++;
      }
?>
    </table>
    <input type="submit" name="entry" value="登録">
  </form>
</body>
</html>
<?php
      fclose($tmp);
      //ファイルの削除
      unlink('../data/uploaded/'.$file_name);
    } else {
      echo "ファイルをアップロードできません。";
    }
  }
} else {
  echo "ファイルが選択されていません。";
}
