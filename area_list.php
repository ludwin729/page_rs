<?php 
# ############### CARGA DE CONSTANTES Y LIBRERIAS ################ #
include_once(__DIR__.DIRECTORY_SEPARATOR."app.config.php");
# ################################################################ #

$page_title = "Listado de Areas / Departamentos"; 

ob_start();


?>
<!-- Inicio Modales -->

    <!-- Formulario Area -->
    <div id="modal_area" class="modal modal-primary fade bs-example-modal-multiple" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><span class="name_action"></span> Area</h4>
                </div>
                <form id="frm_area" class="form-horizontal" role="form" novalidate="novalidate">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-2 col-xs-4 control-label" for="nom_area">Nombre <span class="asterisk">*</span></label>
                            <div class="col-md-10 col-xs-8">
                                <input type="text" class="form-control" id="nom_area" name="nom_area">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 col-xs-4 control-label" for="desc_area">Descripción </label>
                            <div class="col-md-10 col-xs-8">
                                <textarea rows="3" class="form-control" id="desc_area" name="desc_area"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 text-left">
                                <div class="validation_error text-danger"> Complete correctamente los campos señalados </div>
                                <div class="loading_data"></div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="btn_area">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Formulario Area -->

<!-- Fin Modales -->

<!-- Start page header -->
<div class="header-content">
    <h2><i class="fa fa-table"></i> Areas / Departamentos <span>Mantenedor de Datos</span></h2>
    <div class="breadcrumb-wrapper hidden-xs">
        <span class="label">Estás en:</span>
        <ol class="breadcrumb">
        <li>
                <i class="fa fa-home"></i>
                <a href="#">Mantenedores</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Listados</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li class="active">Areas</li>
        </ol>
    </div><!-- /.breadcrumb-wrapper -->
</div><!-- /.header-content -->
<!--/ End page header -->
<?php 
require_once("inc_html_utils.php");
?>
<!-- Start body content -->
<div class="body-content animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right mb-10">
                <button type="button" class="btn btn-rss" onclick="area(1,0)"><i class="fa fa-plus"></i> AGREGAR</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <!-- Start basic color table -->
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3 col-xs-12 pull-right">
                            <div class="form-group">
                                <label for="txt-search">Nombre | Descripción </label>
                                <input type="text" class="form-control" id="txt-search" name="txt-search">
                            </div>
                        </div>
                    </div>                    
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->
                <div class="panel-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-default table-hover" id="table_area">
                            <thead>
                                <tr>
                                    <th width="6%" class="text-center border-right">No.</th>
                                    <th width="32%">Nombre</th>
                                    <th width="50%">Descripción</th>
                                    <th width="12%" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <!--/ End basic color table -->
        </div><!-- /.col-md-12 -->
    </div><!-- /.row -->

</div><!-- /.body-content -->
<!--/ End body content -->

