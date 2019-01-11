<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Juegos <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#nuevo" type="button">+</button>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start" v-for="item in jugados">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Juego A</h5>
                                <small>{{item.created_at}}</small>
                            </div>
                            <p class="mb-1"><span v-for="nom in item.jugadores">{{nom.nombre_pa}}, </span> </p>
                            <small>{{item.estado_ju ? 'Activo' : 'Desactivado'}}</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-danger" v-if="jugados.length===0">No existen Juegos Previos</a>
                    </div>
                </div>
                <div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Nuevo Juego </h5>
                                <button class="btn btn-outline-success btn-sm" type="button" v-on:click="agregar">+</button>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div v-if="paso===1">
                                <div class="modal-body">
                                    <form action="">
                                        <div class="input-group mb-3" v-for="(item,index) in nombres">
                                            <input type="text" class="form-control" :placeholder="'Nombre J'+(index+1)" v-model="item.nombre"/>
                                            <div class="input-group-append" v-if="index!==0">
                                                <button class="btn btn-outline-danger" type="button" v-on:click="quitar(index)">X</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" v-on:click="paso=2">Siguiente</button>
                                </div>
                            </div>
                            <div v-if="paso===2">
                                <div class="modal-body">
                                    <div>
                                        {{tipo}}
                                    </div>
                                    <div class="form-check" v-for="item in tipos">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="juego" :value="item" v-model="tipo"><span :class="item.icono_ti"></span>{{item.titulo_ti}}
                                        </label>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" v-on:click="crearJuego">Jugar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "juegos",
        data:()=>({
            jugados:[],
            nombres:[],
            tipos:[],
            paso:1,
            tipo:{},
        }),
        methods:{
            cargarJuegos:function(){
                axios({
                    method: 'OPTIONS',
                    url: location.origin+location.pathname,
                }).then((response) => {
                    this.jugados=response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            crearJuego:function(){
                axios({
                    method: 'POST',
                    url: location.origin+location.pathname,
                    data:{
                        jugadores:this.nombres,
                        tipo:this.tipo.id_ti
                    }
                }).then((response) => {
                    this.cargarJuegos();
                    if(response.data.val)
                        location.href=response.data.ruta;
                });
            },
            cargarTipos:function(){
                axios({
                    method: 'GET',
                    url: location.origin+'/api/juegos',
                }).then((response) => {
                    this.tipos=response.data;
                });
            },
            agregar:function(){
                let a = new Object();
                this.nombres.push(a);
            },
            quitar:function(num){
                this.nombres.splice(num, 1);
            },


        },
        mounted(){
            this.cargarTipos();
            this.cargarJuegos();
            this.agregar();
        }
    }
</script>

<style scoped>

</style>