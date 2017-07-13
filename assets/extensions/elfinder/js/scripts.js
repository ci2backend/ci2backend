Elfinder = function () {
	var elFinder_opt = {
	    url : function () {
	    	return false;
	    },
	    handlers : {
		    dblclick : function(event, elfinderInstance) {
		      event.preventDefault();
		      elfinderInstance.exec('getfile')
		        .done(function() { elfinderInstance.exec('edit'); })
		        .fail(function() { elfinderInstance.exec('open'); });
		    }
		},
		getFileCallback : function(files, fm) {
		    return false;
		},
		commandsOptions : {
		    quicklook : {
		      	width : $(document).width(),  // Set default width/height voor quicklook
		      	height : $(document).height()
		    },
		    edit: {
		      	mimes: [
		      		'text/plain',
	        		'text/html',
	        		'application/xhtml+xml',
	        		'text/javascript',
	        		'application/javascript',
	        		'application/json',
	        		'text/x-php',
	        		'application/x-php',
	        		'text/css',
	        		'text/xml',
                    'application/docbook+xml',
                    'application/xml'
		      	],
		      	editors: [{
		        	mimes: [
		        		'text/plain',
		        		'text/html',
		        		'application/xhtml+xml',
		        		'text/javascript',
		        		'application/javascript',
		        		'application/json',
		        		'text/x-php',
		        		'application/x-php',
		        		'text/css',
		        		'text/xml',
	                    'application/docbook+xml',
	                    'application/xml'
		        	],
		        	load: function(textarea) {
		          		var mimeType = this.file.mime;
		          		console.log(textarea);
		          		return CodeMirror.fromTextArea(textarea, {
		          			styleActiveLine: true,
							matchBrackets: true,
		            		mode: mimeType,
		            		lineNumbers: true,
		            		indentUnit: 4,
		            		lineWrapping: true,
	                    	theme : 'monokai'
		          		});
		        	},
		        	width : $(document).width(),  // Set default width/height voor quicklook
		      		height : $(document).height(),
			        save: function(textarea, editor) {
			          	$(textarea).val(editor.getValue());
			        }
		      	}]
		    }
		}
	};
	$.extend(this, elFinder_opt);
	return this;
}
function initFinder (element, options) {
	var opt = {
		contextmenu : {
	        // navbarfolder menu
	        navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
	        // current directory menu
	        cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'sort', '|', 'info'],
	        // current directory file menu
	        files  : ['getfile', '|', 'custom', 'edit', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info']
	    }
	}
	options = $.extend(options, opt);
	$(element).elfinder(options);
}