<!-- INICIO JAVASCRIPT -->
<script type="text/javascript">
    $(function(){

        listar_area();

        $('#frm_area').validate({
            errorContainer: $('div.validation_error'),
            rules:{
                nom_area:{
                    required:true
                }
            },
            messages: {
            },
            highlight:function(element) {
                $(element).parents('.form-group').addClass('has-error has-feedback');
            },
            unhighlight: function(element) {
                $(element).parents('.form-group').removeClass('has-error');
            },
            submitHandler: function() {
                //alert("submitted!");
            }
        });

        /* Live Filter */
        $("#txt-search").keyup(function(){
            var _this = this;
            $.each($("#table_area tbody tr"), function() {
                if($(this).find(".atr-search").text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                   $(this).hide();
                else
                   $(this).show();
            });
        });
    });


    function listar_area() {
        $("#txt-search").val("");

        $.ajax({
            url: "controller/area.php?ent=2&ope=5",
            data: {},
            type: "post",
            dataType: "json",
            beforeSend: function() {
                $('#table_area tbody').html('<tr><td colspan="4" align="center"><i class="fa fa-spinner fa-spin"></i> Cargando datos  ... </td></tr>');
            },
            success: function(data){
                obj_lista=data.data_list;
           }
        }).done(function() {
            var contenido_lista = $('#table_area tbody');
            contenido_lista.html('');
            if(Object.keys(obj_lista).length>0){
                var cont_ent=0;
                for (var key in obj_lista) { cont_ent++;

                    contenido_lista_concat='<tr>\
                                                <td class="border-right text-center">'+cont_ent+'</td>\
                                                <td class="atr-search">'+obj_lista[key]['nameArea']+'</td>\
                                                <td class="atr-search">'+obj_lista[key]['descriptionArea']+'</td>\
                                                <td class="text-center">\
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Editar" onclick="area(2, '+obj_lista[key]['codArea']+')"><i class="fa fa-pencil"></i></a>\
                                                    <button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" data-id="'+obj_lista[key]['codArea']+'" onclick="delete_area(this)"><i class="fa fa-times"></i></button>\
                                                </td>\
                                            </tr>';

                    contenido_lista.append(contenido_lista_concat);
                }
            }else{
                contenido_lista_concat='<tr>\
                                            <td colspan="6" class="text-center"> <i class="fa fa-info-circle"></i> No se encontraron registros </td>\
                                        </tr>';
                contenido_lista.append(contenido_lista_concat).fadeIn(300);
            }

            $('[rel=tooltip]').tooltip({container:"body"});

        });
    }
    

    function area(action, id) {
        $('#modal_area').modal('show');
        limpiarForm('frm_area', 'nom_area');
        modalInitValid();
        $("#frm_area" ).unbind();

        $('#modal_area .name_action').html('Registrar');
        $('#modal_area #btn_area').html('Guardar');

        if(action === 2){
            $('#modal_area .name_action').html('Editar');
            $('#modal_area #btn_area').html('Editar');

            $.ajax({
                url: "controller/area.php?ent=2&ope=3",
                data: {id:id},
                type: "post",
                dataType: "json",
                beforeSend: function() {
                    $('#frm_area .loading_data').html('<i class="fa fa-spinner fa-spin"></i> Cargando Datos ... ');
                },
                success: function(data){
                    $('#frm_area .loading_data').html('');
                    if(data.completado){
                        $('#frm_area').populate(data.data_row);
                    }else{
                        not_error(data.mensaje);
                    }
                }
            });
        }


        $('#frm_area').submit(function(e) {

            if ($("#frm_area").valid()){

                data_frm = new FormData(this);
                $('#modal_confirmacion').unbind();
                $('#modal_confirmacion').modal({ backdrop: 'static', keyboard: false }).one('click', '#btn_confirmacion', function (e) {
                    $.ajax({
                        url: "controller/area.php?ent=2&ope="+action+"&id="+id,
                        type: "post",
                        dataType: "json",
                        data: data_frm,
                        processData: false,
                        contentType: false,
                        cache:false,
                        //async:false,
                        beforeSend: function() {
                            $('#frm_area .loading_data').html('<i class="fa fa-spinner fa-spin"></i> Guardando ... ');
                            $("#frm_area #btn_area").prop("disabled",true);
                        },
                        success: function(data){
                            $('#frm_area .loading_data').html('');
                            $("#frm_area #btn_area").prop("disabled",false);

                            if(data.completado){
                                $('#modal_area').modal('hide'); 
                                listar_area();
                            }else{
                                not_alerta(data.mensaje);
                            }
                        }
                    });
                });
            }
            e.preventDefault();
        });        
    }

    function delete_area(ele){
        $('#modal_confirmacion').unbind();
        $('#modal_confirmacion').modal({ backdrop: 'static', keyboard: false }).one('click', '#btn_confirmacion', function (e) {
            var id = $(ele).data("id");
            $(ele).html('<i class="fa fa-spin fa-refresh"></i>');
            $(ele).prop("disabled",true);

            $.ajax({
                url: "controller/area.php?ent=2&ope=4&id="+id,
                type: "post",
                dataType: "json",
                success: function(data){
                    if(data.completado){
                        listar_area();
                    }else{
                        $(ele).html('<i class="fa fa-times"></i>');
                        $(ele).prop("disabled",false);
                        not_alerta(data.mensaje);
                    }
                }
            });
        });
    }

    
</script>

<?php
	$page_main_content = ob_get_contents();
	ob_end_clean();

	//Extras
	ob_start();
?>

<!-- Scripts extras -->
<link href="assets/global/plugins/bower_components/select2-ng/select2.css" rel="stylesheet">
<link href="assets/global/plugins/bower_components/select2-ng/select2-bootstrap.css" rel="stylesheet">
<script src="assets/global/plugins/bower_components/select2-ng/select2.min.js"></script>

<?php 
	$scripts_ext=ob_get_contents();
	ob_end_clean();

	//Apply the template
	include("tpl_admin.php");
?>