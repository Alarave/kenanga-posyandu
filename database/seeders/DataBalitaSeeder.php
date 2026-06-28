<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Posyandu;
use Carbon\Carbon;

class DataBalitaSeeder extends Seeder
{
    public function run()
    {
        // Data hasil ekstraksi dari gambar (Tabel Balita)
        $data = [
            ['Ciara Hafza', 'Djaka S', '01/11', 'P', '2020-11-11', 15.7, 98, 'T'],
            ['Aisyah Hanin', 'Yuniar P', '04/11', 'P', '2020-11-30', 20, 99, 'N'],
            ['Chayra Aretha', 'Almi T', '02/11', 'P', '2020-11-30', 16.5, 101, 'T'],
            ['Alfian Zafran', 'M. Asysyam', '03/11', 'L', '2021-02-03', 21.2, 111, 'T'],
            ['M. Said', 'Raqil', '02/11', 'L', '2021-04-20', 15.7, 96, 'T'],
            ['Vallera Darren R', 'Usman', '02/11', 'L', '2021-04-23', 15.8, 101, 'T'],
            ['Salwa D.Z', 'Heri S', '01/11', 'P', '2020-02-29', 32, 111, 'T'],
            ['Nafa Nael', 'Marjotan', '01/11', 'P', '2021-02-21', 18.5, 99, 'T'],
            ['Sabhira', 'Murdiansyah', '01/11', 'P', '2021-02-28', 16.4, 97, 'T'],
            ['Tsabina A.L', 'Asty K.2', '03/11', 'P', '2021-11-29', 14.5, 96, 'T'],
            ['Ganesh M.D', 'Adi Rosa', '01/11', 'L', '2022-01-06', 12.4, 93, 'T'],
            ['Ryuga A.H', 'Rahmat T', '02/11', 'L', '2022-02-03', 19.5, 100, 'T'],
            ['Anindya Dhea', 'M. Asysyam', '02/11', 'P', '2022-02-28', 15.7, 93, 'T'],
            ['Mikael', 'Winson', '01/11', 'L', '2022-04-03', 14, 96, 'N'],
            ['Arka', 'Suherman', '02/11', 'L', '2022-05-21', 12.7, 96, 'T'],
            ['Khaizanu', 'Heriyawan', '03/11', 'L', '2022-05-21', 16.9, 96, 'T'],
            ['Fatimah Yuni', 'A. Akbari', '01/11', 'P', '2022-05-22', 13.5, 90, 'T'],
            ['Arfan Sidqi', 'Jodi', '08/11', 'L', '2022-05-29', 19.4, 99, 'T'],
            ['Nabila Warna', 'Adri M.S', '01/11', 'P', '2022-01-03', 11.5, 89, 'T'],
            ['Aseela Fida', 'Ujang', '04/11', 'P', '2022-03-07', 13, 92, 'N'],
            ['Mahira N.P.E.A', 'Duta A', '02/11', 'P', '2022-03-13', 16.8, 89, 'T'],
            ['A. Zafran U.R', 'Byan R.R', '04/11', 'L', '2022-03-06', 16.1, 99, 'T'],
            ['Ratu Raline VCB', 'Bachtiar', '02/11', 'P', '2022-10-07', 13.8, 92, 'T'],
            ['Mikhayla A.F', 'Catur I', '03/11', 'P', '2022-02-26', 12.5, 91, 'O'],
            ['Safia', 'Wisnu', '02/11', 'L', '2023-01-05', 17.4, 97, 'T'],
            ['Moriel N.P.A', 'Muel K', '02/11', 'P', '2023-03-25', 10.7, 86, 'T'],
            ['Albiru', 'Ariestya', '01/11', 'L', '2023-03-25', 12.5, 88, 'T'],
            ['Shaynala', 'Syahmi', '03/11', 'P', '2023-04-10', 12.5, 92, 'T'],
            ['M. Azzumar', 'M. Kamaludin', '02/11', 'L', '2023-04-16', 11.5, 84, 'T'],
            ['Adi Tama', 'Dodi F', '03/11', 'L', '2023-04-22', 13.5, 92, 'N'],
            ['Galvin Zane', 'Ananda', '04/11', 'P', '2023-05-22', 13, 92, 'N'],
            ['Jasmin', 'Oji', '04/11', 'P', '2023-06-14', 12.5, 78, 'T'],
            ['Bladis A', 'Adi Rosa', '01/11', 'P', '2023-06-21', 10.4, 85, 'T'],
            ['M. Ichsan A', 'Imam', '02/11', 'L', '2023-06-26', 12.8, 93, 'T'],
            ['Askara A', 'Arindra', '02/11', 'P', '2023-09-20', 11.8, 75, 'T'],
            ['Azzam Ropasisa', 'Irwansyah', '01/11', 'L', '2023-09-11', 10.7, 82, 'T'],
            ['M. Zidan A', 'Rafdi H', '03/11', 'L', '2023-09-10', 12.7, 85, 'T'],
            ['Faiza Takzia', 'Hardian', '01/11', 'P', '2023-10-15', 12.2, 89, 'T'],
            ['Annisa Zafran', 'Riangga', '01/11', 'P', '2023-11-09', 10.7, 85, 'T'],
            ['Abraham', 'Riswan', '02/11', 'L', '2024-02-29', 11.9, 87, 'T'],
            ['Ashraf Faisan', 'Alan F', '04/11', 'L', '2024-02-20', 11, 80, 'N'],
            ['Serenata U.T', 'Theresia', '04/11', 'P', '2024-08-20', 11.8, 93, 'T'],
            ['Kirai Hafza H', 'Rahmat Tri', '02/11', 'P', '2024-03-24', 13.3, 92, 'T'],
            ['Oki', 'Mikail', '02/11', 'L', '2024-04-22', 10.9, 85, 'T'],
            ['Angawira A.A', 'Aldifa', '02/11', 'L', '2024-05-07', 11.5, 82, 'T'],
            ['M. Albifarzan', 'M. Yuda', '01/11', 'L', '2024-08-06', 10, 75, 'T'],
            ['Abhiprana A.S', 'Arief S.S', '02/11', 'P', '2024-08-20', 9.5, 73, 'T'],
            ['M. Maulia R', 'Eva K', '03/11', 'L', '2024-09-05', 9.5, 72, 'T'],
            ['Elisa Shanum A', 'Putra T.A', '01/11', 'P', '2024-09-23', 8.9, 73, 'T'],
            ['Alena Shalihah', 'Ghena P', '04/11', 'P', '2024-10-03', 8.5, 99, 'T'],
            ['Haura R.R', 'Ridwan', '04/11', 'P', '2024-10-04', 9, 76, 'N'],
            ['Barra Al Fatih', 'Wiwit A', '01/11', 'L', '2024-10-01', 14, 80, 'N'],
            ['Soca M.N', 'Ivan B.P', '01/11', 'P', '2025-06-05', 9.3, 69, 'T'],
            ['Mishael N.P.A', 'Muel K', '02/11', 'P', '2025-03-24', 6.9, 69, 'T'],
            ['M. Zaid U', 'Harry L', '03/11', 'L', '2025-06-20', 9.2, 71, 'T'],
            ['Lanang V.A', 'Joko', '04/11', 'L', '2025-06-28', 3.2, 69, 'T'],
            ['Raisa Amarilia S', 'Aditya R', '03/11', 'P', '2025-06-12', 6.9, 64, 'T'],
            ['Grace Veliora', 'Bachtiar', '02/11', 'P', '2025-03-26', 5, 61, 'T'],
            ['M. Zacky J', 'M. Asysyam', '01/11', 'L', '2025-08-01', 7.5, 66, 'N'],
            ['Athertina A.G', 'Ismu', '04/11', 'P', '2025-08-03', 6.9, 44, 'T'],
            ['Hasan Asyub A', 'M. Endang', '01/11', 'L', '2025-09-11', 5.7, 60, 'N'],
            ['M. Ibrahim R', 'Hardian', '01/11', 'L', '2025-09-27', 6.4, 64, 'N'],
            ['Arcelia A.A', 'Aldifa', '02/11', 'P', '2025-10-07', 4.8, 59, 'T'],
            ['Barrea Ghazala A', 'Ali Baba A', '01/11', 'P', '2022-05-06', 15.5, 104, 'B'],
            ['Khanza Hamdia A', 'M. Bayu', '03/11', 'P', '2025-11-30', 4.4, 54, 'B'],
            ['Faturrasya Shabir', 'Sutono', '02/11', 'L', '2022-10-17', 14.3, 97, 'B'],
            ['Kautsar Arsaka', 'Zakky B', '03/11', 'L', '2025-12-20', 3.1, 51, 'B'],
            ['Sabhira N.R', 'Sutono', '02/11', 'P', '2024-08-02', 9.9, 74, 'B'],
        ];

        $posyandu = Posyandu::first();
        $posyanduId = $posyandu ? $posyandu->id : 1;
        $visitDate = '2026-01-05'; // Sesuai permintaan 5 Januari 2026

        foreach ($data as $item) {
            // Pastikan tidak ada data ganda dengan nama yang sama persis
            $patient = Patient::updateOrCreate(
                ['full_name' => $item[0]],
                [
                    'category' => 'balita',
                    'gender' => $item[3] === 'L' ? 'L' : 'P',
                    'birth_date' => $item[4],
                    'mother_name' => $item[1],
                    'dusun_rt_rw' => $item[2],
                    'weight_at_birth' => 3.0,
                    'height_at_birth' => 50.0, // Sesuai permintaan
                    'status_mutasi' => 'aktif',
                    'posyandu_id' => $posyanduId,
                    'id_number' => \Faker\Factory::create('id_ID')->unique()->numerify('################'),
                    'address' => 'RT/RW ' . $item[2] // Add address
                ]
            );

            // Jika Patient baru saja dibuat atau belum punya Medical Record di tanggal tersebut, buatkan
            MedicalRecord::updateOrCreate(
                [
                    'patient_id' => $patient->id,
                    'visit_date' => $visitDate,
                ],
                [
                    'weight' => $item[5],
                    'height' => $item[6],
                    'weight_status' => $item[7],
                    'nutrition_status' => null, // Biar diset sistem otomatis jika ada trigger, atau kosong dulu
                    'complaint' => '-',
                    'health_note' => '-',
                    'diagnosis' => '-',
                    'user_id' => 1 // ID kader/admin pertama
                ]
            );
        }
    }
}
