
<?php
require_once "../common/php/dbconnect.php";

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
<?php   
    //ファイルをdataディレクトリに移動
    if (move_uploaded_file($file_tmp_name, "../data/uploaded/" . $file_name)) {
      //後で削除できるように権限を644に
      chmod("../data/uploaded/" . $file_name, 0644);
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
          $csv = str_replace('"','',$data);
          //インサート
          $sql = "INSERT INTO preafter 
                 (ExamiNumber,PreAftKbn,AnswerDate,Name,Company,Answer1,Answer2,
                  Answer3,Answer4,Answer5,Answer6,Answer7,Answer8,Answer9)
                  VALUES
                 (:ExamiNumber,:PreAftKbn,:AnswerDate,:Name,:Company,:Answer1,:Answer2,
                  :Answer3,:Answer4,:Answer5,:Answer6,:Answer7,:Answer8,:Answer9)";
          var_dump($sql);
//	var_dump($stmt);

          $stmt = $dbh->prepare($sql);
          $stmt->bindParam(':ExamiNumber', $csv[0], PDO::PARAM_STR);
          $stmt->bindParam(':PreAftKbn', $csv[1], PDO::PARAM_STR);
          $stmt->bindParam(':AnswerDate', $csv[2], PDO::PARAM_STR);
          $stmt->bindParam(':Name', $csv[3], PDO::PARAM_STR);
          $stmt->bindParam(':Company', $csv[4], PDO::PARAM_STR);
          $stmt->bindParam(':Answer1', $csv[5], PDO::PARAM_STR);
          $stmt->bindParam(':Answer2', $csv[6], PDO::PARAM_STR);
          $stmt->bindParam(':Answer3', $csv[7], PDO::PARAM_STR);
          $stmt->bindParam(':Answer4', $csv[8], PDO::PARAM_STR);
          $stmt->bindParam(':Answer5', $csv[9], PDO::PARAM_STR);
          $stmt->bindParam(':Answer6', $csv[10], PDO::PARAM_STR);
          $stmt->bindParam(':Answer7', $csv[11], PDO::PARAM_STR);
          $stmt->bindParam(':Answer8', $csv[12], PDO::PARAM_STR);
          $stmt->bindParam(':Answer9', $csv[13], PDO::PARAM_STR);
          $stmt->execute();
        }
        $row++;
      }
      echo "csvファイルを取込ました。";
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
?>
    <button type="button" onclick="history.back()">戻る</button>
  </form>
</body>
</html>
