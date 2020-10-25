<template>
    <b-container>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Prefix Name:
            </b-col>
            <b-col md="6">
                {{ user.prefixname }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                First Name:
            </b-col>
            <b-col md="6">
                {{ user.firstname }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Middle Name:
            </b-col>
            <b-col md="6">
                {{ user.middlename }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Last Name:
            </b-col>
            <b-col md="6">
                {{ user.lastname }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Suffix Name:
            </b-col>
            <b-col md="6">
                {{ user.suffixname }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Username:
            </b-col>
            <b-col md="6">
                {{ user.username }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Email:
            </b-col>
            <b-col md="6">
                {{ user.email }}
            </b-col>
        </b-row>
        <b-row align-v="center" class="p-2">
            <b-col md="4" class="text-right">
                Avatar:
            </b-col>
            <b-col md="6">
                <b-img id="imgPrev" :src="'/avatar/' + user.photo" rounded="circle" alt="Circle image" width="100" height="100"></b-img>
            </b-col>
        </b-row>
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
                    prefixname: null,
                    firstname: null,
                    middlename: null,
                    lastname: null,
                    suffixname: null,
                    username: null,
                    email: null,
                    password: null,
                    password_confirm: null,
                }
            },
            required: false
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
