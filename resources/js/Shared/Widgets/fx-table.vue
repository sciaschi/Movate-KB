<template>
    <div class="fx-table-container">
        <div id="action-bar" class="float-right">
            <slot name="actions"></slot>
        </div>
        <table class="table fx-table">
            <thead>
                <tr>
                    <th v-for="column in columns" scope="col" @click="column.sortable ? this.sortColumn(column.id, $event) : false">
                        {{column.name}} <span class="float-end" v-if="column.sortable ?? false"><i class="fa fa-solid"></i></span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="data && data.length" v-for="(row, index) in data">
                    <td v-for="column in columns">
                        <div v-if="editing">
                            <input v-if="column.edit && column.edit.type" :type="column.edit.type" :value="row[column.id]"
                                   :checked="column.edit.type === 'checkbox' ? row[column.id] : null"
                                   @change="this.editValue($event, column.id, index, column.edit.type, row.id)">
                            <span v-else-if="column.render" :class="column.classList" v-html="column.render(row)"></span>
                            <span v-else>{{row[column.id]}}</span>
                        </div>
                        <div v-else>
                            <span v-if="column.render" :class="column.classList" v-html="column.render(row)"></span>
                            <span v-else>{{row[column.id]}}</span>
                        </div>
                    </td>
                </tr>
                <tr v-else-if="dataset && dataset.length" v-for="(row, index) in dataset">
                    <td v-for="column in columns">
                        <div v-if="editing">
                            <input v-if="column.edit && column.edit.type" :type="column.edit.type" :value="row[column.id]"
                                   :checked="column.edit.type === 'checkbox' ? row[column.id] : null"
                                   @change="this.editValue($event, column.id, index, column.edit.type, row.id)">
                            <span v-else-if="column.render" :class="column.classList" v-html="column.render(row)"></span>
                            <span v-else>{{row[column.id]}}</span>
                        </div>
                        <div v-else>
                            <span v-if="column.render" :class="column.classList" v-html="column.render(row)"></span>
                            <span v-else>{{row[column.id]}}</span>
                        </div>
                    </td>
                </tr>
                <tr v-else class="text-center">
                    <td :colspan="columns.length">
                        <span> Nothing to show yet!</span>
                    </td>
                </tr>
            </tbody>
            <div class="footer-content float-right">
                <create-button v-if="editing" @click="saveEdits"><i class="fa fa-floppy-disk pr-1"></i> Save Audit </create-button>
                <pagaination v-if="links" :links="links" @data="this.setData($event)"></pagaination>
                <slot name="footer"></slot>
            </div>
        </table>

    </div>
</template>

<script>
import CreateButton from "./create-button.vue";
import Pagaination from "./pagination.vue";

export default {
    name: "fx-table",
    components: {Pagaination, CreateButton},
    props: {
        ajax: String,
        columns: Array,
        data: Array,
        editing: Boolean
    },
    emits:['edited'],
    data() {
        return {
            table: null,
            dataset: [],
            links: [],
            editedValues: []
        }
    },
    methods: {
        getData: async function(ajax, callback) {
            if(typeof ajax === "string") {
                let res = await axios.get(ajax),
                    rawRes = res.data.data;

                this.setData(rawRes);
            }

            if(typeof callback === "function") {
                callback();
            }

        },
        sortColumn: function(colId, event) {
            let sourceEl = event.srcElement;
            let iconSpan = sourceEl.firstElementChild;
            let icon = iconSpan.firstChild;

            if(sourceEl.classList.contains('asc')) {
                sourceEl.classList.remove('asc');
                sourceEl.classList.add('desc');

                icon.classList.toggle('fa-chevron-up');
                icon.classList.toggle('fa-chevron-down');

                this.data.sort((a, b) => {
                    const nameA = a[colId]; // ignore upper and lowercase
                    const nameB = b[colId]; // ignore upper and lowercase
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }

                    // names must be equal
                    return 0;
                }).reverse();
            } else if (sourceEl.classList.contains('desc')) {
                sourceEl.classList.remove('desc');
                sourceEl.classList.add('asc');

                icon.classList.toggle('fa-chevron-up');
                icon.classList.toggle('fa-chevron-down');

                this.data.sort((a, b) => {
                    const nameA = a[colId]; // ignore upper and lowercase
                    const nameB = b[colId]; // ignore upper and lowercase
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }

                    // names must be equal
                    return 0;
                });
            } else {
                this.clearSort();

                sourceEl.classList.add('asc');
                icon.classList.add('fa-chevron-up');

                this.data.sort((a, b) => {
                    const nameA = a[colId]; // ignore upper and lowercase
                    const nameB = b[colId]; // ignore upper and lowercase
                    if (nameA < nameB) {
                        return -1;
                    }
                    if (nameA > nameB) {
                        return 1;
                    }

                    // names must be equal
                    return 0;
                });
            }
        },
        clearSort: function() {
            let iconElements = document.querySelectorAll('thead th i'),
                headerElements = document.querySelectorAll('thead tr th')

            iconElements.forEach((el) => {
                el.classList.remove('fa-chevron-up');
                el.classList.remove('fa-chevron-down');
            });

            headerElements.forEach((el) => {
                el.classList.remove('asc');
                el.classList.remove('desc');
            })
        },
        editValue: function(event, columnId, index, type, editValueId) {
            let data      = this.data ?? this.dataset,
                editIndex = this.editedValues.findIndex(x => x.id === editValueId);

            if(editIndex > -1) {
                this.editedValues.splice(editIndex, 1)
                return;
            }

            let editValue = event.target.value;

            if(type === 'checkbox') {
                editValue = event.target.checked ? 1 : 0;
            }

            data[index][columnId] = editValue;
            this.editedValues.push(data[index])
        },
        setData: function(e) {
            this.dataset = e.data;
            this.links = e.links;

            this.checkEdits(e.data);
        },
        saveEdits: function () {
            this.$emit('edited', this.editedValues)
            this.editedValues = [];
        },
        checkEdits: function(data) {
            for(let i = 0; i < data.length; i++) {
                let dataVal = data[i],
                    datasetIndex = this.dataset.findIndex(x => x.id === dataVal.id),
                    editVal = this.editedValues.find(x => x.id === dataVal.id);

                if(editVal) {
                    this.dataset[datasetIndex] = editVal;
                }
            }
        }
    },
    mounted() {
        if(this.ajax) {
            this.getData(this.ajax);
        }
    },
    watch: {
        ajax: {
            handler(newValue) {
                this.getData(newValue);
            },
            deep: true
        }
    }
}
</script>

<style scoped>
#action-bar {
    margin: 10px;
}
td {
    white-space: nowrap;
}
</style>
