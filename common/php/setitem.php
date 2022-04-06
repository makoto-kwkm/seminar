<?php

/////////////////////////////////　既存文書参照・更新　添付ファイル削除・ダウンロード　/////////////////////////////////

if($mode == 'view'|| $mode == 'edit'|| $mode == 'remove'|| $mode == 'download'){

	$id = $_GET['id'];
	
	$sql = "select * from ".$dbname.".masdata where id = '{$id}'";
	$stmt = $dbh->query($sql);
	
	foreach ($stmt as $row) {
	
		$category_1 = $row['category_1'];
		$openflag = $row['openflag'];
		$creator = $row['creator'];
		$created = $row['created'];
		$title = $row['title'];
		$editor = $row['editor'];
		$updated = $row['updated'];
		$body = str_replace('<br />', '', $row['body']);
		
		//　既存文書参照・添付ファイルダウンロード　
		if($mode =='view'|| $mode == 'download'){
				
			$seltext = $category_1."\n";
			$seltext2 = $openflag."\n";
			
			//　編集・文書更新・新規保存　ボタン
			$type01 = '';
			$value01 = '編集';
			$text01 = '';
			//　削除　ボタン
			$type02 = 'button';
			$value02 = '削除';
			$text02 = '';
			//　タグ（カテゴリ）
			$type03 = '';
			$value03 = '';
			$text03 = '';
			//　公開フラグ
			$type04 = 'hidden';
			$value04 = $openflag; 
			$text04 = $openflag;
			//　作成者
			$type05 = 'hidden';
			$value05 = $creator;
			$text05 = $creator;
			//　作成日
			$type06 = 'hidden';
			$value06 = $created;
			$text06 = $created;
			//　件名
			$type07 = 'hidden';
			$value07 = $title; 
			$text07 = $title;
			//　更新者
			$type08 = 'hidden';
			$value08 = $editor;
			$text08 = $editor;
			//　更新日
			$type09 = 'hidden';
			$value09 = $updated;
			$text09 = $updated;
			//　本文
			$type10 = '';
			$value10 = "style='border:none;' readonly";
			$text10 = $body;
			//　添付ファイル一覧
			$type11 = 'hidden';
			$value11 = '';
			$text11 = '';
			//　アップロード　ボタン
			$type12 = 'hidden'; 
			$value12 = '';
			$text12 = '';
			//　アップ済み添付ファイル　削除　ボタン
			$type13 = 'hidden';
			$value13 = '';
			$text13 = '';
			//　アップ済み添付ファイル　ダウンロード　ボタン
			$type14 = 'submit';
			$value14 = '';
			$text14 = '';
			
			//　添付ファイルダウンロード処理
			if($mode == 'download'){
				
				$fid = $_GET['fid'];

				$sql = "select * from ".$dbname.".attachments where id = '{$fid}'";
				$stmt = $dbh->query($sql);
				
				foreach ($stmt as $row) {
					
					$name = $row['name'];
					$type = $row['type'];
					$size = $row['size'];
					$created = $row['created'];
					$parentid = $row['parentid'];
					$contents = $row['contents'];
					
					header('Content-Length:'.$size);
					header('Content-type: '.$type);
					header("Content-Disposition: attachment; filename={$name}");
					ob_end_clean();
					echo $row['contents'];

					$size = calcFileSize($size);

					exit();
					
				}
			}

			$mode = 'edit&id='.$id;

		//　既存文書更新・添付ファイル削除　
		} else if($mode == 'edit'|| $mode == 'remove'){
		
			if(isset($_COOKIE['UNAME'])){
				$editor = $_COOKIE['UNAME'];
			} else {
				$editor = '';
			}
			
			$seltext = SetSelText($dbh,$category_1,$dbname);
			$seltext2 = SetSelText2($openflag);

			//　編集・文書更新・新規保存　ボタン
			$type01 = '';
			$value01 = '文書更新';
			$text01 = '';
			//　削除　ボタン
			$type02 = 'hidden';
			$value02 = '';
			$text02 = '';
			//　タグ（カテゴリ）
			$type03 = '';
			$value03 = '';
			$text03 = '';
			//　公開フラグ
			$type04 = 'text';
			$value04 = $openflag; 
			$text04 = '';
			//　作成者
			$type05 = 'text';
			$value05 = $creator;
			$text05 = '';
			//　作成日
			$type06 = 'text';
			$value06 = $created;
			$text06 = '';
			//　件名
			$type07 = 'text';
			$value07 = $title; 
			$text07 = '';
			//　更新者
			$type08 = 'text';
			$value08 = $editor;
			$text08 = '';
			//　更新日
			$type09 = 'text';
			$value09 = $updated;
			$text09 = '';
			//　本文
			$type10 = '';
			$value10 = '';
			$text10 = $body;
			//　添付ファイル一覧
			$type11 = 'file';
			$value11 = '';
			$text11 = '';
			//　アップロード　ボタン
			$type12 = 'submit'; 
			$value12 = '';
			$text12 = '';
			//　アップ済み添付ファイル　削除　ボタン
			$type13 = 'button';
			$value13 = '';
			$text13 = '';
			//　アップ済み添付ファイル　ダウンロード　ボタン
			$type14 = 'hidden';
			$value14 = '';
			$text14 = '';
			
			if($mode == 'remove'){

				$fid = $_GET['fid'];

				$sql = "delete from ".$dbname.".attachments where id = :id";
				$stmt = $dbh->prepare($sql);
				
				$params = array(':id' => $fid);
				$stmt->execute($params);
			}
			
			$mode = 'update&id='.$id;
			
		}
	}
	
	
/////////////////////////////////　新規文書登録・更新画面　/////////////////////////////////

} else if($mode == 'add' || $mode == 'update'){

	$id = '';
	$category_1 = $_POST['category_1'];
	$openflag = $_POST['openflag'];
	$creator = $_POST['creator'];
	$created = $_POST['created'];
	$title = $_POST['title'];
	$editor = '';
	$updated = '';
	$body = $_POST['body'];

	$seltext = SetSelText($dbh,$category_1,$dbname);
	$seltext2 = SetSelText2($openflag);
	
	//　編集・文書更新・新規保存　ボタン
	$type01 = '';
	$value01 = '文書更新';
	$text01 = '';
	//　削除　ボタン
	$type02 = 'hidden';
	$value02 = '';
	$text02 = '　保存しました';
	//　タグ（カテゴリ）
	$type03 = '';
	$value03 = '';
	$text03 = '';
	//　公開フラグ
	$type04 = 'text';
	$value04 = $openflag; 
	$text04 = '';
	//　作成者
	$type05 = 'text';
	$value05 = $creator;
	$text05 = '';
	//　作成日
	$type06 = 'text';
	$value06 = $created;
	$text06 = '';
	//　件名
	$type07 = 'text';
	$value07 = $title; 
	$text07 = '';
	//　更新者
	$type08 = 'text';
	$value08 = $editor;
	$text08 = '';
	//　更新日
	$type09 = 'text';
	$value09 = $updated;
	$text09 = '';
	//　本文
	$type10 = '';
	$value10 = '';
	$text10 = $body;
	//　添付ファイル一覧
	$type11 = 'file';
	$value11 = '';
	$text11 = '';
	//　アップロード　ボタン
	$type12 = 'submit'; 
	$value12 = '';
	$text12 = '';
	//　アップ済み添付ファイル　削除　ボタン
	$type13 = 'button';
	$value13 = '';
	$text13 = '';
	//　アップ済み添付ファイル　ダウンロード　ボタン
	$type14 = 'hidden';
	$value14 = '';
	$text14 = '';

	if($mode == 'add'){
		
		$sql = "insert into ".$dbname.".masdata (title,body,category_1,creator,created,openflag) values (:title,:body,:category_1,:creator,:created,:openflag)";
		$stmt = $dbh -> prepare($sql);
		
		$stmt->bindParam(':title', $title, PDO::PARAM_STR);
		$stmt->bindParam(':body', $body, PDO::PARAM_STR);
		$stmt->bindParam(':category_1', $category_1, PDO::PARAM_STR);
		$stmt->bindParam(':creator', $creator, PDO::PARAM_STR);
		$stmt->bindParam(':created', $created, PDO::PARAM_STR);
		$stmt->bindParam(':openflag', $openflag, PDO::PARAM_STR);
		$stmt->execute();
		
		$id = $dbh->lastInsertId();
		
	} else if($mode == 'update'){
		
		$id = $_GET['id'];
		$date = date('Y-m-d H:i:s');
		$editor = $_POST['editor'];
		$updated = $date;
		
		$value08 = $editor;
		$value09 = $updated;
		$texte10 = $body;

		$sql = "update ".$dbname.".masdata set title=:title,body=:body,category_1=:category_1,creator=:creator,editor=:editor,updated=:updated,openflag=:openflag WHERE id=:id";
		$stmt = $dbh->prepare($sql);

		$params = array(':title'=>$title,':body'=>$body,':category_1'=>$category_1,':creator'=>$creator,':editor'=>$editor,':updated'=>$updated,':openflag'=>$openflag,':id'=>$id);
		$stmt->execute($params);

	}

	$mode = 'update&id='.$id;

	$timelimit = time()+60*60*24*90 ;
	$domain = "jportal.jmam.co.jp";

	setcookie( "UNAME" , $creator , $timelimit , $path , $domain ) ;


/////////////////////////////////　新規文書作成　//////////////////////////////////////////

} else if($mode == 'new'){

	$id = '';
	$date = date('Y-m-d H:i:s');
	$mode = 'add&id=0';
	
	if(isset($_COOKIE['UNAME'])){
		$creator = $_COOKIE['UNAME'];
	} else {
		$creator = '';
	}
	
	$seltext = SetSelText($dbh,'',$dbname);
	$seltext2 = SetSelText2('');

	//　編集・文書更新・新規保存　ボタン
	$type01 = '';
	$value01 = '新規保存';
	$text01 = '';
	//　削除　ボタン
	$type02 = 'hidden';
	$value02 = '';
	$text02 = '';
	//　タグ（カテゴリ）
	$type03 = '';
	$value03 = '';
	$text03 = '';
	//　公開フラグ
	$type04 = 'text';
	$value04 = ''; 
	$text04 = '';
	//　作成者
	$type05 = 'text';
	$value05 = $creator;
	$text05 = '';
	//　作成日
	$type06 = 'text';
	$value06 = $date;
	$text06 = '';
	//　件名
	$type07 = 'text';
	$value07 = ''; 
	$text07 = '';
	//　更新者
	$type08 = 'text';
	$value08 = '';
	$text08 = '';
	//　更新日
	$type09 = 'text';
	$value09 = '';
	$text09 = '';
	//　本文
	$type10 = '';
	$value10 = '';
	$text10 = '';
	//　添付ファイル一覧
	$type11 = 'hidden';
	$value11 = '';
	$text11 = '';
	//　アップロード　ボタン
	$type12 = 'hidden'; 
	$value12 = '';
	$text12 = '';
	//　アップ済み添付ファイル　削除　ボタン
	$type13 = 'hidden';
	$value13 = '';
	$text13 = '';
	//　アップ済み添付ファイル　ダウンロード　ボタン
	$type14 = 'hidden';
	$value14 = '';
	$text14 = '';
			

	// $mode = 'add';
	
/////////////////////////////////　指定文書削除　/////////////////////////////////

} else if($mode == 'del'){

	$id = $_GET['id'];
	$date = date('Y-m-d H:i:s');

	if(isset($_COOKIE['UNAME'])){
		$editor = $_COOKIE['UNAME'];
	} else {
		$editor = '';
	}
	
	$updated = $date;
	
	$sql = "update ".$dbname.".masdata set editor=:editor,updated=:updated,openflag=:openflag WHERE id=:id";
	$stmt = $dbh->prepare($sql);
	
	$params = array(':editor'=>$editor,':updated'=>$updated,':openflag'=>'削除',':id'=>$id);
	$stmt->execute($params);

	print("<p>文書を削除しました</p>\n");
	print("<a href='index.php'>");
	print("<input type='button' name='menu2' value='戻る' width='100'>");
	print("</a>\n");

    return false;
	
///////////////　********* 物理削除ルーチン *********　/////////////////

} else if($mode == 'del2'){

	$id = $_GET['id'];
	
	$sql = "delete from ".$dbname.".masdata where id = :id";
	$stmt = $dbh->prepare($sql);
	
	$params = array(':id' => $id);
	$stmt->execute($params);
	
	print("<p>文書を削除しました</p>\n");
	print("<a href='index.php'>");
	print("<input type='button' name='menu2' value='戻る' width='100'>");
	print("</a>\n");

    return false;
	

/////////////////////////////////　添付ファイルアップロード　/////////////////////////////////

} else if($mode == 'upload'){

	$stmt = $dbh->query($sql);
	
	foreach ($stmt as $row) {
	
		$category_1 = $row['category_1'];
		$openflag = $row['openflag'];
		$creator = $row['creator'];
		$created = $row['created'];
		$title = $row['title'];
		$editor = $row['editor'];
		$updated = $row['updated'];
		$body = $row['body'];
	
		$seltext = SetSelText($dbh,$category_1,$dbname);
		$seltext2 = SetSelText2($openflag);

		//　編集・文書更新・新規保存　ボタン
		$type01 = '';
		$value01 = '文書更新';
		$text01 = '';
		//　削除　ボタン
		$type02 = 'hidden';
		$value02 = '';
		$text02 = '　保存しました';
		//　タグ（カテゴリ）
		$type03 = '';
		$value03 = '';
		$text03 = '';
		//　公開フラグ
		$type04 = 'text';
		$value04 = $openflag; 
		$text04 = '';
		//　作成者
		$type05 = 'text';
		$value05 = $creator;
		$text05 = '';
		//　作成日
		$type06 = 'text';
		$value06 = $created;
		$text06 = '';
		//　件名
		$type07 = 'text';
		$value07 = $title; 
		$text07 = '';
		//　更新者
		$type08 = 'text';
		$value08 = $editor;
		$text08 = '';
		//　更新日
		$type09 = 'text';
		$value09 = $updated;
		$text09 = '';
		//　本文
		$type10 = '';
		$value10 = '';
		$text10 = $body;
		//　添付ファイル一覧
		$type11 = 'file';
		$value11 = '';
		$text11 = '';
		//　アップロード　ボタン
		$type12 = 'submit'; 
		$value12 = '';
		$text12 = '';
		//　アップ済み添付ファイル　削除　ボタン
		$type13 = 'button';
		$value13 = '';
		$text13 = '';
		//　アップ済み添付ファイル　ダウンロード　ボタン
		$type14 = 'hidden';
		$value14 = '';
		$text14 = '';

		if(!empty($_FILES['upfile']['name'])){
		
			for($i = 0; $i < count($_FILES['upfile']['name']); $i++ ){
				$name = $_FILES['upfile']['name'][$i];
				$contents = file_get_contents($_FILES['upfile']['tmp_name'][$i]);
				$type = $_FILES['upfile']['type'][$i];
				$size = $_FILES['upfile']['size'][$i];
				$parentid = $id;
				$created = date('Y-m-d H:i:s');

				$sql = 'insert into '.$dbname.'.attachments(name,type,contents,size,created,parentid) ';
				$sql = $sql .'values (:name,:type,:contents,:size,:created,:parentid)';
				
				$stmt = $dbh -> prepare($sql);
				$stmt->bindValue(':name', $name, PDO::PARAM_STR);
				$stmt->bindValue(':type', $type, PDO::PARAM_STR);
				$stmt->bindValue(':contents', $contents, PDO::PARAM_LOB);
				$stmt->bindValue(':size', $size, PDO::PARAM_INT);
				$stmt->bindValue(':created', $created, PDO::PARAM_STR);
				$stmt->bindValue(':parentid', $parentid, PDO::PARAM_INT);
				$stmt->execute();
			}
		}

		$mode = 'update&id='.$id;

	}
	return false;
}

