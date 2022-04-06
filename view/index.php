<?php
//　検索条件値設定：初期値＞ブランク
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$word = $_POST['search'];
	$selitem = $_POST['seltext'];
} else {
	$word = '';
	$selitem = '';
}

//var_dump("REQUEST_METHOD=".$_SERVER['REQUEST_METHOD'] );
//var_dump("*****search=".$_POST['search']);
//var_dump("*****seltext=".$_POST['seltext']);

//　MySQL接続　//
require_once '../common/php/dbconnect.php';

if($flag != 'err'){
	$sql = 'SELECT AnswerDate FROM preafter group by AnswerDate order by AnswerDate';
	$stmt = $dbh->query($sql);
	$seltext = '<option value=""></option>'."\n";
	
	foreach ($stmt as $row) {
		if($row['AnswerDate'] != ''){
			if($row['AnswerDate'] == $selitem){
				$seltext = $seltext.'<option value='.$row['AnswerDate'].' selected>'.$row['AnswerDate'].'</option>'."\n";
			} else {
				$seltext = $seltext.'<option value='.$row['AnswerDate'].'>'.$row['AnswerDate'].'</option>'."\n";
			}
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>チームワーキング</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="../common/css/style.css" rel="stylesheet" type="text/css">
</head>

<script>

var tableToCSV = {
  export: function(elm /*, delimiter */) {
    var table = elm;
    var rows  = this.getRows(table);
    var lines = [];
    var delimiter = delimiter || ',';

    for (var i = 0, numOfRows = rows.length; i < numOfRows; i++) {
      var cols    = this.getCols(rows[i]);
      var line = [];

      for (var j = 0, numOfCols = cols.length; j < numOfCols; j++) {
          var text = cols[j].textContent || cols[j].innerText;
          text = '"'+text.replace(/"/g, '""')+'"';
          line.push(text);
      }
      lines.push(line.join(delimiter));
    }
    this.saveAsFile(lines.join("\r\n"));
  },

  saveAsFile: function(csv) {
    var blob = new Blob([csv], {type: 'text/csv'});
    var url  = URL.createObjectURL(blob);
    var a = document.createElement("a");
    a.href = url;
    a.target = '_blank';
    a.download = 'table.csv';
    a.click();
  },
  getRows: function(elm){
    return Util.getNodesByName(elm, 'tr');
  },
  getCols: function(elm){
    return Util.getNodesByName(elm, ['td', 'th']);
  }
}

var Util = {
  getNodesByName: function(elm /*, string or array*/) {
    var children  = elm.childNodes;
    var nodeNames = ('string' === typeof arguments[1]) ? [arguments[1]] : arguments[1] ;
    nodeNames = nodeNames.map(function(str){ return str.toLowerCase() });

    var results  = [];
    for (var i = 0, max = children.length; i < max; i++ ) {
      if (nodeNames.indexOf(children[i].nodeName.toLowerCase()) !== -1)
      {
         results.push(children[i]);
      }
      else
      {
         results = results.concat(this.getNodesByName(children[i], nodeNames));
      }
    }
    return results;
  }
}

window.onload = function(){
	document.getElementById('download').addEventListener('click', function (e){
		e.preventDefault(); tableToCSV.export(document.getElementById('tbl')); 
	});
}

</script>

<body>
	<div id='wrapper'>
		<header class='mainHead'><div>チームワーキング</div></header>
		<br />
		<!-- csvアップロード -->
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<div>CSVファイル</div>
			<input type="file" name="csvfile" size="30" />
			<input type="submit" value="アップロード" />
		</form>
		</br>
		<hr class="layout-separete" width="100%">

		<!-- 検索条件 -->
		<form action="index.php" method="post" name="form1" id="form1">
			<div>日付</div>
			<select name="seltext" style="font-size: 14px;height: 25px;border-style: solid;border-color: #CCCCCC;">
				<?php echo $seltext ?>
			</select>
			<div>会社名</div>
			<input type="text" name="search" id="search" value="<?php echo $word ?>">
			<input type="submit" name="menu1" value="検索">

			<input type="submit" name="csvdl" value="CSVダウンロード" id="download">
			<table class="main" id="tbl">
				<tr>
					<th>対象</th>
					<th>番号</th><th>preAft</th><th>回答日</th>
					<th>名前</th><th>会社</th>
					<th>回答１</th><th>回答２</th><th>回答３</th>
					<th>回答４</th><th>回答５</th><th>回答６</th>
					<th>回答７</th><th>回答８</th><th>回答９</th>
				</tr>
<?php

if($word != 'error'){
	//検索ワード入力時
	if($word!=''){
	
		$word = str_replace('　', ' ', $word);
		$arrword = explode(' ', $word);
		$sql="select * from preafter where 1=1";
		$i=0;

		foreach ($arrword as $sword) {
			$sql .= " and ";
			$sql .= " Company like '%".$sword."%'";
		}
		//リスト選択時
		if($selitem != ''){
			$sql = $sql." and AnswerDate = '".$selitem."'";
		}
	} else {
		//リスト選択時
		if($selitem != ""){
			$sql = "select * from preafter where 1=1 and AnswerDate = '".$selitem."'";
		} else {
			$sql = "select * from preafter where 1=1";
		}
	}
	$sql = $sql." ORDER BY ExamiNumber,PreAftKbn";

	$stmt = $dbh->query($sql);

//	var_dump($stmt);

	foreach ($stmt as $row) {
		$rowtext = "<a href='details.php?mode=view&id={$row['ExamiNumber']}' target='_self'>";
	
		print('<tr>'."\n");
		print("	<td><input type='checkbox' name[]='Target'></td>");
		print("	<td>{$rowtext}{$row['ExamiNumber']}</a></td>\n");
		print("	<td>{$row['PreAftKbn']}</a></td>\n");
		print("	<td>{$row['AnswerDate']}</a></td>\n");
		print("	<td>{$row['Name']}</a></td>\n");
		print("	<td>{$row['Company']}</a></td>\n");
		print("	<td>{$row['Answer1']}</a></td>\n");
		print("	<td>{$row['Answer2']}</a></td>\n");
		print("	<td>{$row['Answer3']}</a></td>\n");
		print("	<td>{$row['Answer4']}</a></td>\n");
		print("	<td>{$row['Answer5']}</a></td>\n");
		print("	<td>{$row['Answer6']}</a></td>\n");
		print("	<td>{$row['Answer7']}</a></td>\n");
		print("	<td>{$row['Answer8']}</a></td>\n");
		print("	<td>{$row['Answer9']}</a></td>\n");
		print('</tr>'."\n");
	}
}
$dbh = null;
?>

			</table>
		</form>

		<footer class="footersize"><div>Copyright © JMA Management Center Inc</div></footer>
	</div>
</body>
</html>
