<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Penilaian Peserta</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <button
              @click="saveAllPenilaian"
              class="btn btn-primary"
              :disabled="!penilaians.length"
            >
              Simpan Semua Nilai
            </button>
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
                  @change="fetchMateriByKelas"
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

              <div class="flex-grow-1" style="min-width: 220px">
                <label class="form-label">Materi</label>
                <select
                  v-model="filter.materi_id"
                  class="form-select"
                  :disabled="!filter.kelas_id"
                >
                  <option value="">Semua Materi</option>
                  <option v-for="materi in materis" :key="materi.id" :value="materi.id">
                    {{ materi.nama }}
                  </option>
                </select>
              </div>

              <div class="d-flex align-items-end">
                <button
                  class="btn btn-primary"
                  type="button"
                  @click="fetchPenilaianData"
                  :disabled="loading"
                >
                  <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                  Tampilkan
                </button>
              </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive" v-if="penilaians.length">
              <table class="table table-hover">
                <thead class="table-light">
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Peserta</th>
                    <th width="20%">Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(penilaian, index) in penilaians" :key="penilaian.id">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td>{{ penilaian.user.name }}</td>
                    <td>
                      <input
                        type="number"
                        class="form-control"
                        v-model.number="penilaian.nilai"
                        min="0"
                        max="100"
                        @change="validateNilai(penilaian)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Empty State -->
            <div class="text-center py-5" v-else>
              <div class="mb-3">
                <i class="fas fa-clipboard-list fa-3x text-muted"></i>
              </div>
              <h5 class="text-muted">Tidak ada data penilaian</h5>
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
  name: "PenilaianIndexComponent",
  data() {
    return {
      penilaians: [],
      programs: [],
      kelases: [],
      filteredKelases: [],
      materis: [],
      filter: {
        program_id: "",
        kelas_id: "",
        materi_id: "",
        search: "",
      },
      loading: false,
      saving: false,
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
        AlertMsg("Gagal memuat data program", true);
      }
    },

    async fetchKelasData() {
      try {
        const response = await axios.get("/v1/kelas/list");
        this.kelases = response.data.data;
      } catch (error) {
        AlertMsg("Gagal memuat data kelas", true);
      }
    },

    fetchKelasByProgram() {
      if (!this.filter.program_id) {
        this.filteredKelases = this.kelases;
        this.filter.kelas_id = "";
        this.filter.materi_id = "";
        this.materis = [];
        return;
      }
      this.filteredKelases = this.kelases.filter(
        (kelas) => kelas.program.id == this.filter.program_id
      );
      this.filter.kelas_id = "";
      this.filter.materi_id = "";
      this.materis = [];
    },

    async fetchMateriByKelas() {
      if (!this.filter.kelas_id) {
        this.filter.materi_id = "";
        this.materis = [];
        return;
      }
      try {
        const response = await axios.get("/v1/materi/list", {
          params: { kelas_id: this.filter.kelas_id },
        });
        this.materis = response.data.data;
      } catch (error) {
        AlertMsg("Gagal memuat data materi", true);
      }
    },

    async fetchPenilaianData(page = 1) {
      this.loading = true;

      try {
        const response = await axios.get("/v1/penilaian/list", {
          params: {
            ...this.filter,
          },
        });

        const data = response.data;
        this.penilaians = data.map((p) => ({
          ...p,
          originalNilai: p.nilai, // Simpan nilai original untuk comparison
        }));
      } catch (error) {
        AlertMsg("Gagal memuat data penilaian", true);
      } finally {
        this.loading = false;
      }
    },

    validateNilai(penilaian) {
      if (penilaian.nilai < 0) penilaian.nilai = 0;
      if (penilaian.nilai > 100) penilaian.nilai = 100;
    },

    async savePenilaian(penilaian) {
      Loading();
      if (penilaian.nilai === penilaian.originalNilai) return;

      this.saving = true;
      try {
        await axios.post(`/v1/penilaian/update/${penilaian.id}`, {
          nilai: penilaian.nilai,
        });
        penilaian.originalNilai = penilaian.nilai;
        AlertMsg("Nilai berhasil disimpan");
      } catch (error) {
        AlertMsg("Gagal menyimpan nilai, silakan coba lagi", true);
      } finally {
        this.saving = false;
        Swal.close();
      }
    },

    async saveAllPenilaian() {
      Loading();
      const changedPenilaians = this.penilaians.filter(
        (p) => p.nilai !== p.originalNilai
      );

      if (!changedPenilaians.length) {
        AlertMsg("Tidak ada perubahan nilai yang perlu disimpan", true);
        return;
      }

      this.saving = true;
      try {
        await axios.post("/v1/penilaian/update-batch", {
          penilaians: changedPenilaians.map((p) => ({
            id: p.id,
            nilai: p.nilai,
          })),
        });

        // Update original values
        changedPenilaians.forEach((p) => {
          p.originalNilai = p.nilai;
        });

        AlertMsg("Semua nilai berhasil disimpan");
      } catch (error) {
        AlertMsg("Gagal menyimpan nilai, silakan coba lagi", true);
      } finally {
        this.saving = false;
        Swal.close();
      }
    },
  },
};
</script>

<style scoped>
.table th {
  vertical-align: middle;
}
.form-control {
  text-align: center;
}
</style>
