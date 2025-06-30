<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Tambah Materi</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form @submit.prevent="submitMateriData">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Kode</label>
                      <input
                        v-model="materi.kode_materi"
                        type="text"
                        class="form-control"
                        placeholder="Kode materi"
                        name="kode_materi"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Nama</label>
                      <input
                        v-model="materi.nama"
                        type="text"
                        class="form-control"
                        placeholder="Nama materi"
                        name="nama"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Kategori</label>
                      <select
                        name="kategori"
                        id="kategori"
                        v-model="materi.kategori"
                        class="form-control"
                      >
                        <option value="Program Perkantoran">Program Perkantoran</option>
                        <option value="Desain Grafis">Desain Grafis</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Silabus</label>
                      <div class="input-group">
                        <input
                          type="file"
                          class="form-control"
                          placeholder="silabus materi"
                          name="silabus"
                          @change="handleFileUpload"
                        />
                        <div class="input-group-append" v-if="materi.silabus_url">
                          <a
                            target="_blank"
                            :href="materi.silabus_url"
                            class="btn"
                            style="height: 36px"
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
                              class="icon icon-tabler icons-tabler-outline icon-tabler-photo"
                            >
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M15 8h.01" />
                              <path
                                d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"
                              />
                              <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                              <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Deskripsi</label>
                      <textarea
                        id="tinymce-mytextarea"
                        v-model="materi.deskripsi"
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
                      :to="{ name: 'admin.materi.index' }"
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
  name: "MateriCreateComponent",
  data() {
    return {
      materi: {},
      silabus: null,
    };
  },
  watch: {},
  mounted() {
    this.initTinyMCE();
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
            this.materi.deskripsi = editor.getContent();
          });
        },
      });
    },
    handleFileUpload(event) {
      this.silabus = event.target.files[0];
    },
    submitMateriData() {
      Loading();
      try {
        const formData = new FormData();

        Object.entries(this.materi).forEach(([key, value]) => {
          if (value !== null && value !== undefined) {
            formData.append(key, value);
          }
        });

        if (this.silabus !== null) {
          formData.append("silabus", this.silabus);
        }

        axios.post("/v1/materi/store", formData).then((response) => {
          const data = response.data;
          AlertMsg(data.message, data.error);
          if (!data.error) {
            this.$router.push({ name: "admin.materi.index" });
          }
        });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
