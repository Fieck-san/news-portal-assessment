<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $authors = collect([
            ['name' => 'Aina Rahman', 'title' => 'Senior Reporter'],
            ['name' => 'Daniel Lee', 'title' => 'News Editor'],
            ['name' => 'Priya Nair', 'title' => 'Political Correspondent'],
        ])->map(fn (array $author) => Author::factory()->create($author));

        $categories = collect([
            ['name' => 'Terkini', 'name_en' => 'Latest', 'slug' => 'terkini', 'sort_order' => 1],
            ['name' => 'Global', 'name_en' => 'Global', 'slug' => 'global', 'sort_order' => 2],
            ['name' => 'Politik', 'name_en' => 'Politics', 'slug' => 'politik', 'sort_order' => 3],
            ['name' => 'Bisnes', 'name_en' => 'Business', 'slug' => 'bisnes', 'sort_order' => 4],
            ['name' => 'Sukan', 'name_en' => 'Sports', 'slug' => 'sukan', 'sort_order' => 5],
            ['name' => 'Pendapat', 'name_en' => 'Opinion', 'slug' => 'pendapat', 'sort_order' => 6],
        ])->mapWithKeys(fn (array $category) => [
            $category['slug'] => Category::factory()->create($category),
        ]);

        $articles = [
            [
                'category' => 'terkini',
                'title' => 'Kerajaan umum inisiatif baharu pantau harga barang harian',
                'title_en' => 'Government announces new initiative to monitor daily goods prices',
                'summary' => 'Langkah baharu itu memberi tumpuan kepada laporan pengguna, data pasar raya dan tindakan susulan agensi penguatkuasaan.',
                'summary_en' => 'The new measure focuses on consumer reports, supermarket data and follow-up action by enforcement agencies.',
            ],
            [
                'category' => 'politik',
                'title' => 'Ahli Parlimen gesa jawatankuasa khas teliti reformasi institusi',
                'title_en' => 'MP urges special committee to review institutional reforms',
                'summary' => 'Cadangan itu dibangkitkan selepas beberapa siri perbahasan mengenai ketelusan dan semak imbang pentadbiran.',
                'summary_en' => 'The proposal was raised after a series of debates on transparency and administrative checks and balances.',
            ],
            [
                'category' => 'global',
                'title' => 'Sidang serantau bincang keselamatan makanan dan perubahan iklim',
                'title_en' => 'Regional summit discusses food security and climate change',
                'summary' => 'Negara peserta bersetuju memperkukuh kerjasama logistik bagi melindungi rantaian bekalan penting.',
                'summary_en' => 'Participating countries agreed to strengthen logistics cooperation to protect critical supply chains.',
            ],
            [
                'category' => 'bisnes',
                'title' => 'Syarikat teknologi tempatan perluas operasi ke pasaran Asia Tenggara',
                'title_en' => 'Local technology firm expands operations across Southeast Asia',
                'summary' => 'Pengembangan itu dijangka membuka peluang pekerjaan baharu dalam bidang produk digital dan sokongan pelanggan.',
                'summary_en' => 'The expansion is expected to create new jobs in digital products and customer support.',
            ],
            [
                'category' => 'sukan',
                'title' => 'Skuad muda negara catat kemenangan dramatik pada minit akhir',
                'title_en' => 'National youth squad seals dramatic last-minute victory',
                'summary' => 'Gol lewat permainan memastikan pasukan negara mengekalkan momentum menjelang perlawanan seterusnya.',
                'summary_en' => 'A late goal helped the national side maintain momentum ahead of its next match.',
            ],
            [
                'category' => 'pendapat',
                'title' => 'Mengapa literasi media semakin penting dalam musim pilihan raya',
                'title_en' => 'Why media literacy matters more during election season',
                'summary' => 'Pembaca perlu memahami sumber, konteks dan bukti sebelum berkongsi kandungan politik di media sosial.',
                'summary_en' => 'Readers need to understand sources, context and evidence before sharing political content on social media.',
            ],
            [
                'category' => 'terkini',
                'title' => 'Pihak berkuasa tempatan lancar sistem aduan digital bersepadu',
                'title_en' => 'Local authority launches integrated digital complaint system',
                'summary' => 'Platform itu membolehkan penduduk menjejak status aduan dan melihat maklum balas jabatan berkaitan.',
                'summary_en' => 'The platform lets residents track complaint status and view responses from relevant departments.',
            ],
            [
                'category' => 'politik',
                'title' => 'Parti komponen bincang strategi komunikasi menjelang persidangan tahunan',
                'title_en' => 'Component parties discuss communication strategy before annual conference',
                'summary' => 'Mesyuarat tertutup itu memberi tumpuan kepada isu kos sara hidup dan penyampaian dasar kepada pengundi muda.',
                'summary_en' => 'The closed-door meeting focused on cost-of-living issues and policy messaging for young voters.',
            ],
            [
                'category' => 'global',
                'title' => 'Pasaran Asia ditutup bercampur selepas data inflasi terbaharu',
                'title_en' => 'Asian markets close mixed after latest inflation data',
                'summary' => 'Pelabur mengambil pendekatan berhati-hati sementara menunggu isyarat lanjut daripada bank pusat utama.',
                'summary_en' => 'Investors took a cautious approach while waiting for further signals from major central banks.',
            ],
            [
                'category' => 'bisnes',
                'title' => 'Usahawan kecil manfaatkan pembayaran digital untuk tingkat jualan',
                'title_en' => 'Small entrepreneurs use digital payments to increase sales',
                'summary' => 'Kajian industri menunjukkan penggunaan dompet elektronik membantu peniaga kecil mempercepat transaksi harian.',
                'summary_en' => 'Industry research shows that e-wallet adoption helps small traders speed up daily transactions.',
            ],
            [
                'category' => 'terkini',
                'title' => 'Hospital awam tambah kaunter saringan bagi kurangkan waktu menunggu',
                'title_en' => 'Public hospital adds screening counters to reduce waiting times',
                'summary' => 'Inisiatif rintis itu bermula minggu ini dan akan diperluas jika maklum balas pesakit memuaskan.',
                'summary_en' => 'The pilot initiative begins this week and will be expanded if patient feedback is positive.',
            ],
            [
                'category' => 'pendapat',
                'title' => 'Editorial: Data terbuka boleh menguatkan kepercayaan awam',
                'title_en' => 'Editorial: Open data can strengthen public trust',
                'summary' => 'Akses kepada data yang jelas dan mudah dibaca membantu rakyat menilai keberkesanan sesuatu dasar.',
                'summary_en' => 'Access to clear and readable data helps people evaluate the effectiveness of public policy.',
            ],
        ];

        foreach ($articles as $index => $article) {
            News::factory()
                ->for($categories[$article['category']], 'category')
                ->for($authors->random(), 'author')
                ->create([
                    'title' => $article['title'],
                    'title_en' => $article['title_en'],
                    'slug' => Str::slug($article['title']),
                    'summary' => $article['summary'],
                    'summary_en' => $article['summary_en'],
                    'body' => $this->bodyFor($article['title']),
                    'body_en' => $this->englishBodyFor($article['title_en']),
                    'image_url' => 'https://picsum.photos/seed/kini-'.$index.'/960/540',
                    'is_featured' => $index < 2,
                    'published_at' => now()->subHours($index * 3 + 1),
                ]);
        }
    }

    private function bodyFor(string $title): string
    {
        return implode("\n\n", [
            $title.' menjadi perhatian pembaca selepas perkembangan terbaharu dilaporkan pagi ini.',
            'Menurut sumber yang ditemui, langkah susulan sedang dirangka bagi memastikan pelaksanaan berjalan dengan lebih teratur dan telus.',
            'Pemerhati berkata isu ini perlu dilihat secara menyeluruh kerana ia menyentuh kepentingan pengguna, pembuat dasar dan komuniti setempat.',
            'Perkembangan lanjut dijangka diumumkan selepas sesi libat urus bersama pihak berkepentingan selesai.',
        ]);
    }

    private function englishBodyFor(string $title): string
    {
        return implode("\n\n", [
            $title.' drew reader attention after the latest development was reported this morning.',
            'According to sources contacted, follow-up measures are being prepared to ensure implementation is more orderly and transparent.',
            'Observers said the issue should be viewed in full because it affects consumers, policymakers and local communities.',
            'Further updates are expected after engagement sessions with stakeholders are completed.',
        ]);
    }
}
