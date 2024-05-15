<template>
    <div class="historical-container">
        <fx-table :columns="this.columns" :ajax="ajax" :editing="editing" @edited="saveEdits">
            <template #actions>
                <div class="header-content">
                    <VueDatePicker ref="dateSelectorRef" v-model="selectedDate"  @update:model-value="setDate" :enable-time-picker="false"></VueDatePicker>
                    <primary-button v-if="selectedDate && this.$page.props.auth.user.role[0] === 'Admin'" @click="this.editing = !this.editing"><i class="fa fa-pen-to-square pr-1"></i> Edit Audit </primary-button>
                </div>
            </template>
        </fx-table>
    </div>
</template>

<script>
import moment from "moment";
import FxTable from "../Widgets/fx-table.vue";
import route from "ziggy-js/src/js";
import VueDatePicker from '@vuepic/vue-datepicker';
import CreateButton from "../Widgets/create-button.vue";
import PrimaryButton from "../Widgets/primary-button.vue";
import Pagaination from "../Widgets/pagination.vue";
export default {
    name: "AccuracyHistoryComponent",
    components: {
        Pagaination,
        PrimaryButton,
        FxTable,
        VueDatePicker,
        CreateButton
    },
    props: {
        data: Object
    },
    data () {
        return {
            columns: [],
            historicalData: this.data,
            ajax: '',
            selectedDate: null,
            editing: false
        }
    },
    methods: {
        getHistoricalData: function (date) {
            this.ajax = route('get-accuracy-history', {
                'user_id': route().params.id ?? this.$page.props.auth.user.id,
                'filter_date': moment(date).format('YYYY-MM-DD'),
                'page': 1
            });
        },
        setDate: function (date) {
            this.getHistoricalData(date);
        },
        saveEdits: function (data) {
            axios.post(route('admin.update-accuracy-history', route().params.id), {
                'user_id': route().params.id,
                'date': moment(this.selectedDate).format('YYYY-MM-DD'),
                'data': data
            }).then((e) => {
                this.editing = false;
                console.log(e);
            })
        },
    },
    created() {
        this.columns = [
            {
                id: 'username',
                name: 'Moderated Term',
            },
            {
                id: 'mod_flagged',
                name: 'Flagged?',
                render: function ( data ) {
                    return data.mod_flagged ? '<i class="fa-regular fa-flag text-green-600"></i>'
                        : '<i class="fa-regular fa-flag text-red-600"></i>'
                }
            },
            {
                id: 'is_correct',
                name: 'Is Correct?',
                render: function (data) {
                    return data.is_correct ? '<i class="fa-solid fa-check text-green-600"></i>'
                        : '<i class="fa-solid fa-ban text-red-600"></i>'
                },
                edit: {
                    type:'checkbox'
                }
            },
        ]
    }
}
</script>

<style scoped>

</style>
