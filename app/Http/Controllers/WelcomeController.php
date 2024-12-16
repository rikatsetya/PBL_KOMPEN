<?php

namespace App\Http\Controllers;

use App\Models\AbsensiModel;
use App\Models\PengumpulanModel;
use App\Models\PeriodeModel;
use App\Models\TugasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'dashboard';
        $activeSubMenu = '';
        if ($user->level_id == 1 || $user->level_id == 2 || $user->level_id == 3 || $user->level_id == 5) {
            $tugasAdmin = TugasModel::whereHas('user', function ($query) {
                $query->where('level_id', 1);
            })->count();

            $adminDikerjakan = PengumpulanModel::whereHas('tugas', function ($query) {
                $query->whereHas('user', function ($subQuery) {
                    $subQuery->where('level_id', 1);
                });
            })->count();

            $tugasDosen = TugasModel::whereHas('user', function ($query) {
                $query->where('level_id', 2);
            })->count();

            $dosenDikerjakan = PengumpulanModel::whereHas('tugas', function ($query) {
                $query->whereHas('user', function ($subQuery) {
                    $subQuery->where('level_id', 2);
                });
            })->count();

            $tugasTendik = TugasModel::whereHas('user', function ($query) {
                $query->where('level_id', 3);
            })->count();

            $tendikDikerjakan = PengumpulanModel::whereHas('tugas', function ($query) {
                $query->whereHas('user', function ($subQuery) {
                    $subQuery->where('level_id', 3);
                });
            })->count();

            // Statistik absensi
            $totalAbsensi = AbsensiModel::count();
            $lunas = AbsensiModel::where('status', 'Lunas')->count();
            $belumLunas = AbsensiModel::where('status', 'Belum Lunas')->count();
            $alphaKosong = AbsensiModel::where('status', null)->count();

            // Periode aktif
            $periodeAktif = PeriodeModel::orderBy('periode_id', 'DESC')->first();

            return view('dashboardADT', [
                'tugasAdmin' => $tugasAdmin,
                'adminDikerjakan' => $adminDikerjakan,
                'tugasDosen' => $tugasDosen,
                'dosenDikerjakan' => $dosenDikerjakan,
                'tugasTendik' => $tugasTendik,
                'tendikDikerjakan' => $tendikDikerjakan,
                'totalAbsensi' => $totalAbsensi,
                'lunas' => $lunas,
                'belumLunas' => $belumLunas,
                'alphaKosong' => $alphaKosong,
                'periodeAktif' => $periodeAktif,
                'breadcrumb' => $breadcrumb,
                'activeMenu' => $activeMenu,
                'activeSubMenu' => $activeSubMenu
            ]);
        } else {
            $breadcrumb = (object) [
                'title' => 'Selamat Datang',
                'list' => ['Home', 'Welcome']
            ];
            $activeMenu = 'dashboard';
            $activeSubMenu = '';
            return view('dashboardMhs', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'activeSubMenu' => $activeSubMenu]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function jumlahPengguna()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
