<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// website route

Route::get('/', function () {
    return redirect('v1/admin');
})->name('login');

// dashboard admin route
Auth::routes();

Route::prefix('v1')->middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin.v1.layouts.app');
    })->name('v1.admin.home');
    Route::get('analysis', 'HomeController@analysis')->name('analysis');

    // pengguna aplikasi
    Route::prefix('admin')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('', 'UsersController@index')->name('index');
            Route::get('{id}', 'UsersController@index')->name('index');
            Route::get('create', 'UsersController@index')->name('index');
        });
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('list', 'UsersController@list')->name('list');
        Route::get('find/{id}', 'UsersController@find')->name('find');

        Route::post('store', 'UsersController@store')->name('store');
        Route::post('update/{id}', 'UsersController@update')->name('update');
        Route::post('delete/{id}', 'UsersController@delete')->name('delete');
    });
    
    // instruktur
    Route::prefix('admin')->group(function () {
        Route::prefix('instruktur')->name('instruktur.')->group(function () {
            Route::get('', 'InstrukturController@index')->name('index');
            Route::get('{id}', 'InstrukturController@index')->name('index');
            Route::get('create', 'InstrukturController@index')->name('index');
        });
    });
    Route::prefix('instruktur')->name('instruktur.')->group(function () {
        Route::get('list', 'InstrukturController@list')->name('list');
        Route::get('find/{id}', 'InstrukturController@find')->name('find');

        Route::post('store', 'InstrukturController@store')->name('store');
        Route::post('update/{id}', 'InstrukturController@update')->name('update');
        Route::post('delete/{id}', 'InstrukturController@delete')->name('delete');
    });
   
    // peserta
    Route::prefix('admin')->group(function () {
        Route::prefix('peserta')->name('peserta.')->group(function () {
            Route::get('', 'PesertaController@index')->name('index');
            Route::get('{id}', 'PesertaController@index')->name('index');
            Route::get('create', 'PesertaController@index')->name('index');
        });
    });
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('list', 'PesertaController@list')->name('list');
        Route::get('find/{id}', 'PesertaController@find')->name('find');

        Route::post('store', 'PesertaController@store')->name('store');
        Route::post('update/{id}', 'PesertaController@update')->name('update');
        Route::post('delete/{id}', 'PesertaController@delete')->name('delete');
    });
    
    // program
    Route::prefix('admin')->group(function () {
        Route::prefix('program')->name('program.')->group(function () {
            Route::get('', 'ProgramController@index')->name('index');
            Route::get('{id}', 'ProgramController@index')->name('index');
            Route::get('create', 'ProgramController@index')->name('index');
        });
    });
    Route::prefix('program')->name('program.')->group(function () {
        Route::get('list', 'ProgramController@list')->name('list');
        Route::get('find/{id}', 'ProgramController@find')->name('find');

        Route::post('store', 'ProgramController@store')->name('store');
        Route::post('update/{id}', 'ProgramController@update')->name('update');
        Route::post('delete/{id}', 'ProgramController@delete')->name('delete');
    });
    
    // kelas
    Route::prefix('admin')->group(function () {
        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('', 'KelasController@index')->name('index');
            Route::get('{id}', 'KelasController@index')->name('index');
            Route::get('create', 'KelasController@index')->name('index');
        });
    });
    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('list', 'KelasController@list')->name('list');
        Route::get('find/{id}', 'KelasController@find')->name('find');

        Route::post('store', 'KelasController@store')->name('store');
        Route::post('update/{id}', 'KelasController@update')->name('update');
        Route::post('delete/{id}', 'KelasController@delete')->name('delete');
    });
    
    // penjadwalan
    Route::prefix('admin')->group(function () {
        Route::prefix('penjadwalan')->name('penjadwalan.')->group(function () {
            Route::get('', 'JadwalController@index')->name('index');
            Route::get('{id}', 'JadwalController@index')->name('index');
            Route::get('create', 'JadwalController@index')->name('index');
        });
    });
    Route::prefix('penjadwalan')->name('penjadwalan.')->group(function () {
        Route::get('list', 'JadwalController@list')->name('list');
        Route::get('find/{id}', 'JadwalController@find')->name('find');

        Route::post('store', 'JadwalController@store')->name('store');
        Route::post('update/{id}', 'JadwalController@update')->name('update');
        Route::post('delete/{id}', 'JadwalController@delete')->name('delete');
    });
    
    // absensi
    Route::prefix('admin')->group(function () {
        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('', 'AbsensiController@index')->name('index');
            Route::get('{id}', 'AbsensiController@index')->name('index');
            Route::get('create', 'AbsensiController@index')->name('index');
        });
    });
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('list', 'AbsensiController@list')->name('list');
        Route::get('riwayat/{id}', 'AbsensiController@riwayat')->name('riwayat');
        Route::get('find/{id}', 'AbsensiController@find')->name('find');

        Route::post('store', 'AbsensiController@store')->name('store');
        Route::post('update/{id}', 'AbsensiController@update')->name('update');
        Route::post('delete/{id}', 'AbsensiController@delete')->name('delete');
    });
    
    // materi
    Route::prefix('admin')->group(function () {
        Route::prefix('materi')->name('materi.')->group(function () {
            Route::get('', 'MateriController@index')->name('index');
            Route::get('{id}', 'MateriController@index')->name('index');
            Route::get('create', 'MateriController@index')->name('index');
        });
    });
    Route::prefix('materi')->name('materi.')->group(function () {
        Route::get('list', 'MateriController@list')->name('list');
        Route::get('find/{id}', 'MateriController@find')->name('find');

        Route::post('store', 'MateriController@store')->name('store');
        Route::post('update/{id}', 'MateriController@update')->name('update');
        Route::post('delete/{id}', 'MateriController@delete')->name('delete');
    });
    
    // pendaftaran
    Route::prefix('admin')->group(function () {
        Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
            Route::get('', 'PendaftaranController@index')->name('index');
            Route::get('{id}', 'PendaftaranController@index')->name('index');
            Route::get('create', 'PendaftaranController@index')->name('index');
        });
    });
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('list', 'PendaftaranController@list')->name('list');
        Route::get('find/{id}', 'PendaftaranController@find')->name('find');

        Route::post('store', 'PendaftaranController@store')->name('store');
        Route::post('update/{id}', 'PendaftaranController@update')->name('update');
        Route::post('delete/{id}', 'PendaftaranController@delete')->name('delete');
    });
   
    // pembayaran
    Route::prefix('admin')->group(function () {
        Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
            Route::get('', 'PembayaranController@index')->name('index');
            Route::get('{id}', 'PembayaranController@index')->name('index');
            Route::get('create', 'PembayaranController@index')->name('index');
        });
    });
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('list', 'PembayaranController@list')->name('list');
        Route::get('find/{id}', 'PembayaranController@find')->name('find');

        Route::post('store', 'PembayaranController@store')->name('store');
        Route::post('update/{id}', 'PembayaranController@update')->name('update');
        Route::post('delete/{id}', 'PembayaranController@delete')->name('delete');
    });

    // penggajian
    Route::prefix('admin')->group(function () {
        Route::prefix('penggajian')->name('penggajian.')->group(function () {
            Route::get('', 'PenggajianController@index')->name('index');
            Route::get('{id}', 'PenggajianController@index')->name('index');
            Route::get('create', 'PenggajianController@index')->name('index');
        });
    });
    Route::prefix('penggajian')->name('penggajian.')->group(function () {
        Route::get('gajiInstruktur', 'PenggajianController@gajiInstruktur')->name('gajiInstruktur');
        Route::get('find/{id}', 'PenggajianController@find')->name('find');

        Route::post('store', 'PenggajianController@store')->name('store');
        Route::post('update/{id}', 'PenggajianController@update')->name('update');
        Route::post('delete/{id}', 'PenggajianController@delete')->name('delete');
    });
});
