<template>
    <div id="counter-wrapper">
        <primary-button @click="subPageCount" id="sub-btn" class="counter-btn"><i class="fa-solid fa-minus"></i></primary-button>
        <input id="page-counter" step="1" type="text" disabled>
        <primary-button @click="addPageCount" id="add-btn" class="counter-btn"><i class="fa-solid fa-plus"></i></primary-button>
    </div>
</template>

<script>
import PrimaryButton from "./primary-button.vue";
import TextInput from "./text-input.vue";
import utils from "@jsAssets/utils"
export default {
    name: "counter",
    computed: {

    },
    components: {TextInput, PrimaryButton},
    data: () => ({
        pageCount: 0
    }),
    mounted() {
        if(utils.getCookie('pageCount'))
            this.pageCount = utils.getCookie('pageCount')
        document.getElementById('page-counter').value = this.pageCount;
    },
    methods: {
        addPageCount: function () {
            this.pageCount++
            document.cookie = "pageCount=" + this.pageCount + "; SameSite=None; Secure";
            document.getElementById('page-counter').value = this.pageCount;
        },
        subPageCount: function () {
            if(this.pageCount == 0)
                return;

            this.pageCount--;
            document.getElementById('page-counter').value = this.pageCount;
            document.cookie = "pageCount=" + this.pageCount + "; SameSite=None; Secure";

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
