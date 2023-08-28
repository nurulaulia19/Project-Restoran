<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\DataUser;
use App\Models\RoleMenu;
use Illuminate\Http\Request;

class CheckRoleMenuAccess
{
    public function handle($request, Closure $next)
    {
        $user_id = auth()->user()->user_id;
        $role_id = DataUser::find($user_id)->role_id;

        $menu_id = $request->route('menu_id'); // Ambil nilai menu_id dari route

        $menu_ids = RoleMenu::where('role_id', $role_id)->pluck('menu_id');
        // dd($user_id, $role_id, $menu_ids);
        // dd($user_id, $role_id, $menu_ids);
        if ($menu_ids->contains($menu_id)) {
            return redirect()->back()->with('error', 'You do not have permission to access this menu.');
        }

        return $next($request);
    }
}
