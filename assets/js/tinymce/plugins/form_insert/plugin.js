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

    function displayHtml(form_name) {
        var newTable;
        newTable = '[?]{=forms:'+form_name+'}[?]';
        return newTable;
    }
    function showPopup() {
        // Open window
        editor.windowManager.open({
            title: 'CSZ-CMS Forms',
            body: [
                {type: 'textbox', name: 'form_name', label: 'Forms Name', size: 40}
            ],
            onsubmit: function (e) {
                // Insert content when the window form is submitted
                var div = displayHtml(e.data.form_name);
                editor.execCommand('mceInsertContent', false, div);
            }
        });
    }

    // Add a button that opens a window
    editor.addButton('form_insert', {
        /*text: 'PN',*/
        icon: 'glyphicons guicon guicon-form',
        tooltip: 'Insert Forms',
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