//////////////////////////////　タグ　選択肢　設定　///////////////////////////////////////

function SetSelText($dbh,$category_1,$dbname)
{
	$sql2 = "SELECT category_1 FROM ".$dbname.".masdata GROUP BY category_1 ORDER BY category_1";
	$stmt2 = $dbh->query($sql2);
	
	$seltext = '<input type="text" list="selectlist" name="category_1" value="'.$category_1.'">'."\n";
	$seltext = $seltext.'<datalist id="selectlist">'."\n";
	$seltext = $seltext.'<option value="">'."\n";
	
	foreach ($stmt2 as $row2) {
		$seltext = $seltext.'<option value="'.$row2['category_1'].'">'."\n";
	}

	$seltext = $seltext.'</datalist>'."\n";

	return $seltext;
}

//////////////////////////////　公開　選択肢　設定　///////////////////////////////////////

function SetSelText2($openflag)
{
	$seltext2 = '<select name= "openflag" style="width:100%;font-size:14px">'."\n";
	
	if($openflag == '非公開'){
		$seltext2 = $seltext2.'<option value="非公開" selected>非公開</option>'."\n";
	} else{
		$seltext2 = $seltext2.'<option value="非公開">非公開</option>'."\n";
	}

	if($openflag == '公開'){
		$seltext2 = $seltext2.'<option value="公開" selected>公開</option>'."\n";
	} else{
		$seltext2 = $seltext2.'<option value="公開">公開</option>'."\n";
	}

	if($openflag == '削除'){
		$seltext2 = $seltext2.'<option value="削除" selected>削除</option>'."\n";
	} else{
		$seltext2 = $seltext2.'<option value="削除">削除</option>'."\n";
	}
		
	$seltext2 = $seltext2.'</select>'."\n";

	return $seltext2;
}

/////////////////////////////////　ファイルサイズ計算　/////////////////////////////////

function calcFileSize($fsize)
{
  $b = 1024;    // バイト
  $mb = pow($b, 2);   // メガバイト
  $gb = pow($b, 3);   // ギガバイト

  switch(true){
    case $fsize >= $gb:
      $target = $gb;
      $unit = 'GB';
      break;
    case $fsize >= $mb:
      $target = $mb;
      $unit = 'MB';
      break;
    default:
      $target = $b;
      $unit = 'KB';
      break;
  }

  $new_size = round($fsize / $target, 2);
  $file_size = number_format($new_size, 2, '.', ',') . $unit;

  return $file_size;
}

/////////////////////////////////　mime-type判定　/////////////////////////////////

function my_check_mime_type( $tmp_name ) {
    $bin_data = bin2hex (file_get_contents($tmp_name));
    $patt = array (
        '89504e47' => 'image/png',
        'ffd8' => 'image/jpeg',
        '47494638' => 'image/gif',
		
    );
    foreach ($patt as $mgk_num => $mime_type) {
        if (strpos ($bin_data,"{$mgk_num}") === 0)
            return $mime_type;
    }
    return false;
}

?>