<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Tambah Pendaftaran</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" @submit.prevent="submitPendaftaranData">
                <div class="row">
                  <!-- <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Kode Pendaftaran</label>
                      <input
                        v-model="pendaftaran.kode_pendaftaran"
                        type="text"
                        class="form-control"
                        placeholder="Kode pendaftaran"
                        name="name"
                        required
                      />
                    </div>
                  </div> -->
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Peserta</label>
                      <select
                        v-model="pendaftaran.peserta_id"
                        name="peserta_id"
                        id="peserta_id"
                        class="form-control"
                        :readonly="user.roles == 'student'"
                        required
                      >
                        <option
                          v-for="peserta in pesertas"
                          :key="peserta.id"
                          :value="peserta.id"
                        >
                          {{ peserta.user.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Program Kursus</label>
                      <select
                        v-model="pendaftaran.program_kursus_id"
                        name="program_kursus_id"
                        id="program_kursus_id"
                        class="form-control"
                        required
                      >
                        <option
                          v-for="program in programs"
                          :key="program.id"
                          :value="program.id"
                        >
                          {{ program.nama_program }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Kelas Kursus</label>
                      <select
                        v-model="pendaftaran.kelas_kursus_id"
                        name="kelas_kursus_id"
                        id="kelas_kursus_id"
                        class="form-control"
                        required
                      >
                        <option v-for="kela in kelas" :key="kela.id" :value="kela.id">
                          {{ kela.nama_kelas }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary me-1 mb-1">
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
                        class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"
                      >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                          d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
                        />
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M14 4l0 4l-6 0l0 -4" />
                      </svg>
                      Simpan
                    </button>
                    <router-link
                      class="btn btn-light-secondary me-1 mb-1"
                      :to="{ name: 'admin.pendaftaran.index' }"
                      >Kembali</router-link
                    >
                  </div>
                </div>
              </form>
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
  name: "CreatePendaftaranComponent",
  data() {
    return {
      pendaftaran: {},
      pesertas: [],
      programs: [],
      kelas: [],
      user: this.$user,
    };
  },
  mounted() {
    this.fetchPesertaData();
    this.fetchKelasData();
    this.fetchProgramData();
  },
  methods: {
    async fetchPesertaData(page = 1) {
      try {
        const response = await axios.get("/v1/peserta/list", {
          params: {},
        });

        const data = response.data;

        this.pesertas = data.data;

        if (this.user.roles === "student") {
          this.pendaftaran.peserta_id = this.pesertas.find(
            (peserta) => peserta.user_id == this.user.id
          ).id;
        }
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    async fetchKelasData() {
      try {
        const response = await axios.get("/v1/kelas/list", {
          params: {},
        });
        this.kelas = response.data.data;
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    async fetchProgramData() {
      try {
        const response = await axios.get("/v1/program/list", {
          params: {},
        });
        this.programs = response.data.data;
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    async submitPendaftaranData() {
      Loading();
      try {
        const formData = new FormData();

        Object.entries(this.pendaftaran).forEach(([key, value]) => {
          if (value !== null && value !== undefined) {
            formData.append(key, value);
          }
        });

        const response = await axios.post("/v1/pendaftaran/store", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        AlertMsg(response.data.message, false);
        this.$router.push({ name: "admin.pendaftaran.index" });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
