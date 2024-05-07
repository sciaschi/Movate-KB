<template>
    <div id="counter-wrapper">
        <primary-button @click="subPageCount" id="sub-btn" class="counter-btn"><i class="fa-solid fa-minus"></i></primary-button>
        <input id="page-counter" step="1" type="text" :value="pageCount" disabled>
        <primary-button @click="addPageCount" id="add-btn" class="counter-btn"><i class="fa-solid fa-plus"></i></primary-button>
    </div>
</template>

<script>
import PrimaryButton from "./primary-button.vue";
import TextInput from "./text-input.vue";
import { useCookies } from "vue3-cookies"
export default {
    name: "page-counter",
    components: {TextInput, PrimaryButton},
    data: () => ({
        pageCount: 0
    }),
    setup() {
        const { cookies } = useCookies();
        return { cookies };
    },
    mounted() {
        if(!this.cookies.get('page-count'))
        {
            this.cookies.set('page-count', this.pageCount, 1);
        }

        this.pageCount = this.cookies.get('page-count')
    },
    methods: {
        addPageCount: function () {
            this.pageCount++
            this.cookies.set('page-count', this.pageCount);
        },
        subPageCount: function () {
            if(this.pageCount == 0)
                return;

            this.pageCount--;
            this.cookies.set('page-count', this.pageCount);
        },
    }
}
</script>

<style scoped>
    #counter-wrapper {
        margin: 0 15px 0 0;
    }
    #page-counter {
        width: 4em;
        text-align: center;
    }

    #sub-btn {
        border-radius: 5px 0 0 5px !important;
    }
    #add-btn {
        border-radius: 0 5px 5px 0 !important;
    }
    .counter-btn {
        height: 40px;
        background-color:#4338ca !important;
    }
</style>
