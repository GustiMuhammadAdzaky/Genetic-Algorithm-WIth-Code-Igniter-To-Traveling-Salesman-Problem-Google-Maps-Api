<?php

namespace App\Models;

use CodeIgniter\Model;

class Ag extends Model
{
    public $TITIK = array();
    public $num_crommosom; //jumlah kromosom awal yang dibangkitkan
    public $data = array();
    public $generation = 0; //generasi ke....
    public $max_generation = 25; //maksimal generasi
    public $crommosom = array(); //array kromosom sesuai $num_cromosom 
    public $success = false; //keadaan jika sudah ada sulosi terbaik
    public $debug = true; //menampilkan debug jika diset true;  
    public $fitness = array(); //nilai fitness setiap kromosom
    public $console = ""; //menyimpan proses algoritma 

    public $total_fitness = 0; //menyimpan total fitness untuk masing-masing kromosom
    public $probability  = array(); //menyimpan probabilitas fitness masing-masing kromosom
    public $com_pro = array(); //menyimpan fitness komulatif untuk masing masing kromosom
    public $rand = array(); //menyimpan bilangan rand())
    public $parent = array(); //menyimpan parent saat crossover

    public $best_fitness = 0; //menyimpan nilai fitness tertinggi
    public $best_cromossom = array(); //menyimpan kromosom dengan fitness tertinggi 

    public $crossover_rate = 75; //prosentase kromosom yang akan dipindah silang
    public $mutation_rate = 25; //prosentase kromosom yang akan dimutasi

    public $time_start; //menyimpan waktu mulai proses algotitma
    public $time_end; //menyimpan waktu selesai proses algoritma

    public $fitness_history = array(); // elitsme

    public $temp = array();
    // public $data;

    public $titik_awal = '';


    public function __construct($data, $titik_awal, $titik)
    {
        $this->TITIK = $titik;
        $this->data = $data;
        $this->titik_awal = $titik_awal;
        foreach ($data as $key => $val) {
            $this->best_fitness += array_sum($val);
        }
        // print_r($titik);

    }

    public function generate()
    {
        // membuat microtime sebelum perulangan
        $this->time_start = microtime(true);
        // Membuat Populasi bari
        $this->generate_crommosom();
        // d($this->crommosom);
        // -> generasi masih 0
        // -> Max generasi = data yang diinputkan pada form ke 4
        // -> $this->success = masih false, Bisa true apa bila sudah melakukan calculate_all_fitness()
        // jika generasi masih kurang dibawah dari inputan max generasi, dan variable sukses masih false lakukan perulangan(Batasan)
        while (($this->generation < $this->max_generation) && $this->success == false) {
            // menambah angka pada generasi sampai batasannya
            $this->generation++;
            // simpan generasi++ pada public $generation 
            $this->console .= "<h4>Generasi ke-$this->generation</h4>";
            // Menalankan show_crommosom() 
            $this->show_crommosom();
            // Menjalankan fungsi calculate_all_fitness() 
            $this->calculate_all_fitness();
            // menjalankan fungsi show_fitnes
            $this->show_fitness();


            // Untuk melakukan pembuktian cromosom terlah berubah, buka komentar line 447 sebagai kromosom yang belum di seleksi, buka line 213 sebagai induk dari untuk melihat nilai yang sudah di acak, dan buka line 139 untuk melihat chromosom yang sudah terseleksi dan terganti.
            if (!$this->success) { //jika fitness terbaik belum mencapai 0, dilanjutkan ke proses seleksi
                // Menghasilkan variable com_pro
                $this->get_com_pro();
                $this->selection();
                $this->show_crommosom();
                $this->calculate_all_fitness();
                $this->show_fitness();
                // d($this->console);
            }
            if (!$this->success) { //jika fitness terbaik belum mencapai 1, dilanjutkan ke proses crossover
                $this->crossover();
                $this->show_crommosom();
                $this->calculate_all_fitness();
                $this->show_fitness();
            }
            if (!$this->success) { //jika fitness terbaik belum mencapai 1, dilanjutkan ke proses mutasi
                $this->mutation();
                $this->show_crommosom();
                $this->calculate_all_fitness();
                $this->show_fitness();
            }
        }


        // mengakhiri microtime end
        $this->time_end = microtime(true);
        // mendapatkan waktu dari end ke start
        $time = $this->time_end - $this->time_start;
        // mengambil best fitness dan dilakukan pnggabungan string untuk Pre
        echo "<pre style='font-size:0.8em'>\r\nFITNESS TERBAIK: $this->best_fitness";
        // Balikan data time dan memori yang diguanakan
        echo "\r\nExecution Time: $time seconds";
        // Balikan data time dan memori yang diguanakan
        echo "\r\nMemory Usage: " . memory_get_usage() / 1024 . ' kilo bytes';
        // melakukan penggabungan string genetasi dari generai yang sudah diberikan operator++
        echo "\r\nGENERASI: $this->generation";
        // penggabungan string dengan print cros yang diisikan best_crommosom
        echo "\r\nCROMOSSOM/RUTE TERBAIK:  " . $this->print_cros($this->best_cromossom) . "</pre>";
        // $this->get_debug();      
        // Mengembalikan Best Cromosome sebagai value utama di maps
        // d($this->console);
        return $this->best_cromossom;
    }

