<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        $user = Auth::user(); // Ambil user yang sedang login

        $activities = Activity::where('user_id', $user->id)
                    ->orderBy('created_at', 'asc')
                    ->get();


        return view('profile.index', compact('user', 'activities')); // Kirim ke view
    }

  

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        $validated = $request->validated();


        // Update profile
        $profile->name = $validated['name'];
        $profile->nickname = $validated['nickname'] ?? null;
        $profile->domicile = $validated['domicile'] ?? null;
        $profile->no_whatsapp = $validated['no_whatsapp'] ?? null;
        $profile->gender = $validated['gender'] ?? null;
        $profile->date_of_birth = $validated['date_of_birth'] ?? null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Simpan ke public/uploads/profiles
            $image->move(public_path('uploads/profiles'), $imageName);
            
            // Simpan path ke database
            $profile->image = 'uploads/profiles/' . $imageName;
        }

        $profile->save();

        return redirect()->back();
    }

     // Method untuk ganti password
    public function changePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validasi langsung di sini
        $validated = $request->validate([
            'password' => 'required|string|min:6', // password lama
            'password_baru' => 'required|string|min:6|confirmed', // harus cocok dengan password_baru_confirmation
        ], [
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek password lama
        if (!Hash::check($validated['password'], $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Password lama tidak sesuai.']);
        }

        // Update password baru
        $user->password = Hash::make($validated['password_baru']);
        $user->save();

        return redirect()->back();
    }


    public function updateDeskripsi(Request $request)
    {
        
        

        $request->validate([
            'description' => 'required|string',
        ]);
        
        
        
        $profile =  Profile::where('id', $request->profile_id)->firstOrFail();
        
        
        $profile->update([
            'description' => $request->description,
        ]);
        

        return redirect()->back()->with('success', 'Deskripsi berhasil diperbarui!');
    }



 
}
