<template>
    <div class="fx-table-container">
        <div id="action-bar" class="float-right">
            <slot name="actions"></slot>
        </div>
        <table class="table fx-table">
            <thead>
            <tr>
                <th v-for="column in columns" scope="col">
                    {{column.name}}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="data && data.length" v-for="row in data">
                <td v-for="column in columns">
                    <span v-if="column.render" :class="column.classList" v-html="column.render(row)"></span>
                    <span v-else>{{row[column.id]}}</span>
                </td>
            </tr>
            <tr v-else-if="dataset && dataset.length" v-for="row in dataset">
                <td v-for="column in columns">
                    <span v-if="column.render" :class="column.classList" v-html="column.render(row)"></span>
                    <span v-else>{{row[column.id]}}</span>
                </td>
            </tr>
            <tr v-else class="text-center">
                <td :colspan="columns.length">
                    <span> Nothing to show yet!</span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "fx-table",
    props: {
        ajax: '',
        columns: Array,
        data: Array
    },
    data() {
        return {
            table: null,
            dataset: []
        }
    },
    methods: {
        getData: async function(ajax, callback) {
            if(typeof ajax === "string") {
                let res = await axios.get(ajax);
                this.dataset = res.data.data;
            }

            if(typeof callback === "function") {
                callback();
            }
        }
    },
    mounted() {
        if(!this.data) {
            this.getData(this.ajax);
        }
    }
}
</script>

<style scoped>
#action-bar {
    margin: 10px;
}
</style>
