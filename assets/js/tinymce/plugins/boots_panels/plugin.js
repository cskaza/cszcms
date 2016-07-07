/*
 * Create by. CSKAZA
 * 
 */
tinymce.PluginManager.add('boots_panels', function (editor) {
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

    function displayHtml(container, type) {
        var newTable;

        if (container === true) {
            newTable = '<div class="container">';
            newTable += '<div class="panel panel-'+type+'">';
            newTable += '<div class="panel-heading">Panel heading</div>';
            newTable += '<div class="panel-body">';
            newTable += '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>';
            newTable += '</div>';
            newTable += '</div>';
            newTable += '</div><br><br>';
        } else {
            newTable = '<div class="panel panel-'+type+'">';
            newTable += '<div class="panel-heading">Panel heading</div>';
            newTable += '<div class="panel-body">';
            newTable += '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>';
            newTable += '</div>';
            newTable += '</div><br><br>';
        }
        return newTable;
    }
    function showPopup() {
        if (editor.settings.type !== false) {
            if (!editor.settings.type) {
                editor.settings.type = [
                    {text: 'Default', value: 'default'},
                    {text: 'Primary', value: 'primary'},
                    {text: 'Success', value: 'success'},
                    {text: 'Info', value: 'info'},
                    {text: 'Warning', value: 'warning'},
                    {text: 'Danger', value: 'danger'}
                ];
            }

            var btnClass = {
                name: 'type',
                type: 'listbox',
                label: 'Panel Type',
                values: buildListItems(editor.settings.type)
            };
        }
        // Open window
        editor.windowManager.open({
            title: 'Bootstrap Panels',
            body: [
                {type: 'checkbox', name: 'container', label: 'Container', value: '1'},
                btnClass
            ],
            onsubmit: function (e) {
                // Insert content when the window form is submitted
                var div = displayHtml(e.data.container, e.data.type);
                editor.execCommand('mceInsertContent', false, div);
            }
        });
    }

    // Add a button that opens a window
    editor.addButton('boots_panels', {
        /*text: 'PN',*/
        icon: 'glyphicons guicon guicon-panel',
        tooltip: 'Insert Panels',
        onclick: function () {
            showPopup();
        }
    });
    
    editor.addMenuItem('boots_panels', {
		icon: 'glyphicons guicon guicon-panel',
		text: 'Panels',
		onclick: function () {
                    showPopup();
                },
		context: 'insert',
		prependToContext: true
    });
});