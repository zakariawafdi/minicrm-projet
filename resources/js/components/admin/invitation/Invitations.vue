<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h4>Invitations</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="inviteEmployee">
          <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" v-model="invitation.name" required>
          </div>

          <div class="form-group">
            <label for="name">Email</label>
            <input type="text" class="form-control" id="name" v-model="invitation.email" required>
          </div>

          <div class="form-group">
            <label for="legal_status">Société</label>
            <select class="form-control" id="company_id" v-model="invitation.company_id" required>
            <option  value="">-- Séléctionnez un Société --</option>
            <option v-for="company in companies" v-bind:key ="company.id" :value="company.id">{{company.name}}</option>
            </select>
        </div>
          <button type="submit" class="btn btn-primary mt-2 mb-3">Inviter</button>
        </form>

        <input type="text" class="search" v-model="searchEmployee" v-on:keypress="filteringInvitations('employee')" placeholder="Chercher un employée...">
        <input type="text" class="search" v-model="searchCompany" v-on:keypress="filteringInvitations('Company')" placeholder="Chercher une société...">

        <table class="table table-bordered table-hover">
            <table-header :sort-order="params.sortOrder" :sort-by="params.sortBy" @sort="onSort">
                <th-column column="company_name">Nom du Société</th-column>
                <th-column column="employee_name">Nom de l'employée</th-column>
                <th-column>Status</th-column>
                <th-column>Action</th-column>
            </table-header>
            <tbody>
                <tr v-for="invitation in filtredInvitations" :key="invitation.id">
                <td>{{ invitation.company }}</td>
                <td>{{ invitation.employee }}</td>
                <td>{{ invitation.status }}</td>
                <td>
                    <button v-if="invitation.status === 'En attente'" class="button-cancel" @click="cancelInvitation(invitation)">Annuler</button>
                </td>
                </tr>
            </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import {TableHeader, TableHeaderColumn as ThColumn} from 'vue-table-sorter';
import 'vue-table-sorter/dist/vue-table-sorter.css';
import api from '../../../http/axios.js';

export default {
  data() {
    return {
      companies: [], // Set the initial value of the companies dropdown
      invitations: [], // Set the initial value of the invitations list

      invitation: {
        email: '',
        name: '',
        company_id:''
      },
      params: {
        sortOrder: 'desc',
        sortBy: 'company_name',
      },
      searchEmployee: '',
      searchCompany: '',
      filtredInvitations: []
    };
  },
  components: {
        TableHeader,
        ThColumn
  },
  methods: {
    inviteEmployee() {
      api.post('/api/admins/invite', this.invitation)
      .then(response => {
        // Redirect to company list page on success
        this.fetchInvitations()
        this.invitation = {
            email: '',
            name: '',
            company_id: ''
        }
      })
      .catch(error => {
        // Handle error response
        console.log(error);
      });
    },
    onSort(params) {
        console.log({params});
        this.params = params;
        this.fetch();
    },
    async fetch() {
        const response = await api.get('/api/admin/invitations', {
            params: this.params
        })
        this.invitations = response.data.invitations;
    },
    fetchCompanies() {
        // make API call to fetch companies data
        api.get('/api/admin/companies')
          .then(response => {
            this.companies = response.data.companies
          })
          .catch(error => {
            console.log(error)
          })
    },
    fetchInvitations() {
        api.get('/api/admin/invitations')
          .then(response => {
            this.invitations = response.data.invitations;
            this.filtredInvitations = response.data.invitations;
          })
          .catch(error => {
            console.log(error)
          })
    },
    cancelInvitation(invitation) {
        // make API call to delete company
        api.delete(`/api/admin/invitations/${invitation.id}`)
          .then(response => {
            // remove company from list
            this.fetchInvitations()
          })
          .catch(error => {
            console.log(error)
          })
    },
    filteringInvitations(isFor) {
        if (isFor === 'company') {
            this.searchEmployee = '';
            this.filtredInvitations = this.invitations.filter(invitation => {
            return invitation.company.toLowerCase().includes(this.searchCompany.toLowerCase())
            })
        } else {
            this.searchCompany = '';
            this.filtredInvitations = this.invitations.filter(invitation => {
            return invitation.employee.toLowerCase().includes(this.searchEmployee.toLowerCase())
            })
        }
        
    },
    
  },
  mounted() {
    // Fetch data and update the values of companies, and invitations
    this.fetchInvitations()
    this.fetchCompanies();
  },
};
</script>

<style>

.search{
    width: 300px;
    padding: 6px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
    margin-left: 8px;
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
  background-color: #333 !important;
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
  margin-right: 8px;
  cursor: pointer;
  border-radius: 4px;
}

.button-cancel {
  background-color: #4e1e1e;
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


