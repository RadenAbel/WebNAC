# Jalankan script ini dari root project (folder yang ada file artisan-nya)
# Contoh: PS C:\development\webNAC> .\fix-psr4.ps1

Write-Host "Memperbaiki folder Controllers/admin -> Admin..." -ForegroundColor Cyan
Rename-Item "app\Http\Controllers\admin" "admin_tmp"
Rename-Item "app\Http\Controllers\admin_tmp" "Admin"

Write-Host "Membuat folder Requests/Admin dan memindahkan file..." -ForegroundColor Cyan
New-Item -ItemType Directory -Force -Path "app\Http\Requests\Admin" | Out-Null
Move-Item "app\Http\Requests\StoreTeamMemberRequest.php" "app\Http\Requests\Admin\StoreTeamMemberRequest.php" -Force
Move-Item "app\Http\Requests\UpdateTeamMemberRequest.php" "app\Http\Requests\Admin\UpdateTeamMemberRequest.php" -Force
Move-Item "app\Http\Requests\StoreTeamMemberRecordRequest.php" "app\Http\Requests\Admin\StoreTeamMemberRecordRequest.php" -Force
Move-Item "app\Http\Requests\StoreTeamMemberAchievementRequest.php" "app\Http\Requests\Admin\StoreTeamMemberAchievementRequest.php" -Force

Write-Host "Memperbaiki huruf besar-kecil nama file Model..." -ForegroundColor Cyan
Rename-Item "app\Models\Sitesetting.php" "Sitesetting_tmp.php"
Rename-Item "app\Models\Sitesetting_tmp.php" "SiteSetting.php"

Rename-Item "app\Models\Teammember.php" "Teammember_tmp.php"
Rename-Item "app\Models\Teammember_tmp.php" "TeamMember.php"

Rename-Item "app\Models\Teammemberachievement.php" "Teammemberachievement_tmp.php"
Rename-Item "app\Models\Teammemberachievement_tmp.php" "TeamMemberAchievement.php"

Rename-Item "app\Models\Teammemberrecord.php" "Teammemberrecord_tmp.php"
Rename-Item "app\Models\Teammemberrecord_tmp.php" "TeamMemberRecord.php"

Write-Host "Memperbaiki huruf besar-kecil nama file Seeder & Factory..." -ForegroundColor Cyan
Rename-Item "database\seeders\Adminuserseeder.php" "Adminuserseeder_tmp.php"
Rename-Item "database\seeders\Adminuserseeder_tmp.php" "AdminUserSeeder.php"

Rename-Item "database\seeders\Teammemberseeder.php" "Teammemberseeder_tmp.php"
Rename-Item "database\seeders\Teammemberseeder_tmp.php" "TeamMemberSeeder.php"

Rename-Item "database\factories\TeammemberfactoryFactory.php" "TeammemberfactoryFactory_tmp.php"
Rename-Item "database\factories\TeammemberfactoryFactory_tmp.php" "TeamMemberFactory.php"

Write-Host "Selesai! Menjalankan composer dump-autoload..." -ForegroundColor Green
composer dump-autoload
