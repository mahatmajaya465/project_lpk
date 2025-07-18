<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Edit Program</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form @submit.prevent="submitProgramData">
                <div class="row">
                  <!-- <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Kode</label>
                      <input
                        v-model="program.kode_program"
                        type="text"
                        class="form-control"
                        placeholder="Kode program"
                        name="kode_program"
                        required
                      />
                    </div>
                  </div> -->
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Program</label>
                      <input
                        v-model="program.nama_program"
                        type="text"
                        class="form-control"
                        placeholder="Nama program"
                        name="nama_program"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Harga</label>
                      <input
                        v-model="program.harga"
                        type="number"
                        class="form-control"
                        placeholder="Harga program"
                        name="harga"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Status</label>
                      <select
                        name="status"
                        id="status"
                        v-model="program.status"
                        class="form-control"
                      >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Thumbnail</label>
                      <div class="input-group">
                        <input
                          type="file"
                          class="form-control"
                          placeholder="Thumbnail program"
                          name="thumbnail"
                          @change="handleFileUpload"
                        />
                        <template v-if="program.thumbnail">
                          <a
                            :href="program.thumbnail"
                            target="_blank"
                            class="input-group-text"
                            title="Lihat Avatar"
                          >
                            <!-- Tabler Eye Icon -->
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="icon icon-tabler icon-tabler-eye"
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              stroke-width="1.5"
                              stroke="#2c3e50"
                              fill="none"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            >
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <circle cx="12" cy="12" r="2" />
                              <path
                                d="M22 12c0 5.523 -4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10s10 4.477 10 10z"
                              />
                            </svg>
                          </a>
                        </template>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Deskripsi</label>
                      <textarea
                        id="tinymce-mytextarea"
                        v-model="program.deskripsi"
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
                      :to="{ name: 'admin.program.index' }"
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
  name: "EditComponent",
  data() {
    return {
      program: {},
      thumbnail: null,
    };
  },
  watch: {},
  mounted() {
    this.fetchProgramData();
  },
  beforeDestroy() {
    if (tinyMCE.get("tinymce-mytextarea")) {
      tinyMCE.get("tinymce-mytextarea").destroy();
    }
  },
  methods: {
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
            this.program.deskripsi = editor.getContent();
          });
        },
      });
    },
    handleFileUpload(event) {
      this.thumbnail = event.target.files[0];
    },
    fetchProgramData() {
      try {
        axios.get(`/v1/program/find/${this.$route.params.id}`).then((response) => {
          this.program = response.data.data;
          this.$nextTick(() => {
            this.initTinyMCE();
            tinyMCE.on("AddEditor", () => {
              tinyMCE.get("tinymce-mytextarea").setContent(this.program.deskripsi || "");
            });
          });
        });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    submitProgramData() {
      Loading();
      try {
        const formData = new FormData();

        Object.entries(this.program).forEach(([key, value]) => {
          if (value !== null && value !== undefined) {
            formData.append(key, value);
          }
        });

        if (this.thumbnail !== null) {
          formData.append("thumbnail", this.thumbnail);
        }

        axios
          .post(`/v1/program/update/${this.$route.params.id}`, formData)
          .then((response) => {
            const data = response.data;
            AlertMsg(data.message, data.error);
            if (!data.error) {
              this.$router.push({ name: "admin.program.index" });
            }
          });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
