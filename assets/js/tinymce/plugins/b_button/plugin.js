/**
 * plugin.js
 *Add Bootstrap Button
 By. CSKAZA
/*global tinymce:true */

tinymce.PluginManager.add('b_button', function(editor) {
	function createLinkList(callback) {
		return function() {
			var linkList = editor.settings.link_list;

			if (typeof linkList == "string") {
				tinymce.util.XHR.send({
					url: linkList,
					success: function(text) {
						callback(tinymce.util.JSON.parse(text));
					}
				});
			} else if (typeof linkList == "function") {
				linkList(callback);
			} else {
				callback(linkList);
			}
		};
	}

	function buildListItems(inputList, itemCallback, startItems) {
		function appendItems(values, output) {
			output = output || [];

			tinymce.each(values, function(item) {
				var menuItem = {text: item.text || item.title};

				if (item.menu) {
					menuItem.menu = appendItems(item.menu);
				} else {
					menuItem.value = item.value;

					if (itemCallback) {
						itemCallback(menuItem);
					}
				}

				output.push(menuItem);
			});

			return output;
		}

		return appendItems(inputList, startItems || []);
	}

	function showDialog(linkList) {
		var data = {}, selection = editor.selection, dom = editor.dom, selectedElm, anchorElm, initialText;
		var win, onlyText, textListCtrl, linkListCtrl, relListCtrl, targetListCtrl, classListCtrl, linkTitleCtrl, value, btnClass, sizeClass;

		function linkListChangeHandler(e) {
			var textCtrl = win.find('#text');

			if (!textCtrl.value() || (e.lastControl && textCtrl.value() == e.lastControl.text())) {
				textCtrl.value(e.control.text());
			}

			win.find('#href').value(e.control.value());
		}

		function buildAnchorListControl(url) {
			var anchorList = [];

			tinymce.each(editor.dom.select('a:not([href])'), function(anchor) {
				var id = anchor.name || anchor.id;

				if (id) {
					anchorList.push({
						text: id,
						value: '#' + id,
						selected: url.indexOf('#' + id) != -1
					});
				}
			});

			if (anchorList.length) {
				anchorList.unshift({text: 'None', value: ''});

				return {
					name: 'anchor',
					type: 'listbox',
					label: 'Anchors',
					values: anchorList,
					onselect: linkListChangeHandler
				};
			}
		}

		function updateText() {
			if (!initialText && data.text.length === 0 && onlyText) {
				this.parent().parent().find('#text')[0].value(this.value());
			}
		}

		function urlChange(e) {
			var meta = e.meta || {};

			if (linkListCtrl) {
				linkListCtrl.value(editor.convertURL(this.value(), 'href'));
			}

			tinymce.each(e.meta, function(value, key) {
				win.find('#' + key).value(value);
			});

			if (!meta.text) {
				updateText.call(this);
			}
		}

		function isOnlyTextSelected(anchorElm) {
			var html = selection.getContent();

			if (/</.test(html) && (!/^<a [^>]+>[^<]+<\/a>$/.test(html) || html.indexOf('href=') == -1)) {
				return false;
			}

			if (anchorElm) {
				var nodes = anchorElm.childNodes, i;

				if (nodes.length === 0) {
					return false;
				}

				for (i = nodes.length - 1; i >= 0; i--) {
					if (nodes[i].nodeType != 3) {
						return false;
					}
				}
			}

			return true;
		}

		selectedElm = selection.getNode();
		anchorElm = dom.getParent(selectedElm, 'a[href]');
		onlyText = isOnlyTextSelected();

		data.text = initialText = anchorElm ? (anchorElm.innerText || anchorElm.textContent) : selection.getContent({format: 'text'});		

		if (anchorElm) {
			data.target = dom.getAttrib(anchorElm, 'target');
		} else if (editor.settings.default_link_target) {
			data.target = editor.settings.default_link_target;
		}

		if ((value = dom.getAttrib(anchorElm, 'rel'))) {
			data.rel = value;
		}
                
                if ((value = dom.getAttrib(anchorElm, 'btn_class'))) {
			data.btn_class = value;
		}
                
                if ((value = dom.getAttrib(anchorElm, 'size_class'))) {
			data.size_class = value;
		}

		if ((value = dom.getAttrib(anchorElm, 'title'))) {
			data.title = value;
		}
                
                data.href = anchorElm ? dom.getAttrib(anchorElm, 'href') : '';

		if (onlyText) {
			textListCtrl = {
				name: 'text',
				type: 'textbox',
				size: 40,
				label: 'Text to display',
				onchange: function() {
					data.text = this.value();
				}
			};
		}

		if (linkList) {
			linkListCtrl = {
				type: 'listbox',
				label: 'Link list',
				values: buildListItems(
					linkList,
					function(item) {
						item.value = editor.convertURL(item.value || item.url, 'href');
					},
					[{text: 'None', value: ''}]
				),
				onselect: linkListChangeHandler,
				value: editor.convertURL(data.href, 'href'),
				onPostRender: function() {
					linkListCtrl = this;
				}
			};
		}

		if (editor.settings.target_list !== false) {
			if (!editor.settings.target_list) {
				editor.settings.target_list = [
					{text: 'None', value: ''},
					{text: 'New window', value: '_blank'}
				];
			}

			targetListCtrl = {
				name: 'target',
				type: 'listbox',
				label: 'Target',
				values: buildListItems(editor.settings.target_list)
			};
		}
                
                if (editor.settings.btn_class !== false) {
			if (!editor.settings.btn_class) {
				editor.settings.btn_class = [
                                        {text: 'Default', value: 'btn btn-default'},
					{text: 'Primary', value: 'btn btn-primary'},
                                        {text: 'Success', value: 'btn btn-success'},
                                        {text: 'Info', value: 'btn btn-info'},
                                        {text: 'Warning', value: 'btn btn-warning'},
                                        {text: 'Danger', value: 'btn btn-danger'}                                       
				];
			}

			btnClass = {
				name: 'btn_class',
				type: 'listbox',
				label: 'Button Class',
				values: buildListItems(editor.settings.btn_class)
			};
		}  
                
                if (editor.settings.size_class !== false) {
			if (!editor.settings.size_class) {
				editor.settings.size_class = [
                                        {text: 'None', value: ''},
					{text: 'Large', value: ' btn-lg'},
                                        {text: 'Small', value: ' btn-sm'},					
                                        {text: 'Extra Small', value: ' btn-xs'}                                     
				];
			}

			sizeClass = {
				name: 'size_class',
				type: 'listbox',
				label: 'Size Class',
				values: buildListItems(editor.settings.size_class)
			};
		}

		if (editor.settings.rel_list) {
			relListCtrl = {
				name: 'rel',
				type: 'listbox',
				label: 'Rel',
				values: buildListItems(editor.settings.rel_list)
			};
		}

		if (editor.settings.link_title !== false) {
			linkTitleCtrl = {
				name: 'title',
				type: 'textbox',
				label: 'Title',
				value: data.title
			};
		}
                             
		win = editor.windowManager.open({
			title: 'Insert Bootstrap Button',
			data: data,
			body: [
				{
					name: 'href',
					type: 'filepicker',
					filetype: 'file',
					size: 40,
					autofocus: true,
					label: 'Url',
					onchange: urlChange,
					onkeyup: updateText
				},
				textListCtrl,
				linkTitleCtrl,
				buildAnchorListControl(data.href),
				linkListCtrl,
				relListCtrl,
				targetListCtrl,
				classListCtrl,
                                btnClass,
                                sizeClass
			],
			onSubmit: function(e) {
				var href;

				data = tinymce.extend(data, e.data);
				href = data.href;

				function delayedConfirm(message, callback) {
					var rng = editor.selection.getRng();

					tinymce.util.Delay.setEditorTimeout(editor, function() {
						editor.windowManager.confirm(message, function(state) {
							editor.selection.setRng(rng);
							callback(state);
						});
					});
				}

				function insertLink() {
					var linkAttrs = {
						target: data.target ? data.target : null,
						rel: data.rel ? data.rel : null,
						class: data.btn_class + data.size_class,
						title: data.title ? data.title : null,
                                                role: "button",
                                                href: href
					};

					if (anchorElm) {
						editor.focus();

						if (onlyText && data.text != initialText) {
							if ("innerText" in anchorElm) {
								anchorElm.innerText = data.text;
							} else {
								anchorElm.textContent = data.text;
							}
						}

						dom.setAttribs(anchorElm, linkAttrs);

						selection.select(anchorElm);
						editor.undoManager.add();
					} else {
						if (onlyText) {
							editor.insertContent(dom.createHTML('a', linkAttrs, dom.encode(data.text)));
						} else {
							editor.execCommand('mceInsertLink', false, linkAttrs);
						}
					}
				}

				if (!href) {
					editor.execCommand('unlink');
					return;
				}

				/* Is email and not //user@domain.com */
				if (href.indexOf('@') > 0 && href.indexOf('//') == -1 && href.indexOf('mailto:') == -1) {
					delayedConfirm(
						'The URL you entered seems to be an email address. Do you want to add the required mailto: prefix?',
						function(state) {
							if (state) {
								href = 'mailto:' + href;
							}

							insertLink();
						}
					);

					return;
				}

				/* Is not protocol prefixed */
				if ((editor.settings.link_assume_external_targets && !/^\w+:/i.test(href)) ||
					(!editor.settings.link_assume_external_targets && /^\s*www[\.|\d\.]/i.test(href))) {
					delayedConfirm(
						'The URL you entered seems to be an external link. Do you want to add the required http:// prefix?',
						function(state) {
							if (state) {
								href = 'http://' + href;
							}

							insertLink();
						}
					);

					return;
				}

				insertLink();
			}
		});
	}

	editor.addButton('b_button', {
		icon: 'glyphicons guicon guicon-button',
                /*text: 'BTN',*/
		tooltip: 'Insert Button',
		onclick: createLinkList(showDialog)

	});

	this.showDialog = showDialog;

	editor.addMenuItem('b_button', {
		icon: 'glyphicons guicon guicon-button',
		text: 'Button',
		onclick: createLinkList(showDialog),
		context: 'insert',
		prependToContext: true
	});
});