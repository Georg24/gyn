<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// Incluimos el archivo fpdf
require_once APPPATH . "/third_party/fpdf/fpdf.php";

//Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
class Pdfex extends FPDF {

    public function __construct() {
        parent::__construct();
    }

    // El encabezado del PDF
    public function Header($head = False) {
        $this->AddFont('tahomaWF');
        $this->Image(base_url() . '/sources/images/logo2.png', 12, 12, -350);
        if ($head) {
            $ci = &get_instance();
            $this->SetFont('Helvetica', 'B', 10);
            $this->SetLeftMargin(6);
            $this->SetRightMargin(6);
            //$this->Cell(0);
            $this->Cell(40, 10, '', 0, 0, 'C', 0, 0);
            $this->Cell(50, 10, 'G&N Importaciones', 0, 0, 'C', 0, 0);
            $this->Ln(4);
            $this->SetFont('tahomaWF', '', 8);
            //$this->SetFont('Courier','',7.5);
            $this->Cell(40, 8, '', 0, 0, 'C', 0, 0);
            $this->Cell(60, 8, $ci->config->item('direccion'), 0, 0, 'C', 0, 0);
            $this->Ln(2.5);
            $this->Cell(40, 8, '', 0, 0, 'C', 0, 0);
            $this->Cell(60, 8, $ci->config->item('local'), 0, 0, 'C', 0, 0);
            $this->Ln(2.5);
            $this->Cell(40, 8, '', 0, 0, 'C', 0, 0);
            $this->Cell(60, 8, $ci->config->item('puesto1'), 0, 0, 'C', 0, 0);
            $this->Ln(2.5);
            $this->Cell(40, 8, '', 0, 0, 'C', 0, 0);
            $this->Cell(45, 8, $ci->config->item('telefono'), 0, 0, 'R', 0, 0);
            $this->Cell(15, 8, ">", 0, 0, 'L', 0, 0);
            $this->Ln(2.5);
            $this->Cell(40, 8, '', 0, 0, 'C', 0, 0);
            $this->Cell(60, 8, $ci->config->item('gerente'), 0, 0, 'C', 0, 0);
            $this->Ln(3);
        }
    }

    // El pie del pdf
    public function Footer() {
        //$this->SetY(-15);
        //$this->SetFont('Arial','I',8);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    public function propEstrecha() {
        //$this->SetFont('Arial','',6.5);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->SetFont('tahomaWF', '', 6.5);
        $this->Cell(90, 4, 'G&N Importaciones - SONY, PHILIPS, beats, ewtto, CAFiNi, Bluedio, Skullcandy', 0, 0, 'C', 0, 0);
        $this->Ln(2.5);
        $this->Cell(90, 4, 'SanDisk, Kingston, BOSE', 0, 0, 'C', 0, 0);
        $this->Ln(2.5);

        $this->Cell(90, 4, '< njoytechgyn  > +591 70506448 e: ghilmarmendoza@gmail.com', 0, 0, 'C', 0, 0);
        $this->SetFont('Arial', '', 6);
        $this->Ln(3);
        $this->Cell(90, 4, 'fecha de impresion:' . date('d/m/Y'), 0, 0, 'C', 0, 0);
    }
    public function pie() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
