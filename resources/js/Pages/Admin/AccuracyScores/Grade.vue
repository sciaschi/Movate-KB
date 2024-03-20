<template>
    <header>
        <span class="header-text">Grading {{$page.props.gradingUser.name}}'s Accuracy</span>
    </header>
    <label for="formFile" class="csv-file-input">
        <span class="sr-only">Choose CSV File</span>
        <input type="file" id="formFile" accept="text/csv, text/xlsx" @change="parseCSV">
    </label>
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
            <button type="button"  class="btn btn-primary" @click="gradeAccuracy">Grade</button>
        </div>
    </div>
</template>

<script>
import * as Papa from 'papaparse';
import route from "ziggy-js";

export default {
    name: "Grade",
    props: {
        gradingUser: Object
    },
    data () {
        return {
            data: null
        }
    },
    methods: {
        parseCSV: function (e) {
            Papa.parse(e.target.files[0],{
                complete: (res) => {
                    console.log('res.data', res.data);
                    this.data = res.data.map(function (x) {
                        return {
                            'name': x[2],
                            'flagged': x[1] == 'Moderator Approved Unselected',
                        }
                    });
                    this.data.splice(this.data.length - 2, 1)
                }
            });
        },
        gradeAccuracy: function(e) {
            var correct         = 0,
                totalCount      = this.data.length,
                selectedChecks  = document.querySelectorAll('input[type=radio]:checked'),
                postData        = []

            this.data.forEach(function(val, index) {
                if(selectedChecks[index].dataset.correct == 'true') {
                    correct++;
                }
                postData.push({
                    'username': val.name,
                    'mod_flagged': val.flagged,
                    'is_correct': (selectedChecks[index].dataset.correct === 'true'),
                })
            });

            var accuracy = (correct / totalCount) * 100;

            axios.post(route('admin.create-accuracy-score'), {
                'user_id': this.$props.gradingUser.id,
                'accuracy': accuracy,
                'data': postData
            })
        }
    }
}
</script>

<style scoped>

</style>
