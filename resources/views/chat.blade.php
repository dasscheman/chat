@extends('layouts.app')

@section('content')

    <div class="container chats">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-header">Chats</div>

                    <div class="card-body">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="card-footer">
                        <chat-form
                                @messagesent="addMessage"
                                :user="{{ auth()->user() }}"
                        ></chat-form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-header">Online</div>
                <ul class="list-group">
                    <li class="list-group-item"  v-for="user in users">

                        <a :href="'/' + user.id" v-if="user.name=='test'">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </a>
                        <div v-if="user.name!='test'">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </div>

                    </li>
                </ul>
                <br>
                <div class="card-header">Conversations</div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="user in conversationusers">
                        <a :href="'/' + user.id">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </a>
                    </li>
                </ul>
                <br>
                <div class="card-header">Nieuwe Dilemma's</div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="dilemma in dilemmas">
                        @{{ dilemma.naam }}
                        @{{ dilemma.status}}
                    </li>
                </ul>
                <br>
                <div class="card-header">Afgeronde Dilemma's</div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="dilemma in uitkomsten">
                        @{{ dilemma.dilemma.naam }}
                        <span v-if="dilemma.user_2_status==null" class="badge badge-primary">Wacht op reactie</span>
                        <span v-else>Afgerond </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
