<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Laporan Kelas</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <router-link
                :to="{ name: 'admin.kelas.create' }"
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
                  <form @submit.prevent="fetchKelasData">
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
                          <th>Kode</th>
                          <th>Nama</th>
                          <th>Program</th>
                          <th>Tgl. mulai</th>
                          <th>Tgl. selesai</th>
                          <th>Jml. peserta</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="kela in kelas" :key="kela.id">
                          <td style="text-wrap: nowrap">
                            <b>{{ kela.kode_kelas }}</b>
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ kela.nama_kelas }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ kela.program.nama_program }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ kela.tgl_mulai_indo }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ kela.tgl_selesai_indo }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ kela.jumlah_peserta }} orang
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
                          @click="fetchKelasData(meta.current_page - 1)"
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
                        <button class="page-link" @click="fetchKelasData(page)">
                          {{ page }}
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{ disabled: meta.current_page === meta.last_page }"
                      >
                        <button
                          class="page-link"
                          @click="fetchKelasData(meta.current_page + 1)"
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
import { filter } from "lodash";

export default {
  components: {},
  name: "KelasIndexComponent",
  props: {},
  data() {
    return {
      kelas: [],
      links: {},
      meta: {},
      filter: {
        search: "",
        periode: "",
      },
    };
  },
  created() {
    this.fetchKelasData();
  },
  methods: {
    truncateText,
    async fetchKelasData() {
      try {
        Loading();
        const response = await axios.get("/v1/kelas/list", {
          params: {
            ...this.filter,
          },
        });
        this.kelas = response.data.data;
        this.links = response.data.links;
        this.meta = response.data.meta;
        Swal.close();
      } catch (error) {
        Swal.close();
        AlertMsg(error.response.data.message, true);
      }
    },
    deleteKelas(id) {
      Swal.fire({
        title: "Hapus data?",
        text: "Data yang dihapus tidak dapat dipulihkan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post(`/v1/kelas/delete/${id}`, {
              id: id,
            })
            .then((response) => {
              const data = response.data;
              AlertMsg(data.message, data.error);
              if (!data.error) {
                this.fetchKelasData();
              }
            })
            .catch((error) => {
              AlertMsg(error.response.data.message, true);
            });
        }
      });
    },
  },
};
</script>
