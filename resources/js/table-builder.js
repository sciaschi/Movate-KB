let jsTableBuilder = {
    html: '',
    columns: [],
    data: [],

    make: async function (tableData, usrColumns) {
        this.columns = usrColumns || [];

        let table = '<table class="table fx-table">';
        let columnKeys= []

        table += '<thead>';
            table += '<tr>';
                this.columns.forEach(function(column) {
                    var classList = column['classList'] ?? '';
                    columnKeys.push(column['id']);

                    table += '<th class="' + classList + '" scope="col">' + column['name'] + '</th>';
                })
            table += '</tr>';
        table += '</thead>';

        if(typeof tableData == 'string')
        {
            this.data = await this.getData(tableData);
            console.log('response', this.data);
        }
        else
        {
            this.data = tableData;
        }

        table += '<tbody>';
            if(this.data)
            {
                this.data.forEach((row) => {
                    table += '<tr>';
                    columnKeys.forEach((key, index) => {
                        if(key == null)
                        {
                            var column = this.columns[index];
                            table += column.render && typeof column.render == 'function' ? '<td>' + column.render(row) + '</th>' : '<td>' + column + '</th>';
                        }
                        else
                        {
                            table += '<td>' + row[key] + '</th>';
                        }
                    });

                    table += '</tr>';

                });
            }

        table += '</tbody>';

        table += '</table>';

        this.html = table;

        console.log(this.html);

        return this.html;
    },

    getData: async function(url) {
        const response = await axios.get(url);

        if(response.data.status)
        {
            return response.data.data;
        }

        return [];
    },

    getHtml: function () {
        return this.html;
    },

    refresh: function () {
        this.html = this.make(this.columns)
    }
}
export default jsTableBuilder
