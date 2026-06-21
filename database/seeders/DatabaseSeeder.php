<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::create([
            'name' => 'Admin Bumdes',
            'email' => 'admin@gmail.com',
            'is_admin' => '1',
            'no_telepon' => '082387120434',
            'password' => 'password'
        ]);
        
        \App\Models\User::create([
            'name' => 'Direktur Bumdes',
            'email' => 'direktur@gmail.com',
            'password' => 'password'
        ]);
        
        \App\Models\Dokumentasi::create([
            'judul' => "Grand Opening Dan Harlah BUBERTA Ke 7 Tahun 2025",
            'tanggal' => '2025-08-07',
            'gambar' => 'gambar_1.png',
            'kontent' => "<div><strong>Betara, 7 Agustus 2025</strong> – Badan Usaha Milik Desa (BUMDes) Bersama Betara menggelar acara <strong>Grand Opening usaha rental mobil BUBERTA</strong> yang dirangkaikan dengan peringatan <strong>Hari Lahir (Harlah) BUBERTA ke-7 tahun</strong> pada Kamis (7/8/2025). Kegiatan berlangsung di <strong>Jl. Lintas Kuala Tungkal–Jambi, Desa Mekar Jaya, Kecamatan Betara, Kabupaten Tanjung Jabung Barat</strong>.</div><div>Acara tersebut dihadiri oleh <strong>Bupati Tanjung Jabung Barat</strong>, Drs. H. Anwar Sadat, M.Ag., bersama Camat Betara, Kepala Desa Mekar Jaya, Direktur BUMDes Bersama Betara, Ketua BPD, serta berbagai unsur masyarakat dan tamu undangan lainnya.</div><div>Grand Opening ini menandai dibukanya unit usaha baru BUBERTA di bidang <strong>jasa rental mobil</strong> dengan dua armada yang siap melayani kebutuhan transportasi masyarakat. Kehadiran usaha baru ini diharapkan dapat memberikan kemudahan akses transportasi sekaligus menjadi sumber pendapatan baru bagi BUMDes Bersama Betara.</div><div>Dalam sambutannya, Bupati Tanjung Jabung Barat menyampaikan apresiasi atas perkembangan BUMDes Bersama Betara yang terus berinovasi dalam mengembangkan usaha desa. Menurutnya, keberadaan unit usaha rental mobil merupakan langkah positif dalam meningkatkan kemandirian ekonomi desa serta membuka peluang pelayanan yang lebih baik bagi masyarakat.</div><div>Sementara itu, Direktur BUMDes Bersama Betara menyampaikan bahwa peringatan Harlah ke-7 menjadi momentum untuk memperkuat komitmen dalam mengelola usaha secara profesional dan berkelanjutan. Ia berharap unit usaha rental mobil yang baru diluncurkan dapat berkembang dan memberikan manfaat bagi masyarakat Desa Mekar Jaya maupun wilayah sekitar Kecamatan Betara.<br>Melalui perayaan Harlah ke-7 dan peluncuran unit usaha baru ini, BUBERTA diharapkan terus tumbuh sebagai badan usaha desa yang mampu mendorong peningkatan perekonomian masyarakat serta menjadi contoh pengelolaan usaha desa yang produktif dan inovatif di Kabupaten Tanjung Jabung Barat.</div>",
        ]);
        
        \App\Models\Dokumentasi::create([
            'judul' => "Grand Opening Kafe Literasi BUMDes, Hadirkan Ruang Edukasi dan Kreativitas bagi Masyarakat",
            'tanggal' => '2026-01-29',
            'gambar' => 'gambar_2.png',
            'kontent' => "<div><strong>Mekar Jaya, 7 Agustus 2025</strong> – Badan Usaha Milik Desa (BUMDes) Bersama Betara resmi menggelar <strong>Grand Opening Kafe Literasi</strong> sebagai salah satu unit usaha baru yang dikembangkan untuk mendukung peningkatan kualitas sumber daya manusia dan pemberdayaan ekonomi masyarakat desa. Acara yang berlangsung di Desa Mekar Jaya, Kecamatan Betara, Kabupaten Tanjung Jabung Barat tersebut dihadiri oleh unsur pemerintah daerah, tokoh masyarakat, pemuda, serta masyarakat setempat.</div><div>Kafe Literasi hadir sebagai konsep usaha yang menggabungkan layanan kuliner dengan ruang baca dan belajar yang nyaman. Selain menyediakan berbagai menu makanan dan minuman, kafe ini juga dilengkapi dengan koleksi buku, akses internet, serta area diskusi yang dapat dimanfaatkan oleh pelajar, mahasiswa, dan masyarakat umum.</div><div>Direktur BUMDes Bersama Betara dalam sambutannya menyampaikan bahwa pendirian Kafe Literasi merupakan bentuk inovasi BUMDes dalam menghadirkan usaha yang tidak hanya berorientasi pada keuntungan ekonomi, tetapi juga memberikan manfaat sosial dan pendidikan bagi masyarakat.</div><div>“Melalui Kafe Literasi, kami ingin menyediakan ruang yang dapat menjadi pusat kegiatan belajar, berdiskusi, dan berkreasi bagi generasi muda. Kami berharap tempat ini dapat menjadi wadah yang mendorong budaya membaca dan meningkatkan minat literasi masyarakat,” ujarnya.</div><div>Acara grand opening ditandai dengan pemotongan pita dan peninjauan fasilitas kafe oleh para tamu undangan. Masyarakat yang hadir juga berkesempatan menikmati berbagai kegiatan seperti bedah buku, diskusi ringan, dan pengenalan program literasi yang akan rutin dilaksanakan di kafe tersebut.</div><div>Kepala Desa Mekar Jaya menyambut baik kehadiran unit usaha baru ini dan berharap Kafe Literasi dapat menjadi ikon desa yang mampu menarik minat masyarakat sekaligus mendukung perkembangan pendidikan dan kreativitas generasi muda.</div><div>Dengan diresmikannya Kafe Literasi, BUMDes Bersama Betara menunjukkan komitmennya dalam mengembangkan usaha yang produktif, inovatif, dan berdampak positif bagi kemajuan masyarakat serta pembangunan desa secara berkelanjutan.</div>",
        ]);
        
        \App\Models\Dokumentasi::create([
            'judul' => "Pengurus BUMDes Bersama Betara Sampaikan Ucapan Selamat Hari Raya Idul Fitri 1447 H",
            'tanggal' => '2026-03-21',
            'gambar' => 'gambar_3.png',
            'kontent' => "<div><strong>Mekar Jaya</strong> – Dalam rangka menyambut Hari Raya Idul Fitri 1447 Hijriah, Pengurus dan Pengelola BUMDes Bersama Betara menyampaikan ucapan selamat kepada seluruh masyarakat Desa Mekar Jaya, Kecamatan Betara, serta masyarakat Kabupaten Tanjung Jabung Barat.</div><div>Melalui momentum hari kemenangan setelah menjalankan ibadah puasa Ramadan, Pengurus BUMDes Bersama Betara mengajak seluruh masyarakat untuk mempererat tali silaturahmi, memperkuat rasa persaudaraan, serta menjadikan Idul Fitri sebagai sarana untuk saling memaafkan dan memperkuat kebersamaan dalam membangun desa.</div><div>Direktur BUMDes Bersama Betara menyampaikan bahwa Idul Fitri tidak hanya menjadi perayaan keagamaan, tetapi juga momentum untuk memperkuat semangat gotong royong dan kerja sama dalam mewujudkan kemajuan desa. Menurutnya, nilai-nilai kebersamaan yang diajarkan selama bulan Ramadan dapat menjadi landasan dalam meningkatkan partisipasi masyarakat terhadap pembangunan dan pengembangan usaha desa.</div><div>“Atas nama Pengurus dan Pengelola BUMDes Bersama Betara, kami mengucapkan Selamat Hari Raya Idul Fitri 1447 H. Minal Aidin Wal Faizin, Mohon Maaf Lahir dan Batin. Semoga Allah SWT senantiasa melimpahkan rahmat, keberkahan, kesehatan, dan kebahagiaan kepada kita semua,” ujarnya.</div><div>Lebih lanjut, BUMDes Bersama Betara berkomitmen untuk terus menghadirkan berbagai program dan layanan yang bermanfaat bagi masyarakat sebagai bagian dari upaya meningkatkan kesejahteraan dan kemandirian ekonomi desa.</div><div>Melalui semangat Idul Fitri, diharapkan hubungan antara pemerintah desa, pengurus BUMDes, dan masyarakat dapat semakin harmonis sehingga mampu bersama-sama mewujudkan desa yang maju, mandiri, dan sejahtera.</div><div><strong>Keluarga Besar BUMDes Bersama Betara mengucapkan Selamat Hari Raya Idul Fitri 1447 H. Minal Aidin Wal Faizin, Mohon Maaf Lahir dan Batin.</strong> Semoga keberkahan dan kebahagiaan senantiasa menyertai seluruh masyarakat.</div>",
        ]);
        
        \App\Models\Dokumentasi::create([
            'judul' => "BUMDes Bersama Betara Informasikan Pelayanan Kembali Beroperasi Normal",
            'tanggal' => '2026-03-25',
            'gambar' => 'gambar_4.png',
            'kontent' => "<div><strong>Mekar Jaya, 25 Maret 2026</strong> – BUMDes Bersama Betara (B3) menginformasikan kepada seluruh nasabah bahwa mulai <strong>Rabu, 25 Maret 2026</strong>, kantor BUMDes Bersama Betara telah kembali beroperasi dan melayani berbagai transaksi sebagaimana biasanya.</div><div>Dengan dibukanya kembali pelayanan kantor, masyarakat dan nasabah dapat melakukan berbagai keperluan administrasi maupun transaksi sesuai dengan jam operasional yang berlaku. Pengelola BUMDes Bersama Betara memastikan bahwa seluruh layanan telah siap beroperasi untuk memberikan pelayanan yang optimal kepada masyarakat.</div><div>Pihak BUMDes Bersama Betara juga mengucapkan terima kasih kepada seluruh nasabah atas perhatian, pengertian, dan kepercayaan yang telah diberikan selama ini. Diharapkan dengan beroperasinya kembali kantor BUMDes, pelayanan kepada masyarakat dapat berjalan dengan lancar dan semakin meningkatkan kualitas layanan yang diberikan.</div><div>Untuk informasi lebih lanjut terkait layanan dan operasional, nasabah dapat langsung menghubungi atau mendatangi kantor BUMDes Bersama Betara pada jam kerja.</div><div><strong>Terima kasih. Salam BUMDes Bersama Betara (B3).</strong></div>",
        ]);
        
        \App\Models\Dokumentasi::create([
            'judul' => "B3 Farm, Unit Usaha Peternakan Ayam Petelur BUMDes Bersama Betara",
            'tanggal' => '2026-03-26',
            'gambar' => 'gambar_5.png',
            'kontent' => "<div><strong>Mekar Jaya</strong> – Dalam upaya memperkuat perekonomian desa dan menciptakan sumber pendapatan yang berkelanjutan, BUMDes Bersama Betara terus mengembangkan berbagai unit usaha produktif. Salah satu unit usaha yang saat ini menjadi andalan adalah <strong>B3 Farm</strong>, yang bergerak di bidang peternakan ayam petelur.</div><div>B3 Farm didirikan sebagai bentuk komitmen BUMDes Bersama Betara dalam mendukung ketahanan pangan sekaligus membuka peluang usaha yang mampu memberikan manfaat ekonomi bagi masyarakat. Melalui usaha peternakan ayam petelur, B3 Farm berfokus pada produksi telur berkualitas untuk memenuhi kebutuhan masyarakat di Desa Mekar Jaya dan wilayah sekitarnya.</div><div>Dengan pengelolaan yang baik serta penerapan standar pemeliharaan yang tepat, B3 Farm berupaya menghasilkan produk yang sehat, aman, dan berkualitas. Selain menjadi sumber pendapatan bagi BUMDes, keberadaan unit usaha ini juga diharapkan dapat menciptakan lapangan pekerjaan serta meningkatkan keterlibatan masyarakat dalam kegiatan ekonomi produktif di desa.</div><div>Direktur BUMDes Bersama Betara menyampaikan bahwa pengembangan B3 Farm merupakan langkah strategis dalam diversifikasi usaha desa. Menurutnya, sektor peternakan memiliki prospek yang menjanjikan karena kebutuhan masyarakat terhadap telur sebagai sumber protein terus meningkat dari waktu ke waktu.</div><div>Ke depan, B3 Farm diharapkan mampu meningkatkan kapasitas produksi dan memperluas jangkauan pemasaran sehingga dapat memberikan kontribusi yang lebih besar terhadap pertumbuhan ekonomi desa. Melalui inovasi dan pengelolaan yang berkelanjutan, BUMDes Bersama Betara berkomitmen untuk terus menghadirkan unit-unit usaha yang produktif, mandiri, dan bermanfaat bagi kesejahteraan masyarakat.</div><div>Dengan semangat kemandirian dan gotong royong, B3 Farm menjadi salah satu wujud nyata peran BUMDes Bersama Betara dalam membangun desa yang maju, produktif, dan berdaya saing.</div>",
        ]);

        \App\Models\Vehicle::create([
            'no_plat' => 'BH 8123 EE',
            'merek' => 'DC Hilux',
            'warna' => 'Putih',
            'tahun' => '2019',
            'harga_perhari' => '1200000',
            'denda_perhari' => '1300000',
            'harga_perbulan' => '2300000',
            'sewa_driver' => '450000',
            'gambar' => 'dc_hilux.jpeg'
        ]);

        \App\Models\Vehicle::create([
            'no_plat' => 'BH 7732 EE',
            'merek' => 'DC Triton',
            'warna' => 'Putih',
            'tahun' => '2019',
            'harga_perhari' => '1100000',
            'denda_perhari' => '1200000',
            'harga_perbulan' => '2200000',
            'sewa_driver' => '450000',
            'gambar' => 'dc_triton.jpeg'
        ]);

    }
}
