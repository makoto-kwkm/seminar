<?php

//　MySQL接続　//
require '../common/php/dbconnect.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title><?php echo $toptitle ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../common/css/style.css" rel="stylesheet" type="text/css">

<script src="../common/js/jquery-1.11.0.min.js"></script>
<script src="../common/js/function.js"></script>
<!-- suneditor -->
<link href="../common/rt/css/suneditor.css" rel="stylesheet">
<script src="../common/rt/js/suneditor.min.js"></script>
<script src="../common/rt/js/common.js"></script>
<script src="../common/rt/js/editor.js"></script>
<script src="../common/rt/lang/ja.js"></script>
<!-- codeMirror -->
<link href="../common/rt/css/codemirror.min.css" rel="stylesheet">
<script src="../common/rt/js/codemirror.min.js"></script>
<script src="../common/rt/js/htmlmixed.js"></script>
<script src="../common/rt/js/xml.js"></script>
<script src="../common/rt/js/css.js"></script>

<script>

if (window.File && window.FileReader) {
	//File API
} else {
	alert("File APIをサポートしていません");
}

window.onload = function() {
	adustTextarea();
	$("#upfile").addEventListener('change', upfile_changeHandler);
	$("#textarea").addEventListener("input", textarea_changeHandler);
	if(<?php echo isset($_GET['mode']) ?>){
		if('<?php echo $_GET["mode"] ?>' == 'view'){
			sun_disabled();
		}
	}
}

</script>

</head>

<body scroll="yes">
    <div id='wrapper'>
        <header class='subHead'><div><?php echo $toptitle ?>＜詳細＞</div></header><br />

<?php 

//　検索条件値設定：初期値＞ブランク　//
if(isset($_GET['mode'])){

	$mode = $_GET['mode'];
	
	if($_GET['mode']=='new'){
	
		$mode = $_GET['mode'];
	
	} else if($_GET['mode']=='add'){
	
		$mode = $_GET['mode'];

	} else {

		$id = $_GET['id'];
		$mode = $_GET['mode'];

		//検索条件設定　//
		$sql = "select * from ".$dbname.".MasData where id = '{$id}'";
		
	}

} else {
	$id = '';
	$mode = '';
}


//　各項目設定　//
require '../common/php/setitem.php';

