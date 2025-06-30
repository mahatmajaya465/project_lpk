<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Dashboard</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <section class="row">
          <div class="col-12 col-lg-12">
            <div class="row">
              <div class="col-12 col-lg-3 col-md-12">
                <router-link
                  class="text-decoration-none"
                  :to="{
                    name: 'admin.peserta.index',
                    query: { periode: periode, status: 'active' },
                  }"
                >
                  <div class="card">
                    <div class="card-body">
                      <h3 class="card-title">Peserta Aktif</h3>
                      <div>
                        <h5 class="font-extrabold mb-0">
                          {{ analysis.peserta_aktif }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-3 col-md-12">
                <router-link
                  class="text-decoration-none"
                  :to="{
                    name: 'admin.kelas.index',
                    query: { periode: periode, status: 'active' },
                  }"
                >
                  <div class="card">
                    <div class="card-body">
                      <h3 class="card-title">Kelas Aktif</h3>
                      <div>
                        <h5 class="font-extrabold mb-0">
                          {{ analysis.kelas_aktif }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-3 col-md-12">
                <router-link
                  class="text-decoration-none"
                  :to="{
                    name: 'admin.pembayaran.index',
                    query: { periode: periode, status: 'accepted' },
                  }"
                >
                  <div class="card mb-3">
                    <div class="card-body">
                      <h3 class="card-title">Pembayaran Diterima</h3>
                      <div>
                        <h5 class="font-extrabold mb-0">
                          {{ analysis.pembayaran_diterima }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-3 col-md-12">
                <router-link
                  class="text-decoration-none"
                  :to="{
                    name: 'admin.gaji_instruktur.index',
                    query: { periode: periode, status: 'accepted' },
                  }"
                >
                  <div class="card mb-3">
                    <div class="card-body">
                      <h3 class="card-title">Gaji Instruktur</h3>
                      <div>
                        <h5 class="font-extrabold mb-0">
                          {{ analysis.gaji_instruktur }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Peserta Per Kelas</h3>
                    <div
                      id="kelas-chart"
                      ref="kelasChart"
                      style="min-height: 240px"
                    ></div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-md-12">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Peserta dalam Program</h3>
                    <div class="table-responsive">
                      <table class="table table-vcenter" style="height: 240px">
                        <tbody>
                          <tr>
                            <td>
                              <h5>Program 1</h5>
                              <ul>
                                <li>Kelas 1 : 2 orang</li>
                                <li>Kelas 2 : 4 orang</li>
                                <li>Kelas 3 : 5 orang</li>
                              </ul>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h5>Program 1</h5>
                              <ul>
                                <li>Kelas 1 : 2 orang</li>
                                <li>Kelas 2 : 4 orang</li>
                                <li>Kelas 3 : 5 orang</li>
                              </ul>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h5>Program 1</h5>
                              <ul>
                                <li>Kelas 1 : 2 orang</li>
                                <li>Kelas 2 : 4 orang</li>
                                <li>Kelas 3 : 5 orang</li>
                              </ul>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { nextTick } from "vue";
import ApexCharts from "apexcharts";

export default {
  name: "IndexComponent",
  components: {},
  data() {
    return {
      periode: null,
      user: this.$user,
      analysis: {
        services_count: 0,
        projects_count: 0,
        testimonials_count: 0,
      },
    };
  },
  created() {
    this.fetchTransactionAnalysis();
    nextTick(() => {
      this.renderKelasChart();
    });
  },

  methods: {
    async fetchTransactionAnalysis() {
      Loading();
      try {
        const response = await axios.get(`/v1/analysis`, {
          params: {
            periode: this.periode,
          },
        });

        this.analysis = response.data.data;
        Swal.close();
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    renderKelasChart() {
      const options = {
        chart: {
          type: "bar",
          height: 240,
          toolbar: { show: false },
          animations: { enabled: false },
          fontFamily: "inherit",
          parentHeightOffset: 0,
        },
        stroke: {
          width: 2,
          lineCap: "round",
          curve: "straight",
        },
        series: [
          {
            name: "Nilai",
            data: [9, 10, 3], // Bahasa, IPA, IPS
          },
        ],
        labels: ["Bahasa", "IPA", "IPS"],
        xaxis: {
          categories: ["Bahasa", "IPA", "IPS"],
          tooltip: { enabled: false },
        },
        tooltip: {
          theme: "dark",
        },
        grid: {
          strokeDashArray: 4,
          padding: {
            top: -20,
            right: 0,
            left: -4,
            bottom: -4,
          },
        },
        colors: ["color-mix(in srgb, transparent, var(--tblr-primary) 100%)"],
        yaxis: {
          labels: { padding: 4 },
        },
        legend: {
          show: false,
        },
      };

      const chart = new ApexCharts(this.$refs.kelasChart, options);
      chart.render();
    },
  },
};
</script>
