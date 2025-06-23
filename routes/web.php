<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Providers\RouteServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;

Route::get('/test-firebase', function () {
    try {
        $database = Firebase::database();

        // Tulis data dummy
        $database->getReference('testing')->set([
            'status' => 'Firebase berhasil terhubung 🎉',
            'timestamp' => now()->toDateTimeString()
        ]);

        // Ambil kembali datanya
        $data = $database->getReference('testing')->getValue();

        // Pastikan data dalam bentuk array
        if (!is_array($data)) {
            $data = ['value' => $data];
        }

        return response()->json([
            'message' => 'Firebase berhasil terhubung',
            'data' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Firebase GAGAL terhubung',
            'error' => $e->getMessage()
        ], 500);
    }
});




// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dasboard');
// })->name('dashboard');

// Route::get('/request', function () {
//     return view('pages/request');
// })->name('request');

// Route::get('/history', function () {
//     return view('pages/historyreq');
// })->name('history'); 



// /////////// create and delete user
// Route::get('/user-management', function () {
//     try {
//         $database = Firebase::database();
//         $users = $database->getReference('users')->getValue();

//         return view('pages.users', [
//             'users' => $users ?? []
//         ]);
//     } catch (\Exception $e) {
//         return view('pages.users', [
//             'users' => [],
//             'error' => $e->getMessage()
//         ]);
//     }
// })->name('user.management');

// Route::delete('/delete-user/{id}', function ($id) {
//     try {
//         $database = Firebase::database();
//         $ref = $database->getReference("users/$id");
//         $ref->remove();

//         return redirect()->route('user.management')->with('success', 'User deleted successfully!');
//     } catch (\Exception $e) {
//         return redirect()->route('user.management')->with('error', $e->getMessage());
//     }
// })->name('user.delete');

// Route::post('/add-user', function (Request $request) {
//     $request->validate([
//         'user_id' => 'required|string',
//         'password' => 'required|string',
//         'role' => 'required|string'
//     ]);

//     $userId = $request->input('user_id');
//     $password = $request->input('password');
//     $role = $request->input('role');

//     $now = now()->toDateTimeString();

//     try {
//         $database = Firebase::database();
//         $ref = $database->getReference("users/$userId");

//         $ref->set([
//             'user_id' => $userId,
//             'password' => Hash::make($password), // ✅ hash password
//             'role' => $role,
//             'created_at' => $now,
//             'updated_at' => $now,
//         ]);

//         return redirect()->route('user.management')->with('success', 'User added successfully!');
//     } catch (\Exception $e) {
//         return redirect()->route('user.management')->with('error', $e->getMessage());
//     }
// });


// /////////// create and delete user


// Route::get('/change', function () {
//     return view('pages/changepw');
// })->name('changepassword');

// Route::get('/profile', function () {
//     return view('pages/profile');
// })->name('profileacct');

// Route::get('/profile-user', function () {
//     return view('pages/admin-userprofile');
// })->name('profileacctuser');

// Route::get('/admin', function () {
//     return view('pages/admin');
// })->name('admindashboard');

// /////////// login
// Route::get('/log-in', function () {
//     return view('login');
// })->name('loginuser');

// Route::post('/log-in', function (Request $request) {
//     $userId = $request->input('user_id');
//     $password = $request->input('password');

//     $firebase = Firebase::database();
//     $user = $firebase->getReference('users/' . $userId)->getValue();

//     if (!$user) {
//         return back()->withErrors(['user_id' => 'User not found']);
//     }

//     if (!Hash::check($password, $user['password'])) {
//         return back()->withErrors(['password' => 'Invalid password']);
//     }

//     // Login sukses: simpan sesi
//     Session::put('user_id', $userId);
//     Session::put('role', $user['role']);

//     return redirect()->route('dashboard'); // Ganti dengan route dashboardmu
// });

// Route::post('/logout', function () {
//     Session::flush(); // Hapus semua data session
//     return redirect()->route('loginuser'); // Arahkan ke login page
// })->name('logoutuser');
// /////////// login




// Route publik
Route::get('/log-in', function () {
    return view('login');
})->name('loginuser');

Route::post('/log-in', function (Request $request) {
    $userId = $request->input('user_id');
    $password = $request->input('password');

    $firebase = Firebase::database();
    $user = $firebase->getReference('users/' . $userId)->getValue();

    if (!$user) {
        return back()->withErrors(['user_id' => 'User not found']);
    }

    if (!Hash::check($password, $user['password'])) {
        return back()->withErrors(['password' => 'Invalid password']);
    }

    Session::put('user_id', $userId);
    Session::put('role', $user['role']);

    return redirect()->route('dashboard');
});