    /**
     * proses mutasi pada AG
     * mutasi dilakukan sesuai prosentase "Mutation Rate" yang diinputkan
     */
    public function mutation()
    {
        // Mutasi  Vaarable
        $mutation = array();
        // Persiapkan text untuk mutasi
        $this->console .= "<h5>Mutasi generasi  ke-$this->generation</h5>\n";
        // Ambil gen per kromosom
        // d(count($this->data));
        $gen_per_cro = count($this->data) - 1;

        // total chrommosomm * generasi per kromosom

        // d(count($this->crommosom));

        $total_gen = count($this->crommosom) * $gen_per_cro;
        // d(0.25 * $total_gen);
        // d($total_gen);
        // d(count($this->crommosom));
        // pembulatan keatas dari mutasi rate / 100 dikali dengan total gemerasi
        $total_mutation = ceil($this->mutation_rate / 100 * $total_gen);
        // d($this->mutation_rate / 100 * $total_gen);
        // d($total_mutation);


        // melakukan perulangan
        for ($a = 1; $a <= $total_mutation; $a++) {
            // mengambil gen individu secara acak dengan cara membuat variable value  untuk di acak dengan parameter function random(1 sampai dengan gen perkromosom)
            $val = rand(1, $total_gen);
            // d($val);
            // mengambil nilai gen pada cromosom terpilih
            $cro_index = ceil($val / $gen_per_cro) - 1;
            // d($val);
            // d($gen_per_cro);
            // d($cro_index);
            // melakukan proses mutasi pada index 1
            $gen_index1 = (($val - 1)  % $gen_per_cro) + 1;
            // d($gen_index1);

            // melakukan proses mutasi pada index 2
            $gen_index2 = rand(0, $gen_per_cro - 1) + 1;

            // update gen pada individu terpilih
            $gen1 = $this->crommosom[$cro_index][$gen_index1];
            $gen2 = $this->crommosom[$cro_index][$gen_index2];
            // d($gen1);

            // update gen pada individu terpilih
            $this->console .= "rand($val): [$cro_index, $gen_index1 x $gen_index2] = " . implode(',', $this->kode_to_nama($this->crommosom[$cro_index]));

            // menyimpan individu terpilih
            $this->crommosom[$cro_index][$gen_index1] = $gen2;
            $this->crommosom[$cro_index][$gen_index2] = $gen1;

            $this->console .= " = " . implode(',', $this->kode_to_nama($this->crommosom[$cro_index])) . " \r\n";
        }
        // d($this->crommosom);
        return false;
    }


