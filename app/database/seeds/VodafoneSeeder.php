<?php

class VodafoneSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = glob("data/*.csv");
        foreach ($files as $file) {
            $handle = fopen($file, 'r');

            $l = 0;
            while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                $l ++;
                if ($l <= 3)
                    continue;
                $datas[$l]['tipo'] = $data[0];
                $datas[$l]['destinazione'] = $data[1];
                $datas[$l]['numero'] = $data[2];
                $datas[$l]['data'] = date("Y-m-d H:m:s", $this->toDate($data[3]));
                $datas[$l]['durata'] = $data[4];
            }

            foreach ($datas as $data)
                DB::table('vodafone')->insert($data);
        }
    }

    private function toDate ($dt)
    {
        return mktime(
            substr($dt, 11, 2), // Hours
            substr($dt, 14, 2), // Minutes
            substr($dt, 17, 2), // Seconds
            substr($dt, 3, 2), // Month
            substr($dt, 0, 2), // Day
            substr($dt, 6, 4) //Year
        );
    }

}
