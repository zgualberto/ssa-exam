<template>
    <b-container>
        <b-table-simple class="table table-bordered table-striped table-hover">
            <b-thead>
            <b-tr>
                <b-th scope="col">#</b-th>
                <b-th scope="col">First</b-th>
                <b-th scope="col">Last</b-th>
                <b-th scope="col">Middle</b-th>
                <b-th scope="col">Username</b-th>
                <b-th scope="col">Email</b-th>
                <b-th scope="col" class="text-center">Actions</b-th>
            </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr v-for="user in usersObj" :key="user.id" :user="user">
                    <b-td style="cursor: pointer;">{{ user.id }}</b-td>
                    <b-td>{{ user.firstname }}</b-td>
                    <b-td>{{ user.lastname }}</b-td>
                    <b-td>{{ user.middlename }}</b-td>
                    <b-td>{{ user.username }}</b-td>
                    <b-td>{{ user.email }}</b-td>
                    <b-td class="text-center">
                        <b-button data-action="show" class="d-none" title="Show" variant="outline-info" :href="'/user/show/' + user.id"><b-icon-info-circle-fill /></b-button>
                        <b-button data-action="edit" class="d-none" title="Edit" variant="outline-primary" :href="'/user/edit/' + user.id"><b-icon-pen-fill /></b-button>
                        <b-button data-action="delete" class="d-none" title="Delete" variant="outline-danger" @click="deleteUser(user)"><b-icon-trash /></b-button>
                        <b-button data-action="restore" class="d-none" title="Restore" variant="outline-info" @click="restoreUser(user)"><b-icon-arrow-counterclockwise /></b-button>
                        <b-button data-action="force-delete" class="d-none" title="Force Delete" variant="outline-dark" @click="forceDeleteUser(user)"><b-icon-trash-fill /></b-button>
                    </b-td>
                </b-tr>
            </b-tbody>
        </b-table-simple>
        <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="limit"
            first-number
            @change="updateData($event)"
        ></b-pagination>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        users: {
            type: Object,
            default: () => {}
        },
        actions: {
            type: Array,
            default: () => []
        },
        count: {
            type: Number,
            default: 0
        },
        limit: {
            type: Number,
            default: 0
        },
        page: {
            type: Number,
            default: 0
        },
    },
    data() {
        return {
            usersObj: [],
            currentPage: this.page,
            totalRows: this.count
        }
    },
    mounted() {
        this.usersObj = this.users.data
    },
    updated() {
        this.actions.forEach((action) => {
            document.querySelectorAll(`[data-action='${action}']`).forEach(el => {
                el.classList.remove('d-none');
            });
        });
    },
    methods: {
        restoreUser(user) {
            axios.patch(`/api/user/${user.id}`,
            {
                headers: {
                   'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                }
            })
            .then(({data}) => {
                this.usersObj = data.data;
                this.totalRows -= 1;
            })
            .catch(err => console.log(err));
        },
        deleteUser(user) {
            axios.delete(`/api/user/${user.id}`,
            {
                headers: {
                   'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                }
            })
            .then(({data}) => {
                this.usersObj = data.data;
                this.totalRows -= 1;
            })
            .catch(err => console.log(err));
        },
        forceDeleteUser(user) {
            axios.delete(`/api/user/force-delete/${user.id}`,
            {
                headers: {
                   'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                }
            })
            .then(({data}) => {
                this.usersObj = data.data;
                this.totalRows -= 1;
            })
            .catch(err => console.log(err));
        },
        updateData(e) {
            location.href = `?page=${e}`;
        }
    },
}
</script>

<style>

</style>
