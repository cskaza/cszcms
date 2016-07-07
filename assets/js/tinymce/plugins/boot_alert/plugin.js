/*
 * Create by. CSKAZA
 * 
 */
tinymce.PluginManager.add('boot_alert', function (editor) {
    function buildListItems(inputList, itemCallback, startItems) {
        function appendItems(values, output) {
            output = output || [];
            tinymce.each(values, function (item) {
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

    function displayHtml(container, type, value) {
        var newTable;

        if (container === true) {
            newTable = '<div class="container">';
            newTable += '<div class="alert alert-'+type+'" role="alert">';
            newTable += value;
            newTable += '</div>';
            newTable += '</div><br><br>';
        } else {
            newTable = '<div class="alert alert-'+type+'" role="alert">';
            newTable += value;
            newTable += '</div><br><br>';
        }
        return newTable;
    }
    function showPopup() {
        if (editor.settings.type !== false) {
            if (!editor.settings.type) {
                editor.settings.type = [
                    {text: 'Success', value: 'success'},
                    {text: 'Info', value: 'info'},
                    {text: 'Warning', value: 'warning'},
                    {text: 'Danger', value: 'danger'}
                ];
            }

            var btnClass = {
                name: 'type',
                type: 'listbox',
                label: 'Alert Type',
                values: buildListItems(editor.settings.type)
            };
        }
        // Open window
        editor.windowManager.open({
            title: 'Bootstrap Alert',
            body: [
                {type: 'checkbox', name: 'container', label: 'Container', value: '1'},
                {type: 'textbox', name: 'text', label: 'Text to display', size: 40},
                btnClass
            ],
            onsubmit: function (e) {
                // Insert content when the window form is submitted
                var div = displayHtml(e.data.container, e.data.type,  e.data.text);
                editor.execCommand('mceInsertContent', false, div);
            }
        });
    }

    // Add a button that opens a window
    editor.addButton('boot_alert', {
        /*text: 'PN',*/
        icon: 'glyphicons guicon guicon-alert',
        tooltip: 'Insert Alert',
        onclick: function () {
            showPopup();
        }
    });
    
    editor.addMenuItem('boot_alert', {
		icon: 'glyphicons guicon guicon-alert',
		text: 'Alert',
		onclick: function () {
                    showPopup();
                },
		context: 'insert',
		prependToContext: true
    });
});