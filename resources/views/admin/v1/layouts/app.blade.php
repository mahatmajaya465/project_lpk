<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>LPK Saraswati Komputer</title>
    <!-- CSS files -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ asset('assets/v1/dist/css/tabler.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('assets/v1/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('assets/v1/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('assets/v1/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('assets/v1/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/v2/assets/extensions/toastify-js/src/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/v2/assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" layout-fluid">
    <script src="{{ asset('assets/v1/dist/js/demo-theme.min.js?1692870487') }}"></script>
    <div class="page" id="app">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark text-center">
                    <a href="/v1/admin">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="110" height="32" viewBox="0 0 232 68"
                            class="navbar-brand-image">
                            <path
                                d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z"
                                fill="#066fd1" style="fill: var(--tblr-primary, #066fd1)"></path>
                            <path
                                d="M105.8 46.1c.4 0 .9.2 1.2.6s.6 1 .6 1.7c0 .9-.5 1.6-1.4 2.2s-2 .9-3.2.9c-2 0-3.7-.4-5-1.3s-2-2.6-2-5.4V31.6h-2.2c-.8 0-1.4-.3-1.9-.8s-.9-1.1-.9-1.9c0-.7.3-1.4.8-1.8s1.2-.7 1.9-.7h2.2v-3.1c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v3.1h3.4c.8 0 1.4.3 1.9.8s.8 1.2.8 1.9-.3 1.4-.8 1.8-1.2.7-1.9.7h-3.4v13c0 .7.2 1.2.5 1.5s.8.5 1.4.5c.3 0 .6-.1 1.1-.2.5-.2.8-.3 1.2-.3zm28-20.7c.8 0 1.5.3 2.1.8.5.5.8 1.2.8 2.1v20.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2-.8-.8-1.2-.8-2.1c-.8.9-1.9 1.7-3.2 2.4-1.3.7-2.8 1-4.3 1-2.2 0-4.2-.6-6-1.7-1.8-1.1-3.2-2.7-4.2-4.7s-1.6-4.3-1.6-6.9c0-2.6.5-4.9 1.5-6.9s2.4-3.6 4.2-4.8c1.8-1.1 3.7-1.7 5.9-1.7 1.5 0 3 .3 4.3.8 1.3.6 2.5 1.3 3.4 2.1 0-.8.3-1.5.8-2.1.5-.5 1.2-.7 2-.7zm-9.7 21.3c2.1 0 3.8-.8 5.1-2.3s2-3.4 2-5.7-.7-4.2-2-5.8c-1.3-1.5-3-2.3-5.1-2.3-2 0-3.7.8-5 2.3-1.3 1.5-2 3.5-2 5.8s.6 4.2 1.9 5.7 3 2.3 5.1 2.3zm32.1-21.3c2.2 0 4.2.6 6 1.7 1.8 1.1 3.2 2.7 4.2 4.7s1.6 4.3 1.6 6.9-.5 4.9-1.5 6.9-2.4 3.6-4.2 4.8c-1.8 1.1-3.7 1.7-5.9 1.7-1.5 0-3-.3-4.3-.9s-2.5-1.4-3.4-2.3v.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.5-.8-1.2-.8-2.1V18.9c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v10c.8-1 1.8-1.8 3.2-2.5 1.3-.7 2.8-1 4.3-1zm-.7 21.3c2 0 3.7-.8 5-2.3s2-3.5 2-5.8-.6-4.2-1.9-5.7-3-2.3-5.1-2.3-3.8.8-5.1 2.3-2 3.4-2 5.7.7 4.2 2 5.8c1.3 1.6 3 2.3 5.1 2.3zm23.6 1.9c0 .8-.3 1.5-.8 2.1s-1.3.8-2.1.8-1.5-.3-2-.8-.8-1.3-.8-2.1V18.9c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v29.7zm29.3-10.5c0 .8-.3 1.4-.9 1.9-.6.5-1.2.7-2 .7h-15.8c.4 1.9 1.3 3.4 2.6 4.4 1.4 1.1 2.9 1.6 4.7 1.6 1.3 0 2.3-.1 3.1-.4.7-.2 1.3-.5 1.8-.8.4-.3.7-.5.9-.6.6-.3 1.1-.4 1.6-.4.7 0 1.2.2 1.7.7s.7 1 .7 1.7c0 .9-.4 1.6-1.3 2.4-.9.7-2.1 1.4-3.6 1.9s-3 .8-4.6.8c-2.7 0-5-.6-7-1.7s-3.5-2.7-4.6-4.6-1.6-4.2-1.6-6.6c0-2.8.6-5.2 1.7-7.2s2.7-3.7 4.6-4.8 3.9-1.7 6-1.7 4.1.6 6 1.7 3.4 2.7 4.5 4.7c.9 1.9 1.5 4.1 1.5 6.3zm-12.2-7.5c-3.7 0-5.9 1.7-6.6 5.2h12.6v-.3c-.1-1.3-.8-2.5-2-3.5s-2.5-1.4-4-1.4zm30.3-5.2c1 0 1.8.3 2.4.8.7.5 1 1.2 1 1.9 0 1-.3 1.7-.8 2.2-.5.5-1.1.8-1.8.7-.5 0-1-.1-1.6-.3-.2-.1-.4-.1-.6-.2-.4-.1-.7-.1-1.1-.1-.8 0-1.6.3-2.4.8s-1.4 1.3-1.9 2.3-.7 2.3-.7 3.7v11.4c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.6-.8-1.3-.8-2.1V28.8c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v.6c.7-1.3 1.8-2.3 3.2-3 1.3-.7 2.8-1 4.3-1z"
                                fill-rule="evenodd" clip-rule="evenodd" fill="#4a4a4a"></path>
                        </svg> --}}
                        <img src="https://lkpsaraswati.com/wp-content/uploads/2020/05/LOGO-LPK.png" height="32"
                            alt="LPK Saraswati Komputer" class="navbar-brand-image">
                        <br>
                        LPK Saraswati
                        <br>
                        Komputer
                    </a>
                </h1>
                <div class="navbar-nav flex-row d-lg-none">
                    <div class="d-none d-lg-flex">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                                aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>
                                <span class="badge bg-red"></span>
                            </a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url(./static/avatars/000m.jpg)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="mt-1 small text-secondary">{{ auth()->user()->roles }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            {{-- <a href="./profile.html" class="dropdown-item">Profile</a>
                            <div class="dropdown-divider"></div> --}}
                            <a href="./sign-in.html" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li
                            :class="{
                                'nav-item': true,
                                'active': ['admin.dashboard.index'].includes($route.name)
                            }">
                            <router-link
                                :class="{
                                    'nav-link': true,
                                    'active': ['admin.dashboard.index'].includes($route.name)
                                }"
                                :to="{
                                    name: 'admin.dashboard.index'
                                }">
                                <span
                                    class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M13.45 11.55l2.05 -2.05" />
                                        <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Dashboard
                                </span>
                            </router-link>
                        </li>

                        @if (in_array(auth()->user()->roles, ['super_admin']))
                            <li
                                :class="{
                                    'nav-item dropdown': true,
                                    'active': [
                                            'admin.instruktur.index',
                                            'admin.instruktur.create',
                                            'admin.instruktur.edit',
                                            'admin.users.index',
                                            'admin.users.create',
                                            'admin.users.edit',
                                            'admin.peserta.index',
                                            'admin.peserta.create',
                                            'admin.peserta.edit'
                                        ]
                                        .includes($route.name)
                                }">
                                <a :class="{
                                    'nav-link dropdown-toggle': true,
                                    'active': [
                                            'admin.instruktur.index',
                                            'admin.instruktur.create',
                                            'admin.instruktur.edit',
                                            'admin.users.index',
                                            'admin.users.create',
                                            'admin.users.edit',
                                            'admin.peserta.index',
                                            'admin.peserta.create',
                                            'admin.peserta.edit'
                                        ]
                                        .includes($route.name)
                                }"
                                    href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="true">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path
                                                d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path
                                                d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path
                                                d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Data Master
                                    </span>
                                </a>
                                <div
                                    :class="{
                                        'dropdown-menu': true,
                                        'show': [
                                                'admin.instruktur.index',
                                                'admin.instruktur.create',
                                                'admin.instruktur.edit',
                                                'admin.users.index',
                                                'admin.users.create',
                                                'admin.users.edit',
                                                'admin.peserta.index',
                                                'admin.peserta.create',
                                                'admin.peserta.edit'
                                            ]
                                            .includes($route.name)
                                    }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.users.index'
                                                }">
                                                Users
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.instruktur.index'
                                                }">
                                                Instruktur
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.peserta.index'
                                                }">
                                                Peserta
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif

                        @if (in_array(auth()->user()->roles, ['super_admin']))
                            <li
                                :class="{
                                    'nav-item dropdown': true,
                                    'active': [
                                            'admin.program.index',
                                            'admin.program.create',
                                            'admin.program.edit',
                                            'admin.kelas.index',
                                            'admin.kelas.create',
                                            'admin.kelas.edit',
                                            'admin.penjadwalan.index',
                                            'admin.materi.index',
                                            'admin.materi.create',
                                            'admin.materi.edit'
                                        ]
                                        .includes($route.name)
                                }">
                                <a :class="{
                                    'nav-link dropdown-toggle': true,
                                    'active': [
                                            'admin.program.index',
                                            'admin.program.create',
                                            'admin.program.edit',
                                            'admin.kelas.index',
                                            'admin.kelas.create',
                                            'admin.kelas.edit',
                                            'admin.penjadwalan.index',
                                            'admin.materi.index',
                                            'admin.materi.create',
                                            'admin.materi.edit'
                                        ]
                                        .includes($route.name)
                                }"
                                    href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="true">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-affiliate">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M18.5 3a2.5 2.5 0 1 1 -.912 4.828l-4.556 4.555a5.475 5.475 0 0 1 .936 3.714l2.624 .787a2.5 2.5 0 1 1 -.575 1.916l-2.623 -.788a5.5 5.5 0 0 1 -10.39 -2.29l-.004 -.222l.004 -.221a5.5 5.5 0 0 1 2.984 -4.673l-.788 -2.624a2.498 2.498 0 0 1 -2.194 -2.304l-.006 -.178l.005 -.164a2.5 2.5 0 1 1 4.111 2.071l.787 2.625a5.475 5.475 0 0 1 3.714 .936l4.555 -4.556a2.487 2.487 0 0 1 -.167 -.748l-.005 -.164l.005 -.164a2.5 2.5 0 0 1 2.495 -2.336z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Kursus
                                    </span>
                                </a>
                                <div
                                    :class="{
                                        'dropdown-menu': true,
                                        'show': [
                                                'admin.program.index',
                                                'admin.program.create',
                                                'admin.program.edit',
                                                'admin.kelas.index',
                                                'admin.kelas.create',
                                                'admin.kelas.edit',
                                                'admin.penjadwalan.index',
                                                'admin.materi.index',
                                                'admin.materi.create',
                                                'admin.materi.edit'
                                            ]
                                            .includes($route.name)
                                    }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.program.index'
                                                }">
                                                Program
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.kelas.index'
                                                }">
                                                Kelas
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.materi.index'
                                                }">
                                                Materi
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif

                        @if (in_array(auth()->user()->roles, ['instruktur', 'super_admin', 'student']))
                            <li
                                :class="{
                                    'nav-item': true,
                                    'active': ['admin.absensi.index'].includes($route.name)
                                }">
                                <router-link
                                    :class="{
                                        'nav-link': true,
                                        'active': ['admin.absensi.index'].includes($route.name)
                                    }"
                                    :to="{
                                        name: 'admin.absensi.index'
                                    }">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h16" />
                                            <path d="M11 15h1" />
                                            <path d="M12 15v3" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Absensi
                                    </span>
                                </router-link>
                            </li>
                        @endif

                        @if (in_array(auth()->user()->roles, ['instruktur', 'super_admin']))
                            <li
                                :class="{
                                    'nav-item': true,
                                    'active': ['admin.penilaian.index'].includes($route.name)
                                }">
                                <router-link
                                    :class="{
                                        'nav-link': true,
                                        'active': ['admin.penilaian.index'].includes($route.name)
                                    }"
                                    :to="{
                                        name: 'admin.penilaian.index'
                                    }">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-stars">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17.8 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" />
                                            <path
                                                d="M6.2 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" />
                                            <path
                                                d="M12 9.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Penilaian
                                    </span>
                                </router-link>
                            </li>
                        @endif

                        @if (in_array(auth()->user()->roles, ['student', 'super_admin']))
                            <li
                                :class="{
                                    'nav-item': true,
                                    'active': ['admin.sertifikat.index'].includes($route.name)
                                }">
                                <router-link
                                    :class="{
                                        'nav-link': true,
                                        'active': ['admin.sertifikat.index'].includes($route.name)
                                    }"
                                    :to="{
                                        name: 'admin.sertifikat.index'
                                    }">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-certificate">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M15 15m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            <path d="M13 17.5v4.5l2 -1.5l2 1.5v-4.5" />
                                            <path
                                                d="M10 19h-5a2 2 0 0 1 -2 -2v-10c0 -1.1 .9 -2 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -1 1.73" />
                                            <path d="M6 9l12 0" />
                                            <path d="M6 12l3 0" />
                                            <path d="M6 15l2 0" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Sertifikat
                                    </span>
                                </router-link>
                            </li>
                        @endif

                        @if (!in_array(auth()->user()->roles, ['instruktur', 'pimpinan']))
                            <li
                                :class="{
                                    'nav-item dropdown': true,
                                    'active': [
                                            'admin.pendaftaran.index',
                                            'admin.pendaftaran.create',
                                            'admin.pendaftaran.edit',
                                            'admin.pembayaran.index',
                                            'admin.pembayaran.create',
                                            'admin.pembayaran.edit',
                                            'admin.penggajian.index',
                                            'admin.penggajian.create',
                                            'admin.penggajian.edit'
                                        ]
                                        .includes($route.name)
                                }">
                                <a :class="{
                                    'nav-link dropdown-toggle': true,
                                    'active': [
                                            'admin.pendaftaran.index',
                                            'admin.pendaftaran.create',
                                            'admin.pendaftaran.edit',
                                            'admin.pembayaran.index',
                                            'admin.pembayaran.create',
                                            'admin.pembayaran.edit',
                                            'admin.penggajian.index',
                                            'admin.penggajian.create',
                                            'admin.penggajian.edit'
                                        ]
                                        .includes($route.name)
                                }"
                                    href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="true">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-cash-register">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M21 15h-2.5c-.398 0 -.779 .158 -1.061 .439c-.281 .281 -.439 .663 -.439 1.061c0 .398 .158 .779 .439 1.061c.281 .281 .663 .439 1.061 .439h1c.398 0 .779 .158 1.061 .439c.281 .281 .439 .663 .439 1.061c0 .398 -.158 .779 -.439 1.061c-.281 .281 -.663 .439 -1.061 .439h-2.5" />
                                            <path d="M19 21v1m0 -8v1" />
                                            <path
                                                d="M13 21h-7c-.53 0 -1.039 -.211 -1.414 -.586c-.375 -.375 -.586 -.884 -.586 -1.414v-10c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h2m12 3.12v-1.12c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2" />
                                            <path
                                                d="M16 10v-6c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-4c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414v6m8 0h-8m8 0h1m-9 0h-1" />
                                            <path d="M8 14v.01" />
                                            <path d="M8 17v.01" />
                                            <path d="M12 13.99v.01" />
                                            <path d="M12 17v.01" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Transaksi
                                    </span>
                                </a>
                                <div
                                    :class="{
                                        'dropdown-menu': true,
                                        'show': [
                                                'admin.pendaftaran.index',
                                                'admin.pendaftaran.create',
                                                'admin.pendaftaran.edit',
                                                'admin.pembayaran.index',
                                                'admin.pembayaran.create',
                                                'admin.pembayaran.edit',
                                                'admin.penggajian.index',
                                                'admin.penggajian.create',
                                                'admin.penggajian.edit'
                                            ]
                                            .includes($route.name)
                                    }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.pendaftaran.index'
                                                }">
                                                Pendaftaran
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.pembayaran.index'
                                                }">
                                                Pembayaran
                                            </router-link>

                                            @if (in_array(auth()->user()->roles, ['super_admin']))
                                                <router-link class="dropdown-item"
                                                    :to="{
                                                        name: 'admin.penggajian.index'
                                                    }">
                                                    Penggajian
                                                </router-link>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif

                        @if (in_array(auth()->user()->roles, ['super_admin', 'pimpinan']))
                            <li
                                :class="{
                                    'nav-item dropdown': true,
                                    'active': [
                                        'admin.laporan_pendaftaran.index',
                                        'admin.laporan_kelas.index',
                                        'admin.laporan_pembayaran.index',
                                        'admin.laporan_penggajian.index'
                                    ].includes($route.name)
                                }">
                                <a :class="{
                                    'nav-link dropdown-toggle': true,
                                    'active': [
                                        'admin.laporan_pendaftaran.index',
                                        'admin.laporan_kelas.index',
                                        'admin.laporan_pembayaran.index',
                                        'admin.laporan_penggajian.index'
                                    ].includes($route.name)
                                }"
                                    href="#navbar-layout" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="true">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-chart-histogram">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 3v18h18" />
                                            <path d="M20 18v3" />
                                            <path d="M16 16v5" />
                                            <path d="M12 13v8" />
                                            <path d="M8 16v5" />
                                            <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Laporan
                                    </span>
                                </a>
                                <div
                                    :class="{
                                        'dropdown-menu': true,
                                        'show': [
                                            'admin.laporan_pendaftaran.index',
                                            'admin.laporan_kelas.index',
                                            'admin.laporan_pembayaran.index',
                                            'admin.laporan_penggajian.index'
                                        ].includes($route.name)
                                    }">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.laporan_pendaftaran.index'
                                                }">
                                                Lap. Pendaftaran
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.laporan_kelas.index'
                                                }">
                                                Lap. Kelas Kursus
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.laporan_pembayaran.index'
                                                }">
                                                Lap. Pembayaran
                                            </router-link>
                                            <router-link class="dropdown-item"
                                                :to="{
                                                    name: 'admin.laporan_penggajian.index'
                                                }">
                                                Lap. Penggajian
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </aside>
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url({{ asset('uploads/' . auth()->user()->avatar) }})"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="mt-1 small text-secondary">
                                    {{ ucwords(str_replace('_', ' ', auth()->user()->roles)) }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            {{-- <router-link
                                :to="{
                                    name: 'admin.users.edit',
                                    params: {
                                        id: {{ auth()->user()->id }}
                                    }
                                }"
                                class="dropdown-item">Profile</router-link> --}}
                            <a href="#!" onclick="Logout()" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu"></div>
            </div>
        </header>
        <div class="page-wrapper">
            <!-- Body -->
            <router-view></router-view>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">

                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; 2025
                                    <a href="/v1/admin" class="link-secondary">LPK Saraswati Komputer</a>.
                                    All rights reserved.
                                </li>
                                <li class="list-inline-item">
                                    <a href="./changelog.html" class="link-secondary" rel="noopener">
                                        v1.0.0
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        window.auth = {
            user: @json(Auth::user())
        };
    </script>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/v2/assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/v2/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuedraggable@2.24.3/dist/vuedraggable.umd.min.js"></script>
    <script>
        function AlertMsg(msg, error) {
            bg = "#4fbe87";
            if (error) {
                bg = "#dc3545";
            }

            Swal.close();

            Toastify({
                text: msg,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: bg,
            }).showToast();
        }

        function Loading(msg = "Loading") {
            Swal.fire({
                title: msg,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function Logout() {
            const url = "{{ route('logout') }}";
            const csrfToken = `{{ csrf_token() }}`;

            Loading();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_token': csrfToken
                },
                success: function(data) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    location.reload();
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/tinymce@5/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Libs JS -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('assets/v1/./dist/libs/apexcharts/dist/apexcharts.min.js?1692870487') }}" defer></script>
    <!-- Tabler Core -->
    <script src="{{ asset('assets/v1/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('assets/v1/dist/js/demo.min.js?1692870487') }}" defer></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

</body>

</html>
