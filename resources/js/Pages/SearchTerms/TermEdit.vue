<template>
    <div id="editPanel" class="row p-3">
        <div class="col-6 mt-2">
            <input type="text" id="edit-term-val" class="edit-term-value form-control" placeholder="Term" :value="!adding ? term.term : ''">
        </div>
        <div class="col-6 mt-2">
            <label for="edit-class" class="form-label">Class <span id="edit-rangeval" class="fs-6 term-rating ml-5 text-white" :class="!adding ? 'class-'+ term.rating : 'class-1'">{{ !adding ? utils().convertRating(term.rating) : '1' }}</span></label>
            <input type="range" class="form-range" min="1" max="4" id="edit-class" :value="!adding ? term.rating : '1'">
        </div>
        <div class="col-12 mt-2" style="height:100%;">
            <quill-editor ref="quillEditor" class="form-control" toolbar="full" :content="!adding ? term.description : ''" contentType="html"></quill-editor>
        </div>
        <div class="col-6 mt-1">
            <div class="input-group">
                <input type="text" id="edit-web-address-val" class="form-control" placeholder="Enter Source Url..." aria-label="Enter Source Url..." aria-describedby="edit-add-web-address-btn">
                <primary-button @click="addLink" class="btn-outline-light bg-primary" type="button" id="edit-add-web-address-btn">
                    <i class="fa-solid fa-plus"></i>
                </primary-button>
            </div>
            <div id="edit-links-table">
                <table class="table-auto static-table">
                    <thead>
                        <tr>
                            <th class="rounded-t-lg">
                                Source
                            </th>
                            <th class="rounded-t-lg">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(link, index) in links">
                            <td>
                                {{ link.link_url }}
                            </td>
                            <td>
                                <primary-button class="btn-primary" @click="removeLink(index)"><i class="fa-solid fa-xmark"></i></primary-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6 mt-1 float-right">
            <label for="edit-category" class="form-label">Category </label>
            <select id="edit-category" v-model="termCategory">
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
        </div>
        <div class="col-12 mt-2">
            <button id="save-term-edit-btn" type="button" class="btn bg-green-600 float-right" @click="!adding ? updateTerm() : addTerm()">
                <i class="fa-regular fa-floppy-disk"></i> Save
            </button>
            <button id="cancel-edit-btn" type="button" class="btn bg-red-600 float-right" @click="!adding ? updateTerm() : addTerm()">
                <i class="fa-regular fa-xmark-circle"></i> Cancel
            </button>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import Editor from '@tinymce/tinymce-vue';
import PrimaryButton from "@jsAssets/Shared/Widgets/primary-button.vue";
import utils from "@jsAssets/utils"
import {QuillEditor} from "@vueup/vue-quill";
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    name: "TermEdit",
    props: {
        term: Object,
        categories: Array,
        adding: Boolean
    },
    components: {
        QuillEditor,
        PrimaryButton,
        'moment': moment,
        'editor': Editor
    },
    data () {
        return {
            description: null,
            termCategory: null,
            links: []
        }
    },
    emits: ['updateEditTerm', 'addNewTerm', 'loading'],
    methods: {
        utils() {
            return utils
        },
        addTerm: function() {
            var context   = this,
                inputData = {
                    term: document.getElementById('edit-term-val').value,
                    rating: document.getElementById('edit-class').value,
                    category: document.getElementById('edit-category').value,
                    description: this.$refs.quillEditor.getHtml(),
                    links: this.links
                };
            this.$emit('loading', true)
            axios.post('/term/add-term', inputData)
                .then(function (response) {
                    context.$emit('addNewTerm', response.data.data);
                    context.$emit('loading', false)
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        updateTerm: function () {
            var context   = this,
                inputData = {
                    id: this.term.id,
                    term: document.getElementById('edit-term-val').value,
                    rating: document.getElementById('edit-class').value,
                    category: document.getElementById('edit-category').value,
                    description: this.$refs.quillEditor.getHTML(),
                    links: this.links
                };

            this.$emit('loading', true)

            axios.put('/term/update-term', inputData)
            .then(function (response) {
                context.$emit('updateEditTerm', response.data.data);
                context.$emit('loading', false)
            })
            .catch(function (error) {
                console.log(error);
            })
        },
        addLink: function(event) {
            var editLinkInput = document.getElementById('edit-web-address-val');

            this.links.push({link_url: editLinkInput.value});

            editLinkInput.value = '';
        },
        removeLink: function(index) {
            this.links.splice(index, 1);
        }
    },
    mounted() {
        this.links = this.term ? [...this.term.links] : [];
        console.log(this.term);
        this.termCategory = this.term.categories.length > 0 ? this.term.categories[0].id : 0;
        document.getElementById("edit-class").addEventListener('input', function() {
            var val = utils.convertRating($(this).val());

            $("#edit-rangeval").html(val);
            utils.setColorByRangeNumber("edit-class", "edit-rangeval");
        });
    }
}
</script>

<style scoped>
#edit-add-web-address-btn {
    height:unset;
    border-top-left-radius: 0!important;
    border-bottom-left-radius: 0!important;
}
</style>
