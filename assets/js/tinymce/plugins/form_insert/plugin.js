/*
 * Create by. CSKAZA
 * 
 */
tinymce.PluginManager.add('form_insert', function (editor) {
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

    function displayHtml(type, name) {
        var newTable;
        newTable = '[?]{='+type+':'+name+'}[?]';
        return newTable;
    }
    function showPopup() {
        // Open window
        var selType = [
            {text: 'Forms', value: 'forms'},
            {text: 'Widget', value: 'widget'},
            {text: 'Banner', value: 'banner'}
        ];
        editor.windowManager.open({
            title: 'CSZ-CMS Forms/Widget/Banner',
            body: [
                {
                    name: 'type',
                    type: 'listbox',
                    label: 'Type',
                    values: buildListItems(selType)
                },
                {type: 'textbox', name: 'name', label: 'Value', size: 40}
            ],
            onsubmit: function (e) {
                // Insert content when the window form is submitted
                var div = displayHtml(e.data.type,e.data.name);
                editor.execCommand('mceInsertContent', false, div);
            }
        });
    }

    // Add a button that opens a window
    editor.addButton('form_insert', {
        /*text: 'PN',*/
        icon: 'glyphicons guicon guicon-form',
        tooltip: 'Insert Forms/Widget/Banner',
        onclick: function () {
            showPopup();
        }
    });
    
    editor.addMenuItem('form_insert', {
		icon: 'glyphicons guicon guicon-form',
		text: 'Forms',
		onclick: function () {
                    showPopup();
                },
		context: 'insert',
		prependToContext: true
    });
});