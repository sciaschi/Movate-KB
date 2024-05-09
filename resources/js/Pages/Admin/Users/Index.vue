<template>
    <header>
        <span class="header-text">Users</span>
    </header>
    <div class="container table-container">
        <fx-table @vue:updated="tableMounted" class="users-table" :ajax="route('admin.users.get-users')" :columns="columns">
            <template #actions>
                <success-button @click="createNewUser"><i class="fa-solid fa-plus"></i> Add New</success-button>
            </template>
        </fx-table>
    </div>
</template>

<script>
import AdminLayout from "../../../Shared/Admin/AdminLayout";
import {Inertia} from "@inertiajs/inertia";
import route from "ziggy-js";
import FxTable from "@jsAssets/Shared/Widgets/fx-table.vue";
import SuccessButton from "../../../Shared/Widgets/success-button.vue";

export default {
    name: "Index",
    layout: AdminLayout,
    components: {
        SuccessButton,
        FxTable
    },
    data() {
        return {
            columns: []
        }
    },
    methods: {
        route,
        editUser: function (id) {
            Inertia.visit(route('admin.users.edit', {id: id}));
        },
        deleteUser: function (id) {
        },
        createNewUser: function () {
            Inertia.visit(route('admin.users.create'));
        },
        tableMounted: function () {
            document.querySelectorAll('.users-table tbody button.edit').forEach((e) => {
                e.onclick = (el) => {
                    var id = el.currentTarget.dataset.id;
                    this.editUser(id);
                };
            });

            document.querySelectorAll('.users-table tbody button.delete').forEach((e) => {
                e.onclick = (el) => {
                    var id = el.currentTarget.dataset.id;
                    this.deleteUser(id);
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
                id: 'role',
                name: 'Role'
            },
            {
                id: null,
                render: function(data) {
                    return '<button name="Edit User" class="action-btn edit" data-id="'+ data.id +'"><i class="fa-solid fa-pen-to-square"></i></button>' +
                        '<button name="Delete User" class="action-btn delete" data-id="'+ data.id +'"><i class="fa-solid fa-xmark"></i></button>';
                },
                name: 'Actions'
            },
        ];
    }
}
</script>
