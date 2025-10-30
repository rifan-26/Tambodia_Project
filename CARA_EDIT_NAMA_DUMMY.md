# Cara Edit Nama Dummy di Database

## Metode 1: Via phpMyAdmin / Database GUI

### Langkah-langkah:
1. Buka **phpMyAdmin** (biasanya di `http://localhost/phpmyadmin`)
2. Pilih database project Anda (misal: `laraveladmin`)
3. Klik tabel **`staff_names`**
4. Klik tab **"Browse"** untuk melihat data
5. Klik icon **"Edit"** (pensil) pada nama yang ingin diganti
6. Ubah field **`name`** dengan nama baru
7. Klik **"Go"** untuk save
8. Refresh halaman Master Profil → Nama sudah berubah!

---

## Metode 2: Via Laravel Tinker (Command Line)

### Edit 1 Nama:
```bash
php artisan tinker
```

Kemudian jalankan:
```php
// Cari nama yang mau diganti
$name = App\Models\StaffName::where('name', 'Ahmad Fauzi')->first();

// Ganti dengan nama baru
$name->name = 'Nama Real Staff 1';
$name->save();

// Output: true (berhasil)
exit
```

### Edit Banyak Nama Sekaligus:
```bash
php artisan tinker
```

```php
// Ganti semua nama dummy dengan nama real
$updates = [
    'Ahmad Fauzi' => 'John Doe',
    'Budi Santoso' => 'Jane Smith',
    'Citra Dewi' => 'Alice Johnson',
    // ... tambahkan sesuai kebutuhan
];

foreach ($updates as $oldName => $newName) {
    $staff = App\Models\StaffName::where('name', $oldName)->first();
    if ($staff) {
        $staff->name = $newName;
        $staff->save();
        echo "Updated: {$oldName} → {$newName}\n";
    }
}

exit
```

---

## Metode 3: Via SQL Query Langsung

### Edit 1 Nama:
```sql
UPDATE staff_names 
SET name = 'Nama Real Staff 1' 
WHERE name = 'Ahmad Fauzi';
```

### Edit Banyak Nama:
```sql
-- Ganti nama satu per satu
UPDATE staff_names SET name = 'John Doe' WHERE name = 'Ahmad Fauzi';
UPDATE staff_names SET name = 'Jane Smith' WHERE name = 'Budi Santoso';
UPDATE staff_names SET name = 'Alice Johnson' WHERE name = 'Citra Dewi';
-- ... dst
```

### Lihat Semua Nama:
```sql
SELECT id, name, is_default FROM staff_names ORDER BY id;
```

---

## Metode 4: Hapus Semua & Insert Ulang

Jika mau ganti semua nama sekaligus:

```bash
php artisan tinker
```

```php
// Hapus semua nama dummy
DB::table('staff_names')->truncate();

// Insert nama real staff
$realNames = [
    'John Doe',
    'Jane Smith',
    'Alice Johnson',
    'Bob Wilson',
    'Charlie Brown',
    // ... tambahkan nama real staff Anda
];

foreach ($realNames as $name) {
    DB::table('staff_names')->insert([
        'name' => $name,
        'is_default' => true,
        'created_at' => now(),
        'updated_at' => now()
    ]);
}

echo "Inserted " . count($realNames) . " names\n";
exit
```

---

## Metode 5: Via Migration Baru (Recommended untuk Production)

Buat migration untuk update nama:

```bash
php artisan make:migration update_staff_names_with_real_data
```

Edit file migration:
```php
public function up()
{
    $updates = [
        'Ahmad Fauzi' => 'John Doe',
        'Budi Santoso' => 'Jane Smith',
        // ... dst
    ];

    foreach ($updates as $oldName => $newName) {
        DB::table('staff_names')
            ->where('name', $oldName)
            ->update(['name' => $newName]);
    }
}

public function down()
{
    // Rollback jika perlu
    $updates = [
        'John Doe' => 'Ahmad Fauzi',
        'Jane Smith' => 'Budi Santoso',
        // ... dst
    ];

    foreach ($updates as $newName => $oldName) {
        DB::table('staff_names')
            ->where('name', $newName)
            ->update(['name' => $oldName]);
    }
}
```

Jalankan:
```bash
php artisan migrate
```

---

## Tips & Catatan

### ✅ Yang Perlu Diperhatikan:
1. **Unique Constraint**: Nama harus unique, tidak boleh duplikat
2. **Case Sensitive**: Perhatikan huruf besar/kecil
3. **Backup**: Backup database dulu sebelum edit massal
4. **Refresh Page**: Setelah edit, refresh halaman Master Profil

### ⚠️ Jangan:
- Jangan hapus semua nama (minimal harus ada 1 nama)
- Jangan buat nama duplikat
- Jangan edit field `id` (primary key)

### 🔍 Cek Hasil Edit:
```bash
# Via Tinker
php artisan tinker --execute="echo json_encode(App\Models\StaffName::pluck('name'), JSON_PRETTY_PRINT);"

# Via SQL
mysql -u root -p -e "SELECT name FROM laraveladmin.staff_names;"
```

---

## Contoh Lengkap: Ganti 5 Nama Pertama

```bash
php artisan tinker
```

```php
$updates = [
    1 => 'Agus Setiawan',
    2 => 'Budi Hartono', 
    3 => 'Citra Lestari',
    4 => 'Dewi Sartika',
    5 => 'Eko Prasetyo'
];

foreach ($updates as $id => $newName) {
    $staff = App\Models\StaffName::find($id);
    if ($staff) {
        $oldName = $staff->name;
        $staff->name = $newName;
        $staff->save();
        echo "✓ ID {$id}: {$oldName} → {$newName}\n";
    }
}

exit
```

Output:
```
✓ ID 1: Ahmad Fauzi → Agus Setiawan
✓ ID 2: Budi Santoso → Budi Hartono
✓ ID 3: Citra Dewi → Citra Lestari
✓ ID 4: Dian Pratama → Dewi Sartika
✓ ID 5: Eka Putri → Eko Prasetyo
```

---

## Troubleshooting

### Error: Duplicate entry
**Penyebab**: Nama sudah ada di database  
**Solusi**: Gunakan nama yang berbeda

### Error: Column 'name' cannot be null
**Penyebab**: Nama kosong  
**Solusi**: Pastikan nama tidak kosong

### Nama tidak berubah di dropdown
**Penyebab**: Cache browser  
**Solusi**: Hard refresh (Ctrl+Shift+R atau Ctrl+F5)

---

## Rekomendasi

Untuk production, gunakan **Metode 5 (Migration)** karena:
- ✅ Trackable (ada history)
- ✅ Reversible (bisa rollback)
- ✅ Reproducible (bisa dijalankan di server lain)
- ✅ Version controlled (masuk git)

Untuk development/testing, gunakan **Metode 2 (Tinker)** karena:
- ✅ Cepat
- ✅ Interactive
- ✅ Langsung lihat hasil

---

**Selamat mengedit! 🎉**
