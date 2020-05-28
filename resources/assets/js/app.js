require('./bootstrap');

// window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('categoria', require('./components/Categoria.vue').default);
Vue.component('unidad', require('./components/Unidad.vue').default);
Vue.component('articulo', require('./components/Articulo.vue').default);
Vue.component('cliente', require('./components/Cliente.vue').default);
Vue.component('proveedor', require('./components/Proveedor.vue').default);
Vue.component('rol', require('./components/Rol.vue').default);
Vue.component('user', require('./components/User.vue').default);
// Vue.component('ingreso', require('./components/Ingreso.vue'));
// Vue.component('venta', require('./components/Venta.vue'));
// Vue.component('dashboard', require('./components/Dashboard.vue'));
// Vue.component('consultaingreso', require('./components/ConsultaIngreso.vue'));
// Vue.component('consultaventa', require('./components/ConsultaVenta.vue'));
// Vue.component('ayuda', require('./components/Ayuda.vue'));
// Vue.component('acerca', require('./components/Acerca.vue'));

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        // ruta: 'http://localhost/sistema/public/'
    }
});
