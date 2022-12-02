<template>
    <header>
        <span class="header-text">Accuracy Scores</span>
    </header>
    <table class="users-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>

</template>

<script>
import AdminLayout from "../../../Shared/Admin/AdminLayout";
import DataTable from "datatables.net";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        DataTable
    },
    data() {
        return {
            table: null
        }
    },
    methods: {
        viewHistoricalData: function(id) {
            console.log("Clicked view historical accuracy data " + id);
            Inertia.visit(route('admin.grade-accuracy'))
        },
        addNewAccuracyData: function(id) {
            console.log("Clicked add new accuracy data " + id);
            Inertia.visit(route('admin.grade-accuracy'))
        },
    },
    mounted() {
        var context = this;

        this.table = new DataTable('.users-table', {
            ajax: {
                url: '/admin/get-users',
                dataSrc: 'data'
            },
            columns: [
                {data: 'id', name: 'ID'},
                {data: 'name', name: 'Name'},
                {data: 'email', name: 'Email'},
                {
                    "data": null,
                    "sortable": false,
                    "render": function (o) {
                        return '<button title="View Historical Accuracies" class="vhd action-btn" data-id="' + o.id + '"><i class="fa-regular fa-eye"></i></button>' +
                               '<button title="Create new Accuracy Data" class="ana action-btn" data-id="' + o.id + '"><i class="fa-solid fa-pen"></i></button>';
                    }
                }
            ]
        });

        $('.users-table tbody').on('click', 'button.vhd', function (e) {
            var id = e.currentTarget.dataset.id;
            context.viewHistoricalData(id);
        }).on('click', 'button.ana', function (e) {
            var id = e.currentTarget.dataset.id;
            context.addNewAccuracyData(id);
        });
    },
    beforeUnmount() {
        this.table.destroy();
    }
}
</script>

<style scoped>

</style>
