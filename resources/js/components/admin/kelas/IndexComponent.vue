<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Kelas</h2>
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
                Kelas</router-link
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
                <div class="d-flex justify-content-end">
                  <div>
                    <form
                      class="d-flex align-items-center"
                      @submit.prevent="fetchKelasData"
                    >
                      <div class="mb-3">
                        <div class="input-group">
                          <input
                            type="text"
                            class="form-control"
                            v-model="filtering.search"
                            placeholder="Search ..."
                          />
                          <button class="btn" type="submit" style="height: 36px">
                            Go!
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
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
                          <th>Max. peserta</th>
                          <th>Actions</th>
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
                          <td style="text-wrap: nowrap">
                            <router-link
                              :to="{
                                name: 'admin.kelas.edit',
                                params: { id: kela.id },
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
                            >
                            <!-- <button
                              @click="deleteKelas(kela.id)"
                              class="btn btn-outline-danger"
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
                            </button> -->
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

export default {
  components: {},
  name: "KelasIndexComponent",
  props: {},
  data() {
    return {
      kelas: [],
      links: {},
      meta: {},
      filtering: {
        search: "",
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
          params: this.filtering,
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
