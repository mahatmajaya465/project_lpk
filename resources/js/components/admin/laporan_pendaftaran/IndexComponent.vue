<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Laporan Pendaftaran</h2>
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
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="d-flex mb-3 justify-content-end">
                <form @submit.prevent="fetchPendaftaranData">
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
              <div class="table-responsive">
                <table class="table table-vcenter table-hover">
                  <thead>
                    <tr class="table-primary">
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama peserta</th>
                      <th>Program</th>
                      <th>Kelas</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(pendaftaran, index) in pendaftarans"
                      :key="pendaftaran.id"
                    >
                      <td>
                        {{
                          meta.current_page * meta.per_page - meta.per_page + index + 1
                        }}
                      </td>
                      <td style="text-wrap: nowrap">
                        {{ pendaftaran.kode_pendaftaran }}
                      </td>
                      <td style="text-wrap: nowrap">
                        {{ pendaftaran.peserta.user.name }}
                      </td>
                      <td style="text-wrap: nowrap">
                        {{ pendaftaran.program.nama_program }}
                      </td>
                      <td style="text-wrap: nowrap">
                        {{ pendaftaran.kelas.nama_kelas }}
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
                      @click="fetchPendaftaranData(meta.current_page - 1)"
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
                    <button class="page-link" @click="fetchPendaftaranData(page)">
                      {{ page }}
                    </button>
                  </li>
                  <li
                    class="page-item"
                    :class="{ disabled: meta.current_page === meta.last_page }"
                  >
                    <button
                      class="page-link"
                      @click="fetchPendaftaranData(meta.current_page + 1)"
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
  name: "IndexPendaftaranComponent",
  data() {
    return {
      pendaftarans: [],
      links: {},
      meta: {},
      filter: {
        search: "",
        periode: "",
      },
    };
  },
  created() {
    this.fetchPendaftaranData();
  },
  computed: {},
  methods: {
    async fetchPendaftaranData(page = 1) {
      Loading();
      this.meta.current_page = page;
      try {
        const response = await axios.get("/v1/pendaftaran/list", {
          params: {
            page: this.meta.current_page,
            per_page: this.meta.per_page,
            ...this.filter
          },
        });

        const data = response.data;

        this.pendaftarans = data.data;
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