    public function crossover()
    {
        // Memasukan data pada console
        $this->console .= "<h5>Pindah silang generasi ke-$this->generation</h5>";
        // membuat variale kosong parrent
        // $parent = array();

        //menentukan kromosom mana saja sebagai induk
        //jumlahnya berdasarkan crossover rate 
        // Memasukan string pada valariable console untuk di cetak
        $this->console .= "Pertama kita bangkitkan bilangan acak R sebanyak jumlah populasi";
        // melakukan perulangan sebanyak chrommosom(populasi)
        foreach ($this->crommosom as $key => $val) {
            // d($val);
            // membuat blangan acak 
            $rnd = mt_rand() / mt_getrandmax();
            // d($rnd);
            // mencetak angka yang di random
            $this->console .= "\nrand([$key]) : " . round($rnd, 3);
            // jika random < $this->crossover_rate / 100
            if ($rnd <= $this->crossover_rate / 100)
                // ambil key nya dan masukan pada perent variable 
                $parent[] = $key;
        }
        // d($parent);
        //reset($this->crommosom);

        //menampilkan parent/induk setiap pindah silang        
        // foreach($parent as $key => $val) {
        //     $this->console.="\r\n Parent[$key] : $val \r\n";
        //     $this->console.="Ofspring[$val] : ";
        // }

        // 
        $parent = $parent;
        $c = count($parent);
        // d($parent);
        // d($c);

        //mulai proses pindah silang sesuai jumlah induk
        $this->temp['induk'] = '';
        $this->temp['detail'] = '';
        $this->temp['point'] = '';
        // jika c lebih dari 1 maka
        if ($c > 1) {
            for ($a = 0; $a < $c - 1; $a++) {
                $new_cro[$parent[$a]] = $this->get_crossover($parent[$a],  $parent[$a + 1]);
            }
            // d($new_cro);
            $this->console .= "\nOfspring[" . $parent[($c - 1)] . "] = chromosome[" . $parent[($c - 1)] . "] x chromosome[$parent[0]] \r";
            $new_cro[$parent[$c - 1]] = $this->get_crossover($parent[$c - 1],  $parent[0]);


            //menyimpan kromosom hasil pindah silang dan fitnessnya
            foreach ($new_cro as $key => $val) {
                $this->crommosom[$key] = $val;
            }
        }

        // d($this->crommosom);

        $this->console .= "\nInduk crossover: \r\n" . $this->temp['induk'];
        $this->console .= "Point: \r\n" . $this->temp['point'];
        $this->console .= "Proses crossover: \r\n" . $this->temp['detail'];
        $this->console .= "Dengan demikian populasi chromosome setelah melalui proses crossover adalah: \r\n";
    }


    public function get_crossover($key1, $key2)
    {

        $this->temp['induk'] .= "chro[$key1] x chro[$key2] \r\n";

        $cro1 = (array) $this->crommosom[$key1];
        $cro2 = (array) $this->crommosom[$key2];
        // d($cro1);
        // die;

        $jumlah_gen = count($cro1);
        // jumlah keturunan = Buat random 1 jumlah gen - 2
        // karna gen dicount berisikan 6 jadi hasil = 4
        $offspring = rand(1, $jumlah_gen - 2); // offspring = keturunan

        // melakukan perulangan pada chromomsom 1
        // -> result
        // ⇄0 => string (4) "T006"
        // ⇄1 => string (4) "T010"
        // ⇄2 => string (4) "T012"
        // ⇄3 => string (4) "T008"
        // ⇄4 => string (4) "T013"
        // ⇄5 => string (4) "T007"
        // ⇄6 => string (4) "T006"
        foreach ($cro1 as $key => $val) {
            // jika key dari cro1 <= offspring maka simpan value dari key tersebut
            if ($key <= $offspring)
                $new_cro[$key] = $val;
        }

        foreach ($cro2 as $key => $val) {
            if (!in_array($val, $new_cro))
                $new_cro[] = $val;
        }
        // d($cro1[0]);
        $new_cro[] = $cro1[0];


        $this->temp['point'] .= "C[$key1] = $offspring \r\n";
        $this->temp['detail'] .= "Offspring[$key1] = chromosome[$key1] x chromosome[$key2] \r\n";
        $this->temp['detail'] .= '            = [' . implode(',', $this->kode_to_nama($cro1)) . '] x [' . implode(',', $this->kode_to_nama($cro2)) . "] \r\n";
        $this->temp['detail'] .= '            = [' . implode(',', $this->kode_to_nama($new_cro)) . "] \r\n";
        // d($new_cro);
        return $new_cro;
    }


