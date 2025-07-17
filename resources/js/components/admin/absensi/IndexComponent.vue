<template>
  <div>
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Absensi</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="page-body">
      <div class="container-xl">
        <section class="row">
          <div class="col-12 col-xl-12">
            <div class="card">
              <div class="card-body">
                <div class="table-container">
                  <div class="table-responsive">
                    <table class="table table-vcenter table-hover">
                      <thead>
                        <tr class="table-primary">
                          <th>Tgl. mulai</th>
                          <th>Tgl. selesai</th>
                          <th>Materi</th>
                          <th>Instruktur</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="jadwal in jadwals" :key="jadwal.id">
                          <td style="text-wrap: nowrap">
                            {{ jadwal.tgl_mulai }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ jadwal.tgl_selesai }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ jadwal.materi.nama }}
                          </td>
                          <td style="text-wrap: nowrap">
                            {{ jadwal.instruktur.user.name }}
                          </td>
                          <td style="text-wrap: nowrap">
                            <button
                              @click="absensiKelas(jadwal.id)"
                              :class="{
                                'btn btn-outline-primary': true,
                                disabled: !jadwal.can_absen,
                              }"
                              v-if="user.roles != 'super_admin'"
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
                                class="icon icon-tabler icons-tabler-outline icon-tabler-alarm-plus"
                              >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M7 4l-2.75 2" />
                                <path d="M17 4l2.75 2" />
                                <path d="M10 13h4" />
                                <path d="M12 11v4" />
                              </svg>
                              Absen
                            </button>
                            <button
                              @click="listAbsensiKelas(jadwal.id)"
                              :class="{
                                'btn btn-outline-info': true,
                                disabled: !jadwal.can_absen,
                              }"
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
                                class="icon icon-tabler icons-tabler-outline icon-tabler-alarm-plus"
                              >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M7 4l-2.75 2" />
                                <path d="M17 4l2.75 2" />
                                <path d="M10 13h4" />
                                <path d="M12 11v4" />
                              </svg>
                              Riwayat Absen
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                      <li
                        class="page-item"
                        :class="{ disabled: meta.current_page === 1 }"
                      >
                        <button
                          class="page-link"
                          @click="fetchJadwalData(meta.current_page - 1)"
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
                        <button class="page-link" @click="fetchJadwalData(page)">
                          {{ page }}
                        </button>
                      </li>
                      <li
                        class="page-item"
                        :class="{ disabled: meta.current_page === meta.last_page }"
                      >
                        <button
                          class="page-link"
                          @click="fetchJadwalData(meta.current_page + 1)"
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
        </section>
      </div>
    </div>

    <!-- modal absensi -->
    <div
      class="modal modal-blur fade show"
      style="display: block"
      tabindex="-1"
      role="dialog"
      v-if="showAbsenModal"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Absensi</h5>
            <button
              type="button"
              class="btn-close"
              @click="showAbsenModal = false"
            ></button>
          </div>

          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label class="form-label">Tipe Absensi</label>
                <select class="form-select" v-model="absen.type">
                  <option value="clock_in">Clock In</option>
                  <option value="clock_out">Clock Out</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Tanggal Absen</label>
                <input
                  type="datetime-local"
                  class="form-control"
                  v-model="absen.tanggal"
                  readonly
                />
              </div>

              <div class="mb-3">
                <label class="form-label">Lokasi Anda Saat Ini</label>
                <div v-if="absen.latitude && absen.longitude">
                  <iframe
                    width="100%"
                    height="250"
                    style="border: 0"
                    :src="`https://www.openstreetmap.org/export/embed.html?bbox=${absen.longitude},${absen.latitude},${absen.longitude},${absen.latitude}&layer=mapnik&marker=${absen.latitude},${absen.longitude}`"
                    allowfullscreen
                  ></iframe>
                  <small>Koordinat: {{ absen.latitude }}, {{ absen.longitude }}</small>
                </div>
                <div v-else>
                  <p class="text-muted">Lokasi belum terdeteksi...</p>
                </div>
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-link" @click="showAbsenModal = false">
              Tutup
            </button>
            <button type="button" class="btn btn-primary" @click="submitAbsensi">
              Absen Sekarang
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal riwayat absensi -->
    <div
      class="modal modal-blur fade show"
      style="display: block"
      tabindex="-1"
      role="dialog"
      v-if="showRiwayatModal"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Riwayat Absensi</h5>
            <button
              type="button"
              class="btn-close"
              @click="showRiwayatModal = false"
            ></button>
          </div>

          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-vcenter table-hover">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Tgl. absensi</th>
                    <th>Tipe absensi</th>
                    <th>Lokasi absensi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="riwayat in riwayats" :key="riwayat.id">
                    <td>{{ riwayat.user.name }}</td>
                    <td>{{ riwayat.tgl_absensi }}</td>
                    <td>
                      <span
                        :class="{
                          badge: true,
                          'bg-yellow text-yellow-fg': riwayat.type === 'clock_in',
                          'bg-green text-green-fg': riwayat.type === 'clock_out',
                        }"
                      >
                        {{ riwayat.type_format }}</span
                      >
                    </td>
                    <td>{{ riwayat.lokasi }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link" @click="showRiwayatModal = false">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { truncateText } from "../../../utils/truncateText";

export default {
  components: {},
  name: "JadwalIndexComponent",
  props: {},
  data() {
    return {
      jadwals: [],
      penjadwalan: {},
      riwayats: [],
      links: {},
      meta: {},
      filtering: {
        search: "",
      },
      showAbsenModal: false,
      showRiwayatModal: false,
      absen: {
        tanggal: "",
        latitude: "",
        longitude: "",
        lokasi: "",
        type: "clock_in", // Default type for absensi
      },
      user: this.$user,
    };
  },
  created() {
    this.fetchJadwalData();
    this.getLocation();
  },
  methods: {
    truncateText,
    listAbsensiKelas(id) {
      Loading();
      axios
        .get(`/v1/absensi/riwayat/${id}`)
        .then((response) => {
          this.showRiwayatModal = true;
          this.riwayats = response.data.data;
          Swal.close();
        })
        .catch((error) => {
          AlertMsg(error.response.data.message, true);
        });
    },
    async getLocation() {
      if (!navigator.geolocation) {
        AlertMsg("Geolocation tidak didukung oleh browser Anda.", true);
        return;
      }

      navigator.geolocation.getCurrentPosition(
        async (position) => {
          this.absen.latitude = position.coords.latitude;
          this.absen.longitude = position.coords.longitude;
          this.absen.tanggal = new Date().toISOString().slice(0, 16); // format 'yyyy-MM-ddTHH:mm'

          try {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${this.absen.latitude}&lon=${this.absen.longitude}&zoom=18&addressdetails=1`;
            const response = await fetch(url, {
              headers: {
                Accept: "application/json",
              },
            });
            const data = await response.json();
            this.absen.lokasi = data.display_name || "Lokasi tidak diketahui";
          } catch (e) {
            console.error("Gagal mengambil alamat:", e);
            this.absen.lokasi = "Gagal mengambil lokasi";
          }
        },
        (error) => {
          AlertMsg("Gagal mendapatkan lokasi. Silakan coba lagi.", true);
        }
      );
    },
    calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371e3; // Earth radius in meters
      const φ1 = (lat1 * Math.PI) / 180;
      const φ2 = (lat2 * Math.PI) / 180;
      const Δφ = ((lat2 - lat1) * Math.PI) / 180;
      const Δλ = ((lon2 - lon1) * Math.PI) / 180;

      const a =
        Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
        Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

      return R * c; // Distance in meters
    },
    submitAbsensi() {
      const targetLat = -8.69080779884201;
      const targetLon = 115.22630535439257;

      if (!this.absen.latitude || !this.absen.longitude) {
        AlertMsg("Lokasi tidak valid. Silakan coba lagi.", true);
        return;
      }

      const distance = this.calculateDistance(
        this.absen.latitude,
        this.absen.longitude,
        targetLat,
        targetLon
      );

      if (distance > 100) {
        Swal.fire({
          title: "Lokasi tidak valid",
          text:
            "Anda harus berada dalam radius 100 meter dari lokasi yang ditentukan untuk absen.",
          icon: "warning",
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ok",
        }).then((result) => {
          if (result.isConfirmed) {
            return;
          }
        });

        return;
      }

      axios
        .post("/v1/absensi/store", {
          ...this.absen,
          ...this.penjadwalan,
        })
        .then((response) => {
          const data = response.data;
          AlertMsg(data.message, data.error);
          if (!data.error) {
            this.fetchJadwalData();
            this.showAbsenModal = false;
          }
        })
        .catch((error) => {
          AlertMsg(error.response.data.message, true);
        });
    },
    async fetchJadwalData() {
      try {
        Loading();
        const response = await axios.get("/v1/absensi/list", {
          params: {
            ...this.filtering,
            kelas_kursus_id: this.$route.query.id_kelas,
          },
        });
        this.jadwals = response.data.data;
        this.links = response.data.links;
        this.meta = response.data.meta;
        Swal.close();
      } catch (error) {
        Swal.close();
        AlertMsg(error.response.data.message, true);
      }
    },
    absensiKelas(id) {
      this.showAbsenModal = true;
      this.absen.tanggal = new Date().toISOString().slice(0, 16);
      this.penjadwalan.id = id;
    },
  },
};
</script>
