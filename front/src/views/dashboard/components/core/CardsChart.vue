<script>
  import { Bar } from 'vue-chartjs'

  export default {
    name: 'BarChart',
    extends: Bar,
    props: {
      chartData: {
        // eslint-disable-next-line vue/require-prop-type-constructor
        type: Array | Object,
        required: false,
      },
      chartLabels: {
        type: Array,
        required: true,
      },
    },
    data () {
      return {
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: true,
              },
            }],
            xAxes: [{
              gridLines: {
                display: false,
              },
            }],
          },
          legend: {
            display: false,
          },
          responsive: true,
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 20,
              bottom: 10,
            },
          },
        },
      }
    },
    mounted () {
      this.renderChart({
        labels: this.chartLabels,
        datasets: [
          {
            label: 'Polise',
            borderColor: '#249EBF',
            pointBackgroundColor: 'white',
            borderWidth: 1,
            pointBorderColor: '#249EBF',
            backgroundColor: '#2dbbe2',
            data: this.chartData,
          },
        ],
      }, this.options)
    },
  }
</script>
