<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\UpdateProfileRequest;


use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('profile.index', compact('users'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        return view('profile.edit', compact('user', 'roles'));
    }

    public function update(User $user, UpdateProfileRequest $request)
    {
        $this->authorize('update', $user);

        $inputs = $request->validated();

        $this->handleAvatarUpload($user, $inputs);

        $this->updateUser($user, $inputs);

        return back()->with('message', '情報を更新しました');
    }

    public function delete(User $user)
    {
        $user->roles()->detach();
        $this->deleteUserAvatar($user);
        if ($user->avatar !== 'user_default.jpg') {
            $oldavatar = 'public/avatar/' . $user->avatar;
            Storage::delete($oldavatar);
        }
        $user->posts()->delete();
        $user->comments()->delete();
        $user->delete();

        return back()->with('message', 'ユーザーを削除しました');
    }

    private function handleAvatarUpload(User $user, &$inputs)
    {
        if (isset($inputs['avatar'])) {
            if ($user->avatar !== 'user_default.jpg') {
                Storage::delete('public/avatar/' . $user->avatar);
            }

            $avatar = request()->file('avatar');
            $avatarPath = $avatar->storeAs('public/avatar', $this->generateAvatarFileName($avatar));
            $inputs['avatar'] = $this->getAvatarFileNameFromPath($avatarPath);
        }
    }

    private function generateAvatarFileName($avatar)
    {
        $name = $avatar->getClientOriginalName();
        return date('Ymd_His') . '_' . $name;
    }

    private function getAvatarFileNameFromPath($path)
    {
        return basename($path);
    }

    private function updateUser(User $user, $inputs)
    {
        $user->update($this->prepareUserUpdateData($inputs));
    }

    private function prepareUserUpdateData($inputs)
    {
        if (isset($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        } else {
            unset($inputs['password']);
        }

        return $inputs;
    }

    private function deleteUserAvatar(User $user)
    {
        if ($user->avatar !== 'user_default.jpg') {
            Storage::delete('public/avatar/' . $user->avatar);
        }
    }
}
