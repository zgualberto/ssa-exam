<template>
    <b-container>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="prefixname">Prefix Name:</label>
            </b-col>
            <b-col md="6">
                <b-form-select id="prefixname" v-model="user.prefixname" :options="options"></b-form-select>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="firstname">First Name:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="firstname" v-model="user.firstname" ></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="middlename">Middle Name:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="middlename" v-model="user.middlename" ></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="lastname">Last Name:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="lastname" v-model="user.lastname" ></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="suffixname">Suffix Name:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="suffixname" v-model="user.suffixname" ></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="username">Username:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="username" v-model="user.username" ></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="email">Email:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="email" type="email" v-model="user.email" ></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="password">New Password:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="password" type="password" v-model="user.password"></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                <label for="password_confirm">Confirm Password:</label>
            </b-col>
            <b-col md="6">
                <b-form-input id="password_confirm" type="password" v-model="user.password_confirm"></b-form-input>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right"></b-col>
            <b-col md="6" class="text-left">
                <b-button variant="primary" @click="updateUser">Update</b-button>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        user: {
            prefixname: null,
            firstname: null,
            middlename: null,
            lastname: null,
            suffixname: null,
            username: null,
            email: null,
            password: null,
            password_confirm: null
        },
        csrf: {
            type: String,
            default: ""
        }
    },
    data() {
        return {
            options: [
                { value: 'Mr', text: 'Mr' },
                { value: 'Mrs', text: 'Mrs' },
                { value: 'Ms', text: 'Ms' },
            ]
        }
    },
    methods: {
        updateUser() {
            console.log('running')
            axios.put(`/api/user/${this.user.id}`, {
                prefixname: this.user.prefixname,
                firstname: this.user.firstname,
                middlename: this.user.middlename,
                lastname: this.user.lastname,
                suffixname: this.user.suffixname,
                username: this.user.username,
                email: this.user.email,
                password: this.user.password,
                password_confirm: this.user.password_confirm,
                _token: document.querySelector("meta[name='csrf-token']").getAttribute('content')
            },
            {
                headers: {
                   'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                }
            })
            .then(({data}) => {
                console.log(data);
            })
            .catch(err => console.log(err));
        }
    },
}
</script>

<style>

</style>
