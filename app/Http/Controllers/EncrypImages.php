<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use File;
use Crypt;
use DB;

class EncrypImages extends Controller
{
    public function index(){
    	
    	# echo "Encriptando Imagenes en Archivos";
    	# $contents = File::get(base_path() . "\\resources\\assets\\images\\image.jpg");
    	# $this->generateBytesImage('image.jpg');

        return $this->displayImage(1);
    }

    private function generateBytesImage( $image ){
    	try {

    		$imagen = imagecreatefromjpeg (base_path() . "\\resources\\assets\\images\\{$image}");

    		ob_start();
			imagegif($imagen);
			$imageBytes = ob_get_contents();
			ob_end_clean();
            
            $imageEncrypted = $this->encryptImage( $imageBytes  );

            $saveImage = DB::table('pictures')
            ->insert([
                'pic_hash'    => md5('xD'),
                'pic_content' => $imageEncrypted
            ]);

            if($saveImage){
                echo "Inserted";
            } else {
                echo "Error xD";
            }
            # Des-encripta
            // $imageDecrypted = base64_decode( $imageEncrypted );
            

            // header("Content-Type: image/gif");
            // echo $imageDecrypted;

    	} catch (Exception $e) {
    		echo "Error: {$e}";
    	}
    }

    private function encryptImage( $imageBytes ){

        $imageEncrypted = @base64_encode( $imageBytes );
        return $imageEncrypted;
    }

    private function displayImage($imageId){

        try{

            $image = DB::table('pictures')
            ->where('pic_id', '=', 1)
            ->first();

            if($image){
                $imageDecrypted = base64_decode( $image->pic_content );
                header("Content-Type: image/gif");
                echo $imageDecrypted;
            } else {
                return Response()->json(array('status' => 'error', 'codigo' => '2', 'msg' => 'No se encontro la imagen'));    
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return Response()->json(array('status' => 'error', 'codigo' => '1', 'msg' => 'Hubo un error al Importar los Datos', 'error' => $e));
        }

    }
}
