<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_grade')->nullable();
            $table->integer('step_1')->nullable();
            $table->integer('step_2')->nullable();
            $table->integer('step_3')->nullable();
            $table->integer('step_4')->nullable();
            $table->integer('step_5')->nullable();
            $table->integer('step_6')->nullable();
            $table->integer('step_7')->nullable();
            $table->integer('step_8')->nullable();
            $table->timestamps();
        });
        $this->salaries();
    }
    private function salaries(): void
    {
       

        DB::table('salary')->insert([
            'salary_grade' => '1',
            'step_1' => '14061',
            'step_2' => '14164',
            'step_3' => '14278',
            'step_4' => '14393',
            'step_5' => '14509',
            'step_6' => '14626',
            'step_7' => '14743',
            'step_8' => '14862',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '2',
            'step_1' => '14925',
            'step_2' => '15035',
            'step_3' => '15146',
            'step_4' => '15258',
            'step_5' => '15371',
            'step_6' => '15484',
            'step_7' => '15599',
            'step_8' => '15714',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '3',
            'step_1' => '15852',
            'step_2' => '15971',
            'step_3' => '16088',
            'step_4' => '16208',
            'step_5' => '16329',
            'step_6' => '16448',
            'step_7' => '16571',
            'step_8' => '16693',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '4',
            'step_1' => '16833',
            'step_2' => '16958',
            'step_3' => '17084',
            'step_4' => '17209',
            'step_5' => '17337',
            'step_6' => '17464',
            'step_7' => '17594',
            'step_8' => '17724',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '5',
            'step_1' => '17866',
            'step_2' => '18000',
            'step_3' => '18133',
            'step_4' => '18267',
            'step_5' => '18401',
            'step_6' => '18538',
            'step_7' => '18676',
            'step_8' => '18813',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '6',
            'step_1' => '18957',
            'step_2' => '19098',
            'step_3' => '19239',
            'step_4' => '19383',
            'step_5' => '19526',
            'step_6' => '19670',
            'step_7' => '19816',
            'step_8' => '19963',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '7',
            'step_1' => '20110',
            'step_2' => '20258',
            'step_3' => '20408',
            'step_4' => '20560',
            'step_5' => '20711',
            'step_6' => '20865',
            'step_7' => '20019',
            'step_8' => '20175',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '8',
            'step_1' => '21448',
            'step_2' => '21642',
            'step_3' => '21839',
            'step_4' => '22035',
            'step_5' => '22234',
            'step_6' => '22435',
            'step_7' => '22638',
            'step_8' => '22483',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '9',
            'step_1' => '23226',
            'step_2' => '23411',
            'step_3' => '23599',
            'step_4' => '23788',
            'step_5' => '23978',
            'step_6' => '24170',
            'step_7' => '24364',
            'step_8' => '24558',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '10',
            'step_1' => '25586',
            'step_2' => '25790',
            'step_3' => '25996',
            'step_4' => '26203',
            'step_5' => '26412',
            'step_6' => '26623',
            'step_7' => '26835',
            'step_8' => '27050',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '11',
            'step_1' => '30024',
            'step_2' => '30308',
            'step_3' => '30597',
            'step_4' => '30889',
            'step_5' => '31185',
            'step_6' => '31486',
            'step_7' => '31790',
            'step_8' => '21099',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '12',
            'step_1' => '32245',
            'step_2' => '32529',
            'step_3' => '32817',
            'step_4' => '33108',
            'step_5' => '33403',
            'step_6' => '33702',
            'step_7' => '34004',
            'step_8' => '34310',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '13',
            'step_1' => '34421',
            'step_2' => '34733',
            'step_3' => '35409',
            'step_4' => '35369',
            'step_5' => '35694',
            'step_6' => '36022',
            'step_7' => '36354',
            'step_8' => '36691',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '14',
            'step_1' => '37024',
            'step_2' => '37384',
            'step_3' => '37749',
            'step_4' => '38118',
            'step_5' => '38491',
            'step_6' => '38869',
            'step_7' => '39252',
            'step_8' => '39640',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '15',
            'step_1' => '40208',
            'step_2' => '40604',
            'step_3' => '41006',
            'step_4' => '41413',
            'step_5' => '41824',
            'step_6' => '42241',
            'step_7' => '41662',
            'step_8' => '43090',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '16',
            'step_1' => '43560',
            'step_2' => '43996',
            'step_3' => '44348',
            'step_4' => '44885',
            'step_5' => '45338',
            'step_6' => '45796',
            'step_7' => '46261',
            'step_8' => '46730',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '17',
            'step_1' => '47247',
            'step_2' => '47727',
            'step_3' => '48213',
            'step_4' => '48705',
            'step_5' => '49203',
            'step_6' => '49708',
            'step_7' => '50218',
            'step_8' => '50735',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '18',
            'step_1' => '51304',
            'step_2' => '51832',
            'step_3' => '52367',
            'step_4' => '52907',
            'step_5' => '53456',
            'step_6' => '54010',
            'step_7' => '54572',
            'step_8' => '55140',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '19',
            'step_1' => '56390',
            'step_2' => '57165',
            'step_3' => '57953',
            'step_4' => '58753',
            'step_5' => '59567',
            'step_6' => '60394',
            'step_7' => '61235',
            'step_8' => '62089',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '20',
            'step_1' => '62967',
            'step_2' => '63842',
            'step_3' => '64732',
            'step_4' => '65367',
            'step_5' => '66557',
            'step_6' => '67479',
            'step_7' => '68409',
            'step_8' => '69342',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '21',
            'step_1' => '70013',
            'step_2' => '71000',
            'step_3' => '72004',
            'step_4' => '73024',
            'step_5' => '74061',
            'step_6' => '75115',
            'step_7' => '76151',
            'step_8' => '77239',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('salary')->insert([
            'salary_grade' => '22',
            'step_1' => '78162',
            'step_2' => '79277',
            'step_3' => '80411',
            'step_4' => '81564',
            'step_5' => '82735',
            'step_6' => '83887',
            'step_7' => '85096',
            'step_8' => '86324',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '23',
            'step_1' => '87315',
            'step_2' => '88574',
            'step_3' => '89855',
            'step_4' => '91163',
            'step_5' => '92592',
            'step_6' => '94043',
            'step_7' => '95518',
            'step_8' => '96955',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '24',
            'step_1' => '98185',
            'step_2' => '99721',
            'step_3' => '101283',
            'step_4' => '102271',
            'step_5' => '104483',
            'step_6' => '106123',
            'step_7' => '107739',
            'step_8' => '109431',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '25',
            'step_1' => '111727',
            'step_2' => '113476',
            'step_3' => '115254',
            'step_4' => '117062',
            'step_5' => '118899',
            'step_6' => '120766',
            'step_7' => '122664',
            'step_8' => '124591',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '26',
            'step_1' => '126252',
            'step_2' => '128228',
            'step_3' => '130238',
            'step_4' => '132280',
            'step_5' => '134356',
            'step_6' => '136465',
            'step_7' => '138608',
            'step_8' => '140788',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '27',
            'step_1' => '142663',
            'step_2' => '144897',
            'step_3' => '147169',
            'step_4' => '149407',
            'step_5' => '151752',
            'step_6' => '153850',
            'step_7' => '156267',
            'step_8' => '158723',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '28',
            'step_1' => '160469',
            'step_2' => '162988',
            'step_3' => '165548',
            'step_4' => '167994',
            'step_5' => '170634',
            'step_6' => '173320',
            'step_7' => '175803',
            'step_8' => '178572',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '29',
            'step_1' => '180492',
            'step_2' => '183332',
            'step_3' => '186218',
            'step_4' => '189151',
            'step_5' => '192131',
            'step_6' => '194797',
            'step_7' => '197870',
            'step_8' => '200993',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '30',
            'step_1' => '203200',
            'step_2' => '206401',
            'step_3' => '209558',
            'step_4' => '212766',
            'step_5' => '216022',
            'step_6' => '219434',
            'step_7' => '222797',
            'step_8' => '226319',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '31',
            'step_1' => '293191',
            'step_2' => '298773',
            'step_3' => '304464',
            'step_4' => '310119',
            'step_5' => '315883',
            'step_6' => '321846',
            'step_7' => '327895',
            'step_8' => '334059',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '32',
            'step_1' => '347888',
            'step_2' => '354743',
            'step_3' => '361736',
            'step_4' => '369694',
            'step_5' => '375969',
            'step_6' => '383391',
            'step_7' => '390963',
            'step_8' => '398686',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('salary')->insert([
            'salary_grade' => '33',
            'step_1' => '434844',
            'step_2' => '451713',
            'step_3' => null,
            'step_4' => null,
            'step_5' => null,
            'step_6' => null,
            'step_7' => null,
            'step_8' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary');
    }
};
