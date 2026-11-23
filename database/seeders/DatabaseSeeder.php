<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Block;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Faq;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TechItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@stepupproject.tech'],
            ['name' => 'Admin StepUp', 'password' => 'StepUp#2026']
        );

        foreach (config('site.defaults') as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        if (Project::query()->exists()) {
            return;
        }

        Project::insert([
            $this->project('Dasbor Data Siswa', 'dasbor-data-siswa', 'Dashboard', '2025', 'Studi internal', 'Satu layar untuk kelas, status berkas, dan data siswa yang sebelumnya tersebar.', "Tim perlu melihat data siswa tanpa membuka banyak berkas.\n\nDasbor ini merangkum kelas, status kelengkapan, dan pencarian dalam satu tampilan yang bisa diserahkan ke operator.", ['Laravel', 'MySQL', 'Blade'], 1, true),
            $this->project('Alur Artikel', 'alur-artikel', 'Otomasi', '2025', 'Studi internal', 'Alur menyusun, meninjau, lalu menerbitkan artikel dengan langkah yang tercatat.', "Draf, tinjauan, dan jadwal terbit dipisah supaya tidak ada tulisan yang langsung naik tanpa diperiksa.\n\nYang dihasilkan adalah urutan kerja, bukan tumpukan draf tanpa pemilik.", ['Laravel', 'PHP', 'MySQL'], 2, false),
            $this->project('Situs Studio', 'situs-studio', 'Website', '2026', 'StepUp', 'Landing untuk layanan, portofolio, dan jalur kontak yang bisa diubah dari dashboard.', "Halaman ini sendiri jadi studi kasus: isi proyek, sertifikat, dan tech stack diatur dari admin, tanpa menyentuh kode.\n\nPengunjung bisa membuka detail, melihat preview bila URL live diisi, lalu lanjut ke WhatsApp.", ['Laravel', 'Blade', 'MySQL'], 3, false),
        ]);

        Certificate::insert([
            $this->stamp('certificates', 'Lab Laravel', 'StepUp Lab', '2025', 'Catatan latihan internal untuk alur routing, Blade, dan penyimpanan data. Ganti dengan sertifikat resmi lewat admin.'),
            $this->stamp('certificates', 'Dasar MySQL', 'StepUp Lab', '2025', 'Catatan latihan skema, relasi, dan cadangan data. Bukan kredensial lembaga luar.'),
            $this->stamp('certificates', 'Antarmuka Web', 'StepUp Lab', '2026', 'Catatan latihan hierarki, kontras, dan tata letak responsif.'),
        ]);

        Achievement::insert([
            $this->row('achievements', [
                'title' => 'Studi kasus terdokumentasi',
                'subtitle' => 'Ada cerita, tahun, dan tech stack',
                'year' => '2025',
                'description' => 'Setiap pekerjaan yang ditampilkan punya ringkasan dan halaman detail, bukan hanya tangkapan layar.',
                'sort_order' => 1,
            ]),
            $this->row('achievements', [
                'title' => 'Serah terima akses',
                'subtitle' => 'Akun dan data tetap di pemilik',
                'year' => '2026',
                'description' => 'Checklist serah terima mencakup hosting, basis data, dan akun admin.',
                'sort_order' => 2,
            ]),
        ]);

        foreach ([
            ['Laravel', 'Backend', 1],
            ['React', 'Frontend', 2],
            ['JavaScript', 'Frontend', 3],
            ['HTML5', 'Frontend', 4],
            ['CSS3', 'Frontend', 5],
            ['Font Awesome', 'Frontend', 6],
            ['Python', 'Backend', 7],
            ['PHP', 'Backend', 8],
            ['MySQL', 'Database', 9],
            ['Supabase', 'Database', 10],
            ['Firebase', 'Backend', 11],
            ['XAMPP', 'Alat', 12],
            ['Git', 'Alat', 13],
            ['GitHub', 'Alat', 14],
            ['Vite', 'Alat', 15],
            ['Vercel', 'Alat', 16],
        ] as [$name, $category, $order]) {
            TechItem::create([
                'name' => $name,
                'category' => $category,
                'description' => null,
                'is_published' => true,
                'sort_order' => $order,
            ]);
        }

        Experience::insert([
            $this->row('experiences', [
                'period' => '2026',
                'title' => 'StepUp Project',
                'organization' => 'Studio mandiri',
                'description' => 'Menyusun penawaran website, aplikasi, dan otomasi dengan portofolio yang bisa diperbarui sendiri.',
                'sort_order' => 1,
            ]),
            $this->row('experiences', [
                'period' => '2025',
                'title' => 'Dasbor dan alur kerja',
                'organization' => 'Project latihan',
                'description' => 'Membangun tampilan data dan urutan kerja yang bisa dioperasikan orang lain.',
                'sort_order' => 2,
            ]),
            $this->row('experiences', [
                'period' => '2024',
                'title' => 'Dasar web dan basis data',
                'organization' => 'Belajar lewat project',
                'description' => 'HTML, PHP, dan MySQL dipelajari dengan membuat aplikasi kecil yang benar-benar dijalankan.',
                'sort_order' => 3,
            ]),
        ]);

        Service::insert([
            $this->row('services', ['title' => 'Website Development', 'description' => "Bangun kehadiran digital yang profesional dan meyakinkan.\n\nCompany Profile\nLanding Page\nWebsite Bisnis\nWebsite Organisasi\nContent Management System", 'icon' => 'window', 'sort_order' => 1]),
            $this->row('services', ['title' => 'Web Application & Information Systems', 'description' => "Ubah proses operasional menjadi sistem yang lebih terintegrasi.\n\nSistem Informasi Manajemen\nDashboard & Data Management\nSistem Administrasi\nCustom Web Application\nIntegrasi API", 'icon' => 'layout', 'sort_order' => 2]),
            $this->row('services', ['title' => 'AI & Automation', 'description' => "Manfaatkan teknologi untuk menyederhanakan pekerjaan dan mengolah informasi.\n\nWorkflow Automation\nAI Integration\nMachine Learning Solutions\nData Processing\nIntelligent Systems", 'icon' => 'flow', 'sort_order' => 3]),
            $this->row('services', ['title' => 'Maintenance & Technical Support', 'description' => "Pastikan produk digital tetap berjalan dan siap berkembang.\n\nWebsite Maintenance\nBug Fixing\nPerformance Optimization\nServer & Deployment\nBackup & Documentation", 'icon' => 'shield', 'sort_order' => 4]),
        ]);

        Faq::insert([
            $this->faq('Berapa lama sebuah pekerjaan?', 'Tergantung lingkup. Landing yang sudah jelas arahnya bisa lebih singkat daripada dasbor dengan banyak peran. Perkiraan waktu dibahas setelah kebutuhan dipetakan.', 1),
            $this->faq('Apakah akses tetap di kami?', 'Ya. Hosting, domain, basis data, dan akun admin dibuka atas nama kamu. StepUp tidak menahan akses sebagai syarat kelanjutan.', 2),
            $this->faq('Bisa lanjut dari sistem yang sudah ada?', 'Bisa, selama akses dan kondisinya bisa diperiksa. Yang sudah berjalan tidak diganti hanya karena ingin terlihat baru.', 3),
            $this->faq('Bagaimana mulai?', 'Isi konteks singkat di halaman ini atau buka WhatsApp. Obrolan pertama cukup untuk memutuskan langkah berikutnya.', 4),
        ]);

        $blocks = [
            ['problem', '01', 'Data tidak terpusat', 'Informasi tersebar di berbagai spreadsheet, dokumen, dan percakapan. Sulit menemukan data yang benar ketika dibutuhkan.', 1],
            ['problem', '02', 'Proses memakan waktu', 'Pekerjaan berulang masih dilakukan secara manual, padahal bisa disederhanakan melalui sistem yang tepat.', 2],
            ['problem', '03', 'Tidak ada visibilitas', 'Sulit mengetahui perkembangan pekerjaan, memantau aktivitas, dan melihat hasil dalam satu tempat.', 3],
            ['problem', '04', 'Sulit dikembangkan', 'Sistem yang dibangun tanpa perencanaan sering kali sulit dirawat, diperbarui, atau dikembangkan ketika kebutuhan berubah.', 4],
            ['method', '01', 'Discover', "Memahami kebutuhan.\n\nKami mempelajari tujuan, tantangan, pengguna, dan proses kerja yang ingin diperbaiki.\n\nOutput: kebutuhan proyek dan ruang lingkup pekerjaan.", 1],
            ['method', '02', 'Design', "Merancang solusi.\n\nMenyusun struktur sistem, alur pengguna, dan desain antarmuka sebelum masuk ke tahap pengembangan.\n\nOutput: rancangan UI/UX dan alur sistem.", 2],
            ['method', '03', 'Develop', "Membangun dan menguji.\n\nMengembangkan produk berdasarkan kesepakatan, melakukan pengujian, dan memastikan setiap fitur bekerja sebagaimana mestinya.\n\nOutput: produk digital yang siap diuji.", 3],
            ['method', '04', 'Deliver', "Menyerahkan dan mendampingi.\n\nMelakukan deployment, dokumentasi, dan serah terima akses agar sistem dapat digunakan dan dikelola dengan baik.\n\nOutput: produk, akses, dokumentasi, dan panduan penggunaan.", 4],
            ['principle', '01', 'Ownership Comes First', "Aset digital tetap milikmu.\n\nDomain, hosting, source code, dan data dikelola dengan transparan. Kepemilikan dan akses disepakati sejak awal.", 1],
            ['principle', '02', 'Clear Scope, Clear Results', "Semua pekerjaan punya arah.\n\nLingkup pekerjaan, fitur, estimasi waktu, dan hasil akhir dibicarakan sebelum pengembangan dimulai.", 2],
            ['principle', '03', 'Transparent Development', "Proses bisa dipantau.\n\nPerkembangan proyek dikomunikasikan secara berkala. Kendala dan perubahan disampaikan secara terbuka.", 3],
            ['principle', '04', 'Built for Continuity', "Tidak berhenti saat proyek selesai.\n\nDokumentasi, akses, dan panduan teknis menjadi bagian dari serah terima agar sistem dapat dilanjutkan dan dikembangkan.", 4],
        ];
        foreach ($blocks as [$group, $eyebrow, $title, $body, $order]) {
            Block::create([
                'group' => $group,
                'eyebrow' => $eyebrow,
                'title' => $title,
                'body' => $body,
                'is_published' => true,
                'sort_order' => $order,
            ]);
        }
    }

    private function project(string $title, string $slug, string $category, string $year, string $client, string $excerpt, string $body, array $tech, int $order, bool $featured): array
    {
        return [
            'title' => $title,
            'slug' => $slug,
            'category' => $category,
            'year' => $year,
            'client' => $client,
            'excerpt' => $excerpt,
            'body' => $body,
            'cover' => null,
            'gallery' => json_encode([]),
            'tech' => json_encode($tech),
            'live_url' => null,
            'repo_url' => null,
            'is_featured' => $featured,
            'is_published' => true,
            'sort_order' => $order,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function stamp(string $table, string $title, string $issuer, string $when, string $description): array
    {
        return $this->row($table, [
            'title' => $title,
            'issuer' => $issuer,
            'issued_on' => $when,
            'credential_url' => null,
            'image' => null,
            'description' => $description,
            'sort_order' => 0,
        ]);
    }

    private function faq(string $question, string $answer, int $order): array
    {
        return $this->row('faqs', [
            'question' => $question,
            'answer' => $answer,
            'sort_order' => $order,
        ]);
    }

    private function row(string $table, array $extra): array
    {
        return array_merge($extra, [
            'is_published' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
