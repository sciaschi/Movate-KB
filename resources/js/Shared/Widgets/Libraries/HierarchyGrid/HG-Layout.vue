<script>
import draggable from 'vuedraggable'
import HgItem from "@jsAssets/Shared/Widgets/Libraries/HierarchyGrid/HG-Item.vue";

export default {
    name: "hg-layout",
    components: {
        HgItem,
        draggable
    },
    props: {
        columns: {
            type: Number,
            default: 4
        },
        columnWidth: {
            type: Number,
            default: 100
        },
        margins: {
            type: Number,
            default: 10
        },
        items: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            specialHeaders: ['col'],
            colStyle: {
                'display': 'flex',
                'flex-basis': this.columnWidth,
                'flex-direction': 'column',
                'flex-grow': 1,
                'height': [
                    '-webkit-max-content',
                    '-moz-max-content',
                    'max-content',
                ],
                'min-width': 0,
            }
        }
    },
    methods: {

    }
}
</script>

<template>
    <div ref="layoutRef"
         class="hg-layout"
         :style="{ display: 'flex', gap: `${margins[0]}px` }">
        <div class="hg-column"
             v-for="i in columns"
             :style="colStyle">
            <slot :name="`column-${i}`"></slot>
        </div>
    </div>
</template>

<style scoped>
    .hg-layout {
        display: inline-flex;
        transition: height 200ms ease;
    }
</style>