<template>
    <div>
        <beautiful-chat
                :participants="participants"
                :titleImageUrl="titleImageUrl"
                :onMessageWasSent="onMessageWasSent"
                :messageList="messageList"
                :newMessagesCount="newMessagesCount"
                :isOpen="isChatOpen"
                :close="closeChat"
                :open="openChat"
                :showEmoji="false"
                :showFile="false"
                :showTypingIndicator="showTypingIndicator"
                :colors="colors"
                :alwaysScrollToBottom="alwaysScrollToBottom"
                :messageStyling="messageStyling"
                placeholder="Escriba un mensaje.."
                title="Chullita"/>
    </div>
</template>

<script>
    import Chat from 'vue-beautiful-chat';
    Vue.use(Chat);
    export default {
        name: "chat",
        data() {
            return {
                participants: [
                    {
                        id: 'user1',
                        name: 'Chulla',
                        imageUrl: 'https://pbs.twimg.com/media/Dn3cfwLX0AI4Pm5.jpg:large'
                    }
                ],
                titleImageUrl: "https://emojipedia-us.s3.dualstack.us-west-1.amazonaws.com/thumbs/240/whatsapp/169/bearded-person_1f9d4.png",
                messageList: [],
                newMessagesCount: 0,
                isChatOpen: false,
                showTypingIndicator: '',
                colors: {
                    header: {
                        bg: '#8e416e',
                        text: '#ffffff'
                    },
                    launcher: {
                        bg: '#8e416e'
                    },
                    messageList: {
                        bg: '#ffffff'
                    },
                    sentMessage: {
                        bg: '#8e416e',
                        text: '#ffffff'
                    },
                    receivedMessage: {
                        bg: '#eaeaea',
                        text: '#222222'
                    },
                    userInput: {
                        bg: '#f4f7f9',
                        text: '#565867'
                    }
                },
                alwaysScrollToBottom: false,
                messageStyling: true
            }
        },
        methods: {
            sendMessage (text) {
                if (text.length > 0) {
                    this.newMessagesCount = this.isChatOpen ? this.newMessagesCount : this.newMessagesCount + 1
                    this.onMessageWasSent({ author: 'support', type: 'text', data: { text } })
                }
            },
            /**
             * Recibe el objeto mensaje enviado por el usuario actual al backend
             * al momento de enviar setea escribiendo
             * y al recibir la respuesta quita el escribiendo y agrega la respuesta al array de mensajes
             * **/
            onMessageWasSent (message) {
                this.messageList = [...this.messageList, message ];
                let vm=this;
                vm.showTypingIndicator="escribiendo";
                axios({
                    method: 'POST',
                    url: location.origin+'/chat',
                    params:{
                        'q':message.data.text,
                    }
                }).then((response) => {
                    vm.showTypingIndicator="";
                    vm.newMessagesCount=1;
                    this.messageList = [...this.messageList, { type: 'text', author: `user1`, data: { text: response.data.response }} ];
                });
            },
            openChat () {
                this.isChatOpen = true;
                this.newMessagesCount = 0;
            },
            closeChat () {
                this.isChatOpen = false
            }
        }
    }
</script>

<style scoped>

</style>