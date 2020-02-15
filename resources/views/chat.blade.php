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
                <!-- <div class="card-header">Online</div>
                <ul class="list-group">
                    <li class="list-group-item"  v-for="user in allusers">

                        <a :href="'private/' + user.id" v-if="user.id!={{ auth()->user()->id }}">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </a>
                        <div v-if="user.id=={{ auth()->user()->id }}">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </div>

                    </li>
                </ul>
                <br> -->
                <div class="card-header">All users</div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="user in allusers">
                        <a :href="'private/' + user.id" v-if="user.id!={{ auth()->user()->id }}">
                            @{{ user.name }}
                            <span v-if="user.typing" class="badge badge-primary">typing...</span>
                            <span v-if="user.online" class="badge badge-success">online...</span>
                        </a>
                        <div v-if="user.id=={{ auth()->user()->id }}">
                            @{{ user.name }}
                        </div>
                    </li>
                </ul>
                <br>
            </div>
        </div>
    </div>
@endsection
