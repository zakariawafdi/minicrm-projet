<template>
  <div class="companies-list">
    <h2>Sociétés</h2>
    <v-btn class="mb-2 button-add" color="primary" @click="createCompany">Nouvelle Société</v-btn>

    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Adresse</th>
          <th>Téléphone</th>
          <th>Statut légale</th>
          <th>Capitale</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="company in companies" :key="company.id">
          <td>{{ company.name }}</td>
          <td>{{ company.address }}</td>
          <td>{{ company.phone_number }}</td>
          <td>{{ company.legal_status }}</td>
          <td>{{ company.capital }}</td>
          <td>
            <button class="button-update" @click="updateCompany(company)">Modifer</button>
            <button :class="{ 'disabled': hasEmployees(company) }" :disabled="hasEmployees(company)" class="button-delete" @click="deleteCompany(company)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
// import axios from 'axios';

import api from '../../../http/axios.js';

  export default {
    data() {
      return {
        companies: []
      }
    },
    methods: {
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
      hasEmployees(company) {
         return company.employee_count == 0? false: true
      },
      createCompany() {
        this.$router.push('/admin/company/create')
      },
      updateCompany(company) {
        // navigate to edit company page with company id
        this.$router.push(`/admin/company/update/${company.id}`)
      },
      deleteCompany(company) {
        // make API call to delete company
        api.delete(`/api/admin/companies/${company.id}`)
          .then(response => {
            // remove company from list
            this.fetchCompanies()
          })
          .catch(error => {
            console.log(error)
          })
      }
    },
    mounted() {
      this.fetchCompanies()
    }
  }
</script>


<style>
.companies-list {
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

.disabled {
  background-color: #D3D3D3 !important;
}

</style>
