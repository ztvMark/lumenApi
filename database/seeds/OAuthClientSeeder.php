<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Estudiante;
use App\Profesor;
use App\Curso;

class OAuthClientSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run(){
			for ($i=1; $i <= 10 ; $i++){
				//Insertamos a la tabla oauth_clients
				DB::table('oauth_clients')->insert([
					'id' => $i,
					'secret' => "secret$i",
					'name' => "cliente$i"
				]);
			}
		}

		//Si hay error en la clase
		//composer dumpautoload
}