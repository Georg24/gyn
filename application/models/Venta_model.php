<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Venta_model extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->database();
    }

    //vender desde cotrol venta, recibe el array bidimensional con los datos modelo cantidad precio existencia 
    //de productos para adicionar a la venta
    //addicion de COD_VENTA con la fecha y usuario que hace la venta
    function registrarVenta($productos) {
        $msg = 0;
        try {
            $total = 0; //inicializamos el total
            $existencia = 0; // no se usa
            $detalle = array(); //inicializamos los datos para registro en detalle_venta
            $cliente = $this->db->query('select id_cliente from cliente where nombre like "' . $productos[1]['cliente'] . '"')->row(); //verificamos si el cliente existe en bd
            if (sizeof($cliente)>0) //si existe obtenemos su id
                $id_cliente = $cliente->id_cliente;
            else //si no existe predefinimos 1 como cliente como en base de datos
                $id_cliente = 1;
            for ($i = 1; $i <= sizeof($productos); $i++) { // hacemos la sumatoria del total 
                $total = $total + floatval($productos[$i]['subtotal']);
            }
            $venta['cod_venta'] = "V-" . date("ymdhi") . $id_cliente . $this->session->userdata('codusu'); //el codigo de venta por la fecha hora minuto idcliente y la primera letra del nombre del usuario
            $venta['ci'] = $this->session->userdata('ci'); //los datos para venta
            $venta['id_cliente'] = $id_cliente;
            $venta['fecha'] = date("Y-m-d");
            $venta['total'] = $total;
            $resp = $this->db->insert('venta', $venta); //llenamos el detalle de la venta
            for ($i = 0; $i < sizeof($productos); $i++) {
                $detalle[$i]['cod_venta'] = $venta['cod_venta'];
                $detalle[$i]['modelo'] = $productos[$i + 1]['modelo'];
                $detalle[$i]['cantidad'] = $productos[$i + 1]['cantidad'];
                $detalle[$i]['precio'] = $productos[$i + 1]['precio'];
                //actualiza la cantidad en la tabla de productos
                $this->db->query('update producto set existencia = existencia-' . $detalle[$i]['cantidad'] . ' where modelo like "' . $detalle[$i]['modelo'] . '"');
            }
            $this->db->insert_batch('detalle_venta', $detalle);
            $msg = $venta['cod_venta']; //devolvemos el codigo de la venta para generar el recibo
            return $msg;
        } catch (Exception $exc) {
            $msg = "ERROR AL AGREGAR LA VENTA \n" . $exc->getTraceAsString();
            return $msg;
        }
    }
    //registrar la reserva como una venta con efectiva=0 false
    function registrarReserva($productos) {
        $msg = 0;
        try {
            $total = 0; //inicializamos el total
            $existencia = 0; // no se usa
            $detalle = array(); //inicializamos los datos para registro en detalle_venta
            $cliente = $this->db->query('select id_cliente from cliente where nombre like "' . $productos[1]['cliente'] . '"')->row(); //verificamos si el cliente existe en bd
            if (sizeof($cliente)>0) //si existe obtenemos su id
                $id_cliente = $cliente->id_cliente;
            else //si no existe predefinimos 1 como cliente como en base de datos
                $id_cliente = 1;
            for ($i = 1; $i <= sizeof($productos); $i++) { // hacemos la sumatoria del total 
                $total = $total + floatval($productos[$i]['subtotal']);
            }
            $venta['cod_venta'] = "V-" . date("ymdhi") . $id_cliente . $this->session->userdata('codusu'); //el codigo de venta por la fecha hora minuto idcliente y la primera letra del nombre del usuario
            $venta['ci'] = $this->session->userdata('ci'); //los datos para venta
            $venta['id_cliente'] = $id_cliente;
            $venta['fecha'] = date("Y-m-d");
            $venta['total'] = $total;
            $venta['efectiva'] = 0; //por ser reserva tiene 0  fasle
            $resp = $this->db->insert('venta', $venta); //llenamos el detalle de la venta
            for ($i = 0; $i < sizeof($productos); $i++) {
                $detalle[$i]['cod_venta'] = $venta['cod_venta'];
                $detalle[$i]['modelo'] = $productos[$i + 1]['modelo'];
                $detalle[$i]['cantidad'] = $productos[$i + 1]['cantidad'];
                $detalle[$i]['precio'] = $productos[$i + 1]['precio'];
                //actualiza la cantidad en la tabla de productos
                $this->db->query('update producto set existencia = existencia-' . $detalle[$i]['cantidad'] . ' where modelo like "' . $detalle[$i]['modelo'] . '"');
            }
            $this->db->insert_batch('detalle_venta', $detalle);
            $msg = $venta['cod_venta']; //devolvemos el codigo de la venta para generar el recibo
            return $msg;
        } catch (Exception $exc) {
            $msg = "ERROR AL AGREGAR LA VENTA \n" . $exc->getTraceAsString();
            return $msg;
        }
    }
    
    //get ventas
    public function getVentas() {
        $tabla = $this->db->get('venta');
        return $tabla->result();
    }

    public function sumaVentas() {
        $tabla = $this->db->query('select sum(total) as todo from venta');
        return $tabla->result();
    }

    public function getVentasXDia($dia = FALSE,$ci=FALSE) {
        if ($dia){
            if($ci==FALSE || $ci=="todos" || $ci=="")
                $tabla = $this->db->query('select v.cod_venta,u.nombre as usuario,c.nombre as cliente,v.fecha,v.total,v.efectiva FROM venta v, usuario u,cliente c where u.ci=v.ci and v.efectiva=1 and c.id_cliente=v.id_cliente and fecha="' . $dia . '"');
            else
                $tabla = $this->db->query('select v.cod_venta,u.nombre as usuario,c.nombre as cliente,v.fecha,v.total,v.efectiva FROM venta v, usuario u,cliente c where u.ci=v.ci and v.efectiva=1 and c.id_cliente=v.id_cliente and fecha="' . $dia . '" AND u.ci like "'.$ci.'"');
        }
        else
            $tabla = $this->db->query('select v.cod_venta,u.nombre as usuario,c.nombre as cliente,v.fecha,v.total,v.efectiva FROM venta v, usuario u,cliente c where u.ci=v.ci and v.efectiva=1 and c.id_cliente=v.id_cliente and fecha="' . date('Y-m-d') . '"');
        return $tabla->result();
    }

    //detalle de ventas
    public function getDetalleVenta($cod) {
        $tabla = $this->db->query('SELECT v.cod_venta,v.fecha,d.modelo,p.descripcion,d.cantidad,d.precio,c.nombre,v.efectiva,(d.cantidad*d.precio) as subtotal FROM venta v,detalle_venta d,cliente c,producto p WHERE p.modelo=d.modelo and v.cod_venta=d.cod_venta and c.id_cliente=v.id_cliente and v.cod_venta like "' . $cod . '"');
        return $tabla->result();
    }
    //recibe fechas //incluyendo el campo sumTotal agrupadas por dia
    public function getDiariasPorPeriodo($desde,$hasta){
        $tabla = $this->db->query("SELECT fecha,COUNT(cod_venta) as ventas,SUM(total) AS sumTotal FROM venta WHERE efectiva=1 AND fecha BETWEEN '".$desde."' AND '".$hasta."' GROUP BY fecha");
        return $tabla->result();
    }
    //devuelve el campo total_ingreso
    public function sumDiariasPorPeriodo($desde,$hasta){
        $tabla = $this->db->query("SELECT SUM(total) AS total_ingreso FROM venta WHERE efectiva=1 AND fecha BETWEEN '".$desde."' AND '".$hasta."'");
        return $tabla->row()->total_ingreso;
    }
    //ganancia contra unidades vendidas de los productos activos
    public function ganaciaPorProducto($limite=FALSE,$orden='sumcantidad') {
        $query="SELECT p.modelo,".
                    " p.existencia,".
                    " p.costo,SUM(d.cantidad) AS sumcantidad,".
                    " SUM(d.cantidad*d.precio)/SUM(d.cantidad) AS precio_promedio ,".
                    " p.costo*SUM(d.cantidad) AS sumcosto,".
                    " SUM(d.precio*d.cantidad) AS sumprecio,".
                    " SUM(d.precio*d.cantidad)-p.costo*SUM(d.cantidad) AS neta,".
                    " ((SUM(d.precio*d.cantidad)-p.costo*SUM(d.cantidad))/(p.costo*SUM(d.cantidad)))*100 AS porcentaje".
                    " FROM producto p,detalle_venta d, venta v WHERE d.cod_venta LIKE v.cod_venta AND d.modelo LIKE p.modelo AND p.activo=1".
                    " GROUP BY p.modelo ORDER BY ".$orden." DESC";
        if($limite!==FALSE)
        {
            $query=$query." LIMIT ".$limite;
        }
        $tabla= $this->db->query($query);
        return $tabla->result();
    }
    //recibe un bi array(1[modelo,cantidad,precio,subtotal,codigo],2...)
    public function ajusteDetalleVenta($datos) {
        $ci = $this->session->userdata('ci');
        $usu = $this->session->userdata('codusu');
        $codigo = $datos[1]['codigo'];
        $cod_venta= "A-". date('ydmhi').$usu;
        $this->db->query('INSERT INTO ajuste_venta SELECT "'.$cod_venta.'" as cod_ajuste, cod_venta,"' . $ci . '",CURRENT_DATE() FROM venta where cod_venta like "' . $codigo . '"');
        if ($this->db->affected_rows() > 0) {
            $this->db->query("INSERT INTO detalle_ajuste (cod_ajuste,modelo,cantidad,precio) SELECT '".$cod_venta."' as cod_ajuste,modelo,cantidad,precio FROM detalle_venta WHERE cod_venta like '" . $codigo . "'");
            if ($this->db->affected_rows() > 0) {
                $total=0;
                for($i=1;$i<=sizeof($datos);$i++){
                    $this->db->query("UPDATE detalle_venta SET cantidad=".$datos[$i]['cantidad'].",precio=".$datos[$i]['precio']." WHERE cod_venta like '".$codigo."' and modelo like '".$datos[$i]['modelo']."'");
                    $diferencia=$datos[$i]['cantidad']-$datos[$i]['antcant'];
                    if($diferencia>=0)
                    {
                        $this->db->query("UPDATE producto SET existencia=existencia-".$diferencia." WHERE modelo LIKE '".$datos[$i]['modelo']."'");
                    } else { 
                        $diferencia=$diferencia*(-1);
                        $this->db->query("UPDATE producto SET existencia=existencia+".$diferencia." WHERE modelo LIKE '".$datos[$i]['modelo']."'");
                    }
                    $total=$total+$datos[$i]['subtotal'];
                }
                $this->db->query("UPDATE venta SET total=".$total." where cod_venta like '".$codigo."'");
                if ($this->db->affected_rows() > 0) {
                    return "Se ha registrado el ajuste de venta";
                }
                else{
                    return "Se ha registrado el ajuste de venta con el mismo total";
                }
            }
            else
            {
                return "ERROR no se ha registrado el detalle del ajuste de venta";
            }
        } else {
            return "ERROR No se ha completado el Registro del Ajuste de Venta";
        }
    }

}
