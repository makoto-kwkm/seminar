function sun_create() {
	suneditor = SUNEDITOR.create('textarea', {
		lang:SUNEDITOR_LANG['ja'],
		display: 'block',
		width: '100%',
		height: 'auto',
		popupDisplay: 'full',
		charCounter: true,
		buttonList: [

			['undo', 'redo'],
			['font', 'fontSize'],
			['bold', 'underline', 'italic', 'strike'],
			['fontColor'],
			['removeFormat'],
			['image'],
			['link'],
			['codeView']
		
/*
			['undo', 'redo'],
			['font', 'fontSize'],
			['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
			['fontColor', 'hiliteColor', 'textStyle'],
			['removeFormat'],
			['outdent', 'indent'],
			['align', 'horizontalRule', 'list', 'lineHeight'],
			['link'],
			['codeView']
*/
		],
		font : [
			'Arial', 
			'Comic Sans MS', 
			'HGP教科書体', 
			'HGP行書体', 
			'HGP創英角ｺﾞｼｯｸUB', 
			'HGP創英角ﾎﾟｯﾌﾟ体', 
			'HG教科書体', 
			'HG行書体', 
			'HG創英角ｺﾞｼｯｸUB', 
			'HG創英角ﾎﾟｯﾌﾟ体', 
			'MS UI Gothic', 
			'ＭＳ ゴシック', 
			'ＭＳ Ｐゴシック', 
			'ＭＳ 明朝', 
			'ＭＳ Ｐ明朝', 
			'メイリオ', 
			'Meiryo UI', 
			'游ゴシック', 
			'Yu Gothic UI ', 
			'游明朝'
		],
		codeMirror: CodeMirror
	});
}

function sun_disabled() {
	suneditor.setOptions({
		mode: 'inline',
	});
	suneditor.disabled();
	
}

function sun_enabled() {
	suneditor.setOptions({
		mode: 'classic',
	});
	suneditor.enabled();
}

