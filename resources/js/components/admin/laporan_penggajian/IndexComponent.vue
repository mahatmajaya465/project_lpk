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
              <router-link
                :to="{ name: 'admin.pendaftaran.create' }"
                class="btn btn-primary d-none d-sm-inline-block"
              >
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
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
                Cetak Laporan</router-link
              >
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
                      <input
                        type="month"
                        class="form-control"
                        v-model="filter.periode"
                      />
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
      }
    },
  },
};
</script>
