<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Edit User</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" @submit.prevent="submitUsersData">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Nama</label>
                      <input
                        v-model="users.name"
                        type="text"
                        class="form-control"
                        placeholder="Nama user"
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
                        placeholder="Email user"
                        name="email"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Role</label>
                      <select
                        v-model="users.roles"
                        name="roles"
                        id="roles"
                        class="form-control"
                      >
                        <option value="student">Peserta</option>
                        <option value="super_admin">Super Admin</option>
                      </select>
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
                        placeholder="Phone user"
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
                        placeholder="Alamat user"
                        name="alamat"
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
                          placeholder="Foto profil user"
                          name="avatar"
                          @change="handleFileUpload"
                        />
                        <template v-if="users.avatar">
                          <a
                            :href="users.avatar"
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
                  <div class="col-md-6 col-12">
                    <div class="form-group mb-1">
                      <label for="first-name-column">Password</label>
                      <input
                        v-model="users.password"
                        type="password"
                        class="form-control mb-1"
                        placeholder="Password login"
                        name="password"
                      />
                    </div>
                    <span class="text-muted">Isi jika kamu ingin merubah password</span>
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
                      :to="{ name: 'admin.users.index' }"
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
  name: "EditUsersComponent",
  data() {
    return {
      avatar: null,
      users: {},
    };
  },
  async created() {
    this.fetchUsersData();
  },
  methods: {
    handleFileUpload(event) {
      this.avatar = event.target.files[0];
    },
    async fetchUsersData() {
      try {
        const response = await axios.get("/v1/users/find/" + this.$route.params.id);
        const data = response.data.data;
        this.users = {
          name: data.name,
          email: data.email,
          avatar: data.avatar,
          roles: data.roles,
          jenis_kelamin: data.jenis_kelamin,
          phone: data.phone,
          alamat: data.alamat,
        };
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    submitUsersData() {
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

        axios
          .post("/v1/users/update/" + this.$route.params.id, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            const data = response.data;
            AlertMsg(data.message, data.error);
            if (!data.error) {
              this.$router.push({ name: "admin.users.index" });
            }
          });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
