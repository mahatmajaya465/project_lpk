<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Laporan Penggajian</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <a
                href="#"
                @click.prevent="printReport"
                class="btn btn-primary d-none d-sm-inline-block"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path
                    d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"
                  />
                  <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                  <path
                    d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"
                  />
                </svg>
                Cetak Laporan
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <section class="row">
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex mb-3 justify-content-end">
                  <form @submit.prevent="fetchAllPenggajianData">
                    <div class="input-group">
                      <input type="month" class="form-control" v-model="filter.periode" />
                      <button class="btn" type="submit" style="height: 36px">Go!</button>
                    </div>
                  </form>
                </div>
                <div class="table-container">
                  <div class="table-responsive">
                    <table class="table table-vcenter table-hover">
                      <thead>
                        <tr class="table-primary">
                          <th>Instruktur</th>
                          <th>Periode</th>
                          <th>Total Jam kerja</th>
                          <th>Gaji</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="instruktur in instrukturs" :key="instruktur.id">
                          <td style="text-wrap: nowrap">
                            {{ instruktur.user.name }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ instruktur.penggajian?.periode || "-" }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ instruktur.penggajian?.total_jam || "0" }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ formatCurrency(instruktur.penggajian?.gaji || 0) }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                      <li
                        class="page-item"
                        :class="{ disabled: meta.current_page === 1 }"
                      >
                        <button
                          class="page-link"
                          @click="fetchInstrukturData(meta.current_page - 1)"
                        >
                          Previous
                        </button>
                      </li>
                      <li
                        v-for="page in meta.last_page"
                        :key="page"
                        class="page-item"
                        :class="{ active: page === meta.current_page }"
                      >
                        <button class="page-link" @click="fetchInstrukturData(page)">
                          {{ page }}
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{ disabled: meta.current_page === meta.last_page }"
                      >
                        <button
                          class="page-link"
                          @click="fetchInstrukturData(meta.current_page + 1)"
                        >
                          Next
                        </button>
                      </li>
                    </ul>
                  </nav>
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
import { truncateText } from "../../../utils/truncateText";

export default {
  components: {},
  name: "PenggajianIndexComponent",
  props: {},
  data() {
    return {
      instrukturs: [],
      meta: {
        current_page: 1,
        per_page: 10,
        last_page: 1,
      },
      filter: {
        search: "",
        periode: new Date().toISOString().slice(0, 7), // Default current month YYYY-MM
      },
    };
  },
  created() {
    this.fetchInstrukturData();
  },
  methods: {
    truncateText,
    printReport() {
      // Buat window baru
      const printWindow = window.open("", "_blank");

      // Format periode untuk tampilan
      const formatPeriode = (periode) => {
        if (!periode) return "-";
        const [year, month] = periode.split("-");
        const monthNames = [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus",
          "September",
          "Oktober",
          "November",
          "Desember",
        ];
        return `${monthNames[parseInt(month) - 1]} ${year}`;
      };

      // Hitung total gaji semua instruktur
      const totalGaji = this.instrukturs.reduce((sum, instruktur) => {
        return sum + (instruktur.penggajian?.gaji || 0);
      }, 0);

      // Ambil HTML yang ingin dicetak
      const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
          <title>Laporan Penggajian</title>
          <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .report-header { text-align: center; margin-bottom: 20px; }
            .report-title { font-size: 18px; font-weight: bold; }
            .report-period { font-size: 14px; margin-bottom: 10px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; font-weight: bold; }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .page-break { page-break-after: always; }
            .footer { margin-top: 20px; display: flex; justify-content: space-between; }
            .total-row { font-weight: bold; background-color: #f8f9fa; }
          </style>
        </head>
        <body>
          <div class="report-header">
            <div class="report-title">LAPORAN PENGAJIAN INSTRUKTUR</div>
            ${
              this.filter.periode
                ? `<div class="report-period">Periode: ${formatPeriode(
                    this.filter.periode
                  )}</div>`
                : ""
            }
          </div>
          
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Instruktur</th>
                <th>Periode</th>
                <th class="text-right">Total Jam Kerja</th>
                <th class="text-right">Gaji</th>
              </tr>
            </thead>
            <tbody>
              ${this.instrukturs
                .map(
                  (instruktur, index) => `
                <tr>
                  <td class="text-center">${index + 1}</td>
                  <td>${instruktur.user.name}</td>
                  <td>${formatPeriode(instruktur.penggajian?.periode)}</td>
                  <td class="text-right">${
                    instruktur.penggajian?.total_jam || "0"
                  } jam</td>
                  <td class="text-right">${this.formatCurrency(
                    instruktur.penggajian?.gaji || 0
                  )}</td>
                </tr>
              `
                )
                .join("")}
              <tr class="total-row">
                <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>${this.formatCurrency(
                  totalGaji
                )}</strong></td>
              </tr>
            </tbody>
          </table>
          
          <div class="footer">
            <div>Total Instruktur: ${this.instrukturs.length}</div>
            <div>Dicetak pada: ${new Date().toLocaleString("id-ID")}</div>
          </div>
        </body>
        </html>
      `;

      // Tulis konten ke window baru
      printWindow.document.open();
      printWindow.document.write(printContent);
      printWindow.document.close();

      // Tunggu konten dimuat lalu cetak
      printWindow.onload = function () {
        setTimeout(() => {
          printWindow.print();
          // printWindow.close(); // Opsional: tutup window setelah cetak
        }, 500);
      };
    },
    formatCurrency(value) {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
      }).format(value);
    },
    async fetchInstrukturData(page = 1) {
      Loading();
      this.meta.current_page = page;
      try {
        const response = await axios.get("/v1/instruktur/list", {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            search: this.filter.search,
          },
        });

        const data = response.data;
        this.instrukturs = data.data;
        this.links = data.links;
        this.meta = data.meta;

        // Fetch penggajian data for each instruktur
        await this.fetchAllPenggajianData();

        Swal.close();
      } catch (error) {
        Swal.close();
        AlertMsg(error.response.data.message, true);
      }
    },
    async fetchAllPenggajianData() {
      try {
        const promises = this.instrukturs.map((instruktur) =>
          this.fetchPenggajianData(instruktur.id)
        );
        await Promise.all(promises);
      } catch (error) {
        console.error("Error fetching penggajian data:", error);
        AlertMsg("Gagal memuat data penggajian", true);
      }
    },
    async fetchPenggajianData(instrukturId) {
      try {
        const response = await axios.get("/v1/penggajian/gajiInstruktur", {
          params: {
            ...this.filter,
            instruktur_id: instrukturId,
          },
        });

        const instruktur = this.instrukturs.find((i) => i.id === instrukturId);
        if (instruktur) {
          this.$set(instruktur, "penggajian", {
            periode: response.data.periode,
            total_jam: response.data.total_jam,
            gaji: response.data.gaji,
            jadwals: response.data.jadwals,
            absensi: response.data.complete_absensi,
          });
        }
      } catch (error) {
        console.error(`Error fetching penggajian for instruktur ${instrukturId}:`, error);
        AlertMsg(`Gagal memuat data penggajian untuk instruktur ${instrukturId}`, true);
      }
    },
  },
};
</script>
