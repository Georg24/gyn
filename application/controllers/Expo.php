<?php

//Expo cotrolador de exportacion de documentos a PDF
defined('BASEPATH') OR exit('No direct script access allowed');

class Expo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Se carga el modelo y Se carga la libreria fpdf
        $this->load->model('Venta_model');
        $this->load->library('pdfex');
    }

    //recibe el parametro codido de venta
    public function guardarPdfVenta() {
        if (isset($_GET['cdg'])) {
            $codigo = base64_decode($this->input->get('cdg')); //otenemos el codigo de la venta
            $detalle = $this->Venta_model->getDetalleVenta($codigo);//obtener los datos de detalle
            if($this->input->get('copia')=="on")
            {
                $concopia=2;
            }
            else
            {
                $concopia=1;
            }
            // Se crea un objeto de la clase Pdfex, la clase Pdfex heredó todos las variables y métodos de fpdf
            $this->pdf = new Pdfex('P', 'mm', 'Letter');
            $this->pdf->AddPage(TRUE); // Agregamos una página encabezado y pie (en caso de tener)
            //$this->pdf->AliasNbPages(); // Define el alias para el número de página que se imprimirá en el pie
            // Se define el titulo, márgenes izquierdo, derecho y el color de relleno predeterminado
            //DATOS INTERNOS
            $this->pdf->SetTitle("Detalle de venta");
            $this->pdf->SetLeftMargin(6);
            $this->pdf->SetRightMargin(6);
            for ($c = 0; $c < $concopia; $c++) { // con copia
                //DESCRIPCION DEL DOCUMENTO
                $this->pdf->SetFont('Helvetica', '', 10);
                $fecha = date_format(new DateTime($detalle[0]->fecha), 'd/m/Y');
                $this->pdf->Cell(50, 10, "fecha " . $fecha, 0, 0, 'C');
                $this->pdf->Cell(40, 10, 'Codigo de Venta', 0, 0, 'C');
                $this->pdf->Ln(4);
                $this->pdf->SetFont('Helvetica', 'B', 8);
                $this->pdf->Cell(50, 10, 'Detalle de Venta', 0, 0, 'C');
                $this->pdf->SetFont('Helvetica', 'B', 10);
                $this->pdf->Cell(40, 10, $codigo, 0, 0, 'C');
                $this->pdf->Ln(8);
                // Se define el formato de fuente: Arial, negritas, tamaño 9 EN FONDO PLOMO
                $this->pdf->SetFillColor(220, 220, 220);
                $this->pdf->SetFont('Helvetica', 'B', 8);
                // TITULOS DE COLUMNAS
                //$this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
                $this->pdf->Cell(15, 4, 'Cant', 'TBL', 0, 'C', '1');
                $this->pdf->Cell(35, 4, 'Modelo/Desc.', 'TB', 0, 'L', '1');
                $this->pdf->Cell(20, 4, 'P/u', 'TB', 0, 'C', '1');
                $this->pdf->Cell(20, 4, 'Subtotal', 'TBR', 0, 'C', '1');

                $this->pdf->Ln(4);
                // seteamos el formato de letra para el detalle
                $this->pdf->SetFont('Arial', '', 9);
                $total = 0;
                $alto = 5;
                if (sizeof($detalle) < 8) {
                    foreach ($detalle as $val) {
                        $this->pdf->Cell(15, $alto, $val->cantidad, 'L', 0, 'C', 0);
                        $this->pdf->Cell(35, $alto, $val->modelo, 0, 0, 'L', 0);
                        $this->pdf->Cell(20, $alto, $val->precio, 0, 0, 'R', 0);
                        $this->pdf->Cell(20, $alto, $val->subtotal, 'R', 0, 'R', 0);
                        $this->pdf->Ln($alto);
                        $this->pdf->Cell(15, $alto, '', 'LB', 0, 'C', 0);
                        $this->pdf->Cell(35, $alto, substr($val->descripcion, 0, 25), 'B', 0, 'L', 0);
                        $this->pdf->Cell(20, $alto, '', 'B', 0, 'R', 0);
                        $this->pdf->Cell(20, $alto, '', 'RB', 0, 'R', 0);
                        $this->pdf->Ln($alto);
                        $total = $total + $val->subtotal;
                    }
                } elseif (sizeof($detalle) < 17) {
                    foreach ($detalle as $val) {
                        $this->pdf->Cell(15, $alto, $val->cantidad, 'LB', 0, 'C', 0);
                        $this->pdf->Cell(35, $alto, $val->modelo, 'B', 0, 'L', 0);
                        $this->pdf->Cell(20, $alto, $val->precio, 'B', 0, 'R', 0);
                        $this->pdf->Cell(20, $alto, $val->subtotal, 'BR', 0, 'R', 0);
                        $this->pdf->Ln($alto);
                        $total = $total + $val->subtotal;
                    }
                } else {
                    foreach ($detalle as $val) {
                        $alto = 4;
                        $this->pdf->SetFont('Arial', '', 7);
                        $this->pdf->Cell(15, $alto, $val->cantidad, 'LB', 0, 'C', 0);
                        $this->pdf->Cell(35, $alto, $val->modelo, 'B', 0, 'L', 0);
                        $this->pdf->Cell(20, $alto, $val->precio, 'B', 0, 'R', 0);
                        $this->pdf->Cell(20, $alto, $val->subtotal, 'BR', 0, 'R', 0);
                        $this->pdf->Ln($alto);
                        $total = $total + $val->subtotal;
                    }
                }
                $this->pdf->Ln(1);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->Cell(50, 5, '', '', 0, 'R', 0);
                $this->pdf->Cell(20, 5, 'Total Bs.-', '', 0, 'L', 0);
                $this->pdf->Cell(20, 5, number_format($total, 2), '', 0, 'C', 0);
                $this->pdf->Ln(5);
                if ($c < 1) {
                    $this->pdf->propEstrecha(); //posicionamos la copia y si solo es reserva la imprimimos
                    if($concopia==2)
                    {
                        $this->pdf->SetXY(6, 150);
                        $this->pdf->SetFont('Arial', 'B', 8);
                        $this->pdf->Cell(50, 5, 'Copia ', '', 0, 'C', 0);
                        if ($detalle[0]->efectiva == 0) {
                            $this->pdf->Cell(40, 5, 'Reservado', '', 0, 'R', 0);
                        }
                        $this->pdf->Ln(2);
                    }
                } else {
                    $this->pdf->SetFont('Arial', '', 8);
                    $this->pdf->Cell(50, 5, '', '', 0, 'C', 0);
                    $this->pdf->Cell(40, 5, $detalle[0]->nombre, '', 0, 'L', 0);
                }
            }
            // Se manda el pdf al navegador
            // $this->pdf->Output(nombredelarchivo, destino);
            // I = Muestra el pdf en el navegador
            // D = Envia el pdf para descarga
            //obtenemos la fecha del codigo de la venta para las carpetas
            $anio = "20" . substr($codigo, 2, 2);
            $mes = substr($codigo, 4, 2);
            if (!is_dir("C:\\GN_Docs\\Ventas\\" . $anio . "\\" . $mes)) {
                mkdir("C:\\GN_Docs\\Ventas\\" . $anio . "\\" . $mes . "\\", null, TRUE);
            }
            $this->pdf->Output("C:/GN_Docs/Ventas/" . $anio . "/" . $mes . "/" . $codigo . ".pdf", 'F');
            $this->pdf->Output($codigo . ".pdf", 'I');
        } else {
            show_404();
        }
    }

    public function porPeriodo() {
        if (isset($_POST['mes_desde'])) { //damos formato a los datos para recibirlos
            $desde = (new DateTime($this->input->post('anio_desde') . "-" . $this->input->post('mes_desde') . "-01"))->format('Y-m-d');
            $hasta = (new DateTime($this->input->post('anio_hasta') . "-" . $this->input->post('mes_hasta') . "-31"))->format('Y-m-d');
            $Diarias = $this->Venta_model->getDiariasPorPeriodo($desde, $hasta);
            $TOTAL = $this->Venta_model->sumDiariasPorPeriodo($desde, $hasta);
            $this->pdf = new Pdfex('P', 'mm', 'Letter');
            $this->pdf->AddPage();
            $this->pdf->SetLeftMargin(15);
            $this->pdf->SetRightMargin(15);
            //DESCRIPCION DEL DOCUMENTO
            $this->pdf->SetFont('Helvetica', '', 10);
            $fecha = date('d/m/Y');
            $this->pdf->Cell(90, 10, '', 0, 0, 'C');
            $this->pdf->Cell(80, 10, "Fecha de impresion: " . $fecha, 0, 0, 'R');
            $this->pdf->Ln(4);
            $this->pdf->SetFont('Helvetica', 'B', 10);
            $this->pdf->Cell(40, 10, '', 0, 0, 'C');
            $this->pdf->Cell(60, 10, 'Detalle de Ventas Diarias', 0, 0, 'L');
            $this->pdf->Cell(80, 10, 'Periodo: desde ' . $desde . ' Hasta ' . $hasta, 0, 0, 'R');
            $this->pdf->Ln(12);
            // Se define el formato de fuente: Arial, negritas, tamaño 9 EN FONDO PLOMO
            $this->pdf->SetFillColor(220, 220, 220);
            $this->pdf->SetFont('Helvetica', 'B', 9);
            // TITULOS DE COLUMNAS
            //$this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
            $this->pdf->Cell(40, 4, 'Fecha', 'TBL', 0, 'C', '1');
            $this->pdf->Cell(40, 4, 'Dia.', 'TB', 0, 'L', '1');
            $this->pdf->Cell(40, 4, 'Nro de ventas', 'TB', 0, 'C', '1');
            $this->pdf->Cell(40, 4, 'Subtotal', 'TBR', 0, 'C', '1');
            $this->pdf->Ln(4);
            // seteamos el formato de letra para el detalle
            $this->pdf->SetFont('Arial', '', 9);
            $total = 0;
            $alto = 5;
            foreach ($Diarias as $val) {
                $this->pdf->Cell(40, $alto, $val->fecha, 'LB', 0, 'C', 0);
                $this->pdf->Cell(40, $alto, get_nombre_dia($val->fecha), 'B', 0, 'L', 0);
                $this->pdf->Cell(40, $alto, $val->ventas, 'B', 0, 'C', 0);
                $this->pdf->Cell(40, $alto, $val->sumTotal, 'BR', 0, 'R', 0);
                $this->pdf->Ln($alto);
                $total = $total + $val->sumTotal;
            }
            $this->pdf->Ln(1);
            $this->pdf->SetFont('Arial', 'B', 10);
            $this->pdf->Cell(80, 5, '', '', 0, 'R', 0);
            $this->pdf->Cell(40, 5, 'Total Bs.-', '', 0, 'R', 0);
            $this->pdf->Cell(40, 5, number_format($TOTAL, 2), '', 0, 'C', 0);
            $this->pdf->Ln(5);
            if (!is_dir("C:\\GN_Docs\\Ventas_Mensual")) {
                mkdir("C:\\GN_Docs\\Ventas_Mensual\\", null, TRUE);
            }
            $this->pdf->Output("C:\\GN_Docs\\Ventas_Mensual\\" . $desde . "_" . $hasta . ".pdf", 'F');
            $this->pdf->Output($desde . "_" . $hasta . ".pdf", 'I');
        } else {
            show_404();
        }
    }

    public function ganaciaPorProducto() {
        if (isset($_POST['limite'])) { //damos formato a los datos para recibirlos
            $limite = $this->input->post('limite');
            $orden = $this->input->post('radio_orden');
            $top = "";
            if ($limite > 0) {
                $productos = $this->Venta_model->ganaciaPorProducto($limite, $orden);
                $top = "Top: " . $limite;
            } else {
                $productos = $this->Venta_model->ganaciaPorProducto(FALSE, $orden);
                $top = "TODOS";
            }

            $this->pdf = new Pdfex('P', 'mm', 'Letter');
            $this->pdf->AddPage();
            $this->pdf->AliasNbPages();
            $this->pdf->SetLeftMargin(15);
            $this->pdf->SetRightMargin(15);
            //DESCRIPCION DEL DOCUMENTO
            $this->pdf->SetFont('Helvetica', '', 10);
            $fecha = date('d/m/Y');
            $this->pdf->Cell(90, 10, '', 0, 0, 'C');
            $this->pdf->Cell(80, 10, "Fecha de impresion: " . $fecha, 0, 0, 'R');
            $this->pdf->Ln(4);
            $this->pdf->SetFont('Helvetica', 'B', 10);
            $this->pdf->Cell(40, 10, '', 0, 0, 'C');
            $this->pdf->Cell(60, 10, 'Ingresos por Unidades Vendidas', 0, 0, 'L');
            $this->pdf->Cell(80, 10, $top, 0, 0, 'R');
            $this->pdf->Ln(12);
            // Se define el formato de fuente: Arial, negritas, tamaño 9 EN FONDO PLOMO
            $this->pdf->SetFillColor(220, 220, 220);
            $this->pdf->SetFont('Helvetica', 'B', 7);
            // TITULOS DE COLUMNAS
            //$this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
            $this->pdf->Cell(20, 4, 'Modelo', 'TBL', 0, 'C', '1');
            $this->pdf->Cell(20, 4, 'Costo Bs', 'TB', 0, 'R', '1');
            $this->pdf->Cell(15, 4, 'Vendidas', 'TB', 0, 'C', '1');
            $this->pdf->Cell(25, 4, 'Prom/Salidas Bs', 'TB', 0, 'R', '1');
            $this->pdf->Cell(25, 4, 'Total Costo Bs', 'TB', 0, 'R', '1');
            $this->pdf->Cell(25, 4, 'Total Venta Bs', 'TB', 0, 'R', '1');
            $this->pdf->Cell(25, 4, 'Ing. Neto Bs', 'TB', 0, 'R', '1');
            $this->pdf->Cell(20, 4, 'Porc.%', 'TBR', 0, 'C', '1');
            $this->pdf->Ln(4);
            // seteamos el formato de letra para el detalle
            $this->pdf->SetFont('Arial', '', 9);
            $pags = 0;
            $alto = 5;
            $total_cantidad = 0;
            $total_precio = 0;
            $total_neta = 0;
            foreach ($productos as $val) {
                $this->pdf->Cell(20, $alto, $val->modelo, 'LB', 0, 'C', 0);
                $this->pdf->Cell(20, $alto, $val->costo, 'B', 0, 'R', 0);
                $this->pdf->Cell(15, $alto, $val->sumcantidad, 'B', 0, 'C', 0);
                $this->pdf->Cell(25, $alto, number_format($val->precio_promedio, 2), 'B', 0, 'R', 0);
                $this->pdf->Cell(25, $alto, $val->sumcosto, 'B', 0, 'R', 0);
                $this->pdf->Cell(25, $alto, $val->sumprecio, 'B', 0, 'R', 0);
                $this->pdf->Cell(25, $alto, $val->neta, 'B', 0, 'R', 0);
                $this->pdf->Cell(20, $alto, number_format($val->porcentaje, 2), 'BR', 0, 'R', 0);
                $this->pdf->Ln($alto);
                $pags++;
                if ($pags % 45 == 0) {

                    $this->pdf->AddPage();
                    $this->pdf->Ln($alto * 4);
                    $this->pdf->SetFont('Helvetica', 'B', 7);
                    // TITULOS DE COLUMNAS
                    //$this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
                    $this->pdf->Cell(20, 4, 'Modelo', 'TBL', 0, 'C', '1');
                    $this->pdf->Cell(20, 4, 'Costo', 'TB', 0, 'L', '1');
                    $this->pdf->Cell(15, 4, 'Vendidas', 'TB', 0, 'C', '1');
                    $this->pdf->Cell(25, 4, 'Prom/Salidas', 'TB', 0, 'C', '1');
                    $this->pdf->Cell(25, 4, 'Total Costo', 'TB', 0, 'C', '1');
                    $this->pdf->Cell(25, 4, 'Total Venta', 'TB', 0, 'C', '1');
                    $this->pdf->Cell(25, 4, 'Ing. Neto', 'TB', 0, 'C', '1');
                    $this->pdf->Cell(20, 4, 'Porc.', 'TBR', 0, 'C', '1');
                    $this->pdf->Ln(4);
                    $this->pdf->SetFont('Arial', '', 9);
                }
                $total_cantidad = $total_cantidad + $val->sumcantidad;
                $total_precio = $total_precio + $val->sumprecio;
                $total_neta = $total_neta + $val->neta;
            }
            $this->pdf->Ln(3);
            $this->pdf->Cell(60, 4, 'Total  de  Unidades  Vendidas:', '', 0, 'R', '1');
            $this->pdf->Cell(30, 4, $total_cantidad, '', 0, 'L', '1');
            $this->pdf->Ln(5);
            $this->pdf->Cell(60, 4, 'Total  Ingresos  por  Ventas Bs.:', '', 0, 'R', '1');
            $this->pdf->Cell(30, 4, number_format($total_precio,2), '', 0, 'L', '1');
            $this->pdf->Ln(5);
            $this->pdf->Cell(60, 4, 'Total  Ing.  Neto  por Ventas Bs.:', '', 0, 'R', '1');
            $this->pdf->Cell(30, 4, number_format($total_neta,2), '', 0, 'L', '1');
            if (!is_dir("C:\\GN_Docs\\Ing_Mensual")) {
                mkdir("C:\\GN_Docs\\Ing_Mensual\\", null, TRUE);
            }
            $this->pdf->Output("C:\\GN_Docs\\Ing_Mensual\\" . date('d-m-y') . "_porProd .pdf", 'F');
            $this->pdf->Output(date('d-m-y') . "_porProd .pdf", 'I');
        } else {
            show_404();
        }
    }

    /* EJEMPLOS */

    public function index() {
        // Se obtienen los alumnos de la base de datos
        $alumnos = $this->Venta_model->getVentas();

        // Creacion del PDF

        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new Pdfex();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();

        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Detalle de venta");
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200, 200, 200);

        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */

        $this->pdf->Cell(15, 7, 'Cant', 'TBL', 0, 'C', '1');
        $this->pdf->Cell(25, 7, 'Descripcion', 'TB', 0, 'L', '1');
        $this->pdf->Cell(25, 7, 'P/u', 'TB', 0, 'L', '1');
        $this->pdf->Cell(25, 7, 'Subtotal', 'TBR', 0, 'L', '1');

        $this->pdf->Ln(7);
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        /* foreach ($alumnos as $alumno) {
          // se imprime el numero actual y despues se incrementa el valor de $x en uno
          $this->pdf->Cell(15,5,$x++,'BL',0,'C',0);
          // Se imprimen los datos de cada alumno
          $this->pdf->Cell(25,5,$alumno->paterno,'B',0,'L',0);
          $this->pdf->Cell(25,5,$alumno->materno,'B',0,'L',0);
          $this->pdf->Cell(25,5,$alumno->nombre,'B',0,'L',0);
          $this->pdf->Cell(40,5,$alumno->fec_nac,'B',0,'C',0);
          $this->pdf->Cell(25,5,$alumno->grado,'B',0,'L',0);
          $this->pdf->Cell(25,5,$alumno->grupo,'BR',0,'C',0);
          //Se agrega un salto de linea
          $this->pdf->Ln(5);
          } */
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Lista de alumnos.pdf", 'I');
    }

}
