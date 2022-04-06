// JavaScript Document

function upfile_changeHandler(evt){
	var files = evt.target.files;
	var s = "";
	for(var i = 0; i < files.length; i++){
		var f = files[i];
		s += 
			'<tr>' + 
			'<td class="row">[ファイル名] ' + decodeURIComponent(f.name) + '</td>' +
			'<td class="row">[サイズ] ' + getFiseSize(f.size) + '</td>' +
			'<td class="row">[最終更新日] ' + f.lastModifiedDate.toLocaleString() + '</td>' +
			'</tr>';
			/* 'type;' + f.type + '<br>' + */
	}
	$('#info').innerHTML = '<table id="list">' + s + '</table>';
}

function $(id) {
	return document.querySelector(id);
}

function textarea_changeHandler(evt){
	/* var ref = $("textarea").currentStyle.fontSize; */
	var ref = String($('textarea').style.fontsize);
	var tasize = ref.replace('px','');
	
	var scrol = evt.target.scrollHeight;
	var ofset = evt.target.offsetHeight;
	
    if(scrol > ofset){
        evt.target.style.height = scrol + 'px';
    }else if(scrol < ofset){
		if(ofset - scrol > tasize){
			evt.target.style.height = ofset - tasize + 'px';
		}
    }
}


function adustTextarea(){
	var textarea = document.getElementById('textarea');
	if( textarea.scrollHeight > textarea.offsetHeight ){
		textarea.style.height = textarea.scrollHeight+'px';
	}
	//wrap=offの場合横幅調整もすると見やすくなる
	if( textarea.scrollWidth > textarea.offsetWidth ){
		textarea.style.width = textarea.scrollWidth+'px';
	}
}

function getFiseSize(file_size)
{
  var str;

  // 単位
  var unit = ['byte', 'KB', 'MB', 'GB', 'TB'];

  for (var i = 0; i < unit.length; i++) {
    if (file_size < 1024 || i == unit.length - 1) {
      if (i == 0) {
        // カンマ付与
        var integer = file_size.toString().replace(/([0-9]{1,3})(?=(?:[0-9]{3})+$)/g, '$1,');
        str = integer +  unit[ i ];
      } else {
        // 小数点第2位は切り捨て
        file_size = Math.floor(file_size * 100) / 100;
        // 整数と小数に分割
        var num = file_size.toString().split('.');
        // カンマ付与
        var integer = num[0].replace(/([0-9]{1,3})(?=(?:[0-9]{3})+$)/g, '$1,');
        if (num[1]) {
          file_size = integer + '.' + num[1];
        }
        str = file_size +  unit[ i ];
      }
      break;
    }
    file_size = file_size / 1024;
  }

  return str;
}

