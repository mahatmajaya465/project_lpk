<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Tambah Intruktur</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" @submit.prevent="submitInstrukturData">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Nama</label>
                      <input
                        v-model="users.name"
                        type="text"
                        class="form-control"
                        placeholder="Nama instruktur"
                        name="name"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Email</label>
                      <input
                        v-model="users.email"
                        type="email"
                        class="form-control"
                        placeholder="Email instruktur"
                        name="email"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Jenis Kelamin</label>
                      <select
                        v-model="users.jenis_kelamin"
                        name="jenis_kelamin"
                        id="jenis_kelamin"
                        class="form-control"
                      >
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Phone</label>
                      <input
                        v-model="users.phone"
                        type="text"
                        class="form-control"
                        placeholder="Phone instruktur"
                        name="phone"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Alamat</label>
                      <input
                        v-model="users.alamat"
                        type="text"
                        class="form-control"
                        placeholder="Alamat instruktur"
                        name="alamat"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Keahlian</label>
                      <input
                        v-model="instruktur.keahlian"
                        type="text"
                        class="form-control"
                        placeholder="Keahlian instruktur"
                        name="keahlian"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Pendidikan</label>
                      <input
                        v-model="instruktur.pendidikan"
                        type="text"
                        class="form-control"
                        placeholder="Pendidikan instruktur"
                        name="pendidikan"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Honor per jam</label>
                      <input
                        v-model="instruktur.honor_perjam"
                        type="number"
                        class="form-control"
                        placeholder="Honor per jam instruktur"
                        name="honor_perjam"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Foto Profil</label>
                      <div class="input-group">
                        <input
                          type="file"
                          class="form-control"
                          placeholder="Foto profil instruktur"
                          name="avatar"
                          @change="handleFileUpload"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Password</label>
                      <input
                        v-model="users.password"
                        type="password"
                        class="form-control mb-1"
                        placeholder="Password login"
                        name="password"
                      />
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
                      :to="{ name: 'admin.instruktur.index' }"
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
  name: "CreateInstrukturComponent",
  data() {
    return {
      avatar: null,
      instruktur: {},
      users: {
        jenis_kelamin: "laki-laki",
        roles: "instruktur",
      },
    };
  },
  created() {},
  methods: {
    handleFileUpload(event) {
      this.avatar = event.target.files[0];
    },
    async submitInstrukturData() {
      Loading();
      try {
        const formData = new FormData();

        Object.entries(this.users).forEach(([key, value]) => {
          if (value !== null && value !== undefined) {
            formData.append(key, value);
          }
        });

        if (this.avatar !== null) {
          formData.append("avatar", this.avatar);
        }

        const responseUsers = await axios.post("/v1/users/store", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        const data = responseUsers.data;

        if (data.error) {
          AlertMsg(data.message, true);
          return;
        }

        const responseInstruktur = await axios.post("/v1/instruktur/store", {
          ...this.instruktur,
          user_id: data.data.id,
        });

        if (!responseInstruktur.data.error) {
          AlertMsg(responseInstruktur.data.message, false);
          this.$router.push({ name: "admin.instruktur.index" });
        }
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
