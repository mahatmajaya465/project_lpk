<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Jadwal Kelas {{ $route.query.nama_kelas }}</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <button
                class="btn btn-primary d-none d-sm-inline-block"
                @click="showModalPenjadwalan"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="icon"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  stroke-width="2"
                  stroke="currentColor"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M12 5l0 14" />
                  <path d="M5 12l14 0" />
                </svg>
                Jadwal
              </button>
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
                <div class="table-container">
                  <div class="table-responsive">
                    <table class="table table-vcenter table-hover">
                      <thead>
                        <tr class="table-primary">
                          <th>Tgl. mulai</th>
                          <th>Tgl. selesai</th>
                          <th>Materi</th>
                          <th>Instruktur</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="jadwal in jadwals" :key="jadwal.id">
                          <td style="text-wrap: nowrap">
                            {{ jadwal.tgl_mulai }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ jadwal.tgl_selesai }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ jadwal.materi.nama }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ jadwal.instruktur.user.name }}
                          </td>
                          <td style="text-wrap: nowrap">
                            <!-- <router-link
                              :to="{
                                name: 'admin.kelas.edit',
                                params: { id: jadwal.id },
                              }"
                              class="btn btn-outline-primary"
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
                                class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"
                              >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                  d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"
                                />
                                <path d="M13.5 6.5l4 4" />
                              </svg>
                              Edit</router-link
                            > -->
                            <button
                              @click="deleteJadwal(jadwal.id)"
                              class="btn btn-outline-danger"
                              v-if="jadwal.can_delete"
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
                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash"
                              >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path
                                  d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"
                                />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                              </svg>
                              Hapus
                            </button>
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
                          @click="fetchJadwalData(meta.current_page - 1)"
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
                        <button class="page-link" @click="fetchJadwalData(page)">
                          {{ page }}
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{ disabled: meta.current_page === meta.last_page }"
                      >
                        <button
                          class="page-link"
                          @click="fetchJadwalData(meta.current_page + 1)"
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

    <!-- modal -->
    <div
      class="modal modal-blur fade show"
      style="display: block"
      tabindex="-1"
      role="dialog"
      v-if="showModal"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Penjadwalan</h5>
            <button type="button" class="btn-close" @click="showModal = false"></button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input
                  type="datetime-local"
                  class="form-control"
                  v-model="penjadwalan.tgl_mulai"
                  required
                />
              </div>

              <div class="mb-3">
                <label class="form-label">Tanggal Selesai</label>
                <input
                  type="datetime-local"
                  class="form-control"
                  v-model="penjadwalan.tgl_selesai"
                  required
                />
              </div>

              <div class="mb-3">
                <label class="form-label">Materi</label>
                <select class="form-control" v-model="penjadwalan.materi_id" required>
                  <option value="" disabled selected>Pilih materi</option>
                  <option v-for="materi in materis" :key="materi.id" :value="materi.id">
                    {{ materi.nama }}
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Instruktur</label>
                <select class="form-control" v-model="penjadwalan.instruktur_id" required>
                  <option value="" disabled selected>Pilih instruktur</option>
                  <option
                    v-for="instruktur in instrukturs"
                    :key="instruktur.id"
                    :value="instruktur.id"
                  >
                    {{ instruktur.user.name }}
                  </option>
                </select>
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-link" @click="showModal = false">
              Tutup
            </button>
            <button type="button" class="btn btn-primary" @click="submitForm">
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { truncateText } from "../../../utils/truncateText";

export default {
  components: {},
  name: "JadwalIndexComponent",
  props: {},
  data() {
    return {
      jadwals: [],
      penjadwalan: {},
      links: {},
      meta: {},
      materis: [],
      instruktur: [],
      filtering: {
        search: "",
      },
      showModal: false,
    };
  },
  created() {
    this.fetchInstrukturData();
    this.fetchMateriData();
    this.fetchJadwalData();
  },
  methods: {
    truncateText,
    showModalPenjadwalan() {
      this.showModal = true;
      this.penjadwalan = {
        tgl_mulai: "",
        tgl_selesai: "",
        materi_id: "",
        instruktur_id: "",
      };
    },
    async fetchInstrukturData(page = 1) {
      this.meta.current_page = page;
      try {
        const response = await axios.get("/v1/instruktur/list", {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            search: this.searchQuery,
          },
        });

        const data = response.data;

        this.instrukturs = data.data;
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    async fetchMateriData(page = 1) {
      this.meta.current_page = page;

      try {
        const response = await axios.get("/v1/materi/list", {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            ...this.filtering,
          },
        });
        this.materis = response.data.data;
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    submitForm() {
      if (!this.penjadwalan.tgl_mulai || !this.penjadwalan.tgl_selesai || !this.penjadwalan.materi_id || !this.penjadwalan.instruktur_id) {
        AlertMsg("Tanggal mulai dan selesai harus diisi", true);
        return;
      }
      axios
        .post("/v1/penjadwalan/store", {
          ...this.penjadwalan,
          kelas_kursus_id: this.$route.query.id_kelas,
        })
        .then((response) => {
          const data = response.data;
          AlertMsg(data.message, data.error);
          if (!data.error) {
            this.fetchJadwalData();
            this.showModal = false;
          }
        })
        .catch((error) => {
          AlertMsg(error.response.data.message, true);
        });
    },
    async fetchJadwalData() {
      try {
        Loading();
        const response = await axios.get("/v1/penjadwalan/list", {
          params: {
            ...this.filtering,
            kelas_kursus_id: this.$route.query.id_kelas,
          },
        });
        this.jadwals = response.data.data;
        this.links = response.data.links;
        this.meta = response.data.meta;
        Swal.close();
      } catch (error) {
        Swal.close();
        AlertMsg(error.response.data.message, true);
      }
    },
    deleteJadwal(id) {
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
            .post(`/v1/penjadwalan/delete/${id}`, {
              id: id,
            })
            .then((response) => {
              const data = response.data;
              AlertMsg(data.message, data.error);
              if (!data.error) {
                this.fetchJadwalData();
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
