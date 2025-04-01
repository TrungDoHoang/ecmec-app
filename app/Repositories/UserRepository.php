<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Repository class nhận dữ liệu từ service, thao tác với db(viết query) và trả về cho service
class UserRepository
{
    public function onlyTrashed(int $perPage, int $page)
    {
        return User::onlyTrashed()->paginate($perPage, ['*'], 'page', $page);
    }

    public function allUser(int $perPage, int $page)
    {
        return User::query()->paginate($perPage, ['*'], 'page', $page);
    }

    public function findUser($value, $collumn = 'id')
    {
        return User::where($collumn, $value)->first();
    }

    public function findUserDeleted($id)
    {
        return User::withTrashed()->where('id', $id)->first();
    }

    public function createUser(array $data)
    {
        // Bắt đầu một transaction, mọi thay đổi database sau đó sẽ tạm thời và chưa được lưu.
        DB::beginTransaction();
        try {
            $user = User::create($data);
            $user->roles()->attach($data['role']);

            // Nếu mọi thứ thành công, commit transaction
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            //  Nếu có lỗi, rollback tất cả thay đổi
            DB::rollBack();
            Log::error($e);
        }
    }

    public function updateUser($id, array $data)
    {
        return User::find($id)->update($data);
    }

    public function deleteUser($id)
    {
        return User::destroy($id);
    }

    // Thu hồi token hiện tại của user
    public function revokeToken($user)
    {
        // Lấy token hiện tại
        $token = $user->token();

        // Kiểm tra nếu token tồn tại thì xóa
        if ($token) {
            $token->delete();
        }
    }

    // Thu hồi tất cả các token của user
    public function revokeAllTokens($user)
    {
        $user->tokens()->delete();
    }
}
