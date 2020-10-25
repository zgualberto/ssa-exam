<template>
    <b-container>
        <div><a href="user/create">Add new user</a></div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Middle</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr style="cursor: pointer;" v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.firstname }}</td>
                    <td>{{ user.lastname }}</td>
                    <td>{{ user.middlename }}</td>
                    <td class="text-center">
                        <a class="btn btn-danger" @click="deleteUser(user)">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        users: {
            type: Array,
            default: () => []
        },
    },
    methods: {
        deleteUser(user) {
            axios.delete(`/api/user/${user.id}`,
            {
                headers: {
                   'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                }
            })
            .then(({data}) => {
                this.users = data;
            })
            .catch(err => console.log(err));
        }
    },
}
</script>

<style>

</style>
