<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsappMessage;
use App\Models\ForumKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PelayananPublikController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ForumKonsultasi = ForumKonsultasi::leftJoin('jawaban_konsultasi AS jawaban', 'jawaban.id_forum', '=', 'forum_konsultasi.id')
            ->select(
                'forum_konsultasi.nama',
                'forum_konsultasi.alamat',
                'forum_konsultasi.email',
                'forum_konsultasi.no_hp',
                'forum_konsultasi.keterangan',
                'forum_konsultasi.dokumen_pendukung',
                'jawaban.keterangan AS jawaban',
                'jawaban.id_forum'
            )
            ->orderBy('forum_konsultasi.created_at', 'desc')  // Mengurutkan berdasarkan created_at secara descending (terbaru dulu)
            ->paginate(8);  // Menggunakan paginate dengan limit 8

        return view('pelayananPublik.index', compact('user', 'ForumKonsultasi'));
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'keterangan' => ['required', 'string', 'min:8'],
            'dokumen' => ['nullable', 'file', 'mimes:pdf,doc,docx'],
        ]);

        try {
            $ForumKonsultasi = new ForumKonsultasi($credentials);

            if ($request->hasFile('dokumen')) {
                $destinationPath = public_path('berkas_konsultasi');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file = $request->file('dokumen');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $ForumKonsultasi->dokumen_pendukung = $fileName;
            }

            $ForumKonsultasi->save();

            $phoneNumber = '62' . ltrim($request->no_hp, '0');  // Ensure the phone number is formatted correctly
            $message = "📢 *Kejaksaan Negeri Pemalang*\n\n"
            . "✅ *Pengaduan Anda Berhasil Diajukan!*\n\n"
            . "Terima kasih telah mengajukan pengaduan.\n\n"
            . "📝 *Informasi Pengaduan:* \n"
            . "Pengaduan Anda akan segera ditindaklanjuti, dan kami akan mengirimkan pemberitahuan melalui WhatsApp begitu respons telah tersedia di situs kami.";
   
            // Dispatch the job
            SendWhatsappMessage::dispatch($phoneNumber, $message);

            return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
        } catch (\Exception $e) {
            // Log the error
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pengaduan.');
        }
    }
}
