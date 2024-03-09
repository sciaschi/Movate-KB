<template>
<table class="table fx-table">
    <thead>
        <tr>
            <th v-for="column in columns" scope="col">
                {{column.name}}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="row in data">
            <td v-for="column in columns">
                <span v-if="column.id == null || column.render" v-html="column.render(row)"></span>
                <span v-else>{{row[column.id]}}</span>
            </td>
        </tr>
    </tbody>
</table>
</template>

<script>
export default {
    name: "fx-table",
    props: {
        ajaxRoute: '',
        columns: Array,
    },
    data() {
        return {
            table: null,
            data: []
        }
    },
    methods: {
        getData: async function(url, callback) {
            let res = await axios.get(url);
            this.data = res.data.data;

            if(typeof callback == "function") {
                callback();
            }
        }
    },
    created() {
        this.getData(this.ajaxRoute);
    }
}
</script>

<style scoped>

</style>
