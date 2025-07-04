<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Laporan Pembayaran</h2>
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
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="d-flex mb-3 justify-content-end">
                <form @submit.prevent="fetchPembayaranData">
                  <div class="input-group">
                    <input type="month" class="form-control" v-model="filter.periode" />
                    <button class="btn" type="submit" style="height: 36px">Go!</button>
                  </div>
                </form>
              </div>
              <div class="table-responsive">
                <table class="table table-vcenter table-hover">
                  <thead>
                    <tr class="table-primary">
                      <th>No</th>
                      <th>Kode</th>
                      <th>Tgl. pembayaran</th>
                      <th>Nama peserta</th>
                      <th>Kelas</th>
                      <th>Program</th>
                      <th>Nominal</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(pembayaran, index) in pembayarans" :key="pembayaran.id">
                      <td>
                        {{
                          meta.current_page * meta.per_page - meta.per_page + index + 1
                        }}
                      </td>
                      <td style="text-wrap: nowrap">{{ pembayaran.kode_pembayaran }}</td>
                      <td style="text-wrap: nowrap">{{ pembayaran.tgl_pembayaran }}</td>
                      <td style="text-wrap: nowrap">
                        {{ pembayaran.pendaftaran.peserta.user.name }}
                      </td>
                      <td style="text-wrap: nowrap">
                        {{ pembayaran.pendaftaran.kelas.nama_kelas }}
                      </td>
                      <td style="text-wrap: nowrap">
                        {{ pembayaran.pendaftaran.program.nama_program }}
                      </td>
                      <td style="text-wrap: nowrap">{{ pembayaran.nominal_rp }}</td>
                      <td style="text-wrap: nowrap">
                        {{ pembayaran.status_strtoupper }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                  <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
                    <button
                      class="page-link"
                      @click="fetchPembayaranData(meta.current_page - 1)"
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
                    <button class="page-link" @click="fetchPembayaranData(page)">
                      {{ page }}
                    </button>
                  </li>
                  <li
                    class="page-item"
                    :class="{ disabled: meta.current_page === meta.last_page }"
                  >
                    <button
                      class="page-link"
                      @click="fetchPembayaranData(meta.current_page + 1)"
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
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  components: {},
  name: "IndexPembayaranComponent",
  data() {
    return {
      pembayarans: [],
      links: {},
      meta: {},
      filter: {
        search: "",
        periode: "",
        status: "settlement",
      },
    };
  },
  created() {
    this.fetchPembayaranData();
  },
  computed: {},
  methods: {
    printReport() {
      // Buat window baru
      const printWindow = window.open("", "_blank");

      // Format nominal untuk print
      const formatNominal = (nominal) => {
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR",
          minimumFractionDigits: 0,
        })
          .format(nominal)
          .replace("Rp", "Rp ");
      };

      // Ambil HTML yang ingin dicetak
      const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
          <title>Laporan Pembayaran</title>
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
          </style>
        </head>
        <body>
          <div class="report-header">
            <div class="report-title">LAPORAN PEMBAYARAN</div>
            ${
              this.filter.periode
                ? `<div class="report-period">Periode: ${this.filter.periode}</div>`
                : ""
            }
          </div>
          
          <table>
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Kode</th>
                <th>Tgl. Pembayaran</th>
                <th>Nama Peserta</th>
                <th>Kelas</th>
                <th>Program</th>
                <th class="text-right">Nominal</th>
                <th class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              ${this.pembayarans
                .map(
                  (pembayaran, index) => `
                <tr>
                  <td class="text-center">${
                    this.meta.current_page * this.meta.per_page -
                    this.meta.per_page +
                    index +
                    1
                  }</td>
                  <td>${pembayaran.kode_pembayaran}</td>
                  <td>${pembayaran.tgl_pembayaran}</td>
                  <td>${pembayaran.pendaftaran.peserta.user.name}</td>
                  <td>${pembayaran.pendaftaran.kelas.nama_kelas}</td>
                  <td>${pembayaran.pendaftaran.program.nama_program}</td>
                  <td class="text-right">${formatNominal(pembayaran.nominal)}</td>
                  <td class="text-center">${pembayaran.status_strtoupper}</td>
                </tr>
              `
                )
                .join("")}
            </tbody>
          </table>
          
          <div class="footer">
            <div>Total Data: ${this.meta.total}</div>
            <div>Dicetak pada: ${new Date().toLocaleString()}</div>
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
    async fetchPembayaranData(page = 1) {
      Loading();
      this.meta.current_page = page;
      try {
        const response = await axios.get("/v1/pembayaran/list", {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            ...this.filter,
          },
        });

        const data = response.data;

        this.pembayarans = data.data;
        this.links = data.links;
        this.meta = data.meta;
        Swal.close();
      } catch (error) {
        Swal.close();
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