    /**
     * proses seleksi, memilih gen secara acak
     * dimana fitness yang besar mendapatkan kesempata yang lebih besar
     */

    public function selection()
    {

        $this->console .= "<h5>Seleksi generasi ke-$this->generation **</h5>";
        // menjalankan fungsi random yang memiliki variable $this->rand yang akan di random
        $this->get_rand();
        // d($this->rand);
        // die;
        $new_cro = array();
        // d($this->rand);
        // melakukan perulangan sebanyak random
        foreach ($this->rand as $key => $val) {
            // melakukan proses seleksi dengan menjalankan fungsu choose_selection
            $k = $this->choose_selection($val);
            // d($k);
            // cromosom baru secara random = cromosom yang sudah di seleksi
            $new_cro[$key] = $this->crommosom[$k];
            // fitnes random = fitnes dari data yang sudah di seleksi
            $this->fitness[$key] = $this->fitness[$k];
            // d($this->crommosom);
            // d($this->fitness);
            $this->console .= "K[$key] = rand(" . round($val, 3) . ") = K[$k] \r\n";
        }
        // echo "seleksi";
        $this->crommosom = $new_cro;
        // d($this->crommosom);
    }

    public function choose_selection($rand_numb = 0)
    {
        // melakukan perulangan com_pro
        foreach ($this->com_pro as $key => $val) {
            // jika random numb yang dihasilkan oleh get_rand lebih kecil atau sama dengan val, Ambil i dari nilai tersebut
            if ($rand_numb <= $val) {
                // d($rand_numb);
                // d($val);
                // d($key);
                // mengembalikan nilai dalam bilangan bulat / integer 
                return $key;
            }
        }
    }

    public function get_rand()
    {
        // Membuat variable random dengan array kosong
        $this->rand = array();

        // Melakukan perulangan sebanyak fitness n
        foreach ($this->fitness as $key => $val) {
            // merandom data
            $r = mt_rand() / mt_getrandmax();
            // memasukan data pada pubic rand
            $this->rand[] = $r;
            $this->console .= "R[$key] : $r \r\n";
        }
        // Mengembalikan data public ran yang sudah dilakukan perulangan
        // d($this->rand);
        $this->rand;
    }

    /**
     * mencari probabilitas untuk setiap fitness
     * rumusnya adalah  fitness / total fitness
     */
    public function get_probability()
    {
        $this->probability = array();
        // membuat array kosong
        $arr = array();
        // d(1 / $this->fitness[0]);
        // d($this->fitness);
        // Melakukan perulangan sebanyak fitness
        foreach ($this->fitness as $key => $val) {
            // i - 1
            // d($key);
            // d($val);
            // memasukan data arr[key/i] dengan logic value fitness akan dibagi 1 dan jika 0 = 0
            $arr[$key] = $val == 0 ? 0 : 1 / $val;
            // d(1 / $val);

        }
        // d($arr);
        // d(array_sum($arr));
        // d($arr[0] / array_sum($arr));
        // melakukan perulangan sebanyak arr
        foreach ($arr as $key => $val) {
            // x = array yang sudah di bagi seluruh array yang dibagi 1 akan di jumlahkan, dan di bagi dengan masing masing individu dan jika di jumlahkan pasti menjadi 1
            // d($arr);
            // d($val);
            // d(array_sum($arr));
            // x = tiap value dari 1 sampai 10 / seluruh jumlah dari tiap value(arr)
            $x = (array_sum($arr) == 0) ? 0 : $val / array_sum($arr);
            // d(array_sum($arr));
            // d($val / array_sum($arr));
            // d($x);
            $this->probability[] = $x;
            // d(array_sum($this->probability));
        }

        $this->console .= "Total P: " . array_sum($this->probability) . "\r\n";
        return $this->probability;
        // d($this->probability);
    }

