<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Dashboard</h2>
          </div>
          <div class="col-auto ms-auto">
            <div class="input-group">
              <input
                type="month"
                class="form-control"
                v-model="periode"
                @change="fetchTransactionAnalysis"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <section class="row">
          <div class="col-12 col-lg-12">
            <div class="row">
              <!-- Stats Cards -->
              <div class="col-12 col-lg-3 col-md-12" v-if="user.roles === 'super_admin'">
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
                          {{ formatNumber(analysis.peserta_aktif) }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-3 col-md-12" v-if="user.roles === 'super_admin' || user.roles === 'student'">
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
                          {{ formatNumber(analysis.kelas_aktif) }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-3 col-md-12" v-if="user.roles === 'super_admin' || user.roles === 'student'">
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
                          {{ formatCurrency(analysis.pembayaran_diterima) }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>
              <div class="col-12 col-lg-3 col-md-12" v-if="user.roles === 'super_admin' || user.roles === 'instruktur'">
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
                          {{ formatCurrency(analysis.gaji_instruktur) }}
                        </h5>
                      </div>
                    </div>
                  </div>
                </router-link>
              </div>

              <!-- Charts -->
              <div class="col-12 col-lg-6 col-md-12" v-if="user.roles === 'super_admin'">
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

              <!-- Program Table -->
              <div class="col-12 col-lg-6 col-md-12" v-if="user.roles === 'super_admin'">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Peserta dalam Program</h3>
                    <div class="table-responsive">
                      <div
                        class="table-container"
                        style="max-height: 240px; overflow-y: auto"
                      >
                        <table class="table table-vcenter">
                          <tbody>
                            <tr
                              v-for="program in analysis.peserta_per_program"
                              :key="program.nama_program"
                            >
                              <td>
                                <h5>{{ program.nama_program }}</h5>
                                <ul>
                                  <li
                                    v-for="kelas in program.kelas"
                                    :key="kelas.nama_kelas"
                                  >
                                    {{ kelas.nama_kelas }} :
                                    {{ formatNumber(kelas.peserta_count) }} orang
                                  </li>
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
  name: "DashboardComponent",
  data() {
    return {
      periode: new Date().toISOString().slice(0, 7), // Default to current month (YYYY-MM)
      analysis: {
        peserta_aktif: 0,
        kelas_aktif: 0,
        pembayaran_diterima: 0,
        gaji_instruktur: 0,
        peserta_per_kelas: {
          labels: [],
          data: [],
        },
        peserta_per_program: [],
      },
      chart: null,
      user: this.$user
    };
  },
  mounted() {
    this.fetchTransactionAnalysis();
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
        this.renderKelasChart();
        Swal.close();
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    renderKelasChart() {
      // Destroy previous chart if exists
      if (this.chart) {
        this.chart.destroy();
      }

      const options = {
        chart: {
          type: "bar",
          height: 240,
          toolbar: { show: false },
          animations: { enabled: false },
          fontFamily: "inherit",
          parentHeightOffset: 0,
        },
        series: [
          {
            name: "Jumlah Peserta",
            data: this.analysis.peserta_per_kelas.data,
          },
        ],
        xaxis: {
          categories: this.analysis.peserta_per_kelas.labels,
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: false,
          },
        },
        colors: ["#02CC1E"],
        tooltip: {
          y: {
            formatter: (value) => `${this.formatNumber(value)} orang`,
          },
        },
        grid: {
          strokeDashArray: 4,
        },
        yaxis: {
          labels: {
            formatter: (value) => this.formatNumber(value),
          },
        },
      };

      this.chart = new ApexCharts(this.$refs.kelasChart, options);
      this.chart.render();
    },
    formatNumber(value) {
      return new Intl.NumberFormat("id-ID").format(value);
    },
    formatCurrency(value) {
      // Format as currency but remove "Rp" prefix
      const formatted = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
      }).format(value);
      return formatted.replace(/^Rp\s?/, "").trim();
    },
  },
  beforeUnmount() {
    if (this.chart) {
      this.chart.destroy();
    }
  },
};
</script>
