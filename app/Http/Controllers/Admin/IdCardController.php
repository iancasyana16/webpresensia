<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdCard;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $idcard = IdCard::when($query, function ($q) use ($query) {
            $q->where('uid', 'like', '%' . $query . '%');
        })
            ->orderBy('uid', 'asc')
            ->paginate(10);

        return view('dashboard_admin.idCard.index', [
            'title' => 'Dashboard ID Card',
            'idCards' => $idcard,
            'search' => $query
        ]);
    }

    public function destroy(IdCard $idCard) {
        // dd($idCard->siswa()->exists());
        if ($idCard->siswa()->exists()) {
            return redirect()->route('dashboard-admin-idCard')->with('error','Data ID Card tidak dapat dihapus karena masih terikat dengan Siswa');
        }
        $idCard->delete();
        return redirect()->route('dashboard-admin-idCard')->with('success','Data ID Card Berhasil Dihapus');
    }
}