    /**
     * mencari nilai probabilitas komulatif
     * 
     * */
    public function get_com_pro()
    {
        // Mendapatkan nilai probability
        $this->get_probability();
        // d($this->probability);
        // d($this->get_probability());
        // membuat variable com_pro kosong
        $this->com_pro = array();
        $x = 0;
        // melakukan perulangan sebanyak probability
        foreach ($this->probability as $key => $val) {
            // Val akan dijumlahkan sebanyak beberapakali, dan menghasilkan 1
            $x += $val;
            // d($this->fitness); // fitness
            // d($x); // hasil value
            // d($val); // pertambahan
            // mengambil semua probability yang sudah di lakukan perhitubgan probabilitas alias dibagi 1
            $this->com_pro[] = $x;
            $this->console .= "PK[$key] : $x \r\n";
        }
        //reset($this->probability);
        // d($this->com_pro);
        // mengembalikan nilai com_pro
        $this->com_pro;
        // d($this->com_pro);
    }

    public function get_total_fitness()
    {
        // variable total_fitnes kosong
        $this->total_fitness = 0;
        // melakukan perulangan  dan menambahkan value pada variable total fitness
        foreach ($this->fitness as $key => $val) {
            // memasukan value pada variable total fitness
            $this->total_fitness += $val;
        }
        // mengembalikan total_fitness yang sudah dilakukan perulangan dan value 
        return $this->total_fitness;
    }

    public function show_fitness()
    {
        // melakukan perulangan fitnes 
        foreach ($this->fitness as $key => $val) {
            // menyimpan data tersebut di dalam console                                 
            $this->console .= "F[$key]: $val \r\n";
        }
        // Menjalankan fungsi get_total_fitness()
        $this->get_total_fitness();

        // menambahkan string baru pada variable public console
        $this->console .= "Total F: " . $this->total_fitness . "\r\n";
    }

    // Melakukukan Stop dan memberikan nilai true pada fitnes ke 10 
    // agar tidak langsung ke 50(memberatkan sistem)
    public function is_stop()
    {
        $total = 20;
        // Membuat data yang ditampung hanya 10
        if (count($this->fitness_history) < $total)
            return false;
        // Membuat Public fitness_history menjadi array
        // d($this->fitness_history);
        $this->fitness_history = array_values($this->fitness_history);
        // d($this->fitness_history);
        // membuang data pertama atau index array ke 0
        unset($this->fitness_history[0]);
        // memperpendek dengan arr
        $arr =  $this->fitness_history;
        // jika ada array yang sama, jadikan hanya 1 data dan count jika hasil count = 1
        if (count(array_unique($arr)) == 1) {
            return true;
        }
        return false;
    }

