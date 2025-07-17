<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Tambah Kelas</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <router-link
                :to="{
                  name: 'admin.penjadwalan.index',
                  query: { id_kelas: $route.params.id, nama_kelas: kelas.nama_kelas },
                }"
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
                Penjadwalan</router-link
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
              <form @submit.prevent="submitKelasData">
                <div class="row">
                  <!-- <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Kode</label>
                      <input
                        v-model="kelas.kode_kelas"
                        type="text"
                        class="form-control"
                        placeholder="Kode kelas"
                        name="kode_kelas"
                        required
                      />
                    </div>
                  </div> -->
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Nama</label>
                      <input
                        v-model="kelas.nama_kelas"
                        type="text"
                        class="form-control"
                        placeholder="Nama kelas"
                        name="nama_kelas"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Program</label>
                      <select
                        name="program_kursus_id"
                        id=""
                        class="form-control"
                        v-model="kelas.program_kursus_id"
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
                      <label for="first-name-column">Jumlah Peserta</label>
                      <input
                        v-model="kelas.jumlah_peserta"
                        type="number"
                        class="form-control"
                        placeholder="Jumlah peserta"
                        name="jumlah_peserta"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Tgl. mulai kelas</label>
                      <input
                        v-model="kelas.tgl_mulai"
                        type="date"
                        class="form-control"
                        placeholder="Tgl. mulai"
                        name="tgl_mulai"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Tgl. selesai kelas</label>
                      <input
                        v-model="kelas.tgl_selesai"
                        type="date"
                        class="form-control"
                        placeholder="Tgl. selesai"
                        name="tgl_selesai"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Tgl. pendaftaran</label>
                      <input
                        v-model="kelas.tgl_pendaftaran"
                        type="date"
                        class="form-control"
                        placeholder="Tgl. pendaftaran"
                        name="tgl_pendaftaran"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Tgl. penutupan pendaftaran</label>
                      <input
                        v-model="kelas.tgl_penutupan"
                        type="date"
                        class="form-control"
                        placeholder="Tgl. penutupan pendaftaran"
                        name="tgl_penutupan"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-12 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Deskripsi</label>
                      <textarea
                        id="tinymce-mytextarea"
                        v-model="kelas.deskripsi"
                      ></textarea>
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
                      :to="{ name: 'admin.kelas.index' }"
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
  name: "CreateComponent",
  data() {
    return {
      kelas: {},
      programs: [],
    };
  },
  watch: {},
  mounted() {
    this.fetchProgramData();
    this.fetchKelasData();
  },
  beforeDestroy() {
    if (tinyMCE.get("tinymce-mytextarea")) {
      tinyMCE.get("tinymce-mytextarea").destroy();
    }
  },
  methods: {
    async fetchProgramData() {
      try {
        Loading();
        const response = await axios.get("/v1/program/list", {
          params: this.filtering,
        });
        this.programs = response.data.data;
        this.links = response.data.links;
        this.meta = response.data.meta;
        Swal.close();
      } catch (error) {
        Swal.close();
        AlertMsg(error.response.data.message, true);
      }
    },
    initTinyMCE() {
      tinyMCE.init({
        selector: "#tinymce-mytextarea",
        height: 300,
        menubar: false,
        statusbar: false,
        plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table paste code help wordcount",
        ],
        toolbar:
          "undo redo | formatselect | " +
          "bold italic backcolor | alignleft aligncenter " +
          "alignright alignjustify | bullist numlist outdent indent | " +
          "removeformat",
        content_style:
          "body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }",

        setup: (editor) => {
          editor.on("input", () => {
            this.kelas.deskripsi = editor.getContent();
          });
        },
      });
    },
    submitKelasData() {
      Loading();
      try {
        const formData = new FormData();

        Object.entries(this.kelas).forEach(([key, value]) => {
          if (value !== null && value !== undefined) {
            formData.append(key, value);
          }
        });

        axios
          .post(`/v1/kelas/update/${this.$route.params.id}`, formData)
          .then((response) => {
            const data = response.data;
            AlertMsg(data.message, data.error);
            if (!data.error) {
              this.$router.push({ name: "admin.kelas.index" });
            }
          });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    fetchKelasData() {
      try {
        axios.get(`/v1/kelas/find/${this.$route.params.id}`).then((response) => {
          this.kelas = response.data.data;
          this.$nextTick(() => {
            this.initTinyMCE();
            tinyMCE.on("AddEditor", () => {
              tinyMCE.get("tinymce-mytextarea").setContent(this.kelas.deskripsi || "");
            });
          });
        });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
