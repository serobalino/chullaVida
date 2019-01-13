<template>
    <div class="fondo" :style="'background-color:'+fondo ">
        <div class="cosas">
            <div class="text-center">
                <h1 :style="'color:'+texto">{{mensaje}}</h1>
            </div>

                <div class="text-center">
                    <br><br><br><br><br>
                    <button class="btn btn-primary" v-on:click="consultar">Siguiente</button>
                    <button class="btn btn-danger" v-on:click="finalizar">Finalizar</button>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "reglas",
        data:()=>({
            fondo:null,
            texto:null,
            mensaje:null,
        }),
        methods:{
            consultar:function(){
                axios({
                    method: 'GET',
                    url: location.origin+'/regla',
                }).then((response) => {
                    if(response.data.val){
                        this.mensaje=response.data.regla.instruccion_re;
                    }else{
                        this.mensaje=response.data.mensaje;
                    }
                }).catch((error) => {
                    console.log(error);
                });
                this.color();
            },
            finalizar:function(){
                axios({
                    method: 'DELETE',
                    url: location.origin+'/regla',
                }).then((response) => {
                    if(response.data.val){
                        location.href=response.data.ruta;
                    }else{
                        this.mensaje=response.data.mensaje;
                    }
                }).catch((error) => {
                    console.log(error);
                });
            },
            color:function(){
                //funcion copiada de internet para generar el fono
                let letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++)
                    color += letters[Math.floor(Math.random() * 16)];
                this.fondo=color;

                //funcion copiada de internet para saber si el fondo es oscuro o claro para determinar el color de las letras
                let r, g, b, hsp;
                if (color.match(/^rgb/)) {
                    color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);
                    r = color[1];
                    g = color[2];
                    b = color[3];
                } else {
                    color = +("0x" + color.slice(1).replace(color.length < 5 && /./g, '$&$&'));
                    r = color >> 16;
                    g = color >> 8 & 255;
                    b = color & 255;
                }
                hsp = Math.sqrt(
                    0.299 * (r * r) +
                    0.587 * (g * g) +
                    0.114 * (b * b)
                );
                if (hsp>127.5)
                    this.texto='black';
                else
                    this.texto='white';

            }
        },
        mounted(){
            this.consultar();
        }
    }
</script>

<style>
    .fondo {
        min-height: 500px;
        width: 100%;
        height: 500px;
        margin: 0 auto -20px;
        display: table;
    }
    .cosas{
        display: table-cell;
        vertical-align: middle;
    }
</style>