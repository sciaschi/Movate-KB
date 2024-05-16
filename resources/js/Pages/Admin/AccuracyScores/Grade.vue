<template>
    <header>
        <span class="header-text">Accuracy Grading</span>
    </header>
    <div id="actions" class="actions">
        <select v-model="selected">
            <option disabled value="">Please select moderator</option>
            <option v-for="user in users" :value="user.id">{{user.name}}</option>
        </select>
        <label class="csv-file-input  float-right">
            <span class="sr-only">Choose CSV File</span>
            <input type="file" id="formFile" accept="text/csv, text/xlsx" @change="parseCSV">
        </label>
    </div>
    <div class="uploaded-names row">
        <div class="col-4" v-for="(dat, index) in data">
            <div class="card mb-2">
                <div class="card-body">
                    <span class="card-text">{{dat.name}}</span>
                    <div class="actions float-right">
                        <input type="radio" class="btn-check" data-correct="true" :name="'options-outlined-'+index" :id="'success-outlined-'+index" autocomplete="off" checked>
                        <label class="btn btn-outline-success" :for="'success-outlined-'+index"><i class="fa-solid fa-check"></i></label>

                        <input type="radio" class="btn-check" data-correct="false" :name="'options-outlined-'+index" :id="'danger-outlined-'+index" autocomplete="off">
                        <label class="btn btn-outline-danger" :for="'danger-outlined-'+index"><i class="fa-solid fa-xmark"></i></label>
                    </div>
                </div>
                <div class="card-footer">
                    <i class="fa-solid fa-flag" :class="dat.flagged ? 'flag' : 'no-flag'"></i> {{dat.flagged ? 'Flagged' : 'Not Flagged'}}
                </div>
            </div>
        </div>
        <div class="grade-details float-right">
            <span class="accuracy-percentage"></span>
            <create-button @click="gradeAccuracy">Grade</create-button>
        </div>
    </div>
</template>

<script>
import Papa from 'papaparse';
import createButton from "@jsAssets/Shared/Widgets/create-button.vue";
import route from "ziggy-js";

export default {
    name: "Grade",
    components: {
        createButton
    },
    props: {
        gradingUser: Object
    },
    data () {
        return {
            data: null,
            users: null,
            selected: null
        }
    },
    methods: {
        parseCSV: function (e) {
            Papa.parse(e.target.files[0], {
                skipEmptyLines: true,
                complete: (res) => {
                    console.log('res', res);
                    console.log('res.data', res.data);
                    this.data = res.data.map(function (x) {
                        return {
                            'name': x[2],
                            'flagged': x[1] == 'Moderator Approved Unselected',
                        }
                    });
                    this.data.splice(this.data.length, 1)
                }
            });
        },
        getMods: async function(e) {
            let res = await axios.get(route('admin.accuracy-scores.get-mods'));
            this.users = res.data.data;
        },
        gradeAccuracy: function(e) {
            var selectedChecks  = document.querySelectorAll('input[type=radio]:checked'),
                postData        = []

            this.data.forEach(function(val, index) {
                postData.push({
                    'username': val.name,
                    'mod_flagged': val.flagged,
                    'is_correct': (selectedChecks[index].dataset.correct === 'true'),
                })
            });

            axios.post(route('admin.create-accuracy-score'), {
                'user_id': this.$props.gradingUser.id ?? this.selected,
                'data': postData
            })
        }
    },
    mounted() {
        this.getMods();
    }
}
</script>

<style scoped>
#actions {
    //margin: 10px;
}
</style>
