<template>
    <header>
        <span class="header-text">Users</span>
    </header>
    <table class="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
    </table>
</template>

<script>
import DataTable from 'datatables.net'
import AdminLayout from "../../../Shared/Admin/AdminLayout";

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
    mounted() {
        this.table = new DataTable('.users-table', {
            ajax: {
                url: '/admin/get-users',
                dataSrc: 'data'
            },
            columns: [
                {data: 'id', name: 'ID'},
                {data: 'name', name: 'Name'},
                {data: 'email', name: 'Email'},
            ]
        })
    },
    beforeUnmount() {
        this.table.destroy();
    }
}
</script>

<style scoped>

</style>
