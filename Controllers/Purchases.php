<?php
	class Purchases extends Controller
	{
		public function __construct()
		{
		    session_start();

		    parent::__construct();
		}

		public function index()
		{
			if (empty($_SESSION['activo'])) {
		    	header("location: ".BASE_URL);
		    }
			$this->views->getView($this, "index");
		}

		public function searchCodigo($cod)
		{
			$data = $this->model->getProCod($cod);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function addPurchase()
		{
		    $id = $_POST['id'];
		    $datas = $this->model->getProduct($id);
		    $id_user = $_SESSION['user_id'];
		    $id_product = $datas['id'];
		    $price = $datas['price_comp'];
		    $stock = $_POST['stock'];

		    $consult = $this->model->consultDetail($id_product, $id_user);

		    if (empty($consult)) {
		    	$sub_total = $price * $stock;
		    	$data = $this->model->addDetail($id_user, $id_product, $price, $stock, $sub_total);
			    if ($data == "ok") {
			    	$msg = "ok";
			    } else {
			    	$msg = "Error en la ingresar el producto";
			    }
		    } else {
		    	$newStock = $consult['stock'] + $stock;
		    	$sub_total = $price * $newStock;
		    	$data = $this->model->updateDetail($price, $newStock, $sub_total, $id_product, $id_user);
			    if ($data == "modificado") {
			    	$msg = "ok";
			    } else {
			    	$msg = "Error en la ingresar el producto";
			    }
		    }

		    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		    die();
		}

		public function addDetails()
		{
			$id = $_SESSION['user_id'];
		    $data['detail'] = $this->model->getDetails($id);
		    $data['total'] = $this->model->totalCompra($id);
		    echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		public function deleteDetails($id)
		{
		    $data = $this->model->deleteDetail($id);
		    if ($data == "ok") {
		    	$msg = "ok";
		    } else {
		    	$msg = "Error al eliminar el priducto";
		    }
		    echo json_encode($msg);
		    die();
		}

		public function register()
		{
			$id = $_SESSION['user_id'];
			$total = $this->model->totalCompra($id);
			$data = $this->model->register($total['total']);
			if ($data == "ok") {
				$details = $this->model->getDetails($id);
				$id_purchase = $this->model->id_purchase();
				foreach ($details as $detail) {
					$id_product = $detail['id_product'];
					$stock = $detail['stock'];
					$price = $detail['price'];
					$sub_total = $price * $stock;
					$this->model->registraDetail($id_purchase['id'], $id_product, $stock, $price, $sub_total);
					$stockActual = $this->model->getProduct($id_product);
					$stockActualizado = $stockActual['stock'] + $stock;
					$this->model->updateStock($id_product, $stockActualizado);
				}
				$vaciar = $this->model->vaciarDetalle($id);
				if ($vaciar == "ok") {
					$msg = array('msg' => 'ok', 'id_compra' => $id_purchase['id']);
				}
			} else {
				$msg = "error al hacer la compra";
			}

			echo json_encode($msg);
			die();
		}

		public function generarPdf($id_purchase)
		{
			$empresa = $this->model->getEmpresa();
			$productos = $this->model->getProPurchase($id_purchase);

			require('libraris/fpdf/fpdf.php');

			$pdf = new FPDF('P','mm',array(80, 200));
			$pdf->AddPage();
			$pdf->SetMargins(5,0,0);
			$pdf->SetTitle('Reporte de Compra');
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(65,10, utf8_decode($empresa['name']), 0, 1, 'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(18,5, 'rut :', 0, 0, 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5, $empresa['rif'], 0, 1, 'L');

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(18,5, 'Telefono :', 0, 0, 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5, $empresa['phone'], 0, 1, 'L');

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(18,5, 'Direccion :', 0, 0, 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5, $empresa['addres'], 0, 1, 'L');

			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(18,5, 'Folio :', 0, 0, 'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(20,5, $id_purchase, 0, 1, 'L');
			$pdf->Ln();

			// Encabesado
			$pdf->SetFillColor(0,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(10,5,'Cant',0,0,'L', true);
			$pdf->Cell(35,5,utf8_decode('Descripción'),0,0,'L', true);
			$pdf->Cell(10,5,'Precio',0,0,'L', true);
			$pdf->Cell(15,5,'SUb-Total',0,1,'L', true);

			$pdf->SetTextColor(0,0,0);
			$total = 0.00;
			foreach ($productos as $pro) {
				$total = $total + $pro['sub_total'];
				$pdf->Cell(10,5,$pro['stock'],0,0,'L');
				$pdf->Cell(35,5,utf8_decode($pro['name']),0,0,'L');
				$pdf->Cell(10,5,$pro['price'],0,0,'L');
				$pdf->Cell(15,5,number_format($pro['sub_total'], 2, '.', ','),0,1,'L');
			}
			$pdf->Ln();
			$pdf->Cell(70,5,'Total a Pagar',0,1,'R');
			$pdf->Cell(70,5,number_format($total, 2, '.', ','),0,1,'R');

			$pdf->Output();
		}

		public function historial()
		{
			$this->views->getView($this, "historial");
		}

		public function listar()
		{
			$data = $this->model->historialCompra();
			for ($i=0; $i < count($data) ; $i++) {
				$data[$i]['acciones'] = '<div>
					<a class="btn btn-danger" href="'.BASE_URL . "Purchases/generarPdf/" . $data[$i]['id'] .'" target="_blank"><i class="fas fa-file-pdf"></i></a>
				</div>';
			}
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
