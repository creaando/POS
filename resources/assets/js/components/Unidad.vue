<template>
    <main class="main">
        
        <div class="navbar navbar-light bg-success d-flex justify-content-center">
            <h2 class="text-align-center"> <i class="cil-library"></i> Unidades</h2> 
        </div>


            <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->

        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Unidades
                    <button type="button" class="btn btn-secondary" @click="abrirModal('unidad', 'registrar')">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">

                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="prefijo">Unidad</option>
                                </select>

                                <input type="text" v-model="buscar" @keyup.enter="listarUnidad(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarUnidad(1, buscar, criterio)" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Prefijo</th>
                                <th>Estado</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="unidad in arrayUnidad" :key="unidad.id">
                                <td>
                                    <button type="button" @click="abrirModal('unidad', 'actualizar', unidad)" class="btn btn-warning btn-sm" >
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;


                                    <template v-if="unidad.condicion">
                                        <button type="button" class="btn btn-dark btn-sm" @click="desactivarUnidad(unidad.id)">
                                            <i class="icon-trash" ></i>
                                        </button>
                                    </template>

                                    <template v-else>
                                        <button type="button" class="btn btn-secondary btn-sm" @click="activarUnidad(unidad.id)">
                                            <i class="icon-check" ></i>
                                        </button>
                                    </template>


                                    <!-- <button type="button" class="btn btn-danger btn-sm" >
                                        <i class="icon-trash"></i>
                                    </button> -->

                                </td>
                                <td v-text="unidad.nombre"></td>
                                <td v-text="unidad.prefijo"></td>
                                <td>
                                    <div v-if="unidad.condicion">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">Inactivo</span>
                                    </div>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- paginacion -->
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>

                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']" >
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>

                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- fin paginacion -->

                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de unidad">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Unidad</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="prefijo" class="form-control" placeholder="Ingrese Unidad">
                                </div>
                            </div>

                            <!-- error de validación -->
                            <div v-show="errorUnidad" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjUnidad" :key="error" v-text="error"></div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-dark" @click="registrarUnidad()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-dark" @click="actualizarUnidad()" >Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        
        

    </main>
</template>
<script>
    export default {
        data (){
            return {
                unidad_id            : 0,
                nombre               : '',
                prefijo              : '',
                arrayUnidad          : [],
                modal                : 0,
                tituloModal          : '',
                tipoAccion           : 0,
                errorUnidad          : 0,
                errorMostrarMsjUnidad: [],
                pagination           : {
                    'total'          : 0,
                    'current_page'   : 0,
                    'per_page'       : 0,
                    'last_page'      : 0,
                    'from'           : 0,
                    'to'             : 0,
                },
                offset               : 3,
                criterio             : 'nombre',
                buscar               : ''

            }
        },
        computed:{
            isActived : function(){
                return this.pagination.current_page;
            },
            // calcula los elementos de la paginación
            pagesNumber : function(){
                if (!this.pagination.to) {
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            } 
        },
        methods: {
            listarUnidad(page, buscar, criterio){
                let me  = this;
                var url = '/unidad?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then(function (response) {
                    var respuesta  = response.data;
                    me.arrayUnidad = respuesta.unidades.data;
                    me.pagination  = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me = this;
                // Actualiza la pagina actual
                me.pagination.current_page = page;
                // envia la petición para visualizar la data de esa página
                me.listarUnidad(page, buscar, criterio); 
            },
            registrarUnidad(){
                if (this.validarUnidad()) {
                    return;
                }
                let me       = this;
                axios.post('/unidad/registrar', {
                    'nombre' : this.nombre,
                    'prefijo': this.prefijo
                }).then(function(response){
                    me.cerrarModal();
                    me.listarUnidad(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarUnidad(){
                if (this.validarUnidad()) {
                    return;
                }
                let me = this;
                axios.put('/unidad/actualizar', {
                    'nombre' : this.nombre,
                    'prefijo': this.prefijo,
                    'id'     : this.unidad_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarUnidad(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            desactivarUnidad(id){
                
                swal({
                title             : 'Esta seguro de desactivar esta unidad?',
                type              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Si, desactivar!',
                cancelButtonText  : 'No, Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass : 'btn btn-danger',
                buttonsStyling    : true,
                reverseButtons    : true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/unidad/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUnidad(1, '', 'nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'No se ha desactivado',
                        'La acción fue cancelada',
                        'error'
                    )
                }
                }) 
            },
            activarUnidad(id){
                
                swal({
                title             : 'Esta seguro de activar esta unidad?',
                type              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                confirmButtonText : 'Si, activar!',
                cancelButtonText  : 'No, Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass : 'btn btn-danger',
                buttonsStyling    : true,
                reverseButtons    : true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/unidad/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUnidad(1, '', 'nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'No se ha activado',
                        'La acción fue cancelada',
                        'error'
                    )
                }
                }) 
            },
            validarUnidad(){
                this.errorUnidad           = 0;
                this.errorMostrarMsjUnidad = [];

                if (!this.nombre) this.errorMostrarMsjUnidad.push("El nombre de la unidad no puede estar vacio.");
                if (this.errorMostrarMsjUnidad.length) this.errorUnidad = 1;
                return this.errorUnidad;
            },
            cerrarModal(){
                this.modal       = 0;
                this.tituloModal = '';
                this.nombre      = '';
                this.prefijo = '';
            },
            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case "unidad":{
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal       = 1;
                                    this.tituloModal = 'Registrar unidad';
                                    this.nombre      = '';
                                    this.prefijo = '';
                                    this.tipoAccion  = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    // console.log(data);
                                    this.modal        = 1;
                                    this.tituloModal  = 'Actualizar unidad';
                                    this.tipoAccion   = 2;
                                    this.categoria_id = data['id'];
                                    this.nombre       = data['nombre'];
                                    this.prefijo  = data['prefijo'];
                                    break;
                                }
                        }
                    }
                }
            }
        },
        mounted(){
            this.listarUnidad(1, this.buscar, this.criterio);
            // console.log('component mounted')
        }
    }
</script>
<style>
    .modal-content{
        width           : 100% !important;
        position        : absolute !important;
    }
    .mostrar{
        display         : list-item !important;
        opacity         : 1 !important;
        position        : absolute !important;
        background-color: #121214af !important;
    }
    .div-error{
        display         : flex;
        justify-content : center;
    }
    .text-error{
        color           : red !important;
        font-weight     : bold;
    }
</style>