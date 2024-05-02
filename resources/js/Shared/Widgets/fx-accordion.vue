<template>
    <div class="fx-accordion">
        <span @click="expandDropdown($event)" class='dark:bg-indigo-600 dark:border dark:border-slate-700 list-group-item
                        list-group-item-action' style="background-color: #4338ca; color:#fafafa;">
                                {{ title }} <i class="accordian-icon expanded fa-solid fa-angle-up float-right"></i>
                            </span>
        <div :id='id + "-accordion"' class="expanded">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'fx-accordion',
    props: {
        id: String,
        title: String
    },
    data () {
        return {

        }
    },
    methods: {
        expandDropdown: function() {
            const el = document.getElementById(this.id + '-accordion'),
                icon = event.target.querySelector('.accordian-icon');


            el.classList.toggle('expanded')
            el.classList.toggle('collapsed')

            icon.classList.toggle('expanded')
            icon.classList.toggle('collapsed')
        }
    }
}
</script>

<style scoped>
div.collapsed {
    overflow: hidden;
    max-height: 0;
}
div.expanded {
    max-height: fit-content;
}
.accordian-icon.collapsed  {
    transform: rotate(0deg);
}
.accordian-icon.expanded {
    transform: rotate(180deg);
}
</style>