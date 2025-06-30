<template>
  <div id="chart-transactions">
    <apexchart
      type="bar"
      :options="chartOptions"
      :series="chartSeries"
      width="100%"
      height="300"
    />
  </div>
</template>

<script>
export default {
  name: "TopTransactionChart",
  props: {
    transactions: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      chartSeries: [],
      chartOptions: {
        fill: {
          opacity: 1,
        },
        plotOptions: {
          bar: {
            horizontal: false,
          },
        },
        yaxis: {
          labels: {
            formatter: (value) => this.formatCurrency(value),
          },
        },
        xaxis: {
          categories: [],
        },
      },
    };
  },
  watch: {
    transactions: "processTransaction",
  },
  methods: {
    processTransaction() {
      const filesData = this.transactions.reduce((acc, item) => {
        acc[item.labels] = (acc[item.labels] || 0) + item.values;
        return acc;
      }, {});

      const chartSeries = [
        {
          name: "Transactions",
          data: [],
        },
      ];

      const categories = Object.entries(filesData).map(([label, value]) => {
        chartSeries[0].data.push(value);
        return label;
      });

      this.chartSeries = chartSeries;
      this.chartOptions = {
        ...this.chartOptions,
        colors: ['#00b0ef'],
        xaxis: {
          ...this.chartOptions.xaxis,
          categories,
        },
      };
    },
    formatCurrency(value) {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
      }).format(value);
    },
  },
  mounted() {
    this.processTransaction();
  },
};
</script>
