<template>
    <main class="main">

        <div class="navbar navbar-light bg-success d-flex justify-content-center">
            <h2 class="text-align-center"> <i class="cil-library"></i> Artículos</h2>
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
                    <i class="fa fa-align-justify"></i> Artículos
                    <button type="button" class="btn btn-secondary" @click="abrirModal('articulo', 'registrar')">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">

                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="descripcion">Descripción</option>
                                </select>

                                <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarArticulo(1, buscar, criterio)" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Código de barras</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Unidad</th>
                                <th>Precio de compra</th>
                                <th>Precio de venta</th>
                                <th>Stcok</th>
                                <th>Stcok mínimo</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                <td>
                                    <button type="button" @click="abrirModal('articulo', 'actualizar', articulo)" class="btn btn-warning btn-sm" >
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;


                                    <template v-if="articulo.condicion">
                                        <button type="button" class="btn btn-dark btn-sm" @click="desactivarCategoria(articulo.id)">
                                            <i class="icon-trash" ></i>
                                        </button>
                                    </template>

                                    <template v-else>
                                        <button type="button" class="btn btn-secondary btn-sm" @click="activarCategoria(articulo.id)">
                                            <i class="icon-check" ></i>
                                        </button>
                                    </template>


                                    <!-- <button type="button" class="btn btn-danger btn-sm" >
                                        <i class="icon-trash"></i>
                                    </button> -->

                                </td>
                                <td v-text="articulo.codigo"></td>
                                <td v-text="articulo.nombre"></td>
                                <td v-text="articulo.nombre_categoria"></td>
                                <td v-text="articulo.nombre_unidad"></td>
                                <td v-text="articulo.precio_compra"></td>
                                <td v-text="articulo.precio_venta"></td>
                                <td v-text="articulo.stock"></td>
                                <td v-text="articulo.stock_minimo"></td>
                                <td v-text="articulo.descripcion"></td>
                                <td>
                                    <div v-if="articulo.condicion">
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
                                <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                <div class="col-md-9">
                                    <select v-model="categoria_id" class="form-control">
                                        <option value="0">Seleccione</option>
                                        <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre" ></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Artículo">

                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="codigo" class="form-control" placeholder="Codigo de barras">
                                    <barcode :value="codigo" :options="{format: 'EAN-13'}">
                                        Generando código de barras
                                    </barcode>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Unidad de venta</label>
                                <div class="col-md-9">
                                    <select v-model="unidad_id" class="form-control">
                                        <option value="0">Seleccione</option>
                                        <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id" v-text="unidad.nombre" ></option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio de compra</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="precio_compra" class="form-control" placeholder="">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Precio de venta</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="precio_venta" class="form-control" placeholder="">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="stock" class="form-control" placeholder="">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Stock mínimo</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="stock_minimo" class="form-control" placeholder="">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                </div>
                            </div>

                            <!-- error de validación -->
                            <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error"></div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-dark" @click="registrarArticulo()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-dark" @click="actualizarArticulo()" >Actualizar</button>
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
    import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                articulo_id            : 0,
                categoria_id           : 0,
                codigo                 : '',
                nombre                 : '',
                unidad_id              : 0,
                precio_compra          : 0,
                precio_venta           : 0,
                stock                  : 0,
                stock_minimo           : 0,
                descripcion            : '',
                arrayArticulo          : [],
                modal                  : 0,
                tituloModal            : '',
                tipoAccion             : 0,
                errorArticulo          : 0,
                errorMostrarMsjArticulo: [],
                pagination             : {
                    'total'            : 0,
                    'current_page'     : 0,
                    'per_page'         : 0,
                    'last_page'        : 0,
                    'from'             : 0,
                    'to'               : 0,
                },
                offset                 : 3,
                criterio               : 'nombre',
                buscar                 : '',
                arrayCategoria         : [],
                arrayUnidad            : []

            }
        },
        components: {
            'barcode': VueBarcode
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
            listarArticulo(page, buscar, criterio){
                let me  = this;
                var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then(function (response) {
                    var respuesta    = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination    = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            selectCategoria(){
                let me  = this;
                var url = '/categoria/selectCategoria';

                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta     = response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
            selectUnidad(){
                let me  = this;
                var url = '/unidad/selectUnidad';

                axios.get(url).then(function (response) {
                    // console.log(response);
                    var respuesta     = response.data;
                    me.arrayUnidad = respuesta.unidades;
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
                me.listarArticulo(page, buscar, criterio);
            },
            registrarArticulo(){
                if (this.validarArticulo()) {
                    return;
                }
                let me           = this;
                axios.post('/articulo/registrar', {

                    'categoria_id'    : this.categoria_id,
                    'codigo'          : this.codigo,
                    'nombre'          : this.nombre,
                    'unidad_id'       : this.unidad_id,
                    'precio_compra'   : this.precio_compra,
                    'precio_venta'    : this.precio_venta,
                    'stock'           : this.stock,
                    'stock_minimo'    : this.stock_minimo,
                    'descripcion'     : this.descripcion

                }).then(function(response){
                    me.cerrarModal();
                    me.listarArticulo(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarArticulo(){
                if (this.validarArticulo()) {
                    return;
                }
                let me = this;
                axios.put('/articulo/actualizar', {
                    'categoria_id'    : this.categoria_id,
                    'codigo'          : this.codigo,
                    'nombre'          : this.nombre,
                    'unidad_id'       : this.unidad_id,
                    'precio_compra'   : this.precio_compra,
                    'precio_venta'    : this.precio_venta,
                    'stock'           : this.stock,
                    'stock_minimo'    : this.stock_minimo,
                    'descripcion'     : this.descripcion,
                    'id'              : this.articulo_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarArticulo(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            desactivarCategoria(id){

                swal({
                title             : 'Esta seguro de desactivar este artículo?',
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

                    axios.put('/articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1, '', 'nombre');
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
            activarCategoria(id){

                swal({
                title             : 'Esta seguro de activar este artículo?',
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

                    axios.put('/articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1, '', 'nombre');
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
            validarArticulo(){
                this.errorArticulo           = 0;
                this.errorMostrarMsjArticulo = [];

                if (this.categoria_id==0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if (this.unidad_id==0) this.errorMostrarMsjArticulo.push("Seleccione una unidad de venta.");
                if (!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
                if (!this.stock) this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número y no debe estar vacío.");
                if (!this.precio_venta) this.errorMostrarMsjArticulo.push("El precio de venta del artículo debe ser un número y no debe estar vacío.");

                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal            = 0;
                this.tituloModal      = '';
                this.categoria_id     = 0;
                this.codigo           = '';
                this.nombre           = '';
                this.unidad_id        = 0;
                this.precio_compra    = 0;
                this.precio_venta     = 0;
                this.stock            = 0;
                this.stock_minimo     = 0;
                this.descripcion      = '';
                this.errorArticulo    = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case "articulo":{
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal            = 1;
                                    this.tituloModal      = 'Registrar articulo';
                                    this.categoria_id     = 0;
                                    this.codigo           = '';
                                    this.nombre           = '';
                                    this.unidad_id        = 0;
                                    this.precio_compra    = 0;
                                    this.precio_venta     = 0;
                                    this.stock            = 0;
                                    this.stock_minimo     = 0;
                                    this.descripcion      = '';
                                    this.tipoAccion       = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    // console.log(data);
                                    this.modal            = 1;
                                    this.tituloModal      = 'Actualizar articulo';
                                    this.tipoAccion       = 2;
                                    this.articulo_id      = data['id'];
                                    this.categoria_id     = data['categoria_id'];
                                    this.codigo           = data['codigo'];
                                    this.nombre           = data['nombre'];
                                    this.unidad_id        = data['unidadmedida_id'];
                                    this.precio_compra    = data['precio_compra'];
                                    this.precio_venta     = data['precio_venta'];
                                    this.stock            = data['stock'];
                                    this.stock_minimo     = data['stock_minimo'];
                                    this.descripcion      = data['descripcion'];
                                    break;
                                }
                        }
                    }
                }
                this.selectCategoria();
                this.selectUnidad();
            }
        },
        mounted(){
            this.listarArticulo(1, this.buscar, this.criterio);
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
