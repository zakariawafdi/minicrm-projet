<template>
  <div class="admins-list">
    <h2>Admins</h2>
    <v-btn class="mb-2 button-add" color="primary" @click="createAdmin">Nouveau admin</v-btn>

    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="admin in admins" :key="admin.id">
          <td>{{ admin.name }}</td>
          <td>{{ admin.email }}</td>
          <td>
            <button class="button-update" @click="updateAdmin(admin)">Modifer</button>
            <button class="button-delete" @click="deleteAdmin(admin)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
// import axios from 'axios';

import api from '../../http/axios.js';

  export default {
    data() {
      return {
        admins: []
      }
    },
    methods: {
      fetchAdmins() {
        // make API call to fetch admins data
        api.get('/api/admins')
          .then(response => {
            this.admins = response.data.admins
          })
          .catch(error => {
            console.log(error)
          })
      },
      createAdmin() {
        this.$router.push('/admin/new')
      },
      updateAdmin(admin) {
        // navigate to edit company page with company id
        this.$router.push(`/admin/update/${admin.id}`)
      },
      deleteAdmin(admin) {
        // make API call to delete company
        api.delete(`/api/admins/${admin.id}`)
          .then(response => {
            // remove company from list
            this.fetchAdmins()
          })
          .catch(error => {
            console.log(error)
          })
      }
    },
    mounted() {
      this.fetchAdmins()
    }
  }
</script>


<style>
.admins-list {
  max-width: 800px;
  margin: 0 auto;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

th {
  background-color: #333;
  color: white;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #ddd;
}

.button-add {
  background-color: #333;
  color: white;
  border: none;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-right: 8px;
  cursor: pointer;
  border-radius: 4px;
  float: right;
}


.button-update {
  background-color: #333;
  color: white;
  border: none;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-right: 8px;
  cursor: pointer;
  border-radius: 4px;
}

.button-delete {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  border-radius: 4px;
}
</style>
