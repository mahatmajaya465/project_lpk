<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Edit Pembayaran</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" @submit.prevent="submitPembayaranData">
                <div class="row">
                  <div class="col-md-12 col-12" style="display: none">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Pendaftaran</label>
                      <select
                        v-model="pembayaran.pendaftaran_id"
                        name="pendaftaran_id"
                        id="pendaftaran_id"
                        class="form-control"
                        @change="fetchPendaftaranDetail"
                      >
                        <option
                          v-for="(item, index) in pendaftarans"
                          :key="index"
                          :value="item.id"
                        >
                          {{ item.kode_pendaftaran }} - {{ item.program.nama_program }} -
                          {{ item.peserta.user.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12 mb-3" v-if="pendaftaranDetail.id">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Detail Pendaftaran</h5>
                        <div class="table-responsive">
                          <table class="table table-vcenter">
                            <tbody>
                              <tr>
                                <th style="width: 250px">Nama Peserta</th>
                                <td>:</td>
                                <td></td>
                                <td>{{ pendaftaranDetail.peserta.user.name }}</td>
                                <td></td>
                              </tr>

                              <tr>
                                <th style="width: 250px">Program Kusus</th>
                                <td>:</td>
                                <td></td>
                                <td>{{ pendaftaranDetail.program.nama_program }}</td>
                                <td></td>
                              </tr>

                              <tr>
                                <th style="width: 250px">Kelas Kusus</th>
                                <td>:</td>
                                <td></td>
                                <td>{{ pendaftaranDetail.kelas.nama_kelas }}</td>
                                <td></td>
                              </tr>

                              <tr>
                                <th style="width: 250px">Biaya</th>
                                <td>:</td>
                                <td></td>
                                <td>{{ pendaftaranDetail.program.harga_rp }}</td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-12" v-if="pembayaran.pendaftaran_id">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Kode Pembayaran</label>
                      <input
                        v-model="pembayaran.kode_pembayaran"
                        type="text"
                        class="form-control"
                        placeholder="Kode pembayaran"
                        name="name"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-12" v-if="pembayaran.pendaftaran_id">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Metode Pembayaran</label>
                      <select
                        v-model="pembayaran.metode_pembayaran"
                        name="metode_pembayaran"
                        id="metode_pembayaran"
                        class="form-control"
                        required
                      >
                        <option value="transfer">Transfer</option>
                        <option value="tunai">Tunai</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12" v-if="pembayaran.pendaftaran_id">
                    <div class="form-group mb-3">
                      <label for="last-name-column">Tanggal Pembayaran</label>
                      <input
                        v-model="pembayaran.tgl_pembayaran"
                        type="date"
                        class="form-control"
                        name="tgl_pembayaran"
                        required
                      />
                    </div>
                  </div>
                  <div
                    :class="{
                      'col-md-6 col-12': true,
                      'd-none': user.roles == 'student',
                    }"
                    v-if="pembayaran.pendaftaran_id"
                  >
                    <div class="form-group mb-3">
                      <label for="last-name-column">Status Pembayaran</label>
                      <select
                        v-model="pembayaran.status"
                        name="status"
                        id="status"
                        class="form-control"
                        required
                        :readonly="user.roles == 'student'"
                      >
                        <option value="pending">Menunggu Konfirmasi</option>
                        <option value="settlement">Sudah Dibayarkan</option>
                        <option value="cancel">Dibatalkan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-12" v-if="pembayaran.pendaftaran_id">
                    <div class="form-group mb-3">
                      <label for="first-name-column">Bukti Pembayaran</label>
                      <div class="input-group">
                        <input
                          type="file"
                          class="form-control"
                          placeholder="Bukti pembayaran"
                          name="bukti_pembayaran"
                          @change="handleFileUpload"
                        />
                        <template v-if="pembayaran.bukti_pembayaran">
                          <a
                            :href="pembayaran.bukti_pembayaran_url"
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
                      :to="{ name: 'admin.pembayaran.index' }"
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
  name: "EditInstrukturComponent",
  data() {
    return {
      pendaftarans: [],
      pendaftaranDetail: {},
      pembayaran: {
        pendaftaran_id: null,
        kode_pembayaran: "",
        metode_pembayaran: "transfer",
        tanggal_pembayaran: "",
        nominal: null,
        status: "pending",
      },
      bukti_pembayaran: null,
      user: this.$user,
    };
  },
  async created() {
    this.fetchPembayaranData();
    this.fetchPendaftaranData();
  },
  methods: {
    fetchPembayaranData() {
      Loading();
      const pembayaranId = this.$route.params.id;
      if (pembayaranId) {
        axios
          .get(`/v1/pembayaran/find/${pembayaranId}`)
          .then((response) => {
            this.pembayaran = response.data.data;
            this.fetchPendaftaranDetail();
            Swal.close();
          })
          .catch((error) => {
            AlertMsg(error.response.data.message, true);
          });
      }
    },
    fetchPendaftaranDetail() {
      const pendaftaranId = this.pembayaran.pendaftaran_id;
      if (pendaftaranId) {
        axios
          .get(`/v1/pendaftaran/find/${pendaftaranId}`)
          .then((response) => {
            this.pendaftaranDetail = response.data.data;
            this.pembayaran.nominal = this.pendaftaranDetail.program.harga;
            this.pembayaran.pendaftaran_id = pendaftaranId;
          })
          .catch((error) => {
            AlertMsg(error.response.data.message, true);
          });
      } else {
        this.pendaftaranDetail = {};
        this.pembayaran.nominal = null;
      }
    },
    handleFileUpload(event) {
      this.bukti_pembayaran = event.target.files[0];
    },
    async fetchPendaftaranData() {
      try {
        const response = await axios.get("/v1/pendaftaran/list", {
          params: {
            status: "pending",
          },
        });

        const data = response.data;

        this.pendaftarans = data.data;
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
    submitPembayaranData() {
      Loading();
      try {
        const formData = new FormData();

        Object.entries(this.pembayaran).forEach(([key, value]) => {
          if (value !== null && value !== undefined) {
            formData.append(key, value);
          }
        });

        if (this.bukti_pembayaran !== null) {
          formData.append("bukti_pembayaran", this.bukti_pembayaran);
        }

        axios
          .post("/v1/pembayaran/update/" + this.pembayaran.id, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            const data = response.data;

            AlertMsg(data.message, data.error);
            if (!data.error) {
              this.$router.push({ name: "admin.pembayaran.index" });
            }
          });
      } catch (error) {
        AlertMsg(error.response.data.message, true);
      }
    },
  },
};
</script>
