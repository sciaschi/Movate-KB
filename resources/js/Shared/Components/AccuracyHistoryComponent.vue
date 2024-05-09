<template>
    <div class="header-content">
        <input type="text" id="datepicker" placeholder="Pick a Date" style="width: 350px;">
    </div>
    <table class="history-table">
        <thead>
            <tr>
                <th>Moderated Name</th>
                <th>Flagged?</th>
                <th>Is Correct?</th>
            </tr>
        </thead>
    </table>
</template>

<script>
import DataTable from "datatables.net";
import moment from "moment";

export default {
    name: "AccuracyHistoryComponent",
    data () {
        return {
            historicalData: null,
            selectedDate: null,
            table: null
        }
    },
    methods: {
        getHistoricalData: function (date) {
            var context = this;

            axios.post(route('admin.get-accuracy-history'), {
                'user_id': route().params.id,
                'filter_date': moment(date).utc().format('YYYY-MM-DD'),
            }).then(function(res) {
                var response = res.data;
                if(response.status == true && response.data)
                {
                    context.generateTable(response.data);
                }
            });
        },
        generateTable: function (data) {
            this.historicalData = data;

            if(this.table)
            {
                this.table.clear().draw();
                this.table.rows.add(data); // Add new data
                this.table.columns.adjust().draw(); // Redraw the DataTable
            }
        }
    },
    mounted: function () {
        this.datePicker = jQuery( "#datepicker" ).datepicker();

        this.datePicker.on('change', (e) => {
            this.getHistoricalData(e.target.value);
        });

        this.table = new DataTable('.history-table', {
            data: this.historicalData,
            columns: [
                {
                    data: 'username',
                    name: 'Moderated Name'
                },
                {
                    data: 'mod_flagged',
                    name: 'Flagged?',
                    render: function ( data, type, row ) {
                        // If display or filter data is requested, format the date
                        if ( type === 'display') {
                            return data ? '<i class="fa-regular fa-flag text-green-600"></i>'
                                : '<i class="fa-regular fa-flag text-red-600"></i>'
                        }

                        // Otherwise the data type requested (`type`) is type detection or
                        // sorting data, for which we want to use the integer, so just return
                        // that, unaltered
                        return data;
                    }
                },
                {
                    data: 'is_correct',
                    name: 'Is Correct?',
                    render: function ( data, type, row ) {
                        // If display or filter data is requested, format the date
                        if ( type === 'display') {
                            return data ? '<i class="fa-solid fa-check text-green-600"></i>'
                                : '<i class="fa-solid fa-ban text-red-600"></i>'
                        }

                        // Otherwise the data type requested (`type`) is type detection or
                        // sorting data, for which we want to use the integer, so just return
                        // that, unaltered
                        return data;
                    }
                },

            ]
        });
    }
}
</script>

<style scoped>

</style>
