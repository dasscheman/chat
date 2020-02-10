<template>
    <div class="input-group">
        <input
                id="btn-input"
                type="text"
                name="message"
                class="form-control input-sm"
                placeholder="Type your message here..."
                v-model="newPrivateMessage"
                @keyup.enter="sendPrivateMessage"
                @keyup="sendTypingEvent">

        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendPrivateMessage">
                Send
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                newPrivateMessage: ''
            }
        },

        methods: {
            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            },
            sendPrivateMessage() {
                this.$emit('privatemessagesent', {
                    user: this.user,
                    message: this.newPrivateMessage,
                    to_user: to_user
                });

                this.newPrivateMessage = ''
            }
        }
    }
</script>