?>

        <form action='details.php?mode=<?php echo $mode ?>' method='post' name='form2' id='form2' enctype="multipa../common/rt/form-data">
            <table class="menu">
                <tr>

                    <td align="right">
						<input 
							name="retbutton" 
							type="button" 
							value="閉じる"
							onClick="window.open('index.php','_self');" 
						>
					</td>
					
					<!-- item01 編集・文書更新・新規保存　ボタン -->
                    <td>
						<input 
							name='menu1' 
							type='hidden' 
							value='<?php echo $value01 ?>'
						>
					</td>
					
					<!-- item02　削除　ボタン -->
                    <td>
						<input 
							name='menu2' 
							type='hidden' 
							value='<?php echo $value02 ?>'
							onClick="location.href='details.php?mode=del&id=<?php echo $id ?>'" 
						>
						<!-- item02　「保存しました」　テキストメッセージ -->
						<?php echo $text02 ?></td>

                </tr>
            </table>
            <br />

            <table class="main">
                <tr>
                    <!-- item03 -->
					<th width="100px">タグ</th>
					<td><?php echo $seltext ?></td>
					
                    <!-- item04 -->
                   	<!-- <th width="100px">公開フラグ</th> -->
					<td></td>
					<td><?php //echo $seltext2 ?></td>
					
                    <!-- item05 -->
                    <th width="100px">作成者</th>
					<td>
						<input 
							name='creator' 
							type='<?php echo $type05 ?>' 
							value='<?php echo $value05 ?>'
						>
						<?php echo $text05 ?></td>
					
                    <!-- item06 -->
                    <th width="100px">作成日</th>
                    <td>
						<input 
							name='created' 
							type='<?php echo $type06 ?>' 
							value='<?php echo $value06 ?>' 
							readonly="readonly"
						>
						<?php echo $text06 ?></td>
                </tr>

                <tr>
                    <!-- item07 -->
                    <th>件名</th>
                    <td colspan='3'>
						<input 
							name='title' 
							type='<?php echo $type07 ?>' 
							value='<?php echo $value07 ?>'
						>
						<?php echo $text07 ?></td>
					
                    <!-- item08 -->
                    <th>更新者</th>
                    <td>
						<input 
							name='editor' 
							type='<?php echo $type08 ?>' 
							value='<?php echo $value08 ?>'
						>
						<?php echo $text08 ?></td>

                    <!-- item09 -->
                    <th>更新日</th>
                    <td><input 
							name='updated' 
							type='<?php echo $type09 ?>' 
							value='<?php echo $value09 ?>'
							readonly="readonly"
						>
                    <?php echo $text09 ?></td>
                </tr>
				<tr>				</tr>
				
                <!-- item10 -->
                <tr><th colspan='8'>本文</th></tr>
                <tr>
                    <td colspan='8'>
						<div id="classic" class="tabcontent" style="display: block;">
							<div class="inline-margin"></div>
								<textarea 
									id="textarea" 
									name='body' 
									<?php echo $value10 ?> 
								><?php echo $text10 ?></textarea>
							</div>
						</div>
					</td>
                </tr>
            </table>
        </form>
		
		<form method='post' action='details.php?mode=upload&id=<?php echo $id ?>' enctype='multipa../common/rt/form-data'>
					
			<!-- item11 -->
			<table class='main' <?php echo $type11 ?>>
                <tr>
                    <td id='infile'>
						<input type='<?php echo $type11 ?>' id='upfile' name='upfile[]' multiple>
                    </td>
					<td align='right'></td>
				</tr>
				<tr>
					<td>
						<div id='info'></div>
					</td>
					
					<!-- item12 -->
					<td align='right' valign='top'>
						<input type='<?php echo $type12 ?>' value='アップロード' style='width:100px'>
					</td>
                </tr>
			</table>
		</form>
		
		<table class='main'>
			<tr>
				<td>添付ファイル</td>
			</tr>
			<tr>
				<td>
					<table id='list'>
<?php

	$slist ='';
	
	$sql = "select * from ".$dbname.".attachments where parentid = '{$id}'";
	
	$stmt = $dbh->query($sql);
	
	foreach ($stmt as $row) {
		
		$id = $row['id'];
		$name = $row['name'];
		$type = $row['type'];
		$contents = $row['contents'];
		$size = $row['size'];
		$size = calcFileSize($size);
		$created = $row['created'];
		$parentid = $row['parentid'];
		$upurl = "'details.php?mode=remove&id=".$parentid."&fid=".$id."'";
		$dlurl = "'details.php?mode=download&id=".$parentid."&fid=".$id."'";
		
		$slist = $slist.'<tr>'."\n";
		$slist = $slist.'<td class="row">[ファイル名] '.$name.'</td>'."\n";
		$slist = $slist.'<td class="row">[サイズ] '.$size."</td>"."\n";
		$slist = $slist.'<td class="row">[最終更新日] '.$created.'</td>'."\n";
		$slist = $slist.'<td class="row" align="right">'."\n";
		$slist = $slist.'<input type="hidden" value='.$id.'>'."\n";
		// item13 ･･･ item12と同じ
		$slist = $slist.'<input type='.$type13.' value="削 除" style="width:100px" onClick="location.href='.$upurl.'">'."\n";
		// item14
		$slist = $slist.'<input type='.$type14.' value="ダウンロード" style="width:100px" onClick="location.href='.$dlurl.'">'."\n";
		$slist = $slist.'</td>'."\n";
		$slist = $slist.'</tr>'."\n";
	}
	
	echo $slist;

$dbh = null;

?>
					</table>
				</td>
			</tr>
		</table>


        <footer class="footersize">
            <div>Copyright © JMA Management Center Inc</div>
        </footer>
    </div>

<script>
	sun_create();
</script>

</body>

</html>
