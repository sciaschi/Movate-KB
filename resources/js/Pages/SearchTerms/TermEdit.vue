<template>
    <div id="editPanel" class="row p-3">
        <div class="col-6 mt-2">
            <label for="edit-rating" class="form-label">Rating <span id="edit-rangeval" class="text-white" :class="'rating-' + term.rating">{{ term.rating }}</span></label>
            <input type="range" class="form-range" min="1" max="8" id="edit-rating" :value="term.rating">
        </div>
        <div class="col-6 mt-2">
            <span>Date</span>
            <p id="edit-date" class="fs-6">{{ formatSelectedTermDate(term.created_at) }}</p>
        </div>
        <div class="col-12  mt-2">
            <input type="text" id="edit-term-val" class="edit-term-value form-control" placeholder="Term" :value="term.term">
        </div>
        <div class="col-12  mt-2">
            <editor api-key="b28l0twrnfpoia2kkfocy20i6yvxkem4m1nptacdtkz0aslk" :init="{
                height: 500,
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks ' +
                'visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor ' +
                'insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                content_style: 'body { font-size:16px }',
                table_default_attributes: {
                    class: 'static-table table-auto'
                },
                table_default_styles: {
                    width: '100%',
                    overflow: 'hidden'
                },
                table_header_type: 'auto',
                skin: (useDarkMode ? 'oxide-dark' : ''),
                content_css: (useDarkMode ? 'dark' : '')
            }" id="edit-description" class="form-control" rows="3" placeholder="Notes/Nuances (if any)" :initial-value="term.description"></editor>
        </div>
        <div class="col-6 mt-2 float-right">
            <div class="input-group">
                <input type="text" id="edit-web-address-val" class="form-control" placeholder="Enter Web address..." aria-label="Enter Web address..." aria-describedby="edit-add-web-address-btn">
                <button @click="addLink" class="btn btn-outline-secondary" type="button" id="edit-add-web-address-btn"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
        <div class="col-12 mt-2">
            <div id="edit-links-table">
                <table class="table-auto static-table">
                    <thead>
                        <tr>
                            <th class="rounded-t-lg">
                                Links
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
                                <button class="btn btn-primary" @click="removeLink(index)"><i class="fa-solid fa-xmark"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 mt-2">
            <button id="save-term-edit-btn" type="button" class="btn btn-outline-success float-right" @click="updateTerm">
                <i class="fa-regular fa-floppy-disk"></i> Save
            </button>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import Editor from '@tinymce/tinymce-vue';

export default {
    name: "TermEdit",
    props: {
        term: Object
    },
    components: {
        'moment': moment,
        'editor': Editor
    },
    data () {
        return {
            links: []
        }
    },
    emits: ['updateEditTerm'],
    methods: {
        formatSelectedTermDate: function (date) {
            return moment(date).format("MMMM Do YYYY");
        },
        useDarkMode: function() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches
        },
        updateTerm: function () {
            var context   = this,
                inputData = {
                    id: this.term.id,
                    term: document.getElementById('edit-term-val').value,
                    rating: document.getElementById('edit-rating').value,
                    description: tinymce.get("edit-description").getContent(),
                    links: this.links
                };

            axios.put('/term/update-term', inputData)
            .then(function (response) {
                var data      = response.data;
                context.$emit('updateEditTerm', data.data);
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        },
        addLink: function(event) {
            var editLinkInput = document.getElementById('edit-web-address-val');

            console.log(editLinkInput.value)

            this.links.push({link_url: editLinkInput.value});

            editLinkInput.value = '';
        },
        removeLink: function(index) {
            this.links.splice(index, 1);
        }
    },
    mounted() {
        this.links = [...this.term.links];

        document.getElementById("edit-rating").addEventListener('input',function() {
            var val = $(this).val();

            $("#edit-rangeval").html(val);
            utils.setColorByRangeNumber("edit-rating", "edit-rangeval");
        });
    }
}
</script>

<style scoped>

</style>
