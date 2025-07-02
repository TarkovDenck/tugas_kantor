<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

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

   Route::get('/dashboard', function (Request $request) {
        $userId = session('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $database = Firebase::database();
        $allRequests = $database->getReference('requests')->getValue() ?? [];

        $totalRequests = 0;
        $totalHours = 0;
        $totalQuantity = 0;

        foreach ($allRequests as $req) {
            if (!isset($req['user_id']) || $req['user_id'] !== $userId) {
                continue;
            }

            $createdAt = isset($req['created_at']) ? Carbon::parse($req['created_at'])->toDateString() : null;

            // Jika user mengisi filter tanggal
            if ($startDate && $endDate) {
                if (!$createdAt || $createdAt < $startDate || $createdAt > $endDate) {
                    continue;
                }
            }

            $totalRequests++;
            $totalHours += isset($req['hours']) ? floatval($req['hours']) : 0;
            $totalQuantity += isset($req['quantity']) ? intval($req['quantity']) : 0;
        }

        return view('dasboard', [
            'totalRequests' => $totalRequests,
            'totalHours' => $totalHours,
            'totalQuantity' => $totalQuantity,
        ]);
    })->name('dashboard');
                





    Route::get('/', function () {
        return view('welcome');
    });

    










    

    Route::get('/request', function () {
        return view('pages.request');
    })->name('request');

   Route::post('/request-store', function (Request $request) {
        $request->validate([
            'requests' => 'required|string',
        ]);

        $requests = json_decode($request->input('requests'), true);
        $database = Firebase::database();
        $ref = $database->getReference('requests');
        $logRef = $database->getReference('request_logs');

        $userId = session('user_id');

        foreach ($requests as $req) {
            $newData = [
                'user_id' => $userId,
                'request_type' => $req['requestType'],
                'quantity' => $req['number'],
                'hours' => $req['hours'],
                'note' => $req['note'],
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];

            $ref->push($newData);

            // Tambahkan log
            $logRef->push([
                'user_id' => $userId,
                'action' => 'insert',
                'request_type' => $req['requestType'],
                'quantity' => $req['number'],
                'hours' => $req['hours'],
                'note' => $req['note'],
                'date' => now()->toDateTimeString()
            ]);
        }

        return redirect()->route('request')->with('success', 'Request Inserted!');
    })->name('request.store');
    

    Route::get('/profile', function () {
        $database = app('firebase.database');
        $userId = session('user_id');

        // Ambil data dari tabel profiles, bukan users
        $profile = $database->getReference('profiles/' . $userId)->getValue() ?? [];

        return view('pages.profile', [
            'userId' => $userId,
            'profile' => $profile
        ]);
    })->name('user.profile');



    Route::get('/edit-request', function (Request $request) {
        $database = Firebase::database();
        $allRequests = $database->getReference('requests')->getValue() ?? [];

        $from = $request->input('from');
        $to = $request->input('to');
        $filterUser = $request->input('filter_user');
        $sessionUserId = session('user_id');
        $sessionRole = session('role');

        $filtered = [];
        $totalFilteredHours = 0;
        $userIdsSet = [];

        foreach ($allRequests as $key => $req) {
            $createdAt = isset($req['created_at']) ? date('Y-m-d', strtotime($req['created_at'])) : null;
            $reqUserId = $req['user_id'] ?? null;

            if ($reqUserId) {
                $userIdsSet[$reqUserId] = true; // collect unique user_id
            }

            $isAdmin = $sessionRole === 'admin';
            $isOwner = $reqUserId === $sessionUserId;
            $dateMatch = (!$from || !$to || ($createdAt && $createdAt >= $from && $createdAt <= $to));

            $userMatch = $isAdmin
                ? (!$filterUser || $reqUserId === $filterUser)
                : $isOwner;

            if ($dateMatch && $userMatch) {
                $filtered[$key] = $req;
                if (isset($req['hours'])) {
                    $totalFilteredHours += floatval($req['hours']);
                }
            }
        }

        // Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $filteredCollection = new Collection($filtered);
        $paginated = new LengthAwarePaginator(
            $filteredCollection->forPage($page, $perPage)->all(),
            $filteredCollection->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        return view('pages.edit-request', [
            'requests' => $paginated,
            'totalHours' => $totalFilteredHours,
            'allUsers' => array_keys($userIdsSet), // <- kirim ke blade
        ]);
    })->name('request.edit.view');


    Route::post('/request-update', function (Request $request) {
        $request->validate([
            'request_id' => 'required|string',
            'request_type' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'hours' => 'required|numeric',
            'note' => 'nullable|string',
            'user_id' => 'required|string',
        ]);

        $id = $request->input('request_id');
        $database = Firebase::database();
        $ref = $database->getReference('requests/' . $id);
        $logRef = $database->getReference('request_logs');

        $ref->update([
            'request_type' => $request->input('request_type'),
            'quantity' => $request->input('quantity'),
            'hours' => $request->input('hours'),
            'note' => $request->input('note'),
            'updated_at' => now()->toDateTimeString(),
        ]);

        $logRef->push([
            'user_id' => $request->input('user_id'),
            'action' => 'update',
            'request_type' => $request->input('request_type'),
            'quantity' => $request->input('quantity'),
            'hours' => $request->input('hours'),
            'note' => $request->input('note'),
            'date' => now()->toDateTimeString()
        ]);

        return redirect()->route('request.edit.view')->with('success', 'Request updated!');
    })->name('request.update');


    Route::post('/request-delete', function (Request $request) {
        $request->validate([
            'request_id' => 'required|string',
        ]);

        $id = $request->input('request_id');
        $database = Firebase::database();
        $ref = $database->getReference('requests/' . $id);
        $logRef = $database->getReference('request_logs');

        $oldData = $ref->getValue();
        $ref->remove();

        $logRef->push([
            'user_id' => $oldData['user_id'] ?? '-',
            'action' => 'delete',
            'request_type' => $oldData['request_type'] ?? '-',
            'quantity' => $oldData['quantity'] ?? 0,
            'hours' => $oldData['hours'] ?? 0,
            'note' => $oldData['note'] ?? '-',
            'date' => now()->toDateTimeString()
        ]);

        return redirect()->route('request.edit.view')->with('success', 'Request deleted!');
    })->name('request.delete');













    Route::get('/history', function () {
        return redirect()->route('historyreq.view');
    })->name('request.history');

    Route::get('/history-request-log', function (Request $request) {
        $database = Firebase::database();
        $logs = $database->getReference('request_logs')->getValue() ?? [];

        $sessionUserId = session('user_id');
        $sessionRole = session('role');
        $isAdmin = $sessionRole === 'admin';

        $from = $request->input('from');
        $to = $request->input('to');
        $filterUser = $request->input('filter_user');

        $filteredLogs = [];
        $userSet = [];

        foreach ($logs as $key => $log) {
            $userId = $log['user_id'] ?? null;
            $date = $log['date'] ?? null;

            if (!$userId || !$date) continue;

            $logDate = substr($date, 0, 10); // ambil format Y-m-d
            $userSet[$userId] = true;

            $userMatch = $isAdmin
                ? (!$filterUser || $userId === $filterUser)
                : $userId === $sessionUserId;

            $dateMatch = !$from || !$to || ($logDate >= $from && $logDate <= $to);

            if ($userMatch && $dateMatch) {
                $filteredLogs[$key] = $log;
            }
        }

        return view('pages.historyreq', [
            'logs' => $filteredLogs,
            'from' => $from,
            'to' => $to,
            'allUsers' => array_keys($userSet),
        ]);
    })->name('historyreq.view');









    Route::get('/change', function () {
        return view('pages/changepw');
    })->name('changepassword');

    Route::post('/change-password', function (Request $request) {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        $userId = Session::get('user_id');
        if (!$userId) {
            return back()->with('error', 'User not logged in.');
        }

        $database = Firebase::database();
        $userRef = $database->getReference('users/' . $userId);
        $userData = $userRef->getValue();

        if (!$userData) {
            return back()->with('error', 'User not found.');
        }

        if (!Hash::check($request->old_password, $userData['password'])) {
            return back()->with('error', 'Old password is incorrect.');
        }

        $userRef->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now()->toDateTimeString(),
        ]);

        return back()->with('success', 'Password changed successfully.');
    })->name('changepassword.submit');






    // Route::get('/profile', function () {
    //     return view('pages/profile');
    // })->name('profileacct');





    Route::middleware(['check.session', 'check.admin'])->group(function () {    

        Route::get('/profile-user', function () {
            $database = Firebase::database();

            $users = $database->getReference('users')->getValue() ?? [];
            $profiles = $database->getReference('profiles')->getValue() ?? [];
            $projects = $database->getReference('projects')->getValue() ?? [];

            $result = [];
            foreach ($users as $userId => $user) {
                $profile = $profiles[$userId] ?? [
                    'project' => 'Unknown',
                    'project_id' => 'Unknown',
                    'created_at' => '-',
                    'updated_at' => '-',
                ];

                $result[] = [
                    'user_id' => $userId,
                    'project' => $profile['project'],
                    'project_id' => $profile['project_id'],
                    'created_at' => $profile['created_at'],
                    'updated_at' => $profile['updated_at'],
                ];
            }

            return view('pages.admin-userprofile', [
                'profiles' => $result,
                'projects' => $projects ?? [],
            ]);
        })->name('profileacctuser');


        Route::post('/update-profile', function (Request $request) {
            $request->validate([
                'user_id' => 'required|string',
                'project' => 'required|string',
                'project_id' => 'required|string',
            ]);

            $userId = $request->input('user_id');
            $project = $request->input('project');
            $projectId = $request->input('project_id');
            $now = now()->toDateTimeString();

            $database = Firebase::database();
            $profileRef = $database->getReference("profiles/{$userId}");

            $existing = $profileRef->getValue();
            $createdAt = $existing['created_at'] ?? $now;

            $profileRef->set([
                'user_id' => $userId,
                'project' => $project,
                'project_id' => $projectId,
                'created_at' => $createdAt,
                'updated_at' => $now,
            ]);

            return redirect()->route('profileacctuser')->with('success', 'Profile updated!');
        })->name('profile.update');












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
                $database->getReference("users/$id")->remove();
                $database->getReference("profiles/$id")->remove();

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


        Route::get('/admin-dashboard', function (Request $request) {
            $database = app('firebase.database');

            // Ambil semua request
            $requests = $database->getReference('requests')->getValue() ?? [];

            // Ambil semua user
            $users = $database->getReference('users')->getValue() ?? [];
            $totalUsers = count($users);

            // Ambil parameter filter user (opsional)
            $filterUser = $request->query('filter_user');

            $totalHours = 0;
            $totalRequests = 0;
            $chartData = [];
            $recentRequests = [];

            $today = Carbon::now()->format('Y-m-d');

            // Loop semua request
            foreach ($requests as $req) {
                $userId = $req['user_id'] ?? null;
                $hours = isset($req['hours']) ? floatval($req['hours']) : 0;
                $createdAt = $req['created_at'] ?? null;
                $dateOnly = $createdAt ? substr($createdAt, 0, 10) : null;

                // Jika pakai filter user, lewati jika bukan user yang diminta
                if ($filterUser && $userId !== $filterUser) {
                    continue;
                }

                // Akumulasi total
                $totalHours += $hours;
                $totalRequests++;

                // Buat chart per hari
                if ($dateOnly) {
                    if (!isset($chartData[$dateOnly])) {
                        $chartData[$dateOnly] = 0;
                    }
                    $chartData[$dateOnly] += $hours;
                }

                // Ambil recent request untuk hari ini saja
                if ($dateOnly === $today) {
                    $recentRequests[] = $req;
                }
            }

            // Siapkan data chart
            ksort($chartData); // sort berdasarkan tanggal
            $chartLabels = array_keys($chartData);
            $chartValues = array_values($chartData);

            // Siapkan list user untuk dropdown filter
            $allUsers = [];
            foreach ($requests as $req) {
                if (isset($req['user_id']) && !in_array($req['user_id'], $allUsers)) {
                    $allUsers[] = $req['user_id'];
                }
            }

            return view('pages.admin', [
                'totalHours' => $totalHours,
                'totalRequests' => $totalRequests,
                'totalUsers' => $totalUsers,
                'chartLabels' => $chartLabels,
                'chartValues' => $chartValues,
                'recentRequests' => $recentRequests,
                'allUsers' => $allUsers,
            ]);
        })->name('admindashboard');



    
    });

    
    

});
