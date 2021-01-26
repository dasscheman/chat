/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data: {
        messages: [],
        privatemessages: [],
        user: [],
        users: [],
        allusers: [],
        dilemmas: [],
        dilemma: [],
        // uitkomsten: []
    },

    created() {
        this.fetchCurrentUser();
        this.fetchMessages();
        this.fetchAllUsers();

        Echo.join('chat')
            .here(users => {
                this.users = users;
                this.users.forEach((user, index) => {
                    this.allusers.forEach((item, index) => {
                        if (item.id === user.id) {
                            item.online = true;
                            this.$set(this.allusers, index, item);
                        }
                    });
                });
            })
            .joining(user => {
                this.allusers.forEach((item, index) => {
                    if (item.id === user.id) {
                        item.online = true;
                        this.$set(this.allusers, index, item);
                    }
                });

                this.users.push(user);
            })
            .leaving(user => {
                // console.log(this.allusers)
                this.users.forEach((user, index) => {
                    this.allusers.forEach((item, index) => {
                        if (item.id === user.id) {
                            item.online = false;
                            this.$set(this.allusers, index, item);
                        }
                    });
                });
                this.users = this.users.filter(u => u.id !== user.id);
            })
            .listenForWhisper('typing', ({id, name}) => {
                this.allusers.forEach((user, index) => {
                    if (user.id === id) {
                        user.typing = true;
                        this.$set(this.allusers, index, user);
                    }
                });
            })
            .listen('MessageSent', (event) => {
                this.messages.push({
                    message: event.message.message,
                    user: event.user
                });

                this.allusers.forEach((user, index) => {
                    if (user.id === event.user.id) {
                        user.typing = false;
                        this.$set(this.allusers, index, user);
                    }
                });
            });
            if (typeof to_user !== 'undefined') {

                this.fetchCurrentUser();
                this.fetchPrivateMessages(to_user)

                this.fetchDilemmas()
                Echo.join('dilemmauitkomst')
                    .listen('UitkomstSent', (event) => {
                        console.log('asdf listen')
                        this.fetchDilemmas();
                      //     fetchDilemmas()
                    });

                var channel_user = userid + '-' + to_user;
                if(userid > to_user) {
                    var channel_user = to_user + '-' + userid;
                }

                console.log(this.user)
                console.log('join invitation.' + channel_user)

                Echo.join('invitation.' + channel_user)
                    .here(users => {
                        this.users = users;
                    })
                    .joining(user => {
                        this.users.push(user);
                    })
                    .leaving(user => {
                        this.users = this.users.filter(u => u.id !== user.id);
                    })
                    .listenForWhisper('typing', ({id, name}) => {

                        this.allusers.forEach((user, index) => {
                            if (user.id === id) {
                                user.typing = true;
                                this.$set(this.allusers, index, user);
                            }
                        });
                    })
                    .listen('PrivateMessageSent', (event) => {
                        console.log('asdf listen')
                        this.privatemessages.push({
                            message: event.message.message,
                            user: event.user,
                            to_user: to_user
                        });
                        this.allusers.forEach((user, index) => {
                            if (user.id === event.user.id) {
                                user.typing = false;
                                this.$set(this.allusers, index, user);
                            }
                        });
                    });
              };

    },
    methods: {
        fetchCurrentUser() {
            axios.get('/user').then(response => {
                this.user = response.data;
            });
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        },

        fetchAllUsers() {
              axios.get('/allusers').then(response => {
                  this.allusers = response.data;
              });
        },

        fetchPrivateMessages(to_user) {
            axios.get('/private/messages/' + to_user).then(response => {
              console.log(response.data)
                this.privatemessages = response.data;
            });
        },

        addPrivateMessage(privatemessage) {
            this.privatemessages.push(privatemessage);
            axios.post('/private/messages', privatemessage).then(response => {
            });
        },

        fetchDilemmas() {
            axios.post('/dilemmas', {'to_user': to_user}).then(response => {
                this.dilemmas = response.data;
                console.log(response.data)
            });
        },
    }
});
