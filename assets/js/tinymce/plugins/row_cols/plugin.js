/*
 * Create by. CSKAZA
 * 
 */
tinymce.PluginManager.add('row_cols', function (editor) {
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

    function displayHtml(container, cols) {
        var newTable, cont_div_start, cont_div_end;
        
        if(container === true){
            cont_div_start = '<div class="container">\n';
            cont_div_end = '\n</div>';
        }else{
            cont_div_start = '';
            cont_div_end = '';
        }
            
        if (cols == '12') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-12">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }else if (cols == '6-6') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-6">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-6">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }else if (cols == '3-9') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-3">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-9">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }else if (cols == '9-3') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-9">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-3">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }else if (cols == '4-4-4') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-4">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-4">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-4">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }else if (cols == '3-3-3-3') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-3">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-3">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-3">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-3">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }else if (cols == '2-2-2-2-2-2') {
            newTable = cont_div_start + '<div class="row">\n';
            newTable += '<div class="col-md-2">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-2">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-2">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-2">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-2">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '<div class="col-md-2">\n';
            newTable += '<h2>Heading</h2><p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p><p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>';
            newTable += '\n</div>';
            newTable += '\n</div><br><br>' + cont_div_end;
        }
        return newTable;
    }
    function showPopup() {
        var cols_val;
        cols_val = [
            {text: '1 Cols (12)', value: '12'},
            {text: '2 Cols (6-6)', value: '6-6'},
            {text: '2 Cols (3-9)', value: '3-9'},
            {text: '2 Cols (9-3)', value: '9-3'},
            {text: '3 Cols (4-4-4)', value: '4-4-4'},
            {text: '4 Cols (3-3-3-3)', value: '3-3-3-3'},
            {text: '6 Cols (2-2-2-2-2-2)', value: '2-2-2-2-2-2'}
        ];

        // Open window
        editor.windowManager.open({
            title: 'Bootstrap Row & Cols',
            body: [
                {
                    name: 'cols_type',
                    type: 'listbox',
                    label: 'Column Type',
                    values: buildListItems(cols_val)
                },
                {type: 'checkbox', name: 'container', label: 'Container', value: '1'}
            ],
            onsubmit: function (e) {
                // Insert content when the window form is submitted
                var div = displayHtml(e.data.container, e.data.cols_type);
                editor.execCommand('mceInsertContent', false, div);
            }
        });
    }

    // Add a button that opens a window
    editor.addButton('row_cols', {
        /*text: 'Row',*/
        icon: 'glyphicons guicon guicon-grid',
        tooltip: 'Insert Row / Cols',
        onclick: function () {
            showPopup();
        }
    });
    
    editor.addMenuItem('row_cols', {
		icon: 'glyphicons guicon guicon-grid',
		text: 'Row / Cols',
		onclick: function () {
                    showPopup();
                },
		context: 'insert',
		prependToContext: true
    });
});