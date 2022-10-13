<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(GLPzmlTableSeeder::class);
        $this->call(GLPznrTableSeeder::class);

        //删除作废凭证数据
        $this->delete_zf_pz();


    }

    /**
     *
     * 删除作废凭证
     *
     */
    

    protected function delete_zf_pz()
    {
        $zuofei_pzs = \DB::table('GL_Pzml')->where('zt','0')->get(['kjqj','pzh']);
        foreach ($zuofei_pzs as $zuofei_pz) {
            \DB::table('GL_Pznr')->where('kjqj', $zuofei_pz->kjqj)->where('pzh', $zuofei_pz->pzh)->delete();
        }
    }
}
