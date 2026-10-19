<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Banner;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete, production-ready data.
     */
    public function run(): void
    {
        // 1. Ensure storage folders exist
        $thumbnailsDir = storage_path('app/public/thumbnails');
        $avatarsDir = storage_path('app/public/avatars');

        if (! File::isDirectory($thumbnailsDir)) {
            File::makeDirectory($thumbnailsDir, 0755, true, true);
        }
        if (! File::isDirectory($avatarsDir)) {
            File::makeDirectory($avatarsDir, 0755, true, true);
        }

        // Copy sample assets to storage if available
        $assetImages = public_path('assets/img');
        if (File::isDirectory($assetImages)) {
            $sampleCopies = [
                'Berita-Golf.png' => 'thumbnails/sample-golf.png',
                'Berita-Motor.png' => 'thumbnails/sample-motor.png',
                'Berita-Demo.png' => 'thumbnails/sample-demo.png',
                'Berita-Liburan.png' => 'thumbnails/sample-liburan.png',
                'profile.png' => 'avatars/sample-avatar-1.png',
                'User.png' => 'avatars/sample-avatar-2.png',
            ];

            foreach ($sampleCopies as $src => $dst) {
                $srcPath = $assetImages . DIRECTORY_SEPARATOR . $src;
                $dstPath = storage_path('app/public' . DIRECTORY_SEPARATOR . $dst);
                if (File::exists($srcPath) && ! File::exists($dstPath)) {
                    File::copy($srcPath, $dstPath);
                }
            }
        }

        // 2. Seed Admin User
        $adminEmail = env('ADMIN_EMAIL', 'admin@newsportal.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@NewsPortal2026!');

        $admin = User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Administrator',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Also check if legacy admin exists, ensure role is admin
        $legacyAdmin = User::where('email', 'admin@NewsPortal.com')->first();
        if ($legacyAdmin && $legacyAdmin->role !== 'admin') {
            $legacyAdmin->update(['role' => 'admin']);
        }

        // 3. Seed Authors & Author Users
        $authorsData = [
            [
                'name' => 'Dadang Suhendar',
                'email' => 'dadang@newsportal.com',
                'username' => 'Markudang',
                'avatar' => 'avatars/sample-avatar-1.png',
                'bio' => 'Jurnalis otomotif dan gaya hidup dengan pengalaman lebih dari 7 tahun menulis ulasan mendalam seputar teknologi berkendara.',
            ],
            [
                'name' => 'Kamaludin Malik',
                'email' => 'kamal@newsportal.com',
                'username' => 'KamalCukur',
                'avatar' => 'avatars/sample-avatar-2.png',
                'bio' => 'Penulis rubrik olahraga dan kesehatan. Gemar mengeksplorasi tren kebugaran modern dan nutrisi aktif.',
            ],
            [
                'name' => 'Rina Maharani',
                'email' => 'rina@newsportal.com',
                'username' => 'lalapo',
                'avatar' => 'avatars/sample-avatar-1.png',
                'bio' => 'Pemerhati kecerdasan buatan, digitalisasi industri, serta destinasi wisata tersembunyi nusantara.',
            ],
        ];

        $seededAuthors = [];
        foreach ($authorsData as $data) {
            $existingAuthor = Author::where('username', $data['username'])->first();
            if ($existingAuthor) {
                // If avatar file does not exist on disk, ensure sample file exists at its path
                if ($existingAuthor->avatar && ! File::exists(storage_path('app/public/' . $existingAuthor->avatar))) {
                    $sampleSrc = public_path('assets/img/profile.png');
                    $targetPath = storage_path('app/public/' . $existingAuthor->avatar);
                    if (File::exists($sampleSrc)) {
                        File::ensureDirectoryExists(dirname($targetPath));
                        File::copy($sampleSrc, $targetPath);
                    }
                }
                $seededAuthors[$data['username']] = $existingAuthor;
                continue;
            }

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('Author@12345'),
                    'role' => 'author',
                    'email_verified_at' => now(),
                ]
            );

            $author = Author::create([
                'user_id' => $user->id,
                'username' => $data['username'],
                'avatar' => $data['avatar'],
                'bio' => $data['bio'],
            ]);

            $seededAuthors[$data['username']] = $author;
        }

        // 4. Seed Categories
        $categoriesData = [
            ['title' => 'Teknologi', 'slug' => 'teknologi'],
            ['title' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['title' => 'Otomotif', 'slug' => 'otomotif'],
            ['title' => 'Wisata', 'slug' => 'wisata'],
            ['title' => 'Gaya Hidup', 'slug' => 'gaya-hidup'],
        ];

        $seededCategories = [];
        foreach ($categoriesData as $cat) {
            $category = NewsCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                ['title' => $cat['title']]
            );
            $seededCategories[$cat['slug']] = $category;
        }

        // 5. Seed News Articles
        $authorKamal = $seededAuthors['KamalCukur'] ?? Author::first();
        $authorDadang = $seededAuthors['Markudang'] ?? Author::first();
        $authorRina = $seededAuthors['lalapo'] ?? Author::first();

        $newsData = [
            [
                'author_id' => $authorKamal->id,
                'news_category_id' => $seededCategories['kesehatan']->id,
                'title' => 'Olahraga yang Seru untuk Dimainkan Bersama Pasangan',
                'slug' => 'olahraga-yang-seru-untuk-di-mainkan-bersama-pasangan',
                'thumbnail' => 'thumbnails/sample-golf.png',
                'content' => '<p>Menjaga kebugaran tubuh bersama pasangan tidak hanya membawa manfaat kesehatan jangka panjang, tetapi juga mempererat komunikasi dan keharmonisan hubungan.</p><p>Aktivitas seperti golf santai di akhir pekan, jogging di taman kota, atau bermain bulu tangkis santai dapat membakar kalori secara optimal sekaligus menjadi momen berkualitas melepas kepenatan kerja.</p><p>Para ahli menyarankan setidaknya 150 menit aktivitas fisik intensitas sedang setiap minggu. Memiliki partner latihan terbukti meningkatkan konsistensi dan motivasi berolahraga secara signifikan.</p>',
                'is_featured' => true,
            ],
            [
                'author_id' => $authorDadang->id,
                'news_category_id' => $seededCategories['otomotif']->id,
                'title' => 'Rekomendasi Mobil untuk Offroad Terbaik dan Tangguh',
                'slug' => 'rekomendasi-mobil-untuk-offroad',
                'thumbnail' => 'thumbnails/sample-motor.png',
                'content' => '<p>Kegiatan offroad semakin diminati masyarakat perkotaan yang haus akan petualangan alam terbuka. Memilih kendaraan yang tangguh dan memiliki sistem suspensi yang andal merupakan kunci utama keselamatan dan kenyamanan.</p><p>Kendaraan dengan sistem penggerak 4x4 (Four Wheel Drive) dilengkapi differential lock mampu melibas medan berbatu, tanjakan terjal, dan lumpur pekat tanpa hambatan berarti.</p><p>Sebelum memulai ekspedisi, selalu lakukan pengecekan menyeluruh terhadap kondisi ban segala medan (All-Terrain atau Mud-Terrain), sistem rem, winch, serta kapasitas bahan bakar cadangan.</p>',
                'is_featured' => true,
            ],
            [
                'author_id' => $authorRina->id,
                'news_category_id' => $seededCategories['teknologi']->id,
                'title' => 'Perkembangan Teknologi AI Sekarang dan Dampaknya pada Produktivitas',
                'slug' => 'teknologi-ai-sekarang',
                'thumbnail' => 'thumbnails/sample-demo.png',
                'content' => '<p>Kecerdasan Buatan (Artificial Intelligence) telah berevolusi dari sekadar eksperimen laboratorium menjadi pilar transformasi digital global. Saat ini, model bahasa besar dan agen otomatis membantu para profesional menyelesaikan tugas kompleks dalam hitungan detik.</p><p>Di bidang rekayasa perangkat lunak, AI membantu debugging kode, menghasilkan arsitektur sistem, dan mempercepat siklus deployment. Sementara di bidang analitik data, AI mampu menemukan pola prediktif yang membantu keputusan bisnis strategis.</p><p>Kunci sukses memanfaatkan teknologi ini adalah adaptabilitas dan etika penggunaan data yang bertanggung jawab.</p>',
                'is_featured' => true,
            ],
            [
                'author_id' => $authorDadang->id,
                'news_category_id' => $seededCategories['wisata']->id,
                'title' => 'Rekomendasi Wisata Sejuk di Daerah Malang untuk Liburan Keluarga',
                'slug' => 'rekomendasi-wisata-di-daerah-malang',
                'thumbnail' => 'thumbnails/sample-liburan.png',
                'content' => '<p>Malang Raya dan Kota Batu tetap menjadi primadona destinasi wisata keluarga di Jawa Timur. Udara sejuk pegunungan dipadukan dengan keindahan panorama alam serta fasilitas wisata modern menjadikan liburan terasa menyenangkan.</p><p>Kawasan agrowisata petik apel, perbukitan teh, dan air terjun alami menawarkan suasana relaksasi yang menyegarkan pikiran dari hiruk pikuk rutinitas kota.</p><p>Wisatawan juga dapat menikmati kelezatan kuliner lokal legendaris seperti bakso malang, wedang ronde hangat, serta aneka olahan apel khas daerah.</p>',
                'is_featured' => true,
            ],
            [
                'author_id' => $authorKamal->id,
                'news_category_id' => $seededCategories['gaya-hidup']->id,
                'title' => 'Menerapkan Pola Hidup Minimalis untuk Kejernihan Pikiran',
                'slug' => 'menerapkan-pola-hidup-minimalis-untuk-kejernihan-pikiran',
                'thumbnail' => 'thumbnails/sample-liburan.png',
                'content' => '<p>Gaya hidup minimalis bukan sekadar mengurangi jumlah barang yang dimiliki, melainkan memusatkan perhatian pada hal-hal yang benar-benar memberikan nilai dan kebahagiaan dalam hidup.</p><p>Dengan menyederhanakan lingkungan sekitar, kita mengurangi beban kognitif sehari-hari, meningkatkan fokus kerja, dan menciptakan ruang mental yang lebih tenang.</p>',
                'is_featured' => false,
            ],
        ];

        $seededNews = [];
        foreach ($newsData as $n) {
            $newsItem = News::firstOrCreate(
                ['slug' => $n['slug']],
                $n
            );
            $seededNews[] = $newsItem;
        }

        // Restore image files for all news items if missing on disk
        foreach (News::all() as $item) {
            if ($item->thumbnail && ! File::exists(storage_path('app/public/' . $item->thumbnail))) {
                $sampleMap = [
                    'otomotif' => 'Berita-Motor.png',
                    'teknologi' => 'Berita-Demo.png',
                    'wisata' => 'Berita-Liburan.png',
                    'kesehatan' => 'Berita-Golf.png',
                ];
                $catSlug = $item->newsCategory?->slug ?? '';
                $srcFile = $sampleMap[$catSlug] ?? 'Berita-Liburan.png';
                $src = public_path('assets/img/' . $srcFile);
                $dst = storage_path('app/public/' . $item->thumbnail);
                if (File::exists($src)) {
                    File::ensureDirectoryExists(dirname($dst));
                    File::copy($src, $dst);
                }
            }
        }

        // 6. Seed Banners
        if (Banner::count() === 0 && count($seededNews) > 0) {
            foreach (array_slice($seededNews, 0, 3) as $item) {
                Banner::firstOrCreate(['news_id' => $item->id]);
            }
        }
    }
}
