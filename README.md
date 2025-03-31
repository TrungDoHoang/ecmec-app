## Learning Laravel

## Day2
- Thiết lập passport để làm authen nhưng phải comment `\Laravel\Passport\Http\Middleware\CreateFreshApiToken::class`,
- Vấn đề: 
> API hết hạn tokken nhưng vẫn sử dụng được. -> resolve: personalAccessTokensExpireIn set time bằng với tokensExpireIn

## Day 3:
- Sửa lại primary bảng trung gian. -> DONE
- Dùng hàm ->sortDelete của laravel thay cho cột is_delete. -> DONE
- Sửa lại time-zone theo giờ VN (.env + config/app.php) -> DONE

## Day 4:
- Refresh token -> DONE. Tuy nhiên sẽ phải chạy 2 port riêng(8000 và 8001) vì Laravel chạy single-threaded trong development server.

## Day 5:
- Phân trang -> DONE. Dùng Traits để có thể tái sử dụng. Tại controller cần sử dụng dùng: `use TraitName`.

## Day 6:
- Viết command customize (make:trait, make:interface, make:enum, make:helper ) kèm stub.

## Next:
- Xác thực với email.
- Phân quyền api.
