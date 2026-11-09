# 🌾 BACKUP SISTEM PROSEED — KEMENTERIAN PERTANIAN REPUBLIK INDONESIA

Repositori ini memuat berkas cadangan (*source code backup*) resmi dari sistem **PROSEED** Direktorat Perbenihan Hortikultura, Direktorat Jenderal Hortikultura, Kementerian Pertanian Republik Indonesia.

---

## 📌 Ringkasan Sistem
* **Framework:** Laravel 10 + Filament PHP Admin Panel
* **Database Relasional:** MySQL (73 Tabel Operasional)
* **Kategori Komoditas:** Tanaman Sayuran, Tanaman Buah, Florikultura, dan Tanaman Obat / Biofarmaka
* **Data Varietas Terdaftar:** 4.009 Varietas Hortikultura Ber-SK Menteri Pertanian RI
* **Produsen Terdaftar:** 861 Produsen & Pengedar Benih Se-Indonesia

---

## 📂 Struktur Utama Proyek
```text
├── app/
│   ├── Filament/            # Resource & Halaman Admin Filament PROSEED
│   │   ├── Resources/       # DataVarietasResource, CaraResource, DistrictsResource
│   │   └── Pages/           # Dashboard Eksekutif
│   ├── Exports/             # VarietasExport, UsersExport
│   └── Models/              # Model Eloquent
├── config/                  # Konfigurasi Layanan Laravel
├── database/                # Skema Migrasi & Seeders
│   └── data/                # Data Varietas Terdaftar (4.009 Varietas)
├── routes/                  # Web & API Routes
└── composer.json            # Dependensi Backend PHP
```

---

## 🚀 Integrasi ke SIM-BENIH HORTI (kementan.unsmadiun.id)
Seluruh basis data varietas terdaftar (4.009 data) dari sistem backup ini telah berhasil diintegrasikan ke dalam portal modern **SIM-BENIH HORTI** berbasis Next.js 14 & Laravel 11 di:
👉 **[kementan.unsmadiun.id](https://kementan.unsmadiun.id)**  
👉 **Repositori Utama:** [haamzz93-sudo/KEMENTAN_WEBSITE](https://github.com/haamzz93-sudo/KEMENTAN_WEBSITE)

---
*Dikelola oleh Tim Pengembang Universitas Sebelas Maret (UNS Madiun) & Kementerian Pertanian RI.*
