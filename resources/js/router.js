import Vue from 'vue';
import VueRouter from 'vue-router';
import VueApexCharts from 'vue-apexcharts';

Vue.use(VueRouter);
Vue.component('apexchart', VueApexCharts);


// dashboard page component
import DashboardComponent from './components/admin/dashboard/DashboardComponent.vue';

// instruktur page component
import IndexInstrukturComponent from './components/admin/instruktur/IndexComponent.vue';
import CreateInstrukturComponent from './components/admin/instruktur/CreateComponent.vue';
import EditInstrukturComponent from './components/admin/instruktur/EditComponent.vue';

// peserta page component
import IndexPesertaComponent from './components/admin/peserta/IndexComponent.vue';
import CreatePesertaComponent from './components/admin/peserta/CreateComponent.vue';
import EditPesertaComponent from './components/admin/peserta/EditComponent.vue';

// users page components
import IndexUsersComponent from './components/admin/users/IndexComponent.vue';
import CreateUsersComponent from './components/admin/users/CreateComponent.vue';
import EditUsersComponent from './components/admin/users/EditComponent.vue';

// program page components
import IndexProgramComponent from './components/admin/program/IndexComponent.vue';
import CreateProgramComponent from './components/admin/program/CreateComponent.vue';
import EditProgramComponent from './components/admin/program/EditComponent.vue';

// kelas page components
import IndexKelasComponent from './components/admin/kelas/IndexComponent.vue';
import CreateKelasComponent from './components/admin/kelas/CreateComponent.vue';
import EditKelasComponent from './components/admin/kelas/EditComponent.vue';

// materi page components
import IndexMateriComponent from './components/admin/materi/IndexComponent.vue';
import CreateMateriComponent from './components/admin/materi/CreateComponent.vue';
import EditMateriComponent from './components/admin/materi/EditComponent.vue';

// penjadwalan page components
import IndexPenjadwalanComponent from './components/admin/penjadwalan/IndexComponent.vue';

// absensi page components
import IndexAbsensiComponent from './components/admin/absensi/IndexComponent.vue';

// pembayaran page component
import IndexPembayaranComponent from './components/admin/pembayaran/IndexComponent.vue';
import CreatePembayaranComponent from './components/admin/pembayaran/CreateComponent.vue';
import EditPembayaranComponent from './components/admin/pembayaran/EditComponent.vue';

// pendaftaran page component
import IndexPendaftaranComponent from './components/admin/pendaftaran/IndexComponent.vue';
import CreatePendaftaranComponent from './components/admin/pendaftaran/CreateComponent.vue';
import EditPendaftaranComponent from './components/admin/pendaftaran/EditComponent.vue';

// laporan page component
import IndexLaporanPendaftaranComponent from './components/admin/laporan_pendaftaran/IndexComponent.vue';
import IndexLaporanKelasComponent from './components/admin/laporan_kelas/IndexComponent.vue';
import IndexLaporanPembayaranComponent from './components/admin/laporan_pembayaran/IndexComponent.vue';
import IndexLaporanPenggajianComponent from './components/admin/laporan_penggajian/IndexComponent.vue';

// penggajian page component
import IndexPenggajianComponent from './components/admin/penggajian/IndexComponent.vue';

const user = Object.freeze(window.auth?.user);
function staffMiddleware(to, from, next) {
  // if (['admin_staff', 'super_admin'].includes(user.roles)) {
  next();
  // } else {
  // next('/');
  // }
}

function storeUserMiddleware(to, from, next) {
  // if (['super_admin'].includes(user.roles)) {
  next();
  // } else {
  // next('/v1/admin');
  // }
}

