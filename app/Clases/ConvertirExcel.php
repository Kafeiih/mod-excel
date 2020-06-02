<?php

namespace App\Clases;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv as Prueba;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ConvertirExcel
{
 
    static function planillaCompra()
    {
        $filePago = public_path('uploads/pago.xls');
        $fileDevengo = public_path('uploads/devengo.xls');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        

        $reader = new Xls();
        $reader->setReadDataOnly(TRUE);

        $fPago = $reader->load($filePago);
        $fDevengo = $reader->load($fileDevengo);

        $workPago = $fPago->getActiveSheet();
        $workDevengo = $fDevengo->getActiveSheet();

        // Listado Pagos Realizado
        $ultimaFilaPago = $workPago->getHighestRow();
        $ultimaFilaDeven = $workDevengo->getHighestRow();
        $i = 2;

        $sheet->setCellValue('A1', 'RBD');
        $sheet->setCellValue('B1', 'Subvencion');
        $sheet->setCellValue('C1', 'Codigo Cuenta');
        $sheet->setCellValue('D1', 'Tipo de Documento');
        $sheet->setCellValue('E1', 'Nro Documento');
        $sheet->setCellValue('F1', 'Fecha Documento');
        $sheet->setCellValue('G1', 'Fecha Pago');
        $sheet->setCellValue('H1', 'Descripcion Gasto');
        $sheet->setCellValue('I1', 'Rut Proveedor');
        $sheet->setCellValue('J1', 'Nombre Proveedor');
        $sheet->setCellValue('K1', 'Monto Gasto');
        $sheet->setCellValue('L1', 'Monto Documento');
        $sheet->setCellValue('M1', 'Documento Original');


        for ($fila = 6; $fila <= $ultimaFilaPago; $fila++) {
            $tipDocumento = $workPago->getCellByColumnAndRow(6, $fila)->getValue();
            $nDocumento = $workPago->getCellByColumnAndRow(7, $fila)->getValue();
            $fechaPago = $workPago->getCellByColumnAndRow(8, $fila)->getValue();
            $numero_cliente_pago = $workPago->getCellByColumnAndRow(10, $fila)->getValue();

            $fPago = Date::excelToTimestamp($fechaPago); // Cambia de formato fecha excel a estandar
            $porcion_cliente = explode(" ", $numero_cliente_pago, 2); //separa rut y nombre
            $nFactura = explode(" ", $tipDocumento, 2); //numero de factura
            $vDevengo = $descGasto = 'NULO_REVISAR'; // En caso de nulo

            // Calcular Devengo
            for ($devengoFila = 7; $devengoFila <= $ultimaFilaDeven; $devengoFila++) { 
                $numero_factura_devengo = $workDevengo->getCellByColumnAndRow(11, $devengoFila)->getValue();
                $numero_cliente_devengo = $workDevengo->getCellByColumnAndRow(6, $devengoFila)->getValue();
                $gastoDevengo = $workDevengo->getCellByColumnAndRow(3, $devengoFila)->getValue();

                if ($nDocumento == $numero_factura_devengo) {
                    $descGasto = $workDevengo->getCellByColumnAndRow(23, $devengoFila)->getValue();
                    $tituloDevengo = $workDevengo->getCellByColumnAndRow(3, $devengoFila)->getValue();
                    $vFormato = explode(".", $tituloDevengo);
                }
            }

            /**
             * PRUEBA
             */
            $sheet->setCellValue('A'.$i, $vFormato[0]);
            $sheet->setCellValue('B'.$i, $vFormato[1]);
            $sheet->setCellValue('C'.$i, $vFormato[2]);
            $sheet->setCellValue('D'.$i, $nFactura[1]);
            $sheet->setCellValue('E'.$i, $nDocumento);
            $sheet->setCellValue('F'.$i, date("Y/m/d", $fPago));
            $sheet->setCellValue('G'.$i, 'NA');
            $sheet->setCellValue('H'.$i, $descGasto);
            $sheet->setCellValue('I'.$i, $porcion_cliente[0]);
            $sheet->setCellValue('J'.$i, $porcion_cliente[1]);
            $sheet->setCellValue('K'.$i, 'NA');
            $sheet->setCellValue('L'.$i, 'NA');
            $sheet->setCellValue('M'.$i, 'NA');

            $i++;
        }

        $writer = new Csv($spreadsheet);
        $writer->setDelimiter(';');
        $writer->setEnclosure('');
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $writer->save('prueba.xlsx');
    }

    static function cargaProfesor($id, $ext) //nombre de guarado - extension del archivo
    {
        $file = public_path('uploads/profe/'. $id .'profe.' . $ext);
        $reader = new Prueba();
        $reader->setReadDataOnly(TRUE);

        $workProfe = $reader->load($file)->getActiveSheet();
        $ultimaProfe = $workProfe->getHighestRow();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $cont = 2;
        $lista[1] = [
            'First Name [Required]','Last Name [Required]','Email Address [Required]','Password [Required]','Password Hash Function [UPLOAD ONLY]','Org Unit Path [Required]','New Primary Email [UPLOAD ONLY]','Recovery Email','Home Secondary Email','Work Secondary Email','Recovery Phone [MUST BE IN THE E.164 FORMAT]','Work Phone','Home Phone','Mobile Phone','Work Address','Home Address','Employee ID','Employee Type','Employee Title','Manager Email','Department','Cost Center','Building ID','Floor Name','Floor Section','Change Password at Next Sign-In','New Status [UPLOAD ONLY]',
        ];

        for ($i=1; $i < $ultimaProfe+1; $i++) { 
            $rut = $workProfe->getCellByColumnAndRow(1, $i)->getValue();
            $verificar = $workProfe->getCellByColumnAndRow(2, $i)->getValue();
            $ruta = $workProfe->getCellByColumnAndRow(7, $i)->getValue();

            //$alumnos = $workProfe->getCellByColumnAndRow(5, $i)->getValue();

            $nombre = $workProfe->getCellByColumnAndRow(3, $i)->getValue();
            $nombre = explode(" ", $nombre);
            $apellido = $workProfe->getCellByColumnAndRow(4, $i)->getValue();
            $apellido = explode(" ", $apellido, 1);

            //$nombre[0] . "." . $apellido[0] . "@slepandaliensur.cl"

            $recupe = "soporteandaliensur@gmail.com";
            $cambio = "True";

            $lista[$cont] = [
                $nombre[0], $apellido[0], $rut . "-" . $verificar . "@slepandaliensur.cl", $rut . "-" . $verificar,'',$ruta,'','',$recupe,'','','','','','','','','','','','','','','','',$cambio,
            ];

            $cont++;
        }
        
        $sheet->fromArray($lista);

        $writer = new Csv($spreadsheet);
        $writer->setDelimiter(';');
        $writer->setEnclosure('');
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);

        $writer->save('aa.csv');
    }
}