    public function calculate_fitness($key)
    {
        // Ambil key dan sebagai cromosom
        $cro = (array)$this->crommosom[$key];
        // variable data yang sudah di construk
        $data = $this->data;
        // d($data);
        // d($data[$cro[0]][$cro[1]] + $data[$cro[1]][$cro[2]] + $data[$cro[2]][$cro[3]]);
        // d($data[$cro[0]][$cro[1]]);
        // d($data[$cro[1]][$cro[2]]);
        // d($data[$cro[2]][$cro[3]]);
        // variable kosong
        $fitness = 0;
        // Lakukan perulangan 
        for ($a = 1; $a < count($cro); $a++) {
            // tambah fitnes
            // $data[$cro[0]][$cro[1]] + $data[$cro[1]][$cro[2]] + $data[$cro[2]][$cro[3]]
            $fitness += $data[$cro[$a - 1]][$cro[$a]];
            // echo $fitness.'<br />';    
            // d($fitness);
        }
        // d($fitness);
        // Mengambil fitnes yang dilakukan perulangan
        $this->fitness[$key] = $fitness;
        // mengembalikan nilai fitnes
        // d($fitness);
        return $fitness;
    }


    public function calculate_all_fitness()
    {
        foreach ($this->crommosom as $key => $val) {
            $this->calculate_fitness($key);
        }
        $min = min($this->fitness);
        $key = array_keys($this->fitness, min($this->fitness));
        $key = $key[0];
        $this->fitness_history[] = $min;

        if ($min < $this->best_fitness) {
            // best fitnes diganti menjadi data terkecil
            $this->best_fitness = $min;
            // memasukan ulang best_crommosom dengan variable crommosom yang sudah diisikan key
            $this->best_cromossom = $this->crommosom[$key];
        }
        $this->console .= "FITNES HISTORY: " . implode(",", $this->fitness_history) . "\r\n";


        if ($this->is_stop()) // jika sudah optimal maka berhenti
            $this->success = true;
    }

    public function kode_to_nama($kode)
    {
        $arr = array();
        foreach ((array) $kode as $val) {
            $arr[] = $this->TITIK[$val];
        }
        // d($arr);
        return $arr;
    }

    public function print_cros($cro)
    {
        return implode(', ', $this->kode_to_nama($cro));
    }

    public function show_crommosom()
    {
        // mengambil this->crommosom yang sudah di generate(Populasi awal)
        $cros = $this->crommosom;
        // membuat array kosong
        $a = array();
        // melakukan perulangan pada $cros
        foreach ($cros as $key => $val) {
            // memngambil data penggabungan string key dan value(Value yang sudah menjadi string dari fungsi print cros)
            $a[] =  "Cro $key: " . $this->print_cros($val);
        }
        // d($a);

        // menambah data kedalam variable string console
        $this->console .= implode(" \r\n", $a) . "\r\n";
    }


    public function generate_crommosom()
    {
        $numb = 0;
        //diulang sesuai jumlah kromosom yang diinputkan
        while ($numb < $this->num_crommosom) {
            // menjalankan dan mengulagi fungsi get_rand_crommosom();
            $cro = $this->get_rand_crommosom();
            // mengisikan public crommosom[] dengan cromosom yang sudah dii acak      
            $this->crommosom[] = $cro;
            // mengisikan seluruh perulangan fitnes menjadi 0
            $this->fitness[] = 0;
            // memberikan operator numb menjadi ++                                    
            $numb++;
        }
        // Poppulasi awal yang memiliki Kromosom(Form input ke 3 pada menu hitung)
        // jadi misal menginputkan 10, gen yang dipilih akan diacak sebanyak 10 kali dan di simpan        
        // dalam bentuk kromosom
        // d($this->crommosom);
        // d($this->fitness);
    }

    // fungsi Random chrommosom
    public function get_rand_crommosom()
    {
        $arr = array($this->titik_awal);
        $x = $this->data;
        // d($x);
        unset($x[$this->titik_awal]);
        $keys = array_keys($x);
        // d($keys);
        shuffle($keys);
        // d($arr, $keys, $arr);
        return array_merge($arr, $keys, $arr);
    }

    public function titikUmum()
    {
        $arr = array($this->titik_awal);
        $x = $this->data;
        // d($x);
        unset($x[$this->titik_awal]);
        $keys = array_keys($x);
        // d($keys);
        // shuffle($keys);
        // d($arr, $keys, $arr);
        return array_merge($arr, $keys, $arr);
    }
}
