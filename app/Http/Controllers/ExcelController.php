<?php

namespace App\Http\Controllers;

use App\Clases\ConvertirExcel;
use Illuminate\Http\Request;

class ExcelController extends Controller
{

    public function index(Request $request)
    {
        return view('excel.index');
    }

    public function profesor(Request $request)
    {
        return view('excel.profesor');
    }

    public function CargaProfesor(Request $request)
    {
        $op = ConvertirExcel::cargaProfesor();

        return $op;
    }

    /**
     * Subida del archivo
     */
    public function excelUploadPost(Request $request)
    {

        $request->validate([
            'pagos' => 'required|mimes:xls,csv|max:2048',
            'devengo' => 'required|mimes:xls,csv|max:2048',
        ]);
    
        $filePago = 'pago.'.$request->pagos->extension();
        $fileDevengo = 'devengo.'.$request->devengo->extension();  
    
        $request->pagos->move(public_path('uploads'), $filePago);
        $request->devengo->move(public_path('uploads'), $fileDevengo);
    
        //proc
        ConvertirExcel::planillaCompra();
        //$cliente = new ConvertirExcel();
        //$cliente->planillaCompra();

        $url = 'prueba.csv';

        return back()
            ->with('success','Archivo procesado con exito.')
            ->with('url', $url);
       
    }

    public function profesorUpload(Request $request)
    {
        $request->validate([
            'profes' => 'required|mimes:xls,csv,txt,xlsx|max:2048',
        ]);
    
        $numero = rand();
        $extension = $request->profes->extension();
        
        $fileProfe = $numero . 'profe.' . $request->profes->extension();

        $request->profes->move(public_path('uploads/profe'), $fileProfe);
    
        //proc
        ConvertirExcel::cargaProfesor($numero, $extension);
        //$cliente = new ConvertirExcel();
        //$cliente->planillaCompra();

        $url = 'aa.csv';

        return back()
            ->with('success','Archivo procesado con exito.')
            ->with('url', $url);
       
    }

}
