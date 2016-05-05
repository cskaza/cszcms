/**
 * @author CSKAZA
 * @copyright CSKAZA 2016
 */
tinymce.PluginManager.add('glyphicons', function(editor, url) {
	var icon_text = 'Glyphicons';
	var icon_selector = 'span.glyphicon';
	var icon_name = 'glyphicons';
	var icon_class = 'glyphicons guicon guicon-glyphicons';
	var icon_command = 'showGuiBootstrapGlyphicons';
	var css_list = [url + '/assets/css/plugin.min.css'];
	var ui_title = 'Bootstrap Glyphicons';
	var icon_list = [
		["Asterisk", "glyphicon glyphicon-asterisk"],
		["Plus", "glyphicon glyphicon-plus"],
		["Euro", "glyphicon glyphicon-euro"],
		["Minus", "glyphicon glyphicon-minus"],
		["Cloud", "glyphicon glyphicon-cloud"],
		["Envelope", "glyphicon glyphicon-envelope"],
		["Pencil", "glyphicon glyphicon-pencil"],
		["Glass", "glyphicon glyphicon-glass"],
		["Music", "glyphicon glyphicon-music"],
		["Search", "glyphicon glyphicon-search"],
		["Heart", "glyphicon glyphicon-heart"],
		["Star", "glyphicon glyphicon-star"],
		["Star Empty", "glyphicon glyphicon-star-empty"],
		["User", "glyphicon glyphicon-user"],
		["Film", "glyphicon glyphicon-film"],
		["Th Large", "glyphicon glyphicon-th-large"],
		["Th", "glyphicon glyphicon-th"],
		["Th List", "glyphicon glyphicon-th-list"],
		["Ok", "glyphicon glyphicon-ok"],
		["Remove", "glyphicon glyphicon-remove"],
		["Zoom In", "glyphicon glyphicon-zoom-in"],
		["Zoom Out", "glyphicon glyphicon-zoom-out"],
		["Off", "glyphicon glyphicon-off"],
		["Signal", "glyphicon glyphicon-signal"],
		["Cog", "glyphicon glyphicon-cog"],
		["Trash", "glyphicon glyphicon-trash"],
		["Home", "glyphicon glyphicon-home"],
		["File", "glyphicon glyphicon-file"],
		["Time", "glyphicon glyphicon-time"],
		["Road", "glyphicon glyphicon-road"],
		["Download Alt", "glyphicon glyphicon-download-alt"],
		["Download", "glyphicon glyphicon-download"],
		["Upload", "glyphicon glyphicon-upload"],
		["Inbox", "glyphicon glyphicon-inbox"],
		["Play Circle", "glyphicon glyphicon-play-circle"],
		["Repeat", "glyphicon glyphicon-repeat"],
		["Refresh", "glyphicon glyphicon-refresh"],
		["List Alt", "glyphicon glyphicon-list-alt"],
		["Lock", "glyphicon glyphicon-lock"],
		["Flag", "glyphicon glyphicon-flag"],
		["Headphones", "glyphicon glyphicon-headphones"],
		["Volume Off", "glyphicon glyphicon-volume-off"],
		["Volume Down", "glyphicon glyphicon-volume-down"],
		["Volume Up", "glyphicon glyphicon-volume-up"],
		["Qrcode", "glyphicon glyphicon-qrcode"],
		["Barcode", "glyphicon glyphicon-barcode"],
		["Tag", "glyphicon glyphicon-tag"],
		["Tags", "glyphicon glyphicon-tags"],
		["Book", "glyphicon glyphicon-book"],
		["Bookmark", "glyphicon glyphicon-bookmark"],
		["Print", "glyphicon glyphicon-print"],
		["Camera", "glyphicon glyphicon-camera"],
		["Font", "glyphicon glyphicon-font"],
		["Bold", "glyphicon glyphicon-bold"],
		["Italic", "glyphicon glyphicon-italic"],
		["Text Height", "glyphicon glyphicon-text-height"],
		["Text Width", "glyphicon glyphicon-text-width"],
		["Align Left", "glyphicon glyphicon-align-left"],
		["Align Center", "glyphicon glyphicon-align-center"],
		["Align Right", "glyphicon glyphicon-align-right"],
		["Align Justify", "glyphicon glyphicon-align-justify"],
		["List", "glyphicon glyphicon-list"],
		["Indent Left", "glyphicon glyphicon-indent-left"],
		["Indent Right", "glyphicon glyphicon-indent-right"],
		["Facetime Video", "glyphicon glyphicon-facetime-video"],
		["Picture", "glyphicon glyphicon-picture"],
		["Map Marker", "glyphicon glyphicon-map-marker"],
		["Adjust", "glyphicon glyphicon-adjust"],
		["Tint", "glyphicon glyphicon-tint"],
		["Edit", "glyphicon glyphicon-edit"],
		["Share", "glyphicon glyphicon-share"],
		["Check", "glyphicon glyphicon-check"],
		["Move", "glyphicon glyphicon-move"],
		["Step Backward", "glyphicon glyphicon-step-backward"],
		["Fast Backward", "glyphicon glyphicon-fast-backward"],
		["Backward", "glyphicon glyphicon-backward"],
		["Play", "glyphicon glyphicon-play"],
		["Pause", "glyphicon glyphicon-pause"],
		["Stop", "glyphicon glyphicon-stop"],
		["Forward", "glyphicon glyphicon-forward"],
		["Fast Forward", "glyphicon glyphicon-fast-forward"],
		["Step Forward", "glyphicon glyphicon-step-forward"],
		["Eject", "glyphicon glyphicon-eject"],
		["Chevron Left", "glyphicon glyphicon-chevron-left"],
		["Chevron Right", "glyphicon glyphicon-chevron-right"],
		["Plus Sign", "glyphicon glyphicon-plus-sign"],
		["Minus Sign", "glyphicon glyphicon-minus-sign"],
		["Remove Sign", "glyphicon glyphicon-remove-sign"],
		["Ok Sign", "glyphicon glyphicon-ok-sign"],
		["Question Sign", "glyphicon glyphicon-question-sign"],
		["Info Sign", "glyphicon glyphicon-info-sign"],
		["Screenshot", "glyphicon glyphicon-screenshot"],
		["Remove Circle", "glyphicon glyphicon-remove-circle"],
		["Ok Circle", "glyphicon glyphicon-ok-circle"],
		["Ban Circle", "glyphicon glyphicon-ban-circle"],
		["Arrow Left", "glyphicon glyphicon-arrow-left"],
		["Arrow Right", "glyphicon glyphicon-arrow-right"],
		["Arrow Up", "glyphicon glyphicon-arrow-up"],
		["Arrow Down", "glyphicon glyphicon-arrow-down"],
		["Share Alt", "glyphicon glyphicon-share-alt"],
		["Resize Full", "glyphicon glyphicon-resize-full"],
		["Resize Small", "glyphicon glyphicon-resize-small"],
		["Exclamation Sign", "glyphicon glyphicon-exclamation-sign"],
		["Gift", "glyphicon glyphicon-gift"],
		["Leaf", "glyphicon glyphicon-leaf"],
		["Fire", "glyphicon glyphicon-fire"],
		["Eye Open", "glyphicon glyphicon-eye-open"],
		["Eye Close", "glyphicon glyphicon-eye-close"],
		["Warning Sign", "glyphicon glyphicon-warning-sign"],
		["Plane", "glyphicon glyphicon-plane"],
		["Calendar", "glyphicon glyphicon-calendar"],
		["Random", "glyphicon glyphicon-random"],
		["Comment", "glyphicon glyphicon-comment"],
		["Magnet", "glyphicon glyphicon-magnet"],
		["Chevron Up", "glyphicon glyphicon-chevron-up"],
		["Chevron Down", "glyphicon glyphicon-chevron-down"],
		["Retweet", "glyphicon glyphicon-retweet"],
		["Shopping Cart", "glyphicon glyphicon-shopping-cart"],
		["Folder Close", "glyphicon glyphicon-folder-close"],
		["Folder Open", "glyphicon glyphicon-folder-open"],
		["Resize Vertical", "glyphicon glyphicon-resize-vertical"],
		["Resize Horizontal", "glyphicon glyphicon-resize-horizontal"],
		["Hdd", "glyphicon glyphicon-hdd"],
		["Bullhorn", "glyphicon glyphicon-bullhorn"],
		["Bell", "glyphicon glyphicon-bell"],
		["Certificate", "glyphicon glyphicon-certificate"],
		["Thumbs Up", "glyphicon glyphicon-thumbs-up"],
		["Thumbs Down", "glyphicon glyphicon-thumbs-down"],
		["Hand Right", "glyphicon glyphicon-hand-right"],
		["Hand Left", "glyphicon glyphicon-hand-left"],
		["Hand Up", "glyphicon glyphicon-hand-up"],
		["Hand Down", "glyphicon glyphicon-hand-down"],
		["Circle Arrow Right", "glyphicon glyphicon-circle-arrow-right"],
		["Circle Arrow Left", "glyphicon glyphicon-circle-arrow-left"],
		["Circle Arrow Up", "glyphicon glyphicon-circle-arrow-up"],
		["Circle Arrow Down", "glyphicon glyphicon-circle-arrow-down"],
		["Globe", "glyphicon glyphicon-globe"],
		["Wrench", "glyphicon glyphicon-wrench"],
		["Tasks", "glyphicon glyphicon-tasks"],
		["Filter", "glyphicon glyphicon-filter"],
		["Briefcase", "glyphicon glyphicon-briefcase"],
		["Fullscreen", "glyphicon glyphicon-fullscreen"],
		["Dashboard", "glyphicon glyphicon-dashboard"],
		["Paperclip", "glyphicon glyphicon-paperclip"],
		["Heart Empty", "glyphicon glyphicon-heart-empty"],
		["Link", "glyphicon glyphicon-link"],
		["Phone", "glyphicon glyphicon-phone"],
		["Pushpin", "glyphicon glyphicon-pushpin"],
		["Usd", "glyphicon glyphicon-usd"],
		["Gbp", "glyphicon glyphicon-gbp"],
		["Sort", "glyphicon glyphicon-sort"],
		["Sort By Alphabet", "glyphicon glyphicon-sort-by-alphabet"],
		["Sort By Alphabet Alt", "glyphicon glyphicon-sort-by-alphabet-alt"],
		["Sort By Order", "glyphicon glyphicon-sort-by-order"],
		["Sort By Order Alt", "glyphicon glyphicon-sort-by-order-alt"],
		["Sort By Attributes", "glyphicon glyphicon-sort-by-attributes"],
		["Sort By Attributes Alt", "glyphicon glyphicon-sort-by-attributes-alt"],
		["Unchecked", "glyphicon glyphicon-unchecked"],
		["Expand", "glyphicon glyphicon-expand"],
		["Collapse Down", "glyphicon glyphicon-collapse-down"],
		["Collapse Up", "glyphicon glyphicon-collapse-up"],
		["Log In", "glyphicon glyphicon-log-in"],
		["Flash", "glyphicon glyphicon-flash"],
		["Log Out", "glyphicon glyphicon-log-out"],
		["New Window", "glyphicon glyphicon-new-window"],
		["Record", "glyphicon glyphicon-record"],
		["Save", "glyphicon glyphicon-save"],
		["Open", "glyphicon glyphicon-open"],
		["Saved", "glyphicon glyphicon-saved"],
		["Import", "glyphicon glyphicon-import"],
		["Export", "glyphicon glyphicon-export"],
		["Send", "glyphicon glyphicon-send"],
		["Floppy Disk", "glyphicon glyphicon-floppy-disk"],
		["Floppy Saved", "glyphicon glyphicon-floppy-saved"],
		["Floppy Remove", "glyphicon glyphicon-floppy-remove"],
		["Floppy Save", "glyphicon glyphicon-floppy-save"],
		["Floppy Open", "glyphicon glyphicon-floppy-open"],
		["Credit Card", "glyphicon glyphicon-credit-card"],
		["Transfer", "glyphicon glyphicon-transfer"],
		["Cutlery", "glyphicon glyphicon-cutlery"],
		["Header", "glyphicon glyphicon-header"],
		["Compressed", "glyphicon glyphicon-compressed"],
		["Earphone", "glyphicon glyphicon-earphone"],
		["Phone Alt", "glyphicon glyphicon-phone-alt"],
		["Tower", "glyphicon glyphicon-tower"],
		["Stats", "glyphicon glyphicon-stats"],
		["Sd Video", "glyphicon glyphicon-sd-video"],
		["Hd Video", "glyphicon glyphicon-hd-video"],
		["Subtitles", "glyphicon glyphicon-subtitles"],
		["Sound Stereo", "glyphicon glyphicon-sound-stereo"],
		["Sound Dolby", "glyphicon glyphicon-sound-dolby"],
		["Sound 5 1", "glyphicon glyphicon-sound-5-1"],
		["Sound 6 1", "glyphicon glyphicon-sound-6-1"],
		["Sound 7 1", "glyphicon glyphicon-sound-7-1"],
		["Copyright Mark", "glyphicon glyphicon-copyright-mark"],
		["Registration Mark", "glyphicon glyphicon-registration-mark"],
		["Cloud Download", "glyphicon glyphicon-cloud-download"],
		["Cloud Upload", "glyphicon glyphicon-cloud-upload"],
		["Tree Conifer", "glyphicon glyphicon-tree-conifer"],
		["Tree Deciduous", "glyphicon glyphicon-tree-deciduous"]
	];
	var config = '';
	if (typeof editor.settings[icon_name] === 'object') {
		var config = editor.settings[icon_name];
	}
	var display_menu = true;
	var display_toolbar_text = true;
	if (typeof config === 'object') {
		/*if (typeof config.css !== 'undefined') {
			if (!config.css.exist) {
				if (!config.css.external) {
					css_list.push(url + '/assets/css/glyphicon.css');
					if (window.galau_ui_debug === true) {
						console.log('glyphicons => css : internal');
					}
				} else {
					css_list.push(config.css.external);
					if (window.galau_ui_debug === true) {
						console.log('glyphicons => css : external');
					}
				}
			} else {
				if (window.galau_ui_debug === true) {
					console.log('glyphicons => css : exist');
				}
			}
		} else {
			css_list.push(url + '/assets/css/glyphicon.css');
			if (window.galau_ui_debug === true) {
				console.log('glyphicons => css : internal');
			}
		}*/
		if (config.toolbar_text) {
			display_toolbar_text = true;
		} else {
			display_toolbar_text = false;
		}
		if (config.menu) {
			display_menu = true;
		} else {
			display_menu = false;
		}
	}/* else {
		css_list.push(url + '/assets/css/glyphicon.css');
		if (window.galau_ui_debug === true) {
			console.log('glyphicons => css : internal');
		}
	}*/

	function showDialog(callback) {
		if (!callback) {
			callback = false;
		}
		//set current icon
		var selection = editor.selection;
		var dom = editor.dom;
		//window.console && console.log(icon_class);

		function getParentTd(elm) {
			while (elm) {
				if (elm.nodeName == 'TD') {
					return elm;
				}
				elm = elm.parentNode;
			}
		}

		function displayIcons(icons_list, obj) {
			var newTable, gridHtml, x, y, win;
			gridHtml = '<table role="presentation" cellspacing="0" ><tbody>';
			var width = 15;
			var height = Math.ceil(icons_list.length / width);
			for (y = 0; y < height; y++) {
				gridHtml += '<tr>';
				for (x = 0; x < width; x++) {
					var index = y * width + x;
					if (index < icons_list.length) {
						var chr = icons_list[index];
						gridHtml += '<td title="' + chr[0] + '" data-icon="' + chr[1] + '" ><div tabindex="-1" title="' + chr[0] + '" role="button"><span class="' + chr[1] + '"></span></div></td>';
					} else {
						gridHtml += '<td />';
					}
				}
				gridHtml += '</tr>';
			}
			gridHtml += '</tbody></table>';
			if (obj === true) {
				newTable = document.createElement('div');
				newTable.setAttribute('id', 'icon-table');
				newTable.setAttribute('class', 'mce-icon-table');
				newTable.innerHTML = gridHtml;
			} else {
				newTable = '<div class="mce-icon-table" id="icon-table">';
				newTable += gridHtml;
				newTable += '</div>';
			}
			return newTable;
		}

		function onSearch(keyword) {
			var filter = [];
			//icon_list
			for (var x = 0; x < icon_list.length; x++) {
				var chr = icon_list[x];
				if (chr[1].toLowerCase().indexOf(keyword) >= 0) {
					filter.push(chr);
				}
			};
			var newTable = displayIcons(filter, true);
			var oldTable = document.querySelector('#icon-table');
			oldTable.parentNode.replaceChild(newTable, oldTable);
			//window.console && console.log(newTable);
		}
		win = editor.windowManager.open({
			title: ui_title,
			classes: icon_name + '-panel',
			bodyType: "tabpanel",
			body: [{
				title: "General",
				type: 'container',
				layout: 'flex',
				spacing: 10,
				padding: 10,
				items: [{
					type: 'container',
					classes: 'icon-table',
					html: '<div class="mce-icon-box" id="icon-box">' + displayIcons(icon_list, false) + '</div>',
					spacing: 10,
					minHeight: 300,
					onclick: function(e) {
						var td = getParentTd(e.target);
						if (typeof callback === 'string') {
							editor.settings[callback](td.getAttribute('data-icon'));
							win.close();
						} else {
							var icon_markup = '<span class="' + td.getAttribute('data-icon') + '"></span> <span data-mce-bogus="1"/>';
							editor.execCommand('mceInsertContent', false, icon_markup);
							if (!e.ctrlKey) {
								win.close();
							}
						}
					},
					onmouseover: function(e) {
						var td = getParentTd(e.target);
						var preview = document.getElementById('icon_preview');
						if (td && td.firstChild) {
							preview.setAttribute('class', td.getAttribute('data-icon'));
							win.find('#icon_title_preview').text(td.title);
						} else {
							preview.setAttribute('class', ' ');
							win.find('#icon_title_preview').text(' ');
						}
					}
				},
				{
					type: 'container',
					layout: 'flex',
					direction: 'column',
					align: 'center',
					spacing: 5,
					minWidth: 160,
					minHeight: 40,
					items: [{
						type: 'panel',
						name: 'preview',
						html: '<span style="margin:10px;font-size:60px;width:60px;height:60px;text-align: center" id="icon_preview"></span>',
						style: 'text-align:center;background:#fff;',
						border: 1,
						width: 80,
						minHeight: 80
					},
					{
						type: 'label',
						name: 'icon_title_preview',
						text: ' ',
						style: 'text-align: center',
						border: 1,
						minWidth: 140,
						minHeight: 36
					}]
				}]
			}],
			buttons: [{
				text: "Close",
				onclick: function() {
					win.close();
				}
			}]
		});
		var selectedElm = selection.getNode();
		var spanElm = dom.getParent(selectedElm, 'span[class]');
		if ((value = dom.getAttrib(spanElm, 'class'))) {
			var preview = document.querySelector('#icon_preview');
			preview.setAttribute('class', value);
		}
	}
	// inline menu icon
	editor.addButton(icon_name + '_remove', {
		icon: 'remove',
		onclick: function() {
			var $_ = tinymce.dom.DomQuery;
			var spanElm = editor.dom.getParent(editor.selection.getStart(), icon_selector);
			if (spanElm) {
				editor.undoManager.transact(function() {
					$_(spanElm).replaceWith('');
				});
			}
		}
	});
	editor.on('init', function() {
		editor.addContextToolbar(icon_selector, icon_name + ' undo redo | ' + icon_name + '_remove');
	});
	// Include CSS 
	if (typeof editor.settings.content_css !== 'undefined') {
		if (typeof editor.settings.content_css.push === "function") {
			for (var i = 0; i < css_list.length; i++) {
				editor.settings.content_css.push(css_list[i]);
			};
		} else if (typeof editor.settings.content_css === "string") {
			editor.settings.content_css = [editor.settings.content_css];
			for (var i = 0; i < css_list.length; i++) {
				editor.settings.content_css.push(css_list[i]);
			};
		} else {
			editor.settings.content_css = css_list;
		}
	} else {
		editor.settings.content_css = css_list;
	}
	// Allow elements
	if (typeof editor.settings.extended_valid_elements == 'undefined') {
		editor.settings.extended_valid_elements = '*[*]';
	}
	if (typeof editor.settings.valid_elements == 'undefined') {
		editor.settings.valid_elements = '*[*]';
	}
	if (window.galau_ui_debug == true) {
		console.log('glyphicon => valid: ', editor.settings.valid_elements);
		console.log('glyphicon => extended_valid: ', editor.settings.extended_valid_elements);
	}
	// Include CSS 
	editor.on('init', function() {
		if (document.createStyleSheet) {
			for (var i = 0; i < css_list.length; i++) {
				document.createStyleSheet(css_list[i]);
			}
		} else {
			for (var i = 0; i < css_list.length; i++) {
				cssLink = editor.dom.create('link', {
					rel: 'stylesheet',
					href: css_list[i]
				});
				document.getElementsByTagName('head')[0].appendChild(cssLink);
			}
		}
	});
	var toolbar_text = '';
	if (display_toolbar_text) {
		toolbar_text = icon_text;
	}
	editor.addCommand(icon_command, showDialog);
	// Add to button
	editor.addButton(icon_name, {
		icon: icon_class,
		/*text: toolbar_text,*/
		tooltip: icon_text,
		cmd: icon_command,
		stateSelector: icon_selector
	});
	if (display_menu === true) {
		// Add to menu
		editor.addMenuItem(icon_name, {
			icon: icon_class,
			text: icon_text,
			cmd: icon_command,
			stateSelector: icon_selector,
			context: 'insert',
                        prependToContext: true
		});
	}
	//callback
	if (!editor.settings[icon_command]) {
		editor.settings[icon_command] = showDialog;
	}
	var iconPicker = [{
		value: 'none',
		text: 'None'
	}];
	//register to iconPicker
	if (typeof editor.settings.gui_icon_picker === 'object') {
		iconPicker = editor.settings.gui_icon_picker;
	}
	iconPicker.push({
		value: icon_command,
		text: icon_text
	});
	editor.settings.gui_icon_picker = iconPicker;
});