<template>
    <header>
        <span class="header-text">Accuracy Scores</span>
    </header>

    <div class="container table-container">
        <fx-table @vue:updated="tableMounted" class="users-table" :ajaxRoute="route('admin.users.get-users-with-accuracies')" :columns="columns"></fx-table>
    </div>

</template>

<script>
import AdminLayout from "../../../Shared/Admin/AdminLayout";
import {Inertia} from "@inertiajs/inertia";
import FxTable from "@jsAssets/Shared/Widgets/fx-table.vue";
import route from "ziggy-js";

export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        FxTable
    },
    data() {
        return {
            columns: []
        }
    },
    methods: {
        route,
        viewHistoricalData: function(id) {
            Inertia.visit(route('admin.accuracy-history', {id: id}));
        },
        addNewAccuracyData: function(id) {
            Inertia.visit(route('admin.grade-accuracy', {id: id}));
        },
        tableMounted: function () {
            document.querySelectorAll('.users-table tbody button.vhd').forEach((e) => {
                e.onclick = (el) => {
                    var id = el.currentTarget.dataset.id;
                    this.viewHistoricalData(id);
                };
            });

            document.querySelectorAll('.users-table tbody button.ana').forEach((e) => {
                e.onclick = (el) => {
                    var id = el.currentTarget.dataset.id;
                    this.addNewAccuracyData(id);
                };
            });
        }
    },
    beforeMount() {
        this.columns = [
            {
                id: 'name',
                name: 'Name'
            },
            {
                id: 'email',
                name: 'Email'
            },
            {
                data: 'accuracy_score',
                name: 'Accuracy Score',
                render: function (data) {
                    console.log('%', data)
                    return data.accuracy_score + '% ' + ' (Last Update: ' + data.last_updated + ')';
                }
            },
            {
                id: null,
                render: function(data) {
                    return '<button title="View Historical Accuracies" class="vhd action-btn" data-id="' + data.id + '"><i class="fa-regular fa-eye"></i></button>' +
                        '<button title="Create new Accuracy Data" class="ana action-btn" data-id="' + data.id + '"><i class="fa-solid fa-circle-plus"></i></button>';
                },
                name: 'Actions'
            },
        ];
    },

    beforeUnmount() {
    }
}
</script>

<style scoped>

</style>
