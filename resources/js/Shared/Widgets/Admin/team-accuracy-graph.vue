<template>
    <dashboard-component-layout header="Average Team Accuracy">
        <canvas id="team-accuracy-graph" class="ml-2 mr-2 mb-2"></canvas>
    </dashboard-component-layout>
</template>

<script>
import Chart from 'chart.js/auto';
import moment from "moment";
import route from "ziggy-js/src/js";
import DashboardComponentLayout from "../Shared/dashboard-component-layout.vue";

export default {
    name: "team-accuracy-graph",
    components: {
        DashboardComponentLayout,
        Chart
    },
    data () {
      return {
          dateData: null,
          labels: null
      }
    },
    methods: {
        getData: function (dates) {
            axios.post(route('admin.get-team-averages'), {
                dates: dates
            }).then((e) => {
                this.generate(e.data.data);
            });
        },
        generate: function(data) {
            var context = this;

            new Chart(document.getElementById('team-accuracy-graph'), {
                type: 'bar',
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
                data: {
                    labels: context.labels,
                    datasets: [{
                        label: 'Average Accuracy Score',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        }
    },
    mounted: function() {
        var getDaysBetweenDates = function(startDate, endDate, format) {
            var now = startDate.clone(), dates = [];

            while (now.isSameOrBefore(endDate)) {
                dates.push(now.format(format));
                now.add(1, 'days');
            }
            return dates;
        };

        var nowDate   = moment().format('MM-DD-YYYY'),
            startDate = moment(nowDate).subtract(3, 'days'),
            endDate   = moment(nowDate).add(3, 'days');

        this.labels = getDaysBetweenDates(startDate, endDate, 'MM/DD/YYYY');

        this.getData(getDaysBetweenDates(startDate, endDate, 'YYYY-MM-DD'));
    }
}
</script>

<style scoped>

</style>
