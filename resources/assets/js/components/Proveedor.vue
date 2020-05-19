<template>
    <main class="main">
        
        <div class="navbar navbar-light bg-success d-flex justify-content-center">
            <h2 class="text-align-center"> <i class="cil-library"></i> Proveedores</h2> 
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
                    <i class="fa fa-align-justify"></i> Proveedores
                    <button type="button" class="btn btn-secondary" @click="abrirModal('persona', 'registrar')">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">

                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value = "nombre">Nombre</option>
                                    <option value = "documento">Documento</option>
                                    <option value = "ciudad">Ciudad</option>
                                    <option value = "ciudad">Telefono</option>
                                </select>

                                <input type="text" v-model="buscar" @keyup.enter="listarPersona(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarPersona(1, buscar, criterio)" class="btn btn-dark"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo de Documento</th>
                                <th>Número de documento</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Notas</th>
                                <th>Nombre de Contacto</th>
                                <th>Telefono de Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="persona in arrayPersona" :key="persona.id">
                                <td>
                                    <button type="button" @click="abrirModal('persona', 'actualizar', persona)" class="btn btn-warning btn-sm" >
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;

                                </td>
                                <td v-text="persona.nombre"></td>
                                <td v-text="persona.tipo_documento"></td>
                                <td v-text="persona.num_documento"></td>
                                <td v-text="persona.direccion"></td>
                                <td v-text="persona.ciudad"></td>
                                <td v-text="persona.telefono"></td>
                                <td v-text="persona.email"></td>
                                <td v-text="persona.nota"></td>
                                <td v-text="persona.contacto"></td>
                                <td v-text="persona.telefono_contacto"></td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Razón Social</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre o Razon Social">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo De Documento</label>
                                <div class="col-md-9">
                                    <select v-model="tipo_documento" class="form-control">
                                        <option value="CC">CC</option>
                                        <option value="CE">CE</option>
                                        <option value="TI">TI</option>
                                        <option value="PA">PA</option>
                                        <option value="NIT">NIT</option>
                                    </select>
                                    <!-- <input type="text" v-model="tipo_documento" class="form-control"> -->
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Numero De Documento</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="num_documento" class="form-control" placeholder="Ingrese el número de identificación">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la dirección">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Ciudad</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ciudad" class="form-control" placeholder="Ciudad de residencia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Numero de teléfono">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="ingrese el correo electrónico">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="nota-input">Notas</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nota" class="form-control" placeholder="Notas relacionadas con el proveedor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="contacto-input">Nombre del Contacto</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="contacto" class="form-control" placeholder="Ingrese el nombre del contacto">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="telContacto-input">Numero de Teléfono del Contacto</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono_contacto" class="form-control" placeholder="Ingrese el numero Telefónico">
                                </div>
                            </div>

                            <!-- error de validación -->
                            <div v-show="errorPersona" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error"></div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-dark" @click="registrarPersona()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-dark" @click="actualizarPersona()" >Actualizar</button>
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
                persona_id            : 0,
                nombre                : '',
                tipo_documento        : 'CC',
                num_documento         : '',
                direccion             : '',
                ciudad                : '',
                telefono              : '',
                email                 : '',
                nota                  : '',
                contacto              : '',
                telefono_contacto     : '',
                arrayPersona          : [],
                modal                 : 0,
                tituloModal           : '',
                tipoAccion            : 0,
                errorPersona          : 0,
                errorMostrarMsjPersona: [],
                pagination            : {
                    'total'           : 0,
                    'current_page'    : 0,
                    'per_page'        : 0,
                    'last_page'       : 0,
                    'from'            : 0,
                    'to'              : 0,
                },
                offset                : 3,
                criterio              : 'nombre',
                buscar                : ''

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
            listarPersona(page, buscar, criterio){
                let me              = this;
                var url             = '/proveedor?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then(function (response) {
                    var respuesta   = response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination   = respuesta.pagination;
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
                me.listarPersona(page, buscar, criterio); 
            },
            registrarPersona(){
                if (this.validarPersona()) {
                    return;
                }
                let me       = this;
                axios.post('/proveedor/registrar', {
                    'nombre'           : this.nombre,
                    'tipo_documento'   : this.tipo_documento,
                    'num_documento'    : this.num_documento,
                    'direccion'        : this.direccion,
                    'ciudad'           : this.ciudad,
                    'telefono'         : this.telefono,
                    'email'            : this.email,
                    'nota'             : this.nota,
                    'contacto'         : this.contacto,
                    'telefono_contacto': this.telefono_contacto,
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPersona(){
                if (this.validarPersona()) {
                    return;
                }
                let me = this;
                axios.put('/proveedor/actualizar', {
                    'nombre'           : this.nombre,
                    'tipo_documento'   : this.tipo_documento,
                    'num_documento'    : this.num_documento,
                    'direccion'        : this.direccion,
                    'ciudad'           : this.ciudad,
                    'telefono'         : this.telefono,
                    'email'            : this.email,
                    'nota'             : this.nota,
                    'contacto'         : this.contacto,
                    'telefono_contacto': this.telefono_contacto,
                    'id'               : this.persona_id
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1, '', 'nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarPersona(){
                this.errorPersona           = 0;
                this.errorMostrarMsjPersona = [];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre del proveedor no puede estar vacio.");
                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
                return this.errorPersona;
            },
            cerrarModal(){
                this.modal             = 0;
                this.tituloModal       = '';
                this.nombre            = '';
                this.tipo_documento    = 'NIT';
                this.num_documento     = '';
                this.direccion         = '';
                this.ciudad            = '';
                this.telefono          = '';
                this.email             = '';
                this.nota              = '';
                this.contacto          = '';
                this.telefono_contacto = '';
                this.errorPersona      = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch (modelo) {
                    case "persona":{
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal             = 1;
                                    this.tituloModal       = 'Registrar proveedor';
                                    this.tipoAccion        = 1;
                                    this.nombre            = '';
                                    this.tipo_documento    = 'NIT';
                                    this.num_documento     = '';
                                    this.direccion         = '';
                                    this.ciudad            = '';
                                    this.telefono          = '';
                                    this.email             = '';
                                    this.nota              = '';
                                    this.contacto          = '';
                                    this.telefono_contacto = '';
                                    break;
                                }
                            case 'actualizar':
                                {
                                    // console.log(data);
                                    this.modal             = 1;
                                    this.tituloModal       = 'Actualizar proveedor';
                                    this.tipoAccion        = 2;
                                    this.persona_id        = data['id'];
                                    this.nombre            = data['nombre'];
                                    this.tipo_documento    = data['tipo_documento'];
                                    this.num_documento     = data['num_documento'];
                                    this.direccion         = data['direccion'];
                                    this.ciudad            = data['ciudad'];
                                    this.telefono          = data['telefono'];
                                    this.email             = data['email'];
                                    this.nota              = data['nota'];
                                    this.contacto          = data['contacto'];
                                    this.telefono_contacto = data['telefono_contacto'];
                                    break;
                                }
                        }
                    }
                }
            }
        },
        mounted(){
            this.listarPersona(1, this.buscar, this.criterio);
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