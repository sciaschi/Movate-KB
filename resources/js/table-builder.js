var tableBuilder = {
    html: '',
    columns: {},
    data: [],

    make: function() {
        let table = '<table class="table table-striped">';

        table += '<thead>';
        var columns    = this.columns,
            columnKeys = [];

            table +=   '<tr>';
            columns.forEach(function(column) {
                var classList = column['classList'] ?? '';
                columnKeys.push(column['id']);

                table += '<th class="' + classList + '" scope="col">' + column['name'] + '</th>';
            })
            table +=   '</tr>';
        table += '</thead>';

        table += '<tbody>';
            if(this.data)
            {
                this.data.forEach(function(row) {
                    var rowData = Object.keys(row);

                    table += '<tr>';
                    columnKeys.forEach(function(key, index) {
                        if(key == 'html')
                        {
                            var column = columns[index][key];

                            table += typeof column == 'function' ? '<td>' + column() + '</th>' : '<td>' + column + '</th>';
                        }
                        else
                        {
                            table += '<td>' + rowData[key] + '</th>';
                        }
                    });

                    table += '</tr>';

                });
            }
        table += '</tbody>';

        table += '</table>';

        this.html = table;

        return this.html;
    }
}
