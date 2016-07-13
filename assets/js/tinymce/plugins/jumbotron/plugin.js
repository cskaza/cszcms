/*
 * Create by. CSKAZA
 * 
 */
tinymce.PluginManager.add('jumbotron', function (editor) {
    function displayHtml(container) {
        var newTable;

        if (container === true) {
            newTable = '<div class="jumbotron">';
            newTable += '<div class="container">';
            newTable += '<h1>Hello, world!</h1><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>';
            newTable += '</div>';
            newTable += '</div><br><br>';
        } else {
            newTable = '<div class="jumbotron">';
            newTable += '<h1>Hello, world!</h1><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>';
            newTable += '</div><br><br>';
        }
        return newTable;
    }
    function showPopup() {
        // Open window
        editor.windowManager.open({
            title: 'Bootstrap Jumbotron',
            body: [
                {type: 'checkbox', name: 'container', label: 'Container', value: '1'}
            ],
            onsubmit: function (e) {
                // Insert content when the window form is submitted
                var div = displayHtml(e.data.container);
                editor.execCommand('mceInsertContent', false, div);
            }
        });
    }

    // Add a button that opens a window
    editor.addButton('jumbotron', {
        /*text: 'Jumbotron',*/
        icon: 'glyphicons guicon guicon-jumbotron',
        tooltip: 'Insert Jumbotron',
        onclick: function () {
            showPopup();
        }
    });
    
    editor.addMenuItem('jumbotron', {
		icon: 'glyphicons guicon guicon-jumbotron',
		text: 'Jumbotron',
		onclick: function () {
                    showPopup();
                },
		context: 'insert',
		prependToContext: true
    });
});