<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AbsensiModel;
use App\Models\MahasiswaModel;
use App\Models\SuratModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class MahasiswaKompenController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->level_id == 5) {
            $mahasiswa = MahasiswaModel::where('username', $user->username)->first();

            if (!$mahasiswa) {
                return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
            }

            $data = MahasiswaModel::select(
                'm_mahasiswa.mahasiswa_id',
                'nim',
                'mahasiswa_nama',
                't_absensi_mhs.poin',
                't_absensi_mhs.status',
                't_periode.periode_tahun',
                't_periode.periode_semester',
            )
                ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
                ->leftJoin('t_periode', 't_absensi_mhs.periode_id', '=', 't_periode.periode_id')
                ->where('m_mahasiswa.mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->where('t_absensi_mhs.alpha', '!=', '0')
                ->get();

            return response()->json([
                'success'   => true,
                'data'      => $data
            ]);
        }

        $data = MahasiswaModel::select(
            'm_mahasiswa.mahasiswa_id',
            'nim',
            'mahasiswa_nama',
            't_absensi_mhs.poin',
            't_absensi_mhs.status',
            't_periode.periode_tahun',
            't_periode.periode_semester',
        )
            ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->leftJoin('t_periode', 't_absensi_mhs.periode_id', '=', 't_periode.periode_id')
            ->where('t_absensi_mhs.alpha', '!=', '0')
            ->get();

        return response()->json([
            'success'   => true,
            'data'      => $data
        ]);
    }

    public function show(Request $request)
    {

        $id = $request->input('id');

        $data = MahasiswaModel::select(
            'm_mahasiswa.mahasiswa_id',
            'user_id',
            'nim',
            'mahasiswa_nama',
            't_absensi_mhs.alpha',
            't_absensi_mhs.poin',
            't_absensi_mhs.status',
        )
            ->leftJoin('t_absensi_mhs', 'm_mahasiswa.mahasiswa_id', '=', 't_absensi_mhs.mahasiswa_id')
            ->where('m_mahasiswa.user_id', $id)
            ->first();

        return response()->json([
            'success'   => true,
            'data'      => $data
        ]);
    }

    public function exportPDF($id)
    {
        $absensi = AbsensiModel::with(['mahasiswa', 'periode'])->findOrFail($id);

        $surat_kompen = SuratModel::firstOrNew([
            'mahasiswa_id' => $absensi->mahasiswa_id,
            'absensi_id' => $absensi->absensi_id
        ]);

        if (!$surat_kompen->exists || !$surat_kompen->surat_uuid) {
            $surat_kompen->surat_uuid = Str::uuid();
            $surat_kompen->tanggal_pengajuan = Carbon::now()->toDateString();
            $surat_kompen->save();
        }

        $absensi->surat_kompen = $surat_kompen;

        $qrPath = 'qrcodes/' . $surat_kompen->surat_uuid . '.svg';
        Storage::disk('public')->put($qrPath, QrCode::size(300)->generate($surat_kompen->surat_uuid));
        $absensi->qrcode = "storage/$qrPath";

        $pdf = Pdf::loadView('hasil_kompen.export_pdf', ['hasil' => $absensi]);
        $pdf->setPaper('a4', 'portrait');

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Hasil_Kompen_' . $absensi->mahasiswa->nim . '.pdf"'
        ]);
    }
}
