<?php include "Views/Layouts/Header.php"; ?>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
    </ol>

  <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h4>Nueva compra</h4>
    </div>
    <div class="card-body">
      <form id="frmPurchase">
        <div class="row">

          <div class="col-md-3">
            <div class="form-floating mb-3">
                <input type="hidden" name="id" id="id">
                <input class="form-control" id="codigo" name="codigo" type="text" onkeyup="searchCodigo(event)" />
                <label for="codigo"> Codigo de barra</label>
            </div>
          </div>

          <div class="col-md-5">
            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" disabled />
                <label for="name"> Nombre</label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" id="stock" name="stock" type="number" onkeyup="subTotal(event)"/>
                <label for="stock"> Cantidad</label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" id="price_comp" name="price_comp" type="number" disabled/>
                <label for="price_comp"> Precio</label>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-floating mb-3">
                <input class="form-control" id="sub_total" name="sub_total" type="number" disabled/>
                <label for="sub_total"> Sub-Total</label>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>

<table class="table table-light table-bordered table-hover" id="tblPurchase">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Sub-Total</th>
          <th></th>
        </tr>
        <tbody id="tblDetails">
        </tbody>
      </thead>
    </table>

    <div class="row">
      <div class="d-flex justify-content-end">
        <div class="row">
          <div class="col-md-12">
            <div class="form-floating mb-3">
                <input class="form-control" id="total" name="total" type="number" disabled/>
                <label for="total"> Total</label>
            </div>
          </div>

          <div class="col-md-12 ml-auto">
            <button class="btn btn-primary" type="button">Generar compra</button>
          </div>
        </div>
        </div>



    </div>

<?php include "Views/Layouts/Footer.php"; ?>