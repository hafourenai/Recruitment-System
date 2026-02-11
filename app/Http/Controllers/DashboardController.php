<?php

namespace App\Http\Controllers;

use App\Models\PendaftarDetails;
use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function pendaftarDashboard()
    {
        $user = Auth::user();
        $pendaftar = PendaftarDetails::where('user_id', $user->id)->first();
        
        if (!$pendaftar) return redirect('/')->with('error', 'Detail pendaftar tidak ditemukan.');
        
        return view('pendaftar.dashboard', compact('pendaftar'));
    }

    public function pendaftarBerkas()
    {
        $user = Auth::user();
        $pendaftar = PendaftarDetails::where('user_id', $user->id)->first();
        
        if (!$pendaftar) return redirect('/')->with('error', 'Detail pendaftar tidak ditemukan.');
        
        return view('pendaftar.berkas', compact('pendaftar'));
    }

    public function deleteFile($type)
    {
        $user = Auth::user();
        $pendaftar = PendaftarDetails::where('user_id', $user->id)->first();
        
        if (!$pendaftar) return back()->with('error', 'Detail pendaftar tidak ditemukan.');
        
        // Prevent deletion if passed/failed?
        if (in_array($pendaftar->status, ['lulus', 'tidak_lulus'])) {
            return back()->with('error', 'Tidak dapat menghapus berkas saat ini.');
        }

        $berkas = Berkas::where('pendaftar_id', $pendaftar->id)
                        ->where('jenis_berkas', $type)
                        ->first();
                        
        if ($berkas) {
            Storage::delete($berkas->path);
            $berkas->delete();
        }

        return back()->with('success', 'Berkas berhasil dihapus.');
    }

    public function dosenDashboard()
    {
        // Dosen can see all pendaftar
        $pendaftarList = PendaftarDetails::with('berkas')->get();
        return view('dosen.dashboard', compact('pendaftarList'));
    }

    public function adminDashboard(Request $request)
    {
        // Admin can see and filter pendaftar
        $query = PendaftarDetails::query();

        if ($request->has('posisi') && $request->posisi != '') {
            $query->where('posisi', $request->posisi);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pendaftarList = $query->with('berkas')->get();

        return view('admin.dashboard', compact('pendaftarList'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:seleksi_berkas,seleksi_ujian,seleksi_wawancara,seleksi_staf,lulus,tidak_lulus'
        ]);

        $pendaftar = PendaftarDetails::findOrFail($id);
        $pendaftar->status = $request->status;
        $pendaftar->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function updateBerkas(Request $request) {
        $user = Auth::user();
        $pendaftar = PendaftarDetails::where('user_id', $user->id)->first();
        
        if (!$pendaftar) {
            return back()->with('error', 'Detail pendaftar tidak ditemukan.');
        }
        
        // Prevent updates if user has passed/failed
        if (in_array($pendaftar->status, ['lulus', 'tidak_lulus'])) {
            return back()->with('error', 'Tidak dapat mengupdate berkas saat status ' . $pendaftar->status);
        }
        
        $request->validate([
            'cv' => 'nullable|mimes:pdf|max:2048',
            'krs' => 'nullable|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
            'sertifikat' => 'nullable|mimes:pdf|max:2048',
        ], [
            'cv.mimes' => 'CV harus berformat PDF',
            'cv.max' => 'Ukuran CV maksimal 2MB',
            'krs.mimes' => 'KRS harus berformat PDF',
            'krs.max' => 'Ukuran KRS maksimal 2MB',
            'transkrip.mimes' => 'Transkrip harus berformat PDF',
            'transkrip.max' => 'Ukuran transkrip maksimal 2MB',
            'sertifikat.mimes' => 'Sertifikat harus berformat PDF',
            'sertifikat.max' => 'Ukuran sertifikat maksimal 2MB',
        ]);

        $files = ['cv', 'krs', 'transkrip', 'sertifikat'];
        $updatedFiles = [];
        
        foreach ($files as $type) {
            if ($request->hasFile($type)) {
                try {
                    $file = $request->file($type);
                    
                    // Validate file integrity
                    if (!$file->isValid()) {
                        throw new \Exception("File {$type} tidak valid");
                    }
                    
                    // Secure filename
                    $safeFilename = $type . '_' . time() . '.pdf';
                    $path = $file->storeAs("uploads/{$pendaftar->npm}", $safeFilename); 
                    
                    if (!$path) {
                        throw new \Exception("Gagal mengupload file {$type}");
                    }
                    
                    // Update or Create
                    Berkas::updateOrCreate(
                        ['pendaftar_id' => $pendaftar->id, 'jenis_berkas' => $type],
                        [
                            'path' => $path,
                            'original_name' => $file->getClientOriginalName()
                        ]
                    );
                    
                    $updatedFiles[] = $type;
                    
                } catch (\Exception $e) {
                    Log::error('File upload error', [
                        'type' => $type,
                        'error' => $e->getMessage(),
                        'user_id' => $user->id,
                        'pendaftar_id' => $pendaftar->id
                    ]);
                    
                    return back()->with('error', "Gagal mengupload file {$type}: " . $e->getMessage());
                }
            }
        }

        if (!empty($updatedFiles)) {
            Log::info('Files uploaded successfully', [
                'files' => $updatedFiles,
                'user_id' => $user->id,
                'pendaftar_id' => $pendaftar->id
            ]);
        }

        return back()->with('success', 'Berkas berhasil diperbarui: ' . implode(', ', array_map('ucfirst', $updatedFiles)));
    }

    public function viewFile($id)
    {
        // Dosen and Admin only? Or owner?
        // Route currently protected by role:dosen. Admin doesn't have route yet?
        // Requirement 2b: Dosen sees all files.
        // Admin: "Mengelola data pendaftar" -> implies seeing files too.
        
        $berkas = Berkas::findOrFail($id);
        
        // Authorization check (simplistic)
        $user = Auth::user();
        if ($user->role == 'pendaftar') {
            // Check if own file
            $pendaftar = PendaftarDetails::where('user_id', $user->id)->first();
            if ($berkas->pendaftar_id !== $pendaftar->id) {
                abort(403);
            }
        }
        
        // Return file
        if (!Storage::exists($berkas->path)) {
            abort(404, 'File not found');
        }

        return response()->file(storage_path("app/{$berkas->path}"));
    }
}
