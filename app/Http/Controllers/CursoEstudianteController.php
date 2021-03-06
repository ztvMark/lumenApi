<?php 
namespace App\Http\Controllers;

use App\Curso;
use App\Estudiante;

class CursoEstudianteController extends Controller{
	
	public function __construct(){
		//Para protegernos este middleware se aplicara excepto a index
		$this->middleware('oauth', ['except' => ['index']]);
	}

	public function index($curso_id){
		
		$curso = Curso::find($curso_id);
		
		//Si existe
		if($curso){
			$estudiantes = $curso->estudiantes;
			return $this->crearRespuesta($estudiantes, 200);
		}
		return $this->crearRespuestaError('No se puede encontrar un curso con el id dado', 404);
	}

	//Agregar estudiante a curso, el estudiante debe existir y el curso igual
	public function store($curso_id, $estudiante_id){
		$curso = Curso::find($curso_id);
		//Si existe curso
		if($curso){
			
			$estudiante = Estudiante::find($estudiante_id);
			
			if($estudiante){
				//Obtenemos el estudiante
				$estudiantes = $curso->estudiantes();
				
				//Verificamos que no este tomando el mismo curso
				if($estudiantes->find($estudiante_id)){
					return $this->crearRespuesta("El estudiante $estudiante_id ya existe en este curso", 409);
				}
				//Agregamos el estudiante
				$curso->estudiantes()->attach($estudiante_id);

				return $this->crearRespuesta("El estudiante $estudiante_id ha sido agregado al curso $curso_id", 201);
			}
			//Si no existe
			return $this->crearRespuestaError('No se puede encontrar un estudiante con el id dado', 404);
		}
		//Si no existe
		return $this->crearRespuestaError('No se puede encontrar un curso con el id dado', 404);
	}

	public function destroy($curso_id, $estudiante_id){
		
		$curso = Curso::find($curso_id);
		if($curso){
			
			//Si existe obtenemos estudiantes del curso
			$estudiantes = $curso->estudiantes();
			
			//Si existe el estudinte que eliminaremos
			if($estudiantes->find($estudiante_id)){
				
				//Lo quitamos
				$estudiantes->detach($estudiante_id);
				
				return $this->crearRespuesta('El estudiante de eliminó', 200);
			}

			return $this->crearRespuestaError('No existe un estudiante con el id dado en este curso', 404);
		}

		return $this->crearRespuestaError('No se puede encontrar un curso con el id dado', 404);
	}
}