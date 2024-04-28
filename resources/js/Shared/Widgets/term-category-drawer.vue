<template>
    <div class="drawer-div">
        <ul class="list-group list-group-flush" role="tablist">
            <a @click="expandDropdown()" class='active:bg-indigo-300
            dark:bg-slate-800 dark:text-slate-400 dark:border dark:border-slate-700 list-group-item
            list-group-item-action term_search_value' v-for="val in values"></a>
        </ul>
    </div>
</template>

<script>
// @click="setSelectedValue(val, $event.target)"
export default {
    name: "term-category-drawer",
    components: {},
    props: {
        data: Object
    },
    data () {
        return {
            editing: false,
            adding: false,
            values: [],
            selectedValue: null,
            searchTrigger: null
        }
    },
    mounted() {
        this.values = this.props.data;
    },
    methods: {
        expandDropdown: function() {

        },
        setSelectedValue: function (term, el) {
            this.selectedValue = term;
            this.editing      = false;
            this.adding       = false;

            this.setSelectedItemBg(el);
        },
    }
}
</script>

<style scoped>

</style>