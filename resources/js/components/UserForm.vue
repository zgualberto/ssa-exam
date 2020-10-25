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
            <b-col md="4" class="text-right">
                <label for="photo">Photo:</label>
            </b-col>
            <b-col md="6">
                <b-form-file
                    id="photo"
                    placeholder="Choose a file or drop it here..."
                    drop-placeholder="Drop file here..."
                    @change="getDataUrl"
                ></b-form-file>
            </b-col>
        </b-row>
        <b-row id="imgHolder" class="d-none">
            <b-col md="4" class="text-right">Image Preview</b-col>
            <b-col md="6">
                <b-img id="imgPrev" rounded="circle" alt="Circle image" width="100" height="100"></b-img>
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right"></b-col>
            <b-col md="6" class="text-left">
                <b-button variant="primary" @click="saveUser">{{ undefined !== user.id ? 'Update' : 'Create' }}</b-button>
            </b-col>
        </b-row>
        <b-modal id="success" title="BootstrapVue">
            <p class="my-4">Successfully updated!</p>
        </b-modal>
        <div>
            <canvas id="image"></canvas>
        </div>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        user: {
            type: Object,
            default: () => {
                return {
                    prefixname: { value: 'Mr', text: 'Mr' },
                    firstname: null,
                    middlename: null,
                    lastname: null,
                    suffixname: null,
                    username: null,
                    email: null,
                    password: null,
                    password_confirm: null,
                    photo: null,
                    photo_filename: null,
                }
            },
            required: false
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
        saveUser() {
            const data = {
                prefixname: this.user.prefixname,
                firstname: this.user.firstname,
                middlename: this.user.middlename,
                lastname: this.user.lastname,
                suffixname: this.user.suffixname,
                email: this.user.email,
                username: this.user.username,
                password: this.user.password,
                password_confirm: this.user.password_confirm,
                photo: this.user.photo,
                photo_filename: this.user.photo_filename,
                _token: document.querySelector("meta[name='csrf-token']").getAttribute('content'),
            }

            if (this.user.id) {
                axios.put(`/api/user/${this.user.id}`, data,
                {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content'),
                    }
                })
                .then(({data}) => {
                    this.$bvModal.show("success")
                })
                .catch(err => console.log(err));
            } else {
                axios.post(`/api/user`, data,
                {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content'),
                    }
                })
                .then(({data}) => {
                    location.href = '/users'
                })
                .catch(err => console.log(err));
            }
        },
        getDataUrl(e) {
            const preview = document.querySelector('#imgPrev');
            const file = e.target.files[0];
            const reader = new FileReader();
            let vm = this;

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                vm.user.photo = reader.result;
                vm.user.photo_filename = file.name;
                document.querySelector("#imgHolder").classList.remove('d-none');
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            } else {
                document.querySelector("#imgHolder").classList.add('d-none');
                this.user.photo = null;
                this.user.photo_filename = null;
            }
        }
    },
}
</script>

<style>
.modal-backdrop
{
    opacity:0.5 !important;
}
</style>
