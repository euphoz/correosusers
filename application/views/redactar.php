<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://rawgit.com/markdalgleish/stellar.js/master/jquery.stellar.js'></script>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/simditor.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/module.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/hotkeys.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/uploader.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/simditor.js"></script>
<title>Domus</title>
  <style type="text/css">
    .bs-twrapper{
    width: 30%;
    height:500px;
    overflow-x:scroll;
    overflow-x:hidden;
    padding-top:10px;
    margin-top: -350px;
    margin-left: 100px; 
    float: left;
  }

  .opciones {
  width: 702px;
  border: 1px #000000 solid;
  margin-left: 290px;

  }

  </style>
  
    <?php 
    $tipo = $this->session->userdata('tipo');
    if ( $tipo == "1") {
      $this->load->view('navbar'); 
    }else{
      $this->load->view('usernavbar');
    }
    ?>
<br>
<br>
<br>

<div class="container" style="margin-right: 100px;">
    <div class="row">
        <div class="col-md-9 col-md-offset-3">
            <form class="form-horizontal" enctype='multipart/form-data' method="POST" action="<?=base_url();?>Cpersona/sendMail">
                <fieldset>
                  <div class="form-group">
                      <div class="col-md-6">
                          <label style="font-size: 15px; margin-left: 215px;">Destinatarios</label><br />
                          <input type="button" name="agregardes" id="agregardes" onclick="llenarDestino();correos();" style="font-size: 15px; margin-left: 215px;" value="Agregar Destinatarios">
                          <input style="margin-left: 215px;" id="email" name="email" type="text" class="form-control" required>
                          <label style="font-size: 15px; margin-left: 215px;">Asunto</label><br />
                          <input style="margin-left: 215px;" type="text" class="form-control" name="asunto" id="asunto">
                          <label style="font-size: 15px; margin-left: 215px;">Mensaje</label><br />
                      </div>
                      <div class="col-md-9" style="float: right;">
                          <textarea id="editor" name="mensaje"></textarea>
                      </div> 
                  </div>
                  <section>
                      <div style="margin-left: 215px;">
                      <p id="msg"></p>
                      <input type="file" id="file" name="file" />
                      </div>
                  </section>

                  <div>
                      <br />
                      <input style="margin-left: 215px;" class="btn btn-primary" type="submit" name="enviar" value="Enviar">
                  </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>             
<div style="margin-top: -600px; float: left;">    
        <?php $this->load->view("clientes"); ?>
</div>
<script type="text/javascript">
    function submit() {
    var form = document.getElementById('uploadform');
    form.submit();
  };
</script>
    <script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/clientes.js"></script>

<script type="text/javascript">
    var editor = new Simditor({
    textarea: $('#editor'),
    placeholder: 'Escribir mensaje',

});

</script>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('#file').on('change', function () {
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: 'http://mail.mayordomus.cl/Cpersona/upload_file', // point to server-side controller method
                dataType: 'text', // what to expect back from the server
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    $('#msg').html(response); // display success response from the server
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the server
                }
            });
        });
    });
</script>
                 
       <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $('#upload').on('click', function () {
                    var file_data = $('#archivo').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('archivo', file_data);
                    $.ajax({
                        url: 'http://mail.mayordomus.cl/Cpersona/cargar_archivo', // point to server-side controller method
                        dataType: 'text', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            $('#msg').html(response); // display success response from the server
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the server
                        }
                    });
                });
            });
        </script>
    <script src="<?php echo base_url('assets/js/login.js')?>"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/clientes.js"></script>
    <script type="text/javascript">

    </script>