Route::post('/logout', function () {
    Session::flush();
    return redirect()->route('loginuser');
})->name('logoutuser');

Route::middleware(['check.session'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dasboard');
    })->name('dashboard');

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dasboard');
    })->name('dashboard');

    Route::get('/request', function () {
        return view('pages/request');
    })->name('request');

    Route::get('/history', function () {
        return view('pages/historyreq');
    })->name('history');

    Route::get('/change', function () {
        return view('pages/changepw');
    })->name('changepassword');

    Route::get('/profile', function () {
        return view('pages/profile');
    })->name('profileacct');

    Route::get('/profile-user', function () {
        return view('pages/admin-userprofile');
    })->name('profileacctuser');

    Route::get('/admin', function () {
        return view('pages/admin');
    })->name('admindashboard');

    

    Route::get('/project-management', function () {
        $database = Firebase::database();
        $projects = $database->getReference('projects')->getValue();

        return view('pages.project', [
            'projects' => $projects ?? []
        ]);
    })->name('project.management');

    Route::post('/project-add', function (Request $request) {
        $request->validate([
            'project_id' => 'required|string',
            'project_name' => 'required|string',
        ]);

        $projectId = $request->input('project_id');
        $projectName = $request->input('project_name');
        $now = now()->toDateTimeString();

        $database = Firebase::database();
        $ref = $database->getReference('projects/' . $projectId);

        $ref->set([
            'project_id' => $projectId,
            'project_name' => $projectName,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->route('project.management')->with('success', 'Project saved!');
    })->name('project.add');

    Route::post('/project-edit/{id}', function (Request $request, $id) {
        $request->validate([
            'project_id' => 'required|string',
            'project_name' => 'required|string',
            'old_project_id' => 'required|string',
        ]);

        $newId = $request->input('project_id');
        $name = $request->input('project_name');
        $oldId = $request->input('old_project_id');
        $now = now()->toDateTimeString();

        $database = Firebase::database();

        // Hapus yang lama jika ID-nya berubah
        if ($oldId !== $newId) {
            $database->getReference('projects/' . $oldId)->remove();
        }

        // Simpan baru (overwrite jika ID tetap sama)
        $database->getReference('projects/' . $newId)->set([
            'project_id' => $newId,
            'project_name' => $name,
            'updated_at' => $now,
            'created_at' => now()->toDateTimeString(), // optional
        ]);

        return redirect()->route('project.management')->with('success', 'Project updated!');
    })->name('project.edit');

    Route::delete('/project-delete/{id}', function ($id) {
        $database = Firebase::database();
        $ref = $database->getReference('projects/' . $id);
        $ref->remove();

        return redirect()->route('project.management')->with('success', 'Project deleted!');
    })->name('project.delete');
    






    

    Route::get('/user-management', function () {
        try {
            $database = Firebase::database();
            $users = $database->getReference('users')->getValue();

            return view('pages.users', [
                'users' => $users ?? []
            ]);
        } catch (\Exception $e) {
            return view('pages.users', [
                'users' => [],
                'error' => $e->getMessage()
            ]);
        }
    })->name('user.management');

    Route::post('/add-user', function (Request $request) {
        $request->validate([
            'user_id' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        $userId = $request->input('user_id');
        $password = $request->input('password');
        $role = $request->input('role');

        $now = now()->toDateTimeString();

        try {
            $database = Firebase::database();
            $ref = $database->getReference("users/$userId");

            $ref->set([
                'user_id' => $userId,
                'password' => Hash::make($password),
                'role' => $role,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return redirect()->route('user.management')->with('success', 'User added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('user.management')->with('error', $e->getMessage());
        }
    });

    

    Route::delete('/delete-user/{id}', function ($id) {
        try {
            $database = Firebase::database();
            $ref = $database->getReference("users/$id");
            $ref->remove();

            return redirect()->route('user.management')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('user.management')->with('error', $e->getMessage());
        }
    })->name('user.delete');

    Route::post('/edit-user/{user_id}', function (Request $request, $user_id) {
        $request->validate([
            'password' => 'required|min:6',
        ]);

        $database = Firebase::database();
        $ref = $database->getReference('users/' . $user_id);

        $user = $ref->getValue();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $ref->update([
            'password' => Hash::make($request->password),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    })->name('user.update');




});