const routes = [
  {
    path: '/v1/admin',
    component: DashboardComponent,
    name: 'admin.dashboard.index',
    meta: { title: 'Dashboard', middleware: [staffMiddleware] },
  },

  // instruktur page
  {
    path: '/v1/admin/instruktur/',
    component: IndexInstrukturComponent,
    name: "admin.instruktur.index",
    meta: { title: 'Instruktur', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/instruktur/create',
    component: CreateInstrukturComponent,
    name: "admin.instruktur.create",
    meta: { title: 'Instruktur', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/instruktur/:id',
    component: EditInstrukturComponent,
    name: "admin.instruktur.edit",
    meta: { title: 'Instruktur', middleware: [staffMiddleware] }
  },

  // peserta page
  {
    path: '/v1/admin/peserta/',
    component: IndexPesertaComponent,
    name: "admin.peserta.index",
    meta: { title: 'Peserta', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/peserta/create',
    component: CreatePesertaComponent,
    name: "admin.peserta.create",
    meta: { title: 'Peserta', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/peserta/:id',
    component: EditPesertaComponent,
    name: "admin.peserta.edit",
    meta: { title: 'Peserta', middleware: [staffMiddleware] }
  },

  // users page
  {
    path: '/v1/admin/users',
    component: IndexUsersComponent,
    name: "admin.users.index",
    meta: { title: 'Users', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/users/create',
    component: CreateUsersComponent,
    name: "admin.users.create",
    meta: { title: 'Users', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/users/:id',
    component: EditUsersComponent,
    name: "admin.users.edit",
    meta: { title: 'Users', middleware: [staffMiddleware] }
  },

  // program page
  {
    path: '/v1/admin/program',
    component: IndexProgramComponent,
    name: "admin.program.index",
    meta: { title: 'Program', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/program/create',
    component: CreateProgramComponent,
    name: "admin.program.create",
    meta: { title: 'Program', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/program/:id',
    component: EditProgramComponent,
    name: "admin.program.edit",
    meta: { title: 'Program', middleware: [staffMiddleware] }
  },

  // kelas page
  {
    path: '/v1/admin/kelas',
    component: IndexKelasComponent,
    name: "admin.kelas.index",
    meta: { title: 'Kelas', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/kelas/create',
    component: CreateKelasComponent,
    name: "admin.kelas.create",
    meta: { title: 'Kelas', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/kelas/:id',
    component: EditKelasComponent,
    name: "admin.kelas.edit",
    meta: { title: 'Kelas', middleware: [staffMiddleware] }
  },

  // penjadwalan page
  {
    path: '/v1/admin/penjadwalan',
    component: IndexPenjadwalanComponent,
    name: "admin.penjadwalan.index",
    meta: { title: 'Penjadwalan', middleware: [staffMiddleware, storeUserMiddleware] }
  },

  // absensi page
  {
    path: '/v1/admin/absensi',
    component: IndexAbsensiComponent,
    name: "admin.absensi.index",
    meta: { title: 'Absensi', middleware: [staffMiddleware, storeUserMiddleware] }
  },

  // materi page
  {
    path: '/v1/admin/materi',
    component: IndexMateriComponent,
    name: "admin.materi.index",
    meta: { title: 'Materi', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/materi/create',
    component: CreateMateriComponent,
    name: "admin.materi.create",
    meta: { title: 'Materi', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/materi/:id',
    component: EditMateriComponent,
    name: "admin.materi.edit",
    meta: { title: 'Materi', middleware: [staffMiddleware] }
  },

  // pembayaran page
  {
    path: '/v1/admin/pembayaran/',
    component: IndexPembayaranComponent,
    name: "admin.pembayaran.index",
    meta: { title: 'Pembayaran', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/pembayaran/create',
    component: CreatePembayaranComponent,
    name: "admin.pembayaran.create",
    meta: { title: 'Pembayaran', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/pembayaran/:id',
    component: EditPembayaranComponent,
    name: "admin.pembayaran.edit",
    meta: { title: 'Pembayaran', middleware: [staffMiddleware] }
  },

  // pendaftaran page
  {
    path: '/v1/admin/pendaftaran/',
    component: IndexPendaftaranComponent,
    name: "admin.pendaftaran.index",
    meta: { title: 'Pendaftaran', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/pendaftaran/create',
    component: CreatePendaftaranComponent,
    name: "admin.pendaftaran.create",
    meta: { title: 'Pendaftaran', middleware: [staffMiddleware, storeUserMiddleware] }
  },
  {
    path: '/v1/admin/pendaftaran/:id',
    component: EditPendaftaranComponent,
    name: "admin.pendaftaran.edit",
    meta: { title: 'Pendaftaran', middleware: [staffMiddleware] }
  },

  // laporan page
  {
    path: '/v1/admin/laporan/pendaftaran/',
    component: IndexLaporanPendaftaranComponent,
    name: "admin.laporan_pendaftaran.index",
    meta: { title: 'Laporan Pendaftaran', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/laporan/kelas/',
    component: IndexLaporanKelasComponent,
    name: "admin.laporan_kelas.index",
    meta: { title: 'Laporan Kelas', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/laporan/pembayaran/',
    component: IndexLaporanPembayaranComponent,
    name: "admin.laporan_pembayaran.index",
    meta: { title: 'Laporan Pembayaran', middleware: [staffMiddleware] }
  },
  {
    path: '/v1/admin/laporan/penggajian/',
    component: IndexLaporanPenggajianComponent,
    name: "admin.laporan_penggajian.index",
    meta: { title: 'Laporan Penggajian', middleware: [staffMiddleware] }
  },

  // penggajian page
  {
    path: '/v1/admin/penggajian/',
    component: IndexPenggajianComponent,
    name: "admin.penggajian.index",
    meta: { title: 'Penggajian', middleware: [staffMiddleware] }
  },
];

const router = new VueRouter({
  mode: 'history',
  routes,
});

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} | LPK Saraswati Komputer` || 'LPK Saraswati Komputer';

  const middlewares = to.meta.middleware;

  if (middlewares) {
    if (Array.isArray(middlewares)) {
      const runMiddlewares = middlewares.reduceRight(
        (nextMiddleware, currentMiddleware) => () => currentMiddleware(to, from, nextMiddleware),
        next
      );
      runMiddlewares();
    } else {
      middlewares(to, from, next);
    }
  } else {
    next();
  }
});


export default router;
