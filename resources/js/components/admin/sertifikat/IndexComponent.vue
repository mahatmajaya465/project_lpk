<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Sertifikat</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-body">
            <!-- Filter Section -->
            <div class="d-flex mb-3 gap-3 align-items-end flex-wrap">
              <div class="flex-grow-1" style="min-width: 220px">
                <label class="form-label">Program</label>
                <select
                  v-model="filter.program_id"
                  class="form-select"
                  @change="fetchKelasByProgram"
                >
                  <option value="">Semua Program</option>
                  <option
                    v-for="program in programs"
                    :key="program.id"
                    :value="program.id"
                  >
                    {{ program.nama_program }}
                  </option>
                </select>
              </div>

              <div class="flex-grow-1" style="min-width: 220px">
                <label class="form-label">Kelas</label>
                <select
                  v-model="filter.kelas_id"
                  class="form-select"
                  :disabled="!filter.program_id"
                >
                  <option value="">Semua Kelas</option>
                  <option
                    v-for="kelas in filteredKelases"
                    :key="kelas.id"
                    :value="kelas.id"
                  >
                    {{ kelas.nama_kelas }}
                  </option>
                </select>
              </div>

              <div class="d-flex align-items-end">
                <button
                  class="btn btn-primary"
                  @click="fetchSertifikatData"
                  :disabled="loading"
                >
                  <span
                    v-if="loading"
                    class="spinner-border spinner-border-sm me-1"
                  ></span>
                  Filter
                </button>
              </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive" v-if="sertifikats.length">
              <table class="table table-hover">
                <thead class="table-light">
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Peserta</th>
                    <th>Program</th>
                    <th>Kelas</th>
                    <th width="10%">Nilai</th>
                    <th width="20%">Keterangan</th>
                    <th width="15%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(sertifikat, index) in sertifikats" :key="sertifikat.id">
                    <td class="text-center">
                      {{ index + 1 }}
                    </td>
                    <td>{{ sertifikat.user.name }}</td>
                    <td>{{ sertifikat.program.nama_program }}</td>
                    <td>{{ sertifikat.kelas.nama_kelas }}</td>
                    <td class="text-center">{{ sertifikat.rata_rata_nilai || "-" }}</td>
                    <td class="text-center">{{ sertifikat.keterangan || "-" }}</td>
                    <td class="text-center">
                      <button
                        class="btn btn-sm btn-primary"
                        @click="
                          downloadSertifikat(sertifikat.program.id, sertifikat.kelas.id)
                        "
                        :disabled="loading"
                      >
                        <i class="fas fa-download me-1"></i>Download
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Empty State -->
            <div class="text-center py-5" v-else>
              <div class="mb-3">
                <i class="fas fa-file-certificate fa-3x text-muted"></i>
              </div>
              <h5 class="text-muted">Tidak ada data sertifikat</h5>
              <p class="text-muted">Silakan pilih filter untuk menampilkan data</p>
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
  name: "SertifikatIndexComponent",
  data() {
    return {
      sertifikats: [],
      programs: [],
      kelases: [],
      filteredKelases: [],
      filter: {
        program_id: "",
        kelas_id: "",
        search: "",
      },
      loading: false,
    };
  },
  created() {
    this.fetchProgramData();
    this.fetchKelasData();
  },
  methods: {
    async fetchProgramData() {
      try {
        const response = await axios.get("/v1/program/list");
        this.programs = response.data.data;
      } catch (error) {
        this.showError("Gagal memuat data program");
      }
    },

    async fetchKelasData() {
      try {
        const response = await axios.get("/v1/kelas/list");
        this.kelases = response.data.data;
        this.filteredKelases = this.kelases;
      } catch (error) {
        this.showError("Gagal memuat data kelas");
      }
    },

    fetchKelasByProgram() {
      if (!this.filter.program_id) {
        this.filteredKelases = this.kelases;
        this.filter.kelas_id = "";
        return;
      }
      this.filteredKelases = this.kelases.filter(
        (kelas) => kelas.program_kursus_id == this.filter.program_id
      );
      this.filter.kelas_id = "";
    },

    async fetchSertifikatData(page = 1) {
      this.loading = true;

      try {
        const response = await axios.get("/v1/sertifikat/list", {
          params: {
            ...this.filter,
          },
        });

        const data = response.data;
        this.sertifikats = data.data;
        this.meta = data.meta;
      } catch (error) {
        this.showError("Gagal memuat data sertifikat");
      } finally {
        this.loading = false;
      }
    },

    async downloadSertifikat(programId, kelasId) {
      location.href = `/v1/sertifikat/download/${programId}?kelas_id=${kelasId}&program_id=${programId}`;
    },

    showError(message) {
      this.$swal({
        icon: "error",
        title: "Oops...",
        text: message,
        timer: 3000,
      });
    },
  },
};
</script>

<style scoped>
.table th {
  vertical-align: middle;
}
</style>
