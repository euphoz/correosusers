<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domus</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/js/login.js')?>"></script>
  </head>
  <body>
    <?php
    $tipo = $this->session->userdata('tipo');
      if ( $tipo == "1") {
        $this->load->view('navbar');
      }else{
        $this->load->view('usernavbar');
      }
      ?>
<br />
<br />
<br />

  <div class="container">
    <div class="container">
      <button class="btn btn-success" onclick="add_terreno()"><i class="glyphicon glyphicon-plus"></i> Agregar Terreno </button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
        <tr>

          <th>ID</th>
          <th>Código</th>
          <th>Inmueble</th>
          <th>Tipo</th>
          <th>Dirección</th>
          <th>Región</th>
          <th>Comuna</th>
          <th>Mts2/miles</th>
          <th>UF/Mts2</th>
          <th>Valor/miles</th>
          <th>Rol&nbsp;&nbsp;&nbsp;&nbsp;</th>
          <th>Propietario</th>
          <th>Corredor</th>
          <th>Observaciones</th>
          <th>Letrero</th>
          <th style="width:125px;">Administrar
          </p></th>
        </tr>
      </thead>
      <tbody>
        <?php
$apiUrl = 'http://mindicador.cl/api';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($apiUrl);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
}

$dailyIndicators = json_decode($json);
$uf = $dailyIndicators->uf->valor;
echo 'Valor actual de la UF <input type="text" id="vuf" value = '.$uf.'>';
?>
        <?php foreach($regs as $reg){?>
             <tr>

                  <?php $metros = $reg->mts2/1000; ?>
                  <?php $fomento = number_format($reg->uf,1); ?>
                  <? $valortotal = (($reg->uf * $uf) * $reg->mts2)/1000; ?>
                  <? $valortotalF = number_format($valortotal,0,',','.'); ?>

                  <td id='id_terreno'><?php echo $reg->id_terreno;?></td>
                  <td><?php echo $reg->codigo;?></td>
                  <td><?php echo $reg->inmueble;?></td>
                  <td><?php echo $reg->tipo;?></td>
                  <td><?php echo $reg->direccion;?></td>
                  <td><?php echo $reg->region;?></td>
                  <td><?php echo $reg->ciudad;?></td>
                  <td><?php echo $metros;?></td>
                  <td><?php echo $fomento;?></td>
                  <td><?php echo $valortotalF;?></td>
                  <td><?php echo $reg->rol;?></td>
                  <td><?php echo $reg->propietario;?></td>
                  <td><?php echo $reg->corredor;?></td>
                  <td><?php echo $reg->observaciones;?></td>
                  <td><?php echo $reg->letrero;?></td>
                  <td>
                    <button class="id_terreno btn btn-warning" onclick="edit_terreno(<?php echo $reg->id_terreno;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
                    <button class="btn btn-danger" onclick="delete_terreno(id_terreno)"><i class="glyphicon glyphicon-remove"></i></button>
                  </td>
              </tr>
             <?php }?>
      </tbody>

    </table>

  </div>

  <script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>


  <script type="text/javascript">
  $(document).ready( function () {
      $('#table_id').DataTable();
  } );

  var save_method; //for save method string
  var table;


    function add_terreno()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

    function edit_terreno(id_terreno)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('/TerrenosC/ajax_edit/')?>/" + id_terreno,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id_terreno"]').val(data.id_terreno);
            $('[name="codigo"]').val(data.codigo);
            $('[name="inmueble"]').val(data.inmueble);
            $('[name="tipo"]').val(data.tipo);
            $('[name="direccion"]').val(data.direccion);
            $('[name="region"]').val(data.region);
            $('[name="ciudad"]').val(data.ciudad);
            $('[name="mts2"]').val(data.mts2);
            $('[name="uf"]').val(data.uf);
            $('[name="valor"]').val(data.valor);
            $('[name="letrero"]').val(data.letrero);
            $('[name="rol"]').val(data.rol);
            $('[name="propietario"]').val(data.propietario);
            $('[name="corredor"]').val(data.corredor);
            $('[name="observaciones"]').val(data.observaciones);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Terreno'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error obteniendo datos');
        }
    });
    }

    function save()
    {
      var url;
      if(save_method == 'add')
      {
          url = "<?php echo site_url('/TerrenosC/terreno_add')?>";
      }
      else
      {
        url = "<?php echo site_url('/TerrenosC/terreno_update')?>";
      }

          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {

              $('#modal_form').modal('hide');
              location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error agregando / Actualizando');
            }
        });
    }

    function delete_terreno(id_terreno)
    {
      if(confirm('¿Estás seguro de hacer esto?'))
      {
        // ajax delete data from database
          $.ajax({
            url : "<?php echo site_url('/TerrenosC/terreno_delete')?>/"+id_terreno,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {

               location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error borrando la información');
            }
        });

      }
    }
/*

});
*/
  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Terreno</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_terreno"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Código</label>
              <div class="col-md-9">
                <input name="codigo" placeholder="Código" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Inmueble</label>
              <div class="col-md-9">
                <input name="inmueble" placeholder="Inmueble" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Tipo</label>
              <div class="col-md-9">
                <input name="tipo" placeholder="Tipo" class="form-control" type="text">

              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Dirección</label>
              <div class="col-md-9">
                <input name="direccion" placeholder="Dirección" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Región</label>
              <div class="col-md-9">
                <input name="region" placeholder="Región" class="form-control" type="tel">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Comuna</label>
              <div class="col-md-9">
                <input name="ciudad" placeholder="Comuna" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Mts2</label>
              <div class="col-md-9">
                <input name="mts2" placeholder="Metros cuadrados" class="form-control" type="text">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">UF/mts2</label>
              <div class="col-md-9">
                <input name="uf" placeholder="UF por Mts2" class="form-control" type="text">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Letrero</label>
              <div class="col-md-9">
                <input name="letrero" placeholder="Letrero" class="form-control" type="text">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Rol</label>
              <div class="col-md-9">
                <input name="rol" placeholder="Rol" class="form-control" type="text">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Propietario</label>
              <div class="col-md-9">
                <input name="propietario" placeholder="Propietario" class="form-control" type="text">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Corredor</label>
              <div class="col-md-9">
                <input name="corredor" placeholder="Corredor" class="form-control" type="text">
            </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Observaciones</label>
              <div class="col-md-9">
                <input name="observaciones" placeholder="Observaciones" class="form-control" type="text">
            </div>
            </div>
          </div>
        </form>
      </div>

          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

  </body>
</html>
